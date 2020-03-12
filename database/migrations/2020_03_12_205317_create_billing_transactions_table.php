<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('sid');
            $table->string('account')->nullable();
            $table->string('order_id');
            $table->foreignId('user_subscription_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->double('amount');
            $table->enum('status', ['initiated', 'failed', 'completed']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billing_transactions');
    }
}
