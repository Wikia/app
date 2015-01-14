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

$dir = dirname( __FILE__ );

// Translations
$wgExtensionMessagesFiles["WikiaNewFiles"] =  "{$dir}/SpecialNewFiles.i18n.php";

//Fix BugzId: 4310
$wgExtensionMessagesFiles['WikiaNewFilesAliases'] = "{$dir}/SpecialNewFiles.alias.php";

// Autoloaded classes
$wgAutoloadClasses['WikiaNewFiles'] = "{$dir}/WikiaNewFiles.class.php";

require_once( "{$dir}/SpecialNewFiles.php" );

$wgSpecialPages['Newimages'] = 'WikiaNewFiles';
