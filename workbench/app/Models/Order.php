<?php

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Workbench\AppModels\User;
use ZeroDaHero\LaravelWorkflow\Traits\WorkflowTrait;

class Order extends Model
{
    protected $guarded = ['id'];

    use WorkflowTrait;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
