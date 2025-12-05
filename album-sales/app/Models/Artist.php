<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;

    // Primary key is 'code' instead of 'id'
    protected $primaryKey = 'code';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['name'];

    public function albums()
    {
        return $this->hasMany(Album::class, 'artist_code', 'code');
    }

    public function albumCount()
    {
        return $this->albums()->count();
    }

    public function totalSales()
    {
        return (int) $this->albums()->sum('sales');
    }
}
