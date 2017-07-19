<?php

namespace App\Http\Controllers\Admin;

use App\Authorizable;
use App\Http\Controllers\Controller;

/**
 * Class AuthController
 * 权限控制器
 * @package App\Http\Controllers\Admin
 */
class AuthController extends Controller
{
    use Authorizable;
}
