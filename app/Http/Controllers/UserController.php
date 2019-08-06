<?php
namespace App\Http\Controllers;
use App\User;
use Auth;

class UserController extends Controller
{
    public function index()
    {
        // データの追加 emailの値はランダムな文字列を使用。「.」で文字列の連結
        $email = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 8) . '@yyyy.com';
        User::insert(['name' => 'yamada taro', 'email' => $email, 'password' => 'xxxxxxxx']);
        // 全データの取り出し
        $users = User::all();
        return view('user', ['users' => $users]);    
    }

    // 投稿された内容を表示するページ
    public function create(Request $request) {

        // 投稿内容の受け取って変数に入れる
        $name = $request->input('name');
        $comment = $request->input('comment');

        // 変数をビューに渡す
        return view('bbs.index')->with([
            "name" => $name,
            "comment"  => $comment,
        ]);
    }

    public function logout() {
        // dd("aaa");
        Auth::logout();
        return redirect()->route("top");
    }
}
