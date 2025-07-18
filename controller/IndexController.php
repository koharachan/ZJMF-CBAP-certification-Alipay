<?php
namespace certification\ali\controller;

/**
 * @desc 实名认证控制器
 * @author wyh
 * @version 1.0
 * @time 2022-0924
 */
class IndexController extends \app\home\controller\BaseController
{
    public function status()
    {
        $param = $this->request->param();
        $AliLogic = new \certification\ali\logic\AliLogic();
        $result = $AliLogic->getAliyunAuthStatus($param["certify_id"] ?? "", $param["type"] ?? "person", $param["client_id"] ?? 0);
        return json($result);
    }
}

?>