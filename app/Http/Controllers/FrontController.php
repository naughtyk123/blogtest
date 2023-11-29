<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FrontController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(6);
        $categories = Category::get();

        $sit_data = [
            'title' => 'Home',
            'posts' => $posts,
            'categories' => $categories
        ];

        return view('frontend.home', $sit_data);
    }


    public function register()
    {

        $sit_data = [
            'title' => 'Register',

        ];

        return view('frontend.auth.register', $sit_data);
    }

    public function attempt_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'con_password' => 'required|same:password',
            'name' => 'required',
        ], [
            'email.required' => 'Required please enter a email!',
            'email.email' => 'Please enter valid email!',
            'email.unique' => 'Email already exist!',
            'password.required' => 'Required please enter a Pasword!',
            'password.min' => 'Password must be minimum 8 charactors!',
            'con_password.required' => 'Please enter password to confirm!',
            'con_password.same' => 'Pass word not match',
            'name.required' => 'Please enter name!',

        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => 'errors',
                'error' => $validator->errors()->toArray()
            ]);
        }

        $result = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if ($result) {
            return response()->json([
                'status' => 'true',
                'message' => 'Congratulation you are now registerd',
            ]);
        } else {
            return response()->json([
                'status' => 'false',
                'message' => 'Some thing Wrong',

            ]);
        }
    }

    public function login()
    {

        $sit_data = [
            'title' => 'Login',

        ];

        return view('frontend.auth.login', $sit_data);
    }

    public function attempt_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',

        ], [
            'email.required' => 'Required please enter a email!',
            'email.email' => 'Please enter valid email!',
            'password.required' => 'Required please enter a Pasword!',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => 'errors',
                'error' => $validator->errors()->toArray()
            ]);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            return response()->json([
                'status' => 'true',
                'message' => 'Congratulation',
            ]);
        } else {

            return response()->json([
                'status' => 'false',
                'message' => 'Some thing Wrong',

            ]);
        }
    }

    public function reade_more(Request $request)
    {


        $post = Post::where('id', '=', $request->id)->first();
        $posts = Post::where('categorie_id', '=', $post->categorie_id)->where('id', '!=', $post->id)->latest()->paginate(6);


        $sit_data = [
            'title' => $post->title,
            'post' => $post,
            'posts' => $posts


        ];

        return view('frontend.read_more', $sit_data);
    }

    public function get_search_result(Request $request)
    {

        $posts = Post::select('*');

        if ($request->key != '') {
            $posts = $posts->where('title', 'like', "%{$request->key}%");
        }
        if ($request->cat != 0) {
            $posts = $posts->where('categorie_id', '=', $request->cat);
        }

        $posts = $posts->latest()->paginate(6);

        $sit_data = [
            'title' => 'posts',
            'posts' => $posts
        ];
        return view('frontend.post_card', $sit_data)->render();
    }
}
