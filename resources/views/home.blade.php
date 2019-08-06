<!-- エラーメッセージ。なければ表示しない -->
@if ($errors->any())
<ul>
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>
@endif

<a href="{{ route('logout') }}">ログアウト</a>
<a href="{{ route('github_login') }}">ログイン</a>
<a href="{{ route('form') }}">投稿</a>


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
