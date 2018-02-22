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
	 *
	 * @return mixed API response
	 */
	static function foreignCall( string $dbName, array $params, string $endpoint = self::API, bool $setUser = false ) {
		$hostName = self::getHostByDbName( $dbName );

		// If hostName is empty, this would make a request to the current host.
		if ( empty( $hostName ) ) {
			return false;
		}

		// request JSON format of API response
		$params[ 'format' ] = 'json';

		$url = "{$hostName}/{$endpoint}?" . http_build_query( $params );
		wfDebug( __METHOD__ . ": {$url}\n" );

		$options = [];
		if ( $setUser ) {
			$options = self::loginAsUser();
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
	 * Get domain for a wiki using given database name
	 *
	 * @param string $dbName database name
	 *
	 * @return string HTTP domain
	 */
	private static function getHostByDbName( string $dbName ): string {
		global $wgDevelEnvironment, $wgDevDomain;

		$hostName = WikiFactory::DBtoUrl( $dbName );

		if ( !empty( $wgDevelEnvironment ) ) {
			if ( strpos( $hostName, 'wikia.com' ) ) {
				$hostName = str_replace( 'wikia.com', $wgDevDomain, $hostName );
			} else {
				$hostName = WikiFactory::getLocalEnvURL( $hostName );
			}
		}

		return rtrim( $hostName, '/' );
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
