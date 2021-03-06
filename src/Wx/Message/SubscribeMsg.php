<?php
/**
 * 小程序订阅消息
 * Created by PhpStorm.
 * User: marin
 * Date: 2020/7/10
 * Time: 下午10:48
 */

namespace YouGeCore\Wx;


use YouGeCore\Client\Http;
use YouGeCore\Wx\Message\PaySuccessMsgDataItem;
use YouGeCore\Wx\Message\RequestParams;

class SubscribeMsg
{
    protected static $api = 'https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token=';
    /** @var PaySuccessMsgDataItem,预订结果消息体 */
    public $msgDataItem;


    /**
     * 发送酒店订单变更消息
     * @param RequestParams $requestParams
     * @return mixed
     */
    public function sendSubMessage(RequestParams $requestParams)
    {
        $client = new Http();

        $client->header = ["Content-type: application/json;charset=UTF-8", "Accept: application/json", "Cache-Control: no-cache", "Pragma: no-cache"];

        $url = self::$api . $requestParams->getAccessToken();

        $paySuccessMsgData = $requestParams->getData();
        $data = $paySuccessMsgData->createMsgItem($this->msgDataItem)->getMsgData();
        //构造请求参数
        $req = [];
        $req['touser'] = $requestParams->getToUser();
        $req['template_id'] = $requestParams->getTemplateId();
        $req['page'] = $requestParams->getPage();
        $req['miniprogram_state'] = $requestParams->getMiniprogramState();
        $req['data'] = $data;
        return $client->post($url, json_encode($req), true);
    }


}