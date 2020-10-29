<?php


namespace app\admin\model;


class Logs extends Base
{
    protected $table = 'cms_log';

    //获取日志列表
    public function getLogList()
    {
        $where = [];
        if (input('username')) {
            $where['b.username'] = input('username');
        }
        if (input('title')) {
            $where['a.title'] = ['like','%'.input('title').'%'];
        }
        if (input('ip')) {
            $where['a.ip'] = input('ip');
        }
        $list = $this->alias('a')
            ->join('cms_admin b', 'a.admin_id = b.id', 'left')
            ->field('a.*,b.username')
            ->where($where)
            ->order('a.id desc')
            ->paginate(10,false,['query' => request()->param()]);
        return $list;
    }
}