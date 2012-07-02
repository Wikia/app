<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "CentralNotice extension\n";
	exit( 1 );
}

class SpecialCentralNoticeLogs extends UnlistedSpecialPage {
	public $logType = 'campaignsettings';

	function __construct() {
		// Register special page
		parent::__construct( "CentralNoticeLogs" );
	}

	/**
	 * Handle different types of page requests
	 */
	function execute( $sub ) {
		global $wgOut, $wgRequest, $wgExtensionAssetsPath;

		$this->logType = $wgRequest->getText( 'log', 'campaignsettings' );

		// Begin output
		$this->setHeaders();

		// Output ResourceLoader module for styling and javascript functions
		$wgOut->addModules( 'ext.centralNotice.interface' );

		// Initialize error variable
		$this->centralNoticeError = false;

		// Show summary
		$wgOut->addWikiMsg( 'centralnotice-summary' );

		// Show header
		CentralNotice::printHeader();

		// Begin Banners tab content
		$wgOut->addHTML( Xml::openElement( 'div', array( 'id' => 'preferences' ) ) );

		$htmlOut = '';

		// Begin log selection fieldset
		$htmlOut .= Xml::openElement( 'fieldset', array( 'class' => 'prefsection' ) );

		$title = SpecialPage::getTitleFor( 'CentralNoticeLogs' );
		$actionUrl = $title->getLocalURL();
		$htmlOut .= Xml::openElement( 'form', array( 'method' => 'get', 'action' => $actionUrl ) );
		$htmlOut .= Xml::element( 'h2', null, wfMsg( 'centralnotice-view-logs' ) );
		$htmlOut .= Xml::openElement( 'div', array( 'id' => 'cn-log-switcher' ) );
		$title = SpecialPage::getTitleFor( 'CentralNoticeLogs' );
		$fullUrl = wfExpandUrl( $title->getFullUrl(), PROTO_CURRENT );

		// Build the radio buttons for switching the log type
		$htmlOut .= $this->getLogSwitcher( 'campaignsettings', 'campaignSettings',
			'centralnotice-campaign-settings', $fullUrl );
		$htmlOut .= $this->getLogSwitcher( 'bannersettings', 'bannerSettings',
			'centralnotice-banner-settings', $fullUrl );
		$htmlOut .= $this->getLogSwitcher( 'bannercontent', 'bannerContent',
			'centralnotice-banner-content', $fullUrl );
		$htmlOut .= $this->getLogSwitcher( 'bannermessages', 'bannerMessages',
			'centralnotice-banner-messages', $fullUrl );

		$htmlOut .= Xml::closeElement( 'div' );

		if ( $this->logType == 'campaignsettings' ) {

			$reset = $wgRequest->getVal( 'centralnoticelogreset' );
			$campaign = $wgRequest->getVal( 'campaign' );
			$user = $wgRequest->getVal( 'user' );
			$startYear = $this->getDateValue( 'start_year' );
			$startMonth = $this->getDateValue( 'start_month' );
			$startDay = $this->getDateValue( 'start_day' );
			$endYear = $this->getDateValue( 'end_year' );
			$endMonth = $this->getDateValue( 'end_month' );
			$endDay = $this->getDateValue( 'end_day' );

			$htmlOut .= Xml::openElement( 'div', array( 'id' => 'cn-log-filters-container' ) );

			if ( $campaign || $user || $startYear || $startMonth || $startDay || $endYear || $endMonth || $endDay ) { // filters on
				$htmlOut .= '<a href="javascript:toggleFilterDisplay()">'.
					'<img src="'.$wgExtensionAssetsPath.'/CentralNotice/collapsed.png" id="cn-collapsed-filter-arrow" style="display:none;position:relative;top:-2px;"/>'.
					'<img src="'.$wgExtensionAssetsPath.'/CentralNotice/uncollapsed.png" id="cn-uncollapsed-filter-arrow" style="display:inline-block;position:relative;top:-2px;"/>'.
					'</a>';
				$htmlOut .= Xml::tags( 'span', array( 'style' => 'margin-left: 0.3em;' ), wfMsg( 'centralnotice-filters' ) );
				$htmlOut .= Xml::openElement( 'div', array( 'id' => 'cn-log-filters' ) );
			} else { // filters off
				$htmlOut .= '<a href="javascript:toggleFilterDisplay()">'.
					'<img src="'.$wgExtensionAssetsPath.'/CentralNotice/collapsed.png" id="cn-collapsed-filter-arrow" style="display:inline-block;position:relative;top:-2px;"/>'.
					'<img src="'.$wgExtensionAssetsPath.'/CentralNotice/uncollapsed.png" id="cn-uncollapsed-filter-arrow" style="display:none;position:relative;top:-2px;"/>'.
					'</a>';
				$htmlOut .= Xml::tags( 'span', array( 'style' => 'margin-left: 0.3em;' ), wfMsg( 'centralnotice-filters' ) );
				$htmlOut .= Xml::openElement( 'div', array( 'id' => 'cn-log-filters', 'style' => 'display:none;' ) );
			}

			$htmlOut .= Xml::openElement( 'table' );
			$htmlOut .= Xml::openElement( 'tr' );

			$htmlOut .= Xml::openElement( 'td' );
			$htmlOut .= Xml::label( wfMsg( 'centralnotice-start-date' ), 'month', array( 'class' => 'cn-log-filter-label' ) );
			$htmlOut .= Xml::closeElement( 'td' );
			$htmlOut .= Xml::openElement( 'td' );
			if ( $reset ) {
				$htmlOut .= $this->dateSelector( 'start' );
			} else {
				$htmlOut .= $this->dateSelector( 'start', $startYear, $startMonth, $startDay );
			}
			$htmlOut .= Xml::closeElement( 'td' );

			$htmlOut .= Xml::closeElement( 'tr' );
			$htmlOut .= Xml::openElement( 'tr' );

			$htmlOut .= Xml::openElement( 'td' );
			$htmlOut .= Xml::label( wfMsg( 'centralnotice-end-date' ), 'month', array( 'class' => 'cn-log-filter-label' ) );
			$htmlOut .= Xml::closeElement( 'td' );
			$htmlOut .= Xml::openElement( 'td' );
			if ( $reset ) {
				$htmlOut .= $this->dateSelector( 'end' );
			} else {
				$htmlOut .= $this->dateSelector( 'end', $endYear, $endMonth, $endDay );
			}
			$htmlOut .= Xml::closeElement( 'td' );

			$htmlOut .= Xml::closeElement( 'tr' );
			$htmlOut .= Xml::openElement( 'tr' );

			$htmlOut .= Xml::openElement( 'td' );
			$htmlOut .= Xml::label( wfMsg( 'centralnotice-notice' ), 'campaign', array( 'class' => 'cn-log-filter-label' ) );
			$htmlOut .= Xml::closeElement( 'td' );
			$htmlOut .= Xml::openElement( 'td' );
			$htmlOut .= Xml::input( 'campaign', 25, ( $reset ? '' : $campaign ) );
			$htmlOut .= Xml::closeElement( 'span' );
			$htmlOut .= Xml::closeElement( 'td' );

			$htmlOut .= Xml::closeElement( 'tr' );
			$htmlOut .= Xml::openElement( 'tr' );

			$htmlOut .= Xml::openElement( 'td' );
			$htmlOut .= Xml::label( wfMsg( 'centralnotice-user' ), 'user', array( 'class' => 'cn-log-filter-label' ) );
			$htmlOut .= Xml::closeElement( 'td' );
			$htmlOut .= Xml::openElement( 'td' );
			$htmlOut .= Xml::input( 'user', 25, ( $reset ? '' : $user ) );
			$htmlOut .= Xml::closeElement( 'span' );
			$htmlOut .= Xml::closeElement( 'td' );

			$htmlOut .= Xml::closeElement( 'tr' );
			$htmlOut .= Xml::openElement( 'tr' );

			$htmlOut .= Xml::openElement( 'td', array( 'colspan' => 2 ) );
			$htmlOut .= Xml::submitButton( wfMsg( 'centralnotice-apply-filters' ),
				array(
					'id' => 'centralnoticesubmit',
					'name' => 'centralnoticesubmit',
					'class' => 'cn-filter-buttons',
				)
			);
			$link = $title->getLinkUrl();
			$htmlOut .= Xml::submitButton( wfMsg( 'centralnotice-clear-filters' ),
				array(
					'id' => 'centralnoticelogreset',
					'name' => 'centralnoticelogreset',
					'class' => 'cn-filter-buttons',
					'onclick' => "window.location = '$link'; return false;",
				)
			);
			$htmlOut .= Xml::closeElement( 'td' );

			$htmlOut .= Xml::closeElement( 'tr' );
			$htmlOut .= Xml::closeElement( 'table' );
			$htmlOut .= Xml::closeElement( 'div' );
			$htmlOut .= Xml::closeElement( 'div' );
		}

		$htmlOut .= Xml::closeElement( 'form' );

		// End log selection fieldset
		//$htmlOut .= Xml::closeElement( 'fieldset' );

		$wgOut->addHTML( $htmlOut );

		$this->showLog( $this->logType );

		// End Banners tab content
		$wgOut->addHTML( Xml::closeElement( 'div' ) );
	}

