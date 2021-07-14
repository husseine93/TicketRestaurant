<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TicketValidate
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
        $ticket = $request->ticket();
        if($ticket->state==1)
            {
                return redirect('/privates');
            }   

        return $next($request);
        }
    }
}
