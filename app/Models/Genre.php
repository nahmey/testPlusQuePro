<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'genres';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'name'];

    public function films()
    {
        return $this->belongsToMany(Film::class)->withTimestamps();
    }
}
