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
			}
		} else {
			//for example: wiki-domain.com/wiki/Special:WikiActivity
			$this->feedSelected = 'activity';
			$feedProxy = new ActivityFeedAPIProxy();
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

		$template = new EasyTemplate( dirname( __FILE__ ) . '/templates' );
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
		$wgHooks['AfterPageHeaderPageSubtitle'][] = [ $this, 'addNavigationToPageHeader' ];
		$wgHooks['AfterPageHeaderSubtitle'][] = [ $this, 'addCheckboxToPageHeader' ];

		if ( $wgUser->isAnon() ) {
			$this->getOutput()->setSquidMaxage( 3600 ); // 1 hour
			$this->getOutput()->tagWithSurrogateKeys(
				MyHome::getWikiActivitySurrogateKey()
			);
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Adds navigation for WikiActivity to page header's page subtitle
	 *
	 * @param array $pageSubtitle
	 *
	 * @return bool
	 */
	function addNavigationToPageHeader( &$pageSubtitle ) {
		$wgUser = RequestContext::getMain()->getUser();

		if ( $wgUser->isLoggedIn() ) {
			if ( $this->feedSelected === 'watchlist' ) {
				array_push(
					$pageSubtitle,
					Wikia::specialPageLink(
						'WikiActivity/activity',
						'myhome-activity-feed'
					)
				);
			} else {
				array_push(
					$pageSubtitle,
					Wikia::specialPageLink(
						'WikiActivity/watchlist',
						'oasis-button-wiki-activity-watchlist'
					)
				);
			}
		}

		array_push(
			$pageSubtitle,
			Wikia::specialPageLink(
				'RecentChanges',
				'oasis-button-wiki-activity-feed'
			)
		);

		return true;
	}

	/**
	 * Adds checkbox to page header's subtitle
	 *
	 * @param array $subtitle
	 *
	 * @return bool
	 */
	function addCheckboxToPageHeader( &$subtitle ) {
		$wgUser = RequestContext::getMain()->getUser();

		// RT #68074: show default view checkbox for logged-in users only
		if ( $wgUser->isLoggedIn() && ( $this->defaultView != $this->feedSelected ) ) {
			$template = new EasyTemplate( __DIR__ . '/templates' );
			$template->set_vars( [
				'type' => $this->feedSelected
			] );

			array_push( $subtitle, $template->render( 'page.header.checkbox' ) );
		}

		return true;
	}
}
