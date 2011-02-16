<?php

abstract class WikiaController {

	/**
	 * request object
	 * @var unknown_type
	 */
	protected $request = null;
	/**
	 * response object
	 * @var WikiaResponse
	 */
	protected $response = null;
	/**
	 * application object
	 * @var WikiaApp
	 */
	protected $app = null;

	protected $allowedRequests = array(
		'help' => array('html', 'json')
	);

	public function canDispatch( $method, $format ) {
		if ( !is_array( $this->allowedRequests )
		  || !isset( $this->allowedRequests[$method] )
		  || !is_array( $this->allowedRequests[$method] )
		  || !in_array( $format, $this->allowedRequests[$method] ) ) {
			return false;
		}

		return true;
	}

	public function setRequest(WikiaRequest $request) {
		$this->request = $request;
	}

	/**
	 * get request
	 * @return WikiaRequest
	 */
	public function getRequest() {
		return $this->request;
	}

	public function setResponse(WikiaResponse $response) {
		$this->response = $response;
	}

	/**
	 * get response object
	 * @return WikiaResponse
	 */
	public function getResponse() {
		return $this->response;
	}

	public function getApp() {
		return $this->app;
	}

	public function setApp( WikiaApp $app ) {
		$this->app = $app;
	}

	public function redirect( $controllerName, $methodName, $resetResponse = true ) {
		if( $resetResponse ) {
			$this->response->resetData();
		}

		$this->request->setVal( 'controller', $controllerName );
		$this->request->setVal( 'method', $methodName );
		$this->request->setDispatched(false);
	}

	public function sendRequest($controllerName, $methodName, $params = array(), $format = null) {
		$request = F::build( 'WikiaHTTPRequest',
		 array( 'params' => array_merge(
		                     array( 'controller' => $controllerName, 'method' => $methodName, 'format' => $format ),
		                     $params ) ) );

		$request->setInternal(true);
		$format = $request->getVal('format', $request->isXmlHttp() ? 'json' : 'html');
		$response = F::build( 'WikiaResponse', array( 'format' => $format ) );
		return $this->getApp()->dispatch($request, $response);
	}

	/**
	 * Prints documentation of current controller
	 */
	public function help() {
		$reflection = new ReflectionClass($this);
		$methods    = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
		$help       = array();

		foreach ($methods as $index => $method) {
			if (!isset($this->allowedRequests[$method->name])) {
				unset($methods[$index]);
			} else {
				$comment = $method->getDocComment();
				if ($comment) {
					$comment = substr($comment, 3, -2);
					$comment = preg_replace('~^\s*\*\s*~m', '', $comment);
				}
				$data = array(
					'method' => $method->name,
					'formats' => $this->allowedRequests[$method->name],
					'description' => $comment
				);
				$help[] = $data;
			}
		}

		$this->getResponse()->setVal('class', substr($reflection->name, 0, -10));
		$this->getResponse()->setVal('methods', $help);
		if($this->getResponse()->getFormat() == 'html') {
			$this->getResponse()->setTemplatePath( dirname( __FILE__ ) .'/templates/Wikia_help.php' );
		}
	}

	public function init() {}
}
