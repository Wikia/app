<?php
/**
 * Description of CorporateModule
 *
 * @author owen
 */
class CorporateSiteController extends WikiaController {

	// These are just templates
	// FIXME: refactor the common functionality out of these
	public function executeSalesSupport () {

		global $wgUser;
		wfProfileIn(__METHOD__);

		// add CSS for this module
		$this->isAdmin = $wgUser->isAllowed('editinterface');

		wfProfileOut(__METHOD__);
	}

	public function executeSlider() {
		global $wgOut, $wgTitle, $wgParser;

		if (WikiaPageType::isMainPage()) {
			$this->isMainPage = true;
			$this->slider_class = "big";
			$this->slider = CorporatePageHelper::parseMsgImg('corporatepage-slider',true);
		}
		else {
			$this->isMainPage = false;
		}
	}
}
