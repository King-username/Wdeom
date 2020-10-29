<?php


namespace app\admin\controller;


use think\Controller;

class Upload extends Controller
{
    //上传文件
    public function upload()
    {
        $file = request()->file('file');
        if ($file) {
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info) {
                $msg['code'] = 1;
                $msg['tips'] = '上传成功';
                $msg['url'] = $info->getSaveName();
            } else {
                $msg['code'] = 0;
                $msg['tips'] = $file->getError();
            }
        } else {
            $msg['code'] = 0;
            $msg['tips'] = '没有文件上传';
        }
        return json($msg);

    }
}