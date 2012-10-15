<?php

class SpecialBannerAllocation extends UnlistedSpecialPage {
	public $project = 'wikipedia';
	public $language = 'en';
	public $location = 'US';

	function __construct() {
		// Register special page
		parent::__construct( 'BannerAllocation' );
	}

	/**
	 * Handle different types of page requests
	 */
	function execute( $sub ) {
		global $wgOut, $wgLang, $wgRequest, $wgNoticeProjects, $wgLanguageCode, $wgNoticeProject;

		$this->project = $wgRequest->getText( 'project', $wgNoticeProject );
		$this->language = $wgRequest->getText( 'language', $wgLanguageCode );

		// If the form has been submitted, the country code should be passed along.
		$locationSubmitted = $wgRequest->getVal( 'country' );
		$this->location = $locationSubmitted ? $locationSubmitted : $this->location;

		// Convert submitted location to boolean value. If it true, showList() will be called.
		$locationSubmitted = (boolean) $locationSubmitted;

		// Begin output
		$this->setHeaders();

		// Output ResourceLoader module for styling and javascript functions
		$wgOut->addModules( array( 'ext.centralNotice.interface', 'ext.centralNotice.bannerStats' ) );

		// Initialize error variable
		$this->centralNoticeError = false;

		// Show summary
		$wgOut->addWikiMsg( 'centralnotice-summary' );

		// Show header
		CentralNotice::printHeader();

		// Begin Banners tab content
		$wgOut->addHTML( Html::openElement( 'div', array( 'id' => 'preferences' ) ) );

		$htmlOut = '';

		// Begin Allocation selection fieldset
		$htmlOut .= Html::openElement( 'fieldset', array( 'class' => 'prefsection' ) );

		$htmlOut .= Html::openElement( 'form', array( 'method' => 'get' ) );
		$htmlOut .= Html::element( 'h2', null, wfMsg( 'centralnotice-view-allocation' ) );
		$htmlOut .= Xml::tags( 'p', null, wfMsg( 'centralnotice-allocation-instructions' ) );

		$htmlOut .= Html::openElement( 'table', array ( 'id' => 'envpicker', 'cellpadding' => 7 ) );
		$htmlOut .= Html::openElement( 'tr' );
		$htmlOut .= Xml::tags( 'td',
			array( 'style' => 'width: 20%;' ),
			wfMsg( 'centralnotice-project-name' ) );
		$htmlOut .= Html::openElement( 'td' );
		$htmlOut .= Html::openElement( 'select', array( 'name' => 'project' ) );

		foreach ( $wgNoticeProjects as $value ) {
			$htmlOut .= Xml::option( $value, $value, $value === $this->project );
		}

		$htmlOut .= Html::closeElement( 'select' );
		$htmlOut .= Html::closeElement( 'td' );
		$htmlOut .= Html::closeElement( 'tr' );
		$htmlOut .= Html::openElement( 'tr' );
		$htmlOut .= Xml::tags( 'td',
			array( 'valign' => 'top' ),
			wfMsg( 'centralnotice-project-lang' ) );
		$htmlOut .= Html::openElement( 'td' );

		// Make sure the site language is in the list; a custom language code
		// might not have a defined name...
		$languages = Language::getLanguageNames( true );
		if( !array_key_exists( $wgLanguageCode, $languages ) ) {
			$languages[$wgLanguageCode] = $wgLanguageCode;
		}

		ksort( $languages );
		$htmlOut .= Html::openElement( 'select', array( 'name' => 'language' ) );

		foreach( $languages as $code => $name ) {
			$htmlOut .= Xml::option(
				wfMsg( 'centralnotice-language-listing', $code, $name ),
				$code, $code === $this->language );
		}

		$htmlOut .= Html::closeElement( 'select' );
		$htmlOut .= Html::closeElement( 'td' );
		$htmlOut .= Html::closeElement( 'tr' );
		$htmlOut .= Html::openElement( 'tr' );
		$htmlOut .= Xml::tags( 'td', array(), wfMsg( 'centralnotice-country' ) );
		$htmlOut .= Html::openElement( 'td' );

		$userLanguageCode = $wgLang->getCode();
		$countries = CentralNoticeDB::getCountriesList( $userLanguageCode );

		$htmlOut .= Html::openElement( 'select', array( 'name' => 'country' ) );

		foreach( $countries as $code => $name ) {
			$htmlOut .= Xml::option( $name, $code, $code === $this->location );
		}

		$htmlOut .= Html::closeElement( 'select' );
		$htmlOut .= Html::closeElement( 'td' );
		$htmlOut .= Html::closeElement( 'tr' );
		$htmlOut .= Html::closeElement( 'table' );

		$htmlOut .= Xml::tags( 'div',
			array( 'class' => 'cn-buttons' ),
			Xml::submitButton( wfMsg( 'centralnotice-view' ) )
		);
		$htmlOut .= Html::closeElement( 'form' );

		// End Allocation selection fieldset
		$htmlOut .= Html::closeElement( 'fieldset' );

		$wgOut->addHTML( $htmlOut );

		// Handle form submissions
		if ( $locationSubmitted ) {
			$this->showList();
		}

		// End Banners tab content
		$wgOut->addHTML( Html::closeElement( 'div' ) );
	}

