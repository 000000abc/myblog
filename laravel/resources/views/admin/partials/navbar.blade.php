<ul class="navbar-nav mr-auto">
    <li class="nav-item"><a class="nav-link" href="/">首页</a></li>
    @auth
        <li @if (Request::is('admin/post*')) class="nav-item active" @else class="nav-item" @endif>
            <a class="nav-link" href="/admin/post">文章</a>
        </li>
        <li @if (Request::is('admin/tag*')) class="nav-item active" @else class="nav-item" @endif>
            <a class="nav-link" href="/admin/tag">标签</a>
        </li>
        <li @if (Request::is('admin/upload*')) class="nav-item active" @else class="nav-item" @endif>
            <a class="nav-link" href="/admin/upload">上传</a>
        </li>
        <li @if (Request::is('admin/export*')) class="nav-item active" @else class="nav-item" @endif>
            <a class="nav-link" href="/excel/export">导出</a>
        </li>
        <li  class="nav-item active">
            @if(app()->environment('local'))
                <form method="post" action="/excel/import" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="file" name="file" />
                    <input type="submit"/>
                </form>
            @endif

{{--            <a onclick="uploadFile2();" id="img" style="cursor: pointer; display: inline-block;background-color: aqua">JQuery-Ajax上传</a>--}}
        </li>

    @endauth
</ul>
{{--composer require 'itbdw/ip-database' ^3.0--}}
{{--composer require itbdw/ip-database ^2.0--}}

<ul class="navbar-nav ml-auto">
    @guest
        <li class="nav-item"><a class="nav-link" href="/login">登录</a></li>
    @else
        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
               aria-expanded="false">
                {{ Auth::user()->name }}
                <span class="caret"></span>
            </a>
            <div class="dropdown-menu" role="menu">
                <a class="dropdown-item" href="/logout">退出</a>
            </div>

        </li>
    @endguest
</ul>
<script>

    // function uploadFile2() {
    //     var fileobj = $("#img")[0].files[0];
    //     console.log(fileobj);
    //     var form = new FormData();
    //     form.append("img", fileobj);
    //     form.append("uesr", 'alex');
    //     $.ajax({
    //         type: 'POST',
    //         url: '/upload/',
    //         data: form,
    //         processData: false,
    //     contentType: false,
    //     success: function (arg) {
    //         console.log(arg)
    //     }
    // })
    // }
</script>
<script type="text/javascript"  charset="utf-8"
        src="http://connect.qq.com/qc_jssdk.js"
        data-appid="102023970"
        data-redirecturi="http://liwanyi521.top/admin">
</script>

