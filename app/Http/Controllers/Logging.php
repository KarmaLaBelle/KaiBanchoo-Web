<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use Log;

class Logging extends Controller
{
    public function Metrics(Request $request)
    {
        //{"u":"[Hidekazu]\u0018\u0000\u0001\u0000\u0000\u0000","h":"a35eb0e01a188b05ee366037a16684d2","info":"{\"GlContextAvailable\":true,\"GlVendor\":\"NVIDIA Corporation\",
        //\"GlVersion\":\"4.5.0 NVIDIA 361.43\",\"GlRenderer\":\"GeForce GTX 970\/PCIe\/SSE2\",\"GlShader\":\"4.50 NVIDIA\",\"CanUseFBO\":true,\"CanUseVBO\":true,\"DotNet35\":true,
        //\"DotNet40\":true,\"DotNet45\":true,\"SurfaceType\":\"nv\",\"OS\":\"Microsoft Windows NT 6.3.9600.0\",\"OsuVersion\":\"20151228.3\"}"}
        /*
                Schema::create('metrics', function ($table) {
                    $table->increments('id');
                    $table->string('user',64);
                    $table->boolean('GlContextAvailable');
                    $table->string('GlVendor',64);
                    $table->string('GlVersion',64);
                    $table->string('GlRenderer',64);
                    $table->string('GlShader',64);
                    $table->boolean('CanUseFBO');
                    $table->boolean('CanUseVBO');
                    $table->boolean('DotNet35');
                    $table->boolean('DotNet40');
                    $table->boolean('DotNet45');
                    $table->string('SurfaceType',64);
                    $table->string('OS',64);
                    $table->string('OsuVersion',64);
                });
        */
       $info = json_decode($request->input('info'));
        DB::table('metrics')->insert(
            ['user' => $request->input('u'), 'GlContextAvailable' => $info->GlContextAvailable, 'GlVendor' => $info->GlVendor, 'GlVersion' => $info->GlVersion, 'GlRenderer' => $info->GlRenderer,
            'GlShader' => $info->GlShader, 'CanUseFBO' => $info->CanUseFBO, 'CanUseVBO' => $info->CanUseVBO, 'DotNet35' => $info->DotNet35, 'DotNet40' => $info->DotNet40,
            'DotNet45' => $info->DotNet45, 'SurfaceType' => $info->SurfaceType, 'OS' => $info->OS, 'OsuVersion' => $info->OsuVersion]
        );
        return "";
    }

    public function Error(Request $request)
    {
        return "";
    }
}
