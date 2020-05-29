<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('profession');
            $table->string('phone_number');
            $table->string('skills');
            $table->string('photo');
            $table->string('models');
            $table->string('rating');
            $table->foreignId('user_id')
            ->constrained()
            ->onDelete('cascade');
            $table->timestamps();
            $table->boolean('is_deleted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('providers');
    }
}
