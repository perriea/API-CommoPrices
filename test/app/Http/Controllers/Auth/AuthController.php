<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Auth;
use DB;
use Session;
use App;
use Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;


    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('guest', ['except' => 'getLogout']);
        $this->data = NULL;
    }


    public function store($request)
    {
        return DB::select(DB::raw($request));
    }


    protected function getLoginValidator()
    {
        return Validator::make($this->data, ["username" => "exists:users,username"]);
    }


    public function getLogin($user, $key)
    {
        $this->data = array('username' => $user, 'password' => $key);
        $validator = $this->getLoginValidator();

        if ($validator->passes()) 
        {
            $user = $this->store("SELECT COUNT(username) FROM users WHERE username = '".$this->data['username']."' AND password = '".$this->data['password']."'");
            if ($user[0]->{"COUNT(username)"} == 1) {
                Session::put('username', $this->data['username']);
                return response()->json(["auth" => "ok", "name" => $this->data['username']]);
            }
            else
                return response()->json(["auth" => "fail", "name" => $this->data['username']]);
        }
        else
            return response()->json(["auth" => "fail", "name" => $this->data['username']]);
    }


    /**
     * Effectue le logout
     *
     * @return Redirect
     */
    public function getLogout()
    {   
        Session::flush();
        return response()->json(["auth" => "Logout", "name" => Session::get("username")]);
    }
}
