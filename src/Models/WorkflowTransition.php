<?php

namespace Soap\WorkflowLoader\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Soap\WorkflowLoader\DatabaseLoader;

class WorkflowTransition extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

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

    public function getFromStatesNameAttribute(): Collection
    {
        return $this->fromStates()
            ->with('fromState')
            ->get()
            ->pluck('fromState.name');
    }
}
