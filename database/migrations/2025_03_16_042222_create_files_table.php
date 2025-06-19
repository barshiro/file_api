<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->char('UUID_FILE', 36)->primary();
            $table->char('UUID_USER', 36);
            $table->char('UUID_DIR', 36);
            $table->string('name', 255);
            $table->bigInteger('size');
            $table->string('type', 50);
            $table->string('path')->nullable(); // Путь к файлу на сервере
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->foreign('UUID_USER')->references('UUID_USER')->on('users')->onDelete('cascade');
            $table->foreign('UUID_DIR')->references('UUID_DIR')->on('dirs')->onDelete('cascade');
            $table->index('name');
            $table->index('UUID_DIR');
        });
    }

    public function down()
    {
        Schema::dropIfExists('files');
    }
}