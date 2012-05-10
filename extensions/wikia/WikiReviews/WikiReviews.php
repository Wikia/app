<?php

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/WikiReviews/WikiReviews.php" );
EOT;
        exit( 1 );
}

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['WikiReviewsController'] = $dir . 'WikiReviewsController.php';

$wgExtensionMessagesFiles['WikiReviews'] = $dir . 'WikiReviews.i18n.php';

$wgHooks['BeforePageDisplay'][] = 'wfWikiReviewsAddStyle';
$wgHooks['BodyIndexAfterExecute'][] = 'wfWikiReviewsReplaceBodyTemplate';
$wgHooks['GetRailModuleList'][] = 'wfWikiReviewsAddModule';
$wgHooks['HistoryDropdownIndexBeforeExecute'][] = 'wfWikiReviewsHideHistoryDropdown';
$wgHooks['PageHeaderIndexAfterExecute'][] = 'wfWikiReviewsRemoveEditButton';

function wfWikiReviewsTitleCheck() {
	global $wgTitle, $wgRequest;
	$action = $wgRequest->getVal( 'action', 'view' );
	return ( $action == 'view' )
		&& ( $wgTitle->getNamespace() == NS_MAIN )
		&& !$wgTitle->equals( Title::newMainPage() );
}

// add CSS
function wfWikiReviewsAddStyle( &$out, &$sk ) {
	if( wfWikiReviewsTitleCheck() ) {
		$out->addStyle( AssetsManager::getInstance()->getSassCommonURL('/extensions/wikia/WikiReviews/WikiReviews.scss'));
	}
	return true;
}

// add rail module
function wfWikiReviewsAddModule( &$railModuleList ) {
	global $wgEnableAdSS, $wgTitle;
	if( !empty( $wgEnableAdSS ) && AdSS_Publisher::canShowAds( $wgTitle ) ) {
		$railModuleList[1449] = array( 'WikiReviews', 'SponsoredLinks', null );
	}
	return true;
}

// display comments before categories
function wfWikiReviewsReplaceBodyTemplate( &$moduleObject, &$params ) {
	if( wfWikiReviewsTitleCheck() ) {
		global $wgEnableAdSS, $wgTitle;
		$moduleObject->getResponse()->getView()->setTemplatePath( dirname(__FILE__).'/templates/WikiReviewsBody_Index.php' );
		$moduleObject->displaySponsoredLinks = !empty( $wgEnableAdSS ) && AdSS_Publisher::canShowAds( $wgTitle );
	}
	return true;
}

// hide history dropdown
function wfWikiReviewsHideHistoryDropdown( &$moduleObject, &$params ) {
	if( wfWikiReviewsTitleCheck() ) {
		$moduleObject->getResponse()->getView()->setTemplatePath( dirname(__FILE__).'/templates/Empty.php' );
		return false;
	} else {
		return true;
	}
}

// remove edit button
function wfWikiReviewsRemoveEditButton( &$moduleObject, &$params ) {
	if( wfWikiReviewsTitleCheck() ) {
		wfLoadExtensionMessages('WikiReviews');
		if( isset( $moduleObject->content_actions['delete'] ) ) {
			$moduleObject->action = $moduleObject->content_actions['delete'];
			$moduleObject->action['text'] = wfMsgHtml('wiki-reviews-delete');
			$moduleObject->actionName = 'delete';
		} else {
			$moduleObject->action = null;
			$moduleObject->actionName = '';
		}
		$moduleObject->dropdown = array();
	}
	return true;
}