	/**
	 * Show a list of banners with allocation. Newer banners are shown first.
	 */
	function showList() {
		global $wgOut, $wgRequest;

		// Begin building HTML
		$htmlOut = '';

		// Begin Allocation list fieldset
		$htmlOut .= Html::openElement( 'fieldset', array( 'class' => 'prefsection' ) );

		$bannerLister = new SpecialBannerListLoader();
		$bannerLister->project = $wgRequest->getVal( 'project' );
		$bannerLister->language = $wgRequest->getVal( 'language' );
		$bannerLister->location = $wgRequest->getVal( 'country' );

		$htmlOut .= Xml::tags( 'p', null,
			wfMsg (
				'centralnotice-allocation-description',
				htmlspecialchars( $bannerLister->language ),
				htmlspecialchars( $bannerLister->project ),
				htmlspecialchars( $bannerLister->location )
			)
		);

		$bannerList = $bannerLister->getJsonList();
		$banners = FormatJson::decode( $bannerList, true );
		$campaigns = array();
		$anonBanners = array();
		$accountBanners = array();
		$anonWeight = 0;
		$accountWeight = 0;

		if ( $banners ) {

			foreach ( $banners as $banner ) {
				if ( $banner['display_anon'] ) {
					$anonBanners[] = $banner;
					$anonWeight += $banner['weight'];
				}

				if ( $banner['display_account'] ) {
					$accountBanners[] = $banner;
					$accountWeight += $banner['weight'];
				}

				if ( $banner['campaign'] ) {
					$campaigns[] = $banner['campaign'];
				}
			}

			// Build campaign list for bannerstats.js
			$campaignList = FormatJson::encode( $campaigns );
			$js = "wgCentralNoticeAllocationCampaigns = $campaignList;";
			$htmlOut .= Html::inlineScript( $js );

			if ( $anonBanners && $anonWeight > 0 ) {
				$htmlOut .= $this->getTable( wfMsg ( 'centralnotice-banner-anonymous' ), $anonBanners, $anonWeight );
			}

			if ( $accountBanners && $accountWeight > 0  ) {
				$htmlOut .= $this->getTable( wfMsg ( 'centralnotice-banner-logged-in' ), $accountBanners, $accountWeight );
			}
		} else {
			$htmlOut .= Xml::tags( 'p', null, wfMsg ( 'centralnotice-no-allocation' ) );
		}

		// End Allocation list fieldset
		$htmlOut .= Html::closeElement( 'fieldset' );

		$wgOut->addHTML( $htmlOut );
	}

	/**
	 * Generate the HTML for an allocation table
	 * @param $type string The title for the table
	 * @param $banners array The banners to list
	 * @param $weight integer The total weight of the banners
	 * @return HTML for the table
	 */
	function getTable( $type, $banners, $weight ) {
		global $wgLang;

		$sk = $this->getSkin();
		$viewBanner = $this->getTitleFor( 'NoticeTemplate', 'view' );
		$viewCampaign = $this->getTitleFor( 'CentralNotice' );

		$htmlOut = Html::openElement( 'table',
			array ( 'cellpadding' => 9, 'class' => 'wikitable sortable', 'style' => 'margin: 1em 0;' )
		);
		$htmlOut .= Html::element( 'caption', array( 'style' => 'font-size: 1.2em;' ), $type );
		$htmlOut .= Html::openElement( 'tr' );
		$htmlOut .= Html::element( 'th', array( 'width' => '20%' ),
			wfMsg ( 'centralnotice-percentage' ) );
		$htmlOut .= Html::element( 'th', array( 'width' => '30%' ),
			wfMsg ( 'centralnotice-banner' ) );
		$htmlOut .= Html::element( 'th', array( 'width' => '30%' ),
			wfMsg ( 'centralnotice-notice' ) );
		$htmlOut .= Html::closeElement( 'tr' );

		foreach ( $banners as $banner ) {
			$htmlOut .= Html::openElement( 'tr' );
			$htmlOut .= Html::openElement( 'td' );

			$percentage = round( ( $banner['weight'] / $weight ) * 100, 2 );

			$htmlOut .= wfMsg ( 'percent', $wgLang->formatNum( $percentage ) );
			$htmlOut .= Html::closeElement( 'td' );

			$htmlOut .= Xml::openElement( 'td', array( 'valign' => 'top' ) );
			// The span class is used by bannerstats.js to find where to insert the stats
			$htmlOut .= Html::openElement( 'span',
				array( 'class' => 'cn-'.$banner['campaign'].'-'.$banner['name'] ) );
			$htmlOut .= $sk->makeLinkObj( $viewBanner, htmlspecialchars( $banner['name'] ),
					'template=' . urlencode( $banner['name'] ) );
			$htmlOut .= Html::closeElement( 'span' );
			$htmlOut .= Html::closeElement( 'td' );

			$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top' ),

			$sk->makeLinkObj( $viewCampaign, htmlspecialchars( $banner['campaign'] ),
					'method=listNoticeDetail&notice=' . urlencode( $banner['campaign'] ) )
			);

			$htmlOut .= Html::closeElement( 'tr' );
		}

		$htmlOut .= Html::closeElement( 'table' );

		return $htmlOut;
	}
}
