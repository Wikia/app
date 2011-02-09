<?php
class WikiaDispatcher {

	protected function getMethodName(WikiaRequest $request) {
		return $request->getVal( 'method', null );
	}

	protected function getControllerName(WikiaRequest $request) {
		return $request->getVal( 'controller' );
	}

	protected function getControllerClassName( $controllerName ) {
		return !empty( $controllerName ) ? ( $controllerName . 'Controller' ) : null;
	}

	protected function createRequest() {
		return SF::build( 'WikiaHTTPRequest', array( 'params' => ( $_POST + $_GET ) ) );
	}

	protected function createResponse( WikiaRequest $request ) {
		$format = $request->getVal('format', $request->isXmlHttp() ? 'json' : 'html');

		return SF::build( 'WikiaResponse', array( 'format' => $format ) );
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
				$controllerName = $this->getControllerName( $request );
				$controllerClassName = $this->getControllerClassName( $controllerName );
				if( empty($method) || empty($controllerClassName) ) {
					throw new WikiaException( 'Invalid controller or method name' );
				}

				$controller = SF::build( $controllerClassName );

				if ( !method_exists($controller, $method) || !is_callable( array($controller, $method) ) ) {
					throw new WikiaException( sprintf('Could not dispatch %s::%s', $controllerClassName, $method) );
				}

				if( !$request->isInternal() && !$controller->canDispatch( $method, $response->getFormat()) ) {
					throw new WikiaException( sprintf('Access denied %s::%s', $controllerClassName, $method), 403 );
				}
				$controller->setRequest($request);
				$controller->setResponse($response);
				$controller->init();
				$controller->$method();

			} catch (Exception $e) {
				$response->setException($e);

				if ($controllerClassName != 'WikiaErrorController' && $method != 'error') {
					$request->setVal('controller', 'WikiaError');
					$request->setVal('method', 'error');
					$request->setDispatched(false);
				}
			}
		} while (!$request->isDispatched());

		if ($request->isInternal() && $response->hasException()) {
			throw $response->getException();
		}

		$response->buildTemplatePath( $controllerName, $method );

		//if ($controller instanceof WikiaSpecialPageController) {
		//global $wgOut;
		//$wgOut->addHTML((string) $response);
		//}

		return $response;
	}
}
