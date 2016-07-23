<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable("books")) {
            Schema::create('books', function (Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->string('title');
                $table->string('author');
                $table->integer('year');
                $table->string('genre');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("books");
    }
}
