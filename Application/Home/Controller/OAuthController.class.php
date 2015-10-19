<?php
namespace Home\Controller;
use Think\Controller;

require_once('./Include/ThinkOAuth2.class.php');

class OAuthController extends Controller {
    public function __construct() {
        parent::__construct();

        $this->OAuth = new \ThinkOAuth2();
        $this->codeDb = D('oauth_codes');
        $this->tokenDb = D('oauth_token');
        
        //清除过期数据
        $this->codeDb->where(array('expires' => array('lt', time())))->delete();
        $this->tokenDb->where(array('expires' => array('lt', time())))->delete();

        if(ACTION_NAME != 'access_token' && ACTION_NAME != 'get_token_info'){
            //检查应用信息
            $this->params = $this->OAuth->getAuthorizeParams();
            $this->client = D('oauth_clients')->where(array('client_id' => $this->params['client_id'], 'client_status' => 1))->find();
            if(!$this->client) $this->error('非法请求（应用不存在) ');

            //检查是否缺少参数参数
            $check = array('state');
            foreach($check as $v){
                if(!isset($_GET[$v])) $this->error('非法请求（缺少参数）');
            }

            //TODO:检查scope
            $scopes = !empty($this->params['scope']) ? explode(",", $this->params['scope']) : NULL;
            $allows = explode(',', $this->client['client_aids']);
            $all_scope = D('api')->where(array('api_status' => 1))->getField('api_id, api_title, api_type', true);
            $result_scopes = array();
            
            foreach($scopes as $scope){
                if(!in_array($scope, $allows)) $this->error('非法请求（请求了一个非法接口）');
                if($all_scope[$scope]) $result_scopes[$scope] = $all_scope[$scope];
            }
            
            $this->scopes = $result_scopes;
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
                $this->assign('scopes', $this->scopes);
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
        $info = $this->tokenDb->where(array('access_token' => I('post.access_token'), 'expire_in' => array('GT', time())))->find();
        $scopes = D('api')->where(array('api_status' => 1))->getField('api_id', true);

        if($info){
            $client = D('oauth_clients')->where(array('client_id' => $info['client_id'], 'client_status' => 1))->find();
            if($client){
                $info_scopes = explode(',', $info['scope']);
                $client_scopes = explode(',', $client['client_aids']);
                $allow_scopes = array_intersect($scopes, array_intersect($info_scopes, $client_scopes));
                
                $return = array(
                    "uid" => $info['user_id'],
                    "client_id" => $info['client_id'],
                    "client_title" => $client['client_title'],
                    "scope" => !empty($allow_scopes) ? implode(',', $allow_scopes) : null,
                    "expire_in" => $info['expires'] - time(),
                    "status" => 'success'
                );
            }else $return['error'] = 'not_found_client';
        }else $return['error'] = 'not_found_token';

        if($return['error']) $return['status'] = 'fail';
        echo json_encode($return);
    }
}