<?php

/**
 * SponsorshipDashboard
 * @author Jakub "Szeryf" Kurcek
 *
 * Main switch for Sponsorship Dashboard
 */

class SponsorshipDashboard extends SpecialPage {

	const TEMPLATE_EMPTY_CHART = 'emptychart';
	const TEMPLATE_ERROR = 'error';
	const TEMPLATE_CHART = 'chart';
	const TEMPLATE_SAVE_SUCCESFUL = 'editor/saveSuccess';

	const ADMIN = 'admin';

	protected $adminTabs = array( 'ViewInfo', 'ViewReports', 'ViewGroups', 'ViewUsers' );

	protected $currentReport = '';
	protected $currentGroup = '';
	protected $currentReports = '';
	protected $currentGroups = '';

	protected $popularCityHubs = array();
	protected $chartCounter = 0;
	protected $hiddenSeries = array();
	protected $dataMonthly = false;
	protected $tagDependent = false;
	protected $currentCityHub = false;
	protected $allowed = false;
	protected $fromYear = 2004;

	function  __construct() {

		$oUser = F::app()->getGlobal('wgUser');
		$this->allowed = $oUser->isAllowed('wikimetrics');

		parent::__construct( 'SponsorshipDashboard', 'sponsorship-dashboard', $this->allowed);
	}

	public function isAllowed() {

		return $this->allowed;
	}

	function execute( $subpage = false ) {

		global $wgSupressPageSubtitle;

		$wgOut = F::app()->getGlobal('wgOut');

		$wgOut->setHTMLTitle( wfMsg( 'sponsorship-dashboard-default-page-title' ) );
		$subPageParams = explode( '/', $subpage );
		$wgSupressPageSubtitle = true;

		// admin panel

		if ( $this->isAllowed() && $subPageParams[0] == self::ADMIN ){

			if ( ( !isset( $subPageParams[1] ) || $subPageParams[1] == 'ViewInfo' ) ) {
				$this->HTMLViewInfo();
				return true;
			}

			if ( $subPageParams[1] == 'EditReport' ) {
				$this->HTMLEditReport(
					( isset( $subPageParams[2] ) ) ? $subPageParams[2] : 0
				);
				return true;
			}

			if ( $subPageParams[1] == 'EditGroup' ) {
				$this->HTMLEditGroup(
					( isset( $subPageParams[2] ) ) ? $subPageParams[2] : 0
				);
				return true;
			}

			if ( $subPageParams[1] == 'EditUser' ) {
				$this->HTMLEditUser(
					( isset( $subPageParams[2] ) ) ? $subPageParams[2] : 0
				);
				return true;
			}

			if ( $subPageParams[1] == 'ViewReports' ) {
				$this->HTMLViewReports();
				return true;
			}

			if ( $subPageParams[1] == 'ViewUsers' ) {
				$this->HTMLViewUsers();
				return true;
			}

			if ( $subPageParams[1] == 'ViewReport' ) {
				$this->HTMLViewReport(
					( isset( $subPageParams[2] ) ) ? $subPageParams[2] : 0
				);
				return true;
			}

			if ( $subPageParams[1] == 'CSVReport' ) {
				$this->HTMLCSVReport(
					( isset( $subPageParams[2] ) ) ? $subPageParams[2] : 0
				);
				return true;
			}

			if ( $subPageParams[1] == 'ViewGroups' ) {
				$this->HTMLViewGroups();
				return true;
			}

			$this->HTMLViewInfo();
			return true;
		}

		// user panel

		if ( $this->getTabs( $subpage ) ) {

			$outputType = ( isset( $subPageParams[2] ) ) ? $subPageParams[2] : 'html' ;
			switch ( $outputType ){
				case 'csv': $this->CSVReport(); break;
				default: $this->HTMLReport(); break;
			}
			return true;
		} else {
			$this->HTMLerror();
			return false;
		}
	}

