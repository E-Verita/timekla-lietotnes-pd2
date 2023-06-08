<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\Book;

class GenreController extends Controller
{
    // display all genres
    public function list()
    {
        $items = Genre::orderBy('name', 'asc')->get();
        return view(
            'genre.list',
            [
                'title' => 'Žanri',
                'items' => $items
            ]
        );
    }

    public function create()
    {
        return view(
            'genre.form',
            [
                'title' => 'Pievienot žanru',
                'genre' => new Genre(),

            ]
        );
    }

    //save new genre
    public function put(Request $request){
        $validatedDate = $request->validate([
            'name' => 'required',
            ]);

            $genre = new Genre();
            $genre -> name = $validatedDate['name'];
            $genre -> save();

            return redirect('/genres');
    }
////
     //display genres update form
     public function update(Genre $genre){
        return view(
            'genre.form',
            [
                'title' => 'Rediģēt žanru',
                'genre' => $genre,
            ]
            );
    }

    //update existing genre
    public function patch(Genre $genre, Request $request){
        $validatedDate = $request->validate([
            'name' => 'required',
            ]);

            $genre -> name = $validatedDate['name'];
            $genre -> save();

            return redirect('/genres');
    }

    //delete
    public function delete (Genre $genre){
        $genre -> delete();
        return redirect('/genres');
    }


}