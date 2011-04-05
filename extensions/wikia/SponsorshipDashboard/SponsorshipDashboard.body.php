<?php
/**
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Jakub Kurcek
 *
 */

class SponsorshipDashboard extends SpecialPage {
	
	const TEMPLATE_EMPTY_CHART = 'emptychart';
	const TEMPLATE_ERROR = 'error';
	const TEMPLATE_CHART = 'chart';

	// important: array key and any array item value cannot be the same
	protected $reports = array(
		'marketresearch' => array (
			'competitors',
			'interests',
			'keywords',
			'source'
		),
		'userengagement' => array (
			'activity',
			'engagement',
			'participation',
		),
	    	'growthmetrics' => array (
			'visitors',
			'traffic',
			'content',
		)
	);

	protected $tagDependentReports = array(
	    'competitors',
	    'interests'
	);

	protected $monthlyReports = array(
	    'activity',
	    'engagements',
	    'participation',
	    'visitors'
	);


	protected $currentReport = '';
	protected $popularCityHubs = array();
	protected $chartCounter = 0;
	protected $hiddenSeries = array();
	protected $dataMonthly = false;
	protected $tagDependent = false;
	protected $currentCityHub = false;
	protected $allowed = false;
	protected $fromYear = 0;

	function  __construct() {

		global $wgSponsorshipDashboardAllowAdmins;
		$wgUser = WF::build('App')->getGlobal('wgUser');
				
		$this->allowed = ( in_array('wikimetrics', $wgUser->getRights()) );

		parent::__construct( 'SponsorshipDashboard', 'sponsorship-dashboard', $this->allowed);
		wfLoadExtensionMessages("SponsorshipDashboard");
	}

	public function isAllowed(){

		return $this->allowed;
	}

	protected function isReportPage( $reportName ){

		foreach ( $this->reports as $reports ){
			if ( in_array( $reportName, $reports ) ){
				return true;
			}
		}

		return false;
	}

	protected function getReportsTab( $reportName ){

		$firstTab = false;
		
		foreach ( $this->reports as $tab => $reports ){
			if ( in_array( $reportName, $reports ) ){
				return $tab;
			} elseif ( empty( $firstTab ) ){
				$firstTab = $tab;
			}
		}

		return $firstTab;
	}

	protected function getTabsReport( $tabName ){

		// 2DO: add checking user prefences;

		if ( !isset( $this->reports[ $tabName ] ) ){
			$tabName = key( $this->reports );
		}

		return $this->reports[ $tabName ][ key( $this->reports[ $tabName ] ) ];
	}

	function execute( $subpage = false ) {

		global $wgSupressPageSubtitle;

		if ( !empty( $subpage ) && $this->isReportPage( $subpage ) ){
			$report = $subpage;
		} else {
			$report = $this->getTabsReport( $subpage );
		}

		$wgSupressPageSubtitle = true;

		if ( $this->isAllowed() ){
			$this->currentReport = $report;
			$this->tagDependent = in_array( $report, $this->tagDependentReports );
			$this->dataMonthly = in_array( $report, $this->monthlyReports );
			$this->displayChart( $report );
		} else {
			$this->HTMLerror();
		}
	}

	/**
	 * HTMLmain - displays tag selector.
	 */

	protected function displayHeader(){

		global $wgOut, $wgTitle;

		wfProfileIn( __METHOD__ );

		$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/SponsorshipDashboard/css/SponsorshipDashboard.scss'));

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars(
			array(
				"tab"			=> $this->getReportsTab( $this->currentReport ),
				"tabs"			=> $this->reports,
				"path"			=> $wgTitle->getFullURL(),
				"report"		=> $this->currentReport
			)
		);
		$wgOut->addHTML( $oTmpl->execute( "header" ) );

		wfProfileOut( __METHOD__ );
	}

