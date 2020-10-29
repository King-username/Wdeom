<?php


namespace app\admin\controller;


use app\admin\model\Groups;
use app\admin\model\Rules;

class Group extends Base
{
    protected $group;
    protected $rule;

    public function __construct()
    {
        parent::__construct();
        $this->group = new Groups();
        $this->rule = new Rules();
    }

    //角色列表
    public function index()
    {
        $list = $this->group->getGroupList();
        $page = $list->render();
        $this->assign([
            'list' => $list,
            'page' => $page,
            'nav' => '权限管理',
            'title' => '角色列表',
        ]);
        return view();
    }

    //添加角色
    public function add()
    {
        if (request()->isPost()) {
            $res = $this->group->addGroup();
            return json($res);
        } else {
            return view();
        }
    }

    //修改角色信息
    public function edit()
    {
        if (request()->isPost()) {
            $res = $this->group->editGroup();
            return json($res);
        } else {
            $id = input('id/d');
            $info = $this->group->getGroupInfo($id);
            $this->assign([
                'info' => $info,
            ]);
            return view();
        }
    }

    //设置权限
    public function setAuth()
    {
        if (request()->isPost()) {
            $res = $this->group->setAuth();
            return json($res);
        } else {
            $id = input('id/d');
            //获取角色权限
            $group = $this->group->getGroupInfo($id);
            //已有权限id
            $rule_id_str = $group['rules'];
            if ($rule_id_str) {
                //获取已有权限信息
                $whereA['id'] = ['in',$rule_id_str];
                $own = $this->rule->getInfoByWhere($whereA,2);
                //获取未有权限信息
                $whereB['id'] = ['not in', $rule_id_str];
                $none = $this->rule->getInfoByWhere($whereB,2);
            } else {
                $own = [];
                $none = $this->rule->getInfoByWhere([],2);
            }
            $this->assign([
                'info' => $group,
                'own' => $own,
                'none' => $none,
            ]);
            return view('set_auth');
        }
    }
}