<?php
/**
 * Created by PhpStorm.
 * User: 75763
 * Date: 2018/1/29
 * Time: 16:50
 */
namespace addons\cms\model;

use think\Model;

/**
 * 推广记录（生成和查询）
 */
class PromotionRecord Extends Model
{
    protected $name = "promotion_record";
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

    public static function addPromotionRecord($userId,$advertId)
    {

    }
}