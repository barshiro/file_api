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
        DB::table('dirs')->insert([
            'UUID_DIR' => '01a4d274-3c8f-4bed-bd78-e8406d64a272',
            'UUID_USER' => '242b72c2-2d84-4a7a-bfa0-e0068873783d',
            'name' => 'work_2 (копия) (копия)',
            'parent_dir' => '28857830-1300-4c12-8160-cbd3c25e9fd2',
            'created_at' => '2025-03-31 13:59:59',
            'updated_at' => '2025-03-31 13:59:59',
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('dirs');
    }
}
