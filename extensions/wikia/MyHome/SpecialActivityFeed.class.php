<?php

class SpecialActivityFeed extends SpecialPage {

	function __construct() {
		wfLoadExtensionMessages('MyHome');
		parent::__construct('ActivityFeed', '' /* no restriction */, true /* listed */);
	}

	function execute($par) {
		wfProfileIn(__METHOD__);
		global $wgOut, $wgUser, $wgTitle;
		$this->setHeaders();

		// not available for skins different then monaco / answers
		$skinName = get_class($wgUser->getSkin());
		if (!in_array($skinName, array('SkinMonaco', 'SkinAnswers'))) {
			$wgOut->addWikiMsg( 'myhome-switch-to-monaco' );
			wfProfileOut(__METHOD__);
			return;
		}

		// load dependencies (CSS and JS)
		global $wgExtensionsPath, $wgStyleVersion, $wgJsMimeType;
		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/MyHome/MyHome.css?{$wgStyleVersion}");

		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/MyHome/MyHome.js?{$wgStyleVersion}\"></script>\n");

		// hide page title
		global $wgSupressPageTitle;
		$wgSupressPageTitle = true;

		// use message from MyHome as special page title
		$wgOut->setPageTitle(wfMsg('myhome-activity-feed'));

		######
		### Prepare HTML for ActivityFeed
		######

		$feedProxy = new ActivityFeedAPIProxy();
		$feedRenderer = new ActivityFeedForAnonsRenderer();

		$feedProvider = new DataFeedProvider($feedProxy);
		// render ActivityFeed
		$feedHTML = $feedRenderer->render($feedProvider->get(60));

		######
		### Show HTML
		######

		$template = new EasyTemplate(dirname(__FILE__).'/templates');
		$template->set('feedHTML', $feedHTML);

		$wgOut->addHTML($template->render('activityfeed'));
		wfProfileOut(__METHOD__);
	}
}
