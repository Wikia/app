<?php
/**
 * Renders Related Videos thumbs in rail module and footer spotlights
 *
 * @author Jakub Kurcek
 */

class RelatedVideoModule extends Module {

	public $categories;
	public $server;

	public function executeIndex() {

		global $wgServer, $wgRelatedVideoCategories, $wgWikiaRelatedVideoSid;
		$this->categories = $wgRelatedVideoCategories;
		$this->server = $wgServer;
		$this->sid = $wgWikiaRelatedVideoSid;

	}

	public function executeSpotlight(){
		
		global $wgServer, $wgRelatedVideoCategories, $wgWikiaRelatedVideoSid;
		$this->categories = $wgRelatedVideoCategories;
		$this->server = $wgServer;
		$this->sid = $wgWikiaRelatedVideoSid;

	}
}