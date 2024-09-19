<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $tableName = app(\Soap\WorkflowLoader\DatabaseLoader::class)->getWorkflowStateTransitionTableName();
        Schema::create($tableName, function (Blueprint $table) {
            $table->id();
            $table->foreignId('workflow_transition_id')->constrained('workflow_transitions')->onDelete('cascade');
            $table->foreignId('from_state_id')->constrained('workflow_states')->onDelete('cascade');
            $table->unique(['workflow_transition_id', 'from_state_id'], 'wf_transition_from_state_unique');
            $table->timestamps();
        });
    }

    public function down()
    {
        $tableName = app(\Soap\WorkflowLoader\DatabaseLoader::class)->getWorkflowStateTransitionTableName();
        Schema::dropIfExists($tableName);
    }
};
