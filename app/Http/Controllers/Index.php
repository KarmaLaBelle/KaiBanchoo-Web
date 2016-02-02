<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Log;
use Cache;
use Auth;
use Response;

class Index extends Controller
{
    public function getIndex(Request $request)
    {
        return view('welcome');
    }

    public function postIndex(Request $request)
    {
        $osutoken = $request->header('osu-token');
        //Is it a login request?
        if(!isset($osutoken))
        {
            $content = explode("\n", $request->getContent());
            $extraData = explode("|", $content[2]);
            return $this->loginFunction($content[0], $content[1], $extraData[0]);
        }
        $user = Cache::get($osutoken);
        Cache::add($osutoken, $user, 10);
        $body = $request->getContent();
        $asciiarray = unpack('C*', $body);
        Log::info($asciiarray);
        Log::info(sprintf("PACKET: %s", implode(array_map("chr", $asciiarray))));
        $output = $this->checkPacket($asciiarray, $user, $osutoken);
        return $output;
    }

    function checkPacket($data, $user, $osutoken)
    {
        switch($data[1])
        {
            case 1: //Chat message
                $message = array();
                foreach (array_slice($data, 11) as $item)
                {
                    if($item == 11)
                    {
                        break;
                    }
                    array_push($message, $item);
                }
                $channel = array();
                foreach (array_slice($data, 11+count($message)+2) as $item)
                {
                    if($item == 0)
                    {
                        break;
                    }
                    array_push($channel, $item);
                }
                $output = array_merge(
                    $this->CreatePacket(07, array($user->name, implode(array_map("chr", $message)), implode(array_map("chr", $channel)), $user->id))
                );
                break;
            case 2: //Logout packet
                Cache::forget($osutoken);
                break;
            case 4: //Default update (Need to work on this)
                $output = array();
                break;
            case 68: //Join channel?
                if(array_slice($data, -4)[1] == 35)
                {
                    $output = array_merge(
                        $this->CreatePacket(64, implode(array_map("chr", array_slice($data, -4))))
                    );
                } else {
                    $output = array();
                }
                break;
            case 85: //PM
                $output = array();
                break;
            default:
                $output = array();
                break;
        }
        return implode(array_map("chr", $output));
    }

    function loginFunction($username, $hash, $version)
    {
        if(Auth::attempt(['name' => $username, 'password' => $hash])) {
            $user = Auth::user();
            Log::info($username . " has logged in");
            $output = array_merge(
                $this->CreatePacket(92, $user->bantime),	//ban status/time
                $this->CreatePacket(5, $user->id),	//user id
                $this->CreatePacket(75, 19),	//bancho protocol version
                $this->CreatePacket(71, $user->usergroup),	//user rank (supporter etc)
                $this->CreatePacket(72, array(3, 4)),	//friend list
                $this->CreatePacket(83, array(	//local player
                    'id' => $user->id,
                    'playerName' => $user->name,
                    'utcOffset' => 0 + 24,
                    'country' => $user->country,
                    'playerRank' => 0,
                    'longitude' => 0,
                    'latitude' => 0,
                    'globalRank' => 0,
                )),
                $this->CreatePacket(11, array(		//more local player data
                    'id' => $user->id,
                    'bStatus' => 0,		//byte
                    'string0' => '',	//String
                    'string1' => '',	//string
                    'mods' => 0,		//int
                    'playmode' => 0,	//byte
                    'int0' => 0,		//int
                    'score' => $user->total_score,			//long 	score
                    'accuracy' => $user->accuracy,	//float accuracy
                    'playcount' => 0,			//int playcount
                    'experience' => 0,			//long 	experience
                    'int1' => 0,	//int 	global rank?
                    'pp' => $user->pp_raw,			//short	pp 				if set, will use?
                )),
                $this->CreatePacket(83, array(	//bancho bob
                    'id' => 3,
                    'playerName' => 'KaiBanchoo',
                    'utcOffset' => 0 + 24,
                    'country' => 1,
                    'playerRank' => 0,
                    'longitude' => 0,
                    'latitude' => 0,
                    'globalRank' => 0,
                )),
                $this->CreatePacket(96, array(0, $user->id)),	//TODO: list of players
                $this->CreatePacket(89, null),
                //foreach player online, packet 12 or 95
                $this->CreatePacket(64, '#osu'),	//main channel
                $this->CreatePacket(64, '#news'),
                $this->CreatePacket(65, array('#osu', 'Main channel', 2147483647 - 1)),	//secondary channel
                $this->CreatePacket(65, array('#news', 'This will contain announcements and info, while beta lasts.', 1)),
                $this->CreatePacket(65, array('#kfc', 'Kawaii friends club', 0)),	//secondary channel
                $this->CreatePacket(65, array('#aqn', 'cuz fuck yeah', 1337)),
                $this->CreatePacket(07, array('KaiBanchoo', 'This is a test message! First step to getting chat working!', '#osu', 3))
            );
            $token = $this->generateToken();
            Cache::put($token, $user, 10);

            return Response::make(implode(array_map("chr", $output)), 200, ['cho-token' => $token]);
        } else {
            Log::info($username . " has failed to logged in");
        }
        return '';
    }

