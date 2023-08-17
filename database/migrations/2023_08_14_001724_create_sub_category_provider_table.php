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
        Schema::create('sub_category_provider', function (Blueprint $table) {
            $table->id();
            $table->foreignid('sub_category_id')->constraind('sub_categories')->cascadeondelete();
            $table->foreignid('provider_id')->constraind('providers')->cascadeondelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_category_provider');
    }
};
