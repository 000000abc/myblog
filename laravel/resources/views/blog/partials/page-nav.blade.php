{{-- Navigation --}}
<script type="text/javascript"  charset="utf-8"
        src="http://connect.qq.com/qc_jssdk.js"
        data-appid="102023970"
        data-redirecturi="http://liwanyi521.top/login">
</script>
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        {{-- Brand and toggle get grouped for better mobile display --}}
        <a class="navbar-brand" href="/">{{ config('blog.name') }}</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            导航菜单
            <i class="fas fa-bars"></i>
        </button>

        {{-- Collect the nav links, forms, and other content for toggling --}}
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/">首页</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/contact">联系我们</a>
                </li>
                <li class="nav-item">
                    <span id="qqLoginBtn">qq登录</span>
                    <script type="text/javascript">
                        QC.Login({
                            btnId:"qqLoginBtn"	//插入按钮的节点id
                        });
                    </script>
                </li>
            </ul>
        </div>
    </div>
</nav>
