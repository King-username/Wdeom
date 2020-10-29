<?php


namespace app\admin\model;


class Groups extends Base
{
    protected $table = 'cms_group';

    //获取角色列表
    public function getGroupList($where = [])
    {
        $list = $this->where($where)->paginate(10,false,['query' => request()->param()]);
        return $list;
    }

    //添加角色
    public function addGroup()
    {
        $data = input('post.');
        //检查是否已存在该角色
        $where['title'] = $data['title'];
        $check = $this->where($where)->find();
        if ($check) {
            $msg['code'] = 0;
            $msg['tips'] = '角色已存在';
            return $msg;
        }
        $res = $this->insertGetId($data);
        if ($res) {
            $msg['code'] = 1;
            $msg['tips'] = '添加成功';
            addLog(session('admin_id'),'添加角色');
        } else {
            $msg['code'] = 0;
            $msg['tips'] = '添加失败';
        }
        return $msg;
    }

    //设置权限
    public function setAuth()
    {
        $data = input('post.');
        if (!isset($data['rules'])) {
            $msg['code'] = 0;
            $msg['tips'] = '权限不能为空';
            return $msg;
        }
        $data['rules'] = implode(',',$data['rules']);
        $where['id'] = $data['id'];
        $res = $this->where($where)->update($data);
        if ($res) {
            $msg['code'] = 1;
            $msg['tips'] = '设置成功';
            addLog(session('admin_id'),'设置权限');
        } else {
            $msg['code'] = 0;
            $msg['tips'] = '设置失败';
        }
        return $msg;

    }

    //获取角色信息
    public function getGroupInfo($id)
    {
        $where['id'] = $id;
        $info = $this->where($where)->find();
        return $info;
    }

    //修改角色信息
    public function editGroup()
    {
        $data = input('post.');
        //判断该角色是否已存在
        $where['title'] = $data['title'];
        $where['id'] = ['<>',$data['id']];
        $check = $this->where($where)->find();
        if ($check) {
            $msg['code'] = 0;
            $msg['tips'] = '角色已存在';
            return $msg;
        }
        $whereA['id'] = $data['id'];
        $res = $this->where($whereA)->update($data);
        if ($res) {
            $msg['code'] = 1;
            $msg['tips'] = '修改成功';
            addLog(session('admin_id'),'修改角色信息');
        } else {
            $msg['code'] = 0;
            $msg['tips'] = '修改失败';
        }
        return $msg;
    }

}