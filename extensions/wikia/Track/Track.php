<?php
global $wgHooks, $wgExtensionCredits;

$wgExtensionCredits[ 'other' ][] = array(
	'name' => 'Track',
	'author' => 'Garth Webb',
	'description' => 'A class to help track events and pageviews for wikia'
);

$wgHooks[ 'MakeGlobalVariablesScript' ][] = 'Track::addGlobalVars';
$wgHooks[ 'WikiaSkinTopScripts' ][] = 'Track::onWikiaSkinTopScripts';

class Track {
	const BASE_URL = 'https://beacon.wikia-services.com/__track';
	const GA_URL = 'https://www.google-analytics.com';
	const GA_VERSION = 1;

	private static function getURL( $type = null, $name = null, $param = null, $for_html = true ) {
		global $wgStyleVersion, $wgCityId, $wgContLanguageCode, $wgDBname, $wgDBcluster, $wgUser, $wgArticle, $wgTitle, $wgAdServerTest;

		$sep = $for_html ? '&amp;' : '&';

		$url = Track::BASE_URL .
			   ( $type ? "/$type" : '' ) .
			   ( $name ? "/$name" : '' ) .
			   '?' .
			   'cb=' . $wgStyleVersion . $sep .
			   'c=' . $wgCityId . $sep .
			   'lc=' . $wgContLanguageCode . $sep .
			   'lid=' . WikiFactory::LangCodeToId( $wgContLanguageCode ) . $sep .
			   'x=' . $wgDBname . $sep .
			   'y=' . $wgDBcluster . $sep .
			   'u=' . $wgUser->getID() . $sep .
			   'a=' . ( is_object( $wgArticle ) ? $wgArticle->getID() : null ) . $sep .
			   's=' . RequestContext::getMain()->getSkin()->getSkinName() . $sep .
			   ( $wgTitle && !is_object( $wgArticle ) ? $sep . 'pg=' . urlencode( $wgTitle->getPrefixedDBkey() ) : '' ) .
			   ( $wgTitle ? $sep . 'n=' . $wgTitle->getNamespace() : '' ) .
			   ( !empty( $wgAdServerTest ) ? $sep . 'db_test=1' : '' );

		// Handle any parameters passed to us
		if ( $param ) {
			foreach ( $param as $key => $val ) {
				$url .= $sep . urlencode( $key ) . '=' . urlencode( $val );
			}
		}

		return $url;
	}

	private static function getGAURL( $type, $category, $action, $label, $value, $tid, array $extraParams = [ ] ) {
		global $wgTitle, $wgContLanguageCode, $wgDBname, $wgUser, $wgCityId, $wgGAUserIdSalt;

		$skinName = RequestContext::getMain()->getSkin()->getSkinName();
		$adContext = ( new AdEngine2ContextService() )->getContext( $wgTitle, $skinName );
		$hubFactory = WikiFactoryHub::getInstance();

		$params = [
			'v' => static::GA_VERSION,
			'ds' => 'backend',
			't' => $type,
			'ni' => 1,
			'dl' => $wgTitle->getFullURL(),
			'ul' => $wgContLanguageCode,
			'de' => 'UTF-8',
			'dt' => $wgTitle->getText(),
			'ec' => $category,
			'ea' => $action,
			'el' => $label,
			'ev' => $value,
			'_utma' => $_COOKIE[ '__utma' ] ?? '',
			'_utmz' => $_COOKIE[ '__utmz' ] ?? '',
			'cid' => $_COOKIE[ '_ga' ] ? explode( ".", $_COOKIE[ '_ga' ] )[ 2 ] : uniqid(),
			'tid' => $tid,
			// custom dimensions
			'cd1' => $wgDBname,
			'cd2' => $wgContLanguageCode,
			'cd3' => implode( ',', $hubFactory->getWikiVertical( $wgCityId ) ),
			'cd4' => $skinName,
			'cd5' => $wgUser->isAnon() ? 'anon' : 'user',
			'cd8' => WikiaPageType::getPageType(),
			'cd9' => $wgCityId,
			'cd13' => AdTargeting::getEsrbRating(),
			'cd14' => isset( $adContext[ 'opts' ][ 'showAds' ] ) ? 'Yes' : 'No',
			'cd15' => WikiaPageType::isCorporatePage(),
			'cd17' => implode( ',', $hubFactory->getWikiVertical( $wgCityId ) ),
			'cd18' => implode( ',', $hubFactory->getWikiCategories( $wgCityId ) ),
			'cd19' => WikiaPageType::getArticleType(),
			'cd21' => $wgTitle->getArticleID(),
			'cd23' => $wgUser->isSpecificPowerUser( Wikia\PowerUser\PowerUser::TYPE_FREQUENT ) ? 'Yes' : 'No',
			'cd24' => $wgUser->isSpecificPowerUser( Wikia\PowerUser\PowerUser::TYPE_LIFETIME ) ? 'Yes' : 'No',
			'cd25' => $wgTitle->getNamespace(),
		];
		if ( !$wgUser->isAnon() ) {
			$params[ 'uid' ] = md5( $wgUser->getId() . $wgGAUserIdSalt );
		}
		$params = array_merge( $params, $extraParams );

		return static::GA_URL . '/collect?' . http_build_query( $params );
	}

