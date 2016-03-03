<?php
/**
 * 默认控制器
 * @author Administrator
 *
 */
class Controller extends \Yaf\Controller_Abstract {
	public function init() {
		defined ( 'CONTROLLER_NAME' ) or define ( 'CONTROLLER_NAME', dispatcher ()->getRequest ()->controller );
		defined ( 'MODULE_NAME' ) or define ( 'MODULE_NAME', dispatcher ()->getRequest ()->module );
		defined ( 'ACTION_NAME' ) or define ( 'ACTION_NAME', dispatcher ()->getRequest ()->action );
	}
	
	/**
	 * 模板变量赋值
	 * @param string $key
	 * @param string $value
	 */
	public function assign($key='',$value=''){
		if(is_array($key)){
			$this->_view->assign($key);
		}else{
			$this->_view->assign($key, $value);
		}
	}
	
	public function display($tpl='',array $tpl_vars = null){
		$this->_view->display($tpl,$tpl_vars);
	}
}
