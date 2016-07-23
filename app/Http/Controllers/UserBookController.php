<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use App\UserBook;
use App\User;
use App\Book;
use Gate;
use App\Lib\JsonRpc\JsonRpcResponse;

class UserBookController extends Controller
{
    public function show($userId) {
        $resp = new JsonRpcResponse;
        $resp->setId($userId);
        $user = User::find($userId);
        if ($user === null) {
            return new JsonResponse($resp->setError("1", "user not found")->render(), 404);
        }
        $books = $user->books()->get();
        return new JsonResponse($resp->setResult($books)->render(), 200);
    }

    public function store(Request $request) {
    	$userBook = new UserBook;
        $rules = [
            "user_id" => "required|exists:users,id",
            "book_id" => "required|exists:books,id",
        ];
        $validator = Validator::make($request->params, $rules);
        $resp = new JsonRpcResponse;
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $code => $error) {
                $resp->setError($code, $error);
            }
            return new JsonResponse($resp->render(), 404);
        } else {
        	$userBook->user_id = $request->params["user_id"];
        	$userBook->book_id = $request->params["book_id"];
            $userBook->save();
        	return Redirect::to("userbooks/{$request->params['user_id']}");
        }
    }

    public function destroy($id) {
        $userBook = UserBook::find($id);
        $resp = new JsonRpcResponse;
        $resp->setId($id);
        if ($userBook === null) {
            return new JsonResponse($resp->setError("1", "book sign not found")->render(), 404);
        } else {
            $userBook->delete();
            return new JsonResponse($resp->setResult("success")->render(), 200);
        }
    }
}