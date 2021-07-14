<?php
namespace App\Http\Middleware;

    
    use App\Models\User;
    use App\Http\Middleware\Auth;
    use Illuminate\Http\Request;
    use Closure;

    class CheckAdmin
    {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle(Request $request, Closure $next)
        {
        $user = $request->user();
        if($user && $user->role !=1 )
            {
                return redirect('/privates');
            }   

        return $next($request);
        }
    }
