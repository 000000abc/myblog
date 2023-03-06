<?php
namespace App\Services;

use App\Constant\VisitantConstant;
use App\Models\Post;
use App\Models\Visitant;

class VisitantService
{
    public static function addPosition($slug)
    {
        $result=Post::where('slug', $slug)->firstOrFail();
        $ip=get_real_ip();
        $position=get_position($ip);
        $data=[
            'username'=>'游客'.mt_rand(1000,9999),
            'creater'=>'游客'.mt_rand(1000,9999),
            'accessnum'=>VisitantConstant::ACCESSNUM,
            'ip'=>get_real_ip(),
            'hostname'=>get_real_ip(),
            'country'=>$position['country']??'',
            'city'=>$position['city']??'',
            'province'=>$position['province']??'',
            'createtime'=>date('Y-m-d h:i:s',time()),
            'title'=>$result['title'],
            'ostype'=>getOsType(),
            'browser'=>my_get_browser(),
            'type'=>isMobile(),
        ];
//        $get_ip=Visitant::where('ip',$ip)->first(['ip','username']);

        Visitant::insert($data);

//        if($get_ip['username']){
//            $data=[
//                'accessnum'=>DB::raw('accessnum+1'),
//            ];
//            $get_ip->query()->update($data);
//        }else{
//        }
    }

    // 记录邮件发送人
    public function addMailCard(array $data){
        $data=[
            ''
        ];


    }



}
