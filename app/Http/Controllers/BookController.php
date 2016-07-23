<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use App\Book;
use Gate;
use App\Lib\JsonRpc\JsonRpcResponse;
class BookController extends Controller
{
    public function index() {
    	$books = Book::all();
        $resp = new JsonRpcResponse;
        return new JsonResponse($resp->setResult($books)->render(), 200);
    }
    public function store(Request $request) {
        $rules = [
            "title" => "required|alpha",
            "author" => "required|alpha",
            "year" => "required|integer|max:2016",
            "genre" => "required|alpha",
        ];
        $validator = Validator::make($request->params, $rules);
        $resp = new JsonRpcResponse;
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $code => $error) {
                $resp->setError($code, $error);
            }
            return new JsonResponse($resp->render(), 404);
        } else {
            $book = new Book();
            $book->title = $request->params["title"];
            $book->author = $request->params["author"];
            $book->year = $request->params["year"];
            $book->genre = $request->params["genre"];
            $book->save();
            return Redirect::to('books/' . $book->id);
        }
    }
     public function show($id) {
        $book = Book::find($id);
        $resp = new JsonRpcResponse;
        $resp->setId($id);
        if ($book === null) {
            return new JsonResponse($resp->setError("1", "book not found")->render(), 404);
        } else {
            return new JsonResponse($resp->setResult($book)->render(), 200);
        }
    }
    public function destroy($id) {
        $book = Book::find($id);
        $resp = new JsonRpcResponse;
        $resp->setId($id);
        if ($book === null) {
            return new JsonResponse($resp->setError("1", "book not found")->render(), 404);
        } else {
            $book->delete();
            return new JsonResponse($resp->setResult("success")->render(), 200);
        }
    }
}