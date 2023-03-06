@extends('blog.layouts.master')
<script src="https://www.asessin.com/js/dl.js" type="text/javascript"></script>
{{--<div id="wp"class="wp"><div class="xnkl"><div class="deng-box2"><div class="deng"><div class="xian"></div><div class="deng-a"><div class="deng-b"><div class="deng-t">度</div></div></div><div class="shui shui-a"><div class="shui-c"></div><div class="shui-b"></div></div></div></div><div class="deng-box3"><div class="deng"><div class="xian"></div><div class="deng-a"><div class="deng-b"><div class="deng-t">欢</div></div></div><div class="shui shui-a"><div class="shui-c"></div><div class="shui-b"></div></div></div></div><div class="deng-box1"><div class="deng"><div class="xian"></div><div class="deng-a"><div class="deng-b"><div class="deng-t">春</div></div></div><div class="shui shui-a"><div class="shui-c"></div><div class="shui-b"></div></div></div></div><div class="deng-box"><div class="deng"><div class="xian"></div><div class="deng-a"><div class="deng-b"><div class="deng-t">新</div></div></div><div class="shui shui-a"><div class="shui-c"></div><div class="shui-b"></div></div></div></div></div>--}}
{{--    <style type="text/css">--}}

{{--        .ct2 .mn {width:770px;}--}}

{{--        .ct2 .sd {width:218px;}--}}

{{--        @media screen and (max-width:768px) {.xnkl {display:none;}--}}

{{--        }--}}

{{--        .deng-box {position:fixed;top:-40px;right:150px;z-index:9999;pointer-events:none;}--}}

{{--        .deng-box1 {position:fixed;top:-30px;right:10px;z-index:9999;pointer-events:none}--}}

{{--        .deng-box2 {position:fixed;top:-40px;left:150px;z-index:9999;pointer-events:none}--}}

{{--        .deng-box3 {position:fixed;top:-30px;left:10px;z-index:9999;pointer-events:none}--}}

