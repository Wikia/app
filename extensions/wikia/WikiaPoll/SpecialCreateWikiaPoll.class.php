<?php

class SpecialCreateWikiaPoll extends SpecialPage {

	function SpecialCreateWikiaPoll() {
			SpecialPage::SpecialPage("CreatePoll", "", false);
	}

	public function execute ($subpage) {
		global $wgOut;
		$wgOut->addHtml(wfRenderPartial('WikiaPoll', 'SpecialPage'));
	}
}
?>
