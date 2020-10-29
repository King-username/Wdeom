<?php
/**
 * Created by PHPstorm
 * User: 刘全明
 * Date: 2019-11-23
 * Time: 14:48
 */

namespace app\api\controller;


use think\Controller;
use think\Request;

class Base extends Controller
{
    public function __construct(Request $request = null)
    {
		parent::__construct($request);
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId");
        header('Access-Control-Allow-Headers:x-requested-with,content-type,USER_ID,TOKEN');
        header('Content-Type:application/json; charset=utf-8');
    }
}