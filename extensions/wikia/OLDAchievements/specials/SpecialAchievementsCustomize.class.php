<?php

class SpecialAchievementsCustomize extends SpecialPage {

	function __construct() {
		wfLoadExtensionMessages('Achievements');
		parent::__construct('AchievementsCustomize', 'editinterface' /* no restriction */, false /* listed */);
	}

	function execute($user_id) {
		wfProfileIn(__METHOD__);
		global $wgUser, $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgSupressPageTitle, $wgRequest;

		if(!$this->userCanExecute($wgUser)) {
			$this->displayRestrictionError();
			return;
		}

		$wgSupressPageTitle = true;

		if($wgRequest->wasPosted()) {

			$messages = Wikia::json_decode($wgRequest->getVal('c-messages'));

			$wgOut->wrapWikiMsg( '<div class="successbox"><strong>$1</strong></div>', 'achievements-special-saved' );

			foreach($messages as $mKey => $mVal) {
				if(wfMsg($mKey) != $mVal) {
					$article = new Article(Title::newFromText($mKey, NS_MEDIAWIKI));
					$article->doEdit($mVal, '');
				}
			}

		}

		$this->setHeaders();
		$template = new EasyTemplate(dirname(__FILE__).'/templates');
		$template->set_vars(array(
			'js_url' => "{$wgExtensionsPath}/wikia/Achievements/js/Achievements.js?{$wgStyleVersion}"
		));
		$wgOut->addHTML($template->render('Customize'));
		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/Achievements/css/customize.css?{$wgStyleVersion}");

		wfProfileOut(__METHOD__);
	}

}
