<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * 生成数据的返回值
 *
 * @param unknown $code
 * @param unknown $data
 */
function AjaxReturn($code, $msg = '', $data = array())
{
    $returnData = [
        'code' => $code,
        'msg' => $msg,
    ];
    if (!empty($data) || $data == 0) {
        $returnData["data"] = $data;
    }
    exit(json_encode($returnData));
}
/**
 * 添加操作日志
 * @param $admin_id
 * @param $title
 */
function addLog($admin_id,$title)
{
    if ($admin_id) {
        $data['admin_id'] = $admin_id;
        $data['title'] = $title;
        $data['ip'] = request()->ip();
        $data['time'] = time();
        \think\Db::name('log')->insertGetId($data);
    }
}
