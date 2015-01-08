<?php
/**
 * AuthImage setup file
 *
 * @author Piotr 'MoLi' Molski <moli(at)wikia.com>
 *
 */
 
$wgExtensionCredits[ 'specialpage' ][ ] = array(
	'name' => 'AuthImage',
	'author' => 'Piotr \'MoLi\' Molski <moli(at)wikia.com>',
	'descriptionmsg' => 'authimage-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/AuthImage',
);

$app = F::app();
$dir = dirname(__FILE__) . '/';

/**
 * classes
 */
$wgAutoloadClasses['AuthImageSpecialPageController'] =  $dir . 'AuthImageSpecialPageController.class.php';

/**
 * special pages
 */
$wgSpecialPages['AuthImage'] = 'AuthImageSpecialPageController';

//i18n
$wgExtensionMessagesFiles['AuthImage'] = $dir . 'AuthImage.i18n.php';

