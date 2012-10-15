<?php

class WikiHeaderController extends WikiaController {

	public function executeIndex() {
		global $wgCityId, $wgUser, $wgIsPrivateWiki, $wgEnableAdminDashboardExt, $wgTitle;

		//fb#1090
		$this->isInternalWiki = empty($wgCityId);
		$this->showMenu = !(($this->isInternalWiki || $wgIsPrivateWiki) && $wgUser->isAnon());

		if($wgUser->isAllowed('editinterface')) {
			$editURL['href'] = Title::newFromText('Wiki-navigation', NS_MEDIAWIKI)->getFullURL();
			$editURL['text'] = wfMsg('oasis-edit-this-menu');
			$this->editURL = $editURL;
		}

		$service = new NavigationService();
		$this->menuNodes = $service->parseMessage('Wiki-navigation', array(4, 7, 7), 60*60*3 /* 3 hours */, true);

		$this->displaySearch = !empty($wgEnableAdminDashboardExt) && AdminDashboardLogic::displayAdminDashboard(F::app(), $wgTitle);
	}

	public function executeWordmark() {
		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();

		$this->wordmarkText = $settings['wordmark-text'];
		$this->wordmarkType = $settings['wordmark-type'];
		$this->wordmarkSize = $settings['wordmark-font-size'];
		$this->wordmarkFont = $settings['wordmark-font'];
		$this->wordmarkFontClass = !empty($settings["wordmark-font"]) ? "font-{$settings['wordmark-font']}" : '';
		$this->wordmarkUrl = '';
		if ($this->wordmarkType == "graphic") {
			wfProfileIn(__METHOD__ . 'graphicWordmark');
			$this->wordmarkUrl = wfReplaceImageServer($settings['wordmark-image-url'], SassUtil::getCacheBuster());			
			$imageTitle = Title::newFromText($themeSettings::WordmarkImageName,NS_IMAGE);
			if($imageTitle instanceof Title) {
				$attributes = array();
				$file = wfFindFile($imageTitle);
				if($file instanceof File) {
					$attributes []= 'width="' . $file->width . '"';
					$attributes []= 'height="' . $file->height. '"';
	
					if(!empty($attributes)) {
						$this->wordmarkStyle = ' ' . implode(' ',$attributes) . ' ';
					}
				}
			}
			wfProfileOut(__METHOD__. 'graphicWordmark');
		}

		$this->mainPageURL = Title::newMainPage()->getLocalURL();
	}
}
