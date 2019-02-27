<?php

use Wikia\Factory\ServiceFactory;
use \Wikia\Service\User\Auth\CookieHelper;

class ApiService {

	/**
	 * string constant for mediawiki api endpoint
	 * @var string
	 */
	const API = 'api.php';

	/**
	 * string constant for wikia api endpoint
	 * @var string
	 */
	const WIKIA = 'wikia.php';

	/**
	 * Simple wrapper for calling MW API
	 *
	 * @param array $params
	 *
	 * @return array|bool
	 */
	static function call( Array $params ) {
		$res = false;

		try {
			$api = new ApiMain( new FauxRequest( $params ) );
			$api->execute();
			$res = $api->getResultData();
		} catch ( Exception $e ) {
		};

		return $res;
	}

	/**
	 * Do cross-wiki API call
	 *
	 * @param string $dbName database name
	 * @param array $params API query parameters
	 * @param string $endpoint (api.php or wikia.php, generally)
	 * @param boolean $setUser
	 * @param bool $internal sets requests as internal
	 *
	 * @return mixed API response
	 */
	static function foreignCall( string $dbName, array $params, string $endpoint = self::API, bool $setUser = false, bool $internal = false ) {
		// Note - this won't work the city_url contains url, as it uses http proxy to make the call.
		// This should be fixed in PLATFORM-3486
		$cityUrl = WikiFactory::DBtoUrl( $dbName );

		// If city url is empty, this would make a request to the current host.
		if ( empty( $cityUrl ) ) {
			return false;
		}

		$options = [ 'headers' => [] ];
		if ( startsWith( $cityUrl, "https://" ) ) {
			$cityUrl = wfHttpsToHttp( $cityUrl );
			$options[ 'headers' ][ 'Fastly-SSL' ] = 1;
		}

		$staging = wfGetStagingEnvForUrl( $cityUrl );
		if ( $staging ) {
			# TODO: remove when we're fully migrated to k8s
			$options[ 'headers' ][ 'X-Staging' ] = $staging;
		}

		// request JSON format of API response
		$params[ 'format' ] = 'json';

		$url = "{$cityUrl}/{$endpoint}?" . http_build_query( $params );
		wfDebug( __METHOD__ . ": {$url}\n" );

		if ( $setUser ) {
			$options = array_merge( $options, self::loginAsUser() );
		}

		if ( $internal ) {
			$options['external'] = 0;
			$options['headers'][WebRequest::WIKIA_INTERNAL_REQUEST_HEADER] = 1;
			$options['headers'][WebRequest::MW_AUTH_OK_HEADER] = 1;
		}

		// send request and parse response
		$resp = Http::get( $url, 'default', $options );

		if ( $resp === false ) {
			wfDebug( __METHOD__ . ": failed!\n" );
			$res = false;
		} else {
			$res = json_decode( $resp, true /* $assoc */ );
		}

		return $res;
	}

	/**
	 * get user data
	 * @return array $options
	 */
	public static function loginAsUser() {
		global $wgCookiePrefix;
		$context = RequestContext::getMain();

		$options = [];
		$user = $context->getUser();
		if ( !$user->isLoggedIn() ) {
			return $options;
		}

		$params = [
			'UserID' => $user->getId(),
			'UserName' => $user->getName(),
			'Token' => $user->getToken(),
		];

		$cookie = '';
		foreach ( $params as $key => $value ) {
			$cookie .= $wgCookiePrefix . $key . '=' . $value . ';';
		}

		$cookieHelper = ServiceFactory::instance()->heliosFactory()->cookieHelper();

		$token = $cookieHelper->getAccessToken( $context->getRequest() );
		if ( !empty( $token ) ) {
			$cookie .= CookieHelper::ACCESS_TOKEN_COOKIE_NAME . '=' . $token . ';';
		}
		$options[ 'curlOptions' ] = [ CURLOPT_COOKIE => $cookie ];

		return $options;
	}

}
