<?php

namespace Wikia\Tasks\Tasks;

use Wikia\Util\Assert;

class MaintenanceTask extends BaseTask {

	/**
	 * @param string $script
	 * @throws \Wikia\Util\AssertionException
	 * @return bool
	 */
	public static function validatePath( string $script ) : bool {
		global $IP;

		$script = realpath( $IP. '/' . $script );

		Assert::true( endsWith( $script, '.php' ), '$script must end with .php' );
		Assert::true( startsWith( $script, $IP ), 'Script path must be relative to app\'s root' );

		return true;
	}

	/**
	 * @param string $script path to PHP script to be executed (relative to app's root!)
	 * @param string $parameters optional script parameters
	 * @throws \Exception
	 */
	public function run( string $script, string $parameters = '' ) {
		global $IP, $wgCityId;

		self::validatePath( $script );

		$exitStatus = 0;
		wfShellExec(
			sprintf(
				'SERVER_ID=%d php %s %s',
				$wgCityId,
				realpath( $IP. '/' . $script ),
				$parameters
			),
			$exitStatus
		);

		if ( $exitStatus > 0 ) {
			throw new \Exception(
				sprintf( 'wfShellExec: %s failed with exit code %d', $script, $exitStatus ) );
		}
	}
}
