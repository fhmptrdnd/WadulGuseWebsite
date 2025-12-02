<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriOpd extends Model
{
    use HasFactory;

    protected $table = 'kategori_opd';
    protected $primaryKey = 'opd_id';
    protected $fillable = [
        'nama_opd',
        'deskripsi',
        'email_kontak',
        'nomor_telepon',
        'kategori_tanggungan',
    ];
    /**
     * Get the reports handled by the KategoriOpd.
     */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class, 'opd_id', 'opd_id');
    }
}
