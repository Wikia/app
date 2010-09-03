<?php
/**
 * Renders search box
 *
 * @author Maciej Brencz
 */

class SearchModule extends Module {

	var $fulltext;
	var $placeholder;
	var $wgBlankImgUrl;
	var $wgSitename;
	var $wgTitle;

	public function executeIndex() {
		global $wgSitename, $wgSearchDefaultFulltext;

		$this->fulltext = !empty($wgSearchDefaultFulltext) ? 1 : 0;
		$this->placeholder = wfMsg('Tooltip-search', $wgSitename);
	}

}