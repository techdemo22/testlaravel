<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckUser
{
    public function handle($request, Closure $next)
    {     
		
        if(!empty(auth()->id()))
        {   
            $data = DB::table('users')
                    ->select('users.*')
                    ->where([['users.id',auth()->id()],['status',"1"],['verify_status','1'],['deleted_status',"0"],['type','user']])
                    ->get()->first();
            if (empty($data->id))
            {
                auth()->logout();
                return redirect()->intended(route('posts.myposts'))->with('error', 'Please Login to access user area.');
            }else{
                Session::put('UserData',$data);
            }
    
            return $next($request);
        }
        else 
        {
            if($request->ajax()){
                return response('Unauthenticated', 401);
            }
            return redirect()->intended(route('posts.myposts'))->with('error', 'Please Login to access user area');
        }
    }

}

