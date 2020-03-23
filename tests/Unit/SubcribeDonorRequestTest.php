<?php

namespace Tests\Unit;

use App\Enums\BillingCycleEnum;
use App\Enums\SubscriptionTypeEnum;
use App\Enums\UserTypeEnum;
use App\Http\Requests\SubscribeDonorRequest;
use JMac\Testing\Traits\HttpTestAssertions;
use Spatie\Enum\Laravel\Rules\EnumRule;
use Tests\TestCase;

class SubcribeDonorRequestTest extends TestCase
{
    use HttpTestAssertions;

    private SubscribeDonorRequest $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new SubscribeDonorRequest();
    }

    /** @test */
    public function validate_rules(): void
    {
        $expected = [
            'user' => ['required', 'array'],
            'user.first_name' => 'required',
            'user.last_name' => 'required',
            'user.email' => ['required', 'unique:users,email', 'email:rfc'],
            'user.user_type' => ['required', new EnumRule(UserTypeEnum::class)],

            'donor_details' => ['required', 'array'],
            'donor_details.phone_number' => 'required',
            'donor_details.city' => 'required',
            'donor_details.country' => 'required',
            'donor_details.postal_code' => 'required',

            'subscription' => ['required', 'array'],
            'subscription.subscription_type' => ['required', new EnumRule(SubscriptionTypeEnum::class)],
            'subscription.amount' => ['required', 'integer'],
            'subscription.cycle' => ['required', new EnumRule(BillingCycleEnum::class)]
        ];

        $this->assertValidationRules($expected, $this->subject->rules());
    }

    /** @test */
    public function athourizes_all_requests(): void
    {
        $this->assertEquals(true, $this->subject->authorize());
    }
}
