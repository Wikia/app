<?php

class AdSS_ManagerAdListPager extends TablePager {

	private $mTitle, $ad, $userId;

	function __construct( $userId ) {
		global $wgAdSS_DBname;

		parent::__construct();

		$this->mDb = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
		$this->mTitle = Title::makeTitle( NS_SPECIAL, "AdSS/manager/adList" );
		$this->userId = $userId;
	}

	function getTitle() {
		return $this->mTitle;
	}

	function isFieldSortable( $field ) {
		return false;
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
				return Xml::element( 'a', array('href'=>$wiki->city_url), $wiki->city_title );
			case 'ad_type':
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
					return wfMsg( 'adss-per-page' ) . "<br />\n($url)";
				} else {
					return wfMsg( 'adss-per-site' );
				}
			case 'ad_weight':
				if( $this->ad->pageId == 0 ) {
					return $value;
					//TODO
					if( !$this->ad->closed && ( !$this->ad->expires || $this->ad->expires > time() ) ) {
						$ret = "$value (" . Xml::element( 'a', array( 'href' => '#' ), '+' );
						if( $this->ad->weight > 1 ) {
							$ret .= " / " . Xml::element( 'a', array( 'href' => '#' ), '-' );
						}
						$ret .= ")";
						return $ret;
					} else {
						return $value;
					}
				} else {
					return '-';
				}
			case 'ad_desc':
				$tmpl = new EasyTemplate( $wgAdSS_templatesDir . '/manager' );
				$tmpl->set( 'ad', $this->ad );
				return $tmpl->render( 'ad' );
			case 'ad_status':
				if( $this->ad->closed && $this->ad->expires ) {
					$status = 'canceled';
				} elseif( $this->ad->closed && !$this->ad->expires ) {
					$status = 'rejected';
				} elseif( !$this->ad->closed && $this->ad->expires ) {
					$status = 'approved';
				} elseif( !$this->ad->closed && !$this->ad->expires ) {
					$status = 'pending';
				}
				return "<div class=\"$status\">" . wfMsg( "adss-$status" ) . "</div>";
			case 'ad_created':
			case 'ad_closed':
			case 'ad_expires':
				return substr( $value, 0, 10 );
			case 'ad_price':
				return AdSS_Util::formatPrice( $this->ad->price );
			case 'ad_action':
				if( !$this->ad->closed ) {
					$tmpl = new EasyTemplate( $wgAdSS_templatesDir . '/manager' );
					$tmpl->set( 'ad', $this->ad );
					return $tmpl->render( 'actionClose' );
				}
				return '';
			default:
				return $value;
		}
	}

	function getDefaultSort() {
		return "ad_id";
	}

	function getDefaultDirections() {
		return true;
	}

	function getFieldNames() {
		return array(
				'ad_wiki_id' => wfMsgHtml( 'adss-wikia' ),
				'ad_type'    => wfMsgHtml( 'adss-type' ),
				'ad_weight'  => wfMsgHtml( 'adss-no-shares' ),
				'ad_price'   => wfMsgHtml( 'adss-price' ),
				'ad_desc'    => wfMsgHtml( 'adss-ad' ),
				'ad_status'  => wfMsgHtml( 'adss-status' ),
				'ad_created' => wfMsgHtml( 'adss-created' ),
				'ad_action'  => '',
			    );
	}

	function getQueryInfo() {
		$qi = array(
				'tables' => array( 'ads' ),
				'fields' => array( '*' ),
				'conds'  => array( 'ad_user_id' => $this->userId ),
			    );
		return $qi;
	}

}
