<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Words;
use App\Services\PostService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $tag = $request->get('tag');
        $postService = new PostService($tag);
        $data = $postService->lists();
        $words = Words::query()->where('status', 0)->orderBy('id', 'desc')->first(['content', 'id']) ?? [];
        $redis = Redis::connection();
        if ($words) {
            if ($redis->get('words_content_expire' . $words['id'])) {
                $new_words['content'] = $words['content'];
            } else {
                Words::query()->where('id', $words['id'])->update(['status' => 1]);
                $words = Words::query()->where('status', 0)->orderBy('id', 'desc')->first(['content', 'id']) ?? [];
                $redis->setex('words_content_expire' . $words['id'], 24 * 60 * 60, $words['id']);
                $new_words['content'] = $words['content'];
            }
        }
        //设置键的过期时间
        $layout = $tag ? Tag::layout($tag) : 'blog.layouts.index';
        $data['words'] = $new_words['content'] ?? ['数据为空'];
        $newData = [
            'today' => get_today_date(),
            'getDayOfYear' => getDayOfYear(),
            'getDaysLeftInYear' => getDaysLeftInYear(),
        ];
        $data=array_merge($data,$newData);
        return view($layout, $data);
    }

    /**
     * @param $slug
     * @param Request $request
     * @return mixed
     * @decribe: 查看文章详情
     * date:2022/12/3 16:30
     * author:Lucky WanYi
     */
    public function showPost($slug, Request $request)
    {
        $post = Post::with('tags')->where('slug', $slug)->firstOrFail();
        $tag = $request->get('tag');
        if ($tag) {
            $tag = Tag::where('tag', $tag)->firstOrFail();
        }
        // 对浏览的文章进行数量排序处理
        $post->increment('views');
        if ($post->save()) {
            // 将当前文章浏览数 +1，存储到对应 Sorted Set 的 score 字段
            Redis::zincrby('popular_posts', 1, $post->id);
        }
        $post['view_post_count'] = Redis::get('view_post' . $slug);
        return view($post->layout, compact('post', 'tag'));
    }

    /**
     * @decribe: 获取列表前十的文章
     * date:2022/8/21 17:54
     * author:Lucky WanYi
     */
    public function popular()
    {
        //设置区域为前十
        $postIds = Redis::zrevrange('popular_posts', 0, 9);
        if ($postIds) {
            $idsStr = implode(',', $postIds);
            // 查询结果排序必须和传入时的 ID 排序一致
            $posts = Post::whereIn('id', $postIds)
                ->select(['id', 'title', 'views'])
                ->orderByRaw('field(`id`, ' . $idsStr . ')')
                ->get()->toArray();
        } else {
            $posts = null;
        }
        return view('/blog', ['post' => $posts]);
    }
}

