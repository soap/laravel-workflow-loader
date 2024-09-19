<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $tableName = app(\Soap\WorkflowLoader\DatabaseLoader::class)->getWorkflowTransitionTableName();
        Schema::create($tableName, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('to_state_id')->constrained('workflow_states')->onDelete('cascade');
            $table->foreignId('workflow_id')->constrained('workflows')->onDelete('cascade');
            $table->json('metadata')->nullable()->comment('meta data');
            $table->timestamps();
        });
    }

    public function down()
    {
        $tableName = app(\Soap\WorkflowLoader\DatabaseLoader::class)->getWorkflowTransitionTableName();
        Schema::dropIfExists($tableName);
    }
};
