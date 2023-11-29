<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Tinymce extends Controller
{
    public function uploads(Request $request)
    {


        $file = $request->file('file');
        $filename = uniqid() . '.' . $file->extension();
        $file->move(public_path('posts'), $filename);
        $data['image'] = $filename;

        return json_encode(['location' => public_path('posts/' . $filename)]);
    }

    public function remove_tiny_image(Request $request)
    {
      
        $file = explode("/", $request->imageSrc);


        @unlink('posts/' . $file[count($file) - 1]);
    }
}
