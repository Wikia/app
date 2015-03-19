<?php

/**
 * Nirvana Framework - Controller class
 *
 * @ingroup nirvana
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 * @author Owen Davis <owen(at)wikia-inc.com>
 * @author Wojciech Szela <wojtek(at)wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
abstract class WikiaController extends WikiaDispatchableObject {

	final public function allowsExternalRequests(){
		return true;
	}

	/**
	 * Get names of methods that should not appear in public documentation, even if they're public.
	 * Protected to allow children classes to add methods here.
	 */
	protected function getSkipMethods() {
		return array();
	}
	
	/**
	 * Prints documentation for current controller
	 * @todo implement request/responseParams tags
	 */
	public function help() {
		$reflection = new ReflectionClass( __CLASS__ );
		$methods = $reflection->getMethods( ReflectionMethod::IS_PUBLIC );
		$skipMethods = $this->getSkipMethods();

		//build a list of the WikiaController base class methods to filter
		//them out from the docs, but maintain "help"
		foreach ( $methods as $m ) {
			if ( $m->name != 'help' ) {
				$skipMethods[] = $m->name;
			}
		}

		$reflection = new ReflectionClass($this);
		$methods    = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
		$help       = array();

		foreach ($methods as $method) {
			if ( !in_array( $method->name, $skipMethods ) ) {
				$comment = $method->getDocComment();

				if ( strpos( $comment, '@private' ) === false ) {

					$data = array(
						'method' => $method->name,
						//TODO: we need a better way to detect available formats
						//for now let's disable this hardcoded list as API controllers
						//allow only for JSON and some normal controllers have to HTML
						//'formats' => array( 'html', 'json' ),
						//'formats' => $this->allowedRequests[$method->name],
						'request' => array(),
						'response' => array()
					);

					if ( !empty( $comment ) ) {
						$results = array();

						//grab documentation tokens
						preg_match_all(
							'/^\s*\*\s*@(response|request)param\s*(\S*)\s*\$?(\S*)\s*(\[optional\])?\s*([^\n]*)$/im',
							$comment,
							$results,
							PREG_SET_ORDER
						);

						foreach ( $results as $res ) {
							$kind = strtolower( $res[1] );

							if ( array_key_exists( $kind, $data ) ) {
								$data[$kind][] = array(
									'name' => $res[3],
									'type' => $res[2],
									'optional' => !empty( $res[4] ),
									'description' => $res[5]
								);
							}

							$comment = str_replace( $res[0], '', $comment );
						}

						preg_match_all( '/@example.*/', $comment, $res );

						if ( $res ) {

							$examples = [];

							foreach ( $res[0] as $r ) {
								$example = preg_replace('/@example\s*/', '', $r);

								if( strpos( $example, 'http' ) === false ) {
									$example = $this->wg->Server . '/wikia.php?controller=' . preg_replace( '/Controller$/', '', $method->class ) . '&method='. $method->name . $example;
								}

								$examples[] = $example;

								$comment = preg_replace( "~" . preg_quote( $r ) . "~", '', $comment, 1 );
							}

							$data['examples'] = $examples;
						}

						//remove /*\n and */
						$comment = substr( $comment, 3, -2 );
						//remove empty comment lines starting with *,
						//non-desired @ metadata
						//and trailing *'s
						$data['description'] =  preg_replace( '/^@.*$/', '', preg_replace( '/^\s*\*\s*/m', '', $comment ) );
					}

					$help[] = $data;
				}
			}
		}

		$this->getResponse()->setVal('class', substr($reflection->name, 0, -10));
		$this->getResponse()->setVal('methods', $help);

		if ( $this->response->getFormat() == 'html' ) {
			$this->getResponse()->getView()->setTemplatePath( dirname( __FILE__ ) .'/templates/Wikia_help.php' );
		}
	}

	/**
	 * Stub method, which provides a fallback in case
	 * when user doesn't have permissions to launch controller (e.g. anonymous user).
	 *
	 * For example, extending of this method can be used
	 * for developing API for anonymous users, but with access keys.
	 *
	 * Important: due to complexity of existing flow of processing requests -
	 * at the point of execution of this method, instance of controller is not injected yet with request object
	 *
	 * So, if you want to access request, use: RequestContext::getMain()->getRequest()
	 *
	 * @return bool
	 */
	public function isAnonAccessAllowedInCurrentContext() {
		return false;
	}

	/**
	 * Allow controllers to define an alternate location for where templates can be found.
	 * This base definition returns null so by default WikiaView.class.php will determine
	 * this directory.
	 *
	 * @return null
	 */
	public function getTemplateDir() {
		return null;
	}
}
