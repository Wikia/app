<?php

class AdSS_AdminPager extends TablePager {

	private $mTitle, $mAd;

	function __construct() {
		global $wgAdSS_DBname;
		parent::__construct();
		$this->mDb = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
		$this->mTitle = Title::makeTitle( NS_SPECIAL, "AdSS/admin" );
	}

	function getTitle() {
		return $this->mTitle;
	}

	function isFieldSortable( $field ) {
		return in_array( $field, array( 'ad_created', 'ad_expires' ) );
	}

	function formatRow( $row ) {
		$this->mAd = AdSS_Ad::newFromRow( $row );
		return parent::formatRow( $row );
	}

	function formatValue( $name, $value ) {
		global $wgAdSS_templatesDir;
		switch( $name ) {
			case 'ad_id':
				$tmpl = new EasyTemplate( $wgAdSS_templatesDir . '/admin' );
				$tmpl->set( 'ad', $this->mAd );
				return $tmpl->render( 'actionLink' );
			case 'ad_text':
				$tmpl = new EasyTemplate( $wgAdSS_templatesDir . '/admin' );
				$tmpl->set( 'ad', $this->mAd );
				return $tmpl->render( 'ad' );
			case 'ad_page_id':
				if( $this->mAd->pageId > 0 ) {
					$title = Title::newFromID( $this->mAd->pageId );
					return "Page<br />\n(".$this->getSkin()->link( $title ).")";
				} else {
					return 'Site';
				}
			default:
				return $value;
		}
	}

	function getDefaultSort() {
		return "ad_created";
	}

	function getFieldNames() {
		return array(
				'ad_page_id'    => 'Type',
				'ad_text'       => 'Ad',
				'ad_user_email' => 'User',
				'ad_created'    => 'Created',
				'ad_expires'    => 'Expires',
				'ppa_baid'      => 'Billing Agreement ID',
				'ad_id'         => 'Action',
			    );
	}

	function getQueryInfo() {
		global $wgCityId;
		return array(
				'tables' => array( 'ads', 'pp_tokens', 'pp_agreements' ),
				'fields' => array( '*' ),
				'conds'  => array(
					'ad_wiki_id' => $wgCityId,
					'ad_closed' => null,
					'ad_id = ppt_ad_id',
					'ppt_token = ppa_token',
					)
			    );
	}

}
