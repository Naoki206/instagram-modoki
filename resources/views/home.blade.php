<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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
    <div class="menu_container">
        <a href="{{ route('top') }}">Home</a>
        @if($auth)
            <a href="{{ route('logout') }}">ログアウト</a>
        @else
            <a href="{{ route('github_login') }}">ログイン</a>
        @endif
        <a href="{{ route('form') }}">投稿</a>
    </div>
</header>

<div class="container">
<div class="images_container">
@isset($images)
    @foreach ($images as $image)
    <div class="image_container">
        <div>
            <img src=" https://github.com/{{{ $image->github_id }}}.png " class="profile_image">
            <a href="{{ route('profile', ['id' => $image->user_id]) }}">{{ $image->github_id}}</a>
        </div>

        <div>
            <img src="data:image/png;base64,<?= $image->image ?>">
        </div>

        <div>
            @if($auth)
                <a href="{{ route('like', ['id' => $image->id ]) }}">いいね</a>
            @else
                <a href="#">いいね(ログアウト中)</a>
            @endif  
            
            <a href="{{ route('liker', ['id' => $image->id ]) }}">いいねしたユーザー</a>
        </div> 

        <div>
            <!-- <img src="{{ asset('storage/' . basename($image->img)) }}"> -->
            <p>{{ $image->comment}}</p>
        </div>

        
    </div>
    @endforeach
@endisset
</div>
</div>
</body>
</html>
