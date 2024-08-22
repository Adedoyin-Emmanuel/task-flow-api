<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    use HasUuids;


    protected $fillable = [
        "name",
        "description",
        "start_date",
        "end_date",
        "project_manager_id",
        "status"
    ];
}
