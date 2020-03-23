<?php

namespace App\Http\Controllers;


use App\Http\Requests\SubscribeDonorRequest;
use App\Models\DonorDetail;
use App\Models\User;
use App\Models\UserSubscription;
use App\Providers\App\Events\DonorSubscribed;

class UserSubscriptionController extends Controller
{

    public function create()
    {
        $options = [
            [
                'image_url' => 'https://d3qzf9rpau633b.cloudfront.net/img/dsc_9271_489430.jpg',
                'title' => 'Become a member',
                'description' => "Your monthly donation helps us to protect, save and restore our country’s most important places as well as influence how you sustainably benefit from nature's resources. Be a change maker. #TogetherforNature",
                'button_text' => 'Sign up',
                'button_url' => '#'
            ],
            [
                'image_url' => 'https://d3qzf9rpau633b.cloudfront.net/img/large_ww22455_490648.jpg',
                'title' => 'Adopt',
                'description' => 'Become a WWF adopter for just Ksh. 500 per month. Your symbolic adoption supports WWF-Kenya\'s work towards protecting Kenya’s endangered species ( Lions, Elephants, Rhinos and Turtles). Take action NOW!',
                'button_text' => 'Show your support',
                'button_url' => '#'
            ],
            [
                'image_url' => 'https://d3qzf9rpau633b.cloudfront.net/img/unnamed__40__486319.jpg',
                'title' => 'Shop for nature',
                'description' => 'Gift nature by Shopping with us. You are just a click away from showing your love for nature and supporting our conservation goals. Get the latest WWF-Kenya branded merchandise. #TogetherForNature',
                'button_text' => 'Shop',
                'button_url' => 'http://wwf-shop.test'
            ]
        ];
        return view('donate', compact('options'));
    }

    public function store(SubscribeDonorRequest $request)
    {
        [$user_attributes, $donor_details, $subscription_atrributes] = array_values($request->validated());

        $donor = User::create($user_attributes);
        $donor->donor_details()->save(new DonorDetail($donor_details));
        $donor->donor_subscriptions()->save(new UserSubscription($subscription_atrributes));

        event(new DonorSubscribed($donor));

        // redirect to ipay payment page
    }
}
