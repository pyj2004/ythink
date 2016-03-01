<?php

// /**
//  * 友好调试输出
//  * @param unknown $var
//  * @param string $echo
//  * @param string $label
//  * @return NULL|string
//  */
// function dump($var, $echo = true, $label = null) {
// 	$label = (null === $label) ? '' : rtrim ( $label ) . ':';
// 	ob_start ();
// 	var_dump ( $var );
// 	$output = ob_get_clean ();
// 	$output = preg_replace ( '/\]\=\>\n(\s+)/m', '] => ', $output );
// 	if (false) {
// 		$output = PHP_EOL . $label . $output . PHP_EOL;
// 	} else {
// 		if (! extension_loaded ( 'xdebug' )) {
// 			$output = htmlspecialchars ( $output, ENT_QUOTES );
// 		}
// 		$output = '<pre>' . $label . $output . '</pre>';
// 	}
// 	if ($echo) {
// 		echo ($output);
// 		return null;
// 	} else {
// 		return $output;
// 	}
// }
/**
 * 输出并终止
 *
 * @param string $str        	
 */
function we($str = '') {
	//header ( "Content-Type: text/html; charset=UTF-8" );
	dump ( $str );
	exit ();
}

/**
 * 调试日志
 *
 * @param unknown $text        	
 */
function logdebug($text) {
	file_put_contents ( 'log.txt', $text . "\n", FILE_APPEND );
}

/**
 * 清除html
 *
 * @param string $str        	
 * @param number $len        	
 * @return string
 */
function htmlclr($str = '', $len = 0) {
	$str = strip_tags ( $str );
	$str = str_replace ( "\n", "", $str );
	if ($len) {
		$str = cut_str ( $str, 0, $len );
	}
	$str = trim ( $str );
	return $str;
}

/**
 * 判断请求是否为空:特点-0为false
 */
function isN($str = null) {
	if (isset ( $str )) {
		if (strlen ( $str ) > 0)
			return false; // 是否是字符串类型
	}
	if (empty ( $str ))
		return true; // 是否已设定
	if ($str == '')
		return true; // 是否为空
	return true;
}

/**
 * 转换为货币格式:0->0.00
 *
 * @param unknown $num        	
 * @return string
 */
function to_price($num = 0) {
	if (! is_numeric ( $num )) {
		$num = 0;
	}
	$num = sprintf ( "%01.2f", $num );
	return $num;
}

/**
 * 转换为百分比:0->0.00%
 *
 * @param number $num        	
 * @return string
 */
function to_percent($num = 0) {
	if (! is_numeric ( $num )) {
		$num = 0;
	}
	$num = sprintf ( "%01.2f", $num * 100 ) . '%';
	return $num;
}

/**
 * 字符串截取：默认20个字符
 *
 * @param string $str        	
 * @param number $start        	
 * @param number $len        	
 * @param string $ext        	
 * @return string
 */
function cut_str($str = null, $start = 0, $len = 20, $ext = '...') {
	if (strlen ( $str ) > $len) {
		$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
		preg_match_all ( $pa, $str, $t_string );
		if (count ( $t_string [0] ) - $start > $len) {
			$str = join ( '', array_slice ( $t_string [0], $start, $len ) );
			$str .= $ext;
		}
	}
	return $str;
}

/**
 * 创建多层目录
 *
 * @param string $dirs        	
 * @param number $mode        	
 * @return boolean
 */
function mkdirs($dirs = '', $mode = 0777) {
	if (! is_dir ( $dirs )) {
		mkdirs ( dirname ( $dirs ), $mode );
		$ret = @mkdir ( $dirs, $mode );
		chmod ( $dirs, $mode );
		return $ret;
	}
	return true;
}

/**
 * 不存在就新建文件
 */
function create_file($l1, $l2 = '') {
	$l1 = str_replace ( '//', '/', $l1 );
	if (! file_exists ( $l1 )) {
		write_file ( $l1, $l2 );
		return true;
	} else {
		return true;
	}
}

/**
 * 生成文件并写入内容，自动创建多层目录
 *
 * @param string $filename
 *        	相对路径: ./1/2/3.html
 * @param string $content        	
 */
function write_file($filename = '', $content = '') {
	$dir = dirname ( $filename );
	if (! is_dir ( $dir )) {
		mkdirs ( $dir );
	}
	$file = @file_put_contents ( $filename, $content );
	chmod ( $filename, 0777 );
	return $file;
}

/**
 * 写入数组到文件
 *
 * @param string $filename        	
 * @param string $arr        	
 */
function arr2file($filename = '', $arr = '') {
	if (is_array ( $arr )) {
		// 数组转字符串
		$con = var_export ( $arr, true );
	} else {
		$con = $arr;
	}
	$con = "<?php\nreturn $con;\n?>";
	write_file ( $filename, $con );
}

