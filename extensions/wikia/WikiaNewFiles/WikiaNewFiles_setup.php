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
	'author'         => [
		'Garth Webb <garth@wikia-inc.com>',
		'Piotr Gabryjeluk <rychu@wikia-inc.com>'
	],
	'descriptionmsg' => 'wikianewfiles-desc',
	'url'            => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WikiaNewFiles',
);

// Translations
$wgExtensionMessagesFiles['WikiaNewFiles'] =  __DIR__ . '/WikiaNewFiles.i18n.php';

// Autoloaded classes
$wgAutoloadClasses['WikiaNewFilesSpecialController'] = __DIR__ . '/WikiaNewFilesSpecialController.class.php';
$wgAutoloadClasses['WikiaNewFilesGallery'] = __DIR__ . '/WikiaNewFilesGallery.class.php';
$wgAutoloadClasses['WikiaNewFilesModel'] = __DIR__ . '/WikiaNewFilesModel.class.php';

// Redirect from the old special page (Special:NewFiles)
$wgSpecialPages['Newimages'] = 'WikiaNewFilesSpecialController';

