<?php

class AdSS_ManagerPager extends TablePager {

	private $mTitle, $ad, $userId;
	private $mFilter = 'active';
	private $mFiltersShown = array(
			'all'     => 'All',
			'active'  => 'In rotation (accepted & not expired)',
			'pending' => 'Pending acceptance',
			'expired' => 'Expired (not closed)',
			'closed'  => 'Closed',
			);

	function __construct( $userId ) {
		global $wgAdSS_DBname;

		parent::__construct();

		$this->mDb = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
		$this->mTitle = Title::makeTitle( NS_SPECIAL, "AdSS/manager" );

		$filter = $this->mRequest->getVal( 'filter', $this->mFilter );
		if( array_key_exists( $filter, $this->mFiltersShown ) ) {
			$this->mFilter = $filter;
		}

		$this->userId = $userId;
	}

	function getTitle() {
		return $this->mTitle;
	}

	function isFieldSortable( $field ) {
		return in_array( $field, array( 'ad_created', 'ad_expires', 'ad_closed' ) );
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
			case 'ad_closed':
				if( $this->ad->closed ) return $value;
				$tmpl = new EasyTemplate( $wgAdSS_templatesDir . '/manager' );
				$tmpl->set( 'ad', $this->ad );
				return $tmpl->render( 'actionClose' );
			case 'ad_text':
				$tmpl = new EasyTemplate( $wgAdSS_templatesDir . '/manager' );
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
			case 'ad_weight':
				if( $this->ad->pageId == 0 ) {
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
					return '';
				}
			case 'ad_price':
				return AdSS_Util::formatPrice( $this->ad->price, $this->ad->weight );
			default:
				return $value;
		}
	}

	function getDefaultSort() {
		return "ad_created";
	}

	function getFieldNames() {
		return array(
				'ad_wiki_id' => 'Wikia',
				'ad_page_id' => 'Type',
				'ad_weight'  => 'No. shares',
				'ad_price'   => 'Price',
				'ad_text'    => 'Ad',
				'ad_created' => 'Created',
				'ad_expires' => 'Expires',
				'ad_closed'  => 'Closed',
			    );
	}

	function getQueryInfo() {
		$qi = array(
				'tables' => array( 'ads' ),
				'fields' => array( '*' ),
				'conds'  => array( 'ad_user_id' => $this->userId ),
			    );
		switch( $this->mFilter ) {
			case 'active':
				$qi['conds'] += array(
						'ad_closed IS NULL',
						'ad_expires > NOW()',
						);
				break;
			case 'pending':
				$qi['conds'] += array(
						'ad_closed IS NULL',
						'ad_expires IS NULL',
						);
				break;
			case 'expired':
				$qi['conds'] += array(
						'ad_closed IS NULL',
						'ad_expires <= NOW()',
						);
				break;
			case 'closed':
				$qi['conds'] += array(
						'ad_closed IS NOT NULL',
						);
				break;
		}
		return $qi;
	}

	function getFilterSelect() {
		$s = "<label for=\"filter\">Show ads:</label>";
		$s .= "<select name=\"filter\">";
		foreach( $this->mFiltersShown as $fkey => $fval ) {
			$selected = '';
			if( $fkey == $this->mFilter ) {
				$selected = " selected";
			}
			$fval = htmlspecialchars( $fval );
			$s .= "<option value=\"$fkey\"$selected>$fval</option>\n";
		}
		$s .= "</select>";
		return $s;
	}

	function getFilterForm() {
		$url = $this->getTitle()->escapeLocalURL();
		return
			"<form method=\"get\" action=\"$url\">" .
			$this->getFilterSelect() .
			"\n<input type=\"submit\" />\n" .
			//$this->getHiddenFields( array('filter','title') ) .
			"</form>\n";
	}

}
