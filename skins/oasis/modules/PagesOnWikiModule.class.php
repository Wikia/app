<?php
class PagesOnWikiModule extends Module {

	var $wgDisableAnonymousEditing;
	var $wgEnableWikiAnswers;
	var $wgSitename;
	var $total;

	public function executeIndex() {
		wfProfileIn(__METHOD__);
		
		$this->total = SiteStats::articles();

		wfProfileOut(__METHOD__);
	}

}
