@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong>
        大哥,我的好大哥,出错啦,数据是必须填写的呦！<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
