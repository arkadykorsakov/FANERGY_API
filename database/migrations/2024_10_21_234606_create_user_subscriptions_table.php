<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('user_subscriptions', function (Blueprint $table) {
			$table->id();
			$table->foreignId('subscriber_id')->index()->constrained('users')->onDelete('cascade');
			$table->foreignId('author_id')->index()->constrained('users')->onDelete('cascade');
			$table->foreignId('subscription_level_id')->nullable()->index()->constrained('subscription_levels')->onDelete('set null');
			$table->dateTime('paid_subscription_start_date')->nullable();
			$table->dateTime('paid_subscription_end_date')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('user_subscriptions');
	}
};
