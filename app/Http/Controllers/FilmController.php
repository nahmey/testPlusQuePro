<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Film;
use App\Models\Entreprise;
use App\Models\Langage;
use App\Models\Genre;
use App\Models\Pays;

use Validator;
use Carbon\Carbon;

class FilmController extends Controller
{
    private $error;

    public function __construct()
    {
        $this->error = [
            'error' => true,
            'message' => "Une erreur est survenue"
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $films = 
        Film::
        when(!empty($request->film_id), function($query) use($request){
            $query->where('id', $request->film_id);
        })
        ->orderby($request->current_sort, $request->current_sort_dir)
        ->paginate($request->per_page);

        return response()->json(compact('films'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $film = Film::find($id);

        if($film){
            $film->genres = $film->genres()->pluck('genres.id')->toArray();
            $film->entreprises = $film->entreprises()->pluck('entreprises.id')->toArray();
            $film->langages = $film->langages()->pluck('langages.id')->toArray();
            $film->pays = $film->pays()->pluck('pays.id')->toArray();

            $genres = Genre::orderby('name', 'asc')->select('id', 'name')->get();
            $entreprises = Entreprise::orderby('name', 'asc')->select('id', 'name')->get();
            $langages = Langage::orderby('name', 'asc')->select('id', 'name')->get();
            $pays = Pays::orderby('name', 'asc')->select('id', 'name')->get();

            return response()->json(compact('film', 'genres', 'entreprises', 'langages', 'pays'));
        }

        return response()->json($this->error);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:250|unique:films,title,'.$id,
            'overview' => 'nullable|string',
            'release_date' => 'nullable|date_format:d/m/Y',
            'tagline' => 'nullable|string|max:250',
            'status' => 'nullable|string|max:250',
            'genres' => 'nullable|array',
            'genres.*' => 'numeric|exists:genres,id',
            'entreprises' => 'nullable|array',
            'entreprises.*' => 'numeric|exists:entreprises,id',
            'langages' => 'nullable|array',
            'langages.*' => 'numeric|exists:langages,id',
            'pays' => 'nullable|array',
            'pays.*' => 'numeric|exists:pays,id',
        ]);

        if($validator->fails()) {
            return response()->json([
                'error' => true, 
                'message' => $validator->messages()
            ]);
        }

        $film = Film::find($id);

        if($film){
            $film->update([
                'title' => !empty($request->title) ? $request->title : null,
                'release_date' => !empty($request->release_date) ? Carbon::createFromFormat('d/m/Y', $request->release_date)->format('Y-m-d') : null,
                'overview' => !empty($request->overview) ? $request->overview : null,
                'tagline' => !empty($request->tagline) ? $request->tagline : null,
                'status' => !empty($request->status) ? $request->status : null,
            ]);

            $film->langages()->sync($request->langages);
            $film->entreprises()->sync($request->entreprises);
            $film->pays()->sync($request->pays);
            $film->genres()->sync($request->genres);

            return response()->json($this->success("Le film", "modifié"));
        }

        return response()->json($this->error);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $film = Film::find($id);

        if($film){
            if($film->entreprises()->exists()){
                $film->entreprises()->sync([]);
            }
            if($film->genres()->exists()){
                $film->genres()->sync([]);
            }
            if($film->langages()->exists()){
                $film->langages()->sync([]);
            }
            if($film->pays()->exists()){
                $film->pays()->sync([]);
            }

            $film->delete();

            return response()->json($this->success("Le film", "supprimé"));
        }

        return response()->json($this->error);
    }


    public function searchBar(Request $request)
    {
        $results = null;

        if(!empty($request->search)){
            $results = 
            Film::select('id', 'title')
            ->where('title', 'LIKE', $request->search.'%')
            ->get();
        }

        return $results;
    }


    /*
     * Affiche les succès si tout est ok
     */
    private function success($model, $type, $data = []) // Exemple : $data['nom_de_la_variable' => $donnees]
    {
        $results = [
            'error' => false,
            'message' => $model." a bien été ".$type,
        ];

        if(!empty($data)){
            foreach ($data as $key => $value) {
                $results[$key] = $value;
            }
        }

        return $results;
    }


    public function reloadFilms()
    {
        \Artisan::call('command:import_films');
        // return response()->json()
    }
}
