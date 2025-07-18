<?php
namespace certification\ali\logic;

class AliLogic
{
    private $client;
    public $_config;
    public function __construct()
    {
        $this->_config = (new \certification\ali\Ali())->Config();
        $this->client = new AlipayService(['app_id'=>$this->_config["app_id"], 'alipay_public_key'=>$this->_config["public_key"], 'app_private_key'=>$this->_config["private_key"], 'sign_type'=>$this->_config["sign_type"], 'charset'=>$this->_config["post_charset"], 'gateway_url'=>$this->_config["gateway_url"], 'return_url'=>$this->_config["return_url"], 'pageMethod'=>'1']);
    }
    public function getCertifyId($realname, $idcard)
    {
        try{
			$outer_order_no = date("YmdHis").rand(000,999);
			$certifyResult = $this->client->initialize($outer_order_no, $realname, $idcard, 'IDENTITY_CARD', $this->_config["biz_code"]);
			$certify_id = $certifyResult['certify_id'];
            return ["status" => 200, "msg" => "请求成功", "certify_id" => $certify_id];
		}catch(\Exception $e){
            return ["status" => 400, "msg" => $e->getMessage()];
		}
    }
    public function generateScanForm($certify_id)
    {
        $result = $this->client->certify($certify_id);
        $jsonMsg["status"] = 200;
        $jsonMsg["msg"] = "请使用支付宝扫描二维码";
        $jsonMsg["url"] = $result;
        return $jsonMsg;
    }
    public function getAliyunAuthStatus($certify_id, $type = "person", $client_id = 0)
    {
        try{
            $certifyResult = $this->client->query($certify_id);
            if($certifyResult['passed'] == 'T'){
                $status = 1;
            }else{
                $errorMsg = "阿里审核未通过";
                $status = 2;
            }
        }catch(\Exception $e){
            $errorMsg = $e->getMessage();
            $status = 2;
        }
        if ($type == "person") {
            $data = ["client_id" => $client_id, "status" => $status, "auth_fail" => $errorMsg ?? ""];
            hook("update_certification_person", $data);
        } else {
            $data = ["client_id" => $client_id, "status" => $status, "auth_fail" => $errorMsg ?? ""];
            hook("update_certification_company", $data);
        }
        return ["status" => 200, "msg" => "请求成功", "code" => $status];
    }
}

?>