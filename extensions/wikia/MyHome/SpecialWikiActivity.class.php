<?php

class SpecialWikiActivity extends UnlistedSpecialPage {
	var $activeTab;
	var $classWatchlist;
	var $loggedIn;

	private $defaultView;
	private $feedSelected;

	/** @var WikiaApp $app */
	private $app;

	/** @var WikiaGlobalRegistry $wg */
	private $wg;

	public function __construct() {
		parent::__construct( 'WikiActivity', '' /* no restriction */, true /* listed */ );
		$this->app = F::app();
		$this->wg = $this->app->wg;
	}

	public function execute( $par ) {
		wfProfileIn( __METHOD__ );

		$this->wg->EditPageFrameOptions = "SAMEORIGIN";
		$this->setHeaders();

		// not available for skins different than Oasis
		if ( !$this->app->checkSkin( 'oasis' ) ) {
			$this->getOutput()->addWikiMsg( 'myhome-switch-to-monaco' );
			wfProfileOut( __METHOD__ );
			return;
		}

		$user = $this->getUser();
		$out = $this->getOutput();

		// choose default view (RT #68074)
		if ( $user->isLoggedIn() ) {
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
			if ( $user->isAnon() ) {
				if ( get_class( RequestContext::getMain()->getSkin() ) == 'SkinOasis' ) {
					$out->wrapWikiMsg( '<div class="latest-activity-watchlist-login" >$1</div>', [ 'oasis-activity-watchlist-login', wfGetReturntoParam() ] );
				} else {
					$out->wrapWikiMsg( '<div id="myhome-log-in">$1</div>', [ 'myhome-log-in', wfGetReturntoParam() ] );
				}

				//oasis-activity-watchlist-login
				// RT #23970
				$out->addInlineScript( <<<JS
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

		$out->addScript( "<script type=\"{$this->wg->JsMimeType}\" src=\"{$this->wg->ExtensionsPath}/wikia/MyHome/WikiActivity.js\"></script>\n" );
		$out->addExtensionStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/MyHome/oasis.scss' ) );

		wfRunHooks( 'SpecialWikiActivityExecute', [ $out, $user ] );

		$data = $feedProvider->get( 50 );  // this breaks when set to 60...

		// FIXME: do it in AchievementsII extension
		if ( ( !empty( $this->wg->EnableAchievementsInActivityFeed ) ) && ( !empty( $this->wg->EnableAchievementsExt ) ) ) {
			$out->addExtensionStyle( "{$this->wg->ExtensionsPath}/wikia/AchievementsII/css/achievements_sidebar.css" );
		}

		// use message from MyHome as special page title
		$out->setPageTitle( $this->msg( 'oasis-activity-header' ) );

		$template = new EasyTemplate( __DIR__ . '/templates' );
		$template->set( 'data', $data['results'] );

		$showMore = isset( $data['query-continue'] );
		if ( $showMore ) {
			$template->set( 'query_continue', $data['query-continue'] );
		}
		if ( empty( $data['results'] ) ) {
			$template->set( 'emptyMessage', $this->msg( 'myhome-activity-feed-empty' )->parse() );
		}

		$template->set_vars( [
			'showMore' => $showMore,
			'type' => $this->feedSelected,
			'wgBlankImgUrl' => $this->wg->BlankImgUrl,
		] );

		$out->addHTML( $template->render( 'activityfeed.oasis' ) );

		// page header: replace subtitle with navigation
		global $wgHooks;
		$wgHooks['PageHeaderIndexAfterExecute'][] = [ $this, 'addNavigation' ];

		if ( $user->isAnon() ) {
			$out->setSquidMaxage( 3600 ); // 1 hour
			$out->getOutput()->tagWithSurrogateKeys(
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
	public function addNavigation( &$moduleObject, &$params ) {
		wfProfileIn( __METHOD__ );

		$template = new EasyTemplate( __DIR__ . '/templates' );
		$isLoggedIn = $this->getUser()->isLoggedIn();

		// RT #68074: show default view checkbox for logged-in users only
		$showDefaultViewSwitch = $isLoggedIn && ( $this->defaultView != $this->feedSelected );

		$template->set_vars( [
			'classWatchlist' => $this->classWatchlist,
			'defaultView' => $this->defaultView,
			'loggedIn' => $isLoggedIn,
			'showDefaultViewSwitch' => $showDefaultViewSwitch,
			'type' => $this->feedSelected,
			'typeMessage' => FeedRenderer::getTypeMessage( $this->feedSelected )->plain(), // only used as message parameter
		] );

		// replace subtitle with navigation for WikiActivity
		$moduleObject->pageSubtitle = $template->render( 'navigation.oasis' );

		wfProfileOut( __METHOD__ );
		return true;
	}
}
