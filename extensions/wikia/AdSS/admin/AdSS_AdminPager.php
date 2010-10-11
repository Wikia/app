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
					global $wgCityId;
					if( $this->ad->wikiId == $wgCityId ) {
						$title = Title::newFromID( $this->ad->pageId );
						$url = $this->getSkin()->link( $title );
					} else {
						$wiki = WikiFactory::getWikiByID( $this->ad->wikiId );
						$dbr = wfGetDB( DB_SLAVE, array(), $wiki->city_dbname );
						$title = $dbr->selectField( 'page', 'page_title', array( 'page_id'=>$this->ad->pageId ) );
						$wServer = WikiFactory::getVarValueByName( "wgServer", $this->ad->wikiId );
						$wArticlePath = WikiFactory::getVarValueByName( "wgArticlePath", $this->ad->wikiId );
						$url = Xml::element( 'a',
								array( 'href' => $wServer . str_replace( '$1', $title, $wArticlePath ) ),
								$title );
					}
					return "Page<br />\n($url)";
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
