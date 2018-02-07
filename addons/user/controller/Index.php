<?php

namespace addons\user\controller;

use addons\user\library\Auth;
use addons\user\model\User;
use think\addons\Controller;
use think\Cookie;
use think\Db;
use think\Request;
use think\Session;
use think\Validate;
use addons\cms\model\PromotionUrl;
use addons\cms\model\PromotionRecord;

/**
 * 会员中心
 */
class Index extends Controller
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
        parent::_initialize();
        $this->view->engine->layout('layout/common');
        $this->auth = Auth::instance();
        $this->auth->init();
        $this->user = $this->auth->getModel();
        $this->user->status = 1;
//        $this->user->url_count = 0;
//        $this->user->record_count = 0;
        //用户登陆后自定义查询用户信息
        if(isset($this->user->id)&&!empty($this->user->id)){
            //推广链接
            $urldata = [
                'user_id' =>(int)$this->user->id,
            ];
            $promotionData = PromotionUrl::all($urldata);

//            if(!empty($promotionData)){
//                $this->user->url_count = count($promotionData);
//            }
            //收益详情
            $recordData = [
                'user_id' =>(int)$this->user->id,
            ];
            $recordata = PromotionRecord::all($recordData);
//            if(!empty($recordata)){
//                $this->user->record_count = count($recordata);
//            }
        }
        $this->view->assign('user', $this->user);

    }

    public function index()
    {
        return $this->view->fetch();
    }

    /**
     * 注册会员
     */
    public function register()
    {
        $url = $this->request->request('url', addon_url('user/index/index'));
        if ($this->auth->check())
            $this->error(__('You\'ve logged in, do not login again'), $url);
        Session::set('redirect_url', $url);
        if ($this->request->isPost())
        {
            $username = $this->request->post('username');
            $password = $this->request->post('password');
            $email = $this->request->post('email');
            $mobile = $this->request->post('mobile', '');
            $captcha = $this->request->post('captcha');
            $token = $this->request->post('__token__');
            $rule = [
                'username'  => 'require|length:6,30',
                'password'  => 'require|length:6,30',
                'email'     => 'require|email',
                'mobile'    => 'regex:/^1\d{10}$/',
                'captcha'   => 'require|captcha',
                '__token__' => 'token',
            ];

            $msg = [
                'username.require' => 'Username can not be empty',
                'username.length'  => 'Username must be 6 to 30 characters',
                'password.require' => 'Password can not be empty',
                'password.length'  => 'Password must be 6 to 30 characters',
                'captcha.require'  => 'Captcha can not be empty',
                'captcha.captcha'  => 'Captcha is incorrect',
                'email'            => 'Email is incorrect',
                'mobile'           => 'Mobile is incorrect',
            ];
            $data = [
                'username'  => $username,
                'password'  => $password,
                'email'     => $email,
                'mobile'    => $mobile,
                'captcha'   => $captcha,
                '__token__' => $token,
            ];
            $validate = new Validate($rule, $msg);
            $result = $validate->check($data);
            if (!$result)
            {
                $this->error($validate->getError());
                return FALSE;
            }

            if ($this->auth->register($username, $password, $email, $mobile))
            {
                $synchtml = '';
                ////////////////同步到Ucenter////////////////
                if (defined('UC_STATUS') && UC_STATUS)
                {
                    $uc = new \addons\ucenter\library\client\Client();
                    $synchtml = $uc->uc_user_synregister($this->auth->id, $password);
                }
                $referer = Cookie::get('referer_url');
                redirect()->restore();
                $this->success(__('Sign up successful') . $synchtml);
            }
            else
            {
                $this->error($this->auth->getError());
            }
        }
        return $this->view->fetch();
    }

    /**
     * 会员登录
     */
    public function login()
    {
        $url = $this->request->request('url', addon_url('user/index/index'));
        if ($this->auth->check())
            $this->error(__('You\'ve logged in, do not login again'), $url);
        Session::set('redirect_url', $url);
        if ($this->request->isPost())
        {
            $account = $this->request->post('account');
            $password = $this->request->post('password');
            $token = $this->request->post('__token__');
            $rule = [
                'account'   => 'require|length:6,50',
                'password'  => 'require|length:6,30',
                '__token__' => 'token',
            ];

            $msg = [
                'account.require'  => 'account can not be empty',
                'password.require' => 'Password can not be empty',
                'password.length'  => 'Password must be 6 to 30 characters',
            ];
            $data = [
                'account'   => $account,
                'password'  => $password,
                '__token__' => $token,
            ];
            $validate = new Validate($rule, $msg);
            $result = $validate->check($data);
            if (!$result)
            {
                $this->error($validate->getError());
                return FALSE;
            }
            if ($this->auth->login($account, $password))
            {
                $synchtml = '';
                ////////////////同步到Ucenter////////////////
                if (defined('UC_STATUS') && UC_STATUS)
                {
                    $uc = new \addons\ucenter\library\client\Client();
                    $synchtml = $uc->uc_user_synlogin($this->auth->id);
                }
                $this->success(__('Logged in successful') . $synchtml, $url);
            }
            else
            {
                $this->error($this->auth->getError());
            }
        }
        return $this->view->fetch();
    }

    /**
     * 注销登录
     */
    function logout()
    {
        //注销本站
        $this->auth->logout();
        $synchtml = '';
        ////////////////同步到Ucenter////////////////
        if (defined('UC_STATUS') && UC_STATUS)
        {
            $uc = new \addons\ucenter\library\client\Client();
            $synchtml = $uc->uc_user_synlogout();
        }
        $this->success(__('Logout successful') . $synchtml, addon_url('user/index/index'));
    }

    /**
     * 第三方登录跳转和回调处理
     */
    public function third()
    {
        $url = addon_url('user/index/index');
        $action = $this->request->param('action');
        $platform = $this->request->param('platform');
        $config = get_addon_config('third');
        if (!$config || !isset($config[$platform]))
        {
            $this->error(__('Invalid parameters'));
            return;
        }
        $thirdapp = new \addons\third\library\Application();
        if ($action == 'redirect')
        {
            // 跳转到登录授权页面
            $this->redirect($thirdapp->{$platform}->getAuthorizeUrl());
        }
        else if ($action == 'callback')
        {
            // 授权成功后的回调
            $result = $thirdapp->{$platform}->getUserInfo();
            if ($result)
            {
                $loginret = \addons\third\library\Service::connect($platform, $result);
                if ($loginret)
                {
                    $synchtml = '';
                    ////////////////同步到Ucenter////////////////
                    if (defined('UC_STATUS') && UC_STATUS)
                    {
                        $uc = new \addons\ucenter\library\client\Client();
                        $synchtml = $uc->uc_user_synlogin($this->auth->id);
                    }
                    $this->success(__('Logged in successful') . $synchtml, $url);
                    return;
                }
            }
            $this->error(__('Operation failed'), $url);
        }
        else
        {
            $this->error(__('Invalid parameters'));
        }

        return;
    }

    /**
     * 修改密码
     */
    public function changepwd()
    {
        if ($this->request->isPost())
        {

            $oldpassword = $this->request->post("oldpassword");
            $newpassword = $this->request->post("newpassword");
            $ret = $this->auth->changepwd($newpassword, $oldpassword);
            if ($ret)
            {
                $this->auth->logout();

                $synchtml = '';
                ////////////////同步到Ucenter////////////////
                if (defined('UC_STATUS') && UC_STATUS)
                {
                    $uc = new \addons\ucenter\library\client\Client();
                    $synchtml = $uc->uc_user_synlogout();
                }
                $this->success(__('Change password successful') . $synchtml, addon_url('user/index/login'));
            }
            else
            {
                $this->error($this->auth->getError());
            }
        }
        return $this->fetch();
    }

    /**
     * 查询推广详情
     * @id 用户id
     */
    public function PromotionUrl()
    {
        //用户登陆后自定义查询用户信息
        if (isset($this->user->id) && !empty($this->user->id)) {
            //推广链接
            $user_id = [
                'user_id' => (int)$this->user->id,
            ];
            $PromotionData = Db::table('fa_promotion_url')
                ->join("fa_archives", "fa_promotion_url.advert_id = fa_archives.id")
                ->where($user_id)
                ->paginate(10);
            // 获取分页显示
            $page = $PromotionData->render();

            $this->assign('Data', $PromotionData->items());
            $this->assign('page', $page);
            return $this->fetch();
        }
    }

    /*
     * 删除推广记录
     */
    public function PromotionUrlDelete($id=''){
        $advert_id=$_GET['id'];
        //用户登陆后自定义查询用户信息
        if (isset($this->user->id) && !empty($this->user->id)) {
            //删除限制条件
            $user_id = [
                'user_id'  => (int)$this->user->id,
                'advert_id'=>$advert_id
            ];
            $result = Db::table('fa_promotion_url')->where($user_id)->delete();
            if ($result){
                return $this->success('删除成功','/addons/user/index/PromotionUrl.html');
            }
        }

    }
    /**
     * 查询推广记录
     */
    public function PromotionRecord(){
        //用户登陆后自定义查询用户信息
        if(isset($this->user->id)&&!empty($this->user->id)) {
            //查询推广记录
            $user_id = [
                'user_id' => (int)$this->user->id
            ];
            $PromotionRecord = Db::table('fa_promotion_record')
                ->join("fa_archives","fa_promotion_record.advert_id = fa_archives.id")
                ->where($user_id)
                ->paginate(10);

            $this->assign('Data', $PromotionRecord);

            return $this->fetch();
        }
    }
}
