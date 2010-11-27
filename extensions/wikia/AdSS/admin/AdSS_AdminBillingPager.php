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
			case 'billing_timestamp':
				return substr( $value, 0, 16 );
			case 'billing_user_id':
				return AdSS_User::newFromId( $value )->toString();
			case 'description':
				if( $this->bl->paymentId ) {
					return wfMsgHtml( 'adss-paypal-payment' ) . " (ID=" . $this->bl->paymentId . ")";
				} elseif( $this->bl->adId ) {
					if( $this->bl->amount > 0 ) {
						$r = wfMsgHtml( 'adss-adss-refund' );
					} else {
						$r = wfMsgHtml( 'adss-adss-fee' );
					}
					$r .= " (ID=" . $this->bl->adId . ")";
					$tmpl = new EasyTemplate( $wgAdSS_templatesDir . '/admin' );
					$ad = AdSS_AdFactory::createFromId( $this->bl->adId );
					$tmpl->set( 'downloadUrl', Title::makeTitle( NS_SPECIAL, "AdSS/admin/download/".$ad->id )->getLocalURL() );
					$r .= "<div style=\"display:none\"><ul><li>".$ad->render( $tmpl )."</li></ul></div>";
					return $r;
				} else {
					return '';
				}
			case 'fee':
				return $this->bl->adId > 0 ? wfMsg( 'adss-amount', $wgLang->formatNum( -$this->bl->amount ) ) : '';
			case 'paid':
				return $this->bl->adId==0 && $this->bl->amount > 0 ? wfMsg( 'adss-amount', $wgLang->formatNum( (float) $this->bl->amount ) ) : '';
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
				'description'       => wfMsgHtml( 'adss-description' ),
				'fee'               => wfMsgHtml( 'adss-fee' ),
				'paid'              => wfMsgHtml( 'adss-paid' ),
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
