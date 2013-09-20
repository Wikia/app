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
$wgExtensionMessagesFiles['WikiaSpecialVersion'] = $dir . 'WikiaSpecialVersion.i18n.php' ;

$wgExtensionCredits['other'][] = array(
	'name'				=> 'Wikia Special:Version',
	'version'			=> '1.1',
	'author'			=> '[http://wikia.com/wiki/User:Relwell Robert Elwell]',
	'descriptionmsg'	=> 'wikia-version-desc',
);
