<?php
/**
 * @category ORG
 * @package ORG
 * @author Leyteris
 * @version 2012.3.16
 */

// OAUTH2_DB_DSN  数据库连接DSN
// OAUTH2_CODES_TABLE 服务器表名称
// OAUTH2_CLIENTS_TABLE 客户端表名称
// OAUTH2_TOKEN_TABLE 验证码表名称

require_once('./Include/OAuth2.server.class.php');

class ThinkOAuth2 extends OAuth2 {

	private $db;
	private $table;

	/**
	 * 构造
	 */
	public function __construct() {
		parent::__construct();
		$this -> db = new \Think\Model();
		$this -> table = array(
			'auth_codes'=>C('OAUTH2_TABLES.CODES'),
			'clients'=>C('OAUTH2_TABLES.CLIENTS'),
			'tokens'=>C('OAUTH2_TABLES.TOKEN')
		);
	}

	/**
	 * 析构
	 */
	function __destruct() {
		$this->db = NULL; // Release db connection
	}

	private function handleException($e) {
		echo "Database error: " . $e->getMessage();
		exit;
	}

	/**
	 * Implements OAuth2::checkClientCredentials()
	 * @see OAuth2::checkClientCredentials()
	 */
	protected function checkClientCredentials($client_id, $client_secret = NULL) {

		$sql = "SELECT client_secret FROM {$this -> table['clients']} ".
			"WHERE client_id = \"{$client_id}\"";

		$result = $this -> db -> query($sql);
		if ($client_secret === NULL) {
			return $result !== FALSE;
		}

		//Log::write("checkClientCredentials : ".$result);
		//Log::write("checkClientCredentials : ".$result[0]);
		//Log::write("checkClientCredentials : ".$result[0]["client_secret"]);
		
		return $result[0]["client_secret"] == $client_secret;
		
	}

	/**
	 * Implements OAuth2::getRedirectUri().
	 * @see OAuth2::getRedirectUri()
	 */
	protected function getRedirectUri($client_id) {
		
		$sql = "SELECT redirect_uri FROM {$this -> table['clients']} ".
			"WHERE client_id = \"{$client_id}\"";
		
		$result = $this -> db -> query($sql);
		if (!$result) {
			return FALSE;
		}
		
		//Log::write("getRedirectUri : ".$result);
		//Log::write("getRedirectUri : ".$result[0]);
		//Log::write("getRedirectUri : ".$result[0]["redirect_uri"]);
		
		return isset($result[0]["redirect_uri"]) && $result[0]["redirect_uri"] ? $result[0]["redirect_uri"] : NULL;
		
	}

	/**
	 * Implements OAuth2::getAccessToken().
	 * @see OAuth2::getAccessToken()
	 */
	protected function getAccessToken($access_token) {
		
		$sql = "SELECT client_id, expires, scope FROM {$this -> table['tokens']} ".
			"WHERE access_token = \"{$access_token}\"";
		
		$result = $this -> db -> query($sql);
		
		//Log::write("getAccessToken : ".$result);
		//Log::write("getAccessToken : ".$result[0]);
		
		return $result ? $result : NULL;
		
	}

	/**
	 * Implements OAuth2::setAccessToken().
	 * @see OAuth2::setAccessToken()
	 */
	protected function setAccessToken($access_token, $client_id, $expires, $scope = NULL, $user_id) {
		
		$sql = "INSERT INTO {$this -> table['tokens']} ".
			"(access_token, client_id, expires, scope, user_id) ".
			"VALUES (\"{$access_token}\", \"{$client_id}\", \"{$expires}\", \"{$scope}\", \"{$user_id}\")";
		
		$this -> db -> execute($sql);
		
	}

	/**
	 * Overrides OAuth2::getSupportedGrantTypes().
	 * @see OAuth2::getSupportedGrantTypes()
	 */
	protected function getSupportedGrantTypes() {
		return array(
			OAUTH2_GRANT_TYPE_AUTH_CODE
		);
	}

	/**
	 * Overrides OAuth2::getAuthCode().
	 * @see OAuth2::getAuthCode()
	 */
	protected function getAuthCode($code) {
		
		$sql = "SELECT code, client_id, redirect_uri, expires, scope, user_id ".
			"FROM {$this -> table['auth_codes']} WHERE code = \"{$code}\"";
		
		$result = $this -> db -> query($sql);
		
		//Log::write("getAuthcode : ".$result);
		//Log::write("getAuthcode : ".$result[0]);
		//Log::write("getAuthcode : ".$result[0]["code"]);
		
		return $result ? $result[0] : NULL;

	}

	/**
	 * Overrides OAuth2::setAuthCode().
	 * @see OAuth2::setAuthCode()
	 */
	protected function setAuthCode($code, $client_id, $redirect_uri, $expires, $scope = NULL, $user_id) {
		
		$time = time();
		$sql = "INSERT INTO {$this -> table['auth_codes']} ".
			"(code, client_id, redirect_uri, expires, scope, user_id) ".
                        "VALUES (\"${code}\", \"${client_id}\", \"${redirect_uri}\", \"${expires}\", \"${scope}\", \"${user_id}\")";
		
		$result = $this -> db -> execute($sql);
    }

    protected function createAccessToken($client_id, $scope = NULL, $uid) {
        //检查是否有已存在的授权
        $db = D('oauth_token');
        $search = array(
            'client_id' => $client_id,
            'user_id' => $uid,
            'expires' => array('gt', time())
        );
        if($scope) $search['scope'] = $this->params['scope'];
        $history = $db->where($search)->find();

        if($history){
            $db->where(array('id' => $history['id']))->setField('expires', time() + $this->getVariable('access_token_lifetime', OAUTH2_DEFAULT_ACCESS_TOKEN_LIFETIME));
            $token = array(
                "access_token" => $history['access_token'],
                "expires_in" => $this->getVariable('access_token_lifetime', OAUTH2_DEFAULT_ACCESS_TOKEN_LIFETIME),
                "scope" => $history['scope'],
                "uid" => $history['user_id']
            );
        }else{
            $token = array(
                "access_token" => $this->genAccessToken(),
                "expires_in" => $this->getVariable('access_token_lifetime', OAUTH2_DEFAULT_ACCESS_TOKEN_LIFETIME),
                "scope" => $scope,
                "uid" => $uid
            );

            $this->setAccessToken($token["access_token"], $client_id, time() + $this->getVariable('access_token_lifetime', OAUTH2_DEFAULT_ACCESS_TOKEN_LIFETIME), $scope, $uid);

            // Issue a refresh token also, if we support them
            if (in_array(OAUTH2_GRANT_TYPE_REFRESH_TOKEN, $this->getSupportedGrantTypes())) {
                $token["refresh_token"] = $this->genAccessToken();
                $this->setRefreshToken($token["refresh_token"], $client_id, time() + $this->getVariable('refresh_token_lifetime', OAUTH2_DEFAULT_REFRESH_TOKEN_LIFETIME), $scope);
                // If we've granted a new refresh token, expire the old one
                if ($this->getVariable('_old_refresh_token'))
                    $this->unsetRefreshToken($this->getVariable('_old_refresh_token'));
            }
        }
        return $token;
    }
}