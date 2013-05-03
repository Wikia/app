<?php
/**
 * Wikia Special:Version Extension
 *
 * @author Robert Elwell <robert(at)wikia-inc.com>
 */


$app = F::app();
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
$app->registerExtensionMessageFile('WikiaSpecialVersion', $dir . 'WikiaSpecialVersion.i18n.php' );

$wgExtensionCredits['other'][] = array(
	'name'				=> 'Wikia Special:Version',
	'version'			=> '1.0',
	'author'			=> '[http://wikia.com/wiki/User:Relwell Robert Elwell]',
	'descriptionmsg'	=> 'wikia-version-desc',
);
