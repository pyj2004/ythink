<?php
/**
 * 默认控制器
 * @author Administrator
 *
 */
class IndexController extends \Yaf\Controller_Abstract {
	public function indexAction($name = '') {
		$list=M('user')->find();
		we($list);
		$this->_view->assign('title','yaf测试');
	}
}
