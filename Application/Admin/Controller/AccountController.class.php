<?php
namespace Admin\Controller;
use Think\Controller;

require_once './Include/OAuth2.client.class.php';

class AccountController extends AdminController {
    public function __construct() {
        parent::__construct();

        $this->OAuth = new \HmtTOAuthV2(getConfig('oauth_client_id'), getConfig('oauth_client_secret'));
    }

    public function signin(){
        if($this->worker){
            $this->redirect('Client/index');
            exit;
        }
        $state = randString();
        session('oauth_state', $state);
        redirect($this->OAuth->getAuthorizeURL(getConfig('system_domain').__CONTROLLER__.'/callback.html', 'code', $state));
    }

    public function callback(){
        if(session('oauth_state') != I('state')) $this->error('授权失败（请求已过期）');
        session('oauth_state', null);

        $keys['code'] = $_REQUEST['code'];
        $keys['redirect_uri'] = getConfig('system_domain').__CONTROLLER__.'/callback.html';
        $token = $this->OAuth->getAccessToken( 'code', $keys );

        $worker = D('system_worker')->where(array('uid' => $token['uid']))->find();
        if(!$worker) $this->error('非法请求（管理员不存在）');

        $cookie = authCode(json_encode($worker), 'ENCODE', getConfig('system_cookie_key'));
        cookie('worker', $cookie);

        $this->redirect('Client/index');
    }

    public function signout(){
        cookie('worker', null);
        echo '退出成功，如需重新登录，请点击<a href="signin.html">这里</a>';
    }
}