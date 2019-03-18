<?php

namespace App;

class Post extends BaseModel
{
    //关联用户
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