{{--        .deng-box1 .deng,.deng-box3 .deng {position:relative;width:120px;height:90px;margin:50px;background:#d8000f;background:rgba(216,0,15,.8);border-radius:50% 50%;-webkit-transform-origin:50% -100px;-webkit-animation:swing 5s infinite ease-in-out;box-shadow:-5px 5px 30px 4px #fc903d}--}}

{{--        .deng {position:relative;width:120px;height:90px;margin:50px;background:#d8000f;background:rgba(216,0,15,.8);border-radius:50% 50%;-webkit-transform-origin:50% -100px;-webkit-animation:swing 3s infinite ease-in-out;box-shadow:-5px 5px 50px 4px #fa6c00}--}}

{{--        .deng-a {width:100px;height:90px;background:#d8000f;background:rgba(216,0,15,.1);margin:12px 8px 8px 8px;border-radius:50% 50%;border:2px solid #dc8f03}--}}

{{--        .deng-b {width:45px;height:90px;background:#d8000f;background:rgba(216,0,15,.1);margin:-4px 8px 8px 26px;border-radius:50% 50%;border:2px solid #dc8f03}--}}

{{--        .xian {position:absolute;top:-20px;left:60px;width:2px;height:20px;background:#dc8f03}--}}

{{--        .shui-a {position:relative;width:5px;height:20px;margin:-5px 0 0 59px;-webkit-animation:swing 4s infinite ease-in-out;-webkit-transform-origin:50% -45px;background:orange;border-radius:0 0 5px 5px}--}}

{{--        .shui-b {position:absolute;top:14px;left:-2px;width:10px;height:10px;background:#dc8f03;border-radius:50%}--}}

{{--        .shui-c {position:absolute;top:18px;left:-2px;width:10px;height:35px;background:orange;border-radius:0 0 0 5px}--}}

{{--        .deng:before {position:absolute;top:-7px;left:29px;height:12px;width:60px;content:" ";display:block;z-index:999;border-radius:5px 5px 0 0;border:solid 1px #dc8f03;background:orange;background:linear-gradient(to right,#dc8f03,orange,#dc8f03,orange,#dc8f03)}--}}

{{--        .deng:after {position:absolute;bottom:-7px;left:10px;height:12px;width:60px;content:" ";display:block;margin-left:20px;border-radius:0 0 5px 5px;border:solid 1px #dc8f03;background:orange;background:linear-gradient(to right,#dc8f03,orange,#dc8f03,orange,#dc8f03)}--}}

{{--        .deng-t {font-family:黑体,Arial,Lucida Grande,Tahoma,sans-serif;font-size:3.2rem;color:#dc8f03;font-weight:700;line-height:85px;text-align:center}--}}

{{--        .night .deng-box,.night .deng-box1,.night .deng-t {background:0 0!important}--}}

{{--        @-moz-keyframes swing {0% {-moz-transform:rotate(-10deg)}--}}

{{--            50% {-moz-transform:rotate(10deg)}--}}

{{--            100% {-moz-transform:rotate(-10deg)}--}}

{{--        @-webkit-keyframes swing {0% {-webkit-transform:rotate(-10deg)}--}}

{{--            50% {-webkit-transform:rotate(10deg)}--}}

{{--            100% {-webkit-transform:rotate(-10deg)}--}}

{{--    </style>--}}
<style>
    .lefter-words {
        color: #3495e3;
    }
    .words{
        margin-left: 3rem;
        /*background: red;*/
        width: 20rem;
        height: 10rem;
        position: absolute;
        /*margin-top: 100px;*/
    }
    .dateData{
        margin-left: 3rem;
        /*background: #bf5329;*/
        width: 20rem;
        height: 10rem;
        position: absolute;
        margin-top: 90px;
    }

</style>

@section('page-lefter')
    <div class="words">
        <h4>每日一言</h4>
        <div  class="lefter-words">{{$words}}</div>
    </div>
    <div class="dateData">
        <h5>今日日期:{{$today}}</h5>
        <div  >今年已过{{$getDayOfYear}}，还剩{{$getDaysLeftInYear}} 加油！</div>
    </div>
@stop
@section('page-header')
    <header class="masthead" style="background-image: url('{{ page_image($page_image) }}')">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="site-heading">
                        <h1>{{ $title }}</h1>
                        <span class="subheading">{{ $subtitle }}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                {{-- 文章列表 --}}
                @foreach ($posts as $post)
                    <div class="post-preview">
                        <a href="{{ $post->url($tag) }}">
                            <h2 class="post-title">{{ $post->title }}</h2>
                            @if ($post->subtitle)
                                <h3 class="post-subtitle">{{ $post->subtitle }}</h3>
                            @endif
                        </a>
                        <p class="post-meta">
                            Posted on {{ $post->published_at->format('Y-m-d') }}
                            @if ($post->tags->count())
                                in
                                {!! join(', ', $post->tagLinks()) !!}
                            @endif
                        </p>
                    </div>
                    <hr>
                @endforeach

                {{-- 分页 --}}
                <div class="clearfix">
                    {{-- Reverse direction --}}
                    @if ($reverse_direction)
                        @if ($posts->currentPage() > 1)
                            <a class="btn btn-primary float-left" href="{!! $posts->url($posts->currentPage() - 1) !!}">
                                ←
                                Previous {{ $tag->tag }} Posts
                            </a>
                        @endif
                        @if ($posts->hasMorePages())
                            <a class="btn btn-primary float-right" href="{!! $posts->nextPageUrl() !!}">
                                Next {{ $tag->tag }} Posts
                                →
                            </a>
                        @endif
                    @else
                        @if ($posts->currentPage() > 1)
                            <a class="btn btn-primary float-left" href="{!! $posts->url($posts->currentPage() - 1) !!}">
                                ←
                                Newer {{ $tag ? $tag->tag : '' }} Posts
                            </a>
                        @endif
                        @if ($posts->hasMorePages())
                            <a class="btn btn-primary float-right" href="{!! $posts->nextPageUrl() !!}">
                                Older {{ $tag ? $tag->tag : '' }} Posts
                                →
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