	protected function getTabs( $tabName ) {

		if ( $this->isAllowed() ) {
			return $this->getTabsForStaff( $tabName );
		}

		$wgUser = F::app()->getGlobal( 'wgUser' );

		if ( $wgUser->isAnon() ) {
			return false;
		}

		$SDUser = SponsorshipDashboardUser::newFromUserId( $wgUser->getId() );
		if ( empty( $SDUser ) ) return false;

		$SDUser->loadUserParams();

		$SDGroups = (new SponsorshipDashboardGroups);
		$SDUserGroups = $SDGroups->getUserData( $SDUser->id );
		$this->currentGroups = $SDUserGroups;

		$exploded = explode( '/', $tabName );
		$catId = $exploded[0];

		if ( isset( $exploded[1] ) ) {
			$repId = $exploded[1];
		} else {
			$repId = 0;
		}

		if ( empty( $catId ) ) {
			$catKeys = array_keys( $this->currentGroups );
			if ( !isset( $catKeys[0] ) ) {
				return false;
			}
			$catId = $catKeys[0];
			$repId = 0;
		} else {
			if ( !in_array( $catId, array_keys( $this->currentGroups ) ) ) {
				return false;
			}
		}

		$currentGroup = $this->currentGroups[ $catId ];

		if ( empty( $repId ) ) {
			$aKeys = array_keys( $currentGroup->reports );
			if ( !isset( $aKeys[0] ) ) {
				return false;
			}
			$repId = $aKeys[0];
		}

		if( !isset( $currentGroup->reports[ $repId ] ) ) {
			return false;
		}

		$this->currentReports = $currentGroup->reports;
		$this->currentGroup = $catId;
		$this->currentReport = $currentGroup->reports[ $repId ];

		return true;
	}

	/*
	 * Provides all groups with reports.
	 *
	 * @param int $tabName group id.
	 *
	 * @return boolean. There is no such group / report returns false;
	 */

	function getTabsForStaff( $tabName ) {

		$SDGroups = (new SponsorshipDashboardGroups);
		$SDGData = $SDGroups->getObjArray( true );
		$this->currentGroups = $SDGData;

		$exploded = explode( '/', $tabName );
		$catId = $exploded[0];
		if ( isset( $exploded[1] ) ) {
			$repId = $exploded[1];
		} else {
			$repId = 0;
		}

		$SDR = new SponsorshipDashboardGroup( $catId );

		if ( !$SDR->exist() ) {
			$catId = 0;
		}

		if ( empty( $catId ) ) {
			$catKeys = array_keys( $SDGData );
			if ( !isset( $catKeys[0] ) ) {
				return false;
			}
			$catId = $catKeys[0];
		}

		$SDGroup = new SponsorshipDashboardGroup( $catId );
		$SDGroup->loadGroupParams();
		if( !isset( $SDGroup->reports[ $repId ] ) ) {
			$aKeys = array_keys( $SDGroup->reports );
			if ( !isset( $aKeys[0] ) ) {
				return false;
			}
			$repId = $aKeys[0];
		}

		$this->currentReports = $SDGroup->reports;
		$this->currentGroup = $catId;
		$this->currentReport = $SDGroup->reports[ $repId ];

		return true;
	}

	/*
	 * Displays user header
	 *
	 * @return void
	 */

	protected function displayHeader() {

		$wgOut = F::app()->getGlobal('wgOut');
		$wgTitle = F::app()->getGlobal('wgTitle');

		wfProfileIn( __METHOD__ );

		$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/SponsorshipDashboard/css/SponsorshipDashboard.scss'));

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars(
			array(
				"groupId"		=> $this->currentGroup,
				"groups"		=> $this->currentGroups,
				"path"			=> $wgTitle->getFullURL(),
				"reports"		=> $this->currentReports,
				"report"		=> $this->currentReport
			)
		);
		$wgOut->addHTML( $oTmpl->render( "header" ) );

		wfProfileOut( __METHOD__ );
	}

	/*
	 * Link where to go after saving report
	 *
	 * @return string link
	 */

	public function reportSaved() {

		return SpecialPage::getTitleFor('SponsorshipDashboard')->getInternalURL()."/".self::ADMIN."/ViewReports/";

	}

	/**
	 * HTMLerror - displays error subpage.
	 */

	public function HTMLerror() {

		$wgOut = F::app()->getGlobal('wgOut');

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$wgOut->addHTML( $oTmpl->render( self::TEMPLATE_ERROR ) );

		return false;
	}

	/*
	 * Displays admin header
	 *
	 * @return void
	 */

	protected function HTMLAdminHeader( $subpage ) {
		$wgOut = F::app()->getGlobal('wgOut');
		$wgTitle = F::app()->getGlobal('wgTitle');

		$subpage = ( !in_array( $subpage, $this->adminTabs ) ) ? $this->adminTabs[0] : $subpage;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars(
			array(
				"tab"		=> $subpage,
				"tabs"		=> $this->adminTabs,
				"path"		=> $wgTitle->getFullURL()
			)
		);

		$wgOut->addHTML(
			$oTmpl->render( 'admin/adminHeader' )
		);
	}

