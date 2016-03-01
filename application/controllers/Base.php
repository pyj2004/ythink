<?php
/**
 * 默认控制器
 * @author Administrator
 *
 */
class BaseController extends \Yaf\Controller_Abstract {
	public function init() {
		defined ( 'CONTROLLER_NAME' ) or define ( 'CONTROLLER_NAME', dispatcher ()->getRequest ()->controller );
		defined ( 'MODULE_NAME' ) or define ( 'MODULE_NAME', dispatcher ()->getRequest ()->module );
		defined ( 'ACTION_NAME' ) or define ( 'ACTION_NAME', dispatcher ()->getRequest ()->action );
	}
}
