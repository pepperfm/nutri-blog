<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', static function (Blueprint $table): void {
            $table->uuid('instance_id')->nullable();
            $table->uuid('id')->primary();
            $table->string('aud')->nullable();
            $table->string('role')->nullable();
            $table->string('email')->nullable();
            $table->string('encrypted_password')->nullable();
            $table->timestamp('email_confirmed_at')->nullable();
            $table->timestamp('invited_at')->nullable();
            $table->string('confirmation_token')->nullable();
            $table->timestamp('confirmation_sent_at')->nullable();
            $table->string('recovery_token')->nullable();
            $table->timestamp('recovery_sent_at')->nullable();
            $table->string('email_change_token_new')->nullable();
            $table->string('email_change')->nullable();
            $table->timestamp('email_change_sent_at')->nullable();
            $table->timestamp('last_sign_in_at')->nullable();
            $table->jsonb('raw_app_meta_data')->nullable();
            $table->jsonb('raw_user_meta_data')->nullable();
            $table->boolean('is_super_admin')->nullable();
            $table->timestamps();
            $table->text('phone')->nullable();
            $table->timestamp('phone_confirmed_at')->nullable();
            $table->text('phone_change')->default('')->nullable();
            $table->string('phone_change_token')->default('')->nullable();
            $table->timestamp('phone_change_sent_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->string('email_change_token_current')->default('')->nullable();
            $table->smallInteger('email_change_confirm_status')->default(0)->nullable();
            $table->timestamp('banned_until')->nullable();
            $table->string('reauthentication_token')->default('')->nullable();
            $table->timestamp('reauthentication_sent_at')->nullable();
            $table->boolean('is_sso_user')->default(false)->nullable();
            $table->softDeletes();
        });

        // Unique constraints and indexes
        Schema::table('users', static function (Blueprint $table): void {
            $table->unique('phone');
            $table->unique('confirmation_token');
            $table->unique('email_change_token_current');
            $table->unique('email_change_token_new');
            $table->unique('reauthentication_token');
            $table->unique('recovery_token');
            $table->unique('email', 'users_email_partial_key')->where('is_sso_user', false);
            $table->index(['instance_id', app('db')->raw('lower(email)')], 'users_instance_id_email_idx');
            $table->index('instance_id', 'users_instance_id_idx');
        });

        // Check constraint
        app('db')->statement('ALTER TABLE users ADD CONSTRAINT users_email_change_confirm_status_check CHECK ((email_change_confirm_status >= 0) AND (email_change_confirm_status <= 2))');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