	private static function getGATrackingIds() {
		global $wgDevelEnvironment, $wgStagingEnvironment;

		$tids = [ $wgDevelEnvironment || $wgStagingEnvironment ? 'UA-32129070-2' : 'UA-32129070-1' ];

		return $tids;
	}

	private static function getViewJS( $param = null ) {
		global $wgDevelEnvironment;

		// Fake beacon and varnishTime values for development environment
		if ( !empty( $wgDevelEnvironment ) ) {
			$script = '<script>var beacon_id = "ThisIsFake", varnishTime = "' . date( "r" ) . '";</script>';

		} else {
			$url = Track::getURL( 'view', '', $param, false );

			$script = ( new Wikia\Template\MustacheEngine )
				->setPrefix( dirname( __FILE__ ) . '/templates' )
				->setData(['url' => $url])
				->render('track.mustache');
		}

		return $script;
	}

	public static function event( $event_type, $param = null ) {
		if ( !self::shouldTrackEvents() ) {
			return false;
		}

		wfProfileIn( __METHOD__ );

		$backtrace = debug_backtrace();
		$class = $backtrace[ 1 ][ 'class' ];
		$func = $backtrace[ 1 ][ 'function' ];
		$line = !empty( $backtrace[ 1 ][ 'line' ] ) ? $backtrace[ 1 ][ 'line' ] : '?';
		$param[ 'caller' ] = "$class::$func:$line";

		$url = Track::getURL( 'special', urlencode( $event_type ), $param, false );
		if ( ExternalHttp::get( $url ) !== false ) {
			wfProfileOut( __METHOD__ );
			\Wikia\Logger\WikiaLogger::instance()->info( 'Internal tracking sent', [ 'url' => $url ] );
			return true;
		} else {
			wfProfileOut( __METHOD__ );
			\Wikia\Logger\WikiaLogger::instance()->error( 'Internal tracking failed', [ 'url' => $url ] );
			return false;
		}
	}

	public static function eventGA( $category, $action, $label, $value = 1, array $params = [ ] ) {
		if ( !self::shouldTrackEvents() ) {
			return false;
		}

		foreach ( static::getGATrackingIds() as $tid ) {
			$url = Track::getGAURL( 'event', $category, $action, $label, $value, $tid, $params );
			static::sendTracking( $url );
		}
	}

	private static function sendTracking( $url ) {
		if ( ExternalHttp::post( $url ) !== false ) {
			wfProfileOut( __METHOD__ );
			\Wikia\Logger\WikiaLogger::instance()->info( 'GA tracking sent', [ 'url' => $url ] );
			return true;
		} else {
			wfProfileOut( __METHOD__ );
			\Wikia\Logger\WikiaLogger::instance()->error( 'GA tracking failed', [ 'url' => $url ] );
			return false;
		}
	}

	/**
	 * Check whether events should be tracked
	 *
	 * @return bool
	 */
	protected static function shouldTrackEvents() {
		// Check request headers to make sure this is not a mirrored
		// request, which could result in duplicate tracking events
		return F::app()->wg->request->isWikiaInternalRequest() === false;
	}

	/**
	 * @static
	 * @param array $vars
	 * @return bool
	 */
	public static function addGlobalVars( Array &$vars ) {
		global $wgUser;

		if ( $wgUser->isLoggedIn() ) {
			$vars[ 'wgTrackID' ] = $wgUser->getId();
		}
		return true;
	}

	public static function onWikiaSkinTopScripts( &$vars, &$scripts ) {
		global $wgCookieDomain, $wgCookiePath;

		$vars['wgCookieDomain'] = $wgCookieDomain;
		$vars['wgCookiePath'] = $wgCookiePath;

		$scripts .= Track::getViewJS();
		return true;
	}
}
