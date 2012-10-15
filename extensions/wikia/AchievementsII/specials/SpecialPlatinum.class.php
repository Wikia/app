<?php

class SpecialPlatinum extends SpecialPage {

	function __construct() {
		parent::__construct('Platinum', 'platinum', true /* listed */);
	}

	function execute($par) {
		wfProfileIn(__METHOD__);

		global $wgOut, $wgExtensionsPath, $wgResourceBasePath, $wgJsMimeType, $wgUser;

		// set basic headers
		$this->setHeaders();

		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			wfProfileOut( __METHOD__ );
			return;
		}

		if(!$this->userCanExecute($wgUser)) {
			$this->displayRestrictionError();
			wfProfileOut( __METHOD__ );
			return;
		}

		// include resources (css and js)
		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/AchievementsII/css/platinum.css\n");
		$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/AchievementsII/css/oasis.scss'));
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/AchievementsII/js/platinum.js\"></script>\n");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgResourceBasePath}/resources/wikia/libraries/aim/jquery.aim.js\"></script>\n");

		// call service to get needed data
		$badges = AchPlatinumService::getList();

		// pass data to template
		$template = new EasyTemplate(dirname(__FILE__).'/templates');
		$template->set_vars(array('badges' => $badges));

		// render template
		$wgOut->addHTML($template->render('SpecialPlatinum'));

		wfProfileOut(__METHOD__);
	}
}