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
	 * Prints documentation for current controller
	 * @todo implement request/responseParams tags
	 */
	public function help() {
		$reflection = new ReflectionClass( __CLASS__ );
		$methods = $reflection->getMethods( ReflectionMethod::IS_PUBLIC );
		$skipMethods = array();

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

		foreach ($methods as $index => $method) {
			if ( !in_array( $method->name, $skipMethods ) ) {
				$comment = $method->getDocComment();
				if ($comment) {
					$comment = substr($comment, 3, -2);
					$comment = preg_replace('~^\s*\*\s*~m', '', $comment);
				}
				$data = array(
					'method' => $method->name,
					'formats' => array( 'html', 'json' ),
					//'formats' => $this->allowedRequests[$method->name],
					'description' => $comment
				);
				$help[] = $data;
			}
		}

		$this->getResponse()->setVal('class', substr($reflection->name, 0, -10));
		$this->getResponse()->setVal('methods', $help);
		$this->getResponse()->getView()->setTemplatePath( dirname( __FILE__ ) .'/templates/Wikia_help.php' );
	}
}
