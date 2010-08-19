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
	'url'            => 'http://www.wikia.com',
);

$dir = dirname( __FILE__ );

// Translations
$wgExtensionMessagesFiles["WikiaNewFiles"] =  $dir . '/SpecialNewFiles.i18n.php';

// Autoloaded classes
$wgAutoloadClasses['WikiaNewFiles'] = "$dir/WikiaNewFiles.class.php";

require_once( $dir . '/SpecialNewFiles.php' );

$wgSpecialPages['Newimages'] = array( 'WikiaNewFiles', 'Newimages' );
