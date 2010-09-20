<?php
class SpotlightsModule extends Module {

	var $wgBlankImgUrl;
	
	var $wgSingleH1;

	public function executeIndex() {
		wfProfileIn(__METHOD__);

		global $wgSingleH1;

		wfProfileOut(__METHOD__);
	}

}