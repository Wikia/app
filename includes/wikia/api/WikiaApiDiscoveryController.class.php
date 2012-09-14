<?php
/**
 * Wikia API discovery tool
 */

class WikiaApiDiscoveryController extends WikiaApiController {
	/**
	 * Lists all the registered API controllers
	 *
	 * @responseParam array A list of controllers' names
	 */
	public function listControllers() {
		$controllers = array();

		foreach ( array_keys( $this->wg->WikiaApiControllers ) as $c ) {
			$rc = new ReflectionClass( $c );

			if ( $rc ) {
				$comment = $rc->getDocComment();

				if ( $comment ) {
					$comment = substr( $comment, 3, -2 );
					$comment = preg_replace( '~^\s*\*\s*~m', '', $comment );
				} else {
					$comment = null;
				}

				$controllers[] = array(
					'name' => $c,
					'description' => $comment,
					'referenceUrl' => "wikia.php?controller={$c}&method=help"
				);
			}
		}

		$this->response->setVal( 'controllers', $controllers );
	}
}