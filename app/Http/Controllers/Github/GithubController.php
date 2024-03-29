<?php

namespace App\Http\Controllers\Github;

use App\Http\Controllers\Controller;
use Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;

class GithubController extends Controller
{
    public function top(Request $request)
    {
        $token = $request->session()->get('github_token', null);

        try {
            $github_user = Socialite::driver('github')->userFromToken($token);
        } catch (\Exception $e) {
            return redirect('login/github');
        }

        // dd($github_user);

        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://api.github.com/user/repos', [
            'headers' => [
                'Authorization' => 'token ' . $token
            ]
        ]);

        //usersテーブルにユーザーのデータが一つもない場合エラー
        // $app_user = DB::select('select * from public.users where github_id = ?', [$github_user->user['login']]);

        // $github_user = Socialite::driver('github')->user();
        $user = User::where(['github_id' => $github_user->nickname])->first();

        $now = date("Y/m/d H:i:s");

        if(empty($user)) {
            $data = ['github_id' => $github_user->user['login'], 'created_at' => $now, 'updated_at' => $now];
            User::insert($data);
            $user = User::where(['github_id' => $github_user->nickname])->first();
        }
        
        $request->session()->put('github_token', $github_user->token);
        Auth::login($user, true);
        // dd(Auth::check());

        return redirect()->route('top');

        // return view('github', [
        //     'user' => $app_user[0],
        //     'nickname' => $github_user->nickname,
        //     'token' => $token,
        //     'repos' => array_map(function($o) {
        //         return $o->name;
        //     }, json_decode($res->getBody()))
        // ]);
    }

    public function createIssue(Request $request)
    {
        $token = $request->session()->get('github_token', null);
        $user = Socialite::driver('github')->userFromToken($token);

        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', 'https://api.github.com/repos/' . $user->user['login'] . '/' . $request->input('repo') . '/issues', [
            'auth' => [$user->user['login'], $token],
            'json' => [
                'title' => $request->input('title'),
                'body' => $request->input('body')
            ]
        ]);

        return view('done', [
            'response' => json_decode($res->getBody())->html_url
        ]);
    }

}