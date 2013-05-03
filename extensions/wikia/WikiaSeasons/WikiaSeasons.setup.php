<?php

/**
 * Setup for WikiaSeasons - seasonal changes in Oasis Skin
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 */

$app = F::app();
$dir = dirname(__FILE__) . '/';

/**
 * classes
 */
$wgAutoloadClasses['WikiaSeasonsController'] =  $dir . 'WikiaSeasonsController.class.php';

/**
 * hooks
 */
//$app->registerHook();

/**
 * i18n mapping
 */
//$app->registerExtensionMessageFile();
