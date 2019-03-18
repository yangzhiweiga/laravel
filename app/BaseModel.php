<?php
/**
 * Created by PhpStorm.
 * User: yangzhiwei
 * Date: 2019/3/14
 * Time: 21:14
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $guarded = [];//允许所有字段注入
}