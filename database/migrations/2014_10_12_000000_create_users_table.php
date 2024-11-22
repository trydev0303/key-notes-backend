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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->integer('role')->nullable()->comment('0 for admin, 1 for user');
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('country_code')->nullable();
            $table->string('phone')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('profile_image')->nullable();
            $table->integer('otp')->nullable();
            $table->string('social_id')->nullable();
            $table->integer('social_login_type')->nullable()->comment('1 for google ,2 for facebook');
            $table->integer('login_type')->nullable()->comment('1 for social ,2 for general');
            $table->integer('is_verified')->default(0)->comment('1 for verified ,0 for unverify');
            $table->timestamp('email_verified_at')->nullable();
            $table->longText('device_token')->nullable();
            $table->integer('device_type')->nullable()->comment('0 for android , 1 for ios');
            $table->string('device_model')->nullable();
            $table->string('country')->nullable();
            $table->string('location')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->integer('is_online')->default(0)->comment('1 for online , 0 for offline');
            $table->string('password')->nullable();
            $table->integer('status')->default(1)->comment('1 for active ,2 for suspended ,3 for deactivate');
            $table->longText('remember_token')->nullable();
            $table->date('subscription_date')->nullable();
            $table->string('order_id')->nullable();
            $table->string('plan_validity')->nullable();
            $table->longText('short_bio')->nullable();
            $table->integer('is_notify')->default(0)->comment('1 for notify ,0 for unnotify');
            $table->integer('is_face_id')->default(0)->comment('1 for face_id, 0 for no face_id');
            $table->integer('is_remember')->default(0)->comment('1 for remember, 0 for no remember');
            $table->integer('is_touch_id')->default(0)->comment('1 for touch_id, 0 for no touch_id');
            $table->integer('is_email_notify')->default(0)->comment('1 email notify, 0 for email unnotify');

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
