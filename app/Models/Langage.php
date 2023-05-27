<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Langage extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'langages';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'english_name', 'iso', 'name'];

    public function films()
    {
        return $this->belongsToMany(Film::class)->withTimestamps();
    }
}
