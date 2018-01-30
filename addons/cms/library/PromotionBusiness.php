<?php
/**
 * Created by PhpStorm.
 * User: 75763
 * Date: 2018/1/30
 * Time: 10:27
 */

namespace addons\cms\library;

use addons\user\model\User;
use fast\Random;
use think\Cookie;
use think\Db;
use think\Exception;
use think\Request;
use think\response\Json;
use think\Validate;

use addons\cms\model\PromotionUrl;
use addons\cms\model\UserLog;

/**
 * promotion 推广业务层
 */
class PromotionBusiness
{

    protected static $instance = null;
    private $_error = '';
    private $_logined = FALSE;
    private $_user = NULL;
    private $keeptime = 0;
    private $requestUri = '';

    /**
     * 初始化
     * @param array $options 参数
     * @return Auth
     */
    public static function instance($options = [])
    {
        if (is_null(self::$instance))
        {
            self::$instance = new static($options);
        }

        return self::$instance;
    }

    /**
     * 推广员添加推广链接
     * @param $userId
     * @param $advertId
     * @param $promotionUrl
     * @return Json
     */
    public static function addPromotionUrl($advertId, $userId ='', $promotionUrl)
    {
        $data = [
            'user_id' => (int)$userId,
            'advert_id' => (int)$advertId,
            'promotion_url' => (int)$promotionUrl
        ];
        //验证是否添加过此广告的链接
        $isHave = PromotionUrl::get($data);
        if(!empty($isHave)){
            return \json('此推广链接已经存在,请前往个人中心查看！');
        }
        //生成时需要开启事务,避免出现垃圾数据
        Db::startTrans();
        //1、添加广告关于此推广员的推广链接
        $addUrl = PromotionUrl::addPromotionUrl($userId, $advertId, $promotionUrl);
        //2、添加此用户的推广操作日志
        $type = 'add';
        $addUserLog = UserLog::addUserLog($advertId, $userId, $type);

        if(!$addUrl || !$addUserLog){
            Db::rollback();
            return \json('生成推广链接失败，请稍后重试！');
        }else{
            Db::commit();
            return \json('生成推广链接成功，请前往个人中心查看！');
        }
    }

    /**
     *
     * @return User
     */
    public function getModel()
    {
        return $this->_user;
    }


}
