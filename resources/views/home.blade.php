<!-- エラーメッセージ。なければ表示しない -->
@if ($errors->any())
<ul>
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>
@endif

<!-- フォーム -->
<form action="{{ url('upload') }}" method="POST" enctype="multipart/form-data">

    <!-- アップロードした画像。なければ表示しない -->
    <!-- @isset ($filename)
    <div>
        <img src="{{ asset('storage/' . $filename) }}">
    </div>
    @endisset -->

    @isset($images)
    @foreach ($images as $image)
    <div>
        <!-- <img src="{{ asset('storage/' . basename($image->img)) }}"> -->
        <img src="data:image/png;base64,<?= $image->image ?>">
        <p>{{ $image->comment}}</p>
    </div>
    @endforeach
    @endisset

    <!-- <label for="photo">画像ファイル:</label> -->
    <input type="file" class="form-control" name="image">
    <br>
    <textarea name="comment" rows="4" cols="40"></textarea>
    <hr>
    {{ csrf_field() }}
    <button class="btn btn-success"> 投稿 </button>
</form>
<a href="{{ route('logout') }}">ログアウト</a>
<a href="{{ route('github_login') }}">ログイン</a>
