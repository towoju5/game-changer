<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfUnderReview
{
    public function handle(Request $request, Closure $next)
    {
        $user = \Auth::user();

        // // If the user has not filled personal details, redirect to the edit profile page
        // if ($user->first_name == null || $user->last_name == null || $user->username == null) {
        //     return redirect('/profile/edit');
        // } 
        
        // // If the user has filled personal details and is under review, redirect to the profile page
        // elseif ($user->account_verification == 'Under Review') {
        //     return redirect('/profile');
        // }

        
        // // If admin approved the request it will redirect to the telegram link
        // elseif ($user->account_verification == 'Approved' && $user->getRoleNames()->first() == 'User') {
        //     return redirect('https://t.me/+EMNFy10vePowYmRh');
        // }

        // // If the user has filled personal details and is suspended, redirect to the profile page
        // elseif ($user->account_verification == 'Suspended') {
        //     return redirect('/profile');
        // }

        // If the user has filled personal details and is approved, proceed to the next request
        return $next($request);
    }
}
