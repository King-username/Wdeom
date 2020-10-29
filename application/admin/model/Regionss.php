<?php


namespace app\admin\model;


class Regionss extends Base
{
    protected $table = 'cms_regions';

    //根据条件获取信息
    public function getInfoByWhere($where = [])
    {
        $list = $this->where($where)->select();
        return $list;
    }

    //获取信息
    public function getInfo($code)
    {
        $where['code'] = $code;
        $info = $this->where($where)->find();
        return $info;
    }
}