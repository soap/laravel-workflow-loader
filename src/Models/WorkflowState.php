<?php

namespace Soap\WorkflowLoader\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Soap\WorkflowLoader\DatabaseLoader;

class WorkflowState extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'metadata' => 'array',
        'initial_state' => 'boolean',
        'final_state' => 'boolean',
    ];

    public function getTable(): string
    {
        return app(DatabaseLoader::class)->getWorkflowStateTableName();
    }

    public function workflow(): BelongsTo
    {
        return $this->belongsTo(Workflow::class);
    }
}
