<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

class userProfile extends Controller
{
    public function getProfile($userid)
    {
        $user = User::find($userid);
        if(count($user) >= 1) {
            $updated = new Carbon($user->updated_at);
            $now = Carbon::now();
            if($updated->diff($now)->m < 1) {
                $lastOnline = "Last seen less than a minute ago";
            } elseif($updated->diff($now)->h < 1) {
                $lastOnline = ($updated->diffInMinutes($now) > 1) ? sprintf("Last seen %d minutes ago", $updated->diffInMinutes($now)) : sprintf("Last seen %d minute ago", $updated->diffInMinutes($now));
            } elseif($updated->diff($now)->d < 1) {
                $lastOnline = ($updated->diffInHours($now) > 1) ? sprintf("Last seen %d hours ago",$updated->diffInHours($now)) : sprintf("Last seen %d hour ago",$updated->diffInHours($now));
            } elseif($updated->diff($now)->d < 7) {
                $lastOnline = ($updated->diffInDays($now) > 1) ? sprintf("Last seen %d days ago",$updated->diffInDays($now)) : sprintf("Last seen %d day ago",$updated->diffInDays($now));
            } elseif($updated->diff($now)->m < 1) {
                $lastOnline = ($updated->diffInWeeks($now) > 1) ? sprintf("Last seen %d weeks ago",$updated->diffInWeeks($now)) : sprintf("Last seen %d week ago",$updated->diffInWeeks($now));
            } elseif($updated->diff($now)->y < 1) {
                $lastOnline = ($updated->diffInMonths($now) > 1) ? sprintf("Last seen %d months ago",$updated->diffInMonths($now)) : sprintf("Last seen %d month ago",$updated->diffInMonths($now));
            } else {
                $lastOnline = ($updated->diffInYears($now) > 1) ? sprintf("Last seen %d years ago",$updated->diffInYears($now)) : sprintf("Last seen %d year ago",$updated->diffInYears($now));
            }
            return view('dashboard.userProfile', ['user' => $user, 'lastOnline' => $lastOnline]);
        } else {
            return view('dashboard.userProfile');
        }
    }
}
