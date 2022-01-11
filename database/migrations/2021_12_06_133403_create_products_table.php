<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{

    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->unsignedBigInteger('section_id');
            $table->longText('notes')->nullable();
            $table->timestamps();


          $table->foreign('section_id')->references('id')->on('sections')
              ->onDelete('cascade')->onUpdate('cascade');  // لما احذف القسم احذفلي كل المنتجات اللي تخصه وهكذا لما احدث
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
