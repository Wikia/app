<?php

if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * @file
 * @ingroup Extensions
 *
 * @author Yaron Koren
 */

define( 'APPROVED_REVS_VERSION', '0.6.1' );

// credits
$wgExtensionCredits['other'][] = array(
	'path'            => __FILE__,
	'name'            => 'Approved Revs',
	'version'         => APPROVED_REVS_VERSION,
	'author'          => 'Yaron Koren',
	'url'             => 'https://www.mediawiki.org/wiki/Extension:Approved_Revs',
	'descriptionmsg'  => 'approvedrevs-desc'
);

// global variables
$egApprovedRevsIP = dirname( __FILE__ ) . '/';
$egApprovedRevsScriptPath = $wgScriptPath . '/extensions/ApprovedRevs';
$egApprovedRevsNamespaces = array( NS_MAIN, NS_USER, NS_PROJECT, NS_TEMPLATE, NS_HELP );
$egApprovedRevsSelfOwnedNamespaces = array();
$egApprovedRevsBlankIfUnapproved = false;
$egApprovedRevsAutomaticApprovals = true;
$egApprovedRevsShowApproveLatest = false;

// internationalization
$wgExtensionMessagesFiles['ApprovedRevs'] = $egApprovedRevsIP . 'ApprovedRevs.i18n.php';
$wgExtensionMessagesFiles['ApprovedRevsAlias'] = $egApprovedRevsIP . 'ApprovedRevs.alias.php';
$wgExtensionMessagesFiles['ApprovedRevsMagic'] = $egApprovedRevsIP . 'ApprovedRevs.i18n.magic.php';

// register all classes
$wgAutoloadClasses['ApprovedRevs'] = $egApprovedRevsIP . 'ApprovedRevs_body.php';
$wgAutoloadClasses['ApprovedRevsHooks'] = $egApprovedRevsIP . 'ApprovedRevs.hooks.php';
$wgSpecialPages['ApprovedRevs'] = 'SpecialApprovedRevs';
$wgAutoloadClasses['SpecialApprovedRevs'] = $egApprovedRevsIP . 'SpecialApprovedRevs.php';
$wgSpecialPageGroups['ApprovedRevs'] = 'pages';

// hooks
$wgHooks['ParserBeforeInternalParse'][] = 'ApprovedRevsHooks::setApprovedRevForParsing';
$wgHooks['ArticleSaveComplete'][] = 'ApprovedRevsHooks::setLatestAsApproved';
$wgHooks['PersonalUrls'][] = 'ApprovedRevsHooks::removeRobotsTag';
$wgHooks['ArticleFromTitle'][] = 'ApprovedRevsHooks::showApprovedRevision';
$wgHooks['ArticleAfterFetchContent'][] = 'ApprovedRevsHooks::showBlankIfUnapproved';
$wgHooks['DisplayOldSubtitle'][] = 'ApprovedRevsHooks::setSubtitle';
// it's 'SkinTemplateNavigation' for the Vector skin, 'SkinTemplateTabs' for
// most other skins
$wgHooks['SkinTemplateTabs'][] = 'ApprovedRevsHooks::changeEditLink';
$wgHooks['SkinTemplateNavigation'][] = 'ApprovedRevsHooks::changeEditLinkVector';
$wgHooks['PageHistoryBeforeList'][] = 'ApprovedRevsHooks::storeApprovedRevisionForHistoryPage';
$wgHooks['PageHistoryLineEnding'][] = 'ApprovedRevsHooks::addApprovalLink';
$wgHooks['UnknownAction'][] = 'ApprovedRevsHooks::setAsApproved';
$wgHooks['UnknownAction'][] = 'ApprovedRevsHooks::unsetAsApproved';
$wgHooks['BeforeParserFetchTemplateAndtitle'][] = 'ApprovedRevsHooks::setTranscludedPageRev';
$wgHooks['ArticleDeleteComplete'][] = 'ApprovedRevsHooks::deleteRevisionApproval';
$wgHooks['MagicWordwgVariableIDs'][] = 'ApprovedRevsHooks::addMagicWordVariableIDs';
$wgHooks['ParserBeforeTidy'][] = 'ApprovedRevsHooks::handleMagicWords';
$wgHooks['AdminLinks'][] = 'ApprovedRevsHooks::addToAdminLinks';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'ApprovedRevsHooks::describeDBSchema';
$wgHooks['EditPage::showEditForm:initial'][] = 'ApprovedRevsHooks::addWarningToEditPage';
$wgHooks['sfHTMLBeforeForm'][] = 'ApprovedRevsHooks::addWarningToSFForm';
$wgHooks['ArticleViewHeader'][] = 'ApprovedRevsHooks::setArticleHeader';
//$wgHooks['SearchUpdate'] = 'ApprovedRevsHooks::setSearchText';

// logging
$wgLogTypes['approval'] = 'approval';
$wgLogNames['approval'] = 'approvedrevs-logname';
$wgLogHeaders['approval'] = 'approvedrevs-logdesc';
$wgLogActions['approval/approve'] = 'approvedrevs-approveaction';
$wgLogActions['approval/unapprove'] = 'approvedrevs-unapproveaction';

// user rights
$wgAvailableRights[] = 'approverevisions';
$wgGroupPermissions['sysop']['approverevisions'] = true;
$wgAvailableRights[] = 'viewlinktolatest';
$wgGroupPermissions['*']['viewlinktolatest'] = true;

// page properties
$wgPageProps['approvedrevs'] = 'Whether or not the page is approvable';
