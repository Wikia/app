<?php
use \Wikia\Service\User\Auth\HeliosCookieHelper;

class ApiService extends Service {

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
		wfProfileIn(__METHOD__);

		$res = false;

		try {
			$api = new ApiMain( new FauxRequest( $params ) );
			$api->execute();
			$res = $api->getResultData();
		} catch ( Exception $e ) {};

		wfProfileOut( __METHOD__ );

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
	static function foreignCall( $dbName, Array $params, $endpoint = self::API, $setUser = false ) {
		wfProfileIn(__METHOD__);

		$hostName = self::getHostByDbName( $dbName );

		// If hostName is empty, this would make a request to the current host.
		if ( empty( $hostName ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		// request JSON format of API response
		$params['format'] = 'json';

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

		wfProfileOut( __METHOD__ );

		return $res;
	}

	/**
	 * Get domain for a wiki using given database name
	 *
	 * @param string $dbName database name
	 *
	 * @return string HTTP domain
	 */
	private static function getHostByDbName( $dbName ) {
		global $wgDevelEnvironment, $wgDevelEnvironmentName;

		$cityId = WikiFactory::DBtoID( $dbName );
		$hostName = WikiFactory::getVarValueByName( 'wgServer', $cityId );

		if ( !empty( $wgDevelEnvironment ) ) {
			if ( strpos( $hostName, "wikia.com" ) ) {
				$hostName = str_replace( "wikia.com", "{$wgDevelEnvironmentName}.wikia-dev.com", $hostName );
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
		$app = F::app();

		$options = array();
		if ( $app->wg->User->isLoggedIn() ) {
			$user = $app->wg->User;
		} else {
			return $options;
		}

		$params = array(
			'UserID' => $user->getId(),
			'UserName' => $user->getName(),
			'Token' => $user->getToken(),
		);

		$cookie = '';
		foreach ( $params as $key => $value ) {
			$cookie .= $app->wg->CookiePrefix.$key.'='.$value.';';
		}

		if ( $app->wg->EnableHeliosExt ) {
			$token = \Wikia\Helios\User::getAccessToken( $app->wg->Request );
			if ( !empty( $token ) ) {
				$cookie .= HeliosCookieHelper::ACCESS_TOKEN_COOKIE_NAME . "=" . $token . ";";
			}
		}
		$options['curlOptions'] = array( CURLOPT_COOKIE => $cookie );

		return $options;
	}

}
