<?php
namespace app\promotion\controller;

use app\promotion\controller\PromotionBase;

use think\Db;
use addons\cms\model\Archives as ArchivesModel;
use addons\user\model\UserAccount;
use addons\user\model\User;
use think\Config;
use addons\user\library\Auth;
use fast\HelperTools;
use addons\cms\library\PromotionBusiness;
use addons\cms\model\PromotionUrl as PromotionUrlModel;
use addons\cms\model\UserLog;
use addons\cms\model\PromotionRecord;

/**
 * 推广单产生控制器
 * Class Index
 * @package app\promotion\controller
 */
class Index extends PromotionBase
{
    /**
     *
     */
    public function index()
    {
        if ($this->request->isGet()) {
            $nickname =  $this->request->get('n');
            $advertId =  $this->request->get('advertId');
            $userIdCode =  $this->request->get('u');
            $userIdCode = base64_decode($userIdCode);
            $userIdCode = urldecode($userIdCode);
            $userIdCode = explode('promoterId',$userIdCode);
            $userId = isset($userIdCode[1]) ? $userIdCode[1] : '';
            $advert =  PromotionUrlModel::get(['advert_id'=>$advertId]);
            if(empty($advert))
            {
                //广告不存在
                echo "<script>window.location.href='".Config::get('app_host')."'</script>";
            }

            //查看userId 是否真实存在
            $user = User::get($userId);

            if(empty($user)){
                //邀请人id不正确

            }
            $data = [
                'user_id'=> (int)$userId,
                'advert_id'=> (int)$advertId,
                'create_ip'=> $this->request->ip(),
            ];
            //正常情况
            //查看推广记录生成与否
            $isRecode = PromotionRecord::get($data);
            $advertData = ArchivesModel::get($advertId);
            //无此纪录
            if(!$isRecode){
                $data['type'] = 'add';
                $data['status'] = '1';
                $data['money'] = $advertData->prices;
                //开启事务
                Db::startTrans();
                //添加推广记录  promotionRecode
                $addRecord = PromotionRecord::create($data);
                //根据广告推广收益 添加推广人金额
                $userAccount = new User();
                $addAccount = $userAccount->where('id','=',$userId)->setInc('account',$advertData['prices']);
                if(!$addAccount||!$addRecord){
                    Db::rollback();
                }else{
                    Db::commit();
                }
            }
            //跳转到被推广产品网址
            echo "<script>window.location.href='".$advertData['url']."'</script>";



        }
    }

    public function ceshi()
    {
        $advertId = '30';
        $userCode = base64_encode('promoterId' . 1);
        $userId = urlencode(HelperTools::authcode($userCode,',',time(),'ENCODE'));
        echo "asdas";exit;
    }
}
