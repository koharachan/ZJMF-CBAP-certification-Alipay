<?php
return [
    "module_name" => [
        "title" => "名称",
        "type" => "text",
        "value" => "支付宝-芝麻信用",
        "tip" => "friendly name",
        "size" => 200,
    ],
    "app_id" => [
        "title" => "AppID",
        "type" => "text",
        "value" => "",
        "tip" => "",
    ],
    "public_key" => [
        "title" => "接口公钥",
        "type" => "textarea",
        "value" => "",
        "tip" => "",
    ],
    "private_key" => [
        "title" => "应用私钥",
        "type" => "textarea",
        "value" => "",
        "tip" => "",
    ],
    "biz_code" => [
        "title" => "认证方式",
        "type" => "select",
        "options" => [
            "SMART_FACE" => "快捷认证",
            "FACE" => "人脸识别",
            "CERT_PHOTO" => "身份证认证",
            "CERT_PHOTO_FACE" => "人脸+身份证",
        ],
        "value" => "SMART_FACE",
        "tip" => "认证方式",
    ],
];

?>
