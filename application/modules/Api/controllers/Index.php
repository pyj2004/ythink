<?php
/**
 * 默认控制器
 * @author Administrator
 *
 */
class IndexController extends Yar {
	/**
	 * 测试接口
	 */
	public function index() {
		return time ();
	}
	
	/**
	 * 测试接口
	 *
	 * @param string $name        	
	 */
	public function test($name = '') {
		// logdebug(file_get_contents('php://input', 'r'));
		$list=M('user')->find();
		return $list;
	}
}