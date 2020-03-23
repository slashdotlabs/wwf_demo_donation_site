<?php

namespace Tests\Unit;

use App\Http\Requests\SubscribeDonorRequest;
use JMac\Testing\Traits\HttpTestAssertions;
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
            'user.email' => ['required', 'unique:users,email', 'email:rfc,dns'],
            'user.user_type' => ['required', 'in:donor'],

            'donor_details' => ['required', 'array'],
            'donor_details.phone_number' => 'required',
            'donor_details.city' => 'required',
            'donor_details.country' => 'required',
            'donor_details.postal_code' => 'required',

            'subscription' => ['required', 'array'],
            'subscription.subscription_type' => ['required', 'in:adoption,membership'],
            'subscription.amount' => ['required', 'integer'],
            'subscription.cycle' => ['required', 'in:monthly,quarterly,yearly']
        ];

        $this->assertValidationRules($expected, $this->subject->rules());
    }

    /** @test */
    public function athourizes_all_requests(): void
    {
        $this->assertEquals(true, $this->subject->authorize());
    }
}
