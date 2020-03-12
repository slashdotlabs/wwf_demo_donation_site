<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/donate', function() {
    $options = [
        [
            'image_url' => 'https://d3qzf9rpau633b.cloudfront.net/img/dsc_9271_489430.jpg',
            'title' => 'Become a member',
            'description' => "Your monthly donation helps us to protect, save and restore our country’s most important places as well as influence how you sustainably benefit from nature's resources. Be a change maker. #TogetherforNature",
            'button_text' => 'Sign up',
        ],
        [
            'image_url' => 'https://d3qzf9rpau633b.cloudfront.net/img/large_ww22455_490648.jpg',
            'title' => 'Adopt',
            'description' => 'Become a WWF adopter for just Ksh. 500 per month. Your symbolic adoption supports WWF-Kenya\'s work towards protecting Kenya’s endangered species ( Lions, Elephants, Rhinos and Turtles). Take action NOW!',
            'button_text' => 'Show your support',
        ],
        [
            'image_url' => 'https://d3qzf9rpau633b.cloudfront.net/img/unnamed__40__486319.jpg',
            'title' => 'Shop for nature',
            'description' => 'Gift nature by Shopping with us. You are just a click away from showing your love for nature and supporting our conservation goals. Get the latest WWF-Kenya branded merchandise. #TogetherForNature',
            'button_text' => 'Shop',
        ]
    ];
    return view('donate', compact(['options']));
})->name('donate');

Route::get('ipay_test', function(\App\Billing\IpayGateway $ipayGateway) {
    $params = [
        'order_id' => "wwftest-".now()->timestamp,
        'phone_number' => '0725127193',
        'email' => 'waynewanyee@gmail.com',
        'amount' => '1'
    ];

//     Test first payment
    return $ipayGateway->charge($params);

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
