<?php

namespace Tests\Unit;


use App\Models\DonorDetail;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function donor_has_details()
    {
        $donor = factory(User::class)->state('donor')->create();

        $this->assertInstanceOf(DonorDetail::class, $donor->donor_details);
    }

    /** @test */
    public function donor_has_subscriptions()
    {
        $donor = factory(User::class)->state('donor')->create();

        $this->assertInstanceOf(Collection::class, $donor->donor_subscriptions);
    }
}
