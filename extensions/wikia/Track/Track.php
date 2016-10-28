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
	const BASE_URL = 'http://a.wikia-beacon.com/__track';
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
			   'beacon=' . wfGetBeaconId() .
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
		global $wgDevelEnvironment, $wgStagingEnvironment, $wgIsGASpecialWiki, $wgUser;

		$tids = [ ];
		// 10% sampling for general account
		if ( mt_rand( 0, 9 ) === 0 ) {
			$tids[] = $wgDevelEnvironment || $wgStagingEnvironment ? 'UA-32129070-2' : 'UA-32129070-1';
		}
		if ( $wgIsGASpecialWiki ) {
			$tids[] = $wgDevelEnvironment || $wgStagingEnvironment ? 'UA-32132943-2' : 'UA-32132943-1';
		}
		if ( !$wgUser->isAnon() ) {
			$tids[] = $wgDevelEnvironment || $wgStagingEnvironment ? 'UA-32132943-8' : 'UA-32132943-7';
		}

		return $tids;
	}

	private static function getViewJS( $param = null ) {
		global $wgDevelEnvironment;

		// Fake beacon and varnishTime values for development environment
		if ( !empty( $wgDevelEnvironment ) ) {
			$script = '<script>var beacon_id = "ThisIsFake", varnishTime = "' . date( "r" ) . '";</script>';

		} else {
			$url = Track::getURL( 'view', '', $param );

			$script = <<<SCRIPT1
<!-- Wikia Beacon Tracking -->
<noscript><img src="$url&amp;nojs=1" width="1" height="1" border="0" alt="" /></noscript>
<script>
(function() {
	var result = RegExp("wikia_beacon_id=([A-Za-z0-9_-]{10})").exec(document.cookie);
	if(result) {
		window.beacon_id = result[1];
	} else {
		// something went terribly wrong
		document.write('<img src="http://logs-01.loggly.com/inputs/88a88e56-77c6-49cc-af41-6f44f83fe7fe.gif?message=wikia_beacon_id%20is%20empty" style="position:absolute;top:-1000px" />');
	}

	var utma = RegExp("__utma=([0-9\.]+)").exec(document.cookie);
	var utmb = RegExp("__utmb=([0-9\.]+)").exec(document.cookie);

	var trackUrl = "$url" + ((typeof document.referrer != "undefined") ? "&amp;r=" + escape(document.referrer) : "") + "&amp;rand=" + (new Date).valueOf() + (window.beacon_id ? "&amp;beacon=" + window.beacon_id : "") + (utma && utma[1] ? "&amp;utma=" + utma[1] : "") + (utmb && utmb[1] ? "&amp;utmb=" + utmb[1] : "");
	document.write('<'+'script type="text/javascript" src="' + trackUrl + '"><'+'/script>');
})();
</script>
SCRIPT1;
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
		$scripts .= Track::getViewJS();
		return true;
	}
}
