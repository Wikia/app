<?php
$wgAutoloadClasses['PremiumDesignABTestHooks'] =  __DIR__ . '/PremiumDesignABTest.hooks.php';
$wgAutoloadClasses[ 'PremiumDesignABTestController' ] = __DIR__ . '/PremiumDesignABTestController.class.php';

$wgHooks['BeforePageDisplay'][] = 'PremiumDesignABTestHooks::onBeforePageDisplay';