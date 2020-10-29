<?php


namespace app\admin\model;


use app\admin\controller\Excel;

class Users extends Base
{
    protected $table = 'cms_user';

    //获取用户列表
    public function getUserList()
    {
        $where = [];
        if (input('phone')) {
            $where['a.phone'] = input('phone');
        }
        $list = $this->alias('a')
            ->join('cms_regions b', 'a.province = b.code','left')
            ->join('cms_regions c', 'a.city = c.code','left')
            ->join('cms_regions d', 'a.area = d.code','left')
            ->field('a.*,b.name as pro_name,c.name as city_name,d.name as area_name')
            ->where($where)
            ->order('a.id desc')
            ->paginate(10,false,['query' => request()->param()]);
        return $list;
    }

    //获取用户
    public function getUserInfo($id)
    {
        $where['id'] = $id;
        $info = $this->where($where)->find();
        return $info;
    }

    //添加用户
    public function addUser()
    {
        $data = input('post.');
        //判断该手机号是否已存在
        $where['phone'] = $data['phone'];
        $check = $this->where($where)->find();
        if ($check) {
            $msg['code'] = 0;
            $msg['tips'] = '手机号已存在';
            return $msg;
        }
        $data['create_time'] = time();
        $data['password'] = md5(md5($data['password']));
        unset($data['file']);
        //添加
        $res = $this->insertGetId($data);
        if ($res) {
            $msg['code'] = 1;
            $msg['tips'] = '添加成功';
            addLog(session('admin_id'),'添加用户');
        } else {
            $msg['code'] = 0;
            $msg['tips'] = '添加失败';
        }
        return $msg;
    }

    //编辑用户
    public function editUser()
    {
        $data = input('post.');
        //判断该手机号是否已存在
        $where['phone'] = $data['phone'];
        $where['id'] = ['<>',$data['id']];
        $check = $this->where($where)->find();
        if ($check) {
            $msg['code'] = 0;
            $msg['tips'] = '手机号已存在';
            return $msg;
        }
        if ($data['password']) {
            $data['password'] = md5(md5($data['password']));
        } else {
            unset($data['password']);
        }
        unset($data['file']);
        $whereA['id'] = $data['id'];
        $res = $this->where($whereA)->update($data);
        if ($res) {
            $msg['code'] = 1;
            $msg['tips'] = '修改成功';
            addLog(session('admin_id'),'修改用户');
        } else {
            $msg['code'] = 0;
            $msg['tips'] = '修改失败';
        }
        return $msg;
    }

    //冻结解冻
    public function freeze($id,$type)
    {
        $where['id'] = $id;
        $data['status'] = $type;
        $res = $this->where($where)->update($data);
        if ($res) {
            $msg['code'] = 1;
            $msg['tips'] = '操作成功';
            if ($type == 1) {
                //添加操作日志
                addLog(session('admin_id'), '解冻用户');
            } else {
                //添加操作日志
                addLog(session('admin_id'), '冻结用户');
            }
        } else {
            $msg['code'] = 0;
            $msg['tips'] = '操作失败';
        }
        return $msg;
    }

    //删除用户
    public function delUser()
    {
        $id = input('post.id/d');
        $where['id'] = $id;
        $res = $this->where($where)->delete();
        if ($res) {
            $msg['code'] = 1;
            $msg['tips'] = '删除成功';
            addLog(session('admin_id'),'删除用户');
        } else {
            $msg['code'] = 0;
            $msg['tips'] = '删除失败';
        }
        return $msg;
    }



    //导入用户
    public function importUser()
    {
        $excel = new Excel();
        $file = request()->file('file');
        //获取表单上传文件   限制大小20M
        $info = $file->validate(['size' => 20971520, 'ext' => 'xlsx,xls'])->move(ROOT_PATH . 'public' . DS . 'excel');
        if ($info) {
            $exclePath = $info->getSaveName();
            //获取文件名
            $file_name = ROOT_PATH . 'public' . DS . 'excel/' . $exclePath;
            //获取导入数据
            $data = $excel->importExecl($file_name);
            array_shift($data);
            $insertData = [];
            foreach ($data as $key => $datum) {
                $insertData[$key]['username'] = $datum['A'];
                $insertData[$key]['password'] = md5(md5($datum['B']));
                $insertData[$key]['phone'] = $datum['C'];
                $insertData[$key]['email'] = $datum['D'];
                $insertData[$key]['create_time'] = ($datum['E'] - 25569) * 24 * 3600;
            }
            $success_count = $this->insertAll($insertData);
            $msg['code'] = 1;
            $msg['tips'] = '导入成功：' . $success_count . '条。';
            return $msg;
        } else {
            $msg['code'] = 0;
            $msg['tips'] = $file->getError();
            return $msg;
        }
    }

