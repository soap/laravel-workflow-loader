<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('state')->nullable();
            $table->unsignedInteger('price')->default(0)->comment('price in stangs');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });
    }
};
