<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable=['pid','name','keyword','description','status'];

    public function getCateNameList()
    {
        $data = $this->pluck('name', 'id')->toArray();
        $data = ['0'=>"顶级分类"] +$data;
        return $data;
    }
}

