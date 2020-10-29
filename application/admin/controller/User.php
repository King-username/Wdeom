<?php


namespace app\admin\controller;


use app\admin\model\Regionss;
use app\admin\model\Users;

class User extends Base
{
    protected $user;
    protected $regions;
    public function __construct()
    {
        parent::__construct();
        $this->user = new Users();
        $this->regions = new Regionss();
    }

    //用户列表
    public function index()
    {
        $list = $this->user->getUserList();
        $page = $list->render();
        $this->assign([
            'list' => $list,
            'page' => $page,
            'nav' => '用户管理',
            'title' => '用户列表',
        ]);
        return view();
    }

    //添加用户
    public function add()
    {
        if (request()->isPost()) {
            $res = $this->user->addUser();
            return json($res);
        } else {
            return view();
        }
    }

    //导入用户
    public function import()
    {
        if (request()->isPost()) {
            $res = $this->user->importUser();
            return json($res);
        } else {
            return view();
        }
    }

    //导出用户
    public function export()
    {
        if (request()->isPost()) {
            $this->user->exportUser();
        } else {
            return view();
        }
    }

    //编辑用户
    public function edit()
    {
        if (request()->isPost()) {
            $res = $this->user->editUser();
            return json($res);
        } else {
            $id = input('id/d');
            $info = $this->user->getUserInfo($id);
            //获取省
            $province = $this->regions->getInfo($info['province']);
            //获取市
            $city = $this->regions->getInfo($info['city']);
            //获取乡镇
            $area = $this->regions->getInfo($info['area']);
            $this->assign([
                'info' => $info,
                'province' => $province,
                'city' => $city,
                'area' => $area,
            ]);
            return view();
        }
    }

    //冻结解冻
    public function freeze()
    {
        $id = input('post.id/d');
        $type = input('post.type/d');
        $res = $this->user->freeze($id, $type);
        return json($res);
    }

    //删除用户
    public function del()
    {
        if (request()->isPost()) {
            $res = $this->user->delUser();
            return json($res);
        }
    }
}