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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignid('provider_id')->constraind('providers')->cascadeondelete()->nullable();
            $table->foreignid('users_id')->constraind('users')->cascadeondelete();
            $table->string('service_type');
            $table->date('due_date')->date_format('Y-m-d');
            $table->string('description');
            $table->string('attacment');//
            $table->string('budget');
            $table->string('title');
            $table->enum('status_of_request',['binding','accepted','refused'])->default('binding');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
