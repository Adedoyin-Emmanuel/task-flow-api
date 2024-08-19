<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Token extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        "user_id",
         "token",
         "type",
         "expires_at"
    ];


    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
}
