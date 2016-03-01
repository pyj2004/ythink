<?php

namespace think;

/**
 * 视图引擎定义
 * Smarty/Adapter.php
 */
class Thinkview implements \Yaf\View_Interface {
	/**
	 * Smarty object
	 *
	 * @var Smarty
	 */
	public $_smarty;
	
	/**
	 * Constructor
	 *
	 * @param string $tmplPath        	
	 * @param array $extraParams        	
	 * @return void
	 */
	public function __construct() {
		$this->_smarty = \think\View::instance ( \think\Config::get () )->instance ();
	}
	
	/**
	 * Assign variables to the template
	 *
	 * Allows setting a specific key to the specified value, OR passing
	 * an array of key => value pairs to set en masse.
	 *
	 * @see __set()
	 * @param string|array $spec
	 *        	The assignment strategy to use (key or
	 *        	array of key => value pairs)
	 * @param mixed $value
	 *        	(Optional) If assigning a named variable,
	 *        	use this as the value.
	 * @return void
	 */
	public function assign($spec, $value = null) {
		if (is_array ( $spec )) {
			$this->_smarty->assign ( $spec );
			return;
		}
		
		$this->_smarty->assign ( $spec, $value );
	}

	public function setScriptPath($path) {
		if (is_readable($path))
		{
			$this->_smarty->theme($path);
		}
		else
		{
			throw new Exception('Invalid path provided');
		}
	}

	public function getScriptPath() {
		return $this->_smarty->getThemePath();
	}
	
	
	/**
	 * Processes a template and returns the output.
	 *
	 * @param string $name
	 *        	The template to process.
	 * @return string The output.
	 */
	public function render($name, $tpl_vars = array()) {
		if (!empty($tpl_vars))
		{
			$this->assign($tpl_vars);
		}
 		$module=strtolower(dispatcher()->getRequest()->module);
 		if($module==C('DEFAULT_MODULE')){
			$themepath=APP_PATH.DS.'views'.DS;
 		}else{
 			$themepath=APP_PATH.DS.$module.DS.'views'.DS;
 		}
		return $this->_smarty->fetch($themepath.$name);
	}
	
	public function display($name, $tpl_vars = array()) {
		//die(var_dump($name));
		if (!empty($tpl_vars))
		{
			$this->assign($tpl_vars);
		}
		echo $this->_smarty->fetch($name . ".tpl");
		exit();
	}
}
?>