<?php
/**
 * Created by PhpStorm.
 * User: 75763
 * Date: 2018/1/29
 * Time: 16:30
 */
namespace addons\cms\model;

use think\Model;

/**
 * 推广链接
 */
class PromotionUrl Extends Model
{

    protected $name = "promotion_url";
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    // 追加属性
    protected $append = [

    ];
    protected static $config = [];

    //自定义初始化
    protected static function init()
    {
        $config = get_addon_config('cms');
        self::$config = $config;
    }

    /**
     * 添加推广员主动添加的推广链接
     * @param $userId
     * @param $advertId
     * @param $promotionUrl
     * @return $this
     */
    public static function addPromotionUrl($userId, $advertId, $promotionUrl)
    {
        $data =[
            'user_id'=> $userId,
            'advert_id'=> $advertId,
            'promotion_url'=> $promotionUrl,
            'status' => (int)1,
        ];
        return PromotionUrl::create($data);
    }
}
