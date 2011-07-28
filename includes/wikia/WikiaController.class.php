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
abstract class WikiaController extends WikiaBaseController {
	final public function allowsExternalRequests(){
		return true;
	}

	/**
	 * Prints documentation for current controller
	 * @todo implement request/responseParams tags
	 */
	public function help() {
		$reflection = new ReflectionClass($this);
		$methods    = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
		$help       = array();

		foreach ($methods as $index => $method) {
			//if (!isset($this->allowedRequests[$method->name])) {
			//	unset($methods[$index]);
			//} else {
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
			//}
		}

		$this->getResponse()->setVal('class', substr($reflection->name, 0, -10));
		$this->getResponse()->setVal('methods', $help);
		$this->getResponse()->getView()->setTemplatePath( dirname( __FILE__ ) .'/templates/Wikia_help.php' );
	}
	
	// Magic setting of template variables so we don't have to do $this->response->setVal
	// NOTE: This is the opposite behavior of the Oasis Module
	// In a module, a public member variable goes to the template
	// In a controller, a public member variable does NOT go to the template, it's a local var
	
	public function __set($propertyName, $value) {
		if (property_exists($this, $propertyName)) {
			$this->$propertyName = $value;
		} else {
			$this->response->setVal( $propertyName, $value );
		}
	}
	
	public function __get($propertyName) {
		if (property_exists($this, $propertyName)) {
			return $this->$propertyName;
		} else {
			return $this->response->getVal( $propertyName );
		}
	}
	
}
