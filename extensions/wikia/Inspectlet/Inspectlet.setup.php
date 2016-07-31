<?php
/**
 * Inspectlet setup
 * @desc Adds inspectlet script with given experiment ID if
 * experiment ID was set before WikiaSkinTopScripts hook.
 *
 * @author Diana Falkowska
 *
 */
$dir = dirname( __FILE__ ) . '/';

$wgExtensionCredits[ 'other' ][] = array(
	'name'           => 'Inspectlet',
	'author'         => [ 'Diana Falkowska' ],
	'descriptionmsg' => 'inspectlet-desc',
	'version'        => 1,
	'url'            => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Inspectlet'
);

//i18n
$wgExtensionMessagesFiles['Inspectlet'] = $dir . '/Inspectlet.i18n.php';

// classes
$wgAutoloadClasses[ 'Inspectlet' ] = $dir . '/Inspectlet.class.php';

// hooks
$wgHooks[ 'WikiaSkinTopScripts' ][] = 'Inspectlet::onWikiaSkinTopScripts';
