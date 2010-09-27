<?php

class WikiHeaderModule extends Module {

	var $wgBlankImgUrl;

	var $mainPageURL;
	var $wgSitename;
	var $menuNodes;
	var $editURL;

	var $wordmarkText;
	var $wordmarkType;
	var $wordmarkSize;
	var $wordmarkStyle;
	var $wordmarkFont;

	var $wgSingleH1;

	private function parseMonacoSidebarToOasisNavigation($text) {
		$lines = explode("\n", $text);
		$skip = true;
		$firstDone = false;
		$new_lines = array();

		foreach($lines as $line) {
			if($skip) {
				if(trim($line) != '' && $line{0} == '*') {
					$depth = strrpos($line, '*') + 1;
					if($depth == 1) {
						if(!$firstDone) {
							$firstDone = true;
						} else {
							$skip = false;
						}
					}
				}
			}

			if(!$skip) {
				$new_lines[] = $line;
			}
		}

		return join("\n", $new_lines);
	}

	public function executeIndex() {

		global $wgOut, $wgCityId, $wgUser, $wgMemc;
		// Moved to StaticChute.
		//$wgOut->addScript('<script src="/skins/oasis/js/WikiHeader.js"></script>');

		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();

		$this->wordmarkText = $settings["wordmark-text"];
		$this->wordmarkType = $settings["wordmark-type"];
		$this->wordmarkSize = $settings["wordmark-font-size"];
		$this->wordmarkFont = $settings["wordmark-font"];

		if ($this->wordmarkType == "graphic") {
			$this->wordmarkStyle = 'style="background: url('. $settings["wordmark-image-url"] .') no-repeat"';
		} else {
			$this->wordmarkStyle = '';
		}

		$this->mainPageURL = Title::newMainPage()->getLocalURL();
		$service = new NavigationService();

		$oasis_navigation_title = Title::newFromText('Wiki-navigation', NS_MEDIAWIKI);

		if($wgUser->isAllowed('editinterface')) {
			$this->editURL['href'] = $oasis_navigation_title->getFullURL();
			$this->editURL['text'] = wfMsg('monaco-edit-this-menu');
		}

		if(!$oasis_navigation_title->exists()) {
			// There is no local version of Oasis-navigation

			$monaco_sidebar_title = Title::newFromText('Monaco-sidebar', NS_MEDIAWIKI);
			if($monaco_sidebar_title->exists()) {
				// There is a local version of Monaco-sidebar

				if(!wfEmptyMsg('Monaco-sidebar', wfMsgForContent('Monaco-sidebar'))) {
					$monaco_sidebar_text = wfMsgForContent('Monaco-sidebar');
					$oasis_navigation_text = $this->parseMonacoSidebarToOasisNavigation($monaco_sidebar_text);

					if(trim($oasis_navigation_text) != "") {
						global $wgIP;
						$userWikia = User::newFromName('Wikia');
						$origIP = $wgIP;
						$wgIP = '127.0.0.1';
						$oasis_navigation_article = new Article($oasis_navigation_title);
						$oasis_navigation_article->doEdit($oasis_navigation_text, '', ($userWikia->isAllowed('bot') ? EDIT_FORCE_BOT : 0) | EDIT_SUPPRESS_RC, false, $userWikia);
						$wgIP = $origIP;
					}
				}
			}
		}

		$this->menuNodes = $service->parseMessage('Wiki-navigation', array(4, 7));

		/*
		$mKey = wfMemcKey('mOasisWikiHeaderNodes', $oasis_navigation_title->getLatestRevID());
		$this->menuNodes = $wgMemc->get($mKey);
		if (empty($this->menuNodes)) {
			$lines = explode("\n", wfMsg('Wiki-navigation'));
			$this->menuNodes = $service->parseLines($lines, array(4, 7));
			$wgMemc->set($mKey, $this->menuNodes);
		}
		*/
	}

}
