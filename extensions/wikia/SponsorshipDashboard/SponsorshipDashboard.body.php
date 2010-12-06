<?php
/**
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Jakub Kurcek
 *
 */

class SponsorshipDashboard extends SpecialPage {



	private $allowedSubpages = array('report1', 'report2', 'error', 'gapi');
	// private $allowedGroups = array('staff', 'sysop', 'janitor', 'bureaucrat');
	// private $TEST = 0;

	function  __construct() {

		global $wgUser;

		$listed = ( in_array('staff', $wgUser->getEffectiveGroups()) );

		parent::__construct( "SponsorshipDashboard" , '', $listed /*restriction*/);
		wfLoadExtensionMessages("SponsorshipDashboard");
	}

	function execute( $subpage = 'report2' ) {

		global $wgSupressPageSubtitle, $wgUser;

		$wgSupressPageSubtitle = true;

		if ( in_array('staff', $wgUser->getEffectiveGroups()) ){
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
	 * HTMLgapi - displays Google Api subpage - not used.
	 */

	private function HTMLgapi(){

		global $wgHTTPProxy, $wgWikiaGAPassword, $wgWikiaGALogin;

		$ga = new gapi($wgWikiaGALogin, $wgWikiaGAPassword, null, 'curl', $wgHTTPProxy);
		$ga->requestAccountData();
		foreach($ga->getResults() as $result)
		{
			echo $result . ' (' . $result->getProfileId() . ")<br />";
		}
	}

	/**
	 * HTMLmain - displays report 1 subpage.
	 */

	private function HTMLreport1(){

		global $wgOut, $wgJsMimeType, $wgStyleVersion, $wgHTTPProxy;

		wfProfileIn( __METHOD__ );

		$SponsorshipDashboardService = new SponsorshipDashboardService;
		$fromWikiStats = $SponsorshipDashboardService->loadDataFromWikiStats();

		$this->displayChart( $fromWikiStats['serie'], $fromWikiStats['ticks'] );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * HTMLmain - displays report 2 subpage.
	 */

	private function HTMLreport2(){

		wfProfileIn( __METHOD__ );

		$SponsorshipDashboardService = new SponsorshipDashboardService;
		$fromWikiStats = $SponsorshipDashboardService->loadDataFromWikiStats();
		$tagPosition = $SponsorshipDashboardService->loadTagPosition();

		$this->displayChart( $fromWikiStats['serie'], $fromWikiStats['ticks'], $tagPosition );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * HTMLmain - displays chart.
	 */
	
	private function displayChart( $datasets, $ticks, $tagPosition = false ){

		global $wgOut, $wgJsMimeType, $wgStyleVersion, $wgHTTPProxy;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars(
			array(
				"datasets"		=> $datasets,
				"ticks"			=> $ticks,
				"tagPosition"		=> $tagPosition
			)
		);

		$wgOut->addStyle( wfGetSassUrl( 'extensions/wikia/SponsorshipDashboard/css/SponsorshipDashboard.scss' ) );
		$wgOut->addScript( "<!--[if IE]><script type=\"{$wgJsMimeType}\" src=\"/skins/common/jquery/excanvas.min.js?{$wgStyleVersion}\"></script><![endif]-->\n" );
		$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"/skins/common/jquery/jquery.flot.js?{$wgStyleVersion}\"></script>\n" );
		$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"/skins/common/jquery/jquery.flot.selection.js?{$wgStyleVersion}\"></script>\n" );
		$wgOut->addHTML( $oTmpl->execute( "chart" ) );
		
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



