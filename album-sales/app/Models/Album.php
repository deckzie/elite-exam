<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = ['artist_code', 'year', 'name', 'sales', 'cover'];

    public function artist()
    {
        return $this->belongsTo(Artist::class, 'artist_code', 'code');
    }
}
