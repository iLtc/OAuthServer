<?php
namespace Home\Controller;
use Think\Controller;

require_once('./Include/ThinkOAuth2.class.php');

class OAuthController extends Controller {
    public function __construct() {
        parent::__construct();

        $this->OAuth = new \ThinkOAuth2();
        $this->tokenDb = D('oauth_token');


        if(ACTION_NAME == 'access_token'){

        }else{
            //检查应用信息
            $this->params = $this->OAuth->getAuthorizeParams();
            $this->client = D('oauth_clients')->where(array('client_id' => $this->params['client_id']))->find();

            //检查是否缺少参数参数
            $check = array('state');
            foreach($check as $v){
                if(!isset($_GET[$v])) $this->error('非法请求（缺少参数）');
            }

            //TODO:检查scope
        }
    }

    public function authorize(){
        $server_state = randString();
        session('server_state', $server_state);

        $callback = getConfig('system_domain').__CONTROLLER__.'/confirm.html';
        $params['query'] = $_GET;
        $callback_url = buildUri($callback, $params);

        $request = getConfig('bbs_plugin_uri');
        $params['query'] = array(
            'callback' => $callback_url,
            'server_state' => $server_state
        );

        redirect(buildUri($request, $params));
    }

    public function confirm(){
        $account = json_decode(authCode(I('token'), 'DECODE', getConfig('bbs_plugin_token')), true);
        if(!$account) $this->error('授权失败（登陆已过期）');

        if(session('server_state') != $account['state']) $this->error('授权失败（请求已过期）');
        unset($account['state']);

        if(IS_GET){
            //检查是否此前的授权未到期
            $search = array(
                'client_id' => $this->params['client_id'],
                'user_id' => $account['uid'],
                'expires' => array('gt', time())
            );
            if($this->params['scope']) $search['scope'] = $this->params['scope'];
            $token = $this->tokenDb->where($search)->find();

            if($token){
                $_GET['uid'] = $account['uid'];
                $this -> OAuth -> finishClientAuthorization(true, $_GET);
            }else{
                $this->assign('client_title', $this->client['client_title']);
                $this->assign('client_uri', $this->client['client_uri']);
                $this->assign('account', $account);
                $this->display('confirm_computer');
            }
        }else{
            session('server_state',null);
            if($_POST['action'] == '授权'){
                $_POST['uid'] = $account['uid'];
                $this -> OAuth -> finishClientAuthorization(true, $_POST);
            }else{
                $this -> OAuth -> finishClientAuthorization(false, $_POST);
            }
        }
    }

    public function access_token(){
        $this -> OAuth -> grantAccessToken();
    }

    public function get_token_info(){
        $info = $this->tokenDb->where(array('access_token' => I('post.access_token')))->find();

        if($info) $return = array(
            "uid" => $info['user_id'],
            "client_id" => $info['client_id'],
            "scope" => $info['scope'] ? $info['scope'] : null,
            "expire_in" => $info['expires'] - time()
        );
        else $return['error'] = 'not_found';

        echo json_encode($return);
    }

    //verifyAccessToken(
}