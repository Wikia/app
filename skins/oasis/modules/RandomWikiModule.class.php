<?php
class RandomWikiModule extends Module {

	var $url;

	public function executeIndex() {
		global $wgEnableRandomWikiOasisButton, $wgCityId;

		if (!empty($wgEnableRandomWikiOasisButton)) {
			$this->url = "http://community.wikia.com/wiki/Special:RandomWiki/{$wgCityId}";
		}
	}
}