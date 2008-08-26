<?php
/*
 (c) Aaron Schulz, Joerg Baach, 2007-2008 GPL
 
 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License along
 with this program; if not, write to the Free Software Foundation, Inc.,
 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 http://www.gnu.org/copyleft/gpl.html
*/

if( !defined('MEDIAWIKI') ) {
	echo "FlaggedRevs extension\n";
	exit( 1 );
}

# This messes with dump HTML...
if( defined('MW_HTML_FOR_DUMP') ) {
	return;
}

# Quality -> Sighted (default)
if( !defined('FLAGGED_VIS_NORMAL') )
	define('FLAGGED_VIS_NORMAL',0);
# No precedence
if( !defined('FLAGGED_VIS_LATEST') )
	define('FLAGGED_VIS_LATEST',1);
# Pristine -> Quality -> Sighted
if( !defined('FLAGGED_VIS_PRISTINE') )
	define('FLAGGED_VIS_PRISTINE',2);
	
if( !defined('FR_FOR_UPDATE') )
	define('FR_FOR_UPDATE',1);
if( !defined('FR_TEXT') )
	define('FR_TEXT',2);

$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'Flagged Revisions',
	'author'         => array( 'Aaron Schulz', 'Joerg Baach' ),
	'version'        => '1.094',
	'svn-date'       => '$LastChangedDate: 2008-08-08 04:53:04 -0400 (Fri, 08 Aug 2008) $',
	'svn-revision'   => '$LastChangedRevision: 38863 $',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:FlaggedRevs',
	'descriptionmsg' => 'flaggedrevs-desc',
);

#########
# IMPORTANT:
# When configuring globals, add them to localsettings.php and edit them THERE

# This will only distinguish "sigted", "quality", and unreviewed
# A small icon will show in the upper right hand corner
$wgSimpleFlaggedRevsUI = false;
# Add stable/draft revision tabs. May be redundant due to the tags.
# If you have an open wiki, with the simple UI, you may want to enable these.
$wgFlaggedRevTabs = false;
# For non-user visitors, only show tags/icons for *unreviewed* pages
$wgFlaggedRevsLowProfile = false;

# Allowed namespaces of reviewable pages
$wgFlaggedRevsNamespaces = array( NS_MAIN );
# Patrollable namespaces
$wgFlaggedRevsPatrolNamespaces = array( NS_CATEGORY, NS_IMAGE, NS_TEMPLATE );

# Pages exempt from reviewing
$wgFlaggedRevsWhitelist = array();
# $wgFlaggedRevsWhitelist = array( 'Main_Page' );

# Do flagged revs override the default view?
$wgFlaggedRevsOverride = true;
# Do quality revisions show instead of sighted if present by default?
$wgFlaggedRevsPrecedence = true;
# Revision tagging can slow development...
# For example, the main user base may become complacent, perhaps treat flagged
# pages as "done", or just be too lazy to click "current". We may just want non-user
# visitors to see reviewed pages by default.
# Below are groups that see the current revision by default.
$wgFlaggedRevsExceptions = array( 'user' );

# Can users make comments that will show up below flagged revisions?
$wgFlaggedRevsComments = false;
# Redirect users out to review changes since stable version on save?
$wgReviewChangesAfterEdit = true;
# Auto-review edits directly to the stable version by reviewers?
# Depending on how often templates are edited and by whom, this can possibly
# allow for vandalism to slip in :/
# Users should preview changes perhaps. This doesn't help much for section
# editing, so they may also want to review the page afterwards.
$wgFlaggedRevsAutoReview = true;
# Auto-review new pages with the minimal level?
$wgFlaggedRevsAutoReviewNew = false;

# When parsing a reviewed revision, if a template to be transcluded
# has a stable version, use that version. If not present, use the one
# specified when the reviewed revision was reviewed. Note that the
# fr_text column will not be used, which may reduce performance. It will
# still be populated however, so that these settings can be retroactively
# changed.
$wgUseStableTemplates = false;
# We may have templates that do not have stable version. Given situational
# inclusion of templates (such as parser functions that select template
# X or Y depending), there may also be no revision ID for each template
# pointed to by the metadata of how the article was when it was reviewed.
# An example would be an article that selects a template based on time.
# The template to be selected will change, and the metadata only points
# to the reviewed revision ID of the old template. This can be a problem if
# $wgUseStableTemplates is enabled. In such cases, we can select the
# current (unreviewed) revision.
$wgUseCurrentTemplates = true;

