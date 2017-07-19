<?php
/**
 * Created by PhpStorm.
 * User: hupo
 * Date: 2017/6/22
 * Time: 上午11:28
 */

namespace app\Services;


use App\Menu;

class MenuService
{

    public function menu()
    {
        $menu = Menu::where(['shownav'=>'T','status'=>'T'])->get();
        return $menu;
    }
}