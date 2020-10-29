<?php


namespace app\admin\controller;


use app\admin\model\Admins;
use think\Controller;
use think\Request;

class Login extends Controller
{
    protected $admin;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->admin = new Admins();
    }

    //登录
    public function index()
    {
        return view();
    }

    //检查登录
    public function checkLogin()
    {
        if (request()->isPost()) {
            $res = $this->admin->checkLogin();
            return json($res);
        }
    }

    //登出
    public function logout()
    {
        addLog(session('admin_id'),'管理员登出');
        session('admin_id',null);
        return view('index');
    }
}