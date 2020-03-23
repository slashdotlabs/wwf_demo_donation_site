<?php

namespace App\Http\Controllers;

use App\Billing\IpayGateway;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create(IpayGateway $ipayGateway)
    {
        $donor = session()->get('donor');
        $donor->load(['donor_details', 'donor_subscriptions']);


        $params = [
            'order_id' => "wwftest-" . now()->timestamp,
            'phone_number' => $donor->donor_details->phone_number,
            'email' => $donor->email,
            'amount' => $donor->donor_subscriptions->first()->amount
        ];

        return $ipayGateway->charge($params);
    }

    public function store(Request $request)
    {
        $data = $request->all();
    }
}
