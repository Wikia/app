<?php

$app = F::app();
$dir = dirname(__FILE__) . '/';


$app->registerClass('HelloWorld', $dir . 'HelloWorld.class.php');
$app->registerClass('HelloWorldSpecialController', $dir . 'HelloWorldSpecialController.class.php');
$app->registerSpecialPage('HelloWorld', 'HelloWorldSpecialController');
$app->registerExtensionMessageFile('HellowWorld', $dir . 'HelloWorld.i18n.php');
