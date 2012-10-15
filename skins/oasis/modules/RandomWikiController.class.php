<?php
/**
 * Renders "Random Wiki" button in page footer if RandomWiki extension is enabled on Oasis
 *
 * @author Maciej Brencz
 */

class RandomWikiController extends WikiaController {

	public function executeIndex() {
		global $wgEnableRandomWikiOasisButton, $wgCityId;

		$this->url = null;
		if (!empty($wgEnableRandomWikiOasisButton)) {
			$this->url = "http://community.wikia.com/wiki/Special:RandomWiki/{$wgCityId}";
		}
	}
}