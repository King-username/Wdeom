<?php


namespace app\admin\controller;


use app\admin\model\Regionss;

class Regions extends Base
{
    protected $regions;

    public function __construct()
    {
        parent::__construct();
        $this->regions = new Regionss();
    }

    //获取省
    public function getProvince()
    {
        $where['pid'] = 0;
        $list = $this->regions->getInfoByWhere($where)->toArray();
        return json($list);
    }

    //获取市
    public function getCity()
    {
        if (request()->isPost()) {
            $parent_id = input('post.parent_id');
            $where['parent_id'] = $parent_id;
            $list = $this->regions->getInfoByWhere($where)->toArray();
            return json($list);
        }

    }

    //获取乡镇
    public function getTown()
    {
        if (request()->isPost()) {
            $parent_id = input('post.parent_id');
            $where['parent_id'] = $parent_id;
            $list = $this->regions->getInfoByWhere($where)->toArray();
            return json($list);
        }
    }
}