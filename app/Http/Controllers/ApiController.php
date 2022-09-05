<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
class ApiController extends Controller
{
    public function payment_handler(Request $request){
        // return $request;
        $json = json_decode($request->getContent());
        $signature_key = hash('sha512',$json->order_id . $json->status_code . $json->gross_amount . env('SERVER_KEY_MIDTRANS_SANDBOX'));
        // return $signature_key;
        if($signature_key != $json->signature_key){
            return abort(404);
        }

        // //status berhasil
        $order = Order::where('order_id', $json->order_id)->first();
        return $order->update(['status'=>$json->transaction_status]);
    }
}
