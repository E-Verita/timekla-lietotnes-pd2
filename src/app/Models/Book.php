<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'author_id', 'description', 'price', 'year', 'genre_id'];


    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
    
    public function jsonSerialize(): mixed
    {
        $image = $this->image ? asset('images/' . $this->image) : asset('images/nocover.jpg');


        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'author' => $this->author->name,
            'genre' => ($this->genre ? $this->genre->name : ""),
            'price' => floatval(number_format($this->price, 2)),
            'year' => $this->year,
            'image' => $image,
        ];
    }

}