	protected function HTMLEditReport( $id ) {
		global $wgExtensionsPath, $wgResourceBasePath;

		$wgOut = F::app()->getGlobal('wgOut');
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

		$wgOut->addScript( "<script src=\"{$wgExtensionsPath}/wikia/SponsorshipDashboard/js/SponsorshipDashboardEditor.js\" ></script>\n" );
		$wgOut->addScript( "<script src=\"{$wgResourceBasePath}/resources/wikia/libraries/jquery/flot/jquery.flot.js\"></script>\n" );
		$wgOut->addScript( "<script src=\"{$wgResourceBasePath}/resources/wikia/libraries/jquery/flot/jquery.flot.selection.js\"></script>\n" );
		$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/SponsorshipDashboard/css/SponsorshipDashboardEditor.scss' ) );
		$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/SponsorshipDashboard/css/SponsorshipDashboard.scss' ) );
		$this->HTMLAdminHeader( 'ViewReports' );

		$report = new SponsorshipDashboardReport( $id );
		$report->loadReportParams();

		$menuItems = $report->getMenuItemsHTML();
		$reportParams = $report->getReportParams();

		$oTmpl->set_vars(
			array(
			    'menuItems' => $menuItems,
			    'reportParams' => $reportParams,
			    'reportEditorPath' => SpecialPage::getTitleFor('SponsorshipDashboard')->getInternalURL().'/'.self::ADMIN.'/ViewReports'
			)
		);

		$wgOut->addHTML(
			$oTmpl->render( 'admin/editReport' )
		);

		return false;
	}

	protected function HTMLCSVReport( $id ) {

		$id = (int)$id;

		if ( !empty( $id ) ){

			$this->currentReport = new SponsorshipDashboardReport( $id );
			$this->currentReport->setId( $id );
			$this->currentReport->loadReportParams();
			$this->currentReport->loadSources();
			$this->currentReport;
			$this->CSVReport();
		}
		$this->HTMLerror();
	}

	protected function HTMLViewReport( $id ) {
		$wgOut = F::app()->getGlobal('wgOut');

		$this->HTMLAdminHeader( 'ViewReports' );

		$report = new SponsorshipDashboardReport( $id );
		$report->setId( $id );
		$report->loadReportParams();
		$report->loadSources();

		$chart = SponsorshipDashboardOutputChart::newFromReport( $report );
		$table = SponsorshipDashboardOutputTable::newFromReport( $report );

		$wgOut->addHTML(
			$chart->getHTML()
		);

		$wgOut->addHTML(
			$table->getHTML()
		);
	}

	protected function HTMLViewInfo() {

		$wgOut = F::app()->getGlobal('wgOut');

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

		$this->HTMLAdminHeader( 'ViewInfo' );
		$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/SponsorshipDashboard/css/SponsorshipDashboard.scss' ) );
		$wgOut->addHTML(
			$oTmpl->render( 'admin/viewInfo' )
		);

		return true;
	}

