<?php
if ( !defined( 'MEDIAWIKI' ) ) die();
/**
 *
 * @author Brion Vibber
 * @author Aaron Schulz
 * @author Alexandre Emsenhuber
 * @author Chad Horohoe
 * @copyright Copyright © 2008 Brion Vibber <brion@pobox.com>
 * @copyright Copyright © 2008 Chad Horohoe <innocentkiller@gmail.com>
 * @copyright Copyright © 2008 Aaron Schulz <JSchulz_4587@msn.com>
 * @copyright Copyright © 2008 Alexandre Emsenhuber <alex.emsenhuber@bluewin.ch>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/*

What do I need out of SVN?

1) Find out what revisions exist
2) Get id/author/timestamp/notice basics
3) base path helps if available
4) get list of affected files
5) get diffs

http://pecl.php.net/package/svn

*/

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'CodeReview',
	'url' => 'https://www.mediawiki.org/wiki/Extension:CodeReview',
	'author' => array( 'Brion Vibber', 'Aaron Schulz', 'Alexandre Emsenhuber', 'Chad Horohoe', 'Sam Reed', 'Roan Kattouw' ),
	'descriptionmsg' => 'codereview-desc',
);

$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses['ApiCodeUpdate'] = $dir . 'api/ApiCodeUpdate.php';
$wgAutoloadClasses['ApiCodeDiff'] = $dir . 'api/ApiCodeDiff.php';
$wgAutoloadClasses['ApiRevisionUpdate'] = $dir . 'api/ApiRevisionUpdate.php';
$wgAutoloadClasses['ApiQueryCodeComments'] = $dir . 'api/ApiQueryCodeComments.php';
$wgAutoloadClasses['ApiQueryCodePaths'] = $dir . 'api/ApiQueryCodePaths.php';
$wgAutoloadClasses['ApiQueryCodeRevisions'] = $dir . 'api/ApiQueryCodeRevisions.php';
$wgAutoloadClasses['ApiQueryCodeTags'] = $dir . 'api/ApiQueryCodeTags.php';
$wgAutoloadClasses['CodeRevisionCommitterApi'] = $dir . 'api/CodeRevisionCommitterApi.php';

$wgAutoloadClasses['SubversionAdaptor'] = $dir . 'backend/Subversion.php';
$wgAutoloadClasses['CodeDiffHighlighter'] = $dir . 'backend/DiffHighlighter.php';

$wgAutoloadClasses['CodeRepository'] = $dir . 'backend/CodeRepository.php';
$wgAutoloadClasses['CodeRevision'] = $dir . 'backend/CodeRevision.php';
$wgAutoloadClasses['CodeComment'] = $dir . 'backend/CodeComment.php';
$wgAutoloadClasses['CodeCommentLinker'] = $dir . 'backend/CodeCommentLinker.php';
$wgAutoloadClasses['CodeCommentLinkerHtml'] = $dir . 'backend/CodeCommentLinker.php';
$wgAutoloadClasses['CodeCommentLinkerWiki'] = $dir . 'backend/CodeCommentLinker.php';
$wgAutoloadClasses['CodePropChange'] = $dir . 'backend/CodePropChange.php';
$wgAutoloadClasses['CodeSignoff'] = $dir . 'backend/CodeSignoff.php';
$wgAutoloadClasses['RepoStats'] = $dir . 'backend/RepoStats.php';

