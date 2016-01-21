<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Log;
use DB;
use Response;
use Cache;

class PostHandler extends Controller
{
    public function handle(Request $request)
    {
        $osutoken = $request->header("osu-token");
        $content = $request->getContent();
        /* //Debugging
        if(!$this->isNormalPacket($content)) {
            Log::info(sprintf("Received from client: %s", (string)$content));
            Log::info(sprintf("Received from client with Hex: %s", $this->strToHex($content)));
        }
        */
        if($osutoken)
        {
            $user = Cache::get($osutoken);
            Cache::add($osutoken, $user, 10);
            if($this->isNormalPacket($this->strToHex($content)))
            {
                Log::info(sprintf("Bancho request recieved from %s (%s)", $user->user, $osutoken));
            }
            if($this->isBeatmapExitPacket($this->strToHex($content)))
            {
                Log::info(sprintf("% has exited a beatmap", $user->user));
            }
            if($this->isLogoutPacket($this->strToHex($content)))
            {
                Log::info(sprintf("%s has disconnected", $user->user));
                Cache::forget($osutoken);
            }
            return hex2bin("0d0a");
        }
        else {
            return $this->loginRequest($content);
        }
    }

    private function loginRequest($rawData)
    {
        $arrayData = explode("\n", $rawData);
        $user = DB::table('users')->select('id','user','passwordHash','isBanned')->where('user', '=', $arrayData[0])->first();

        if(is_null($user))
        {
            Log::info(sprintf("%s was not found",$arrayData[0]));
            return hex2bin("05000004000000FEFFFFFF");
        }

        if($user->passwordHash != $arrayData[1])
        {
            Log::info("Wrong password");
            return hex2bin("05000004000000FEFFFFFF");
        }
        $output = "";
        if($user->isBanned)
        {
            $output .= sprintf("5C0000000000000005000004000000600200004b00000400000013000000470000040000000100000048000053006002%s6002", $this->strToHex($user->user));
        }
        $output .= sprintf("%s00040000000000000005000004000000600200004B0000040000001300000047000004000000010000004800000A000000020002000000030000005300001C000000600200000B%s%s1800010000000000000000BC0100000B00002E0000006002000000000000000000000000000067B3040000000000D044783F030000000000000000000000BC0100000000530000210000000200",
            str_pad($user->id, 4, "0", STR_PAD_LEFT),
            str_pad(strval(strlen($user->user)), 2, "0", STR_PAD_LEFT),
            $this->strToHex($user->user));

        $bind = hex2bin($output);
        $token = $this->generateToken();
        Cache::put($token, $user, 10);

        return Response::make($bind, 200, ['cho-token' => $token]);
    }

    private function isNormalPacket($hexpacket) {
        if ($hexpacket == "04000000000000") {
            return true;
        } else {
            return false;
        }
    }

    private function isBeatmapExitPacket($hexpacket) {
        if ($hexpacket == "0000000E000000000B000B0000000000001F720A00") {
            return true;
        } else {
            return false;
        }
    }

    private function isLogoutPacket($hexpacket) {
        if ($hexpacket == "0200000400000000000000") {
            return true;
        } else {
            return false;
        }
    }

    private function strToHex($string) {
        $hex = '';
        for ($i=0; $i<strlen($string); $i++){
            $ord = ord($string[$i]);
            $hexCode = dechex($ord);
            $hex .= substr('0'.$hexCode, -2);
        }
        return strToUpper($hex);
    }

    private function generateToken() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 8; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $randomString .= "-";
        for ($i = 0; $i < 4; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $randomString .= "-";
        for ($i = 0; $i < 4; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $randomString .= "-";
        for ($i = 0; $i < 4; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $randomString .= "-";
        for ($i = 0; $i < 12; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
