<a href="{{ route('logout') }}">ログアウト</a>
<a href="{{ route('github_login') }}">ログイン</a>
<a href="{{ route('form') }}">投稿</a>

@if(!empty($likers))
@foreach($likers as $liker)
{{ $liker }}
@endforeach
@endif