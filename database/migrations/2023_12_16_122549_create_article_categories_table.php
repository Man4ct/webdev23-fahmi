<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('article_categories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->unique();
        });
    }

    public function down()
    {
        Schema::dropIfExists('article_categories');
    }
}
