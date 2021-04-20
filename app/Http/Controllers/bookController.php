<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Repositories\Books;
use App\Http\Requests\deleteBook;


class bookController extends Controller
{

    public function __construct(Books $books){
        $this->books = $books;
    }
    
    public function index(){
        $books = $this->books->getBooks();
        return view('books.index', compact('books'));
    }

    public function toList()
    {
        $books = $this->books->getBooks();
        return $books;
    }

    public function create(Request $request)
    {
        $books = $this->books->storeBook($request);
        return $books;
    }

    public function show($id)
    {
        $book = $this->books->showBook($id);
        return $book;
    }

    public function destroy(Request $request)
    {
        $books = $this->books->deleteBook($request);
        return $books;
    }

    public function deleteBook($id)
    {
        $book = Book::where('ISBN', '=', $id)->delete();
        return back()->with('ok', '<span>Usuario:</span> '. $id);
    }
}
