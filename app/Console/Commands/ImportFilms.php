<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

use App\Models\Film;
use App\Models\Entreprise;
use App\Models\Genre;
use App\Models\Langage;
use App\Models\Pays;
use App\Models\User;

class ImportFilms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:import_films';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importe les films dans la base de données';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $token = "eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIyMjJkNjNjZGRjMDY2ZDk5ZWQzZTgwNmQzMjY3MThjYSIsInN1YiI6IjYyNGVhNTRhYjc2Y2JiMDA2ODIzODc4YSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.zuuBq1c63XpADl8SQ_c62hezeus7VibE1w5Da5UdYyo";

        $all_films_ids = $this->getAllFilmsIds($token);

        if(!empty($all_films_ids)){
            foreach ($all_films_ids as $film_id){
                $this->getFilmData($film_id, $token);
                // sleep(1);
                // die();
            }
        }

        // return Command::SUCCESS;
    }

    private function getFilmData($film_id, $token)
    {
        $url = "https://api.themoviedb.org/3/movie/".$film_id;
        $response = Http::withToken($token)->get($url);

        $sync_langage = [];
        $sync_entreprise = [];
        $sync_pays = [];
        $sync_genre = [];


        if($response){
            $film = (Object) $response->json();

            if(!empty($film->spoken_languages)){
                foreach ($film->spoken_languages as $spoken_language) {
                    $spoken_language = (Object) $spoken_language;

                    $langage = Langage::updateOrCreate(
                        ['iso' => $spoken_language->iso_639_1],
                        [
                            'iso' => $spoken_language->iso_639_1, 
                            'english_name' => $spoken_language->english_name, 
                            'name' => $spoken_language->name,
                        ]
                    );

                    $sync_langage[] = $langage->id;
                }
            }

            if(!empty($film->production_companies)){
                foreach ($film->production_companies as $entreprise) {
                    $entreprise = (Object) $entreprise;

                    Entreprise::updateOrCreate(
                        ['id' => $entreprise->id],
                        [
                            'id' => $entreprise->id,
                            'logo_path' => $entreprise->logo_path,
                            'name' => $entreprise->name,
                            'origin_country' => $entreprise->origin_country,
                        ]
                    );

                    $sync_entreprise[] = $entreprise->id;
                }
            }        

            if(!empty($film->production_countries)){
                foreach ($film->production_countries as $countrie) {
                    $countrie = (Object) $countrie;

                    $pays = Pays::updateOrCreate(
                        ['iso' => $countrie->iso_3166_1],
                        [
                            'iso' => $countrie->iso_3166_1,
                            'name' => $countrie->name
                        ]
                    );

                    $sync_pays[] = $pays->id;
                }
            } 

            if(!empty($film->production_countries)){
                foreach ($film->genres as $genre) {
                    $genre = (Object) $genre;

                    Genre::updateOrCreate(
                        ['id' => $genre->id],
                        [
                            'id' => $genre->id,
                            'name' => $genre->name
                        ]
                    );

                    $sync_genre[] = $genre->id;
                }
            }

            $new_film = Film::updateOrCreate(
                ['id' => $film->id],
                [
                    'id' => $film->id,
                    'title' => !empty($film->title) ? $film->title : null,
                    'backdrop_path' => !empty($film->backdrop_path) ? $film->backdrop_path : null,
                    'original_language' => !empty($film->original_language) ? $film->original_language : null,
                    'original_title' => !empty($film->original_title) ? $film->original_title : null,
                    'overview' => !empty($film->overview) ? $film->overview : null,
                    'poster_path' => !empty($film->poster_path) ? $film->poster_path : null,
                    'media_type' => !empty($film->media_type) ? $film->media_type : null,
                    'release_date' => !empty($film->release_date) ? $film->release_date : null,
                    'video' => !empty($film->video) ? $film->video : false,
                    'adult' => !empty($film->adult) ? $film->adult : false,
                    'popularity' => !empty($film->popularity) ? $film->popularity : null,
                    'vote_average' => !empty($film->vote_average) ? $film->vote_average : null,
                    'vote_count' => !empty($film->vote_count) ? $film->vote_count : null,
                    'budget' => !empty($film->budget) ? $film->budget : null,
                    'imdb_id' => !empty($film->imdb_id) ? $film->imdb_id : null,
                    'revenue' => !empty($film->revenue) ? $film->revenue : null,
                    'runtime' => !empty($film->runtime) ? $film->runtime : null,
                    'status' => !empty($film->status) ? $film->status : null,
                    'tagline' => !empty($film->tagline) ? $film->tagline : null
                ]
            );

            $new_film->langages()->sync($sync_langage);
            $new_film->entreprises()->sync($sync_entreprise);
            $new_film->pays()->sync($sync_pays);
            $new_film->genres()->sync($sync_genre);

            // return var_dump($response);
        }
    }

    private function getAllFilmsIds($token)
    {
        $url = "https://api.themoviedb.org/3/trending/movie/day";
        $response = Http::withToken($token)->get($url);
        $all_films_ids = [];

        if($response){
            $response = (Object) $response->json();

            if(!empty($response->results)){
                foreach ($response->results as $film) {
                    $film = (Object) $film;
                    $all_films_ids[] = $film->id;
                }
            }
        }

        return $all_films_ids;
    }
}
