<?php
class WikiaDispatcher {

	const DEFAULT_METHOD_NAME = 'index';

	protected function getMethodName(WikiaRequest $request) {
		return $request->getVal( 'method', self::DEFAULT_METHOD_NAME );
	}

	protected function getControllerName(WikiaRequest $request) {
		return $request->getVal( 'controller' );
	}

	protected function getControllerClassName( $controllerName ) {
		return !empty( $controllerName ) ? ( $controllerName . 'Controller' ) : null;
	}

	protected function createRequest() {
		return F::build( 'WikiaHTTPRequest', array( 'params' => ( $_POST + $_GET ) ) );
	}

	protected function createResponse( WikiaRequest $request ) {
		$format = $request->getVal('format', $request->isXmlHttp() ? 'json' : 'html');

		return F::build( 'WikiaResponse', array( 'format' => $format ) );
	}

	public function dispatch(WikiaApp $app, WikiaRequest $request = null, WikiaResponse $response = null) {
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
				if( empty($controllerClassName) ) {
					throw new WikiaException( sprintf('Invalid controller name: %s', $controllerName ) );
				}

				$controller = F::build( $controllerClassName );

				if ( !method_exists($controller, $method) || !is_callable( array($controller, $method) ) ) {
					throw new WikiaException( sprintf('Could not dispatch %s::%s', $controllerClassName, $method) );
				}

				if( !$request->isInternal() && !$controller->canDispatch( $method, $response->getFormat()) ) {
					throw new WikiaException( sprintf('Access denied %s::%s (format: "%s")', $controllerClassName, $method, $response->getFormat()), WikiaResponse::RESPONSE_CODE_FORBIDDEN );
				}

				$controller->setRequest($request);
				$controller->setResponse($response);
				$controller->setApp($app);
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

		return $response;
	}
}
