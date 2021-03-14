<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
        public function up(): void
        {
        Schema::create('social_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('social_id');
            $table->string('social_name');
            $table->string('social_type');
            $table->string('access_token')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('social_data');
    }
}
