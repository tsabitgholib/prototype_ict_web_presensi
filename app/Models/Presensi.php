<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Presensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'qr_code', 
        'latitude', 
        'longitude',
        'guru_id',
        'metode',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

}
