<?php

/**
 * Initialization file for the SubPageList extension.
 * 
 * Documentation:	 		http://www.mediawiki.org/wiki/Extension:SubPageList
 * Support					http://www.mediawiki.org/wiki/Extension_talk:SubPageList
 * Source code:             http://svn.wikimedia.org/viewvc/mediawiki/trunk/extensions/SubPageList
 *
 * @file SubPageList.php
 * @ingroup SubPageList
 *
 * @licence GNU GPL v3 or later
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

/**
 * This documenation group collects source code files belonging to SubPageList.
 *
 * @defgroup SPL SubPageList
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

// Include the Validator extension if that hasn't been done yet, since it's required for SubPageList to work.
if ( !defined( 'Validator_VERSION' ) ) {
	@include_once( dirname( __FILE__ ) . '/../Validator/Validator.php' );
}

// Only initialize the extension when all dependencies are present.
if ( ! defined( 'Validator_VERSION' ) ) {
	die( '<b>Error:</b> You need to have <a href="http://www.mediawiki.org/wiki/Extension:Validator">Validator</a> installed in order to use <a href="http://www.mediawiki.org/wiki/Extension:SubPageList">SubPageList</a>.<br />' );
}

define( 'SPL_VERSION', '0.5' );

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'SubPageList',
	'version' => SPL_VERSION,
	'author' => array(
		'[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]',
		'Van de Bugger. Based on [http://www.mediawiki.org/wiki/Extension:SubPageList3 SubPageList3].',
	),
	'url' => 'https://www.mediawiki.org/wiki/Extension:SubPageList',
	'descriptionmsg' => 'spl-desc'
);

$egSPLIP = dirname( __FILE__ );

$wgExtensionMessagesFiles['SubPageList'] = $egSPLIP . '/SubPageList.i18n.php';
$wgExtensionMessagesFiles['SubPageListMagic'] = $egSPLIP . '/SubPageList.i18n.magic.php';

$wgAutoloadClasses['SubPageBase'] = $egSPLIP . '/SubPageBase.class.php';
$wgAutoloadClasses['SubPageList'] = $egSPLIP . '/SubPageList.class.php';
$wgAutoloadClasses['SubPageCount'] = $egSPLIP . '/SubPageCount.class.php';
$wgAutoloadClasses['SPLHooks'] = $egSPLIP . '/SubPageList.hooks.php';

$wgHooks['ParserFirstCallInit'][] = 'SubPageList::staticInit';
$wgHooks['ParserFirstCallInit'][] = 'SubPageCount::staticInit';

$wgHooks['ArticleInsertComplete'][] = 'SPLHooks::onArticleInsertComplete';
$wgHooks['ArticleDeleteComplete'][] = 'SPLHooks::onArticleDeleteComplete';
$wgHooks['TitleMoveComplete'][] = 'SPLHooks::onTitleMoveComplete';

require_once 'SubPageList.settings.php';