$wgAutoloadClasses['CodeRepoListView'] = $dir . 'ui/CodeRepoListView.php';
$wgAutoloadClasses['CodeRepoStatsView'] = $dir . 'ui/CodeRepoStatsView.php';
$wgAutoloadClasses['CodeRevisionAuthorView'] = $dir . 'ui/CodeRevisionAuthorView.php';
$wgAutoloadClasses['CodeRevisionAuthorLink'] = $dir . 'ui/CodeRevisionAuthorLink.php';
$wgAutoloadClasses['CodeRevisionCommitter'] = $dir . 'ui/CodeRevisionCommitter.php';
$wgAutoloadClasses['CodeRevisionListView'] = $dir . 'ui/CodeRevisionListView.php';
$wgAutoloadClasses['CodeRevisionStatusView'] = $dir . 'ui/CodeRevisionStatusView.php';
$wgAutoloadClasses['CodeRevisionTagView'] = $dir . 'ui/CodeRevisionTagView.php';
$wgAutoloadClasses['CodeRevisionView'] = $dir . 'ui/CodeRevisionView.php';
$wgAutoloadClasses['CodeAuthorListView'] = $dir . 'ui/CodeAuthorListView.php';
$wgAutoloadClasses['CodeStatusListView'] = $dir . 'ui/CodeStatusListView.php';
$wgAutoloadClasses['CodeTagListView'] = $dir . 'ui/CodeTagListView.php';
$wgAutoloadClasses['CodeCommentsListView'] = $dir . 'ui/CodeCommentsListView.php';
$wgAutoloadClasses['CodeCommentsAuthorListView'] = $dir . 'ui/CodeCommentsAuthorListView.php';
$wgAutoloadClasses['CodeReleaseNotes'] = $dir . 'ui/CodeReleaseNotes.php';
$wgAutoloadClasses['CodeStatusChangeListView'] = $dir . 'ui/CodeStatusChangeListView.php';
$wgAutoloadClasses['CodeStatusChangeAuthorListView'] = $dir . 'ui/CodeStatusChangeAuthorListView.php';
$wgAutoloadClasses['SpecialCode'] = $dir . 'ui/SpecialCode.php';
$wgAutoloadClasses['CodeView'] = $dir . 'ui/CodeView.php';
$wgAutoloadClasses['SpecialRepoAdmin'] = $dir . 'ui/SpecialRepoAdmin.php';
$wgAutoloadClasses['WordCloud'] = $dir . 'ui/WordCloud.php';

$wgAutoloadClasses['SvnRevTablePager'] = $dir . 'ui/CodeRevisionListView.php';
$wgAutoloadClasses['CodeCommentsTablePager'] = $dir . 'ui/CodeCommentsListView.php';
$wgAutoloadClasses['SvnRevAuthorTablePager'] = $dir . 'ui/CodeRevisionAuthorView.php';
$wgAutoloadClasses['SvnRevStatusTablePager'] = $dir . 'ui/CodeRevisionStatusView.php';
$wgAutoloadClasses['SvnRevTagTablePager'] = $dir . 'ui/CodeRevisionTagView.php';
$wgAutoloadClasses['CodeStatusChangeTablePager'] = $dir . 'ui/CodeRevisionStatusView.php';

$wgSpecialPages['Code'] = 'SpecialCode';
$wgSpecialPageGroups['Code'] = 'developer';
$wgSpecialPages['RepoAdmin'] = 'SpecialRepoAdmin';
$wgSpecialPageGroups['RepoAdmin'] = 'developer';

$wgAPIModules['codeupdate'] = 'ApiCodeUpdate';
$wgAPIModules['codediff'] = 'ApiCodeDiff';
$wgAPIModules['coderevisionupdate'] ='ApiRevisionUpdate';
$wgAPIListModules['codecomments'] = 'ApiQueryCodeComments';
$wgAPIListModules['codepaths'] = 'ApiQueryCodePaths';
$wgAPIListModules['coderevisions'] = 'ApiQueryCodeRevisions';
$wgAPIListModules['codetags'] = 'ApiQueryCodeTags';

$wgExtensionMessagesFiles['CodeReview'] = $dir . 'CodeReview.i18n.php';
$wgExtensionMessagesFiles['CodeReviewAliases'] = $dir . 'CodeReview.alias.php';

$wgAvailableRights[] = 'repoadmin';
$wgAvailableRights[] = 'codereview-use';
$wgAvailableRights[] = 'codereview-add-tag';
$wgAvailableRights[] = 'codereview-remove-tag';
$wgAvailableRights[] = 'codereview-post-comment';
$wgAvailableRights[] = 'codereview-set-status';
$wgAvailableRights[] = 'codereview-signoff';
$wgAvailableRights[] = 'codereview-associate';
$wgAvailableRights[] = 'codereview-link-user';
$wgAvailableRights[] = 'codereview-review-own';

