<?php
if ( !defined( 'MEDIAWIKI' ) ) { die( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" ); }
/**
 * An extension that adds features (such as a preference, recent changes, ...)
 * for a test wiki system (i.e. incubated wikis inside one actual wiki)
 * mainly intended for the Wikimedia Incubator
 *
 * MediaWiki 1.18 or higher required
 *
 * @file
 * @ingroup Extensions
 * @author Robin Pepermans (SPQRobin)
 */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Wikimedia Incubator',
	'author' => 'SPQRobin',
	'version' => '4.6',
	'url' => '//www.mediawiki.org/wiki/Extension:WikimediaIncubator',
	'descriptionmsg' => 'wminc-desc',
);

/* General (globals and/or configuration) */
$wmincPref = 'incubatortestwiki'; // Name of the preference
$dir = dirname( __FILE__ ) . '/';
$wmincScriptDir = $wgExtensionAssetsPath . '/WikimediaIncubator/';
# only one-letter codes can be used for projects
$wmincProjects = array(
	'p' => 'Wikipedia',
	'b' => 'Wikibooks',
	't' => 'Wiktionary',
	'q' => 'Wikiquote',
	'n' => 'Wikinews',
);
# Sister projects is here defined as projects that are not on Incubator
$wmincSisterProjects = array(
	's' => 'Wikisource',
	'v' => 'Wikiversity',
);
$wmincMultilingualProjects = array(
	'meta.wikimedia.org' => 'Meta-Wiki',
	'commons.wikimedia.org' => 'Wikimedia Commons',
	'species.wikimedia.org' => 'Wikispecies',
	'mediawiki.org' => 'MediaWiki',
);
$wmincProjectSite = array(
	'name' => 'Incubator',
	'short' => 'inc',
);
$wmincTestWikiNamespaces = array(
	NS_MAIN, NS_TALK,
	NS_TEMPLATE, NS_TEMPLATE_TALK,
	NS_CATEGORY, NS_CATEGORY_TALK,
);
$wmincLangCodeLength = 12; // can be changed if needed (depends on policy)
// Pseudo category namespaces like "Category:Maintenance:Delete", for easy whitelisting and structure
$wmincPseudoCategoryNSes = array(
	'Incubator', 'Help', 'Users', 'Maintenance', 'Files',
);

/* Test wiki admin user group */
$wgGroupPermissions['test-sysop']['delete'] = true;
$wgGroupPermissions['test-sysop']['undelete'] = true;
$wgGroupPermissions['test-sysop']['deletedhistory'] = true;
$wgGroupPermissions['test-sysop']['block'] = true;
$wgGroupPermissions['test-sysop']['blockemail'] = true;
$wgGroupPermissions['test-sysop']['rollback'] = true;
$wgGroupPermissions['test-sysop']['suppressredirect'] = true;
$wgAddGroups['bureaucrat'][] = 'test-sysop';
$wgRemoveGroups['bureaucrat'][] = 'test-sysop';

$wgExtensionMessagesFiles['WikimediaIncubator'] = $dir . 'WikimediaIncubator.i18n.php';
$wgExtensionMessagesFiles['WikimediaIncubatorAlias'] = $dir . 'WikimediaIncubator.alias.php';
$wgExtensionMessagesFiles['WikimediaIncubatorMagic'] = $dir . 'WikimediaIncubator.i18n.magic.php';

/* Special:ViewUserLang */
$wgAutoloadClasses['SpecialViewUserLang'] = $dir . 'SpecialViewUserLang.php';
$wgSpecialPages['ViewUserLang'] = 'SpecialViewUserLang';
$wgSpecialPageGroups['ViewUserLang'] = 'users';
$wgAvailableRights[] = 'viewuserlang';
$wgHooks['ContributionsToolLinks'][] = 'IncubatorTest::efLoadViewUserLangLink';
$wgGroupPermissions['*']['viewuserlang'] = false;
$wgGroupPermissions['sysop']['viewuserlang'] = true;

/* TestWiki preference */
$wgAutoloadClasses['IncubatorTest'] = $dir . 'IncubatorTest.php';
$wgHooks['GetPreferences'][] = 'IncubatorTest::onGetPreferences';
$wgHooks['MagicWordwgVariableIDs'][] = 'IncubatorTest::magicWordVariable';
$wgHooks['ParserGetVariableValueSwitch'][] = 'IncubatorTest::magicWordValue';

/* Special:MyMainPage (depending on your test wiki preference) */
$wgAutoloadClasses['SpecialMyMainPage'] = $dir . 'SpecialMyMainPage.php';
$wgSpecialPages['MyMainPage'] = 'SpecialMyMainPage';

/* Create/move page permissions */
$wgHooks['getUserPermissionsErrors'][] = 'IncubatorTest::onGetUserPermissionsErrors';
$wgHooks['AbortMove'][] = 'IncubatorTest::checkPrefixMovePermissions';

/* Recent Changes */
$wgAutoloadClasses['TestWikiRC'] = $dir . 'TestWikiRC.php';
$wgHooks['SpecialRecentChangesQuery'][] = 'TestWikiRC::onRcQuery';
$wgHooks['SpecialRecentChangesPanel'][] = 'TestWikiRC::onRcForm';

/* Automatic pref on account creation */
$wgAutoloadClasses['AutoTestWiki'] = $dir . 'CreateAccountTestWiki.php';
$wgHooks['UserCreateForm'][] = 'AutoTestWiki::onUserCreateForm';
$wgHooks['AddNewAccount'][] = 'AutoTestWiki::onAddNewAccount';

/* Random page by test */
$wgAutoloadClasses['SpecialRandomByTest'] = $dir . 'SpecialRandomByTest.php';
$wgSpecialPages['RandomByTest'] = 'SpecialRandomByTest';

/* support for automatic checking in a list of databases if a wiki exists */
$wmincExistingWikis = $wgLocalDatabases;
/* Stupid "wiki" referring to "wikipedia" in WMF config */
$wmincProjectDatabases = array( 
	'p' => 'wiki',
	'b' => 'wikibooks',
	't' => 'wiktionary',
	'q' => 'wikiquote',
	'n' => 'wikinews',
	's' => 'wikisource',
	'v' => 'wikiversity',
);
# set this to an array or file of closed wikis (like SiteMatrix $wgSiteMatrixClosedSites)
$wmincClosedWikis = false;

/* Wx/xx[x] info page */
$wgAutoloadClasses['InfoPage'] = $dir . 'InfoPage.php';
$wgExtensionMessagesFiles['InfoPage'] = $dir . 'InfoPage.i18n.php';
$wgHooks['ShowMissingArticle'][] = 'IncubatorTest::onShowMissingArticle';
$wgHooks['EditFormPreloadText'][] = 'IncubatorTest::onEditFormPreloadText';
$wgHooks['ArticleFromTitle'][] = 'IncubatorTest::onArticleFromTitle';

$wgResourceModules['WikimediaIncubator.InfoPage'] = array(
		'styles' => 'InfoPage.css',
		'localBasePath' => dirname(__FILE__),
		'remoteExtPath' => 'WikimediaIncubator',
);

/* Possibility to set a logo per test wiki */
$wgHooks['BeforePageDisplay'][] = 'IncubatorTest::fnTestWikiLogo';

/* Set page content language depending on the prefix */
$wgHooks['PageContentLanguage'][] = 'IncubatorTest::onPageContentLanguage';

/* List of users */
$wgAutoloadClasses['ListUsersTestWiki'] = $dir . 'ListUsersTestWiki.php';
$wgHooks['SpecialListusersHeaderForm'][] = 'ListUsersTestWiki::onSpecialListusersHeaderForm';
$wgHooks['SpecialListusersQueryInfo'][] = 'ListUsersTestWiki::onSpecialListusersQueryInfo';
$wgHooks['SpecialListusersHeader'][] = 'ListUsersTestWiki::onSpecialListusersHeader';

/* Search in test wiki */
$wgHooks['SpecialSearchCreateLink'][] = 'IncubatorTest::onSpecialSearchCreateLink';
$wgHooks['SpecialSearchPowerBox'][] = 'IncubatorTest::onSpecialSearchPowerBox';
$wgHooks['SpecialSearchSetupEngine'][] = 'IncubatorTest::onSpecialSearchSetupEngine';
