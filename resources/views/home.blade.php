<!-- エラーメッセージ。なければ表示しない -->
@if ($errors->any())
<ul>
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>
@endif

<a href="{{ route('top') }}">Home</a>
@if($auth)
<a href="{{ route('logout') }}">ログアウト</a>
@else
<a href="{{ route('github_login') }}">ログイン</a>
@endif
<a href="{{ route('form') }}">投稿</a>


@isset($images)
    @foreach ($images as $image)
    <div>
        <div>
            <a href="{{ route('profile', ['id' => $image->user_id]) }}">{{ $image->github_id}}</a>
        </div>

        <div>
            <!-- <img src="{{ asset('storage/' . basename($image->img)) }}"> -->
            <img src="data:image/png;base64,<?= $image->image ?>">
            <p>{{ $image->comment}}</p>
        </div>

        <div>
        @if($auth)
            <a href="{{ route('like', ['id' => $image->id ]) }}">いいね</a>
        @else
            <a href="#">いいね(ログアウト中)</a>
        @endif  
        </div>
        <div>
            <a href="{{ route('liker', ['id' => $image->id ]) }}">いいねしたユーザー</a>
        </div>
    </div>
    @endforeach
@endisset
