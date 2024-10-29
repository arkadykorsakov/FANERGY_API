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
		Schema::create('posts', function (Blueprint $table) {
			$table->id();
			$table->string('title');
			$table->string('description');
			$table->string('category');
			$table->jsonb('links')->nullable();
			$table->foreignId('user_id')->index()->constrained('users')->onDelete('cascade');
            $table->decimal('price', 10,2)->default(0);
			$table->foreignId('subscription_level_id')->nullable()->index()->constrained('subscription_levels')->onDelete('set null');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('posts');
	}
};
