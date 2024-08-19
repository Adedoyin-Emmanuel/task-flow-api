<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class Project extends Model
{
    use HasFactory;
    use HasUuids;


    protected $fillable = [
        "name",
        "description",
        "start_date",
        "end_date"
    ];
}