# Similar to above...
$wgUseStableImages = false;
$wgUseCurrentImages = true;

# When setting up new dimensions or levels, you will need to add some
# MediaWiki messages for the UI to show properly; any sysop can do this.
# Define the tags we can use to rate an article, and set the minimum level
# to have it become a "quality" version. "Quality" revisions take precedence
# over other reviewed revisions
$wgFlaggedRevTags = array( 'accuracy'=>2, 'depth'=>1, 'style'=>1 );
# How high can we rate these revisions?
$wgFlaggedRevValues = 4;
# A revision with all tags rated at least to this level is considered "pristine"/"featured"
$wgFlaggedRevPristine = 4;
# Who can set what flags to what level? (use -1 or 0 for not at all)
# Users cannot lower tags from a level they can't set
# Users with 'validate' can do anything regardless
# This is mainly for custom, less experienced, groups
$wgFlagRestrictions = array(
	'accuracy' => array( 'review' => 1 ),
	'depth'	   => array( 'review' => 2 ),
	'style'	   => array( 'review' => 3 ),
);

# Please set these as something different. Any text will do, though it probably
# shouldn't be very short (less secure) or very long (waste of resources).
# There must be four codes, and only the first four are checked.
$wgReviewCodes = array();

# URL location for flaggedrevs.css and flaggedrevs.js
# Use a literal $wgScriptPath as a placeholder for the runtime value of $wgScriptPath
$wgFlaggedRevsStylePath = '$wgScriptPath/extensions/FlaggedRevs';

# Lets some users access the review UI and set some flags
$wgAvailableRights[] = 'review';
# Let some users set higher settings
$wgAvailableRights[] = 'validate';
$wgAvailableRights[] = 'autoreview';
$wgAvailableRights[] = 'patrolmarks';
$wgAvailableRights[] = 'autopatrolother';
$wgAvailableRights[] = 'unreviewedpages';

# Define our basic reviewer class
$wgGroupPermissions['editor']['review']          = true;
$wgGroupPermissions['editor']['autoreview']      = true;
$wgGroupPermissions['editor']['autoconfirmed']   = true;
$wgGroupPermissions['editor']['patrolmarks']     = true;
$wgGroupPermissions['editor']['autopatrolother'] = true;
$wgGroupPermissions['editor']['unreviewedpages'] = true;

# Defines extra rights for advanced reviewer class
$wgGroupPermissions['reviewer']['validate'] = true;
# Let this stand alone just in case...
$wgGroupPermissions['reviewer']['review'] = true;

$wgGroupPermissions['bot']['autoreview'] = true;

# Stable version selection and default page revision selection can be set per page.
$wgGroupPermissions['sysop']['stablesettings'] = true;
# Sysops can always move stable pages
$wgGroupPermissions['sysop']['movestable'] = true;

# Try to avoid flood by having autoconfirmed user edits to non-reviewable
# namespaces autopatrolled.
$wgGroupPermissions['autoconfirmed']['autopatrolother'] = true;

# Define when users get automatically promoted to editors. Set as false to disable.
# 'spacing' and 'benchmarks' require edits to be spread out. Users must have X (benchmark)
# edits Y (spacing) days apart.
$wgFlaggedRevsAutopromote = array(
	'days'	              => 60, # days since registration
	'edits'	              => 350, # total edit count
	'excludeDeleted'      => true, # exclude deleted edits from 'edits' count above?
	'spacing'	          => 3, # spacing of edit intervals
	'benchmarks'          => 15, # how many edit intervals are needed?
	'recentContentEdits'  => 10, # $wgContentNamespaces edits in recent changes
	'totalContentEdits'   => 300, # $wgContentNamespaces edits
	'uniqueContentPages'  => 10, # $wgContentNamespaces unique pages edited
	'editComments'        => 50, # how many edit comments used?
	'email'	              => true, # user must be emailconfirmed?
	'userpage'            => true, # user must have a userpage?
	'userpageBytes'       => 100, # if userpage is needed, what is the min size?
	'uniqueIPAddress'     => false, # If $wgPutIPinRC is true, users sharing IPs won't be promoted
	'neverBlocked'        => true, # Can users that were blocked be promoted?
	'noSorbsMatches'      => false, # If $wgSorbsUrl is set, do not promote users that match
);

