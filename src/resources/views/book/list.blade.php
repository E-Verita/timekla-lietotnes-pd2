@extends('layout')
@section('content')
    <h1>{{ $title }}</h1>
    @if (count($items) > 0)
        <div class="table-responsive">
            <table class="table table-dark table-striped table-hover table-sm d-none d-md-table"> 
            
                <!-- Table Header -->
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Attēls</th>
                        <th scope="col">ID</th>
                        <th scope="col">Nosaukums</th>
                        <th scope="col">Autors</th>
                        <th scope="col">Žanrs</th>
                        <th scope="col">Gads</th>
                        <th scope="col">Cena</th>
                        <th scope="col">Publicēts</th>
                        <th scope="col">Darbības</th>
                        <th scope="col">&nbsp;</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody>
                    @foreach ($items as $book)
                        <tr>
                            <td>
                                @if ($book->image)
                                    <img src="{{ asset('images/' . $book->image) }}" alt="Book Image" width="100">
                                @else
                                    <div class="book-info-overlay">
                                        <img src="{{ asset('images/nocover.jpg') }}" alt="No Image" width="100">
                                        <div class="book-info-text">
                                            <span>{{ $book->name }}</span>
                                            <span>{{ $book->author->name }}</span>
                                        </div>
                                    </div>
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
        </div>
        
        <div class="d-md-none">

            <!-- Mobile view -->
            @foreach ($items as $book)
                <div class="mb-4">
                    <div>
                        @if ($book->image)
                            <img src="{{ asset('images/' . $book->image) }}" alt="Book Image" width="100">
                        @else
                            <div class="book-info-overlay">
                                <img src="{{ asset('images/nocover.jpg') }}" alt="No Image" width="100">
                                <div class="book-info-text">
                                    <span>{{ $book->name }}</span>
                                    <span>{{ $book->author->name }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div>
                        <strong>ID:</strong> {{ $book->id }}
                    </div>
                    <div>
                        <strong>Nosaukums:</strong> {{ $book->name }}
                    </div>
                    <div>
                        <strong>Autors:</strong> {{ $book->author->name }}
                    </div>
                    <div>
                        <strong>Žanrs:</strong> {{ $book->genre?->name }}
                    </div>
                    <div>
                        <strong>Gads:</strong> {{ $book->year }}
                    </div>
                    <div>
                        <strong>Cena:</strong> &euro; {{ number_format($book->price, 2, '.') }}
                    </div>
                    <div>
                        <strong>Publicēts:</strong> {!! $book->display ? '&#x2714;' : '&#x274C;' !!}
                    </div>
                    <div>
                        <a href="/books/update/{{ $book->id }}" class="btn btn-outline-primary btn-sm">Labot</a> /
                        <form method="post" action="/books/delete/{{ $book->id }}" class="d-inline deletion-form">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">Dzēst</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>Nav atrasts neviens ieraksts</p>
    @endif
    <div class="text-center">
        <a href="/books/create" class="btn btn-primary align-center">Pievienot jaunu gramatu</a>
    </div>
@endsection