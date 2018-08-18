<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    /**
     * Register a new file for the portal
     *
     * @param  string  $cfileid
     * @return Response
     */
    public function start($cfileid)
    {
        return view('onboarding.start');
    }
}