	protected function getCurrentCityHub(){
		
		global $wgRequest;

		if ( !empty( $this->currentCityHub ) ){
			return  $this->currentCityHub;
		}
		
		$aPopularHubs = $this->getPopularHubs();
		if ( empty( $aPopularHubs ) ){ 
			return false;
		}

		$value = ( int ) $wgRequest->getVal( 'cityHub', 0 );
		if ( empty( $value ) || !in_array( $value, $aPopularHubs ) ){
			reset( $aPopularHubs );
			$iKey = key( $aPopularHubs );
			$aCurrent = array('id' => $aPopularHubs[ $iKey ], 'name' =>  $iKey );
		} else {
			$aCurrent = array('id' => $value, 'name' => array_search( $value , $aPopularHubs ) );
		}

		return $aCurrent;
	}
	
	protected function getPopularHubs(){

		if ( empty( $this->popularCityHubs ) ){
			$sponsorshipDashboardService = new SponsorshipDashboardService;
			$aPopularHubs = $sponsorshipDashboardService->getPopularHubs();
			$this->popularCityHubs = $aPopularHubs;
		}
		return $this->popularCityHubs;
	}

	/**
	 * HTMLmain - main function for displaying chart.
	 */

	protected function getChartData( $title ){
		
		if ( !empty( $this->tagDependent ) ){
			$this->currentCityHub = $this->getCurrentCityHub();
		}

		$sponsorshipDashboardService = new SponsorshipDashboardService;
		$method = 'load'.ucfirst( $title ).'Data';

		$aData = array();

		if ( empty( $this->tagDependent ) ) {
			$aData = $sponsorshipDashboardService->$method();
		} elseif ( !empty( $this->currentCityHub ) ){
			$this->getPopularHubs();
			$aData = $sponsorshipDashboardService->$method( $this->currentCityHub );
		}


		$this->fromYear = $sponsorshipDashboardService->getFromYear();

		return $aData;

	}

	protected function displayChart( $title ){

		global $wgTitle, $wgOut, $wgJsMimeType, $wgStyleVersion, $wgHTTPProxy;

		wfProfileIn( __METHOD__ );

		$aData = $this->getChartData( $title );

		$this->displayHeader();

		$oTmpl = WF::build( 'EasyTemplate', array( ( dirname( __FILE__ )."/templates/" ) ) );

		if (	!isset ( $aData['ticks'] ) || !isset ( $aData['serie'] ) || !isset ( $aData['fullTicks'] ) ||
			empty ( $aData['ticks'] ) || empty ( $aData['serie'] ) || empty ( $aData['fullTicks'] ) )
		{
			$wgOut->addHTML( $oTmpl->execute( self::TEMPLATE_EMPTY_CHART ) );
		} else {

			$datasets = $aData['serie'];
			$ticks = $aData['ticks'];
			$fullTicks = $aData['fullTicks'];
			
			$oTmpl->set_vars(
				array(
					"title"			=> wfMsg( 'sponsorship-dashboard-report-'.$title ),
					"description"		=> wfMsg( 'sponsorship-dashboard-description-'.$title ),
					"datasets"		=> $datasets,
					"ticks"			=> $ticks,
					"fullTicks"		=> $fullTicks,
					"hiddenSeries"		=> ( !empty( $this->hiddenSeries ) ) ? "['".implode( "', '", $this->hiddenSeries )."']" : "[]",
					"number"		=> ++$this->chartCounter,
					"path"			=> $wgTitle->getFullURL().'/'.$this->currentReport,
					"current"		=> $this->currentCityHub,
					"selectorItems"		=> $this->popularCityHubs,
					"monthly"		=> $this->dataMonthly,
					"fromYear"		=> $this->fromYear
				)
			);

			$wgOut->addScript( "<!--[if IE]><script type=\"{$wgJsMimeType}\" src=\"/skins/common/jquery/excanvas.min.js?{$wgStyleVersion}\"></script><![endif]-->\n" );
			$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"/skins/common/jquery/jquery.flot.js?{$wgStyleVersion}\"></script>\n" );
			$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"/skins/common/jquery/jquery.flot.selection.js?{$wgStyleVersion}\"></script>\n" );
			$wgOut->addHTML( $oTmpl->execute( self::TEMPLATE_CHART ) );
		}



		wfProfileOut( __METHOD__ );
		
		return true;

	}

	/**
	 * HTMLerror - displays error subpage.
	 */

	protected function HTMLerror(){

		global $wgOut;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$wgOut->addHTML( $oTmpl->execute( self::TEMPLATE_ERROR ) );

		return false;

	}
	
}



