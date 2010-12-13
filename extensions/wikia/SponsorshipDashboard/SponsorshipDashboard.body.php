<?php
/**
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Jakub Kurcek
 *
 */

class SponsorshipDashboard extends SpecialPage {



	private $allowedSubpages = array('error', 'report1', 'report2', 'report3', 'report4');
	private $popularCityHubs;

	function  __construct() {

		global $wgUser, $wgSponsorshipDashboardAllowAdmins;

		$listed = (
			( in_array('staff', $wgUser->getEffectiveGroups()) ) ||
			( in_array('admin', $wgUser->getEffectiveGroups()) && !empty( $wgSponsorshipDashboardAllowAdmins ) )
		);

		parent::__construct( "SponsorshipDashboard" , '', $listed /*restriction*/);
		wfLoadExtensionMessages("SponsorshipDashboard");
	}

	function execute( $subpage = 'report2' ) {

		global $wgSupressPageSubtitle, $wgUser, $wgRequest;

		$wgSupressPageSubtitle = true;

		if ( in_array('staff', $wgUser->getEffectiveGroups()) || in_array('admin', $wgUser->getEffectiveGroups()) ){
			if ( in_array( $subpage, $this->allowedSubpages ) ){
				$function = 'HTML'.$subpage;
				$this->$function();
			} else {
				$this->HTMLreport2();
			}
		} else {
			$this->HTMLerror();
		}
	}
	
	/**
	 * HTMLmain - displays report 1 subpage.
	 */

	private function HTMLreport1(){

		global $wgOut;

		wfProfileIn( __METHOD__ );

		$currentCityHub = $this->getCurrentCityHub();

		$this->displayHeader();
		$this->displayTagSelector();

		if ( empty( $currentCityHub ) ){
			$this->displayChart( false, false );
		} else {
			$sponsorshipDashboardService = new SponsorshipDashboardService;
			$fromWikiStats = $sponsorshipDashboardService->loadRelatedWikiasData( $currentCityHub );
			$this->displayChart( $fromWikiStats['serie'], $fromWikiStats['ticks'] );
		}
		
		wfProfileOut( __METHOD__ );
	}

	/**
	 * HTMLmain - displays report 2 subpage.
	 */

