<?php

/**
 * Bootstrap引导程序
 * 所有在Bootstrap类中定义的, 以_init开头的方法, 都会被依次调用
 * 而这些方法都可以接受一个Yaf\Dispatcher实例作为参数.
 */
class Bootstrap extends \Yaf\Bootstrap_Abstract {
	
	/**
	 * 把配置存到注册表
	 */
	public function _initConfig() {
		$config = \Yaf\Application::app ()->getConfig ();
		\Yaf\Registry::set ( 'config', $config );
		// 引入THINK类库
		\Yaf\Loader::import ( FRAMEWORK_PATH.'/Base.php' );
		\Yaf\Loader::import ( FRAMEWORK_PATH.'/Convention.php' );
		\Yaf\Loader::import ( FRAMEWORK_PATH.'/Helper.php' );
		
		// 引入扩展函数
		\Yaf\Loader::import ( FRAMEWORK_PATH.'/Function.php' );
		\Yaf\Loader::import ( FRAMEWORK_PATH.'/Yaf.php' );

		// 加载模式定义文件
		$mode = require MODE_PATH . APP_MODE . EXT;
		// 加载模式配置文件
		if (isset($mode['config'])) {
		    is_array($mode['config']) ? \think\Config::set($mode['config']) : \think\Config::load($mode['config']);
		}
	}

	public function _initThink(Yaf\Dispatcher $dispatcher) {
		$thinkview = new \think\Thinkview();
		Yaf\Dispatcher::getInstance()->setView($thinkview);
	}
	
// 	/**
// 	 * 路由规则定义，如果没有需要，可以去除该代码
// 	 *
// 	 * @param Yaf_Dispatcher $dispatcher        	
// 	 */
// 	public function _initRoute(\Yaf\Dispatcher $dispatcher) {
// 		$config = new \Yaf\Config\Ini ( APPLICATION_PATH . '/conf/route.ini', 'common' );
// 		if ($config->routes) {
// 			$router = \Yaf\Dispatcher::getInstance ()->getRouter ();
// 			$router->addConfig ( $config->routes );
// 		}
// 	}
	
// 	/**
// 	 * 获取url.ini配置的地址
// 	 *
// 	 * @param string $name        	
// 	 * @return string
// 	 */
// 	public static function getUrlIniConfig($name) {
// 		static $config = null;
// 		if ($config === null) {
// 			$config = new \Yaf\Config\Ini ( APPLICATION_PATH . '/conf/url.ini', ini_get ( 'yaf.environ' ) );
// 		}
// 		$urlConf = $config->get ( 'config.url' );
// 		if ($urlConf === null) {
// 			throw new \Exception ( "config.url is not exist" );
// 		}
// 		if ($urlConf [$name] === null) {
// 			throw new \Exception ( "config.url" . $name . " is not exist" );
// 		}
// 		return $urlConf [$name];
// 	}
}