# Special:Userrights settings
## Basic rights for Sysops
$wgAddGroups['sysop'][] = 'editor';
$wgRemoveGroups['sysop'][] = 'editor';
## Extra ones for Bureaucrats
## Add UI page rights just in case we have non-sysop bcrats
$wgAddGroups['bureaucrat'][] = 'reviewer';
$wgRemoveGroups['bureaucrat'][] = 'reviewer';

# If you want to use a storage group specifically for this
# software, set this array
$wgFlaggedRevsExternalStore = false;

# Show reviews in recentchanges? Disabled by default, often spammy...
$wgFlaggedRevsLogInRC = false;

# How far the logs for overseeing quality revisions and depreciations go
$wgFlaggedRevsOversightAge = 7 * 24 * 3600;

# How many hours pending review is considering long?
$wgFlaggedRevsLongPending = array( 3, 12, 24 );
# How many pages count as a backlog?
$wgFlaggedRevsBacklog = 1000;

# Flagged revisions are always visible to users with rights below.
# Use '*' for non-user accounts.
$wgFlaggedRevsVisible = array();
# If $wgFlaggedRevsVisible is populated, it is applied to talk pages too
$wgFlaggedRevsTalkVisible = true;

# Users that can use the feedback form.
$wgGroupPermissions['*']['feedback'] = false;

# Allow readers to rate pages in these namespaces
$wgFeedbackNamespaces = array( NS_MAIN );
# Reader feedback tags, positive and negative. [a-zA-Z] tag names only.
# Each tag has five levels, which 3 being average. The tag names are
# mapped to their weight. This is used to determine the "worst"/"best" pages.
$wgFlaggedRevsFeedbackTags = array( 'reliability' => 3, 'completeness' => 2, 'npov' => 2, 'presentation' => 1 );
# How many days back should the average rating for a page be based on?
$wgFlaggedRevsFeedbackAge = 7 * 24 * 3600;
# How long before stats page is updated?
$wgFlaggedRevsStatsAge = 2 * 3600; // 2 hours

$wgPHPlotDir = dirname(__FILE__) . '/phplot-5.0.5';

# End of configuration variables.
#########

# Bump this number every time you change flaggedrevs.css/flaggedrevs.js
$wgFlaggedRevStyleVersion = 35;

$wgExtensionFunctions[] = 'efLoadFlaggedRevs';

$dir = dirname(__FILE__) . '/';
$langDir = dirname(__FILE__) . '/language/';

$wgAutoloadClasses['FlaggedRevs'] = $dir.'FlaggedRevs.class.php';
$wgExtensionMessagesFiles['FlaggedRevs'] = $langDir . 'FlaggedRevs.i18n.php';
$wgExtensionAliasesFiles['FlaggedRevs'] = $langDir . 'FlaggedRevs.i18n.alias.php';

# Load general UI
$wgAutoloadClasses['FlaggedRevsXML'] = $dir . 'FlaggedRevsXML.php';
# Load context article stuff
$wgAutoloadClasses['FlaggedArticle'] = $dir . 'FlaggedArticle.php';
# Load FlaggedRevision object class
$wgAutoloadClasses['FlaggedRevision'] = $dir . 'FlaggedRevision.php';
# Load review UI
$wgSpecialPages['RevisionReview'] = 'RevisionReview';
$wgAutoloadClasses['RevisionReview'] = $dir . 'FlaggedRevsPage.php';
# Load reader feedback UI
$wgSpecialPages['ReaderFeedback'] = 'ReaderFeedback';
$wgAutoloadClasses['ReaderFeedback'] = $dir . '/specialpages/ReaderFeedback_body.php';