	private function dateSelector( $prefix, $year = 0, $month = 0, $day = 0 ) {
		$dateRanges = CentralNotice::getDateRanges();

		$fields = array(
			array( $prefix."_month", "centralnotice-month", $dateRanges['months'], $month ),
			array( $prefix."_day",   "centralnotice-day",   $dateRanges['days'],   $day ),
			array( $prefix."_year",  "centralnotice-year",  $dateRanges['years'],  $year ),
		);

		$out = '';
		foreach ( $fields as $data ) {
			list( $field, $label, $set, $current ) = $data;
			$out .= Xml::listDropDown( $field,
				CentralNotice::dropDownList( wfMsg( $label ), $set ),
				'',
				$current );
		}
		return $out;
	}

	/**
	 * Show a log of changes.
	 * @param $logType string: which type of log to show
	 */
	function showLog( $logType ) {
		global $wgOut;

		switch ( $logType ) {
			case 'bannersettings':
				$pager = new CentralNoticeBannerLogPager( $this );
				break;
			case 'bannercontent':
			case 'bannermessages':
				$pager = new CentralNoticePageLogPager( $this, $logType );
				break;
			default:
				$pager = new CentralNoticeCampaignLogPager( $this );
		}

		$htmlOut = '';

		// Begin log fieldset
		//$htmlOut .= Xml::openElement( 'fieldset', array( 'class' => 'prefsection' ) );

		// Show paginated list of log entries
		$htmlOut .= Xml::tags( 'div',
			array( 'class' => 'cn-pager' ),
			$pager->getNavigationBar() );
		$htmlOut .= $pager->getBody();
		$htmlOut .= Xml::tags( 'div',
			array( 'class' => 'cn-pager' ),
			$pager->getNavigationBar() );

		// End log fieldset
		$htmlOut .= Xml::closeElement( 'fieldset' );

		$wgOut->addHTML( $htmlOut );
	}

	static function getDateValue( $type ) {
		global $wgRequest;
		$value = $wgRequest->getVal( $type );
		if ( $value === 'other' ) $value = null;
		return $value;
	}

	/**
	 * Build a radio button that switches the log type when you click it
	 */
	private function getLogSwitcher( $type, $id, $message, $fullUrl ) {
		$htmlOut = '';
		$htmlOut .= Xml::radio(
			'log_type',
			$id,
			( $this->logType == $type ? true : false ),
			array( 'onclick' => "switchLogs( '".$fullUrl."', '".$type."' )" )
		);
		$htmlOut .= Xml::label( wfMsg( $message ), $id );
		return $htmlOut;
	}

}
