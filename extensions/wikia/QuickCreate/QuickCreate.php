<?php
/**
 * Adds contest button (RT #38367)
 *
 * @author Bartek Lapinski <bartek@wikia-inc.com>
 */

$wgExtensionCredits['parserhook'][] = array(
	'name' => 'QuickCreate',
	'description' => 'Adds a create new page button with ability to log in for anons',
	'descriptionmsg' => 'quickcreate-desc',
	'version' => '1,0',
	'author' => array( 'Bartek Lapinski' ),
);

$wgExtensionMessagesFiles['QuickCreate'] = dirname(__FILE__) . '/QuickCreate.i18n.php';

$wgHooks['ParserFirstCallInit'][] = 'wfQuickCreate';

function wfQuickCreate( &$parser ) {
	$parser->setHook( 'quickcreate', 'wfQuickCreateButton' );
	return true;
}

function wfQuickCreateButton( $input, $argv, $parser ) {

	$title = Title::makeTitle( NS_SPECIAL, "CreatePage");
	$link = $title->getFullUrl();
	$output = Xml::openElement( 'a', array(
			'class' => 'wikia-button wikiaComboAjaxLogin',
			'id'	=> 'mr-submit',
			'href' => $link
		) )
		.wfMsg( 'quickcreate' )
		.Xml::closeElement( 'a' );

	return $parser->replaceVariables( $output );
}
