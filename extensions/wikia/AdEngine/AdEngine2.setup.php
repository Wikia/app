<?php

$dir = dirname(__FILE__);

$app = F::app();

$app->registerClass('AdEngine2Controller', "$dir/AdEngine2Controller.class.php");

$app->registerHook('WikiaSkinTopScripts', 'AdEngine2Controller', 'onWikiaSkinTopScripts');
