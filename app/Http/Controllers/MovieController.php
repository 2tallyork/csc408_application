<?php namespace App\Http\Controllers;
//this is the movie controller
use Illuminate\Http\Request;
use App\Http\Requests\CreateMovieValidation;

use App\Movie;
use App\User;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::get()->toArray();

        return view('movies.index')->with('movies', $movies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('movies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\CreateMovieValidation $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateMovieValidation $request)
    {
        $input = $request->all();

        $movie = new Movie($input);
        if ( ! $movie->save() ) {
            $this->setMessage('Oops... Movie was not created.  Please try again', 'error');
            return redirect('/movies');
        }

        // Save the uploaded photo
        if ($request->file('cover_photo')) {
            $this->savePicture($request, $movie);
        }

        return redirect('/movies');
    }

    /**
     * Uses the image library from Intervention to manipulate the image See
     * example 14-4 in book.
     * http://image.intervention.io
     *
     * @param Request $request
     * @param Person $person
     */
    private function savePicture($request, Movie $movie)
    {
        $original = $request->file('cover_photo');

        $image = Image::make($original)->encode('jpg', 75);

        $filename = 'movie_' . $movie->id . '.jpg';

        // For updates we need to delete existing file
        if (Storage::disk('web')->exists($filename)) {
            Storage::disk('web')->delete($filename);
        }

        Storage::disk('web')->put($filename, $image->getEncoded());
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // if ( $movie = Movie::with('genre')->with('reviews')->find($id)->toArray() ) {
        if ( $movie = Movie::find($id)->toArray() ) {

            // $genres = Genre::get()->toArray();

            // $avgKernals = $this->calculateKernals($movie['reviews']);

            return view('movies.show')->with('movie', $movie);
                // ->with('genres', $genres)
                // ->with('kernals', $avgKernals);
        }

        // User doesn't exist for this account
        $this->setMessage('Movie not found!', 'error');

        return redirect('/movies');
    }


    // Get a list of movies to view as a renter
    public function listing()
    {
        $movies = Movie::orderBy('title')->get()->toArray();

        return view('movies.listing')->with('movies', $movies);
    }

}
