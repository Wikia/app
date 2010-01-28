<?php
/**
 * Adds top title edit button (RT #37771)
 *
 * @author Bartek Lapinski <bartek@wikia-inc.com>
 */
$wgExtensionCredits['other'][] = array(
		'name' => 'TitleEdit',
		'description' => 'Adds top title edit buttons',
		'version' => '0.1',
		'author' => array('Bartek Lapinski')
		);

$wgHooks['MonacoPrintFirstHeading'][] = 'wfTitleEditPrintFirstHeading';


function wfTitleEditPrintFirstHeading() {
	global $wgTitle, $wgUser; // different for Anon? or will js handle this?	
	
	$sk = $wgUser->getSkin();
	$link = $sk->link( $wgTitle, wfMsg('editsection'),
			array(),
			array( 'action' => 'edit'),
			array( 'noclasses', 'known' )
			);
	$result = wfMsgHtml( 'editsection-brackets', $link );
	$result = "<span class=\"editsection\">$result</span>";

	echo $result;
	return true;
}