/**
 * 数组清洁工作:注意会把0抹掉！
 *
 * @param unknown $arr        	
 * @return multitype:
 */
function arr2clr($arr = null) {
	$arr = array_filter ( $arr );
	$arr = array_unique ( $arr );
	return $arr;
}

/**
 * 字符串转换成数组：默认以逗号分割
 *
 * @param string $str        	
 * @param string $glue        	
 * @return multitype:
 */
function str2arr($str = '', $glue = ',') {
	return explode ( $glue, $str );
}

/**
 * 数组转换成字符串：默认以逗号分割
 *
 * @param string $arr        	
 * @param string $glue        	
 * @return string
 */
function arr2str($arr = null, $glue = ',') {
	return implode ( $glue, $arr );
}

/**
 * 二维数组根据指定键值排序
 *
 * @param string $arr        	
 * @param string $keys        	
 * @param string $type        	
 * @return multitype:string
 */
function array_sort($arr = null, $keys = '', $type = 'asc') {
	$keysvalue = $new_array = array ();
	foreach ( $arr as $k => $v ) {
		$keysvalue [$k] = $v [$keys];
	}
	if ($type == 'asc') {
		asort ( $keysvalue );
	} else {
		arsort ( $keysvalue );
	}
	reset ( $keysvalue );
	foreach ( $keysvalue as $k => $v ) {
		$new_array [$k] = $arr [$k];
	}
	return $new_array;
}

/**
 * 数字时间转换成友好可读形式
 *
 * @param string $time        	
 * @param string $format        	
 * @return string
 */
function time_format($time = NULL, $format = 'Y-m-d H:i:s') {
	$time = $time === NULL ? NOW_TIME : intval ( $time );
	return date ( $format, $time );
}

/**
 * 日期格式转换
 *
 * @param unknown $date        	
 * @param string $format        	
 */
function date2format($date = '', $format = 'Y-m-d') {
	if ($date == '') {
		return '';
	} else {
		if (is_number ( $date )) {
			return date ( $format, $date );
		} else {
			return time_format ( strtotime ( $date ), $format );
		}
	}
}

/**
 * 字节格式化
 *
 * @param number $size        	
 * @param string $delimiter        	
 * @return string
 */
function format_bytes($size = 0, $delimiter = '') {
	$units = array (
			'B',
			'KB',
			'MB',
			'GB',
			'TB',
			'PB' 
	);
	for($i = 0; $size >= 1024 && $i < 5; $i ++)
		$size /= 1024;
	return round ( $size, 2 ) . $delimiter . $units [$i];
}

/**
 * 解析配置:键=>值，如：a:名称1,b:名称2，返回数组形式
 *
 * @param string $string        	
 * @return Ambigous <multitype:, multitype:multitype: >
 */
function parse_config($string = '') {
	if (0 === strpos ( $string, ':' )) {
		// 采用函数定义
		return eval ( substr ( $string, 1 ) . ';' );
	}
	$array = preg_split ( '/[,;\r\n]+/', trim ( $string, ",;\r\n" ) );
	if (strpos ( $string, ':' )) {
		$value = array ();
		foreach ( $array as $val ) {
			list ( $k, $v ) = explode ( ':', $val );
			$value [$k] = $v;
		}
	} else {
		$value = $array;
	}
	return $value;
}

/**
 * 生成随机订单号
 */
function get_order_no() {
	return date ( 'YmdHis' ) . rand ( 1000, 2000 );
}

/**
 * 提取编辑器里的图片，返回数组
 *
 * @param string $content        	
 */
function get_imgs($content = '') {
	$pattern = '/<img.*?src=\s*?"?([^"\s]+)(?!\/>)"?\s*?/is';
	preg_match_all ( $pattern, $content, $matches );
	return ($matches [1]);
}

/**
 * 数组转换成CSV格式
 *
 * @param string $list        	
 * @param string $coding        	
 * @param string $header        	
 * @param string $csvfile        	
 */
function list_to_csv($list = null, $coding = 'gbk', $header = '', $csvfile = '') {
	if ($csvfile == '') {
		$csvfile = get_order_no ();
	}
	
	if ($header == '') {
		if (count ( $list ) > 0) {
			$header [] = array_keys ( $list [0] );
		}
	}
	$list = array_merge ( $header, $list );
	// echo(chr(0xEF).chr(0xBB).chr(0xBF));
	
	$content = generate_csv ( $list );
	if ($coding == 'utf-8') {
		header ( "Content-Type:APPLICATION/OCTET-STREAM" );
	} else {
		$content = iconv ( "UTF-8", "UTF-16LE", $content );
		$content = "\xFF\xFE" . $content; // 添加BOM
		header ( "Content-type: text/csv;charset=UTF-16LE" );
	}
	header ( "Content-Disposition: attachment; filename=$csvfile.csv" );
	echo ($content);
	exit ();
}

