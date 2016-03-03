<?php
/**
 * 默认控制器
 * @author Administrator
 *
 */
class IndexController extends BaseController {
	public function tAction($name = "Stranger") {
		dump ( U ( 'index/t', 'name=1&nam1=2' ) );
		dump ( dispatcher ()->getRequest ()->getParams () );
		dump ( I () );
		we ( $name );
		// 2. fetch model
		$this->assign ( "name", $name );
		
		return false;
	}
	public function indexAction($name = '') {
		$list = M ( 'user' )->field ( 'id,username' )->limit ( 10 )->select ();
		$this->assign ( 'list', $list );
		$this->assign ( 'title', 'yaf测试1' );
		$this->display ();
	}
	public function testAction() {
		dump ( MODULE_NAME );
		dump ( CONTROLLER_NAME );
		dump ( ACTION_NAME );
		exit ();
	}
}
