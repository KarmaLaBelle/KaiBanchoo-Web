<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Log;

class Debug extends Controller
{
    public function getDebug(Request $request, $section)
    {
        Log::info(sprintf("Request made to %s from %s", $section, $request->getClientIp()));
        return '';
    }

    public function postDebug(Request $request, $section)
    {
        Log::info(sprintf("Request made to %s", $section));
        return '';
    }
}
