<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'entreprises';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'logo_path', 'name', 'origin_country'];

    public function films()
    {
        return $this->belongsToMany(Film::class, 'film_entreprise')->withTimestamps();
    }
}
