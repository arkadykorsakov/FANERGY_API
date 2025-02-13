<?php

use App\Enums\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date_birth');
            $table->string('nickname')->unique();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('tg_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('twitch_link')->nullable();
            $table->string('vk_link')->nullable();
            $table->string('inst_link')->nullable();
            $table->string('tiktok_link')->nullable();
            $table->text('description');
            $table->string('role')->default(Role::USER);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('exists_adult_content')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
