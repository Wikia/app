<?php

$dir = dirname(__FILE__) . '/';
//classes
$wgAutoloadClasses['Suggestions'] =  $dir . 'Suggestions.class.php';

$wgHooks['BeforePageDisplay'][] = 'Suggestions::loadAssets';

//message files
$wgExtensionMessagesFiles['Suggestions'] = $dir . 'Suggestions.i18n.php';
JSMessages::registerPackage('Suggestions', array('suggestions-redirect-from', 'suggestions-see-all'));
JSMessages::enqueuePackage('Suggestions', JSMessages::EXTERNAL);
