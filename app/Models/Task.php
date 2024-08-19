<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    use HasFactory;
    use HasUuids;


    protected $fillable = [

        "name",
        "description",
        "project_id",
        "start_date",
        "end_date",
        "assignee"
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "assignee");
    }
}
