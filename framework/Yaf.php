<?php
/**
 * 应用实例
 */
function application(){
	return \Yaf\Application::app();
}
/**
 * 分发器实例
 * @return \Yaf\Dispatcher
 */
function dispatcher(){
	return \Yaf\Dispatcher::getInstance();
}

/**
 * 配置
 * @return mixed
 */
function cfg(){
	return \Yaf\Registry::get('config');
}
?>