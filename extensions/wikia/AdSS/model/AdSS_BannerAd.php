<?php

class AdSS_BannerAd extends AdSS_Ad {

	public $bannerPath;

	function __construct() {
		parent::__construct();
		$this->bannerPath;
	}

	function loadFromForm( $f ) {
		parent::loadFromForm( $f );
		$this->bannerPath = $f->get( 'wpBannerPath' );
	}

	function loadFromRow( $row ) {
		parent::loadFromRow( $row );
		$this->bannerPath = $row->banner_path;
	}

	function render() {
		global $wgAdSS_templatesDir;
		$tmpl = new EasyTemplate( $wgAdSS_templatesDir );
		$tmpl->set( 'ad', $this );
		return $tmpl->render( 'bannerAd' );
	}
}
