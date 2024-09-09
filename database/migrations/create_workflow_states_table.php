<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('workflow_states', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('metadata')->nullable()->comment('metadata');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('workflow_states');
    }
};
