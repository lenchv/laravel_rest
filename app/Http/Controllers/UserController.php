<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\User;
use Gate;
use App\Lib\JsonRpc\JsonRpcResponse;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function show($id) {
        $user = User::find($id);
        $resp = new JsonRpcResponse;
        $resp->setId($id);
        if ($user === null) {
            return new JsonResponse($resp->setError("1", "user not found")->render(), 404);
        } else {
            return new JsonResponse($resp->setResult($user)->render(), 200);
        }
    }
}