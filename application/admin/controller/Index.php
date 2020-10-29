<?php
namespace app\admin\controller;

use app\admin\model\Admins;
use app\admin\model\Groups;
use app\admin\model\Rules;
use think\Db;

class Index extends Base
{
    protected $admin;
    protected $group;
    protected $rule;
    public function __construct()
    {
        parent::__construct();
        $this->admin = new Admins();
        $this->group = new Groups();
        $this->rule = new Rules();
    }

    public function index()
    {
        $admin_id = session('admin_id');
        $adminInfo = $this->admin->getAdminInfo($admin_id);
        $groupInfo = $this->group->getGroupInfo($adminInfo['group_id']);
        $where['id'] = ['in', $groupInfo['rules']];
        $where['p_id'] = 0;
        $where['status'] = 1;
        //一级菜单
        $menu = $this->rule->getInfoByWhere($where)->toArray();
        foreach ($menu as $k => $v) {
            $whereA['p_id'] = $v['id'];
            $whereA['status'] = 1;
            $whereA['id'] = ['in', $groupInfo['rules']];
            $menu[$k]['son'] = $this->rule->getInfoByWhere($whereA)->toArray();
        }
//        dump($menu);exit;
        $this->assign([
            'menu' => $menu,
            'adminInfo' => $adminInfo,
            'nav' => '首页',
            'title' => '首页',
        ]);
        return view();
    }

    public function welcome()
    {
        //系统配置
        $config = [
            '操作系统' => PHP_OS,
            'PHP版本号' => PHP_VERSION,
            '运行环境' => $_SERVER["SERVER_SOFTWARE"],
            'PHP运行方式' => php_sapi_name(),
            '上传附件限制' => ini_get('upload_max_filesize'),
            '执行时间限制' => ini_get('max_execution_time').'秒',
            '主机名' => $_SERVER['SERVER_NAME'],
            'WEB服务端口' => $_SERVER['SERVER_PORT'],
            '浏览器信息' => substr($_SERVER['HTTP_USER_AGENT'], 0, 40),
            '服务器域名/IP' => $_SERVER['SERVER_NAME'] . ' [ ' . gethostbyname($_SERVER['SERVER_NAME']) . ' ]',
            '用户的IP地址' => $_SERVER['REMOTE_ADDR'],
            '剩余空间' => round((disk_free_space(".") / (1024 * 1024)), 2) . 'M',
        ];
        $admin_id = session('admin_id');
        $adminInfo = $this->admin->getAdminInfo($admin_id);
        //统计用户数
        $userCount = Db::name('user')->count();
        $this->assign([
            'config' => $config,
            'userCount' => $userCount,
            'adminInfo' => $adminInfo,
        ]);
        return view();
    }
}
