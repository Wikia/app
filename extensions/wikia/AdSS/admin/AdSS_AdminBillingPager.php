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
		global $wgAdSS_templatesDir, $wgLang;
		switch( $name ) {
			case 'billing_amount':
				return $value > 0 ? wfMsgHtml( 'adss-paypal-payment' ) : wfMsg( 'adss-adss-fee' );
			case 'billing_ad_id':
				return $value ? wfMsg( 'adss-amount', $wgLang->formatNum( -$this->bl->amount ) ) : '';
			case 'billing_ppp_id':
				return $value ? wfMsg( 'adss-amount', $wgLang->formatNum( (float) $this->bl->amount ) ) : '';
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
				'billing_timestamp' => wfMsgHtml( 'adss-timestamp' ),
				'billing_user_id'   => 'User',
				'billing_amount'    => wfMsgHtml( 'adss-description' ),
				'billing_ad_id'     => wfMsgHtml( 'adss-fee' ),
				'billing_ppp_id'    => wfMsgHtml( 'adss-paid' ),
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
