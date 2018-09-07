<?php
namespace controller;
use Yansongda\Pay\Pay;
class AlipayController{
    public $config = [
        'app_id' => '2016091700530874',
        // 通知地址
        // 'notify_url' => 'http://openapi.alipaydev.com/gateway.do',
        // 'notify_url' => 'http://localhost:9998/alipay/notify', 
        'notify_url' => 'http://requestbin.fullcontact.com/1ewqlvb1',   //支付成功后台通知地址
        // 跳回地址
        'return_url' => 'http://localhost:9998/alipay/return',// 支付成功后跳转地址
        // 支付宝公钥
        'ali_publc_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAt3wzkkjn8PpA6Zjzn9PE97+H27rgFgbD8c1MjJ7VNhOopTemojyEI35Lv0dsT+pA5SJP9P/kFgST6z2fpW4jpGs3rsdVSNJ8SVG5BM4TB0NzSRCbNX4Wj0pyPYTeJj+/6J3Wz3y70cSjqtfHCbmdaamntFRikhjxaShhRqDrzrnHdY3RRnxAA79/nYdCVw7dhuEpYZS830vq9xK2G1a3SPUeDcMxfTnWvb6AEF5HyJ2UAghmBEv0qLLTLoK4MAVCId9ymQtwuHQ1dlfgB5IX23ewA2bXbe5TGytoVsjprjOLMB8UROCLkWBP+uX/ZtioMyBhVohkqPUFH254/CmSAQIDAQAB
        ',
        // 商户应用密钥
        'private_key' => 'MIIEogIBAAKCAQEAripZFzV2Hmp0VMKSLBuOEhmK7ZdRt+svo29f0s7dd/OEqQeZxzFUEFvPj0JY0aDeQXWOA9OshgnGYjkk4VuOyinfq/G2z5bSUvqx560bel4rg/ur7o9bOGTBI+omtKuWDg3+F2M27uZAPcTw6Kbjjbd5lnc3pHzDwacSKcBgiR/y6m3FgBOMEcqL+aKN3H/cwSBCdUii1DTIqTaa9YW7u57TkUWeICDlJHM0pdmL5ZLKJnCWm9pSv2fQlWUUPa/cJK1dxmWN+xS7bII9dlhsvhfFPQMfOEDz1UzkhZd2FjyWNlLt3KigbmQMTNXKe5RLIW3iDtS7KWvJ66kwjpTepQIDAQABAoIBAA+iV4sAzpCeZ8DwEmUJODChwFnhmoFTCFy4c7adwT2yS3dM6l36LJynUTN/9i8jLLBdmBj52GPT3s4UaR4dtOyq45wwv4NU+55dSLkOTggnCer4HY/1qG+gg8Hwk/bl7DtowCVjT5wUaTHiSunniUfAb5a1LvaCCKSKldPPpBrK8HKEGwJT/IURy9CZHmNvmYDqHSxWqf4wNE1M1kiFbyUBh1W7ceh1659W+wSucoGAakMxUIFwolF9zTVZ0UNzWM4Dsw9QtMo4FLw6KhApUitPKhBrDeom5fRmyxY9wb+kV72fPVc9ywKNiVfU/5sF0j0N8Lbo5BoW2EU1DdYZEmECgYEA3l25nxI8PGJYm1NowzISScm6/zY+7bxwafmxWO7FYs4P5tOkOduyhds09AXJin8rkH1WRcSWj81+p0Kg7hfnftsOYKDfOCFgVzBiVQf/oujq9qrc/R0gXeNp024BZpRnF9S1InT/ZI0M9boINDi+9IoTHkS5QtJeYZ6Cp1EENtkCgYEAyII8arqlRoBN6hrZcxbIC3stH84ffnzYJeBWq9b75Abl+99oZwNL3GyujLRdJli+LcxIEDtBruwpXAMLkwLQOsOoxsuh6183BrUOyzfZXInhEv622bALY6DUQBZJmtNVf7A0qdVxspMenCYsmuqQ4KB8JqmeXQNrH6DyXAWFfq0CgYAlAd4xnhxORGPQvenyinPGuf8YGFQSxsjCql6cmWhaUEcPOGvdgTXN1zSR5CCtnwqGCoYAKH6SQjXw6kLUPUA2uYhEBqH/unZJLHFBC4q89xybnsYWjfFkDsP+/xDWnJ4ntivLJ0OV3W+puaNB5avKEOyrne5jM5Wnk3TVGcOkyQKBgDgDSeV25pzfUuTHQ1/HSXMLoft0lY+8SJWsKgovMIbu9mh6bKv6W8LkCY79A9imido5axg9tYesKZGuuBkFfC4uYoPGdyFNpA2Xnt5eZ7ZWPi4UQfhmGYhncWPF1iIOT6AwFUYsfmqodrCgaW2NgZN+wa/7SmYpgk9/orTaRgSxAoGAG1kbKlfJiWt6hM33WsXNujPWpKGz1sP0XlW2NncU97rtvb2ejhCDHUZPfuixij01wsZgPlxpAcaBOaHM26n0Y69krzzKhf2qHUnOgRDYVzlwgGBFYynGG+7icpVJlZmmFb2xuSE5Dfa6fwl124vhmFURh20J40gOTkICSyFkOrg=',
        // 沙箱模式
        'mode' => 'dev',
        ];
    // 发起支付
    public function pay(){
        $order = [
            // 本地订单
            'out_trade_no' =>time(),
            // 支付金额
            'total_amount' => '0.01',
            // 支付标题
            'subject' =>'test subject',

        ];
        $alipay = Pay::alipay($this->config)->web($order);
        $alipay->send();
    }
    public function return (){
        $data = Pay::alipay($this->config)->verify();
        echo '<h1>支付成功！</h1><hr>';
        var_dump($data->all());
    }
    // 接收支付完成通知
    public function motify(){
        $alipay = Pay::alipay($this->config);
        try{
            $data = $alipay->verify();
            echo '订单ID：'.$data->out_trade_no."\r\n";
            echo '支付总金额'.$data->total_amount."\r\n";
            echo '支付状态'.$data->trade_status."\r\n";
            echo '商户ID'.$data->seller_id."\r\n";
            echo 'app_id'.$data->app_id."\r\n";
        }catch(\Exception $e){
            echo "失败：";
            var_dump($e->getMessage());
        }
        // 返回响应
        $alipay->success()->send();
    }
    // 退款
    public function refund(){
        // 生成唯一退款订单号
        $refundNo = md5(rand(1,99999) . microtime());
        try{
            // 退款
            $ret = Pay::alipay($this->config)->refund([
                'out_trade_no' => '15454154', //之前的订单流水号
                'refund_amount' => 0.01,  //退款金额，单位元
                'out_request_no' => $refundNo,  //退款点单号
            ]);
            if($ret->code == 10000){
                echo "退款成功！";
            }else{
                echo "退款失败，错误信息".$ret->sub_msg;
                echo "错误编号:".$ret->sub_code;
            }
        }
        catch(\Exceotion $e){
            var_dump($e->getMessage());

        }
        
    }
}
