<?php
namespace certification\ali;

class Ali extends \app\common\lib\Plugin
{
    public $info = ["name" => "certification_alipay", "title" => "支付宝-芝麻信用", "description" => "支付宝-芝麻信用", "status" => 1, "author" => "小原", "version" => "1.0.0", "help_url" => "https://github.com/koharachan/ZJMF-CBAP-certification-Alipay"];
    public function install()
    {
        return true;
    }
    public function uninstall()
    {
        return true;
    }
    public function AliPerson($certifi)
    {
        require_once "phpqrcode/phpqrcode.php";
        $AliLogic = new logic\AliLogic();
        $res1 = $AliLogic->getCertifyId($certifi["name"], $certifi["card"]);
        $data = ["status" => 4, "auth_fail" => "", "certify_id" => "", "notes" => "", "refresh" => 0];
        $clientId = get_client_id();
        if ($res1["status"] == 200) {
            $certify_id = $res1["certify_id"];
            $data["certify_id"] = $certify_id;
            $res2 = $AliLogic->generateScanForm($certify_id);
            $url = $res2["url"];
            $time = date("Y-m-d H:i:s", time());
            $data["notes"] = "支付宝记录号:" . $certify_id . ";\r\n" . "实名认证方式:" . $this->info["title"] . ";\r\n" . "实名认证接口提交时间:" . $time . "\r\n";
            $response = \QRcode::png($url, false, 0, 4, 5, false);
            $base64 = "data:png;base64," . base64_encode($response->getData());
            $data["client_id"] = $clientId;
            hook("update_certification_person", $data);
            $CertificationLogModel = new \addon\idcsmart_certification\model\CertificationLogModel();
            $log = $CertificationLogModel->where("client_id", $clientId)->where("type", 1)->order("id", "desc")->find();
            $ClientModel = new \app\common\model\ClientModel();
            $client = $ClientModel->find($clientId);
            $html = "\r\n            <div class='thirdBox-left'>\r\n            <div class='left-box1'>\r\n            <p>\r\n                <span class='left-title'>用户名：</span>\r\n                <span>" . $client["username"] . "</span>\r\n            </p>\r\n            <p>\r\n                <span class='left-title'>认证姓名：</span>\r\n                <span>" . $log["card_name"] . "</span>\r\n            </p>\r\n            <p>\r\n                <span class='left-title'>认证号码：</span>\r\n                <span>" . $log["card_number"] . "</span>\r\n            </p>\r\n            </div>\r\n            <div id='contentBox'>\r\n                <img height='200' width='200' src=\"" . $base64 . "\" alt=\"\">\r\n            </div>\r\n            <div class='left-box2'>\r\n                <div class='sao-icon-box'>\r\n                    <img src='/plugins/addon/idcsmart_certification/template/clientarea/img/account/sao-icon.png' alt=''>\r\n                </div>\r\n                <div class='sao-text'>\r\n                    <p>打开手机支付宝</p>\r\n                    <p>扫一扫继续认证</p>\r\n                </div>\r\n            </div>\r\n        </div>\r\n        <div class='thirdBox-right'>\r\n        <img src='/plugins/addon/idcsmart_certification/template/clientarea/img/account/zfb-img.png' alt=''>\r\n        </div>\r\n            <script src='https://cdn.staticfile.org/jquery/1.10.2/jquery.min.js'></script>\r\n            <script>\r\n                var timer = null\r\n                var captchaTimer = setTimeout(() => { onLoad() }, 500)\r\n                function getIdcsmartaliStatus() {\r\n                    if (Date.now() - startTime > timeout) {
                        clearInterval(timer);
                        $('.btn-refresh').show();
                        alert('认证超时，请重新认证');
                        return;
                    }
                    $.ajax({
                        url:'/certification/ali/index/status?certify_id=" . $certify_id . "&type=person&client_id=" . $clientId . "',
                        success:function(result) {
                            if(result.status === 'success') {
                                window.location.href = result.redirect_url;
                            } else if(result.status === 'pending') {
                                $('.btn-refresh').show();
                            }
                        }
                    })
                }
                function restartCheck() {
                    startTime = Date.now();
                    $('.btn-refresh').hide();
                    timer = setInterval(() => getIdcsmartaliStatus(), 30000);
                }
            </script>\r\n            function onLoad() {\r\n                    timer = setInterval(() => {\r\n                        getIdcsmartaliStatus()\r\n                    }, 2000)\r\n                }\r\n            </script>\r\n            ";
            return $html;
        }
        $data["auth_fail"] = $res1["msg"] ?: "实名认证接口配置错误,请联系管理员";
        return "<h3 class=\"pt-2 font-weight-bold h2 py-4\"><img src=\"\" alt=\"\">" . $data["auth_fail"] . "</h3>";
    }
    public function AliCompany($certifi)
    {
        require_once "phpqrcode/phpqrcode.php";
        $AliLogic = new logic\AliLogic();
        $res1 = $AliLogic->getCertifyId($certifi["name"], $certifi["card"]);
        $data = ["status" => 4, "auth_fail" => "", "certify_id" => "", "notes" => "", "refresh" => 0];
        $clientId = get_client_id();
        if ($res1["status"] == 200) {
            $certify_id = $res1["certify_id"];
            $data["certify_id"] = $certify_id;
            $res2 = $AliLogic->generateScanForm($certify_id);
            $url = $res2["url"];
            $time = date("Y-m-d H:i:s", time());
            $data["notes"] = "支付宝记录号:" . $certify_id . ";\r\n" . "实名认证方式:" . $this->info["title"] . ";\r\n" . "实名认证接口提交时间:" . $time . "\r\n";
            $response = \QRcode::png($url, false, 0, 4, 5, false);
            $base64 = "data:png;base64," . base64_encode($response->getData());
            $data["client_id"] = $clientId;
            hook("update_certification_company", $data);
            $CertificationLogModel = new \addon\idcsmart_certification\model\CertificationLogModel();
            $log = $CertificationLogModel->where("client_id", $clientId)->whereIn("type", [2, 3])->order("id", "desc")->find();
            $html = "\r\n            <div class='thirdBox-left'>\r\n            <div class='left-box1'>\r\n            <p>\r\n                <span class='left-title'>认证企业：</span>\r\n                <span>" . $log["company"] . "</span>\r\n            </p>\r\n            <p>\r\n                <span class='left-title'>企业信用代码：</span>\r\n                <span>" . $log["company_organ_code"] . "</span>\r\n            </p>\r\n            </div>\r\n            <div id='contentBox'>\r\n                <img height='200' width='200' src=\"" . $base64 . "\" alt=\"\">\r\n            </div>\r\n            <div class='left-box2'>\r\n                <div class='sao-icon-box'>\r\n                    <img src='/plugins/addon/idcsmart_certification/template/clientarea/img/account/sao-icon.png' alt=''>\r\n                </div>\r\n                <div class='sao-text'>\r\n                    <p>打开手机支付宝</p>\r\n                    <p>扫一扫继续认证</p>\r\n                </div>\r\n            </div>\r\n        </div>\r\n        <div class='thirdBox-right'>\r\n        <img src='/plugins/addon/idcsmart_certification/template/clientarea/img/account/zfb-img.png' alt=''>\r\n        </div>\r\n            <shr/ric nr                          timer = null\r\n                         \r\n}\r\n               \r\n        }\r\n       t       })\r\r\    function onLo() {\ap cha        setTimeo t(()t=>i{molL \d   }, 500)\r\n              gefunctaontgs()dcsmarr  iStatus    \r\n        }, 2000)\r\n\        \r\n   }\r\n            </sc>\r\'/cert fi   ";
/ li/index/s  tuseturn $html;" . $     }
    . "&type=company&client_id=" .$$clientIdd.a"',\r\nta["auth_fail"] = $res  1["msg"]?: "实名认证接口配置ult错误,\r\n联系管理员";
        return "<hs=\"ptult-2 font-weigt\r\nbold h2 py-4\"><img src=\"\"">" . $data["atil"] \r\n
    }
    public function AnIm  t=p"=ll\l\," => ["title" => "身份证号码", "\r\nype" => "text", "value" =\r\n", "tip" => "", "requ=\r\ntrue]];
         \r\n } else {
                 L;ad    \r\n      }
        }
   rn $data;
    }
    public\r\nfunction Config()
    {
ge I$)smwheamiSpa   ])\r;
$con = (require dirname2_D \\\\n\r\n