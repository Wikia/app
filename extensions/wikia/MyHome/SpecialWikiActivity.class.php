<?php

class SpecialWikiActivity extends UnlistedSpecialPage {
	var $activeTab;
	var $classWatchlist;
	var $loggedIn;

	private $defaultView;
	private $feedSelected;

	function __construct() {
		parent::__construct( 'WikiActivity', '' /* no restriction */, true /* listed */ );
	}

	function execute( $par ) {
		wfProfileIn( __METHOD__ );
		global $wgOut, $wgUser, $wgBlankImgUrl, $wgEditPageFrameOptions;

		$wgEditPageFrameOptions = "SAMEORIGIN";
		$this->setHeaders();

		// not available for skins different than Oasis
		if ( !F::app()->checkSkin( 'oasis' ) ) {
			$wgOut->addWikiMsg( 'myhome-switch-to-monaco' );
			wfProfileOut( __METHOD__ );
			return;
		}

		// choose default view (RT #68074)
		if ( $wgUser->isLoggedIn() ) {
			$this->defaultView = MyHome::getDefaultView();
			if ( $par == '' ) {
				$par = $this->defaultView;
			}
		} else {
			$this->defaultView = false;
		}

		// watchlist feed
		if ( $par == 'watchlist' ) {
			$this->classWatchlist = "selected";

			// not available for anons
			if ( $wgUser->isAnon() ) {
				if ( get_class( RequestContext::getMain()->getSkin() ) == 'SkinOasis' ) {
					$wgOut->wrapWikiMsg( '<div class="latest-activity-watchlist-login" >$1</div>', [ 'oasis-activity-watchlist-login', wfGetReturntoParam() ] );
				} else {
					$wgOut->wrapWikiMsg( '<div id="myhome-log-in">$1</div>', [ 'myhome-log-in', wfGetReturntoParam() ] );
				}

				//oasis-activity-watchlist-login
				// RT #23970
				$wgOut->addInlineScript( <<<JS
$(function() {
	$('#myhome-log-in').find('a').click(function(ev) {
		openLogin(ev);
	});
});
JS
				);
				wfProfileOut( __METHOD__ );
				return;
			} else {
				$this->feedSelected = 'watchlist';
				$feedProxy = new WatchlistFeedAPIProxy();
				$feedRenderer = new WatchlistFeedRenderer();
			}
		} else {
			//for example: wiki-domain.com/wiki/Special:WikiActivity
			$this->feedSelected = 'activity';
			$feedProxy = new ActivityFeedAPIProxy();
			$feedRenderer = new ActivityFeedRenderer();
		}

		$feedProvider = new DataFeedProvider( $feedProxy );

		global $wgJsMimeType, $wgExtensionsPath;
		$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/MyHome/WikiActivity.js\"></script>\n" );
		$wgOut->addExtensionStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/MyHome/oasis.scss' ) );

		wfRunHooks( 'SpecialWikiActivityExecute', [ $wgOut, $wgUser ] );

		$data = $feedProvider->get( 50 );  // this breaks when set to 60...

		// FIXME: do it in AchievementsII extension
		global $wgEnableAchievementsInActivityFeed, $wgEnableAchievementsExt;
		if ( ( !empty( $wgEnableAchievementsInActivityFeed ) ) && ( !empty( $wgEnableAchievementsExt ) ) ) {
			$wgOut->addExtensionStyle( "{$wgExtensionsPath}/wikia/AchievementsII/css/achievements_sidebar.css" );
		}

		// use message from MyHome as special page title
		$wgOut->setPageTitle( wfMsg( 'oasis-activity-header' ) );

		$template = new EasyTemplate( __DIR__ . '/templates' );
		$template->set( 'data', $data['results'] );

		$showMore = isset( $data['query-continue'] );
		if ( $showMore ) {
			$template->set( 'query_continue', $data['query-continue'] );
		}
		if ( empty( $data['results'] ) ) {
			$template->set( 'emptyMessage', wfMsgExt( "myhome-activity-feed-empty", [ 'parse' ] ) );
		}

		$template->set_vars( [
			'showMore' => $showMore,
			'type' => $this->feedSelected,
			'wgBlankImgUrl' => $wgBlankImgUrl,
		] );

		$wgOut->addHTML( $template->render( 'activityfeed.oasis' ) );

		// page header: replace subtitle with navigation
		global $wgHooks;
		$wgHooks['PageHeaderIndexAfterExecute'][] = [ $this, 'addNavigation' ];

		if ( $wgUser->isAnon() ) {
			$this->getOutput()->setSquidMaxage( 3600 ); // 1 hour
			$this->getOutput()->tagWithSurrogateKeys(
				MyHome::getWikiActivitySurrogateKey()
			);
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Replaces page header's subtitle with navigation for WikiActivity
	 *
	 * @author macbre
	 */
	function addNavigation( &$moduleObject, &$params ) {
		global $wgUser;
		wfProfileIn( __METHOD__ );

		$template = new EasyTemplate( __DIR__ . '/templates' );

		// RT #68074: show default view checkbox for logged-in users only
		$showDefaultViewSwitch = $wgUser->isLoggedIn() && ( $this->defaultView != $this->feedSelected );

		$template->set_vars( [
			'classWatchlist' => $this->classWatchlist,
			'defaultView' => $this->defaultView,
			'loggedIn' => $wgUser->isLoggedIn(),
			'showDefaultViewSwitch' => $showDefaultViewSwitch,
			'type' => $this->feedSelected,
		] );

		// replace subtitle with navigation for WikiActivity
		$moduleObject->pageSubtitle = $template->render( 'navigation.oasis' );

		wfProfileOut( __METHOD__ );
		return true;
	}
}
