<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/formstyle.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.1/css/all.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.1/css/v4-shims.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>

<header>
    <div class="menu_container">
        <a href="{{ route('top') }}" class="fas fa-home" id="a">ホーム</a>
        <a href="{{ route('form') }}" class="fas fa-camera" id="a">投稿</a>
        @if($auth)
            <a href="{{ route('logout') }}" class="fas fa-sign-out-alt" id="a">ログアウト</a>
        @else
            <a href="{{ route('github_login') }}" class="fas fa-sign-in-alt" id="a">ログイン</a>
        @endif
    </div>
</header>

<div class="formcontainer">
    <form action="{{ url('upload') }}" method="POST" enctype="multipart/form-data">
        <input type="file" class="form-control" name="image" id="file">
        <br>
        <textarea name="comment" rows="4" cols="40"></textarea>
        <hr>
        {{ csrf_field() }}
        <button class="btn btn-light">投稿</button>
    </form>
</div>
</body>
</html>