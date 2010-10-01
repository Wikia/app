<?php
class PagesOnWikiModule extends Module {

	var $wgSingleH1;
	var $wgSitename;
	var $total;

	public function executeIndex() {
		wfProfileIn(__METHOD__);
		
		global $wgLang;
		$this->total = $wgLang->formatNum(SiteStats::articles());
		
		wfProfileOut(__METHOD__);
	}

}