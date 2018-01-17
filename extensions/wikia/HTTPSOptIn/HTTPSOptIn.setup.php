<?php

$wgAutoloadClasses['HTTPSOptInHooks'] =  __DIR__ . '/HTTPSOptInHooks.class.php';

$wgExtensionMessagesFiles['HTTPSOptIn'] = __DIR__ . '/HTTPSOptIn.i18n.php' ;

$wgHooks['GetPreferences'][] = 'HTTPSOptInHooks::onGetPreferences';
$wgHooks['BeforeInitialize'][] = 'HTTPSOptInHooks::onBeforeInitialize';
