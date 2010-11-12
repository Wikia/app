<?php

class AdSS_TextAd extends AdSS_Ad {

	public $text;
	public $desc;

	function __construct() {
		parent::__construct();
		$this->type = 't';
		$this->text = '';
		$this->desc = '';
	}

	function loadFromForm( $f ) {
		parent::loadFromForm( $f );
		$this->text = $f->get( 'wpText' );
		$this->desc = $f->get( 'wpDesc' );
	}

	function loadFromRow( $row ) {
		parent::loadFromRow( $row );
		$this->text = $row->ad_text;
		$this->desc = $row->ad_desc;
	}

	function save() {
		global $wgAdSS_DBname;

		$dbw = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
		if( $this->id == 0 ) {
			$dbw->insert( 'ads',
					array(
						'ad_user_id'      => $this->userId,
						'ad_type'         => $this->type,
						'ad_url'          => $this->url,
						'ad_text'         => $this->text,
						'ad_desc'         => $this->desc,
						'ad_wiki_id'      => $this->wikiId,
						'ad_page_id'      => $this->pageId,
						'ad_status'       => $this->status,
						'ad_created'      => wfTimestampNow( TS_DB ),
						'ad_expires'      => wfTimestampOrNull( TS_DB, $this->expires ),
						'ad_weight'       => $this->weight,
						'ad_price'        => $this->price['price'],
						'ad_price_period' => $this->price['period'],
					     ),
					__METHOD__
				    );
			$this->id = $dbw->insertId();
		} else {
			$dbw->update( 'ads',
					array(
						'ad_user_id'      => $this->userId,
						'ad_type'         => $this->type,
						'ad_url'          => $this->url,
						'ad_text'         => $this->text,
						'ad_desc'         => $this->desc,
						'ad_wiki_id'      => $this->wikiId,
						'ad_page_id'      => $this->pageId,
						'ad_status'       => $this->status,
						'ad_closed'       => wfTimestampOrNull( TS_DB, $this->closed ),
						'ad_expires'      => wfTimestampOrNull( TS_DB, $this->expires ),
						'ad_weight'       => $this->weight,
						'ad_price'        => $this->price['price'],
						'ad_price_period' => $this->price['period'],
					     ),
					array(
						'ad_id' => $this->id
					     ),
					__METHOD__
				    );
		}
	}

	function render( $tmpl ) {
		$tmpl->set( 'ad', $this );
		return $tmpl->render( 'textAd' );
	}

}