# Load stableversions UI
$wgSpecialPages['StableVersions'] = 'StableVersions';
$wgAutoloadClasses['StableVersions'] = $dir . '/specialpages/StableVersions_body.php';
$wgExtensionMessagesFiles['StableVersions'] = $langDir . 'StableVersions.i18n.php';
# Stable version config
$wgSpecialPages['Stabilization'] = 'Stabilization';
$wgAutoloadClasses['Stabilization'] = $dir . '/specialpages/Stabilization_body.php';
$wgExtensionMessagesFiles['Stabilization'] = $langDir . 'Stabilization.i18n.php';
# Page rating history
$wgSpecialPages['RatingHistory'] = 'RatingHistory';
$wgAutoloadClasses['RatingHistory'] = $dir . '/specialpages/RatingHistory_body.php';
$wgExtensionMessagesFiles['RatingHistory'] = $langDir . 'RatingHistory.i18n.php';
# Load unreviewed pages list
$wgSpecialPages['UnreviewedPages'] = 'UnreviewedPages';
$wgAutoloadClasses['UnreviewedPages'] = $dir . '/specialpages/UnreviewedPages_body.php';
$wgExtensionMessagesFiles['UnreviewedPages'] = $langDir . 'UnreviewedPages.i18n.php';
$wgSpecialPageGroups['UnreviewedPages'] = 'quality';
# Load "in need of re-review" pages list
$wgSpecialPages['OldReviewedPages'] = 'OldReviewedPages';
$wgAutoloadClasses['OldReviewedPages'] = $dir . '/specialpages/OldReviewedPages_body.php';
$wgExtensionMessagesFiles['OldReviewedPages'] = $langDir . 'OldReviewedPages.i18n.php';
$wgSpecialPageGroups['OldReviewedPages'] = 'quality';
# Load reviewed pages list
$wgSpecialPages['ReviewedPages'] = 'ReviewedPages';
$wgAutoloadClasses['ReviewedPages'] = $dir . '/specialpages/ReviewedPages_body.php';
$wgExtensionMessagesFiles['ReviewedPages'] = $langDir . 'ReviewedPages.i18n.php';
$wgSpecialPageGroups['ReviewedPages'] = 'quality';
# Load stable pages list
$wgSpecialPages['StablePages'] = 'StablePages';
$wgAutoloadClasses['StablePages'] = $dir . '/specialpages/StablePages_body.php';
$wgExtensionMessagesFiles['StablePages'] = $langDir . 'StablePages.i18n.php';
$wgSpecialPageGroups['StablePages'] = 'quality';
# To oversee quality revisions
$wgSpecialPages['QualityOversight'] = 'QualityOversight';
$wgAutoloadClasses['QualityOversight'] = $dir . '/specialpages/QualityOversight_body.php';
$wgExtensionMessagesFiles['QualityOversight'] = $langDir . 'QualityOversight.i18n.php';
$wgSpecialPageGroups['QualityOversight'] = 'quality';
# To oversee quality revisions
$wgSpecialPages['ProblemPages'] = 'ProblemPages';
$wgAutoloadClasses['ProblemPages'] = $dir . '/specialpages/ProblemPages_body.php';
$wgExtensionMessagesFiles['ProblemPages'] = $langDir . 'ProblemPages.i18n.php';
$wgSpecialPageGroups['ProblemPages'] = 'quality';
# Statistics
$wgSpecialPages['ValidationStatistics'] = 'ValidationStatistics';
$wgAutoloadClasses['ValidationStatistics'] = $dir . '/specialpages/ValidationStatistics_body.php';
$wgExtensionMessagesFiles['ValidationStatistics'] = $langDir . 'ValidationStatistics.i18n.php';
$wgSpecialPageGroups['ValidationStatistics'] = 'quality';

######### Hook attachments #########
# Remove stand-alone patrolling
$wgHooks['UserGetRights'][] = 'FlaggedRevs::stripPatrolRights';

