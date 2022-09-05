<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
class WebController extends Controller
{
    public function index(Request $request)
    {
        return view('web.index');
    }

    public function payment(Request $request)
    {
        if (!empty(env('SERVER_KEY_MIDTRANS_SANDBOX'))){
            // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = env('SERVER_KEY_MIDTRANS_SANDBOX');
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = false;
            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = true;
            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = true;
            
            $params = array(
                // transaksi 
                'transaction_details' => array(
                    'order_id' => rand(),
                    'gross_amount' => 18000,
                ),
                // transaksi detail/item 
                'item_details' => array(
                    [
                        'id' => 'a1',
                        'price' => '10000',
                        'quantity' => 1,
                        'name' => 'Apel'
                    ],[
                        'id' => 'b1',
                        'price' => '8000',
                        'quantity' => 1,
                        'name' => 'Jeruk'
                    ]
                ),

                // data pembayar/data customer
                'customer_details' => array(
                    'first_name' => $request->get('uname'),
                    'last_name' => '',
                    'email' => $request->get('email'),
                    'phone' => $request->get('number'),
                ),
            );
            
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            // dd($snapToken);
            return view('web.payment', compact('snapToken'));
        } else {
            abort(404);
        }
    }

    public function paymentPost(Request $request)
    {
        // return $request;
        $json = json_decode($request->get('json'));
        $order = new Order();
        $order->status = $json->transaction_status;
        // $order->uname = $request->get('uname');
        // $order->email = $request->get('email');
        // $order->number = $request->get('number');
        $order->uname ='afif';
        $order->email = 'afif@gmail.com';
        $order->number = '081277';
        $order->transaction_id = $json->transaction_id;
        $order->order_id = $json->order_id;
        $order->gross_amount = $json->gross_amount;
        $order->payment_type = $json->payment_type;
        $order->payment_code = isset($json->payment_code) ? $json->payment_code : null;
        $order->pdf_url = isset($json->pdf_url) ? $json->pdf_url : null;
        return $order->save() ? 
            redirect(url('/web'))->with('alert-success', 'Order berhasil dibuat') 
            : redirect(url('/web'))->with('alert-failed', 'Terjadi kesalahan');
    }
}
