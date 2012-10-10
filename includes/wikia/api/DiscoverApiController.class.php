<?php
/**
 * Controller to browse information about Wikia's API
 *
 * @author  Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

class DiscoverApiController extends WikiaApiController {
	public function index() {
		$this->forward( __CLASS__, 'getList');
	}

	/**
	 * Lists all the registered API controllers
	 *
	 * @responseParam array controllers A list of API controller names
	 */
	public function getList() {
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