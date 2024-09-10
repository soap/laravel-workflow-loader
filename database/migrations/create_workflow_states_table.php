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
            $table->tinyInteger('initial_state')->default(0)->comment('initial state');
            $table->tinyInteger('final_state')->default(0)->comment('final state');
            $table->foreignId('workflow_id')->constrained('workflows')->onDelete('cascade');
            $table->json('metadata')->nullable()->comment('metadata');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('workflow_states');
    }
};
