<?php
/**
 * Created by PhpStorm.
 * ThinkPHP VERSIONS：Think PHP 5.1.18
 * Author: Mr.liu <417626953@qq.com>
 * Date: 2018/6/7
 * Time: 13:51
 */

namespace app\admin\controller;

//管理员类
use app\admin\model\Admins;
use app\admin\model\Groups;
use app\admin\model\Regionss;

class Admin extends Base
{
    protected $admin;
    protected $group;
    protected $regions;
    public function __construct()
    {
        parent::__construct();
        $this->admin = new Admins();
        $this->group = new Groups();
        $this->regions = new Regionss();
    }

    //用户总览
    public function index()
    {
        //获取管理员列表
        $list = $this->admin->getAdminList();
        $page = $list->render();
        $this->assign([
            'list' => $list,
            'page' => $page,
            'nav' => '权限管理',
            'title' => '管理员列表',
        ]);
        return view();
    }

    //添加管理员
    public function add()
    {
        if (request()->isPost()) {
            $res = $this->admin->addAdmin();
            return json($res);
        } else {
            //获取角色列表
            $group = $this->group->getGroupList()->toArray();
            $this->assign([
                'group' => $group['data'],
            ]);
            return view();
        }
    }

    //修改管理员
    public function edit()
    {
        if (request()->isPost()) {
            $res = $this->admin->editAdmin();
            return json($res);
        } else {
            $id = input('id/d');
            $info = $this->admin->getAdminInfo($id);
            //获取省
            $province = $this->regions->getInfo($info['province']);
            //获取市
            $city = $this->regions->getInfo($info['city']);
            //获取乡镇
            $area = $this->regions->getInfo($info['area']);
            //获取角色信息
            $groupList = $this->group->getGroupList()->toArray();
            $this->assign([
                'info' => $info,
                'province' => $province,
                'city' => $city,
                'area' => $area,
                'group' => $groupList['data'],
            ]);
            return view();
        }
    }

    //更改状态
    public function status()
    {
        if (request()->isPost()) {
            $res = $this->admin->updateStatus();
            return json($res);
        }
    }

    //更改密码
    public function editPwd()
    {
        if (request()->isPost()) {
            $res = $this->admin->editPwd();
            return json($res);
        } else {
            $id = input('id/d');
            $this->assign([
                'id' => $id,
            ]);
            return view('edit_pwd');
        }
    }

}