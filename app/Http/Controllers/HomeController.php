<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use App\User;
use Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // dd(Auth::id());
        $images = Image::get();
        $auth_status = Auth::check();
        //dd($auth_status);
        return view('home', compact('images'));
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'image' => [
                // 必須
                'required',
                // アップロードされたファイルであること
                'file',
                // 画像ファイルであること
                'image',
                // MIMEタイプを指定
                'mimes:jpeg,png',
            ]
        ]);

        if ($request->file('image')->isValid([])) {
            // $path = $request->file->store('public');
            // dd(Auth::check());
            $user_id = Auth::id();
            $github_id = User::find($user_id)->github_id;
            $image = base64_encode(file_get_contents($request->image->getRealPath()));
            Image::insert([
                "image" => $image, "user_id" => $user_id, "comment" => $request->comment, "github_id" => $github_id,
            ]);
            $images = Image::get();
            // foreach($images as $image) {
            //     dd($image->comment);
            // }
            // return view('home')->with('filename', basename($path));
            return view('home', compact('images'));
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors();
        }
    }

    //投稿フォーム
    public function form() {
        //ログインしていない場合、ログインページにリダイレクト
        if(!Auth::check()) {
            return view('loginform');
        }
        return view('form');
    }

    public function profile($id) {
        $images = Image::where('user_id', $id)->get();
        $user_info = User::find($id);

        return view('profile', compact('images', 'user_info'));
    }
}
