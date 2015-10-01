<?php
/**
 * @file
 * @ingroup SpecialPage
 *
 * Extends the IncludeableSpecialPage to override some of the header formatting
 */

$wgExtensionCredits['specialpage'][] = [
	'path'           => __FILE__,
	'name'           => 'WikiaNewFiles',
	'author'         => 'Garth Webb',
	'descriptionmsg' => 'wikianewfiles-desc',
	'url'            => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WikiaNewFiles',
];

// i18n
$wgExtensionMessagesFiles['WikiaNewFiles'] =  __DIR__ . '/SpecialNewFiles.i18n.php';
$wgExtensionMessagesFiles['WikiaNewFilesAliases'] = __DIR__ . '/SpecialNewFiles.alias.php';

// autoloaded classes
$wgAutoloadClasses['WikiaNewFiles'] = __DIR__ . '/WikiaNewFiles.class.php';
$wgAutoloadClasses['WikiaNewFilesHooks'] = __DIR__ . '/WikiaNewFilesHooks.php';

// hooks
$wgHooks['PageHeaderIndexExtraButtons'][] = 'WikiaNewFilesHooks::onPageHeaderIndexExtraButtons';

require_once( __DIR__ . '/SpecialNewFiles.php' );

$wgSpecialPages['Newimages'] = 'WikiaNewFiles';
