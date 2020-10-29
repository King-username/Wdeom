<?php
/**
 * Created by PHPstorm
 * User: 刘全明
 * Date: 2019-11-27
 * Time: 14:55
 */

namespace app\api\controller;


use think\Db;

class Index extends Base
{
    public function sql()
    {
        $users = Db::query("explain select * from cms_user where username='阁下贵姓'");
        dump($users);
    }

    //身份证验证
    public function checkIdcard()
    {
        $alistore = new Alistore();
        $id_card = 'xxxxxxxxxxxxxxxx';
        $name = '彭于晏';
        $res = $alistore->trueNameAuth($id_card,$name);
        dump($res);
    }

    //循环获取地区信息
    public function getRegion($leave,$page)
    {
        echo 'leave:'.$leave.',page:'.$page.'<br>';
        $start_time = time();
        $alistore = new Alistore();
        $data = $alistore->regionSearch($leave,$page);
        if (!$data) {
            echo '数据处理完毕，耗时：'.(time()-$start_time).'秒';
            die();
        }
        foreach ($data as $datum) {
            $where['id'] = $datum['id'];
            $find = Db::name('region')->where($where)->find();
            if (!$find) {
                $dataA['id'] = $datum['id'];
                $dataA['parent_id'] = $datum['parent_id'];
                $dataA['level'] = $datum['level'];
                $dataA['area_code'] = $datum['area_code'];
                $dataA['merger_name'] = $datum['merger_name'];
                $dataA['name'] = $datum['name'];
                $dataA['city_code'] = $datum['city_code'];
                $dataA['short_name'] = $datum['short_name'];
                $dataA['zip_code'] = $datum['zip_code'];
                $dataA['lat'] = $datum['lat'];
                $dataA['lng'] = $datum['lng'];
                $dataA['pinyin'] = $datum['pinyin'];
                Db::name('region')->insertGetId($dataA);
            }
        }
        sleep(1);
        $this->getRegion($leave,$page + 1);
//        dump($data);
    }

    //调用
    public function runGetRegion()
    {
        set_time_limit(0);
        //$this->getRegion(3,1633);//3946
    }

    //infura开发
    //http://cw.hubwiz.com/card/c/infura-api/1/2/7/
    public function infuraApi()
    {
        /*$a = $this->to10('0x');
        dump($a);exit;*/
        $url = 'https://mainnet.infura.io/v3/12baf6c4aa5740f5a93b5001f872f97c';
        $data['jsonrpc'] = '2.0';
        $data['method'] = 'eth_gasPrice';
        $data['params'] = [
            //'0xd241ef78fe89c109d12f01956de884aeb2e3b6b0',
            //'latest'
        ];
        $data['id'] = 1;
        $data_str = json_encode($data);
        $res = $this->http_post($url,$data_str);
        dump($res);
        $a = $this->to10($res['result']) / 10000000000;
        dump($a);

    }

    /**
     * 传入json数据进行HTTP POST请求
     *
     * @param string $url $data_string
     * @return string
     */
    public function http_post($url,$data_string,$timeout = 60)
    {
        //curl验证成功
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//// 跳过证书检查
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string)
        ));

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            print curl_error($ch);
        }
        curl_close($ch);
        return json_decode($result,true);
    }

    //转为16进制
    public function to16($num)
    {
        return "0x".base_convert($num, 10, 16);
    }
    //转为10进制
    public function to10($num)
    {
        return base_convert($num, 16, 10);
    }
}