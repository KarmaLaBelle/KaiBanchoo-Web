<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Image;

class dashboard extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('dashboard.dashboard');
    }

    public function getAvatarPage()
    {
        $user = Auth::user();
        return view('dashboard.avatarUpload', ['avatar' => url("/".$user->id)]);
    }

    public function postAvatarPage(Request $request)
    {
        $this->validate($request, ['avatar' => 'required|max:50|image|image_size:<=200']);
        if($request->hasFile("avatar"))
        {
            $session = Auth::user();
            $user = User::findOrFail($session->id);
            $data = base64_encode(Image::make(file_get_contents($request->file('avatar')))->encode('jpg', 90));
            $user->avatar = $data;
            $user->update();
            return redirect()->intended('/dashboard/avatar');
        } else {
            return redirect()->back()
                ->withErrors(
                    ['avatarError' => "You need to select an image first"]
                );
        }
    }
}
