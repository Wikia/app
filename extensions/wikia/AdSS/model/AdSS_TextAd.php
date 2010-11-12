<?php

class AdSS_TextAd extends AdSS_Ad {

	public $url;
	public $text;
	public $desc;

	function __construct() {
		parent::__construct();

		$this->url = '';
		$this->text = '';
		$this->desc = '';
	}

	function loadFromForm( $f ) {
		parent::loadFromForm( $f );
		$this->url = $f->get( 'wpUrl' );
		if( strtolower( mb_substr( $this->url, 0, 7 ) ) == 'http://' ) {
			$this->url = mb_substr( $this->url, 7 );
		}
		$this->text = $f->get( 'wpText' );
		$this->desc = $f->get( 'wpDesc' );
	}

	function loadFromRow( $row ) {
		parent::loadFromRow( $row );
		$this->url = $row->ad_url;
		$this->text = $row->ad_text;
		$this->desc = $row->ad_desc;
	}

	function render() {
		global $wgAdSS_templatesDir;
		$tmpl = new EasyTemplate( $wgAdSS_templatesDir );
		$tmpl->set( 'ad', $this );
		return $tmpl->render( 'textAd' );
	}

}
