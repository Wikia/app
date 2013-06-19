<?php
/**
 * RelatedPages Extension - version for Oasis skin only
 *
 * @author Jakub 'Szeryf' Kurcek
 */

/**
 * Extension credits properties.
 */
$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'ImageDrop',
	'author'         => 'Jakub Szeryf Kurcek',
	'descriptionmsg' => 'wikiimagedrop-desc',
	'url'            => 'http://www.wikia.com',
);

/**
 * @var WikiaApp
 */
$app = F::app();
$dir = dirname( __FILE__ );

/**
 * classes
 */

$wgAutoloadClasses['ImageDrop'] =  $dir . '/ImageDrop.class.php';
$wgAutoloadClasses['ImageDropController'] =  $dir . '/ImageDropController.class.php';

// hooks
$wgHooks['BeforePageDisplay'][] = 'ImageDrop::onBeforePageDisplay';

// messages
//$wgExtensionMessagesFiles['RelatedPages'] = $dir . 'RelatedPages.i18n.php';
