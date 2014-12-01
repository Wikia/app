<?php
class RSHiscores {
	public static $ch = NULL;
	public static $cache = array();
	public static $times = 0;

	/**
	 * Setup parser function
	 *
	 * @param $parser Parser
	 * @return bool
	 */
	public static function register( &$parser ) {
		$parser->setFunctionHook( 'hs', 'RSHiscores::renderHiscores' );
		return true;
	}

	/**
	 * Retrieve the raw hiscores data from RuneScape.
	 *
	 * @param string $hs Which hiscores API to retrieve from.
	 * @param string $player Player's display name.
	 * @return string Raw hiscores data
	 */
	private static function retrieveHiscores( $hs, $player ) {
		global $wgHTTPTimeout;

		if ( $hs == 'rs3' ) {
			$url = 'http://services.runescape.com/m=hiscore/index_lite.ws?player=';
		} elseif ( $hs == 'osrs' ) {
			$url = 'http://services.runescape.com/m=hiscore_oldschool/index_lite.ws?player=';
		} else {
			// Unknown or unsupported hiscores API.
			return 'H';
		}

		// Setup the cURL handler if not previously initialised.
		if ( self::$ch == NULL ) {
			self::$ch = curl_init();
			curl_setopt( self::$ch, CURLOPT_TIMEOUT, $wgHTTPTimeout );
			curl_setopt( self::$ch, CURLOPT_RETURNTRANSFER, TRUE );
		}

		curl_setopt( self::$ch, CURLOPT_URL, $url . urlencode( $player ) );

		if ( $data = curl_exec( self::$ch ) ) {
			$status = curl_getinfo( self::$ch, CURLINFO_HTTP_CODE );

			if ( $status == 200 ) {
				return $data;
			} elseif ( $status == 404 ) {
				// The player could not be found.
				return 'B';
			}

			// An unexpected HTTP status code was returned, so report it.
			return 'D'.$status;
		}

		// An unexpected curl error occurred, so report it.
		$errno = curl_errno ( self::$ch );

		if( $errno ) {
			return 'C'.$errno;
		}

		// Should be impossible, but odd things happen, so handle it.
		return 'C';
	}

	/**
	 * Parse the hiscores data.
	 *
	 * @param string $data
	 * @param int $skill Index representing the requested skill.
	 * @param int $type Index representing the requested type of data for the given skill.
	 * @return string Requested portion of the hiscores data.
	 */
	private static function parseHiscores( $data, $skill, $type ) {
		/*
		 * Check to see if an error has already occurred.
		 * If so, return the error now, otherwise the wrong error will be
		 * returned. Some errors have int statuses, so only check first char.
		 */
		if ( ctype_alpha ( $data{0} ) ) {
			return $data;
		}

		$data = explode( "\n", $data, $skill + 2 );

		if ( !array_key_exists( $skill, $data ) ) {
			// The skill does not exist.
			return 'F';
		}

		$data = explode( ',', $data[$skill], $type + 2 );

		if ( !array_key_exists( $type, $data ) ) {
			// The type does not exist.
			return 'G';
		}

		return $data[$type];
	}

	/**
	 * <doc>
	 *
	 * @param $parser Parser
	 * @param string $hs Which hiscores API to use.
	 * @param string $player Player's display name. Can not be empty.
	 * @param int $skill Index representing the requested skill. Leave as -1 for requesting the raw data.
	 * @param int $type Index representing the requested type of data for the given skill.
	 * @return string
	 */
	public static function renderHiscores( &$parser, $hs = 'rs3', $player = '', $skill = -1, $type = 1 ) {
		global $wgRSLimit;

		if ( $hs != 'rs3' && $hs != 'osrs' ) {
			// RSHiscores 3.0 breaks backward-compatibility. Add a tracking category to allow fixing existing usage.
			$parser->addTrackingCategory( 'rshiscores-error-category' );
			// Unknown or unsupported hiscores API.
			return 'H';
		}

		$player = trim( $player );

		if( $player == '' ) {
			// No name was entered.
			return 'A';

		} elseif ( array_key_exists( $player, self::$cache ) && array_key_exists( $player, self::$cache[$hs] ) ) {
			// Get the hiscores data from the cache.
			$data = self::$cache[$hs][$player];

		} elseif ( self::$times < $wgRSLimit || $wgRSLimit == 0 ) {
			// Update the name limit counter.
			self::$times++;

			// Get the hiscores data from the site.
			$data = self::retrieveHiscores( $hs, $player );

			// Add the hiscores data to the cache.
			self::$cache[$hs][$player] = $data;

		} else {
			// The name limit set by $wgRSLimit was reached.
			return 'E';
		}

		/*
		 * Finally, return the raw string for use in JS calcs,
		 * or if requested, parse the hiscores data.
		 */
		if ( $skill < 0 ) {
			return $data;
		} else {
			return self::parseHiscores( $data, $skill, $type );
		}
	}
}