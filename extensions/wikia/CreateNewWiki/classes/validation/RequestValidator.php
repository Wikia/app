<?php
namespace Wikia\CreateNewWiki;

use TorBlock;
use WebRequest;

class RequestValidator {
	/**
	 * @param WebRequest $request
	 * @return bool
	 * @throws MissingParamsException
	 */
	public function assertValidParams( WebRequest $request ): bool {
		$params = $request->getArray( 'data' );

		if (
			empty( $params ) ||
			empty( $params['wName'] ) ||
			empty( $params['wDomain'] ) ||
			empty( $params['wLanguage'] ) ||
			( !isset( $params['wVertical'] ) || $params['wVertical'] === '-1' )
		) {
			throw new MissingParamsException();
		}

		return true;
	}

	/**
	 * @param WebRequest $request
	 * @return bool
	 * @throws TorNodeException
	 */
	public function assertNotTorNode( WebRequest $request ): bool {
		global $wgEnableTorBlockExt;

		if ( $wgEnableTorBlockExt ) {
			$ipAddress = $request->getIP();

			if ( TorBlock::isExitNode( $ipAddress ) ) {
				throw new TorNodeException();
			}
		}

		return true;
	}
}
