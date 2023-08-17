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
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('job_title');
            $table->string('country');
            $table->string('city');
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('country_code');
            $table->enum('activation',['active','in_active'])->default('in_active');
            // $table->enum('rate',[1,2,3,4,5])->default(0);
            $table->string('company_registeration_image')->nullable();
            $table->string('otp_code');
            $table->enum('provider_type',['freelancer','company']);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
