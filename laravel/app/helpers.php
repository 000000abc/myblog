<?php
/**
 * 返回可读性更好的文件尺寸
 */
function human_filesize($bytes, $decimals = 2)
{
    $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];
    $factor = floor((strlen($bytes) - 1) / 3);

    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}

/**
 * 判断文件的MIME类型是否为图片
 */
function is_image($mimeType)
{
    return starts_with($mimeType, 'image/');
}

/**
 * Return "checked" if true
 */
function checked($value)
{
    return $value ? 'checked' : '';
}

/**
 * Return img url for headers
 */
function page_image($value = null)
{
    if (empty($value)) {
        $value = config('blog.page_image');
    }
    if (!starts_with($value, 'http') && $value[0] !== '/') {
        $value = config('blog.uploads.webpath') . '/' . $value;
    }

    return $value;
}

/**
 * Return img url for
 */
function ENV_CONFIG($value = null)
{
    if (env('APP_ENV') == 'local') {
        return [
            'port' => '6379',
            'password' => 'bendi123',
        ];
    }
    return [
        'port' => '6399',
        'password' => 'lwi20151627',
    ];//product 端口
}

/**
 * 获取文件扩展名
 */
function getExt($url)
{
    $arr = parse_url($url);
    //Array ( [scheme] => http [host] => www.sina.com.cn [path] => /abc/de/fg.php [query] => id=1 )
    $file = basename($arr['path']);
    $ext = explode('.', $file);
    return end($ext); //优化后的代码
}

/**
 * 无限极分类
 */
function tree($arr, $pid = 0, $level = 0)
{
    static $list = array();
    foreach ($arr as $v) {
        //如果是顶级分类，则将其存到$list中，并以此节点为根节点，遍历其子节点
        if ($v['parent_id'] == $pid) {
            $v['level'] = $level;
            $list[] = $v;
            tree($arr, $v['cat_id'], $level + 1);
        }
    }
    return $list;
}

date_default_timezone_set('PRC');
/**
 * 获取给定月份的上一月最后一天
 * @param $date string 给定日期
 * @return string 上一月最后一天
 */

function get_last_month_last_day($date = '')
{
    if ($date != '') {
        $time = strtotime($date);

    } else {
        $time = time();

    }
    $day = date('j', $time);//获取该日期是当前月的第几天
    return date('Y-m-d', strtotime("-{$day} days", $time));
}

/**
 * @return bool|mixed|string
 * @decribe: 获取真实ip
 * date:2022/10/24 10:06
 * author:Lucky WanYi
 */
function get_real_ip()
{
    $ip = false;
    if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
        if ($ip) {
            array_unshift($ips, $ip);
            $ip = FALSE;
        }
        for ($i = 0; $i < count($ips); $i++) {
            if (!eregi("^(10|172.16|192.168).", $ips[$i])) {
                $ip = $ips[$i];
                break;
            }
        }
    }
    return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}


function get_position($ip)
{
    if (!$ip) {
        return '';
    }
    $result = json_encode(itbdw\Ip\IpLocation::getLocation($ip), JSON_UNESCAPED_UNICODE);
    $data = json_decode($result, true);
    return $data;
}

function getOsType()
{

    $os = "";
    $agent = $GLOBALS['_SERVER']["HTTP_USER_AGENT"];
    $os = "Unknown";
    if (preg_match('/win/i', $agent) && strpos($agent, '/95/i')) {

        $os = "Windows 95";

    } elseif (preg_match('/win 9x/i', $agent) && strpos($agent, '/4.90/i')) {

        $os = "Windows ME";

    } elseif (preg_match('/win/i', $agent) && preg_match('/ 98/i', $agent)) {

        $os = "Windows 98";

    } elseif (preg_match('/win/i', $agent) && preg_match('/nt 5.0/i', $agent)) {

        $os = "Windows 2000";

    } elseif (preg_match('/win/i', $agent) && preg_match('/nt/i', $agent)) {

        $os = "Windows NT";

    } elseif (preg_match('/win/i', $agent) && preg_match('/nt 5.1/i', $agent)) {

        $os = "Windows XP";

    } elseif (preg_match('/win/i', $agent) && preg_match('/32/i', $agent)) {

        $os = "Windows 32";

    } elseif (preg_match('/linux/i', $agent)) {

        $os = "Linux";

    } elseif (preg_match('/unix/i', $agent)) {

        $os = "Unix";

    } elseif (preg_match('/sun/i', $agent) && preg_match('/os/i', $agent)) {

        $os = "SunOS";

    } elseif (preg_match('/ibm/i', $agent) && preg_match('/os/i', $agent)) {

        $os = "IBM OS/2";

    } elseif (preg_match('/Mac/i', $agent) && preg_match('/PC/i', $agent)) {

        $os = "Macintosh";

    } elseif (preg_match('/PowerPC/i', $agent)) {

        $os = "PowerPC";

    } elseif (preg_match('/AIX/i', $agent)) {

        $os = "AIX";

    } elseif (preg_match('/HPUX/i', $agent)) {

        $os = "HPUX";

    } elseif (preg_match('/NetBSD/i', $agent)) {

        $os = "NetBSD";

    } elseif (preg_match('/BSD/i', $agent)) {

        $os = "BSD";

    } elseif (preg_match('/OSF1/i', $agent)) {

        $os = "OSF1";

    } elseif (preg_match('/IRIX/i', $agent)) {

        $os = "IRIX";

    } elseif (preg_match('/FreeBSD/i', $agent)) {

        $os = "FreeBSD";

    }

    return $os;

}

