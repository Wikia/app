<?php

$wgExtensionCredits['other'][] = [
	'name' => 'Paginator',
	'author' => 'Jakub Kurcek',
	'descriptionmsg' => 'paginator-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Paginator',
];

$wgAutoloadClasses['Wikia\Paginator\Paginator'] = __DIR__ . '/classes/Paginator.class.php';
$wgAutoloadClasses['Wikia\Paginator\UrlGenerator'] = __DIR__ . '/classes/UrlGenerator.class.php';
$wgAutoloadClasses['Wikia\Paginator\Validator'] = __DIR__ . '/classes/Validator.class.php';

$wgExtensionMessagesFiles['Paginator'] = __DIR__ . '/i18n/Paginator.i18n.php';
