<?php
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/blog');
});
Route::get('/blog', 'BlogController@index')->name('blog.home');
Route::get('/blog/{slug}', 'BlogController@showPost')->name('blog.detail')->middleware('view.post');

// 后台路由
Route::get('/admin', function () {
    return redirect('/admin/post');
});
// 生气快乐页面
//Route::get('/happy_birthday', 'Happy\HappyController@happy')->name('happy.birthday');

Route::middleware('auth')->namespace('Admin')->group(function () {
//    Route::resource('admin/post', 'PostController');
    Route::resource('admin/post', 'PostController', ['except' => 'show']);
    //去除tag 标签详情显示
    Route::resource('admin/tag', 'TagController', ['except' => 'show']);
    // 在这一行下面
    Route::get('admin/upload', 'UploadController@index');
    // 添加如下路由
    Route::post('admin/upload/file', 'UploadController@uploadFile');
    Route::delete('admin/upload/file', 'UploadController@deleteFile');
    Route::post('admin/upload/folder', 'UploadController@createFolder');
    Route::delete('admin/upload/folder', 'UploadController@deleteFolder');
    //excel 的导入导出
    Route::post('excel/import','UploadController@import');
    Route::get('excel/export','UploadController@export');

});
//联系我们
Route::get('contact', 'ContactController@showForm');
Route::post('contact', 'ContactController@sendContactInfo');


// 登录退出
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
//测试队列
Route::get('/queue', 'TestController@mailQueueTest');


//qq回调的路径，和QQ互联平台一直
Route::get('/test','TestController@callback1');







