<?php

namespace App;

use App\Events\EventLog;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable=['title','keywords','description','category_id','pic','status','content'];

    public function category(){

        return $this->belongsTo(Category::class);
    }
    public function tag(){
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}


