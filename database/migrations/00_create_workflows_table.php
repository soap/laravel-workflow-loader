<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('workflows', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('marking_store_attribute')->nullable()->comment('name of marking store attribute');
            $table->string('type')->default('workflow')->comment('workflow or state_machine');
            $table->text('description')->nullable();
            $table->json('supports')->nullable()->comment('support models');
            $table->json('metadata')->nullable()->comment('metadata');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('workflows');
    }
};
