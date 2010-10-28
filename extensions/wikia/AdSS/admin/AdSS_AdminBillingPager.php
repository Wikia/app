<?php

class AdSS_AdminBillingPager extends TablePager {

	private $mTitle, $bl;

	function __construct() {
		global $wgAdSS_DBname;

		parent::__construct();

		$this->mDb = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
		$this->mTitle = Title::makeTitle( NS_SPECIAL, "AdSS/admin/billing" );
	}

	function getTitle() {
		return $this->mTitle;
	}

	function isFieldSortable( $field ) {
		return false;
	}

	function formatRow( $row ) {
		$this->bl = AdSS_Billing::newFromRow( $row );
		return parent::formatRow( $row );
	}

	function formatValue( $name, $value ) {
		global $wgAdSS_templatesDir;
		switch( $name ) {
			case 'billing_id':
				if( $this->bl->adId > 0 ) {
					return 'AdSS Fee';
				} elseif( $this->bl->paymentId > 0 ) {
					return 'PayPal payment';
				} else {
					return '???';
				}
			case 'billing_user_id':
				return AdSS_User::newFromId( $value )->toString();
			default:
				return $value;
		}
	}

	function getDefaultSort() {
		return "billing_id";
	}

	function getDefaultDirections() {
		// descending
		return true;
	}

	function getFieldNames() {
		return array(
				'billing_timestamp' => 'Timestamp',
				'billing_id'        => 'Type',
				'billing_user_id'   => 'User',
				'billing_amount'    => 'Amount',
			    );
	}

	function getQueryInfo() {
		$qi = array(
				'tables' => array( 'billing' ),
				'fields' => array( '*' ),
			    );
		return $qi;
	}

}
