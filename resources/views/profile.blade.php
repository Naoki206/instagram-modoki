<div>
<a href="{{ route('logout') }}">ログアウト</a>
<a href="{{ route('github_login') }}">ログイン</a>
<a href="{{ route('form') }}">投稿</a>
</div>

<div>
{{ $user_info->github_id }}
</div>

<div>
@isset($images)
    @foreach ($images as $image)
    <div>
        <div>
            <a href="#">{{ $image->github_id}}</a>
        </div>

        <div>
            <!-- <img src="{{ asset('storage/' . basename($image->img)) }}"> -->
            <img src="data:image/png;base64,<?= $image->image ?>">
            <p>{{ $image->comment}}</p>
        </div>
    </div>
    @endforeach
@endisset
<div>
