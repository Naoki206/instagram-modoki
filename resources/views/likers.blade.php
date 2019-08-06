<div>
<a href="{{ route('top') }}">Home</a>
@if($auth)
<a href="{{ route('logout') }}">ログアウト</a>
@else
<a href="{{ route('github_login') }}">ログイン</a>
@endif
<a href="{{ route('form') }}">投稿</a>
</div>


@if(!empty($likers))
@foreach($likers as $liker)
{{ $liker->github_id }}
@endforeach
@endif