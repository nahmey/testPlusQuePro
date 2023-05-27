<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'films';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'title', 'backdrop_path', 'original_language', 'original_title', 'overview', 'poster_path', 'media_type', 'release_date', 'video', 'adult', 'popularity', 'vote_average','vote_count', 'budget', 'imdb_id', 'revenue', 'runtime', 'status', 'tagline'];


    public function entreprises()
    {
        return $this->belongsToMany(Entreprise::class, 'film_entreprise')->withTimestamps();
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class)->withTimestamps();
    }

    public function langages()
    {
        return $this->belongsToMany(Langage::class)->withTimestamps();
    }

    public function pays()
    {
        return $this->belongsToMany(Pays::class)->withTimestamps();
    }

}
