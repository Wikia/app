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

		$scriptRealPath = realpath( $IP. '/' . $script );
		$logContext = [
			'IP' => $IP,
			'script' => $script,
			'scriptRealPath' => $scriptRealPath
		];

		Assert::true( file_exists( $scriptRealPath ), 'Provided script does not exist', $logContext );
		Assert::true( endsWith( $scriptRealPath, '.php' ), '$script must end with .php', $logContext );
		Assert::true( startsWith( $scriptRealPath, $IP ), 'Script path must be relative to app\'s root', $logContext );

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
		$output = wfShellExec(
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

		$this->info( __METHOD__ . '::output', [
			'output' => $output,
			'script' => $script
		] );
	}
}
