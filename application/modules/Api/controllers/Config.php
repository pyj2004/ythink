<?php

/**
 * 配置文件测试
 */
class ConfigController extends  \Yaf\Controller_Abstract {

    public function readAction() {
        var_dump(\Yaf\Registry::get('config'));
    }

}