$wgGroupPermissions['*']['codereview-use'] = true;

$wgGroupPermissions['user']['codereview-add-tag'] = true;
$wgGroupPermissions['user']['codereview-remove-tag'] = true;
$wgGroupPermissions['user']['codereview-post-comment'] = true;
$wgGroupPermissions['user']['codereview-set-status'] = true;
$wgGroupPermissions['user']['codereview-link-user'] = true;
$wgGroupPermissions['user']['codereview-signoff'] = true;
$wgGroupPermissions['user']['codereview-associate'] = true;

$wgGroupPermissions['svnadmins']['repoadmin'] = true;

// Constants returned from CodeRepository::getDiff() when no diff can be calculated.

// If you can't directly access the remote SVN repo, you can set this
// to an offsite proxy running this fun little proxy tool:
// http://svn.wikimedia.org/viewvc/mediawiki/trunk/tools/codereview-proxy/
$wgSubversionProxy = false;
$wgSubversionProxyTimeout = 30; // default 3 secs is too short :)

// Command-line options to pass on SVN command line if SVN PECL extension
// isn't available and we're not using the proxy.
// Defaults here should allow working with both http: and https: repos
// as long as authentication isn't required.
$wgSubversionOptions = "--non-interactive --trust-server-cert";

// What is the default SVN import chunk size?
$wgCodeReviewImportBatchSize = 400;

// Shuffle the tag cloud
$wgCodeReviewShuffleTagCloud = false;

$commonModuleInfo = array(
	'localBasePath' => dirname( __FILE__ ) . '/modules',
	'remoteExtPath' => 'CodeReview/modules',
);

// Styles and any code common to all Special:Code subviews:
$wgResourceModules['ext.codereview'] = array(
	'scripts' => 'ext.codereview.js',
	'dependencies' => 'jquery.suggestions',
) + $commonModuleInfo;

$wgResourceModules['ext.codereview.styles'] = array(
	'styles' => 'ext.codereview.styles.css',
) + $commonModuleInfo;

// On-demand diff loader for CodeRevisionView:
$wgResourceModules['ext.codereview.loaddiff'] = array(
	'scripts' => 'ext.codereview.loaddiff.js'
) + $commonModuleInfo;

// Revision tooltips CodeRevisionView:
$wgResourceModules['ext.codereview.tooltips'] = array(
	'scripts' => 'ext.codereview.tooltips.js',
	'dependencies' => 'jquery.tipsy',
) + $commonModuleInfo;

// Revision 'scapmap':
$wgResourceModules['ext.codereview.overview'] = array(
	'scripts' => 'ext.codereview.overview.js',
	'styles' => 'ext.codereview.overview.css',
	'dependencies' => 'jquery.tipsy',
	'messages' => array( 'codereview-overview-title', 'codereview-overview-desc' ),
) + $commonModuleInfo;

// If you are running a closed svn, fill the following two lines with the username and password
// of a user allowed to access it. Otherwise, leave it false.
// This is only necessary if using the shell method to access Subversion
$wgSubversionUser = false;
$wgSubversionPassword = false;

// Leave this off by default until it works right
$wgCodeReviewENotif = false;

// Set this to an e-mail list to send all comments to
$wgCodeReviewCommentWatcherEmail = false;
// Name to use in the To: header of e-mails to the list. Ignored if $wgCodeReviewCommentWatcherEmail isn't set
$wgCodeReviewCommentWatcherName = "CodeReview comments list";

// What images can be used for client-side side-by-side comparisons?
$wgCodeReviewImgRegex = '/\.(png|jpg|jpeg|gif)$/i';

/**
 * Maximum size of diff text before it is omitted from the revision view
 */
$wgCodeReviewMaxDiffSize = 500000;

