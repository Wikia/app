<?php
/**
 * Entities extension
 *
 * @file
 * @ingroup Extensions
 * 
 * @author Trevor Parscal <tparscal.kattouw@gmail.com>
 * @license GPL v2 or later
 * @version 0.1.0
 */

/* Setup */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Entities',
	'author' => array( 'Trevor Parscal' ),
	'version' => '0.1.0',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Entities',
	'descriptionmsg' => 'entities-desc',
);
$wgAutoloadClasses['EntitiesHooks'] = dirname( __FILE__ ) . '/Entities.hooks.php';
$wgAutoloadClasses['SpecialEntities'] = dirname( __FILE__ ) . '/SpecialEntities.php';
$wgSpecialPages['Entities'] = 'SpecialEntities';
$wgSpecialPageGroups['Entities'] = 'wiki';
$wgExtensionMessagesFiles['Entities'] = dirname( __FILE__ ) . '/Entities.i18n.php';
$wgExtensionMessagesFiles['EntitiesAlias'] = dirname( __FILE__ ) . '/Entities.alias.php';
