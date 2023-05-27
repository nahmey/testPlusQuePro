<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pays extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'pays';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'iso', 'name'];

    public function films()
    {
        return $this->belongsToMany(Film::class)->withTimestamps();
    }
}
