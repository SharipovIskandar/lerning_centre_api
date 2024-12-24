<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('table_name');
            $table->string('field_name');
            $table->unsignedBigInteger('field_id');
            $table->text('field_value');
            $table->string('language_url');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('translations');
    }
}