# Autopromote Editors
$wgHooks['ArticleSaveComplete'][] = 'FlaggedRevs::autoPromoteUser';
# Adds table link references to include ones from the stable version
$wgHooks['LinksUpdateConstructed'][] = 'FlaggedRevs::extraLinksUpdate';
# Empty flagged page settings row on delete
$wgHooks['ArticleDeleteComplete'][] = 'FlaggedRevs::deleteVisiblitySettings';
# Check on undelete/merge/revisiondelete for changes to stable version
$wgHooks['ArticleRevisionVisiblitySet'][] = 'FlaggedRevs::titleLinksUpdate';
$wgHooks['ArticleMergeComplete'][] = 'FlaggedRevs::updateFromMerge';
$wgHooks['ArticleRevisionUndeleted'][] = 'FlaggedRevs::updateFromRestore';
# Parser hooks, selects the desired images/templates
$wgHooks['ParserClearState'][] = 'FlaggedRevs::parserAddFields';
$wgHooks['BeforeGalleryFindFile'][] = 'FlaggedRevs::galleryFindStableFileTime';
$wgHooks['BeforeParserFetchTemplateAndtitle'][] = 'FlaggedRevs::parserFetchStableTemplate';
$wgHooks['BeforeParserMakeImageLinkObj'][] = 'FlaggedRevs::parserMakeStableImageLink';
# Additional parser versioning
$wgHooks['ParserAfterTidy'][] = 'FlaggedRevs::parserInjectTimestamps';
$wgHooks['OutputPageParserOutput'][] = 'FlaggedRevs::outputInjectTimestamps';
# Auto-reviewing
$wgHooks['RecentChange_save'][] = 'FlaggedRevs::autoMarkPatrolled';
$wgHooks['NewRevisionFromEditComplete'][] = 'FlaggedRevs::maybeMakeEditReviewed';
# Disallow moves of stable pages
$wgHooks['userCan'][] = 'FlaggedRevs::userCanMove';
# Log parameter
$wgHooks['LogLine'][] = 'FlaggedRevs::reviewLogLine';
# Disable auto-promotion for demoted users
$wgHooks['UserRights'][] = 'FlaggedRevs::recordDemote';
# Local user account preference
$wgHooks['RenderPreferencesForm'][] = 'FlaggedRevs::injectPreferences';
$wgHooks['InitPreferencesForm'][] = 'FlaggedRevs::injectFormPreferences';
$wgHooks['ResetPreferences'][] = 'FlaggedRevs::resetPreferences';
$wgHooks['SavePreferences'][] = 'FlaggedRevs::savePreferences';
# Show unreviewed pages links
$wgHooks['CategoryPageView'][] = 'FlaggedRevs::unreviewedPagesLinks';
# Backlog notice
$wgHooks['SiteNoticeAfter'][] = 'FlaggedRevs::addBacklogNotice';

# Visibility - experimental
$wgHooks['userCan'][] = 'FlaggedRevs::userCanView';

# Override current revision, add patrol links, set cache...
$wgHooks['ArticleViewHeader'][] = 'FlaggedRevs::onArticleViewHeader';
$wgHooks['ImagePageFindFile'][] = 'FlaggedRevs::imagePageFindFile';
# Override redirect behavoir...
$wgHooks['InitializeArticleMaybeRedirect'][] = 'FlaggedRevs::overrideRedirect';
# Sets tabs and permalink
$wgHooks['SkinTemplateTabs'][] = 'FlaggedRevs::setActionTabs';
# Add tags do edit view
$wgHooks['EditPage::showEditForm:initial'][] = 'FlaggedRevs::addToEditView';
# Add review form and visiblity settings link
$wgHooks['BeforePageDisplay'][] = 'FlaggedRevs::onBeforePageDisplay';
# Mark items in page history
$wgHooks['PageHistoryPager::getQueryInfo'][] = 'FlaggedRevs::addToHistQuery';
$wgHooks['PageHistoryLineEnding'][] = 'FlaggedRevs::addToHistLine';
$wgHooks['LocalFile::getHistory'][] = 'FlaggedRevs::addToFileHistQuery';
$wgHooks['ImagePageFileHistoryLine'][] = 'FlaggedRevs::addToFileHistLine';
# Mark items in user contribs
$wgHooks['ContribsPager::getQueryInfo'][] = 'FlaggedRevs::addToContribsQuery';
$wgHooks['ContributionsLineEnding'][] = 'FlaggedRevs::addToContribsLine';
# Page review on edit
$wgHooks['ArticleUpdateBeforeRedirect'][] = 'FlaggedRevs::injectReviewDiffURLParams';
$wgHooks['DiffViewHeader'][] = 'FlaggedRevs::onDiffViewHeader';
# Autoreview stuff
$wgHooks['EditPage::showEditForm:fields'][] = 'FlaggedRevs::addRevisionIDField';

# Add CSS/JS as needed
$wgHooks['OutputPageParserOutput'][] = 'FlaggedRevs::injectStyleAndJS';
$wgHooks['EditPage::showEditForm:initial'][] = 'FlaggedRevs::injectStyleAndJS';
$wgHooks['PageHistoryBeforeList'][] = 'FlaggedRevs::injectStyleAndJS';
$wgHooks['BeforePageDisplay'][] = 'FlaggedRevs::InjectStyleForSpecial';