	protected function HTMLEditGroup( $id ) {

		global $wgExtensionsPath, $wgJsMimeType;

		$wgOut = F::app()->getGlobal('wgOut');

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

		$this->HTMLAdminHeader( 'ViewGroups' );

		$group = new SponsorshipDashboardGroup( $id );
		$group->loadGroupParams();

		$aReports = new SponsorshipDashboardReports();
		$aUsers = new SponsorshipDashboardUsers();
		$oTmpl->set_vars(
			array(
			    'groupParams' => $group->getGroupParams(),
			    'reports' => $aReports->getData(),
			    'users' => $aUsers->getData(),
			    'path' => SpecialPage::getTitleFor('SponsorshipDashboard')->getInternalURL(),
			    'groupEditorPath' => SpecialPage::getTitleFor('SponsorshipDashboard')->getInternalURL().'/'.self::ADMIN.'/ViewGroups'
			)
		);

		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/SponsorshipDashboard/js/SponsorshipDashboardGroupEditor.js\" ></script>\n");
		$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/SponsorshipDashboard/css/SponsorshipDashboard.scss' ) );
		$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/SponsorshipDashboard/css/SponsorshipDashboardEditor.scss' ) );
		$wgOut->addHTML(
			$oTmpl->render( 'admin/editGroup' )
		);
	}

	protected function HTMLEditUser( $id ) {

		global $wgExtensionsPath, $wgJsMimeType;

		$wgOut = F::app()->getGlobal('wgOut');

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

		$this->HTMLAdminHeader( 'ViewUsers' );

		$oUser = new SponsorshipDashboardUser( $id );
		$oUser->loadUserParams();

		$aGroups = new SponsorshipDashboardGroups();
		$aGroupUserData = $aGroups->getUserData( $id );

		$aUserReports = array();
		foreach ( $aGroupUserData as $group ) {
			foreach ( $group->reports as $report  ) {
				$aUserReports[ $report->id ] = $report;
			}
		}

		$oTmpl->set_vars(
			array(
			    'userParams' => $oUser->getUserParams(),
			    'groups' => $aGroupUserData,
			    'reports' => $aUserReports,
			    'path' => SpecialPage::getTitleFor('SponsorshipDashboard')->getInternalURL(),
			    'userEditorPath' => SpecialPage::getTitleFor('SponsorshipDashboard')->getInternalURL().'/'.self::ADMIN.'/ViewUsers',
			    'allowedTypes' => $oUser->allowedTypes
			)
		);

		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/SponsorshipDashboard/js/SponsorshipDashboardUserEditor.js\" ></script>\n");
		$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/SponsorshipDashboard/css/SponsorshipDashboard.scss' ) );
		$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/SponsorshipDashboard/css/SponsorshipDashboardEditor.scss' ) );
		$wgOut->addHTML(
			$oTmpl->render( 'admin/editUser' )
		);
	}

	protected function HTMLViewReports() {

		global $wgTitle, $wgOut, $wgRequest, $wgExtensionsPath, $wgJsMimeType;

		$wgOut = F::app()->getGlobal('wgOut');
		$wgRequest = F::app()->getGlobal('wgRequest');
		$wgTitle = F::app()->getGlobal('wgTitle');

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/SponsorshipDashboard/js/SponsorshipDashboardList.js\" ></script>\n");
		$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/SponsorshipDashboard/css/SponsorshipDashboardList.scss' ) );
		$this->HTMLAdminHeader( 'ViewReports' );

		$aReports = (new SponsorshipDashboardReports);
		$oTmpl->set_vars(
			array(
				"data" => $aReports->getData(),
				"path" => $wgTitle->getFullURL()
			)
		);

		$wgOut->addHTML(
			$oTmpl->render( 'admin/viewReports' )
		);

		return false;
	}

	protected function HTMLViewGroups() {

		global $wgTitle, $wgOut, $wgRequest, $wgExtensionsPath, $wgJsMimeType;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

		if ( $wgRequest->getVal( 'action' ) == 'save' ) {
			$oGroup = (new SponsorshipDashboardGroup);
			$oGroup->fillFromRequest();
			$oGroup->save();
		}

		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/SponsorshipDashboard/js/SponsorshipDashboardList.js\" ></script>\n");
		$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/SponsorshipDashboard/css/SponsorshipDashboardList.scss' ) );
		$this->HTMLAdminHeader( 'ViewGroups' );

		$aGroups = (new SponsorshipDashboardGroups);
		$oTmpl->set_vars(
			array(
				"data" => $aGroups->getData(),
				"path" => $wgTitle->getFullURL()
			)
		);

		$wgOut->addHTML(
			$oTmpl->render( 'admin/viewGroups' )
		);

		return false;
	}

	protected function HTMLViewUsers() {

		global $wgTitle, $wgOut, $wgRequest, $wgExtensionsPath, $wgJsMimeType;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$sMsg = '';

		if ( $wgRequest->getVal( 'action' ) == 'save' ) {
			$oUser = new SponsorshipDashboardUser();
			$oUser->fillFromRequest();
			$bSuccess = $oUser->save();
			$sMsg = ( $bSuccess ) ? '' : wfMsg('sponsorship-dashboard-users-error', $oUser->name );
		}

		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/SponsorshipDashboard/js/SponsorshipDashboardList.js\" ></script>\n");
		$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL( '/extensions/wikia/SponsorshipDashboard/css/SponsorshipDashboardList.scss' ) );
		$this->HTMLAdminHeader( 'ViewUsers' );

		$aUsers = new SponsorshipDashboardUsers();
		$oTmpl->set_vars(
			array(
				"data" => $aUsers->getData(),
				"path" => $wgTitle->getFullURL(),
				"errorMsg" => $sMsg
			)
		);

		$wgOut->addHTML(
			$oTmpl->render( 'admin/viewUsers' )
		);

		return false;
	}

	protected function HTMLReport() {

		global $wgOut;

		$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/SponsorshipDashboard/css/SponsorshipDashboard.scss' ) );
		$this->displayHeader();

		$chart = SponsorshipDashboardOutputChart::newFromReport( $this->currentReport, $this->currentGroup );
		$table = SponsorshipDashboardOutputTable::newFromReport( $this->currentReport );

		$wgOut->addHTML(
			$chart->getHTML()
		);
		$wgOut->addHTML(
			$table->getHTML()
		);

		return false;
	}

	protected function CSVReport() {

		$this->currentReport->loadReportParams();
		$dataFormatter = SponsorshipDashboardOutputCSV::newFromReport( $this->currentReport );
		echo $dataFormatter->getHTML();
		exit;
	}
}
