<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIsAdminOrSelf
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // USER ID THAT COMES FROM THE FRONT-END
        $userId=$request->route()->parameter('id');
        // IF USER IS AN ADMINISTRATOR OR IS TRYING TO ACCESS THEIR OWN INFORMATIONS
        if(Auth::user()->role===2 || Auth::user()->id===$userId){
            // LET THEM CONTINUE
            return $next($request);
        }
        // USER DOESN'T HAVE ACCESS TO THE INFORMATION
        return response()->json([
            'status'=>false,
            'message'=>'Unauthorized access.',
        ],403); 
    }
}
