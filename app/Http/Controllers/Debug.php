<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Log;

class Debug extends Controller
{
    public function getThingy(Request $request, $uri)
    {
        Log::info(sprintf("New %s request from %s with data: %s", $request->method(), $uri, json_encode($request->all())));
        return "";
    }
}
