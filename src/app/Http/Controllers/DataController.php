<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Genre;

class DataController extends Controller
{
    //atgriež 3 nejauši izvēlētas grāmatas

    public function getTopBooks()
    {
        $genres = Genre::pluck('id')->toArray();
        $books = [];
    
        while (count($books) < 3) {
            $genreId = array_shift($genres);
            $booksByGenre = Book::where('display', true)
                ->where('genre_id', $genreId)
                ->inRandomOrder()
                ->first();
    
            if ($booksByGenre) {
                $books[] = $booksByGenre;
            }
    
            if (empty($genres)) {
                break;
            }
        }
    
        if (count($books) < 3) {
            $remainingCount = 3 - count($books);
            $remainingGenreIds = array_diff(Genre::pluck('id')->toArray(), collect($books)->pluck('genre_id')->toArray());
            $remainingBooks = Book::where('display', true)
                ->whereIn('genre_id', $remainingGenreIds)
                ->inRandomOrder()
                ->take($remainingCount)
                ->get();
    
            $books = array_merge($books, $remainingBooks->toArray());
        }
    
        if (count($books) < 3) {
            $remainingCount = 3 - count($books);
            $randomBooks = Book::where('display', true)
                ->inRandomOrder()
                ->whereNotIn('genre_id', collect($books)->pluck('genre_id')->toArray())
                ->take($remainingCount)
                ->get();
    
            $books = array_merge($books, $randomBooks->toArray());
        }
    
        return $books;
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
         $relatedBooks = Book::where('display', true)
             ->where('id', '<>', $book->id)
             ->where('author_id', $book->author_id)
             ->inRandomOrder()
             ->take(3)
             ->get();
     
         $missingBooksCount = 3 - $relatedBooks->count();
     
         if ($missingBooksCount > 0) {
             $genreBooks = Book::where('display', true)
                 ->where('genre_id', $book->genre_id)
                 ->where('id', '<>', $book->id)
                 ->whereNotIn('id', $relatedBooks->pluck('id')->toArray())
                 ->inRandomOrder()
                 ->take($missingBooksCount)
                 ->get();
     
             $relatedBooks = $relatedBooks->concat($genreBooks);
             $missingBooksCount -= $genreBooks->count();
         }
     
         if ($missingBooksCount > 0) {
             $randomBooks = Book::where('display', true)
                 ->where('id', '<>', $book->id)
                 ->whereNotIn('id', $relatedBooks->pluck('id')->toArray())
                 ->inRandomOrder()
                 ->take($missingBooksCount)
                 ->get();
     
             $relatedBooks = $relatedBooks->concat($randomBooks);
         }
     
         return $relatedBooks;
     }
     

}