function my_get_browser()
{
    if (empty($_SERVER['HTTP_USER_AGENT'])) {
        return 'robot！';
    }
    if ((false == strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE)) {
        return 'Internet Explorer 11.0';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 10.0')) {
        return 'Internet Explorer 10.0';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 9.0')) {
        return 'Internet Explorer 9.0';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 8.0')) {
        return 'Internet Explorer 8.0';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.0')) {
        return 'Internet Explorer 7.0';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.0')) {
        return 'Internet Explorer 6.0';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'Edge')) {
        return 'Edge';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox')) {
        return 'Firefox';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome')) {
        return 'Chrome';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'Safari')) {
        return 'Safari';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'Opera')) {
        return 'Opera';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], '360SE')) {
        return '360SE';
    }
    //微信浏览器
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessage')) {
        return 'MicroMessage';
    }


}

/**
 * @return bool
 * @decribe: 判断是否是手机
 * date:2022/12/3 17:41
 * author:Lucky WanYi
 */
function isMobile()
{
    $useragent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    $useragent_commentsblock = preg_match('|\(.*?\)|', $useragent, $matches) > 0 ? $matches[0] : '';
    function CheckSubstrs($substrs, $text)
    {
        foreach ($substrs as $substr) if (false !== strpos($text, $substr)) {
            return true;
        }
        return false;
    }

    $mobile_os_list = array('Google Wireless Transcoder', 'Windows CE', 'WindowsCE', 'Symbian', 'Android', 'armv6l', 'armv5', 'Mobile', 'CentOS', 'mowser', 'AvantGo', 'Opera Mobi', 'J2ME/MIDP', 'Smartphone', 'Go.Web', 'Palm', 'iPAQ');
    $mobile_token_list = array('Profile/MIDP', 'Configuration/CLDC-', '160×160', '176×220', '240×240', '240×320', '320×240', 'UP.Browser', 'UP.Link', 'SymbianOS', 'PalmOS', 'PocketPC', 'SonyEricsson', 'Nokia', 'BlackBerry', 'Vodafone', 'BenQ', 'Novarra-Vision', 'Iris', 'NetFront', 'HTC_', 'Xda_', 'SAMSUNG-SGH', 'Wapaka', 'DoCoMo', 'iPhone', 'iPod');
    $found_mobile = CheckSubstrs($mobile_os_list, $useragent_commentsblock) || CheckSubstrs($mobile_token_list, $useragent);
    if ($found_mobile) {
        return 'phone';
    } else {
        return 'pc';
    }
}//执行函数if(isMobile()){        echo "手机端访问";    }else{        echo "电脑端访问";    }

// 计算今天是今年的第几天
function getDayOfYear()
{
    $now = new \DateTime();
    $startOfYear = new \DateTime($now->format('Y-01-01'));
    $diff = $now->diff($startOfYear);
    return $diff->format('%a') + 1;
}

// 计算今年剩余天数
function getDaysLeftInYear()
{
    $now = new \DateTime();
    $endOfYear = new \DateTime($now->format('Y-12-31'));
    $diff = $now->diff($endOfYear);
    return $diff->format('%a') + 1;
}
function get_today_date() {
    $timezone = 'Asia/Shanghai'; // 设置时区，根据实际情况进行调整
    $date = new DateTime('now', new DateTimeZone($timezone)); // 获取当前时间
    $today = $date->format('Y-m-d'); // 将当前时间格式化为YYYY-MM-DD的形式
    return $today;
}

