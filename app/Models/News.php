<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'admin_id',
        'judul_berita',
        'slug',
        'konten',
        'gambar_thumbnail',
    ];
    
    const CREATED_AT = 'tanggal_dibuat';
    const UPDATED_AT = 'tanggal_update';
    
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    protected $casts = [
        'tanggal_dibuat' => 'datetime',
        'tanggal_update' => 'datetime',
    ];
}