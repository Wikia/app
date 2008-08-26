<?php

# Wikimedia Foundation Board of Trustees Election

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
	die( "Not a valid entry point\n" );
}

# Extension credits
$wgExtensionCredits['other'][] = array(
	'name'           => 'BoardVote',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:BoardVote',
	'svn-date'       => '$LastChangedDate: 2008-07-10 06:27:11 +0000 (Thu, 10 Jul 2008) $',
	'svn-revision'   => '$LastChangedRevision: 37462 $',
	'description'    => '[[meta:Board elections|Wikimedia Board of Trustees election]]',
	'descriptionmsg' => 'boardvote-desc',
);

# Default settings
$wgBoardVoteDB = "boardvote";
$wgBoardCandidates = array();
/* $wgBoardCandidates = array( "John Doe", "Jane Doe", "Joe Bloggs", "John Smith", "A. N. Other" ); */
$wgGPGCommand = "gpg";
$wgGPGRecipient = "boardvote";
$wgGPGHomedir = false;
$wgGPGPubKey = "C:\\Program Files\\GNU\\GnuPG\\pub.txt";
$wgBoardVoteEditCount = 600;
$wgBoardVoteRecentEditCount = 50;
$wgBoardVoteCountDate = '20080301000000';
$wgBoardVoteRecentFirstCountDate = '20080101000000';
$wgBoardVoteRecentCountDate = '20080529000000';
$wgBoardVoteStartDate = '20080601000000';
$wgBoardVoteEndDate =   '20080622000000';
$wgBoardVoteDBServer = $wgDBserver;

# Vote admins
$wgGroupPermissions['boardvote']['boardvote'] = true;
$wgAvailableRights[] = 'boardvote';

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['BoardVote'] = $dir . 'BoardVote.i18n.php';
$wgExtensionAliasesFiles['BoardVote'] = $dir . 'BoardVote.alias.php';

# Register special page
if ( !function_exists( 'extAddSpecialPage' ) ) {
	require( dirname(__FILE__) . '/../ExtensionFunctions.php' );
}

if ( !defined( 'BOARDVOTE_REDIRECT_ONLY' ) ) {
	extAddSpecialPage( dirname(__FILE__) . '/BoardVote_body.php', 'Boardvote', 'BoardVotePage' );
	$wgExtensionFunctions[] = 'wfSetupBoardVote';
} else {
	extAddSpecialPage( dirname(__FILE__) . '/GoToBoardVote_body.php', 'Boardvote', 'GoToBoardVotePage' );
}

function wfSetupBoardVote() {
	wfSetupSession();
	if ( isset( $_SESSION['bvLang'] ) && !isset( $_REQUEST['uselang'] ) ) {
		wfDebug( __METHOD__.": Setting user language to {$_SESSION['bvLang']}\n" );
		$_REQUEST['uselang'] = $_SESSION['bvLang'];
		global $wgLang;
		$wgLang = Language::factory( $_SESSION['bvLang'] );
	}
}

function wfBoardVoteInitMessages() {
	static $done = false;
	if ( $done ) return true;

	$done = true;
	wfLoadExtensionMessages( 'BoardVote' );

	return true;
}
