<?php
/**
 * @file
 * @ingroup Extensions
 * @author Tim Starling <tstarling@wikimedia.org>
 * @link http://www.mediawiki.org/wiki/Extension:SecurePoll Documentation
 */

# Not a valid entry point, skip unless MEDIAWIKI is defined
if ( !defined( 'MEDIAWIKI' ) ) {
	die( "Not a valid entry point\n" );
}

# Extension credits
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'SecurePoll',
	'author' => array( 'Tim Starling', '...' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:SecurePoll',
	'descriptionmsg' => 'securepoll-desc',
);

# Configuration
/**
 * The GPG command to run
 */
$wgSecurePollGPGCommand = 'gpg';

/**
 * The temporary directory to be used for GPG home directories and plaintext files
 */
$wgSecurePollTempDir = '/tmp';

/**
 * Show detail of GPG errors
 */
$wgSecurePollShowErrorDetail = false;

/**
 * Relative URL path to auth-api.php
 */
$wgSecurePollScript = 'extensions/SecurePoll/auth-api.php';

### END CONFIGURATON ###


// Set up the new special page
$dir = dirname( __FILE__ );
$wgExtensionMessagesFiles['SecurePoll'] = "$dir/SecurePoll.i18n.php";
$wgExtensionMessagesFiles['SecurePollAlias'] = "$dir/SecurePoll.alias.php";

$wgSpecialPages['SecurePoll'] = 'SecurePoll_BasePage';

$wgAutoloadClasses = $wgAutoloadClasses + array(
	# ballots
	'SecurePoll_ApprovalBallot' => "$dir/includes/ballots/ApprovalBallot.php",
	'SecurePoll_Ballot' => "$dir/includes/ballots/Ballot.php",
	'SecurePoll_ChooseBallot' => "$dir/includes/ballots/ChooseBallot.php",
	'SecurePoll_PreferentialBallot' => "$dir/includes/ballots/PreferentialBallot.php",
	'SecurePoll_RadioRangeBallot' => "$dir/includes/ballots/RadioRangeBallot.php",
	'SecurePoll_RadioRangeCommentBallot' => "$dir/includes/ballots/RadioRangeCommentBallot.php",

	# crypt
	'SecurePoll_Crypt' => "$dir/includes/crypt/Crypt.php",
	'SecurePoll_GpgCrypt' => "$dir/includes/crypt/Crypt.php",
	'SecurePoll_Random' => "$dir/includes/crypt/Random.php",

	# entities
	'SecurePoll_Election' => "$dir/includes/entities/Election.php",
	'SecurePoll_Entity' => "$dir/includes/entities/Entity.php",
	'SecurePoll_Option' => "$dir/includes/entities/Option.php",
	'SecurePoll_Question' => "$dir/includes/entities/Question.php",

	# main
	'SecurePoll_BasePage' => "$dir/includes/main/Base.php",
	'SecurePoll_Context' => "$dir/includes/main/Context.php",
	'SecurePoll_DBStore' => "$dir/includes/main/Store.php",
	'SecurePoll_MemoryStore' => "$dir/includes/main/Store.php",
	'SecurePoll_Store' => "$dir/includes/main/Store.php",
	'SecurePoll_XMLStore' => "$dir/includes/main/Store.php",

	# pages
	'SecurePoll_DetailsPage' => "$dir/includes/pages/DetailsPage.php",
	'SecurePoll_DumpPage' => "$dir/includes/pages/DumpPage.php",
	'SecurePoll_EntryPage' => "$dir/includes/pages/EntryPage.php",
	'SecurePoll_ListPage' => "$dir/includes/pages/ListPage.php",
	'SecurePoll_LoginPage' => "$dir/includes/pages/LoginPage.php",
	'SecurePoll_MessageDumpPage' => "$dir/includes/pages/MessageDumpPage.php",
	'SecurePoll_Page' => "$dir/includes/pages/Page.php",
	'SecurePoll_TallyPage' => "$dir/includes/pages/TallyPage.php",
	'SecurePoll_TranslatePage' => "$dir/includes/pages/TranslatePage.php",
	'SecurePoll_VotePage' => "$dir/includes/pages/VotePage.php",
	'SecurePoll_Voter' => "$dir/includes/user/Voter.php",

	# talliers
	'SecurePoll_ElectionTallier' => "$dir/includes/talliers/ElectionTallier.php",
	'SecurePoll_HistogramRangeTallier' => "$dir/includes/talliers/HistogramRangeTallier.php",
	'SecurePoll_PairwiseTallier' => "$dir/includes/talliers/PairwiseTallier.php",
	'SecurePoll_PluralityTallier' => "$dir/includes/talliers/PluralityTallier.php",
	'SecurePoll_SchulzeTallier' => "$dir/includes/talliers/SchulzeTallier.php",
	'SecurePoll_AlternativeVoteTallier' => "$dir/includes/talliers/AlternativeVoteTallier.php",
	'SecurePoll_Tallier' => "$dir/includes/talliers/Tallier.php",
	'SecurePoll_CommentDumper' => "$dir/includes/talliers/CommentDumper.php",

	# user
	'SecurePoll_Auth' => "$dir/includes/user/Auth.php",
	'SecurePoll_LocalAuth' => "$dir/includes/user/Auth.php",
	'SecurePoll_RemoteMWAuth' => "$dir/includes/user/Auth.php",
);

$wgAjaxExportList[] = 'wfSecurePollStrike';
$wgHooks['UserLogout'][] = 'wfSecurePollLogout';

function wfSecurePollStrike( $action, $id, $reason ) {
	return SecurePoll_ListPage::ajaxStrike( $action, $id, $reason );
}
function wfSecurePollLogout( $user ) {
	$_SESSION['securepoll_voter'] = null;
	return true;
}
