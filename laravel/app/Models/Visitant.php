<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Visitant extends Model
{
    protected $table='visitant';
    // 在 Post 类的 $dates 属性后添加 $fillable 属性
    protected $fillable = [
        'username', 'creater', 'accessnum', 'ip', 'hostname','country', 'city','province','createtime','title','ostype','browser','type'
    ];


}
