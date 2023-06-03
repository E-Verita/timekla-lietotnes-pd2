<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Book;

class AuthorController extends Controller
{
    public function __construct()
    {
    $this->middleware('auth');
    }
    
    //display the list of all authors
    public function list(){
        $items = Author::orderBy('name','asc')->get();
        return view(
            'author.list',
            [
                'title'=>'Autori',  //virsraksts, ks parādīsies lapā
                'items'=> $items,
            ]

        );
    }

    //display new author form
    public function create(){
        return view(
            'author.form',
            [
                'title' => 'Pievienot jaunu autoru',
                'author' => new Author(),
            ]
        );
    }

    //save new author
    public function put(Request $request){
        $validatedDate = $request->validate([
            'name' => 'required',
            ]);

            $author = new Author();
            $author -> name = $validatedDate['name'];
            $author -> save();

            return redirect('/authors');
    }

    //display author update form
    public function update(Author $author){
        return view(
            'author.form',
            [
                'title' => 'Rediģēt autoru',
                'author' => $author,
            ]
            );
    }

    //update existing authors
    public function patch(Author $author, Request $request){
        $validatedDate = $request->validate([
            'name' => 'required',
            ]);

            $author -> name = $validatedDate['name'];
            $author -> save();

            return redirect('/authors');
    }

    //delete
    public function delete (Author $author){
        $author -> delete();
        return redirect('/authors');
    }

}
