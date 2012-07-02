<?php
/** \file
* \brief Contains setup code for the Contribution Scores Extension.
*/

# Not a valid entry point, skip unless MEDIAWIKI is defined
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "Contribution Scores extension";
	exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Contribution Scores',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Contribution_Scores',
	'author' => 'Tim Laqua',
	'descriptionmsg' => 'contributionscores-desc',
	'version' => '1.15'
);

$dir = dirname( __FILE__ ) . '/';

define( 'CONTRIBUTIONSCORES_MAXINCLUDELIMIT', 50 );
$wgContribScoreReports = null;

// These settings can be overridden in LocalSettings.php.
$wgContribScoreIgnoreBlockedUsers = false; // Set to true to exclude bots from the reporting.
$wgContribScoreIgnoreBots = false; // Set to true to exclude blocked users from the reporting.
$wgContribScoresUseRealName = false; // Set to true to use real user names when available. Only for MediaWiki 1.19 and later.
$wgContribScoreDisableCache = false; // Set to true to disable cache for parser function and inclusion of table.

$wgAutoloadClasses['ContributionScores'] = $dir . 'ContributionScores_body.php';
$wgSpecialPages['ContributionScores'] = 'ContributionScores';
$wgSpecialPageGroups['ContributionScores'] = 'wiki';

$wgExtensionMessagesFiles['ContributionScores'] = $dir . 'ContributionScores.i18n.php';
$wgExtensionMessagesFiles['ContributionScoresAlias'] = $dir . 'ContributionScores.alias.php';
$wgExtensionMessagesFiles['ContributionScoresMagic'] = $dir . 'ContributionScores.i18n.magic.php';

$wgHooks['ParserFirstCallInit'][] = 'efContributionScores_Setup';

function efContributionScores_Setup( &$parser ) {
	$parser->setFunctionHook( 'cscore', 'efContributionScores_Render' );
	return true;
}

function efContributionScores_Render( &$parser, $usertext, $metric = 'score' ) {
	global $wgContribScoreDisableCache;

	if ( $wgContribScoreDisableCache ) {
		$parser->disableCache();
	}

	$user = User::newFromName( $usertext );
	$dbr = wfGetDB( DB_SLAVE );

	if ( $user instanceof User && $user->isLoggedIn() ) {
		global $wgLang;

		if ( $metric == 'score' ) {
			$res = $dbr->select( 'revision',
									'COUNT(DISTINCT rev_page)+SQRT(COUNT(rev_id)-COUNT(DISTINCT rev_page))*2 AS wiki_rank',
									array( 'rev_user' => $user->getID() ) );
			$row = $dbr->fetchObject( $res );
			$output = $wgLang->formatNum( round( $row->wiki_rank, 0 ) );
		} elseif ( $metric == 'changes' ) {
			$res = $dbr->select( 'revision',
									'COUNT(rev_id) AS rev_count',
									array( 'rev_user' => $user->getID() ) );
			$row = $dbr->fetchObject( $res );
			$output = $wgLang->formatNum( $row->rev_count );

		} elseif ( $metric == 'pages' ) {
			$res = $dbr->select( 'revision',
									'COUNT(DISTINCT rev_page) AS page_count',
									array( 'rev_user' => $user->getID() ) );
			$row = $dbr->fetchObject( $res );
			$output = $wgLang->formatNum( $row->page_count );
		} else {
			$output = wfMsg( 'contributionscores-invalidmetric' );
		}
	} else {
		$output = wfMsg( 'contributionscores-invalidusername' );
	}

	return $parser->insertStripItem( $output, $parser->mStripState );
}
