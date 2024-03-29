<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;// 追加！
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * GitHubの認証ページヘユーザーをリダイレクト
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()// 追加！
    {
        return Socialite::driver('github')->scopes(['read:user', 'public_repo'])->redirect(); 
    }

    /**
     * GitHubからユーザー情報を取得
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request)
    {
        $github_user = Socialite::driver('github')->user();

        $now = date("Y/m/d H:i:s");
        // $app_user = DB::select('select * from public.users where github_id = ?', [$github_user->user['login']]);
        $user = User::where(['github_id' => $github_user->nickname])->first();
        
        if (empty($user)) {
            $data = ['github_id' => $github_user->user['login'], 'created_at' => $now, 'updated_at' => $now];
            User::insert($data);
            $user = User::where(['github_id' => $github_user->nickname])->first();
        }

        $request->session()->put('github_token', $github_user->token);

        Auth::login($user, true);
        
        return redirect('github');
    }
}