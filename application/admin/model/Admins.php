<?php


namespace app\admin\model;


class Admins extends Base
{
    protected $table = 'cms_admin';

    //获取管理员列表
    public function getAdminList()
    {
        $where = [];
        $list = $this->alias('a')
            ->join('cms_group b', 'b.id = a.group_id','left')
            ->join('cms_admin c', 'a.pid = c.id','left')
            ->join('cms_regions d', 'a.province = d.code','left')
            ->join('cms_regions e', 'a.city = e.code','left')
            ->join('cms_regions f', 'a.area = f.code','left')
            ->where($where)
            ->field('a.*,b.title,c.username as pname,d.name as pro_name,e.name as city_name,f.name as area_name')
            ->paginate(10,false,['query' => request()->param()]);
        return $list;
    }

    //添加管理员
    public function addAdmin()
    {
        $data = input('post.');
        //判断该用户名是否已存在
        $where['username'] = $data['username'];
        $check = $this->where($where)->find();
        if ($check) {
            $msg['code'] = 0;
            $msg['tips'] = '用户名已存在';
            return $msg;
        }
        $data['pid'] = session('admin_id');
        $data['password'] = md5(md5($data['password']));
        //添加
        $res = $this->insertGetId($data);
        if ($res) {
            $msg['code'] = 1;
            $msg['tips'] = '添加成功';
            addLog(session('admin_id'),'添加管理员');
        } else {
            $msg['code'] = 0;
            $msg['tips'] = '添加失败';
        }
        return $msg;
    }

    //获取管理员信息
    public function getAdminInfo($id)
    {
        $where['id'] = $id;
        $info = $this->where($where)->find();
        return $info;
    }

    //修改管理员
    public function editAdmin()
    {
        $data = input('post.');
        //判断该用户名是否已存在
        $where['username'] = $data['username'];
        $where['id'] = ['<>',$data['id']];
        $check = $this->where($where)->find();
        if ($check) {
            $msg['code'] = 0;
            $msg['tips'] = '用户名已存在';
            return $msg;
        }
        if ($data['password']) {
            $data['password'] = md5(md5($data['password']));
        } else {
            unset($data['password']);
        }
        $whereA['id'] = $data['id'];
        $res = $this->where($whereA)->update($data);
        if ($res) {
            $msg['code'] = 1;
            $msg['tips'] = '修改成功';
            addLog(session('admin_id'),'修改管理员');
        } else {
            $msg['code'] = 0;
            $msg['tips'] = '修改失败';
        }
        return $msg;
    }

    //更改状态
    public function updateStatus()
    {
        $data = input('post.');
        $where['id'] = $data['id'];
        $res = $this->where($where)->update($data);
        if ($res) {
            $msg['code'] = 1;
            $msg['tips'] = '操作成功';
            addLog(session('admin_id'),'修改管理员状态');
        } else {
            $msg['code'] = 0;
            $msg['tips'] = '操作失败';
        }
        return $msg;
    }

    //检查登录
    public function checkLogin()
    {
        $data = input('post.');
        //检查验证码
        if (!captcha_check($data['code'])) {
            $msg['code'] = 0;
            $msg['tips'] = '验证码错误';
            return $msg;
        }
        //检查用户名
        $whereA['username'] = $data['username'];
        $checkName = $this->where($whereA)->find();
        if (!$checkName) {
            $msg['code'] = 0;
            $msg['tips'] = '用户不存在';
            return $msg;
        }
        //检查密码
        $pwd = md5(md5($data['password']));
        if ($checkName['password'] != $pwd) {
            $msg['code'] = 0;
            $msg['tips'] = '密码错误';
            return $msg;
        }
        if ($checkName['status'] == 0) {
            $msg['code'] = 0;
            $msg['tips'] = '账户冻结';
            return $msg;
        }
        session('admin_id',$checkName['id']);
        //更新登录时间
        $whereB['id'] = $checkName['id'];
        $dataA['last_time'] = time();
        $res = $this->where($whereB)->update($dataA);
        if ($res) {
            $msg['code'] = 1;
            $msg['tips'] = '登录成功';
            addLog(session('admin_id'),'管理员登录');
        } else {
            $msg['code'] = 0;
            $msg['tips'] = '登录失败';
        }
        return $msg;
    }

    //修改密码
    public function editPwd()
    {
        $data = input('post.');
        $where['id'] = session('admin_id');
        $data['password'] = md5(md5($data['password']));
        $res = $this->where($where)->update($data);
        if ($res) {
            $msg['code'] = 1;
            $msg['tips'] = '修改成功';
            addLog(session('admin_id'),'修改密码');
        } else {
            $msg['code'] = 0;
            $msg['tips'] = '修改失败';
        }
        return $msg;
    }
}