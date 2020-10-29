<?php
/**
 * Created by PHPstorm
 * User: 阁下贵姓
 * Date: 2019-12-03
 * Time: 11:23
 */

namespace app\api\controller;


use think\Controller;
use think\Request;
use OauthSDK\Oauth;
class Login extends Controller
{
    protected $appid;
    protected $secret;
    protected $config;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->appid = 'wxcaa47f9d91e01b2f';
        $this->secret = 'e852dc5ad26d8675cb270f38556f708e';
        $this->config =  array(
            //腾讯QQ登录配置
            'QQ' => array(
                'APP_KEY' => '123456', //应用注册成功后分配的 APP ID
                'APP_SECRET' => '9cc9ac2fb17d010104d8a58dbebb4d3a', //应用注册成功后分配的KEY
                'CALLBACK' =>  'http://www.example.com/wx_login_callback.php?client=qq',//回调URL
                'SCOPE' =>  'get_user_info',//应用授权作用域
            ),
            //新浪微博配置
            'SINA' => array(
                'APP_KEY' => '123456', //应用注册成功后分配的 APP ID
                'APP_SECRET' => '9cc9ac2fb17d010104d8a58dbebb4d3a', //应用注册成功后分配的KEY
                'CALLBACK' => 'http://www.example.com/wx_login_callback.php?client=sina',//回调URL
                'SCOPE' => 'all',//应用授权作用域
            ),
            //腾讯微信配置
            'WECHAT' => array(
                'APP_KEY' => '123456', //应用注册成功后分配的 APP ID
                'APP_SECRET' => '9cc9ac2fb17d010104d8a58dbebb4d3a', //应用注册成功后分配的KEY
                'CALLBACK' => 'http://www.example.com/wx_login_callback.php?client=wechat',//回调URL
                'SCOPE' => 'snsapi_userinfo',//应用授权作用域
            )
        );
    }

    //版本二
    /*
     html
    <a href="wx_login.php?client=qq">QQ登录</a>
    <a href="wx_login.php?client=wechat">微信登录</a>
    <a href="wx_login.php?client=sina">新浪登录</a>
     * */
    public function wx_login()
    {
        $client = $_GET['client'];
        $sns = Oauth::getInstance($client,$this->config);
//跳转到授权页面
        header('Location: ' . $sns->getRequestCodeURL());
    }

    //回调地址
    public function wx_login_callback()
    {
        $client = $_GET['client'];
        $code = $_GET['code'];
        (empty($client) || empty($code)) && exit('参数错误');
        $sns = Oauth::getInstance($client,$this->config);
        $tokenArr = $sns->getAccessToken($code);

        $openid = $tokenArr['openid'];
        $token = $tokenArr['access_token'];
        //获取当前登录用户信息
        if ($openid) {
            $userinfo  = $sns->getUserInfo();
            exit( 'SUCCESS');
        } else {
            exit('系统出错;请稍后再试！');
        }
    }


    //版本一
    //+------------------------------------------+
    //微信授权登录  -- 网页开发
    public function wx_webpage_login()
    {
        $host = 'http://域名/api/index.php/Login/wx_webpage_login_do';
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->appid.'&redirect_uri='.$host.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
        header("Location:".$url);
    }

    //微信授权登录  -- 网页开发
    public function wx_webpage_login_do()
    {
        header("Content-type: text/html; charset=utf-8");
        if (isset($_GET['code'])){
            //微信获取用户信息链接，没有次数限制，无需关注公众号
            $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->appid."&secret=".$this->secret."&code=".$_GET['code']."&grant_type=authorization_code";
            $res = $this->https_request($url);
            $res=(json_decode($res, true));
            $access_token = $res['access_token'];//网页授权access_token,没有请求次数限制
            $openid = $res['openid'];
            $get_user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
            $res = $this->https_request($get_user_info_url);//调用SDK方法获取到res 从中可以得到openid
            //解析json
            $row = json_decode($res,true);
            //dump($row);
            //exit;
            if ($row['openid']) {
                //用户基本信息$row
                //用户openID
                $openid = $row['openid'];

            }else{
                echo "<meta charset='utf-8' /><script>alert('授权出错,请重新授权!');</script>";
                echo "<script>history.back();</script>";
            }
        }else{
            echo "<script>alert('NO CODE!');</script>";
            echo "<script>history.back();</script>";
        }
    }

    public function https_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
    //+----------------------------------------------+
}