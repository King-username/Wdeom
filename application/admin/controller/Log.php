<?php


namespace app\admin\controller;


use app\admin\model\Logs;

class Log extends Base
{
    protected $log;

    public function __construct()
    {
        parent::__construct();
        $this->log = new Logs();
    }

    //日志列表
    public function index()
    {
        $list = $this->log->getLogList();
        $page = $list->render();
        $this->assign([
            'list' => $list,
            'page' => $page,
            'nav' => '日志管理',
            'title' => '日志列表',
        ]);
        return view();
    }
}
