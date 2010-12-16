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
	'url' => 'http://www.mediawiki.org/wiki/Extension:CodeReview',
	'author' => array( 'Brion Vibber', 'Aaron Schulz', 'Alexandre Emsenhuber', 'Chad Horohoe' ),
	'descriptionmsg' => 'code-desc',
);

$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses['ApiCodeUpdate'] = $dir . 'api/ApiCodeUpdate.php';
$wgAutoloadClasses['ApiCodeDiff'] = $dir . 'api/ApiCodeDiff.php';
$wgAutoloadClasses['ApiCodeComments'] = $dir . 'api/ApiCodeComments.php';
$wgAutoloadClasses['ApiCodeTestUpload'] = $dir . 'api/ApiCodeTestUpload.php';

$wgAutoloadClasses['SubversionAdaptor'] = $dir . 'backend/Subversion.php';
$wgAutoloadClasses['CodeDiffHighlighter'] = $dir . 'backend/DiffHighlighter.php';

$wgAutoloadClasses['CodeRepository'] = $dir . 'backend/CodeRepository.php';
$wgAutoloadClasses['CodeRevision'] = $dir . 'backend/CodeRevision.php';
$wgAutoloadClasses['CodeComment'] = $dir . 'backend/CodeComment.php';
$wgAutoloadClasses['CodeCommentLinker'] = $dir . 'backend/CodeCommentLinker.php';
$wgAutoloadClasses['CodeCommentLinkerHtml'] = $dir . 'backend/CodeCommentLinker.php';
$wgAutoloadClasses['CodeCommentLinkerWiki'] = $dir . 'backend/CodeCommentLinker.php';
$wgAutoloadClasses['CodePropChange'] = $dir . 'backend/CodePropChange.php';
$wgAutoloadClasses['CodeTestSuite'] = $dir . 'backend/CodeTestSuite.php';
$wgAutoloadClasses['CodeTestRun'] = $dir . 'backend/CodeTestRun.php';
$wgAutoloadClasses['CodeTestResult'] = $dir . 'backend/CodeTestResult.php';

$wgAutoloadClasses['CodeRepoListView'] = $dir . 'ui/CodeRepoListView.php';
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
$wgAutoloadClasses['CodeReleaseNotes'] = $dir . 'ui/CodeReleaseNotes.php';
$wgAutoloadClasses['CodeStatusChangeListView'] = $dir . 'ui/CodeStatusChangeListView.php';
$wgAutoloadClasses['SpecialCode'] = $dir . 'ui/SpecialCode.php';
$wgAutoloadClasses['CodeView'] = $dir . 'ui/SpecialCode.php';
$wgAutoloadClasses['SpecialRepoAdmin'] = $dir . 'ui/SpecialRepoAdmin.php';


$wgSpecialPages['Code'] = 'SpecialCode';
$wgSpecialPageGroups['Code'] = 'developer';
$wgSpecialPages['RepoAdmin'] = 'SpecialRepoAdmin';
$wgSpecialPageGroups['RepoAdmin'] = 'developer';

$wgAPIModules['codeupdate'] = 'ApiCodeUpdate';
$wgAPIModules['codediff'] = 'ApiCodeDiff';
$wgAPIModules['codetestupload'] = 'ApiCodeTestUpload';
$wgAPIListModules['codecomments'] = 'ApiCodeComments';

$wgExtensionMessagesFiles['CodeReview'] = $dir . 'CodeReview.i18n.php';
$wgExtensionAliasesFiles['CodeReview'] = $dir . 'CodeReview.alias.php';

$wgAvailableRights[] = 'repoadmin';
$wgAvailableRights[] = 'codereview-use';
$wgAvailableRights[] = 'codereview-add-tag';
$wgAvailableRights[] = 'codereview-remove-tag';
$wgAvailableRights[] = 'codereview-post-comment';
$wgAvailableRights[] = 'codereview-set-status';
$wgAvailableRights[] = 'codereview-link-user';

$wgGroupPermissions['*']['codereview-use'] = true;

$wgGroupPermissions['user']['codereview-add-tag'] = true;
$wgGroupPermissions['user']['codereview-remove-tag'] = true;
$wgGroupPermissions['user']['codereview-post-comment'] = true;
$wgGroupPermissions['user']['codereview-set-status'] = true;
$wgGroupPermissions['user']['codereview-link-user'] = true;

$wgGroupPermissions['steward']['repoadmin'] = true; // temp

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

// Bump the version number every time you change a CodeReview .css/.js file
$wgCodeReviewStyleVersion = 5;

// The name of a repo which represents the code running on this wiki, used to highlight active revisions
$wgWikiSVN = '';

// If you are running a closed svn, fill the following two lines with the username and password
// of a user allowed to access it. Otherwise, leave it false.
// This is only necessary if using the shell method to access Subversion
$wgSubversionUser = false;
$wgSubversionPassword = false;

// Leave this off by default until it works right
$wgCodeReviewENotif = false;

// Set this to an e-mail list to send all comments to
$wgCodeReviewCommentWatcher = false;

// What images can be used for client-side side-by-side comparisons?
$wgCodeReviewImgRegex = '/\.(png|jpg|jpeg|gif)$/i';

// Set to a secret string for HMAC validation of test run data uploads.
// Should match test runner's $wgParserTestRemote['secret'].
$wgCodeReviewSharedSecret = false;

/**
 * Maximum size of diff text before it is omitted from the revision view
 */
$wgCodeReviewMaxDiffSize = 500000;

# Schema changes
$wgHooks['LoadExtensionSchemaUpdates'][] = 'efCodeReviewSchemaUpdates';

function efCodeReviewSchemaUpdates() {
	global $wgDBtype, $wgExtNewFields, $wgExtPGNewFields, $wgExtNewIndexes, $wgExtNewTables;
	$base = dirname(__FILE__);
	if( $wgDBtype == 'mysql' ) {
		$wgExtNewTables[] = array( 'code_rev', "$base/codereview.sql" ); // Initial install tables
		$wgExtNewFields[] = array( 'code_rev', 'cr_diff', "$base/archives/codereview-cr_diff.sql" );
		$wgExtNewIndexes[] = array( 'code_relations', 'repo_to_from', "$base/archives/code_relations_index.sql" );
		//$wgExtNewFields[] = array( 'code_rev', "$base/archives/codereview-cr_status.sql" ); // FIXME FIXME this is a change to options... don't know how
		$wgExtNewTables[] = array( 'code_bugs', "$base/archives/code_bugs.sql" );
		$wgExtNewTables[] = array( 'code_test_suite', "$base/archives/codereview-code_tests.sql" );
	} elseif( $wgDBtype == 'postgres' ) {
		// TODO
	}
	return true;
}

