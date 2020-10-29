<?php


namespace app\admin\controller;


use app\admin\model\Configs;

class Config extends Base
{
    protected $config;

    public function __construct()
    {
        parent::__construct();
        $this->config = new Configs();
    }

    //配置列表
    public function index()
    {
        $list = $this->config->getConfigList();
        $page = $list->render();
        $this->assign([
            'list' => $list,
            'page' => $page,
            'nav' => '配置管理',
            'title' => '配置列表',
        ]);
        return view();
    }

    //添加配置
    public function add()
    {
        if (request()->isPost()) {
            $res = $this->config->addConfig();
            return json($res);
        } else {
            return view();
        }
    }

    //编辑配置
    public function edit()
    {
        if (request()->isPost()) {
            $res = $this->config->editConfig();
            return json($res);
        } else {
            $id = input('id/d');
            $info = $this->config->getConfigInfo($id)->toArray();
            $this->assign([
                'info' => $info,
            ]);
            return view();
        }
    }

    //删除
    public function del()
    {
        if (request()->isPost()) {
            $res = $this->config->delConfig();
            return json($res);
        }
    }
}