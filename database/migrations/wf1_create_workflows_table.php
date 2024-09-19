<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $tableName = app(\Soap\WorkflowLoader\DatabaseLoader::class)->getWorkflowTableName();
        Schema::create($tableName, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('marking_store')->nullable()->comment('marking store as array');
            $table->string('type')->default('workflow')->comment('workflow or state_machine');
            $table->text('description')->nullable();
            $table->json('supports')->nullable()->comment('support models');
            $table->json('metadata')->nullable()->comment('metadata');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        $tableName = app(\Soap\WorkflowLoader\DatabaseLoader::class)->getWorkflowTableName();
        Schema::dropIfExists($tableName);
    }
};
