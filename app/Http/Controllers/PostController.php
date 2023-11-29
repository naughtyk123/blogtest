<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cat = Category::get();
        $sit_data = [
            'title' => 'Create Post',
            'cats' => $cat
        ];

        return view('frontend.create_post', $sit_data);
    }


    public function add_post_record(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'post_text' => 'required',
            'cat' => 'required',
            'images' => 'image',
        ], [
            'title.required' => 'Required please enter a tittle!',
            'post_text.required' => 'Required please enter a post!',
            'cat.required' => 'Required please select a categorie!',
            'images.image' => 'Not an image!',


        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => 'errors',
                'error' => $validator->errors()->toArray()
            ]);
        }




        $result = Post::create([
            'title' => $request->title,
            'post' => $request->post_text,
            'user_id' => Auth::user()->id,
            'categorie_id' => $request->cat,

        ]);
        if ($request->hasfile('images') && $result) {

            $file = $request->file('images');
            $path = $file->store('public/posts');
            $name = $file->getClientOriginalName();
            $upload_image_name = uniqid() . '-img.' . $file->extension();


            $moved = $file->move(public_path('posts/' . Auth::user()->id . '/'), $upload_image_name);
            $name_withpath = 'posts/' . Auth::user()->id . '/' . $upload_image_name;
            $result = PostImage::create([
                'path' => $name_withpath,
                'post_id' => $result->id,
            ]);
        }


        if ($result) {
            return response()->json([
                'status' => 'true',
                'message' => 'Post added',
            ]);
        } else {
            return response()->json([
                'status' => 'false',
                'message' => 'Some thing Wrong',

            ]);
        }
    }

    public function delete_post(Request $request)
    {



        $post = Post::where('id', '=', $request->id)->where('user_id', '=', Auth::user()->id)->first();
        $image = PostImage::where('post_id', '=', $post->id)->first();


        if ($image) {
            @unlink($image->path);
            $deteted_img = PostImage::where('id', '=', $image->id)->delete();
        }
        if ($post) {
            $deteted = Post::where('id', '=', $request->id)->delete();
        } else {

            return response()->json([
                'status' => 'false',
                'message' => 'Some thing Wrong',

            ]);
        }

        if ($deteted) {
            return response()->json([
                'status' => 'true',
                'message' => 'Deleted',

            ]);
        } else {

            return response()->json([
                'status' => 'false',
                'message' => 'Some thing Wrong',

            ]);
        }
    }


    public function edite(Request $request)
    {
        $cats = Category::get();
        $post = Post::where('id', '=', $request->id)->where('user_id', '=', Auth::user()->id)->first();
        $sit_data = [
            'title' => 'Edite Post',
            'post' => $post,
            'cats' => $cats
        ];
        if ($post) {
            return view('frontend.edite_post', $sit_data);
        } else {
            return redirect('/');
        }
    }

    public function edite_post_record(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'post_text' => 'required',
            'cat' => 'required',
            'images' => 'image',
        ], [
            'title.required' => 'Required please enter a tittle!',
            'post_text.required' => 'Required please enter a post!',
            'cat.required' => 'Required please select a categorie!',
            'images.image' => 'Not an image!',


        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => 'errors',
                'error' => $validator->errors()->toArray()
            ]);
        }




        $result = Post::where('id', '=', $request->id)->where('user_id', '=', Auth::user()->id)->update([
            'title' => $request->title,
            'post' => $request->post_text,
            'user_id' => Auth::user()->id,
            'categorie_id' => $request->cat,

        ]);

        if ($request->hasfile('images') && $result) {

            $image = PostImage::where('post_id', '=', $request->id)->first();


            if ($image) {
                @unlink($image->path);
                $deteted_img = PostImage::where('id', '=', $image->id)->delete();
            }

            $file = $request->file('images');
            $path = $file->store('public/posts');
            $name = $file->getClientOriginalName();
            $upload_image_name = uniqid() . '-img.' . $file->extension();


            $moved = $file->move(public_path('posts/' . Auth::user()->id . '/'), $upload_image_name);
            $name_withpath = 'posts/' . Auth::user()->id . '/' . $upload_image_name;

            $result = PostImage::create([
                'path' => $name_withpath,
                'post_id' => $request->id,
            ]);
        }

        if ($result) {
            return response()->json([
                'status' => 'true',
                'message' => 'Post added',
            ]);
        } else {
            return response()->json([
                'status' => 'false',
                'message' => 'Some thing Wrong',

            ]);
        }
    }


    public function my_posts()
    {
        $posts = Post::latest()->paginate(6);
        $sit_data = [
            'title' => 'My Posts',
            'posts' => $posts,

        ];

        return view('frontend.my_posts', $sit_data);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
