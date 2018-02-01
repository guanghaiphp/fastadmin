<?php

namespace addons\cms\controller;

use addons\cms\model\Archives as ArchivesModel;
use addons\user\model\User;
use think\Config;
use addons\user\library\Auth;
use fast\HelperTools;
use addons\cms\library\PromotionBusiness;
use addons\cms\model\PromotionUrl as PromotionUrlModel;
use addons\cms\model\UserLog;
use addons\cms\model\PromotionRecord;
use think\Url;
use think\Validate;

class Promotion extends Base
{

    /**
     * 认证类
     * @var Auth
     */
    protected $auth = null;

    /**
     * 会员模型
     * @var User
     */
    protected $user = null;

    public function _initialize()
    {
        $this->auth = Auth::instance();

        $isLogin = $this->auth->isLogin();
        if(!$isLogin){
            return json('请点击个人中心进行登陆！');
        }
    }

    public function index()
    {
        $this->redirect('/');
    }
    /**
     * @return mixed|null|string
     */
    public function addAdvertUrlForMe()
    {
        if ($this->request->isPost()) {
            //未登录 提示
            $this->auth = Auth::instance();
            $this->auth->init();
            $isLogin = $this->auth->isLogin();
            if(!$isLogin){
                return json('请点击个人中心进行登陆！');
            }
            $advertId = $this->request->post('id');
            $archives = ArchivesModel::get($advertId);
            //广告不存在 提示
            if(empty($archives)){
                return json('此广告不存在，请刷新后重新查看');
            }
            $userinfo = User::get($this->auth->id);
            //生成我的推广链接
            //生成规则暂时按照用户id 和广告id和推广人昵称
            $userId = urlencode(base64_encode('promoterId' . $this->auth->id));
            $url = Config::get('app_host');
            $url.="/promotion/index";
            $url.="?advertId=".$advertId;
            $url.="&u=".$userId;
            $url.="&n=".$userinfo->nickname;
            return PromotionBusiness::addPromotionUrl($advertId, $this->auth->id, $url);
        }
    }
    /**
     * 赞与踩
     */
    public function vote()
    {
        $id = (int) $this->request->post("id");
        $type = trim($this->request->post("type", ""));
        if (!$id || !$type)
        {
            $this->error(__('Operation failed'));
        }
        $archives = ArchivesModel::get($id);
        if (!$archives || $archives['status'] == 'hidden')
        {
            $this->error(__('No specified article found'));
        }
        $archives->where('id', $id)->setInc($type === 'like' ? 'likes' : 'dislikes', 1);
        $archives = ArchivesModel::get($id);
        $this->success(__('Operation completed'), null, ['likes' => $archives->likes, 'dislikes' => $archives->dislikes, 'likeratio' => $archives->likeratio]);
    }

}
