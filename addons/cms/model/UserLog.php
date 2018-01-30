<?php

namespace addons\cms\model;

use think\Model;

/**
 * 用户操作日志 for 推管员
 */
class UserLog Extends Model
{

    protected $name = "user_log";
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
     * 添加用户关于推广链接的操作日志
     * @param $advertId
     * @param string $userId
     *
     * @param string $type
     * @param int $status
     * @return $this
     */
    static function addUserLog($advertId, $userId ='',$type, $status = 1)
    {
        $data= [
            'user_id'=> (int)$userId,
            'advert_id'=> (int)$advertId,
            'status'=> (int)$status,
            'type'=> (string)$type,
            ];
        return UserLog::create($data);
    }


}
