<?php

namespace App\CentralLogics;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Uservalidation
{
    public function user_icon($id = '')
    {
        if ($id == '') {

            if (Auth::user()) {
                $border = 'border-style:solid;border-color:red;';
                $icon = Auth::user()->name[0];


                $code = dechex(crc32($icon . '' . Auth::user()->name[0] . '' . Auth::user()->id));
                $color = substr($code, 0, 6);

                return '<div  class="userouter_border" style="' . $border . '"><div class="usericon"  style="background:#' . $color . ';" ><puser>' . $icon . '</puser></div></div>';
            }
        } else {
            $user = User::where('id', '=',  $id)->first();

            $border = 'border-style:solid;border-color:red;';

            $icon = $user->name[0];

            $code = dechex(crc32($icon . '' . $user->name[0] . '' . $user->id));
            $color = substr($code, 0, 6);

            return '<div class="userouter_border"   style="' . $border . '" ><div class="usericon"  style="background:#' . $color . ';" ><puser>' . $icon . '</puser></div></div>';
        }
    }
}
