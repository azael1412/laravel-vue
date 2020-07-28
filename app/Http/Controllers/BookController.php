<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\BookCollection;
use App\Book;
use Illuminate\Validation\ValidationException;
class BookController extends Controller
{
      // all books
      public function index()
      {
          $books = Book::all()->toArray();
          return array_reverse($books);
      }
  
      // add book
      public function add(Request $request)
      {
        if (request()->ajax()) {
			try {
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:255',
            'author' => 'required|min:3|max:255',
        ]);
          $book = new Book([
              'name' => $request->input('name'),
              'author' => $request->input('author')
          ]);
          $book->save();
  
          return response()->json(['message' => 'Libro creado', 'id' => $book->id]);
        }
          catch ( ValidationException $e ) {
            return response()->json(['errors' => $e->validator->errors()]);
        }
    }
        abort( 401);
      }
  
      // edit book
      public function edit($id)
      {
          $book = Book::find($id);
          return response()->json($book);
      }
  
      // update book
      public function update($id, Request $request)
      {
        if (request()->ajax()) {
			try {
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:255',
            'author' => 'required|min:3|max:255',
        ]);
          $book = Book::find($id);
          $book->update($request->all());
  
          return response()->json(['message' => 'Libro actualizado', 'id' => $book->id]);
        }catch ( ValidationException $e ) {
            return response()->json(['errors' => $e->validator->errors()]);
        }
      }
    }
  
      // delete book
      public function delete($id)
      {
          $book = Book::find($id);
          $book->delete();
  
          return response()->json('The book successfully deleted');
      }
}
