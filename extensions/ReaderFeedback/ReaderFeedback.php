<?php
/*
 (c) Aaron Schulz 2007-2009 GPL
 
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
 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 http://www.gnu.org/copyleft/gpl.html
*/

if( !defined('MEDIAWIKI') ) {
	echo "ReaderFeedback extension\n";
	exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'Reader Feedback',
	'author'         => array( 'Aaron Schulz' ),
	'url'            => 'https://www.mediawiki.org/wiki/Extension:ReaderFeedback',
	'descriptionmsg' => 'readerfeedback-desc',
);

#########
# IMPORTANT:
# When configuring globals, add them to localsettings.php and edit them THERE

# Users that can use the feedback form.
$wgGroupPermissions['*']['feedback'] = true;

# Allow readers to rate pages in these namespaces
$wgFeedbackNamespaces = array();

# Reader feedback tags, positive and negative. [a-zA-Z] tag names only.
# Each tag has five levels, which 3 being average. The tag names are
# mapped to their weight. This is used to determine the "worst"/"best" pages.
$wgFeedbackTags = array(
	'reliability'  => 3,
	'completeness' => 2,
	'npov'         => 2,
	'presentation' => 1
);
# How many seconds back should the average rating for a page be based on?
$wgFeedbackAge = 7 * 24 * 3600;
# What number of page votes (for the average above) is considered significant?
# (number of recent reviews to be a decent sample size)
$wgFeedbackSizeThreshhold = 15;
# How long before stats page is updated?
$wgFeedbackStatsAge = 2 * 3600; // 2 hours
# Limit people from spamming the system
# (uses count => seconds tuples)
$wgRateLimits['feedback'] = array(
	'newbie' => array( 5, 60 ), // for each recent (autoconfirmed) account; overrides 'user'
	'user'   => null, // for each logged-in user
	'ip'     => array( 5, 60 ), // for each anon and recent account
	'subnet' => null, // ... with final octet removed
);

# URL location for readerfeedback.css and readerfeedback.js
# Use a literal $wgScriptPath as a placeholder for the runtime value of $wgScriptPath
$wgFeedbackStylePath = '$wgScriptPath/extensions/ReaderFeedback';

# End of configuration variables.
#########

# Bump this number every time you change readerfeedback.css/readerfeedback.js
$wgFeedbackStyleVersion = 1;

$dir = dirname(__FILE__) . '/';
$langDir = $dir . 'language/';

$wgSvgGraphDir = $dir . 'svggraph';
$wgPHPlotDir = $dir . 'phplot-5.0.5';

$wgAutoloadClasses['ReaderFeedback'] = $dir.'ReaderFeedback.class.php';
$wgAutoloadClasses['ReaderFeedbackHooks'] = $dir.'ReaderFeedback.hooks.php';
$wgExtensionMessagesFiles['ReaderFeedbackAlias'] = $langDir . 'ReaderFeedback.alias.php';

# Load reader feedback UI
$wgExtensionMessagesFiles['ReaderFeedback'] = $langDir . 'ReaderFeedback.i18n.php';
$wgAutoloadClasses['ReaderFeedbackPage'] = $dir . 'specialpages/ReaderFeedback_body.php';
$wgAutoloadClasses['ReaderFeedbackXML'] = $dir.'ReaderFeedbackXML.php';

# Page rating history
$wgAutoloadClasses['RatingHistory'] = $dir . 'specialpages/RatingHistory_body.php';
$wgExtensionMessagesFiles['RatingHistory'] = $langDir . 'RatingHistory.i18n.php';

# Page list by ratings
$wgAutoloadClasses['RatedPages'] = $dir . 'specialpages/RatedPages_body.php';
$wgExtensionMessagesFiles['RatedPages'] = $langDir . 'RatedPages.i18n.php';
$wgSpecialPageGroups['RatedPages'] = 'feedback';

######### Hook attachments #########

# Add review form and visiblity settings link
$wgHooks['SkinAfterContent'][] = 'ReaderFeedbackHooks::addFeedbackForm';

# Rating link
$wgHooks['SkinTemplateBuildNavUrlsNav_urlsAfterPermalink'][] = 'ReaderFeedbackHooks::addRatingLink';
$wgHooks['SkinTemplateToolboxEnd'][] = 'ReaderFeedbackHooks::ratingToolboxLink';

# Add CSS/JS as needed
$wgHooks['BeforePageDisplay'][] = 'ReaderFeedbackHooks::injectStyleAndJS';
$wgHooks['MakeGlobalVariablesScript'][] = 'ReaderFeedbackHooks::injectJSVars';

# Duplicate flagged* tables in parserTests.php
$wgHooks['ParserTestTables'][] = 'ReaderFeedbackHooks::onParserTestTables';

# Actually register special pages
$wgHooks['SpecialPage_initList'][] = 'efLoadReaderFeedbackSpecialPages';

#########

/* 
 * Register ReaderFeedback special pages as needed. 
 * Also sets $wgSpecialPages just to be consistent.
 */
function efLoadReaderFeedbackSpecialPages( &$list ) {
	global $wgSpecialPages, $wgFeedbackNamespaces;
	if( !empty($wgFeedbackNamespaces) ) {
		$list['ReaderFeedback'] = $wgSpecialPages['ReaderFeedback'] = 'ReaderFeedbackPage';
		$list['RatingHistory'] = $wgSpecialPages['RatingHistory'] = 'RatingHistory';
		$list['RatedPages'] = $wgSpecialPages['RatedPages'] = 'RatedPages';
	}
	return true;
}

# AJAX functions
$wgAjaxExportList[] = 'ReaderFeedbackPage::AjaxReview';

# Schema changes
$wgHooks['LoadExtensionSchemaUpdates'][] = 'efReaderFeedbackSchemaUpdates';

function efReaderFeedbackSchemaUpdates( $updater = null ) {
	$base = dirname( __FILE__ );
	if ( $updater === null ) {
		global $wgDBtype, $wgExtNewTables;
		if( $wgDBtype == 'mysql' ) {
			$wgExtNewTables[] = array( 'reader_feedback', "$base/ReaderFeedback.sql" ); // Initial install tables
		} elseif( $wgDBtype == 'postgres' ) {
			$wgExtNewTables[] = array( 'reader_feedback', "$base/ReaderFeedback.pg.sql" ); // Initial install tables
		}
	} else {
		if( $updater->getDB()->getType() == 'mysql' ) {
			$updater->addExtensionUpdate( array( 'addTable', 'reader_feedback',
				"$base/ReaderFeedback.sql", true ) ); // Initial install tables
		} elseif( $updater->getDB()->getType() == 'postgres' ) {
			$updater->addExtensionUpdate( array( 'addTable', 'reader_feedback',
				"$base/ReaderFeedback.pg.sql", true ) ); // Initial install tables
		}
	}
	return true;
}
