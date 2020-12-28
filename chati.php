<?php
include "wechat.class.php";
function getda($w){
	$r=file_get_contents("http://jk.fm210.cn/wangke/anci/yh1.php?yhm=cs&w=".$w);
	$s=json_decode($r,true);
	if($s['code']==200)
	{
		$tm=$s['tm'];
		$da=$s['da'];
		return "❤：$tm"."\n"."💙:$da"."\n"."<a href=\"https://baidu.com\">这是一个后缀</a>";
		
	}
	else{
		return $s['msg'];
		
	}
}


$options = array(
		'token'=>'123456', //填写你设定的key
        '填写加密用的EncodingAESKey'=>'encodingaeskey' //填写加密用的EncodingAESKey，如接口为明文模式可忽略
	);
$weObj = new Wechat($options);
//$weObj->valid();//明文或兼容模式可以在接口验证通过后注释此句，但加密模式一定不能注释，否则会验证失败

$type = $weObj->getRev()->getRevType();
$w=$weObj->getRev()->getRevContent();//接收消息

switch($type) {
	case Wechat::MSGTYPE_TEXT://文本消息

			$weObj->text(getda($w))->reply();
			exit;
			break;
	case Wechat::MSGTYPE_EVENT://关注消息
			$weObj->text("关注消息")->reply();
			exit;
			break;
	default://语音
			$weObj->text(getda($w))->reply();
			exit;
}