/**
 * The maximum number of paths that we will perform a diff on.
 * If a revision contains more changed paths than this, we will skip getting the
 * diff altogether.
 * May be set to 0 to indicate no limit.
 */
$wgCodeReviewMaxDiffPaths = 20;

/**
 * Key is repository name. Value is an array of regexes
 *
 * Any base paths matching regular expressions in these arrays will have their
 * default status set to deferred instead of new. Helpful if you've got a part
 * of the repository you don't care about.
 *
 * $wgCodeReviewDeferredPaths = array( 'RepoName' => array( '/path/to/use', '/another/path/to/use' ) )
 */
$wgCodeReviewDeferredPaths = array();

/**
 * Key is repository name. Value is an array of key value pairs of the path and then tags
 *
 * An array (or string, for 1 tag) of tags to add to a revision upon commit
 *
 * $wgCodeReviewAutoTagPath = array( 'RepoName' => array( '%^/path/to/use%' => 'sometag', '%^/another/path/to/use%' => array( 'tag1', 'tag2' ) ) )
 */
$wgCodeReviewAutoTagPath = array();

/**
 * Key is repository name. Value is an array of key value pairs of the paths to get fixme list for
 *
 * $wgCodeReviewFixmePerPath = array( 'RepoName' => array( '/path/to/use', '/another/path/to/use' ) )
 */
$wgCodeReviewFixmePerPath = array();

/**
 * Key is repository name. Value is an array of key value pairs of the paths to get new list for
 *
 * $wgCodeReviewNewPerPath = array( 'RepoName' => array( '/path/to/use', '/another/path/to/use' ) )
 */
$wgCodeReviewNewPerPath = array();

/**
 * UDP comment and status changes notification
 */
$wgCodeReviewUDPAddress = false;
$wgCodeReviewUDPPort = false;
$wgCodeReviewUDPPrefix = '';

/**
* How long to cache repository statistics in seconds
* See http://www.mediawiki.org/wiki/Special:Code/MediaWiki/stats
 */
$wgCodeReviewRepoStatsCacheTime = 6 * 60 * 60; // 6 Hours

/**
 * Possible states a revision can be in
 *
 * A system message will still needed to be added as code-status-<state>
 */
$wgCodeReviewStates = array(
	'new',
	'fixme',
	'reverted',
	'resolved',
	'ok',
	'deferred',
	'old',
);

/**
 * Revisions states that a user cannot change to on their own revision
 */
$wgCodeReviewProtectedStates = array(
	'ok',
	'resolved',
);

/**
 * List of all flags a user can mark themself as having done to a revision
 *
 * A system message will still needed to be added as code-signoff-flag-<flag>
 */
$wgCodeReviewFlags = array(
	'inspected',
	'tested',
);

# Schema changes
$wgHooks['LoadExtensionSchemaUpdates'][] = 'efCodeReviewSchemaUpdates';

/**
 * @param $updater DatabaseUpdater
 * @return bool
 */