	private function HTMLreport2(){

		global $wgOut;

		wfProfileIn( __METHOD__ );

		$sponsorshipDashboardService = new SponsorshipDashboardService;
		$fromWikiStats = $sponsorshipDashboardService->loadDataFromWikiStats();

		$hiddenSeries = array('A' , 'B', 'C', 'D', 'E', 'G', 'I', 'K', 'L', 'X', 'Y');

		$this->displayHeader( 1 );
		$this->displayRanking( $sponsorshipDashboardService->loadTagPosition() );
		$this->displayChart( $fromWikiStats['serie'], $fromWikiStats['ticks'], $hiddenSeries );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * HTMLmain - displays report 3 subpage.
	 */

	private function HTMLreport3(){

		global $wgOut;

		wfProfileIn( __METHOD__ );

		$sponsorshipDashboardService = new SponsorshipDashboardService;
		$GAData = $sponsorshipDashboardService->loadGAData();

		$hiddenSeries = array( 'clicks' , 'visits', 'newVisits', 'newVisitsTimeOnSite' );

		$this->displayHeader(2);
		$this->displayChart( $GAData['serie'], $GAData['ticks'], $hiddenSeries );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * HTMLmain - displays report 4 subpage.
	 */

	private function HTMLreport4(){

		global $wgOut;

		wfProfileIn( __METHOD__ );

		$currentCityHub = $this->getCurrentCityHub();

		$this->displayHeader(4);
		$this->displayTagSelector( 'report4');
		
		if ( empty( $currentCityHub ) ){
			$this->displayChart( false, false );
		} else {
			$sponsorshipDashboardService = new SponsorshipDashboardService;
			$GAData = $sponsorshipDashboardService->loadTop10CompetitionData( $currentCityHub );
			$hiddenSeries = array( 'clicks' , 'visits', 'newVisits', 'newVisitsTimeOnSite' );
			$this->displayChart( $GAData['serie'], $GAData['ticks'], $hiddenSeries );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * HTMLmain - displays tag selector.
	 */

	private function displayTagSelector( $subpage = 'report1' ){

		global $wgOut, $wgRequest, $wgTitle;

		wfProfileIn( __METHOD__ );

		$sponsorshipDashboardService = new SponsorshipDashboardService;
		$aPopularHubs = $this->getPopularHubs();

		if ( is_array( $aPopularHubs ) && count( $aPopularHubs ) > 1){
			
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars(
				array(
					"current"		=> $this->getCurrentCityHub(),
					"selectorItems"		=> $aPopularHubs,
					"path"			=> $wgTitle->getFullURL().'/'.$subpage
				)
			);
			$wgOut->addHTML( $oTmpl->execute( "form" ) );
		
		}
		wfProfileOut( __METHOD__ );
	}

	private function displayHeader( $tab = 0 ){

		global $wgOut, $wgTitle;

		wfProfileIn( __METHOD__ );

		$wgOut->addStyle( wfGetSassUrl( 'extensions/wikia/SponsorshipDashboard/css/SponsorshipDashboard.scss' ) );

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars(
				array(
					"tab"			=> (int) $tab,
					"path"			=> $wgTitle->getFullURL()				)
			);
		$wgOut->addHTML( $oTmpl->execute( "header" ) );

		wfProfileOut( __METHOD__ );
	}

	private function getCurrentCityHub(){
		
		global $wgRequest;

		$aPopularHubs = $this->getPopularHubs();

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
	
	private function getPopularHubs(){

		if ( empty( $this->popularCityHubs ) ){
			$sponsorshipDashboardService = new SponsorshipDashboardService;
			$aPopularHubs = $sponsorshipDashboardService->getPopularHubs();
			$this->popularCityHubs = $aPopularHubs;
		}
		return $this->popularCityHubs;
	}

	private function displayRanking( $tagPosition ){

		global $wgOut, $wgJsMimeType, $wgStyleVersion, $wgHTTPProxy;

		wfProfileIn( __METHOD__ );

		if ( empty( $tagPosition ) ){
			return false;
		}

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars(
			array(
				"tagPosition"		=> $tagPosition
			)
		);

		$wgOut->addHTML( $oTmpl->execute( "ranking" ) );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * HTMLmain - main function for displaying chart.
	 */
	
	private function displayChart( $datasets, $ticks, $hiddenSeries = false ){

		global $wgOut, $wgJsMimeType, $wgStyleVersion, $wgHTTPProxy;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

		if ( empty( $datasets ) || empty( $datasets ) ){
			$wgOut->addHTML( $oTmpl->execute( "emptychart" ) );
		} else {

			$oTmpl->set_vars(
				array(
					"datasets"		=> $datasets,
					"ticks"			=> $ticks,
					"hiddenSeries"	=> ( !empty( $hiddenSeries ) && is_array( $hiddenSeries ) ) ? "['".implode("', '", $hiddenSeries)."']" : "[]"
				)
			);

			$wgOut->addScript( "<!--[if IE]><script type=\"{$wgJsMimeType}\" src=\"/skins/common/jquery/excanvas.min.js?{$wgStyleVersion}\"></script><![endif]-->\n" );
			$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"/skins/common/jquery/jquery.flot.js?{$wgStyleVersion}\"></script>\n" );
			$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"/skins/common/jquery/jquery.flot.selection.js?{$wgStyleVersion}\"></script>\n" );
			$wgOut->addHTML( $oTmpl->execute( "chart" ) );
		}

	}

	/**
	 * HTMLerror - displays error subpage.
	 */

	private function HTMLerror(){

		global $wgOut;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$wgOut->addHTML( $oTmpl->execute( "error" ) );

	}
	
}



