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
        $auth_id = Auth::id();
        // foreach($images as $image) {
        //         $image_user_id = $image->likes;
        //         // dd(empty($image_user_id));
        // }
        // dd($image_user_id);
        // dd(empty($image_user_id));
        //dd($auth_status);
        return view('home', compact('images', 'auth', 'auth_id'));
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
            // $likes = Image::find(2)->likes;
            // dd($likes);
            // foreach($likes as $like) {
            //     dd($like);
            // }
            $auth_id = Auth::id();
            return view('home', compact('images', 'auth', 'auth_id'));
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
        $auth = Auth::check();
        if(!$auth) {
            return view('loginform');
        }
        return view('form', compact('auth'));
    }

    //ユーザー詳細ページ
    public function profile($id) {
        $auth = Auth::check();
        $images = Image::where('user_id', $id)->get();
        $image_count = $images->count();
        $user_info = User::find($id);

        return view('profile', compact('images', 'user_info', 'auth', 'image_count'));
    }

    //いいね機能
    public function like($id){
        $auth = Auth::check();
        if(!$auth) {
            return view('loginform');
        }

        $auth_id = Auth::id();
        $user_github_id = User::where('id', $auth_id)->first()->github_id;
        
        $like = Like::where('user_id', Auth::id())->where('image_id', $id)->first();
        if (!empty($like)) {
            if ($like->image_flg) {
                Like::where('user_id', Auth::id())->where('image_id', $id)->update(['image_flg' => 0]);
            } else {
                Like::where('user_id', Auth::id())->where('image_id', $id)->update(['image_flg' => 1]);
            }
        } else {
            Like::insert(['user_id' => Auth::id(), 'image_id' => $id, 'image_flg' => 1, 'github_id' => $user_github_id]);
        }

        $images = Image::get();
        $auth_status = Auth::check();
        $auth_id = Auth::id();
        //dd($auth_status);
        return view('home', compact('images', 'auth', 'auth_id'));
    }

    //いいねした人一覧
    public function liker($id) {
        $auth = Auth::check();
        $likers = Like::where('image_id', $id)->where('image_flg', 1)->get();
        return view('likers', compact('likers', 'auth'));
    }
}
