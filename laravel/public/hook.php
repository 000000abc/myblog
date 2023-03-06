<?php


set_time_limit(0);
//git webhook 自动部署脚本
//项目存放物理路径,第一次clone时,必须保证该目录为空
//$savePath = "/var/www/myblog/laravel/";
//$gitPath  = "https://gitee.com/li_wan_yi/myblog.git";//代码仓库
//$email = "3357702725@qq.com}";//用户仓库邮箱
//$name  = "3357702725@qq.com}";//仓库用户名,一般和邮箱一致即可
//$isClone = true;//设置是否已经Clone到本地,true:已经clone,直接pull,false:先clone.
////如果已经clone过,则直接拉去代码
//
//if ($isClone) {
//    $requestBody = file_get_contents("php://input");
//    if (empty($requestBody)) {
//        die('send fail');
//    }
//
//    //解析Git服务器通知过来的JSON信息
//    $content = json_decode($requestBody, true);
//    //若是主分支且提交数大于0
//    if ($content['ref']=='refs/heads/master' && $content['total_commits_count']>0) {
//
//        $res = PHP_EOL."pull start --------".PHP_EOL;
//        $res .= shell_exec("cd {$savePath} && git pull {$gitPath}");//拉去代码
//        $res_log = '-------------------------'.PHP_EOL;
//        $res_log .= $content['user_name'] . ' 在' . date('Y-m-d H:i:s') . '向' . $content['repository']['name'] . '项目的' . $content['ref'] . '分支push了' . $content['total_commits_count'] . '个commit：';
//        $res_log .= $res.PHP_EOL;
//        $res_log .= "pull end --------".PHP_EOL;
//        file_put_contents("git-webhook_log.txt", $res_log, FILE_APPEND);//写入日志到log文件中
//    }
//}else {
//    $res = "clone start --------".PHP_EOL;
//    //注:在这里需要设置用户邮箱和用户名,不然后面无法拉去代码
//    $res .= shell_exec("git config --global user.email {$email}}").PHP_EOL;
//    $res .= shell_exec("git config --global user.name {$name}}").PHP_EOL;
//    $res .= shell_exec("git clone {$gitPath} {$savePath}").PHP_EOL;
//    $res .= "clone end --------".PHP_EOL;
//    var_dump($res);
////    file_put_contents("git-.txt", $res, FILE_APPEND);//写入日志到log文件中
//    echo '结束';
//}
// function writelog($message,$logFileDir){
//     $logFile = 'git_info.log';
//     $log = date('Y-m-d H:i:s') . ' - ' . $message . "\n";
//     $fp = fopen($logFileDir.$logFile, 'a+');
//     fwrite($fp, $log);
//     fclose($fp);
// }
//$target = dirname(__FILE__);
//$headers = getallheaders();
//var_dump($headers);
//var_dump('+++++++++++++++++++++++++++++++++++++++++++++++=');
//$target='/var/www/myblog/laravel/';
//$json = json_decode(file_get_contents("php://input"), true);
//var_dump($json);
//$password='20151627lwi';
//// writelog(json_encode($json));
//if (empty($json['password']) || $json['password'] !== $password) {
//    exit('error request');
//}
//$cmd=" cd {$target} ;sudo -Hu www git pull 2<&1";
//$r= shell_exec($cmd);
//print_r($r);
//echo date('Y-m-d H:i:s');
// 获取请求参数
////$headers = getallheaders();
//
//$body = json_decode(file_get_contents("php://input"), true);
//// 请求密码
//$password = '20151627lwi';
//
//// 验证提交分支是否为master
////if (!isset($body['ref']) || $body['ref'] !== 'refs/heads/master') {
////    echo  $body['ref'];
////    echo '非主分支' . $body;
////    exit(0);
////}
//
//// 验证提交密码是否正确
//if (!isset($body['password']) || $body['password'] !== $password) {
//    echo '密码错误';
//    exit(0);
//}
//
//
//// 验证成功，拉取代码 origin master
//
//$user = shell_exec("whoami"); //服务器上先把shell_exec和exec函数禁用解除
//file_put_contents('/tmp/hook.txt',$user);
////$command = 'cd /var/www/' . $body['project']['path'] .'/laravel'. ' && pwd &&  git pull 2>&1';
//$target='/var/www/myblog/laravel/';
//$cmd=" cd {$target} ; sudo -Hu www git pull  2<&1";
//$r= shell_exec($cmd);
//var_dump($r); //打印执行结果

$local = '/var/www/myblog/laravel/';
//仓库地址
$remote = 'https://gitee.com/li_wan_yi/myblog.git';

//密码
$password = '20151627lwi';

//获取请求参数
$request = file_get_contents('php://input');
if (empty($request)) {
    die('request is empty');
}

//验证密码是否正确
$data = json_decode($request, true);
if ($data['password'] != $password) {
    die('password is error');
}

echo shell_exec("cd {$local} && git pull {$remote} 2>&1");
die('done ' . date('Y-m-d H:i:s', time()));

