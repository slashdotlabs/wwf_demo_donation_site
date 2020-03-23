<?php

namespace Tests\Feature;

use App\Http\Controllers\UserSubscriptionController;
use App\Http\Requests\SubscribeDonorRequest;
use App\Mail\AccoutSetup;
use App\Models\DonorDetail;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use JMac\Testing\Traits\HttpTestAssertions;
use Tests\TestCase;

class DonationSubscriptionTest extends TestCase
{
    use WithFaker, RefreshDatabase, HttpTestAssertions;

    /** @test */
    public function donor_can_subsribe_to_adoption_subscription()
    {
        // TODO: mock ipay response, check payment callback, check email sent for account creation

        $this->withoutExceptionHandling();

        $user = factory(User::class)->make()->only(['first_name', 'last_name', 'email']);
        $user['user_type'] = 'donor';
        $donor_details = factory(DonorDetail::class)->make()->only(['phone_number', 'city', 'country', 'postal_code']);
        $subscription = factory(UserSubscription::class)->state('adoption')->make()->only(['subscription_type', 'cycle', 'amount']);

        $attributes = compact(['user', 'donor_details', 'subscription']);

        $this->assertActionUsesFormRequest(UserSubscriptionController::class, 'store', SubscribeDonorRequest::class);

        Mail::fake();

        $this->post('/subscriptions/store', $attributes);

        $this->assertDatabaseHas('users', $user);
        $this->assertDatabaseHas('donor_details', $donor_details);
        $this->assertDatabaseHas('user_subscriptions', $subscription);

        Mail::assertSent(AccoutSetup::class);
    }

    /** @test */
    public function donor_can_subsribe_to_membership_subscription()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->make()->only(['first_name', 'last_name', 'email']);
        $user['user_type'] = 'donor';
        $donor_details = factory(DonorDetail::class)->make()->only(['phone_number', 'city', 'country', 'postal_code']);
        $subscription = factory(UserSubscription::class)->state('membership')->make()->only(['subscription_type', 'cycle', 'amount']);

        $attributes = compact(['user', 'donor_details', 'subscription']);

        $this->assertActionUsesFormRequest(UserSubscriptionController::class, 'store', SubscribeDonorRequest::class);

        Mail::fake();

        $this->post('/subscriptions/store', $attributes);

        $this->assertDatabaseHas('users', $user);
        $this->assertDatabaseHas('donor_details', $donor_details);
        $this->assertDatabaseHas('user_subscriptions', $subscription);

        Mail::assertSent(AccoutSetup::class);
    }
}
