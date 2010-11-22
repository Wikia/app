<?php

abstract class AdSS_Ad {

	public $id;
	public $type;
	public $url;
	public $userId;
	public $userEmail;
	public $wikiId;
	public $pageId;
	public $status;
	public $created;
	public $closed;
	public $expires;
	public $weight;
	public $price;

	protected $user;

	function __construct() {
		global $wgCityId;
		$this->id = 0;
		$this->url = '';
		$this->userId = 0;
		$this->userEmail = '';
		$this->wikiId = $wgCityId;
		$this->pageId = 0;
		$this->status = 0;
		$this->created = null;
		$this->closed = null;
		$this->expires = null;
		$this->weight = 1;
		$this->price = 0;
		$this->user = null;
	}

	function loadFromForm( $f ) {
		$this->userEmail = $f->get( 'wpEmail' );
		$this->url = $f->get( 'wpUrl' );
		if( strtolower( mb_substr( $this->url, 0, 7 ) ) == 'http://' ) {
			$this->url = mb_substr( $this->url, 7 );
		}
		switch( $f->get( 'wpType' ) ) {
			case 'banner':
				$this->weight = $f->get( 'wpWeight' );
				$this->price = AdSS_Util::getBannerPricing();
				$this->price['price'] = $this->weight * $this->price['price'];
				break;
			case 'site-premium':
				$this->weight = 4;
				$this->price = AdSS_Util::getSitePricing();
				$this->price['price'] = 3 * $this->price['price'];
				break;
			default /* site */:
				$this->weight = $f->get( 'wpWeight' );
				$this->price = AdSS_Util::getSitePricing();
				$this->price['price'] = $this->weight * $this->price['price'];
				break;
		}
	}

	function loadFromRow( $row ) {
		if( isset( $row->ad_id ) ) {
			$this->id = intval( $row->ad_id );
		}
		$this->url = $row->ad_url;
		$this->userId = $row->ad_user_id;
		$this->userEmail = $row->ad_user_email;
		$this->wikiId = $row->ad_wiki_id;
		$this->pageId = $row->ad_page_id;
		$this->status = $row->ad_status;
		$this->created = wfTimestampOrNull( TS_UNIX, $row->ad_created );
		$this->closed = wfTimestampOrNull( TS_UNIX, $row->ad_closed );
		$this->expires = wfTimestampOrNull( TS_UNIX, $row->ad_expires );
		$this->weight = $row->ad_weight;
		$this->price = array(
				'price'  => $row->ad_price,
				'period' => $row->ad_price_period,
				);
	}

	abstract function save();

	abstract function render( $tmpl );

	function refresh() {
		$now = time();
		if( is_null( $this->expires ) ) {
			$this->expires = $now;
		} else {
			if( $this->expires < $now ) {
				$this->expires = $now;
			}
		}
		switch( $this->price['period'] ) {
			case 'd': $period = "+1 day"; break;
			case 'w': $period = "+1 week"; break;
			case 'm': $period = "+1 month"; break;
		}
		$this->expires = strtotime( $period, $this->expires );
		$this->save();
	}

	function close() {
		$this->closed = wfTimestampNow( TS_DB );
		$this->save();
	}

	function getUser() {
		if( !$this->user ) {
			$this->user = AdSS_User::newFromId( $this->userId );
		}
		return $this->user;
	}

	function setUser( $user ) {
		$this->user = $user;
		$this->userId = $user->id;
		$this->userEmail = $user->email;
	}

}
