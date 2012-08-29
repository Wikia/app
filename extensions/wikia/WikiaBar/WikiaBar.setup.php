<?php

/**
 * Setup for WikiaBar - Meebo replacement
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 */

$app = F::app();
$dir = dirname(__FILE__) . '/';

/**
 * classes
 */
$app->registerClass('WikiaBarController', $dir . 'WikiaBarController.class.php');
$app->registerClass('WikiaBarHooks', $dir . 'WikiaBarHooks.class.php');
$app->registerClass('WikiaBarModel', $dir . 'models/WikiaBarModel.class.php');
$app->registerClass('WikiaBarModelBase', $dir . 'models/WikiaBarModelBase.class.php');
$app->registerClass('WikiaBarDataModel', $dir . 'models/WikiaBarDataModel.class.php');
$app->registerClass('WikiaBarDataFailsafeModel', $dir . 'models/WikiaBarDataFailsafeModel.class.php');

/**
 * hooks
 */
$app->registerHook('WikiaAssetsPackages', 'WikiaBarHooks', 'onWikiaAssetsPackages');
$app->registerHook('MessageCacheReplace', 'WikiaBarHooks', 'onMessageCacheReplace');
