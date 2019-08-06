<div>
<a href="{{ route('top') }}">Home</a>
@if($auth)
<a href="{{ route('logout') }}">ログアウト</a>
@else
<a href="{{ route('github_login') }}">ログイン</a>
@endif
<a href="{{ route('form') }}">投稿</a>
</div>

<div>
{{ $user_info->github_id }}
</div>

<div>
<img src=" https://github.com/{{{ $user_info->github_id }}}.png ">
</div>

<div>
@isset($images)
    @foreach ($images as $image)
    <div>
        <div>
            <!-- <img src="{{ asset('storage/' . basename($image->img)) }}"> -->
            <img src="data:image/png;base64,<?= $image->image ?>">
            <p>{{ $image->comment}}</p>
        </div>
    </div>
    @endforeach
@endisset
<div>
