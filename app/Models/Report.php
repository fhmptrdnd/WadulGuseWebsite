<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'category',
        'location',
        'description',
        'photo',
        'status',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
