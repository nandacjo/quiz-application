<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = ['answer', 'qeustion_id'];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}