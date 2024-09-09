<?php

namespace Soap\WorkflowStorage\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Soap\WorkflowStorage\DatabaseLoader;
use Soap\WorkflowStorage\Enums\WorkflowTypeEnum;

class Workflow extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description',
        'supports',
        'metadata',
    ];

    protected $casts = [
        'supports' => 'array',
        'metadata' => 'array',
        'type' => WorkflowTypeEnum::class,
    ];

    public function getTable()
    {
        return app(DatabaseLoader::class)->getTableName('workflows');
    }
}
