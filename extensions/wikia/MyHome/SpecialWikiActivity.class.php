<?php

class SpecialWikiActivity extends SpecialPage {
	var $activeTab;
	var $classActivity;
	var $classWatchlist;
	
	
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
		
		// watchlist feed
		if($par == 'watchlist') {
			if (get_class($wgUser->getSkin()) == 'SkinOasis') {
				$this->classWatchlist = "selected";
			}
			
			// not available for anons
			if($wgUser->isAnon()) {
				if (get_class($wgUser->getSkin()) == 'SkinOasis') {
					$wgOut->wrapWikiMsg( '<div class="latest-activity-watchlist-login" >$1</div>', array('oasis-activity-watchlist-login', wfGetReturntoParam()) );
				}
				else {
					$wgOut->wrapWikiMsg( '<div id="myhome-log-in">$1</div>', array('myhome-log-in', wfGetReturntoParam()) );
				}

				//oasis-activity-watchlist-login
				// RT #23970
				$wgOut->addInlineScript(<<<JS
$(function() {
	$('#myhome-log-in').find('a').click(function(ev) {
		openLogin(ev);
	});
});
JS
				);
				wfProfileOut(__METHOD__);
				return;
			}
			else {
				$feedSelected = 'watchlist';
				$feedProxy = new WatchlistFeedAPIProxy();
				$feedRenderer = new WatchlistFeedRenderer();
			}
		} else {
			// activity feed
			if (get_class($wgUser->getSkin()) == 'SkinOasis') {
				$this->classActivity = "selected";
			}
			
			$feedSelected = 'activity';
			$feedProxy = new ActivityFeedAPIProxy();
			$feedRenderer = new ActivityFeedRenderer();
		}
		
		$feedProvider = new DataFeedProvider($feedProxy);
		
		// WikiActivity.js is MyHome.js modified for Oasis
		global $wgJsMimeType, $wgExtensionsPath, $wgStyleVersion;
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/MyHome/WikiActivity.js?{$wgStyleVersion}\"></script>\n");
		
		$data = $feedProvider->get(50);  // this breaks when set to 60...
		
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
		$showMore = isset($data['query-continue']);
		if ($showMore) {
			$template->set('query_continue', $data['query-continue']);
		}
		if (empty($data['results'])) {
			$template->set('emptyMessage', wfMsgExt("myhome-activity-feed-empty", array( 'parse' )));
		}
		
		$template->set_vars(array(
					'assets' => array(
						'blank' => $wgBlankImgUrl,
						),
					'showMore' => $showMore,
					'type' => 'activity',
					'classWatchlist' => $this->classWatchlist,
					'classActivity' => $this->classActivity,
					));  // FIXME: remove
		
		$wgOut->addStyle(wfGetSassUrl("extensions/wikia/MyHome/oasis.scss"));
		
		$wgOut->addHTML($template->render('activityfeed.oasis'));
		
		wfProfileOut(__METHOD__);
	}
	
}

