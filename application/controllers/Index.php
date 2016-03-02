<?php
/**
 * 默认控制器
 * @author Administrator
 *
 */
class IndexController extends BaseController {
	public function indexAction($name = '') {
		// $list=M('user')->find();
		// we($list);
		$this->assign ( 'title', 'yaf测试1' );
		$this->display();
	}
	
	public function testAction(){

		dump(MODULE_NAME);
		dump(CONTROLLER_NAME);
		dump(ACTION_NAME);
		exit();
	}
}
