<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use App\User;
use App\Like;
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
        $auth = Auth::check();
        $images = Image::get();
        $auth_status = Auth::check();
        //dd($auth_status);
        return view('home', compact('images', 'auth'));
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
            $auth = Auth::check();

            if(!$auth) {
                return view('loginform');
            }
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
            return view('home', compact('images', 'auth'));
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

    //ユーザー詳細ページ
    public function profile($id) {
        $images = Image::where('user_id', $id)->get();
        $user_info = User::find($id);

        return view('profile', compact('images', 'user_info'));
    }

    //いいね機能
    public function like($id){
        $auth = Auth::check();
        if(!$auth) {
            return view('loginform');
        }
        $like = Like::where('user_id', Auth::id())->where('image_id', $id)->first();
        if (!empty($like)) {
            if ($like->flg) {
                Like::where('user_id', Auth::id())->where('image_id', $id)->update(['flg' => 0]);
            } else {
                Like::where('user_id', Auth::id())->where('image_id', $id)->update(['flg' => 1]);
            }
        } else {
            Like::insert(['user_id' => Auth::id(), 'image_id' => $id, 'image_flg' => 1]);
        }

        $images = Image::get();
        $auth_status = Auth::check();
        //dd($auth_status);
        return view('home', compact('images', 'auth'));
    }

    //いいねした人一覧
    public function liker($id) {
        $likers = Like::where('image_id', $id)->where('image_flg', 1)->get();
        return view('likers', compact('likers'));
    }
}
