<?php
/**
 * Created by PhpStorm.
 * User: 75763
 * Date: 2018/1/25
 * Time: 11:24
 */

namespace addons\user\model;

use think\Model;
use think\Db;

/**
 * 会员模型
 */
class UserAccount Extends Model
{

    // 设置完整的数据表（包含前缀）
    protected $table = 'fa_user_account';
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    // 追加属性
    protected $append = [
    ];

//    public $rule = [
//        'name'        =>'require|max:25',
//        'status'         =>'in:1,2',
//        'limit'         =>'require|number',
//        'type'        =>'require',
//        'start_time'        =>'require|date',
//        'end_time'    =>'require|date',
//    ];

//    public $message = [
//        'name.require'     => '计划名称不能为空',
//        'status'        => '展示状态参数错误',
//        'type'            => '广告展示类型参数错误',
//        'begin_time'        => '开始时间格式错误',
//        'end_time'        => '结束时间格式错误'
//    ];

//    public function check()
//    {
//        return \addons\user\library\Auth::instance()->check();
//    }


    /**
     * 根据user_id获取用户账户信息
     * @param $userId
     * @return null|static
     */
    static function getUserAccountByUserId($userId)
    {
        return UserAccount::get(['user_id'=>$userId]);
    }

}
