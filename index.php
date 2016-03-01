<?php
define ( "APPLICATION_PATH", __DIR__ );
define ( "APP_PATH", APPLICATION_PATH. '/application' );
define ( "FRAMEWORK_PATH", APPLICATION_PATH . '/framework' );
$app = new \Yaf\Application ( APPLICATION_PATH . "/conf/application.ini", ini_get ( 'yaf.environ' ) );
$app->bootstrap ()->run ();
