<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pay;
class PayController extends Controller
{
    public $app_id;
    public $gate_way;
    public $notify_url;
    public $return_url;
    public $rsaPrivateKeyFilePath = '';  //路径
    public $aliPubKey = '';  //路径
    public $privateKey = 'MIIEogIBAAKCAQEAsDntH2PX9GJMb97+Qf3yU6xxfWP6zR/iTRQZhrqOMP0Ofaog1CyxvzO4c1ZjZ5egf80Gp3AGOuOsrdRE/RXI2uJt96kKPf7ChmVV53QVW1Ce1EZsosuh0e5cPZqq4ebExxFPwITKzQB7y8U+a8eoLMLXih19E6W9K0uiPgkuuQtEiRCP9TZG+wIjuyLxEnuRZTQIIbW+AFLx8e5vAaidoqXGllDkp+hUCVIDdbHQG9fiLJTLNGoVgcRGtzzfrnN+VeKrOXJS8mN9eINJ3RjlQod+kwVI+FgoqkD+9ESLJeSzqVuR57jq8t9oZLq6TXSx1NMRxZYhO5KnPkIpJDzhwwIDAQABAoIBAECNx53zDh2YkJV+Yzc7VjRue9hJ8oqHfndrwHoJBqNNX6yK0KHIiYgX4x5k6977vTBzo1dcgvu5gPzgQDFRdJUx0sShKH5TP2DJ6DDz5grgOn5aGdt8qpdjMGjkqmo8BaNCZSuJuVxlK/QWGeqTZbiX2yrd6H50/RnKB/GfnXzs1tQ8GgZyqhEus8N5BMHGlMNGl7L7wEr36RpHCbszcn/FybJOxrWaf1A9mbDljWhKBsJ64Ep6ynsASpZ0jLxrQ/ATyj/oFwrfBIidBflXmP8KQaFBvVT1yz0+qatH1ehTojQBDMLxxnT2NMa5qWgBp8nMUAArMlFEltQ4+i+u80ECgYEA4caNXERy7Es/wr0ewnwrMZpEmakgtRxebbQcTVDuXZKqvgCCVSSXilvv6ovNYV7YgLXbPsgEZkavDR7PV5FVVv+8VXx0N2y/PPFFSiwXZWb0dIYTSRZjRKlN6jq4gVh6DRQijh/M7JFna+5lSxlCbKU5+RF3ptfyyivXVOboG2ECgYEAx9FK/dVqxD8qTnUGIYbIwo9i3WMfTl3TppY4X6oVDbpkT1DG0ZSObI4jz+1NU6TUT2I2RZ0WDKrGgtBo+e/XHrIE6W6GyyP77yXgwtSjKn/zTX35niINzG/UipxrYmztTj08KbuL4PZ5Yspbnitzm6mb/8cZG+/k1ZwFmzFzU6MCgYBIOJ9XeH3aoGeQ/7YrOFUI1PREwxk3Vg/Ov+KdyNm3DQeZJ8iJO99N3wLr4DSehRx0b7fmaU0e+lVcuRJSTKcj4UJ5hgoXAK5b7EHh7CC/yyM/cvQQWR0ABbhqyMXkekzwihRTqlB/DDQtDmFQmI/q+R+GUNQZhtKfYU7MVeDBgQKBgAZHGg8NhHQz89VRMecdv/L05EtGUPZ6Vir2r0C6LD0pLPuc8xIkk7DvakqfDv3gwNbZpBDd1ZKCTwhPGe04Ts7lEuhuk4eQUtr5mq0kVxf/uxolKhGAymQw40GTloAaIf6CSACbptJji/7Bks1OWix60K7hh3VsPQlFBJwSmqf3AoGABn6CdTBpqxVCZ4X5fU8Ij4GPN564cfBrkylug6tjLHiEH+dfPr74NC7Y5Ck0DVt0u6XtJaP2BjRGYmnQmwAHc3YZLv86gef9hBnzfP4fiPA5UtlfdwFPDWGiyd8w4O2uJPaOHm40mmpamqOQK2GOpRFdql0HbAtpaIH+Y3/T4ag=';
    public $publicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAsDntH2PX9GJMb97+Qf3yU6xxfWP6zR/iTRQZhrqOMP0Ofaog1CyxvzO4c1ZjZ5egf80Gp3AGOuOsrdRE/RXI2uJt96kKPf7ChmVV53QVW1Ce1EZsosuh0e5cPZqq4ebExxFPwITKzQB7y8U+a8eoLMLXih19E6W9K0uiPgkuuQtEiRCP9TZG+wIjuyLxEnuRZTQIIbW+AFLx8e5vAaidoqXGllDkp+hUCVIDdbHQG9fiLJTLNGoVgcRGtzzfrnN+VeKrOXJS8mN9eINJ3RjlQod+kwVI+FgoqkD+9ESLJeSzqVuR57jq8t9oZLq6TXSx1NMRxZYhO5KnPkIpJDzhwwIDAQAB';
    public function __construct()
    {
        $this->app_id = '2016092800618146';
        $this->gate_way = 'https://openapi.alipaydev.com/gateway.do';
        $this->notify_url = env('APP_URL').'/notify_url';
        $this->return_url = env('APP_URL').'/return_url';
    }

