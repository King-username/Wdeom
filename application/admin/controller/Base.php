<?php
/**
 * Created by PhpStorm.
 * ThinkPHP VERSIONS：Think PHP 5.1.18
 * Author: Mr.liu <417626953@qq.com>
 * Date: 2018/6/7
 * Time: 13:52
 */

namespace app\admin\controller;
use think\Controller;

class Base extends Controller
{
    //初始化
    public function __construct()
    {
        parent::__construct();
        if (!session('?admin_id')) {
            $this->redirect('Login/index');
        }
    }
}