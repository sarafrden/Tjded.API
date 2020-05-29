<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('required');
            $table->text('description');
            $table->string('limited_price');
            $table->string('images');
            $table->string('address');
            $table->foreignId('user_id')
            ->constrained()
            ->onDelete('cascade');
            $table->foreignId('category_id')
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
        Schema::dropIfExists('items');
    }
}
