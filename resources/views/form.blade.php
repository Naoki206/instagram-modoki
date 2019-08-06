<form action="{{ url('upload') }}" method="POST" enctype="multipart/form-data">

    <!-- アップロードした画像。なければ表示しない -->
    <!-- @isset ($filename)
    <div>
        <img src="{{ asset('storage/' . $filename) }}">
    </div>
    @endisset -->

    <!-- <label for="photo">画像ファイル:</label> -->
    <input type="file" class="form-control" name="image">
    <br>
    <textarea name="comment" rows="4" cols="40"></textarea>
    <hr>
    {{ csrf_field() }}
    <button class="btn btn-success"> 投稿 </button>
</form>