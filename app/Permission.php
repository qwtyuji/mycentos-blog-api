<?php

namespace App;

use \Spatie\Permission\Models\Permission as Model;

class Permission extends Model
{
    protected $fillable=['name','guard_name','group','cname'];
}