# File cache
$wgHooks['IsFileCacheable'][] = 'FlaggedRevs::isFileCacheable';

# Duplicate flagged* tables in parserTests.php
$wgHooks['ParserTestTables'][] = 'FlaggedRevs::onParserTestTables';

#########

function efLoadFlaggedRevs() {
	global $wgUseRCPatrol;
	// wfLoadExtensionMessages( 'FlaggedRevs' );
	# Use RC Patrolling to check for vandalism
	# When revisions are flagged, they count as patrolled
	$wgUseRCPatrol = true;
}

# Add review log
$wgLogTypes[] = 'review';
$wgLogNames['review'] = 'review-logpage';
$wgLogHeaders['review'] = 'review-logpagetext';
# Various actions are used for log filtering ...
$wgLogActions['review/approve']  = 'review-logentry-app'; // sighted (again)
$wgLogActions['review/approve2']  = 'review-logentry-app'; // quality (again)
$wgLogActions['review/approve-i']  = 'review-logentry-app'; // sighted (first time)
$wgLogActions['review/approve2-i']  = 'review-logentry-app'; // quality (first time)
$wgLogActions['review/approve-a']  = 'review-logentry-app'; // sighted (auto)
$wgLogActions['review/approve-ia']  = 'review-logentry-app'; // sighted (initial & auto)
$wgLogActions['review/unapprove'] = 'review-logentry-dis'; // was sighted
$wgLogActions['review/unapprove2'] = 'review-logentry-dis'; // was quality

# Add stable version log
$wgLogTypes[] = 'stable';
$wgLogNames['stable'] = 'stable-logpage';
$wgLogHeaders['stable'] = 'stable-logpagetext';
$wgLogActions['stable/config'] = 'stable-logentry';
$wgLogActions['stable/reset'] = 'stable-logentry2';

# AJAX functions
$wgAjaxExportList[] = 'ReaderFeedback::AjaxReview';
$wgAjaxExportList[] = 'RevisionReview::AjaxReview';


# B/C ...
$wgLogActions['rights/erevoke']  = 'rights-editor-revoke';

# Schema changes
$wgHooks['LoadExtensionSchemaUpdates'][] = 'efFlaggedRevsSchemaUpdates';

function efFlaggedRevsSchemaUpdates() {
	global $wgDBtype, $wgExtNewFields, $wgExtPGNewFields, $wgExtNewIndexes, $wgExtNewTables;
	$base = dirname(__FILE__);
	if( $wgDBtype == 'mysql' ) {
		$wgExtNewFields[] = array( 'flaggedpage_config', 'fpc_expiry', "$base/archives/patch-fpc_expiry.sql" );
		$wgExtNewIndexes[] = array('flaggedpage_config', 'fpc_expiry', "$base/archives/patch-expiry-index.sql" );
		$wgExtNewTables[] = array( 'flaggedrevs_promote', "$base/archives/patch-flaggedrevs_promote.sql" );
		$wgExtNewTables[] = array( 'flaggedpages', "$base/archives/patch-flaggedpages.sql" );
		$wgExtNewFields[] = array( 'flaggedrevs', 'fr_img_name', "$base/archives/patch-fr_img_name.sql" );
		$wgExtNewTables[] = array( 'reader_feedback', "$base/archives/patch-reader_feedback.sql" );
	} else if( $wgDBtype == 'postgres' ) {
		$wgExtPGNewFields[] = array('flaggedpage_config', 'fpc_expiry', "TIMESTAMPTZ NULL" );
		$wgExtNewIndexes[] = array('flaggedpage_config', 'fpc_expiry', "$base/postgres/patch-expiry-index.sql" );
		$wgExtNewTables[] = array( 'flaggedrevs_promote', "$base/postgres/patch-flaggedrevs_promote.sql" );
		$wgExtNewTables[] = array( 'flaggedpages', "$base/postgres/patch-flaggedpages.sql" );
		$wgExtNewIndexes[] = array('flaggedrevs', 'key_timestamp', "$base/postgres/patch-fr_img_name.sql" );
		$wgExtNewTables[] = array( 'reader_feedback', "$base/postgres/patch-reader_feedback.sql" );
	}
	return true;
}
