<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileTagTable extends Migration
{
    public function up()
    {
        Schema::create('file_tag', function (Blueprint $table) {
            $table->char('UUID_FILE', 36);
            $table->char('UUID_TAG', 36);
            $table->primary(['UUID_FILE', 'UUID_TAG']);
            $table->foreign('UUID_FILE')->references('UUID_FILE')->on('files')->onDelete('cascade');
            $table->foreign('UUID_TAG')->references('UUID_TAG')->on('tags')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('file_tag');
    }
}