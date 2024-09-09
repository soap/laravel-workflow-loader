<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('workflow_state_transitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_state_id')->constrained('workflow_states')->onDelete('cascade');
            $table->foreignId('to_state_id')->constrained('workflow_states')->onDelete('cascade');
            $table->unique(['from_state_id', 'to_state_id'], 'from_to_state_unique');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('workflow_state_transitions');
    }
};
