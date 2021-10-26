<?php

namespace App\Scripts;

use App\Client;
use App\Item;
use App\Order;
use Error;
use Illuminate\Support\Facades\Http;

class SalesScript
{

    protected $headers = [];
    protected $account;

    public function __construct()
    {
        $this->headers['X-VTEX-API-AppKey'] = env('API_KEY');
        $this->headers['X-VTEX-API-AppToken'] = env('API_TOKEN');
        $this->account = env('ACCOUNT_NAME');
    }

    public function getOrder($order)
    {
        $response = Http::withHeaders($this->headers)->get('https://' . $this->account . '.vtexcommercestable.com.br/api/oms/pvt/orders/' . $order);
        $data = json_decode($response->body());


        if (Order::where('order_id', $data->orderId)->count() == 0) {
            $client = Client::create([
                'first_name' => $data->clientProfileData->firstName,
                'last_name' => $data->clientProfileData->lastName,
                'email' => $data->clientProfileData->email
            ]);

            $order = Order::create([
                'order_id' => $data->orderId,
                'payment_method_id' => $data->paymentData->transactions[0]->payments[0]->paymentSystem,
                'total_amount' => $data->value,
                'client_id' => $client->id
            ]);

            foreach ($data->items as $item) {
                Item::create([
                    'ref_id' => $item->refId,
                    'product_id' => $item->productId,
                    'name' => $item->name,
                    'quantity' => $item->quantity,
                    'order_id' => $order->id
                ]);
            }
        }

        return 0;
    }

    public function getOrdersList($year)
    {

        $response = Http::withHeaders($this->headers)->get(
            'https://' . $this->account . '.vtexcommercestable.com.br/api/oms/pvt/orders',
            ['f_creationDate' => 'creationDate:[' . $year . '-01-01T02:00:00.000Z TO ' . $year . '-12-31T01:59:59.999Z]', 'f_hasInputInvoice' => false]
        );

        if ($response->clientError()) {
            return 'Bad Request';
        }
        if ($response->serverError()) {
            return 'Server  error';
        }
        if ($response->successful()) {
            $decoded_data = json_decode($response->body());
            $this->processOrders($decoded_data->list);
            $pages = $decoded_data->paging->pages;
            echo 'Orders found: ' . $decoded_data->stats->stats->totalValue->Count;
            try {
                for ($i = 1; $i <= $pages; $i++) {
                    $response = Http::withHeaders($this->headers)->get(
                        'https://' . $this->account . '.vtexcommercestable.com.br/api/oms/pvt/orders',
                        ['f_creationDate' => 'creationDate:[' . $year . '-01-01T02:00:00.000Z TO ' . $year . '-12-31T01:59:59.999Z]', 'f_hasInputInvoice' => false, 'page' => $i]
                    );
                    $data =  json_decode($response->body())->list;
                    $this->processOrders($data);;
                }
                return 'Done.';
            } catch (Error $e) {
                return $e;
            }
        }
    }

    public function processOrders($orders)
    {
        foreach ($orders as $key) {
            if ($key->status == 'ready-for-handling') {
                $this->getOrder($key->orderId);
            }
        }
    }
}
