<?php

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'WikiaTrivia',
	'descriptionmsg' => 'wikiatrivia-desc',
	'author' => array('Hyun Lim', 'Will Lee')
);

$dir = dirname(__FILE__).'/';

// autoloads
$wgAutoloadClasses['WikiaTriviaModule'] = $dir . 'WikiaTriviaModule.class.php';
$wgAutoloadClasses['SpecialWikiaTrivia'] = $dir . 'SpecialWikiaTrivia.class.php';

// special pages
$wgSpecialPages['WikiaTrivia'] = 'SpecialWikiaTrivia';

// i18n
$wgExtensionMessagesFiles['WikiBuilder'] = $dir . 'WikiBuilder.i18n.php';