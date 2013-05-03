<?php

/**
 * SponsorshipDashboard
 * @author Jakub "Szeryf" Kurcek
 *
 * Returns chart basing on report object
 */

class SponsorshipDashboardOutputTable extends SponsorshipDashboardOutputFormatter {

	const TEMPLATE_MAIN = 'table';

	public $sourceLabels;
	public $sourceData;

	protected $actualDate;

	static function newFromReport( $oReport ){

		$obj = new self;
		$obj->set( $oReport );
		return $obj;
	}

	public function getHTML(){

		wfProfileIn( __METHOD__ );

		$wgOut = $this->App->getGlobal('wgOut');
		$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/SponsorshipDashboard/css/SponsorshipDashboard.scss' ) );

		$this->report->loadSources();

		$aData = array();
		$aLabel = array();

		if ( count( $this->report->reportSources ) == 0 ) {
			wfProfileOut(__METHOD__);
			return '';
		}

		foreach( $this->report->reportSources as $reportSource ){

			$reportSource->getData();
			$this->actualDate = $reportSource->actualDate;

			if ( !empty( $reportSource->dataAll ) && !empty( $reportSource->dataTitles ) ){
				if ( is_array( $reportSource->dataAll ) ){
					foreach ( $reportSource->dataAll as $key => $val ){
						if ( isset( $aData[$key] ) ){
							$aData[$key] = array_merge( $aData[$key], $val );
						} else {
							$aData[$key] = $val;
						}
					}
				}
				$aLabel += $reportSource->dataTitles;
			}
		}

		sort( $aData );
		$this->sourceData = array_reverse( $aData );
		$this->sourceLabels = array_reverse( $aLabel );

		$oTmpl = new EasyTemplate( dirname( __FILE__ )."/templates/" );
		$oTmpl->set_vars(
			array(
				'data'			=> $this->sourceData,
				'labels'		=> $this->sourceLabels
			)
		);

		wfProfileOut( __METHOD__ );

		$this->beforePrint();

		return $oTmpl->render( '../../templates/output/'.self::TEMPLATE_MAIN );
	}

	function beforePrint(){
		return true;
	}
}
