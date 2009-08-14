<?php

class SpecialMyHome extends UnlistedSpecialPage {
	function __construct() {
		parent::__construct( 'MyHome');
		wfLoadExtensionMessages('MyHome');
	}

	function execute( $par ) {
		global $wgOut, $wgUser;

		if( !$wgUser->isAllowed( 'wikifactory' ) ) {
			$this->displayRestrictionError();
			return;
		}

		$this->setHeaders();

		// load CSS/JS
		global $wgExtensionsPath, $wgStyleVersion, $wgJsMimeType;
		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/MyHome/MyHome.css?{$wgStyleVersion}");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/MyHome/MyHome.js?{$wgStyleVersion}\"></script>\n");

		// message for anons
		if ($wgUser->isAnon()) {
			$wgOut->addWikiText(wfMsg('myhome-log-in'));
			return;
		}

		// force user to use Monaco skin
		$skinName = get_class($wgUser->getSkin());
		if ($skinName != 'SkinMonaco') {
			$wgOut->addWikiText(wfMsg('myhome-switch-to-monaco'));
			return;
		}

		// debug
		global $wgRequest;
		$limit = $wgRequest->getInt('limit', 30);

		// choose feed to show
		if ($par == 'watchlist') {
			// watchlist
			$provider = new WatchlistFeedProvider();
			$feedData = $provider->get($limit);
			$renderer = new WatchlistFeedRenderer();
		}
		else {
			// activity
			$provider = new ActivityFeedProvider();
			$feedData = $provider->get($limit);
			$feedData = $feedData['results'];
			$renderer = new ActivityFeedRenderer();
		}

		// render chosen feed
		$feedHtml = $renderer->render($feedData);

		// user contributions
		$contribsProvider = new UserContributionsProvider();
		$contribsData = $contribsProvider->get($limit);

		$contribsRenderer = new UserContributionsRenderer();
		$contribsHtml = $contribsRenderer->render($contribsData);

		// show it
		$wgOut->addHTML('<div id="myhome-wrapper">');

		// links to feeds
		$linkToMyHome = Skin::makeSpecialUrl('MyHome');

		$wgOut->addHTML('<div style="position: absolute; top: 12px; right: 300px">');
		$wgOut->addHTML( Xml::element('a', array('href' => $linkToMyHome . '/activity'), wfMsg('myhome-activity-feed')) );
		$wgOut->addHTML(' | ');
		$wgOut->addHTML( Xml::element('a', array('href' => $linkToMyHome . '/watchlist'), wfMsg('myhome-watchlist-feed')) );
		$wgOut->addHTML('</div>');

		// feed
		$wgOut->addHTML($feedHtml);

		// sidebar
		$wgOut->addHTML('<div id="myhome-sidebar">');
		$wgOut->addHTML( $contribsHtml );
		//$wgOut->addHTML( Xml::element('pre', array(), print_r($contribsData, true)) );
		$wgOut->addHTML('</div>');

		//$wgOut->addHTML('<pre>' . htmlspecialchars(print_r($feedData, true)) . '</pre>');

		$wgOut->addHTML('</div>');
	}
}
