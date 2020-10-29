<?php


namespace app\admin\model;

use think\Session;
use app\admin\controller\Excel;
use think\Db;
use think\Request;
include_once("./vendor/PHPExcel/PHPExcel.php");
include_once("./vendor/PHPExcel/PHPExcel/Reader/Excel5.php");
include_once("./vendor/PHPExcel/PHPExcel/IOFactory.php");

class Exceldao extends Base
{
    /**
     *导入测试数据
     * 问题 ：字节不足上传不上去
     * 解决方法：设置PHP.ini配置post_max_size值和memory_limit的值
     */
    public function importUser()
    {
        //获取表单上传文件
        $file = request()->file('file');
        $info = $file->validate(['size' => 20971520, 'ext' => 'xlsx,xls'])->move('./excel');//最大20M
        if ($info) {
            $exclePath = $info->getSaveName();
            //获取文件名
            $file_name = './excel/' . $exclePath;
            //上传文件的地址
            $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
            //加载文件内容,编码utf-8
            $obj_PHPExcel = $objReader->load($file_name, $encode = 'utf-8');
            //缓存在临时的磁盘文件中，速度可能会慢一些
            \PHPExcel_CachedObjectStorageFactory::cache_to_discISAM;
            //转换为数组格式
            $excel_array = $obj_PHPExcel->getsheet(0)->toArray();
            //生成logs.txt文件
            //file_put_contents('logs.txt',json_encode($excel_array).PHP_EOL,FILE_APPEND);
            // dump($excel_array);die;
            //删除第一个数组(标题)
            array_shift($excel_array);
            //dump($excel_array);die;
            $data = [];
            $msg = [];
            $total_count = 0;
            foreach ($excel_array as $key => $v) {
				//数据根据表配置一下
                $insertData[$key]['name'] = $v['0'];
                $insertData[$key]['card'] = $v['1'];
                unset($v);
                $total_count++;
            }
            unset($excel_array);
            //批量插入数据
            $success_count = Db::name('ceshi')->insertAll($insertData);
            unset($insertData);
            $error_count = $total_count - $success_count;
            if($success_count)
            {
                $msg['code'] = 1;
                $msg['tips'] = '总' . $total_count . '条，成功' . $success_count . '条，失败' . $error_count . '条';
                return $msg;
            }else {
                $msg['code'] = 0;
                $msg['tips'] = $file->getError();
                return $msg;
            }
        }
    }
}