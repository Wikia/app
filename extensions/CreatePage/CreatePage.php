<?php

/**
 * Initialization file for the Create Page extension.
 *
 * Documentation:	 		https://www.mediawiki.org/wiki/Extension:Create_Page
 * Support					https://www.mediawiki.org/wiki/Extension_talk:Create_Page
 * Source code:				http://svn.wikimedia.org/viewvc/mediawiki/trunk/extensions/CreatePage
 *
 * @file CreatePage.php
 * @ingroup CreatePage
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

/**
 * This documentation group collects source code files belonging to Create Page.
 *
 * @defgroup CreatePage Create Page
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

if ( version_compare( $wgVersion, '1.18c', '<' ) ) { // Needs to be 1.18c because version_compare() works in confusing ways.
	die( '<b>Error:</b> Create Page requires MediaWiki 1.18 or above.' );
}

define( 'CP_VERSION', '0.1' );

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Create Page',
	'version' => CP_VERSION,
	'author' => array(
		'[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]',
	),
	'url' => 'https://www.mediawiki.org/wiki/Extension:Create_Page',
	'descriptionmsg' => 'cp-desc'
);

// i18n
$wgExtensionMessagesFiles['CreatePage'] = dirname( __FILE__ ) . '/CreatePage.i18n.php';
$wgExtensionMessagesFiles['CreatePageAlias'] = dirname( __FILE__ ) . '/CreatePage.alias.php';
$wgExtensionMessagesFiles['CreatePageMagic'] = dirname( __FILE__ ) . '/CreatePage.magic.php';

$wgAutoloadClasses['SpecialCreatePage'] = dirname( __FILE__ ) . '/SpecialCreatePage.php';
$wgSpecialPages['CreatePage'] = 'SpecialCreatePage';

$wgHooks['ParserFirstCallInit'][] = function( Parser &$parser ) {
	$parser->setFunctionHook( 'createpage', function( Parser $parser, PPFrame $frame, array $args ) {
		$html = Html::openElement( 'form', array(
			'action' => SpecialPage::getTitleFor( 'CreatePage' )->getLocalURL(),
			'method' => 'post',
			'style' => 'display: inline',
		) );
		
		$html .= Html::input(
			'pagename',
			array_key_exists( 1, $args ) ? trim( $frame->expand( $args[1] ) ) : ''
		);
		
		if ( array_key_exists( 0, $args ) ) {
			$html .= Html::hidden( 'pagens', trim( $frame->expand( $args[0] ) ) );
		}
		
		$html .= '&#160;';
		
		$html .= Html::input(
			'createpage',
			array_key_exists( 2, $args ) ? trim( $frame->expand( $args[2] ) ) : wfMsg( 'cp-create' ),
			'submit'
		);
		
		$html .= '</form>';
		
		return $parser->insertStripItem( $html );
	}, SFH_OBJECT_ARGS );

	return true;
};
