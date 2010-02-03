<?php
/**
 * Adds contest button (RT #38367)
 *
 * @author Bartek Lapinski <bartek@wikia-inc.com>
 */
$wgExtensionCredits['parserhook'][] = array(
                'name' => 'MakeRecipe',
                'description' => 'Adds contest button',
                'version' => '0.2',
                'author' => array('Bartek Lapinski')
                );

$wgExtensionMessagesFiles['MakeRecipe'] = dirname(__FILE__) . '/MakeRecipe.i18n.php';

$wgHooks['ParserFirstCallInit'][] = 'wfMakeRecipe';

function wfMakeRecipe( &$parser ) {
        $parser->setHook( 'makerecipe', 'wfMakeRecipeButton' );
        return true;
}

function wfMakeRecipeButton( $input, $argv, &$parser ) {
        wfLoadExtensionMessages( 'MakeRecipe' );
        global $wgRequest, $wgScript;

	$link = '';
	$onclick = '';
	$output = Xml::openElement( 'a', array(
						'class' => 'wikia_button',
						'href' => $link,
						'onclick' => $onclick
						 ) )
		.Xml::openElement( 'span' )
		.wfMsg( 'makerecipe' )	
		.Xml::closeElement( 'span' )
		.Xml::closeElement( 'a' );

	return $parser->replaceVariables( $output );	
}


