<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class TestController extends Controller
{
    //登录的回调
    public function callback1()
    {
        //获取基本信息
        $userInfo = Socialite::driver('qq')->user();

        //打印返回的信息，有基本信息字段和详细信息数组
        //dd($userInfo);
        //通过dd打印，可以看出，基本信息中的 unionid 为空，可以发送get请求获取

        //发送get请求，获取 unionid
        $userInfo2 = Http::get('https://graph.qq.com/oauth2.0/me?access_token=' . $userInfo->accessTokenResponseBody['access_token'] . '&unionid=1&fmt=json');
        $userInfo2 = json_decode($userInfo2, true);
        //dd($userInfo2);
        $unionid = $userInfo2['unionid'];

        // 获取基本信息
        echo '用户ID：' . $userInfo->getId() . '<br>';
        echo '用户unionid：' . $unionid . '<br>';
        echo '用户头像URL：' . $userInfo->getAvatar() . '<br>';
        echo '用户昵称：' . $userInfo->getNickname() . '<br>';

        //获取更加详细的信息
        $user = $userInfo->user;
        echo '性别：' . $user['gender'] . '<br>';
        echo '性别：' . $user['gender_type'] . '<br>';
        echo '省份：' . $user['province'] . '<br>';
        echo '城市：' . $user['city'] . '<br>';
        echo '年：' . $user['year'] . '<br>';

    }

    public function postTest(Request $request){
        $name=$request->post('name');
        if(!$name){
            return ['code'=>401,'msg'=>'失败','data'=>$name];
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showForm()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
