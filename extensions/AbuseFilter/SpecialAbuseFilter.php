<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

class SpecialAbuseFilter extends SpecialPage {

	var $mSkin;

	function __construct() {
		wfLoadExtensionMessages('AbuseFilter');
		parent::__construct( 'AbuseFilter', 'abusefilter-view' );
	}
	
	function execute( $subpage ) {
		global $wgUser, $wgOut, $wgRequest, $wgAbuseFilterStyleVersion, $wgScriptPath;

		$wgOut->addExtensionStyle( "{$wgScriptPath}/extensions/AbuseFilter/abusefilter.css?" . 
			$wgAbuseFilterStyleVersion );
		$view = 'AbuseFilterViewList';

		$this->setHeaders();

		$this->loadParameters( $subpage );
		$wgOut->setPageTitle( wfMsg( 'abusefilter-management' ) );

		// Are we allowed?
		if ( !$wgUser->isAllowed( 'abusefilter-view' ) ) {
			$this->displayRestrictionError();
			return;
		}

		if ( $wgRequest->getVal( 'result' ) == 'success' ) {
			$wgOut->setSubtitle( wfMsg( 'abusefilter-edit-done-subtitle' ) );
			$wgOut->wrapWikiMsg( '<p class="success">$1</p>', 
				array('abusefilter-edit-done', $wgRequest->getVal( 'changedfilter' ) ) );
		}
		
		$this->mSkin = $wgUser->getSkin();
		$this->mHistoryID = null;
		$pageType = 'home';
		
		$params = explode( '/', $subpage );
		
		// Filter by removing blanks.
		foreach( $params as $index => $param ) {
			if ($param === '') {
				unset( $params[$index] );
			}
		}
		$params = array_values( $params );
		
		if ($subpage == 'tools') {
			$view = 'AbuseFilterViewTools';
			$pageType = 'tools';
		}

		if ( count($params) == 2 && $params[0] == 'revert' && is_numeric( $params[1] ) ) {
			$this->mFilter = $params[1];
			$view = 'AbuseFilterViewRevert';
			$pageType = 'revert';
		}

		if ( count($params) && $params[0] == 'test' ) {
			$view = 'AbuseFilterViewTestBatch';
			$pageType = 'test';
		}

		if ( count($params) && $params[0] == 'examine' ) {
			$view = 'AbuseFilterViewExamine';
			$pageType = 'examine';
		}
		
		if (!empty($params[0]) && ($params[0] == 'history' || $params[0] == 'log') ) {
			$pageType = '';
			if (count($params) == 1) {
				$view = 'AbuseFilterViewHistory';
				$pageType = 'recentchanges';
			} elseif (count($params) == 2) {
				## Second param is a filter ID
				$view = 'AbuseFilterViewHistory';
				$this->mFilter = $params[1];
			} elseif (count($params) == 4 && $params[2] == 'item') {
				$this->mFilter = $params[1];
				$this->mHistoryID = $params[3];
				$view = 'AbuseFilterViewEdit';
			} elseif (count($params) == 5 && $params[2] == 'diff') {
				// Special:AbuseFilter/history/<filter>/diff/<oldid>/<newid>
				$view = 'AbuseFilterViewDiff';
			}
		}
		
		if ( is_numeric($subpage) || $subpage == 'new' ) {
			$this->mFilter = $subpage;
			$view = 'AbuseFilterViewEdit';
			$pageType = 'edit';
		}
		
		if ( $subpage == 'import' ) {
			$view = 'AbuseFilterViewImport';
			$pageType = 'import';
		}
		
		// Links at the top
		AbuseFilter::addNavigationLinks( $wgOut, $this->mSkin, $pageType );

		$v = new $view( $this, $params );
		$v->show( );
	}
	
	function loadParameters( $subpage ) {
		global $wgRequest;
		
		$filter = $subpage;
		
		if (!is_numeric($filter) && $filter != 'new') {
			$filter = $wgRequest->getIntOrNull( 'wpFilter' );
		}
		$this->mFilter = $filter;
	}
}
