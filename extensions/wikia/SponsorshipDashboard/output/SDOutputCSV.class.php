<?php

/**
 * SponsorshipDashboard
 * @author Jakub "Szeryf" Kurcek
 *
 * Returns chart basing on report object
 */

class SponsorshipDashboardOutputCSV extends SponsorshipDashboardOutputTable {

	const TEMPLATE_MAIN = 'csv';

	public $sourceLabels;
	public $sourceData;

	protected $actualDate;

	static function newFromReport( $oReport ){
		// get_class here will return self::$__CLASS__
		$class = get_class();
		$obj = new $class; /* @var $obj SponsorshipDashboardOutputCSV */
		$obj->set( $oReport );
		return $obj;
	}

	public function getHTML(){
		wfProfileIn( __METHOD__ );

		$this->report->loadSources();

		$aData = array();
		$aLabel = array();

		if ( count( $this->report->reportSources ) == 0 ) {
			wfProfileOut( __METHOD__ );
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
		header("HTTP/1.0 200 OK");
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		$fileTitle = $this->report->name.' - '.date('Y-m-d');
		header("Content-Disposition: attachment;filename={$fileTitle}.csv");
		header("Content-Transfer-Encoding: binary ");
	}
}
