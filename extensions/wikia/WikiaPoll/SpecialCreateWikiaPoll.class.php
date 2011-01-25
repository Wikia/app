<?php

class SpecialCreateWikiaPoll extends SpecialPage {

	function SpecialCreateWikiaPoll() {
			SpecialPage::SpecialPage("CreatePoll", "", false);
	}

	public function execute ($subpage) {
		global $wgOut, $wgBlankImgUrl, $wgJsMimeType, $wgExtensionsPath, $wgStylePath;

		$wgOut->addScript("<script src=\"{$wgStylePath}/common/jquery/jquery-ui-1.7.2.custom.js\" type=\"{$wgJsMimeType}\"></script>");
		$wgOut->addScript("<script src=\"{$wgExtensionsPath}/wikia/WikiaPoll/js/CreateWikiaPoll.js\" type=\"{$wgJsMimeType}\"></script>");

		$wgOut->addStyle(wfGetSassUrl('/extensions/wikia/WikiaPoll/css/CreateWikiaPoll.scss'));

		$wgOut->addHtml(wfRenderModule('WikiaPoll', 'SpecialPage'));
	}
}
?>
