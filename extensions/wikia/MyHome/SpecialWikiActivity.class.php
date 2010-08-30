<?php

class SpecialWikiActivity extends SpecialPage {

	function __construct() {
		wfLoadExtensionMessages('MyHome');
		parent::__construct('WikiActivity', '' /* no restriction */, true /* listed */);
	}

	function execute($par) {
		wfProfileIn(__METHOD__);
		global $wgOut, $wgUser, $wgTitle;
		$this->setHeaders();

		// not available for skins different then monaco / answers
		$skinName = get_class($wgUser->getSkin());
		if (!in_array($skinName, array('SkinMonaco', 'SkinAnswers', 'SkinOasis'))) {
			$wgOut->addWikiMsg( 'myhome-switch-to-monaco' );
			wfProfileOut(__METHOD__);
			return;
		}

		// load tracking JS
		global $wgJsMimeType, $wgExtensionsPath, $wgStyleVersion;
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/MyHome/WikiActivity.js?{$wgStyleVersion}\"></script>\n");

		$feedProxy = new ActivityFeedAPIProxy();
		$feedProvider = new DataFeedProvider($feedProxy);

		$data = $feedProvider->get(60);

		global $wgEnableAchievementsInActivityFeed, $wgEnableAchievementsExt, $wgExtensionsPath, $wgStyleVersion;
		if((!empty($wgEnableAchievementsInActivityFeed)) && (!empty($wgEnableAchievementsExt))){
			$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/AchievementsII/css/achievements_sidebar.css?{$wgStyleVersion}");
		}

		// use message from MyHome as special page title
		//$wgOut->setPageTitle(wfMsg('myhome-activity-feed'));
		$wgOut->setPageTitle(wfMsg('oasis-activity-header'));

		$template = new EasyTemplate(dirname(__FILE__).'/templates');
		$template->set('data', $data['results']);
		$template->set('tagid', 'myhome-activityfeed'); // FIXME: remove
		global $wgBlankImgUrl;
		$template->set_vars(array(
			'assets' => array(
				'blank' => $wgBlankImgUrl,
			),
			'type' => 'activity',
		));  // FIXME: remove

		$wgOut->addStyle(wfGetSassUrl("extensions/wikia/MyHome/oasis.scss"));

		$wgOut->addHTML($template->render('activityfeed.oasis'));

		wfProfileOut(__METHOD__);
	}

}

