<?php
/**
 * Created by PhpStorm.
 * User: 304455977@qq.com
 * Date: 2017/9/30
 * Time: 10:00
 */

namespace app\logic;


class Tool
{
    static function cutstr($string, $length, $dot = '...',$charset="utf-8")
    {/*{{{*/
        if(strlen($string)<= $length)
        {
            return $string;
        }
        $string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);
        $strcut = '';
        if(strtolower($charset) == 'utf-8')
        {
            $n = $tn = $noc = 0;
            while($n < strlen($string))
            {
                $t = ord($string[$n]);
                if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                    $tn = 1; $n++; $noc++;
                } elseif(194 <= $t && $t <= 223) {
                    $tn = 2; $n += 2; $noc += 2;
                } elseif(224 <= $t && $t <= 239) {
                    $tn = 3; $n += 3; $noc += 2;
                } elseif(240 <= $t && $t <= 247) {
                    $tn = 4; $n += 4; $noc += 2;
                } elseif(248 <= $t && $t <= 251) {
                    $tn = 5; $n += 5; $noc += 2;
                } elseif($t == 252 || $t == 253) {
                    $tn = 6; $n += 6; $noc += 2;
                } else {
                    $n++;
                }

                if($noc >= $length) {
                    break;
                }
            }
            if($noc > $length)
            {
                $n -= $tn;
            }
            $strcut = substr($string, 0, $n);
        }
        else
        {
            for($i = 0; $i < $length; $i++) {
                $strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
            }
        }
        $strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);
        return $strcut.$dot;
    }/*}}}*/
    public static function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
        // 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
        $ckey_length = 4;

        // 密匙
        $key = md5($key ? $key : $GLOBALS['discuz_auth_key']);

        // 密匙a会参与加解密
        $keya = md5(substr($key, 0, 16));
        // 密匙b会用来做数据完整性验证
        $keyb = md5(substr($key, 16, 16));
        // 密匙c用于变化生成的密文
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length):
            substr(md5(microtime()), -$ckey_length)) : '';
        // 参与运算的密匙
        $cryptkey = $keya.md5($keya.$keyc);
        $key_length = strlen($cryptkey);
         $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) :
            sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
        $string_length = strlen($string);
        $result = '';
        $box = range(0, 255);
        $rndkey = array();
        // 产生密匙簿
        for($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }
        // 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度
        for($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        // 核心加解密部分
        for($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            // 从密匙簿得出密匙进行异或，再转成字符
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        if($operation == 'DECODE') {
            // 验证数据有效性，请看未加密明文的格式
            if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) &&
                substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {

            return $keyc.str_replace('=', '', base64_encode($result));
        }
    }
    public static function checkPhone($phone){
         $pattern = "/^13[0-9]{1}[0-9]{8}$|17[0123456789]{1}[0-9]{8}$|15[0123456789]{1}[0-9]{8}$|18[0123456789]{1}[0-9]{8}$|14[57]{1}[0-9]{8}$/";
        return preg_match($pattern,$phone);
    }
    public static function checkEmail($email){
        $pattern ="/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
        return preg_match($pattern,$email);

    }

    public static  function buildUrl($arr){
        $str='';
        foreach($arr as $key=>$val){
            $str.="$key=$val&";
        }
        return substr($str,0,-1);
    }
   public static  function getnowurl(){
        if(!isset($_SERVER['REQUEST_URI'])) {//获得当前url
            $_SERVER['REQUEST_URI'] = $_SERVER['PHP_SELF'];
            if(isset($_SERVER['QUERY_STRING'])) $_SERVER['REQUEST_URI'] .= '?'.$_SERVER['QUERY_STRING'];
        }
        return $_SERVER['REQUEST_URI'];
    }
   public static function get_extension($file)
    {
        return substr($file, strrpos($file, '.')+1);
    }
    public static function getHumanTime($secs)
    {
        $msg = '';
        $hour = 60*60;
        $day = $hour*24;
        if($secs<60){
            $msg =$secs.'秒前';
        }else if($secs<$hour){
            $msg = ceil($secs/60) . '分钟前';
        }else if($secs<$day){
            $msg = ceil($secs/$hour) . '小时前';
        }else{
            $msg = ceil($secs/$day) . '天前';
        }
        return $msg;
    }
    public static function get_randstr($random_length) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $random_string = '';
        for ($i = 0; $i < $random_length; $i++) {
            $random_string .= $chars [mt_rand(0, strlen($chars) - 1)];
        }
        return $random_string;
    }
    /**
     * 转化html为 javascript
     * @param $html
     * @return unknown_type
     */
   public static   function html2js($html=''){
        $html = str_replace('"', '\"',$html);
        $html = str_replace("\r", "\\r",$html);
        $html = str_replace("\n", "\\n",$html);
        $html = "<!--\r\ndocument.write(\"{$html}\");\r\n-->\r\n";
        return $html;
    }
}