<?php

namespace App\Repositories;

use App\Models\Book;
use GuzzleHttp\Client;
use App\Http\Resources\BookResource;

class Books{
    
    public function storeBook($request){

        $client = new Client(['base_uri' => 'https://openlibrary.org/']);

        $params = [
            'query' => [
                'bibkeys' => $request['ISBN'],
                'jscmd' => 'data',
                'format' => 'json'
            ],
            'headers' => [
                'Accept' => 'application/json'
            ],
            ];

        $response = $client->request('GET', '/api/books', $params);
        $res = json_decode($response->getBody(), true);

        if (empty($res)) {
            return response()->json([
                'status' => 'IBSN no encontrado'
            ]);
        }else{
            $book = new Book;
            $book->ISBN = $request['ISBN'];
            $book->title = $res[$request['ISBN']]['title'];
            if (array_key_exists('cover', $res[$request['ISBN']]))  {
                $book->cover_large = $res[$request['ISBN']]['cover']['large'];
            }else{
                $book->cover_large = NULL;
            }

            $book->save();
            
            $array = $res[$request['ISBN']]['authors'];
            $arrayAux = array();
            foreach ($array as $resKey) {
                $arrayAux[] = array(
                    'author_name'=> $resKey['name'],
                    'book_id' => $book->id
                );
            }

            $book->authors()->createMany($arrayAux);
            return response()->json([
                'status' => $response->getStatusCode()
            ]);
        }

    }

    public function getBooks(){
        return BookResource::collection(Book::with('authors')->paginate(2));
    }

    public function deleteBook($request){

        $book = Book::where('ISBN', '=', $request['ISBN'])->with('authors')->get();

        if (!sizeOf($book)) {
            return response()->json([
                'status' => 'ISBN no encontrado'
                ]);
        }else{
            $book = Book::where('ISBN', '=', $request['ISBN'])->delete();
            return response()->json([
                'status' => 'DELETED'
                ]);
        }

    }

    public function showBook($id){
        $book = Book::where('ISBN', '=', $id)->with('authors')->get();
        $xml = "<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>\n";
        if (!sizeOf($book)) {
            return $xml .= $this->isbnNotFound();
        }else{
            $title_size = 1;
            $xml .= "<libros>\n";
            foreach ($book as $data) {
                $xml .= $this->printItem($data['title'], $data['ISBN'], $data['cover_large'], $data['authors']);
            }
            $xml .= "</libros>\n";   
            return response($xml,200)->header("Content-type","text/xml");
        }
         
        return $book;
    }

    private function printItem($title, $ISBN, $cover_large, $authors)
    {
        $item = "<libro>\n";
        $item .= "<titulo>" . $title . "</titulo>\n";
        $item .= "<ISBN>" . $ISBN . "</ISBN>\n";
        $item .= "<autores>";
        foreach ($authors as $author) {
            $item .= "<autor>" . $author['author_name'] . "</autor>\n";
        }
        $item .= "</autores>\n";
        $item .= " <caratula>" . $cover_large . "</caratula>\n";
        $item .= "</libro>\n";
        return $item;
    }

    private function isbnNotFound()
    {
        $item = "<libro>\n";
        $item .= "Error, libro no encontrado\n";
        $item .= "</libro>\n";
        return $item;
    }

}