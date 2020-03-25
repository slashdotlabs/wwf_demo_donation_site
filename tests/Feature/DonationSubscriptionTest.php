<?php

namespace Tests\Feature;

use App\Enums\SubscriptionTypeEnum;
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

    /**
     * @test
     * @param string $subscriptionType
     *
     * @dataProvider subscriptionTypes
     */
    public function donor_can_subsribe_to_a_subscription(string $subscriptionType)
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->state('donor')->make()->toArray();
        $donor_details = factory(DonorDetail::class)->make()->toArray();
        $subscription = factory(UserSubscription::class)->state($subscriptionType)->make()->toArray();

        $attributes = compact(['user', 'donor_details', 'subscription']);

        $this->assertActionUsesFormRequest(UserSubscriptionController::class, 'store', SubscribeDonorRequest::class);

        Mail::fake();

        $this->post('/subscriptions/store', $attributes)
            ->assertRedirect(route('payment.create'))
            ->assertSessionHas('donor');

        $this->assertDatabaseHas('users', collect($user)->except('email_verified_at')->toArray());
        $this->assertDatabaseHas('donor_details', $donor_details);
        $this->assertDatabaseHas('user_subscriptions', $subscription);

        Mail::assertSent(AccoutSetup::class);

        $this->markTestIncomplete('Check payment callback');
    }

    public function subscriptionTypes()
    {
        return [
            SubscriptionTypeEnum::adoption()->getValue() => [SubscriptionTypeEnum::adoption()->getValue()],
            SubscriptionTypeEnum::membership()->getValue() => [SubscriptionTypeEnum::membership()->getValue()]
        ];
    }
}
