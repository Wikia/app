<?php
/**
 * Wikia Special:Version Extension
 *
 * @author Robert Elwell <robert(at)wikia-inc.com>
 */


$dir = dirname(__FILE__) . '/';

/**
 * classes
 */
$wgAutoloadClasses['WikiaSpecialVersion'] =  $dir . 'WikiaSpecialVersion.class.php';
$wgAutoloadClasses['WikiaSpecialVersionController'] =  $dir . 'WikiaSpecialVersionController.class.php';

/**
 * special pages
 */
$wgSpecialPages['Version'] = 'WikiaSpecialVersionController';

/**
 * message files
 */

$wgExtensionCredits['other'][] = array(
	'name'				=> 'Wikia Special:Version',
	'version'			=> '1.1',
	'author'			=> '[http://wikia.com/wiki/User:Relwell Robert Elwell]',
	'descriptionmsg'	=> 'wikia-version-desc',
	'url'               => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SpecialVersion'
);
