<?php
class WikiaDispatcher {

	protected function getMethodName(WikiaRequest $request) {
		return $request->getVal( 'method', null );
	}

	protected function getControllerName(WikiaRequest $request) {
		$controller = $request->getVal( 'controller' );
		return !empty($controller) ? ( $controller . 'Controller' ) : null;
	}

	protected function createRequest() {
		return WF::build( 'WikiaHTTPRequest', array( 'params' => ( $_POST + $_GET ) ) );
	}

	protected function createResponse( WikiaRequest $request ) {
		$format = $request->getVal('format', $request->isXmlHttp() ? 'json' : 'html');

		return WF::build( 'WikiaResponse', array( 'format' => $format ) );
	}

	public function dispatch(WikiaRequest $request = null, WikiaResponse $response = null) {
		if (null === $request) {
			$request = $this->createRequest();
		}

		if (null === $response) {
			$response = $this->createResponse( $request );
		}

		do {
			$request->setDispatched(true);
			try {
				$method = $this->getMethodName( $request );
				$controllerClass = $this->getControllerName( $request );
				if( empty($method) || empty($controllerClass) ) {
					throw new WikiaException( 'Invalid controller or method name' );
				}

				$controller = WF::build( $controllerClass );

				if ( !method_exists($controller, $method) || !is_callable( array($controller, $method) ) ) {
					throw new WikiaException( sprintf('Could not dispatch %s::%s', $controllerClass, $method) );
				}

				$controller->setRequest($request);
				$controller->setResponse($response);
				$controller->init();
				$controller->$method();

			} catch (Exception $e) {
				$response->setException($e);

				if ($controllerClass != 'WikiaErrorController' && $method != 'error') {
					$request->setVal('controller', 'WikiaError');
					$request->setVal('method', 'error');
					$request->setDispatched(false);
				}
			}
		} while (!$request->isDispatched());

		return $response;
	}
}
