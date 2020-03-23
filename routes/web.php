<?php

use App\Billing\IpayGateway;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'UserSubscriptionController@create')->name('subscription.create');
Route::post('/subscriptions/store', 'UserSubscriptionController@store')->name('subscription.store');

Route::get('/payments/create', 'PaymentController@create')->name('payment.create');

Route::get('ipay_test', function (IpayGateway $ipayGateway) {
    $params = [
        'order_id' => "wwftest-" . now()->timestamp,
        'phone_number' => '0725127193',
        'email' => 'waynewanyee@gmail.com',
        'amount' => '1'
    ];

    $initiator_res = $ipayGateway->rest_initiate_request($params);

    if ($initiator_res->status() !== 200) {
        // todo handle error
        dd($initiator_res->json());
    }

    dump($initiator_res->json());

    $initiator_data = $initiator_res->json()['data'];

//    // Send stk push
//    $stk_res = $ipayGateway->trigger_stk_push($params['phone_number'], $initiator_data['sid']);
//    dd($stk_res->json());

    // Recurring billing charge
    $recurring_params = [
        'sid' => $initiator_data['sid'],
        'cardid' => 'demo',
        'phone' => $params['phone_number'],
        'email' => $params['email'],
    ];
    $recurring_res  = $ipayGateway->recurring_billing($recurring_params);
    dd($recurring_res->json());
});

Route::get('payment/process', function () {
   Log::channel('ipay')->debug('Sent from C2B callback', request()->all());
   dd(request()->all());
});
