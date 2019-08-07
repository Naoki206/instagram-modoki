<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>
<body>
<!-- エラーメッセージ。なければ表示しない -->
@if ($errors->any())
<ul>
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>
@endif

<header>
<a href="{{ route('top') }}">Home</a>
@if($auth)
<a href="{{ route('logout') }}">ログアウト</a>
@else
<a href="{{ route('github_login') }}">ログイン</a>
@endif
<a href="{{ route('form') }}">投稿</a>
</header>


<div class="images_container">
@isset($images)
    @foreach ($images as $image)
    <div class="image_container">
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
</div>
</body>
</html>