    public function do_pay(Request $request){
        $oid = $request->all()['oid'];
        $price = $request->all()['price'];
//        $oid = time().mt_rand(1000,1111);  //订单编号
        $order = [
            'out_trade_no' => $oid,
            'total_amount' => $price,
            'subject' => 'test subject - 测试',
        ];

        return Pay::alipay()->web($order);
    }

    public function return_url()
    {
        echo 11;
    }

    public function notify_url()
    {
        $post_json = file_get_contents("php://input");
        $post = json_encode($post_json);
    }
    public function rsaSign($params) {
        return $this->sign($this->getSignContent($params));
    }
    protected function sign($data) {
    	if($this->checkEmpty($this->rsaPrivateKeyFilePath)){
    		$priKey=$this->privateKey;
			$res = "-----BEGIN RSA PRIVATE KEY-----\n" .
				wordwrap($priKey, 64, "\n", true) .
				"\n-----END RSA PRIVATE KEY-----";
    	}else{
    		$priKey = file_get_contents($this->rsaPrivateKeyFilePath);
            $res = openssl_get_privatekey($priKey);
    	}
        
        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');
        openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        if(!$this->checkEmpty($this->rsaPrivateKeyFilePath)){
            openssl_free_key($res);
        }
        $sign = base64_encode($sign);
        return $sign;
    }
    public function getSignContent($params) {
        ksort($params);
        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {
                // 转换成目标字符集
                $v = $this->characet($v, 'UTF-8');
                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
                }
                $i++;
            }
        }
        unset ($k, $v);
        return $stringToBeSigned;
    }

    

    /**
     * 根据订单号支付
     * [ali_pay description]
     * @param  [type] $oid [description]
     * @return [type]      [description]
     */
    public function ali_pay($oid){
        $order = [];
        $order_info = $order;
        //业务参数
        $bizcont = [
            'subject'           => 'Lening-Order: ' .$oid,
            'out_trade_no'      => $oid,
            'total_amount'      => 10,
            'product_code'      => 'FAST_INSTANT_TRADE_PAY',
        ];
        //公共参数
        $data = [
            'app_id'   => $this->app_id,
            'method'   => 'alipay.trade.page.pay',
            'format'   => 'JSON',
            'charset'   => 'utf-8',
            'sign_type'   => 'RSA2',
            'timestamp'   => date('Y-m-d H:i:s'),
            'version'   => '1.0',
            'notify_url'   => $this->notify_url,        //异步通知地址
            'return_url'   => $this->return_url,        // 同步通知地址
            'biz_content'   => json_encode($bizcont),
        ];
        //签名
        $sign = $this->rsaSign($data);
        $data['sign'] = $sign;
        $param_str = '?';
        foreach($data as $k=>$v){
            $param_str .= $k.'='.urlencode($v) . '&';
        }
        $url = rtrim($param_str,'&');
        $url = $this->gate_way . $url;
        dd($url);
        header("Location:".$url);
    }
    protected function checkEmpty($value) {
        if (!isset($value))
            return true;
        if ($value === null)
            return true;
        if (trim($value) === "")
            return true;
        return false;
    }
    /**
     * 转换字符集编码
     * @param $data
     * @param $targetCharset
     * @return string
     */
    function characet($data, $targetCharset) {
        if (!empty($data)) {
            $fileType = 'UTF-8';
            if (strcasecmp($fileType, $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
            }
        }
        return $data;
    }
    /**
     * 支付宝同步通知回调
     */
    public function aliReturn()
    {
        header('Refresh:2;url=/order_list');
        echo "<h2>订单： ".$_GET['out_trade_no'] . ' 支付成功，正在跳转</h2>';
    }
    /**
     * 支付宝异步通知
     */
    public function aliNotify()
    {
        $data = json_encode($_POST);
        $log_str = '>>>> '.date('Y-m-d H:i:s') . $data . "<<<<\n\n";
        //记录日志
        file_put_contents(storage_path('logs/alipay.log'),$log_str,FILE_APPEND);
        //验签
        $res = $this->verify($_POST);
        $log_str = '>>>> ' . date('Y-m-d H:i:s');
        if($res){
            //记录日志 验签失败
            $log_str .= " Sign Failed!<<<<< \n\n";
            file_put_contents(storage_path('logs/alipay.log'),$log_str,FILE_APPEND);
        }else{
            $log_str .= " Sign OK!<<<<< \n\n";
            file_put_contents(storage_path('logs/alipay.log'),$log_str,FILE_APPEND);
            //验证订单交易状态
            if($_POST['trade_status']=='TRADE_SUCCESS'){
                
            }
        }
        
        echo 'success';
    }
    //验签
    function verify($params) {
        $sign = $params['sign'];
        if($this->checkEmpty($this->aliPubKey)){
            $pubKey= $this->publicKey;
            $res = "-----BEGIN PUBLIC KEY-----\n" .
                wordwrap($pubKey, 64, "\n", true) .
                "\n-----END PUBLIC KEY-----";
        }else {
            //读取公钥文件
            $pubKey = file_get_contents($this->aliPubKey);
            //转换为openssl格式密钥
            $res = openssl_get_publickey($pubKey);
        }
        
        
        ($res) or die('支付宝RSA公钥错误。请检查公钥文件格式是否正确');
        //调用openssl内置方法验签，返回bool值
        $result = (bool)openssl_verify($this->getSignContent($params), base64_decode($sign), $res, OPENSSL_ALGO_SHA256);
        
        if(!$this->checkEmpty($this->aliPubKey)){
            openssl_free_key($res);
        }
        return $result;
    }
}
