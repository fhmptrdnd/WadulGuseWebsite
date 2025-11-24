<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'feedback',
        'is_active',
        // OPD Things
        'prioritas',
        'ditangani_oleh',
        'opd_id',
        'admin_photo', 
    ];

    /**
     * Cast atribut ke boolean biar ga return string
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function opd(): BelongsTo
    {
        return $this->belongsTo(KategoriOpd::class, 'opd_id', 'opd_id');
    }

    // Admin/User yang menangani (ditangani_oleh)
    public function handler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ditangani_oleh');
    }
}
