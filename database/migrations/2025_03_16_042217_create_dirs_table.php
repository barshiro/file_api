<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirsTable extends Migration
{
    public function up()
    {
        Schema::create('dirs', function (Blueprint $table) {
            $table->char('UUID_DIR', 36)->primary();
            $table->char('UUID_USER', 36);
            $table->string('name', 255);
            $table->char('parent_dir', 36)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->foreign('UUID_USER')->references('UUID_USER')->on('users')->onDelete('cascade');
            $table->foreign('parent_dir')->references('UUID_DIR')->on('dirs')->onDelete('restrict');
            $table->unique(['name', 'parent_dir']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('dirs');
    }
}