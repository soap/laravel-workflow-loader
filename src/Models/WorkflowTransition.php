<?php

namespace Soap\WorkflowStorage\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Soap\WorkflowStorage\DatabaseLoader;

class WorkflowTransition extends Model
{
    use HasFactory;

    protected $fillable = [
        'workflow_id',
        'from_state_id',
        'to_state_id',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function getTable(): string
    {
        return app(DatabaseLoader::class)->getWorkflowTransitionTableName();
    }

    public function workflow(): BelongsTo
    {
        return $this->belongsTo(Workflow::class);
    }

    public function toState(): BelongsTo
    {
        return $this->belongsTo(WorkflowState::class);
    }

    public function fromStates(): HasMany
    {
        return $this->hasMany(WorkflowStateTransition::class);
    }
}
