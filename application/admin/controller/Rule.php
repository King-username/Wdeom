<?php


namespace app\admin\controller;


use app\admin\model\Rules;

class Rule extends Base
{
    protected $rule;
    public function __construct()
    {
        parent::__construct();
        $this->rule = new Rules();
    }

    //规则列表
    public function index()
    {
        $list = $this->rule->getRuleList();
        $this->assign([
            'list' => $list,
            'nav' => '权限管理',
            'title' => '规则列表',
        ]);
        return view();
    }

    //添加规则
    public function add()
    {
        if (request()->isPost()) {
            $res = $this->rule->addRule();
            return json($res);
        } else {
            //获取一级规则信息
            $whereA['p_id'] = 0;
            $ruleList = $this->rule->getInfoByWhere($whereA);
            $this->assign([
                'ruleList' => $ruleList,
            ]);
            return view();
        }
    }

    //修改规则
    public function edit()
    {
        if (request()->isPost()) {
            $res = $this->rule->editRule();
            return json($res);
        } else {
            $id = input('id/d');
            $info = $this->rule->getRuleInfo($id);
            //获取一级规则信息
            $whereA['p_id'] = 0;
            $ruleList = $this->rule->getInfoByWhere($whereA);
            $this->assign([
                'info' => $info,
                'ruleList' => $ruleList,
            ]);
            return view();
        }
    }
}