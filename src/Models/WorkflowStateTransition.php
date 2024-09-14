<?php

namespace Soap\WorkflowStorage\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Soap\WorkflowStorage\DatabaseLoader;

class WorkflowStateTransition extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function getTable(): string
    {
        return app(DatabaseLoader::class)->getWorkflowStateTransitionTableName();
    }

    public function transition(): BelongsTo
    {
        return $this->belongsTo(WorkflowTransition::class);
    }

    public function fromState(): BelongsTo
    {
        return $this->belongsTo(WorkflowState::class, 'from_state_id');
    }

    public function toState(): BelongsTo
    {
        return $this->belongsTo(WorkflowState::class, 'to_state_id');
    }
}
