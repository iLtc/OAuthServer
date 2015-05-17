<?php
/*
 * 加/解密函数
 */
function authCode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
    if($key == '') $key = C('authcode');
    $ckey_length = 4;
    $key = md5($key ? $key : UC_KEY);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    for($i = 0; $i <= 255; $i++) $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if($operation == 'DECODE') {
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc.str_replace('=', '', base64_encode($result));
    }
}

/*
* 检测 pjax 请求
*/
function is_pjax_request(){
    return (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == 'true');
}

/*
 *产生MD5码
 */
function randString($l = 32){
    $chars = '1234567890abcdefhijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $str = '';
    for ( $i = 0; $i < $l; $i++ ) {
        $str .= $chars[ mt_rand(0, strlen($chars) - 1) ];
    }
    return $str;
}

/*
 * 读取配置参数
 */
function getConfig($name){
    $value = M('system_config')->where(array('name'=>$name))->cache('config_'.$name)->getField('value');
    return $value;
}

/*
 * curl POST请求
 */
function curlPost($url, $post){
    $ch = curl_init();//初始化curl

    curl_setopt($ch,CURLOPT_URL, $url);//抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $data = curl_exec($ch);//运行curl
    curl_getinfo($ch,CURLINFO_HTTP_CODE); //我知道HTTPSTAT码哦～
    curl_close($ch);

    return $data;
}

/*
 * curl GET请求
 */
function curlGet($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

/*
 * 建立URI
 */
function buildUri($uri, $params) {
    $parse_url = parse_url($uri);

    // Add our params to the parsed uri
    foreach ($params as $k => $v) {
        if (isset($parse_url[$k]))
            $parse_url[$k] .= "&" . http_build_query($v);
        else
            $parse_url[$k] = http_build_query($v);
    }

    // Put humpty dumpty back together
    return
        ((isset($parse_url["scheme"])) ? $parse_url["scheme"] . "://" : "")
        . ((isset($parse_url["user"])) ? $parse_url["user"] . ((isset($parse_url["pass"])) ? ":" . $parse_url["pass"] : "") . "@" : "")
        . ((isset($parse_url["host"])) ? $parse_url["host"] : "")
        . ((isset($parse_url["port"])) ? ":" . $parse_url["port"] : "")
        . ((isset($parse_url["path"])) ? $parse_url["path"] : "")
        . ((isset($parse_url["query"])) ? "?" . $parse_url["query"] : "")
        . ((isset($parse_url["fragment"])) ? "#" . $parse_url["fragment"] : "");
}