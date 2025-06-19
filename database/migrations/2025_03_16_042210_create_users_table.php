<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->char('UUID_USER', 36)->primary();
            $table->string('login', 50)->unique();
            $table->string('mail', 100)->unique();
            $table->string('password_hash', 255);
            $table->timestamps();
        });
        DB::table('users')->insert([
            'UUID_USER' => '14bb2d14-9950-434f-8a6d-b5c2bd21d967',
            'login' => 'testuser',
            'mail' => 'testuser@example.com',
            'password_hash' => '$2y$12$RYUdI.K003LbEF3IWLz3u.6rvN2JNfcI9lGDdPBiKqSdSXrxJJ8/m',
            'created_at' => '2025-03-30 01:12:57',
            'updated_at' => '2025-03-30 01:12:57',
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
