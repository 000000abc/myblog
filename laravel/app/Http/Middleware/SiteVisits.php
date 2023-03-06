<?php

namespace App\Http\Middleware;

use App\Services\VisitantService;
use Closure;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
class SiteVisits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $slug=$request->path();//获取路由
        $slug=strrchr($slug, "/");//获取路由字符串
        //给第一个字符串设置为空 （去除第一个字符串）
        $slug = substr($slug, 1);
        Redis::incr('view_post'.$slug);
        VisitantService::addPosition($slug);
        return $next($request);
    }
}



