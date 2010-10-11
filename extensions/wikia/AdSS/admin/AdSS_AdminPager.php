<?php

class AdSS_AdminPager extends TablePager {

	private $mTitle, $ad;

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
		$this->ad = AdSS_Ad::newFromRow( $row );
		return parent::formatRow( $row );
	}

	function formatValue( $name, $value ) {
		global $wgAdSS_templatesDir;
		switch( $name ) {
			case 'ad_wiki_id':
				$wiki = WikiFactory::getWikiByID( $value );
				return $wiki->city_title;
			case 'ad_id':
				$tmpl = new EasyTemplate( $wgAdSS_templatesDir . '/admin' );
				$tmpl->set( 'ad', $this->ad );
				return $tmpl->render( 'actionLink' );
			case 'ad_text':
				$tmpl = new EasyTemplate( $wgAdSS_templatesDir . '/admin' );
				$tmpl->set( 'ad', $this->ad );
				return $tmpl->render( 'ad' );
			case 'ad_page_id':
				if( $this->ad->pageId > 0 ) {
					$title = Title::newFromID( $this->ad->pageId );
					return "Page<br />\n(".$this->getSkin()->link( $title ).")";
				} else {
					return 'Site';
				}
			case 'ad_price':
				return AdSS_Util::formatPrice( $this->ad->price );
			default:
				return $value;
		}
	}

	function getDefaultSort() {
		return "ad_created";
	}

	function getFieldNames() {
		return array(
				'ad_wiki_id'    => 'Wikia',
				'ad_page_id'    => 'Type',
				'ad_text'       => 'Ad',
				'ad_user_email' => 'User',
				'ad_created'    => 'Created',
				'ad_expires'    => 'Expires',
				'ppa_baid'      => 'Billing Agreement ID',
				'ad_price'      => 'Price',
				'ad_id'         => 'Action',
			    );
	}

	function getQueryInfo() {
		return array(
				'tables' => array( 'ads', 'pp_tokens', 'pp_agreements' ),
				'fields' => array( '*' ),
				'conds'  => array(
					'ad_closed' => null,
					'ad_id = ppt_ad_id',
					'ppt_token = ppa_token',
					)
			    );
	}

}