/**
 * 生成csv文件
 *
 * @param unknown $data        	
 * @param string $delimiter        	
 * @param string $enclosure        	
 * @return string
 */
function generate_csv($data, $delimiter = "\t", $enclosure = '"') {
	$handle = fopen ( 'php://temp', 'r+' );
	foreach ( $data as $k => $line1 ) {
		$lines = array ();
		$lines [] = array (
				$k 
		);
		$lines [] = array (
				"店名",
				"地址",
				"会员数",
				"分享数" 
		);
		$lines = array_merge ( $lines, $line1 );
		foreach ( $lines as $line ) {
			fputcsv ( $handle, $line, $delimiter, $enclosure );
		}
	}
	rewind ( $handle );
	while ( ! feof ( $handle ) ) {
		$contents .= fread ( $handle, 8192 );
	}
	fclose ( $handle );
	return $contents;
}

/**
 * 发送HTTP请求方法，目前只支持CURL发送请求，供微信接口使用
 *
 * @param string $url
 *        	请求URL
 * @param array $params
 *        	请求参数
 * @param string $method
 *        	请求方法GET/POST
 * @return array $data 响应数据
 */
function http($url, $params = array(), $method = 'GET', $header = array(), $multi = false) {
	$opts = array (
			CURLOPT_TIMEOUT => 30,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_HTTPHEADER => $header 
	);
	
	/* 根据请求类型设置特定参数 */
	switch (strtoupper ( $method )) {
		case 'GET' :
			$opts [CURLOPT_URL] = $url . '?' . http_build_query ( $params );
			break;
		case 'POST' :
			
			// 判断是否传输文件
			// $params = $multi ? $params : http_build_query($params);
			$opts [CURLOPT_URL] = $url;
			$opts [CURLOPT_POST] = 1;
			$opts [CURLOPT_POSTFIELDS] = http_build_query ( $params );
			
			if (stripos ( $url, "https://" ) !== FALSE) {
				$opts [CURLOPT_SSL_VERIFYPEER] = false;
				$opts [CURLOPT_SSL_VERIFYHOST] = false;
				$opts [CURLOPT_SSLVERSION] = CURL_SSLVERSION_TLSv1;
			}
			
			break;
		default :
			throw new Exception ( '不支持的请求方式！' );
	}
	/* 初始化并执行curl请求 */
	$ch = curl_init ();
	curl_setopt_array ( $ch, $opts );
	$data = curl_exec ( $ch );
	$error = curl_error ( $ch );
	curl_close ( $ch );
	if ($error)
		throw new Exception ( '请求发生错误：' . $error );
	return $data;
}

/**
 * 设置参数值
 *
 * @param string $p        	
 * @param string $v        	
 * @return Ambigous <string, mixed>
 */
function set_url($p = '', $v = '') {
	$p = strtolower ( $p );
	$param = $_GET;
	$param = array_change_key_case ( $param, CASE_LOWER );
	if ($v != '') {
		$v = strtolower ( $v );
		$v = parse_param ( $v );
	}
	$param [$p] = $v;
	return U ( CONTROLLER_NAME . '/' . ACTION_NAME, $param );
}

/**
 * 参数转换：防止URL Rewrite模式解析不正常
 *
 * @param string $str        	
 * @param string $de        	
 * @return Ambigous <string, mixed>
 */
function parse_param($str = '', $de = false) {
	if ($de) {
		$str = str_replace ( '_', ' ', $str );
		$str = str_replace ( '@', "'", $str );
	} else {
		$str = str_replace ( ' ', '_', $str );
		$str = str_replace ( "'", '@', $str );
	}
	return $str;
}

/**
 * 密码加密方式
 *
 * @param unknown $str        	
 * @return string
 */
function md5pwd($str) {
	$key = 'yourkey';
	return md5 ( $str . $key );
}

