<?php


namespace app\admin\model;


class Rules extends Base
{
    protected $table = 'cms_rule';

    //获取规则列表
    public function getRuleList()
    {
        $list = $this->select();
        return $list;
    }

    //添加规则
    public function addRule()
    {
        $data = input('post.');
        //检查是否已存在该规则
        $where['name'] = $data['name'];
        $check = $this->where($where)->find();
        if ($check) {
            $msg['code'] = 0;
            $msg['tips'] = '规则已存在';
            return $msg;
        }
        $data['condition'] = 2;
        $res = $this->insertGetId($data);
        if ($res) {
            $msg['code'] = 1;
            $msg['tips'] = '添加成功';
            addLog(session('admin_id'),'添加规则');
        } else {
            $msg['code'] = 0;
            $msg['tips'] = '添加失败';
        }
        return $msg;
    }

    //修改规则
    public function editRule()
    {
        $data = input('post.');
        //判断该规则是否已存在
        $where['name'] = $data['name'];
        $where['id'] = ['<>',$data['id']];
        $check = $this->where($where)->find();
        if ($check) {
            $msg['code'] = 0;
            $msg['tips'] = '规则已存在';
            return $msg;
        }
        $whereA['id'] = $data['id'];
        $res = $this->where($whereA)->update($data);
        if ($res) {
            $msg['code'] = 1;
            $msg['tips'] = '修改成功';
            addLog(session('admin_id'),'修改规则');
        } else {
            $msg['code'] = 0;
            $msg['tips'] = '修改失败';
        }
        return $msg;
    }

    //获取规则信息
    public function getRuleInfo($id)
    {
        $where['id'] = $id;
        $info = $this->where($where)->find();
        return $info;
    }

    //获取信息
    public function getInfoByWhere($where,$type = 1)
    {
        if ($type == 1) {
            $list = $this->where($where)->order('show_order desc')->select();
        } else {
            $list = $this->where($where)->order('id asc')->select();
        }
        return $list;
    }
}