<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Log;
use DB;

class Beatmap extends Controller
{
    public function getScores(Request $request)
    {
        $output = "2|"; //Need more info
        $output .= "false|"; //Need more info
        $output .= sprintf("%s|",$request->query("i")); //Beatmap ID
        $output .= "45204|"; //Beatmap wallpaper? Not too sure yet
        $output .= sprintf("%d\n", DB::table('beatmapsRanks')->where('beatmapID', '=', $request->query("c"))->count()); //How many ranks are in the table for the ID
        $output .= "0\n"; //Need more info
        $output .= sprintf("[bold:0,size:20]%s|\n",str_replace(".osu","",$request->query("f"))); //Sets text size and name for viewing
        $output .= "9.19911\n"; //Difficulty? Need more info
        $selfrank = DB::table('beatmapsRanks')->select('id','user','score','combo','count50','count100','count300','countMiss','countKatu','countGeki','fc','mods','avatarID', DB::raw('FIND_IN_SET( score, (SELECT GROUP_CONCAT( score ORDER BY score DESC ) FROM beatmapsRanks )) AS rank'),'timestamp')->where('user', '=', $request->query("us"))->where('beatmapID', '=', $request->query("c"))->orderBy('rank','asc')->first();
        if(!is_null($selfrank))
        {
            $output .= $this->scoreString($selfrank->id, $selfrank->user, $selfrank->score, $selfrank->combo, $selfrank->count50, $selfrank->count100, $selfrank->count300, $selfrank->countMiss, $selfrank->countKatu, $selfrank->countGeki, $selfrank->fc, $selfrank->mods, $selfrank->avatarID, $selfrank->rank, $selfrank->timestamp);
        }
        else
        {
            $output .= "\n";
        }
        $ranking = DB::table('beatmapsRanks')->select('id','user','score','combo','count50','count100','count300','countMiss','countKatu','countGeki','fc','mods','avatarID', DB::raw('FIND_IN_SET( score, (SELECT GROUP_CONCAT( score ORDER BY score DESC ) FROM beatmapsRanks )) AS rank'),'timestamp')->where('beatmapID', '=', $request->query("c"))->orderBy('rank','asc')->limit(50)->get();
        foreach ($ranking as $rank)
        {
            $output .= $this->scoreString($rank->id, $rank->user, $rank->score, $rank->combo, $rank->count50, $rank->count100, $rank->count300, $rank->countMiss, $rank->countKatu, $rank->countGeki, $rank->fc, $rank->mods, $rank->avatarID, $rank->rank, $rank->timestamp);
        }
        return $output;
    }

    public function submitModular(Request $request)
    {
        Log::info(sprintf("Encrypted data: %s",json_encode($request->all())));
        //$decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $request->input("pass"), $request->input("fs"), MCRYPT_MODE_CBC, $request->input("iv"));
        //Log::info($decrypted);
        return "";
    }

    private function scoreString($replayId, $name, $score, $combo, $count50, $count100, $count300, $countMiss, $countKatu, $countGeki, $FC, $mods, $avatarID, $rank, $timestamp)
    {
        return sprintf("%d|%s|%d|%d|%d|%d|%d|%d|%d|%d|%d|%d|%d|%d|%d|1\n",$replayId, $name, $score, $combo, $count50, $count100, $count300, $countMiss, $countKatu, $countGeki, $FC, $mods, $avatarID, $rank, $timestamp);
    }
}