    //导出用户
    public function exportUser()
    {
        $excel = new Excel();
        $param = input('post.');
        $where = [];
        $where['status'] = $param['status'];
        $list = $this->where($where)->select()->toArray();
        foreach ($list as $key => $item) {
            $list[$key]['create_time'] = date('Y-m-d',$item['create_time']);
        }
        //设置表格标题
        $title = [
            'username' => '用户名',
            'password' => '密码',
            'phone' => '手机号',
            'email' => '邮箱',
            'create_time' => '注册时间',
        ];
        //添加标题到数组头部
        array_unshift($list,$title);
        //根据此参数获取数据中的值，要与导出的数据键名对应
        $keys = ['username','password','phone','email','create_time'];
        $excel->exportExcel($list,$keys,'用户' . date('Y-m-d_His') . '.xlsx');
    }

    //导入用户 -- PHPExcel 版
    /* public function importUser()
    {
        Vendor('PHPExcel.PHPExcel');
        $file = request()->file('file');
        //获取表单上传文件
        $info = $file->validate(['size' => 20971520, 'ext' => 'xlsx,xls'])->move(ROOT_PATH . 'public' . DS . 'excel');//最大20M
        if ($info) {
            $exclePath = $info->getSaveName();
            //获取文件名
            $file_name = ROOT_PATH . 'public' . DS . 'excel/' . $exclePath;
            //上传文件的地址
            $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
            //加载文件内容,编码utf-8
            $obj_PHPExcel = $objReader->load($file_name, $encode = 'utf-8');
            //转换为数组格式
            $excel_array = $obj_PHPExcel->getsheet(0)->toArray();
            //删除第一个数组(标题)
            array_shift($excel_array);
            //dump($excel_array);die;
            $data = [];
            $msg = [];
            $total_count = 0;
            foreach ($excel_array as $k => $v) {
                $data[$k]['username'] = $v[0];
                $data[$k]['password'] = md5(md5($v[1]));
                $data[$k]['phone'] = $v[2];
                $data[$k]['email'] = $v[3];
                $data[$k]['create_time'] = time();
                unset($v);
                $total_count++;
            }
            unset($excel_array);
            //批量插入数据
            $success_count = $this->insertAll($data);
            unset($data);
            //dump($success_count);exit;
            $error_count = $total_count - $success_count;
            $msg['code'] = 1;
            $msg['tips'] = '总' . $total_count . '条，成功' . $success_count . '条，失败' . $error_count . '条';
            return $msg;
        } else {
            //echo $file->getError();
            $msg['code'] = 0;
            $msg['tips'] = $file->getError();
            return $msg;
        }
    }*/

    //导出用户 -- PHPExcel 版
    /*public function exportUser()
    {
        Vendor('PHPExcel.PHPExcel');
        $param = input('post.');
        $where = [];
        $where['status'] = $param['status'];
        $list = $this->where($where)->select()->toArray();
        //echo Db::getLastSql();exit;
//        dump($list);exit;
        $file_name = '用户' . date('Y-m-d_His') . '.xls';
        $PHPExcel = new \PHPExcel();
        // print_r($PHPExcel);die;
        $PHPSheet = $PHPExcel->getActiveSheet();
        $PHPSheet->setTitle("表格一");
        $PHPSheet->setCellValue("A1", "用户名");
        $PHPSheet->setCellValue("B1", "密码");
        $PHPSheet->setCellValue("C1", "手机号");
        $PHPSheet->setCellValue("D1", "邮箱");
//        $PHPSheet->setCellValue("E1", "");
//        $PHPSheet->setCellValue("F1", "");
//        $PHPSheet->setCellValue("G1", "");
//        $PHPSheet->setCellValue("H1", "");
//        $PHPSheet->setCellValue("I1", "");
//        $PHPSheet->setCellValue("J1", "");


        $i = 2;
        foreach ($list as $key => $value) {
            $PHPSheet->setCellValue('A' . $i, '' . $value['username']);
            $PHPSheet->setCellValue('B' . $i, '' . $value['password']);
            $PHPSheet->setCellValue('C' . $i, '' . $value['phone']);
            $PHPSheet->setCellValue('D' . $i, '' . $value['email']);
//            $PHPSheet->setCellValue('E' . $i, '' . $value['']);
//            $PHPSheet->setCellValue('F' . $i, '' . $value['']);
//            $PHPSheet->setCellValue('G' . $i, '' . $value['']);
//            $PHPSheet->setCellValue('H' . $i, '' . $value['']);
//            $PHPSheet->setCellValue('I' . $i, '' . $value['']);
//            $PHPSheet->setCellValue('J' . $i, '' . $value['']);
            $i++;
        }
        $PHPWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, "Excel2007");
        header('Content-Disposition: attachment;filename=' . $file_name);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $PHPWriter->save("php://output");
    }*/
}