<?php


namespace app\admin\model;


class Configs extends Base
{
    protected $table = 'cms_config';

    //获取配置列表
    public function getConfigList()
    {
        $where = [];
        if (input('name')) {
            $where['name'] = ['like','%'.input('name').'%'];
        }
        $list = $this->order('id desc')
            ->where($where)
            ->paginate(10,false, ['query' => request()->param()]);
        return $list;
    }

    //获取配置信息
    public function getConfigInfo($id)
    {
        $where['id'] = $id;
        $info = $this->where($where)->find();
        return $info;
    }

    //添加配置
    public function addConfig()
    {
        $data = input('post.');
        $res = $this->insertGetId($data);
        if ($res) {
            $msg['code'] = 1;
            $msg['tips'] = '添加成功';
        } else {
            $msg['code'] = 0;
            $msg['tips'] = '添加失败';
        }
        return $msg;
    }

    //编辑配置
    public function editConfig()
    {
        $data = input('post.');
        $where['id'] = $data['id'];
        $res = $this->where($where)->update($data);
        if ($res) {
            $msg['code'] = 1;
            $msg['tips'] = '编辑成功';
        } else {
            $msg['code'] = 0;
            $msg['tips'] = '编辑失败';
        }
        return $msg;
    }

    //删除配置
    public function delConfig()
    {
        $id = input('post.id/d');
        $where['id'] = $id;
        $res = $this->where($where)->delete();
        if ($res) {
            $msg['code'] = 1;
            $msg['tips'] = '删除成功';
            addLog(session('admin_id'),'删除配置');
        } else {
            $msg['code'] = 0;
            $msg['tips'] = '删除失败';
        }
        return $msg;
    }
}