function efCodeReviewSchemaUpdates( $updater ) {
	$base = dirname( __FILE__ );
	switch ( $updater->getDB()->getType() ) {
	case 'mysql':
		$updater->addExtensionTable( 'code_rev', "$base/codereview.sql" ); // Initial install tables
		$updater->addExtensionField( 'code_rev', 'cr_diff',
			"$base/archives/codereview-cr_diff.sql" );
		$updater->addExtensionIndex( 'code_relations', 'repo_to_from',
			"$base/archives/code_relations_index.sql" );

		if ( !$updater->updateRowExists( 'make cr_status varchar' ) ) {
			$updater->addExtensionUpdate( array( 'modifyField', 'code_rev', 'cr_status',
				"$base/archives/codereview-cr_status_varchar.sql", true ) );
		}

		$updater->addExtensionTable( 'code_bugs', "$base/archives/code_bugs.sql" );

		$updater->addExtensionTable( 'code_signoffs', "$base/archives/code_signoffs.sql" );

		$updater->addExtensionField( 'code_signoffs', 'cs_user',
			"$base/archives/code_signoffs_userid.sql" );
		$updater->addExtensionField( 'code_signoffs', 'cs_timestamp_struck',
			"$base/archives/code_signoffs_timestamp_struck.sql" );

		$updater->addExtensionIndex( 'code_comment', 'cc_author',
			"$base/archives/code_comment_author-index.sql" );

		$updater->addExtensionIndex( 'code_prop_changes', 'cpc_author',
			"$base/archives/code_prop_changes_author-index.sql" );

		if ( !$updater->updateRowExists( 'make cp_action char' ) ) {
			$updater->addExtensionUpdate( array( 'modifyField', 'code_paths', 'cp_action',
				"$base/archives/codereview-cp_action_char.sql", true ) );
		}

		if ( !$updater->updateRowExists( 'make cpc_attrib varchar' ) ) {
			$updater->addExtensionUpdate( array( 'modifyField', 'code_prop_changes', 'cpc_attrib',
				"$base/archives/codereview-cpc_attrib_varchar.sql", true ) );
		}

		$updater->addExtensionIndex( 'code_paths', 'repo_path',
			"$base/archives/codereview-repopath.sql" );

		$updater->addExtensionIndex( 'code_rev', 'cr_repo_status_author',
			"$base/archives/code_revs_status_author-index.sql" );

		$updater->addExtensionUpdate( array( 'dropField', 'code_comment', 'cc_review',
			"$base/archives/code_drop_cc_review.sql", true ) );

		$updater->addExtensionUpdate( array( 'dropTable', 'code_test_suite', "$base/archives/code_drop_test.sql", true ) );
		break;
	case 'sqlite':
		$updater->addExtensionTable( 'code_rev', "$base/codereview.sql" );
		$updater->addExtensionTable( 'code_signoffs', "$base/archives/code_signoffs.sql" );
		$updater->addExtensionUpdate( array( 'addField', 'code_signoffs', 'cs_user',
			"$base/archives/code_signoffs_userid-sqlite.sql", true ) );
		$updater->addExtensionUpdate( array( 'addField', 'code_signoffs', 'cs_timestamp_struck',
			"$base/archives/code_signoffs_timestamp_struck.sql", true ) );
		$updater->addExtensionUpdate( array( 'addIndex', 'code_paths', 'repo_path',
			"$base/archives/codereview-repopath.sql", true ) );
		break;
	case 'postgres':
		// TODO
		break;
	}
	return true;
}

# Unit tests
$wgHooks['UnitTestsList'][] = 'efCodeReviewUnitTests';

/**
 * @param $files array
 * @return bool
 */
function efCodeReviewUnitTests( &$files ) {
	$files[] = dirname( __FILE__ ) . '/tests/CodeReviewApiTest.php';
	$files[] = dirname( __FILE__ ) . '/tests/CodeReviewTest.php';
	$files[] = dirname( __FILE__ ) . '/tests/DiffHighlighterTest.php';
	return true;
}

# Add global JS vars
$wgHooks['MakeGlobalVariablesScript'][] = 'efCodeReviewResourceLoaderGlobals';

/**
 * @param $values array
 * @return bool
 */
function efCodeReviewResourceLoaderGlobals( &$values ){
	# Bleugh, this is horrible
	global $wgTitle;
	if( $wgTitle->isSpecial( 'Code' ) ){
		$bits = explode( '/', $wgTitle->getText() );
		if( isset( $bits[1] ) ){
			$values['wgCodeReviewRepository'] = $bits[1];
		}
	}
	return true;
}

# Add state messages to RL
$wgExtensionFunctions[] = 'efCodeReviewAddTooltipMessages';

function efCodeReviewAddTooltipMessages() {
	global $wgResourceModules;

	$wgResourceModules['ext.codereview.tooltips']['messages'] = array_merge(
		CodeRevision::getPossibleStateMessageKeys(),
		array( 'code-tooltip-withsummary', 'code-tooltip-withoutsummary' ) );
}
