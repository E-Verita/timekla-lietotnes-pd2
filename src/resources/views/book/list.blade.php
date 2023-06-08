@extends('layout')
@section('content')
    <h1>{{ $title }}</h1>
    @if (count($items) > 0)
        <table class="table table-sm table-hover table-striped">
            <thead class="thead-light align-middle">
                <tr>
                    <th>Attēls</th>
                    <th>ID</th>
                    <th>Nosaukums</th>
                    <th>Autors</th>
                    <th>Žanrs</th>
                    <th>Gads</th>
                    <th>Cena</th>
                    <th>Publicēts</th>
                    <th>Darbības</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $book)
                    <tr>
                        <td>
                            @if ($book->image)
                                <img src="{{ asset('images/' . $book->image) }}" alt="Book Image" width="100">
                            @else
                                No Image
                            @endif
                        </td>
                        <td class="align-middle">{{ $book->id }}</td>
                        <td class="align-middle">{{ $book->name }}</td>
                        <td class="align-middle">{{ $book->author->name }}</td>
                        <td class="align-middle">{{ $book->genre?->name }}</td>
                        <td class="align-middle">{{ $book->year }}</td>
                        <td class="align-middle">&euro; {{ number_format($book->price, 2, '.') }}</td>
                        <td class="align-middle">{!! $book->display ? '&#x2714;' : '&#x274C;' !!}</td>
                        <td class="align-middle">
                            <a href="/books/update/{{ $book->id }}" class="btn btn-outline-primary btn-sm">Labot</a> /
                            <form method="post" action="/books/delete/{{ $book->id }}" class="d-inline deletion-form">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">Dzēst</button>
                            </form>
                        </td>


                        <td>&nbsp;</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Nav atrasts neviens ieraksts</p>
    @endif
    <a href="/books/create" class="btn btn-primary">Pievienot jaunu</a>
@endsection
