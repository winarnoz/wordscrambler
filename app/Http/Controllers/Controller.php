<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use App\Models\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function authRequest(Request $request) {
        if ($request->hasHeader('X-Token')) {
            $user = User::where('api_token',  $request->header('X-Token'))->take(1)->get();
            if (count($user)===0) {
                return 0;
            }
            return $user[0];
        } else {
            return 0;
        }
    }
}