/**
 * 系统加密方法
 *
 * @param string $data
 *        	要加密的字符串
 * @param string $key
 *        	加密密钥
 * @param int $expire
 *        	过期时间 单位 秒
 * @return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function think_encrypt($data, $key = '', $expire = 0) {
	$key = md5 ( empty ( $key ) ? C ( 'DATA_AUTH_KEY' ) : $key );
	$data = base64_encode ( $data );
	$x = 0;
	$len = strlen ( $data );
	$l = strlen ( $key );
	$char = '';
	
	for($i = 0; $i < $len; $i ++) {
		if ($x == $l)
			$x = 0;
		$char .= substr ( $key, $x, 1 );
		$x ++;
	}
	
	$str = sprintf ( '%010d', $expire ? $expire + time () : 0 );
	
	for($i = 0; $i < $len; $i ++) {
		$str .= chr ( ord ( substr ( $data, $i, 1 ) ) + (ord ( substr ( $char, $i, 1 ) )) % 256 );
	}
	return str_replace ( array (
			'+',
			'/',
			'=' 
	), array (
			'-',
			'_',
			'' 
	), base64_encode ( $str ) );
}

/**
 * 系统解密方法
 *
 * @param string $data
 *        	要解密的字符串 （必须是think_encrypt方法加密的字符串）
 * @param string $key
 *        	加密密钥
 * @return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function think_decrypt($data, $key = '') {
	$key = md5 ( empty ( $key ) ? C ( 'DATA_AUTH_KEY' ) : $key );
	$data = str_replace ( array (
			'-',
			'_' 
	), array (
			'+',
			'/' 
	), $data );
	$mod4 = strlen ( $data ) % 4;
	if ($mod4) {
		$data .= substr ( '====', $mod4 );
	}
	$data = base64_decode ( $data );
	$expire = substr ( $data, 0, 10 );
	$data = substr ( $data, 10 );
	
	if ($expire > 0 && $expire < time ()) {
		return '';
	}
	$x = 0;
	$len = strlen ( $data );
	$l = strlen ( $key );
	$char = $str = '';
	
	for($i = 0; $i < $len; $i ++) {
		if ($x == $l)
			$x = 0;
		$char .= substr ( $key, $x, 1 );
		$x ++;
	}
	
	for($i = 0; $i < $len; $i ++) {
		if (ord ( substr ( $data, $i, 1 ) ) < ord ( substr ( $char, $i, 1 ) )) {
			$str .= chr ( (ord ( substr ( $data, $i, 1 ) ) + 256) - ord ( substr ( $char, $i, 1 ) ) );
		} else {
			$str .= chr ( ord ( substr ( $data, $i, 1 ) ) - ord ( substr ( $char, $i, 1 ) ) );
		}
	}
	return base64_decode ( $str );
}

/**
 * 是否是手机号码
 *
 * @param string $phone        	
 * @return boolean
 */
function is_mobile($phone) {
	if (strlen ( $phone ) != 11 || ! preg_match ( '/^1[3|4|5|7|8][0-9]\d{4,8}$/', $phone )) {
		return false;
	} else {
		return true;
	}
}

/**
 * 验证字符串是否为数字,字母,中文和下划线构成
 *
 * @param string $username        	
 * @return bool
 */
function is_check_string($str) {
	if (preg_match ( '/^[\x{4e00}-\x{9fa5}\w_]+$/u', $str )) {
		return true;
	} else {
		return false;
	}
}

/**
 * 是否为一个合法的email
 *
 * @param sting $email        	
 * @return boolean
 */
function is_email($email) {
	if (filter_var ( $email, FILTER_VALIDATE_EMAIL )) {
		return true;
	} else {
		return false;
	}
}

/**
 * 是否为整数
 *
 * @param int $number        	
 * @return boolean
 */
function is_number($number) {
	if (preg_match ( '/^[-\+]?\d+$/', $number )) {
		return true;
	} else {
		return false;
	}
}

/**
 * 是否为小数
 *
 * @param float $number        	
 * @return boolean
 */
function is_decimal($number) {
	if (preg_match ( '/^[-\+]?\d+(\.\d+)?$/', $number )) {
		return true;
	} else {
		return false;
	}
}

/**
 * 是否为合法的身份证(支持15位和18位)
 *
 * @param string $card        	
 * @return boolean
 */
function is_card($card) {
	if (preg_match ( '/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$/', $card ) || preg_match ( '/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{4}$/', $card ))
		return true;
	else
		return false;
}

/**
 * 验证日期格式是否正确
 *
 * @param string $date        	
 * @param string $format        	
 * @return boolean
 */
function is_date($date, $format = 'Y-m-d') {
	$t = date_parse_from_format ( $format, $date );
	if (empty ( $t ['errors'] )) {
		return true;
	} else {
		return false;
	}
}

/**
 * 把返回的数据集转换成Tree
 * access public
 *
 * @param array $list
 *        	要转换的数据集
 * @param string $pid
 *        	parent标记字段
 * @param string $level
 *        	level标记字段
 *        	return array
 */
function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0) {
	// 创建Tree
	$tree = array ();
	if (is_array ( $list )) {
		// 创建基于主键的数组引用
		$refer = array ();
		foreach ( $list as $key => $data ) {
			$refer [$data [$pk]] = & $list [$key];
		}
		foreach ( $list as $key => $data ) {
			// 判断是否存在parent
			$parentId = $data [$pid];
			if ($root == $parentId) {
				$tree [] = & $list [$key];
			} else {
				if (isset ( $refer [$parentId] )) {
					$parent = & $refer [$parentId];
					$parent [$child] [] = & $list [$key];
				}
			}
		}
	}
	return $tree;
}
