<?php
/**
 * @file
 * @ingroup SpecialPage
 * Extends the IncludeableSpecialPage to override some of the header formatting
 *
 */

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'WikiaNewFiles',
	'author'         => 'Garth Webb',
	'descriptionmsg' => 'wikianewfiles-desc',
	'url'            => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WikiaNewFiles',
);

// Translations
$wgExtensionMessagesFiles['WikiaNewFiles'] =  __DIR__ . '/SpecialNewFiles.i18n.php';
$wgExtensionMessagesFiles['WikiaNewFilesAliases'] = __DIR__ . '/SpecialNewFiles.alias.php';

// Autoloaded classes
$wgAutoloadClasses['WikiaNewFiles'] = __DIR__ . '/WikiaNewFiles.class.php';
$wgAutoloadClasses['WikiaNewFilesModel'] = __DIR__ . '/WikiaNewFilesModel.class.php';

$wgSpecialPages['Newimages'] = 'WikiaNewFiles';