    function ConvertPlayer($player) {
        return array(
            'id' => $player['id'],
            'playerName' => $player['username'],
            'utcOffset' => 0 + 24,
            'country' => 1,
            'playerRank' => $player['status'],
            'longitude' => 0,
            'latitude' => 0,
            'globalRank' => 0,
        );
    }

    function DieError($err) {
        die(implode(array_map("chr", $this->CreatePacket(5, $err))));
    }

    function generateToken() {
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

    function GetLongBytes($long) {
        $value = $long;
        $highMap = 0xffffffff00000000;
        $lowMap = 0x00000000ffffffff;
        $higher = ($value & $highMap) >>32;
        $lower = $value & $lowMap;
        $packed = pack('NN', $higher, $lower);
        return array_reverse(unpack('C*', $packed));
    }

    function ULeb128($string) {	//TODO: use proper ULEB128
        if ($string == '') return array(0);
        $toreturn = array();
        $toreturn = array_merge(
            array(11, strlen($string)),
            unpack('C*', $string));
        //var_dump($toreturn);
        return $toreturn;
    }

    function CreatePacket($type, $data = null) {
        $toreturn = '';
        $length = 0;
        switch ($type) {
            //string
            case 24:	//show custom, orange notification
            case 64:	//Main channel
            case 66:	//remove channel?
            case 105:	//show scary msg
                $toreturn = $this->ULeb128($data);
                break;
            //empty
            case 23:
            case 50:	//something with match-confirm
            case 59:	//something with chat channels?
            case 80:	//Sneaky Shizzle
                $toreturn = array();
                break;
            //Class17 (player data 02)
            case 83:	//local player
                $toreturn = array();
                $toreturn = array_merge(
                    unpack('C*', pack('L*', $data['id'])),
                    $this->ULeb128($data['playerName']),				//TODO: fix names
                    unpack('C*', pack('C*', $data['utcOffset'])),
                    unpack('C*', pack('C*', $data['country'])),
                    unpack('C*', pack('C*', $data['playerRank'])),
                    unpack('C*', pack('f*', $data['longitude'])),
                    unpack('C*', pack('f*', $data['latitude'])),
                    unpack('C*', pack('L*', $data['globalRank']))
                );
                break;
            //Class19 (player data 01)
            case 11:	//some player thing
                $toreturn = array_merge(
                    unpack('C*', pack('L*', $data['id'])),
                    unpack('C*', pack('C*', $data['bStatus'])),
                    $this->ULeb128($data['string0']),
                    $this->ULeb128($data['string1']),
                    unpack('C*', pack('L*', $data['mods'])),
                    unpack('C*', pack('C*', $data['playmode'])),
                    unpack('C*', pack('L*', $data['int0'])),
                    $this->GetLongBytes($data['score']),
                    unpack('C*', pack('f*', $data['accuracy'])),
                    unpack('C*', pack('L*', $data['playcount'])),
                    $this->GetLongBytes($data['experience']),
                    unpack('C*', pack('L*', $data['int1'])),
                    unpack('C*', pack('S*', $data['pp']))
                );
                break;
            //Class20 (string, string, short)
            case 65: 	//chat channel with title
                $toreturn = array_merge(
                    $this->ULeb128($data[0]),
                    $this->ULeb128($data[1]),
                    unpack('C*', pack('S*', $data[2]))
                );
                break;
            //chat Message
            case 07:
                $toreturn = array_merge(
                    $this->ULeb128($data[0]),
                    $this->ULeb128($data[1]),
                    $this->ULeb128($data[2]),
                    unpack('C*', pack('I', $data[3]))
                );
                break;
            //int[] (short length, int[length])
            case 72:	//friend list, int[]
            case 96:	//list of online players
                $l1 = unpack('C*', pack('S', sizeof($data)));
                $toreturn = array();
                foreach ($data as $key => $value) {
                    $toreturn = array_merge($toreturn, unpack('C*', pack('I', $value)) );
                }
                $toreturn = array_merge($l1, $toreturn);
                break;
            //int32
            case 5:		//user id
            case 71:	//user rank
            case 75: 	//cho protocol
            case 92:	//ban status
            default:
                $toreturn = unpack('C*', pack('L*', $data));
                break;
        }

        return array_merge(
            unpack('S*', pack("L*", $type)),			//type
            array(0),									//unused byte
            unpack('C*', pack('L', sizeof($toreturn))),	//length
            $toreturn									//data
        );
    }
}
