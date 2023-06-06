<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class DataController extends Controller
{
    //atgriež 3 nejauši izvēlētas grāmatas
    public function getTopBooks()
    {
        return Book::where('display', true)
        ->inRandomOrder()
        ->take(3)
        ->get();
    }

    //atgriež gramatu (pēc id)
    public function getBook(Book $book)
    {
        return Book::where([
            'id' => $book->id,
            'display' => true,
        ])
        ->firstOrFail();
    }

     // atgriež līdzīgus ierakstus
     public function getRelatedBooks(Book $book)
     {
         return Book::where('display', true)
             ->where('id', '<>', $book->id)
             ->where('author_id', $book->author_id)
             ->inRandomOrder()
             ->take(3)
             ->get();

     }
}
