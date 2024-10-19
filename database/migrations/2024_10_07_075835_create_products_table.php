<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name', 255);
            $table->unsignedBigInteger('category_id'); // Should match with 'id' from 'categories' table
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->text('image')->nullable();
            $table->string('descr', 2048)->nullable();
            $table->string('brand')->nullable();
            $table->string('rating')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
