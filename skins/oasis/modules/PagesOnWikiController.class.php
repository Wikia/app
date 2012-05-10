<?php
class PagesOnWikiController extends WikiaController {

	public function executeIndex() {
		wfProfileIn(__METHOD__);
		
		$this->total = SiteStats::articles();

		wfProfileOut(__METHOD__);
	}

}