<?php
namespace Admin\Controller;
use Think\Controller;
class AdminController extends Controller {
    private $account;

    public function __construct() {
        parent::__construct();

        $force_login = (CONTROLLER_NAME == 'Account'
            && (ACTION_NAME == 'signin' || ACTION_NAME == 'callback' || ACTION_NAME == 'signout')) ?
            false : true;
        $this->worker = $this->checkSignin($force_login);
        $this->assign('worker', $this->worker);
    }

    private function checkSignin($force_login = false){
        $worker = $this->deWorkerCookie();
        if($worker){
            return $worker;
        }else{
            if($force_login) $this->redirect('Account/signin');
            else return false;
        }
    }

    /*
     * 读取用户信息
     */
    private function deWorkerCookie(){
        if(cookie('worker') != '' && $user = json_decode(authCode(cookie('worker'), 'DECODE', getConfig('system_cookie_key')), true))
            return $user;
        else return false;
    }
}