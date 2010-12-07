<?php

class AdSS_AdChange {

	public $id;
	public $url;
	public $text;
	public $desc;

	function __construct( $ad ) {
		$this->id = $ad->id;
	}

	function loadFromRow( $row ) {
		$this->url = $row->adc_url;
		$this->text = $row->adc_text;
		$this->desc = $row->adc_desc;
	}

	function loadFromDB() {
		global $wgAdSS_DBname;

		$dbr = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
		$row = $dbr->selectRow( 'ad_changes', '*', array( 'adc_ad_id' => $this->id ), __METHOD__ );
		if( $row === false ) {
			// invalid id
			return null;
		} else {
			$this->loadFromRow( $row );
			return $this;
		}
	}

	function save() {
		global $wgAdSS_DBname;

		$dbw = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
		
		if( $dbw->selectField( 'ad_changes', 'adc_ad_id', array( 'adc_ad_id' => $this->id ), __METHOD__ ) ) {
			$dbw->update( 'ad_changes',
					array(
						'adc_url'          => $this->url,
						'adc_text'         => $this->text,
						'adc_desc'         => $this->desc,
						'adc_created'      => wfTimestampNow( TS_DB ),
					     ),
					array(
						'adc_ad_id'        => $this->id,
					     ),
					__METHOD__
				    );
		} else {
			$dbw->insert( 'ad_changes',
					array(
						'adc_ad_id'        => $this->id,
						'adc_url'          => $this->url,
						'adc_text'         => $this->text,
						'adc_desc'         => $this->desc,
						'adc_created'      => wfTimestampNow( TS_DB ),
					     ),
					__METHOD__
				    );
		}
	}

	function delete() {
		global $wgAdSS_DBname;
		$dbw = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
		$dbw->delete( 'ad_changes', array( 'adc_ad_id' => $this->id ), __METHOD__ );
	}
}
