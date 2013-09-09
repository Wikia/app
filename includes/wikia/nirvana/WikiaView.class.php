<?php

/**
 * Nirvana Framework - View class
 *
 * @ingroup nirvana
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 * @author Owen Davis <owen(at)wikia-inc.com>
 * @author Wojciech Szela <wojtek(at)wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaView {
	/**
	 * Response object
	 * @var WikiaResponse
	 */
	private $response = null;
	private $templatePath = null;

	function __construct( WikiaResponse $response = null ) {
		if ( !empty ( $response ) ) {
			$this->setResponse( $response );
		}
	}

	/**
	 * factory method - create view object for given controller and method name
	 *
	 * @param string $controllerName
	 * @param string $methodName
	 * @param array $data
	 * @param string $format
	 */
	public static function newFromControllerAndMethodName( $controllerName, $methodName, Array $data = array(), $format = WikiaResponse::FORMAT_HTML ) {
		$response = new WikiaResponse( $format );
		$response->setControllerName( $controllerName );
		$response->setMethodName( $methodName );
		$response->setData( $data );

		return $response->getView();
	}

	/**
	 * get response object
	 * @return WikiaResponse
	 */
	public function getResponse() {
		return $this->response;
	}

	/**
	 * set response object
	 * @param WikiaResponse $response
	 */
	public function setResponse( WikiaResponse $response ) {
		$this->response = $response;
	}

	/**
	 * get template path
	 * @return string
	 */
	public function getTemplatePath() {
		return $this->templatePath;
	}

	/**
	 * set template path
	 * @param string $value
	 */
	public function setTemplatePath( $value ) {
		$this->templatePath = $value;
	}

	/**
	 * set template by controller and method name
	 * @param string $controllerName
	 * @param string $methodName
	 */
	public function setTemplate( $controllerName, $methodName ) {
		$this->buildTemplatePath($controllerName, $methodName, true);
	}

	/**
	 * build template path for given controller and method name
	 *
	 * @param string $controllerName
	 * @param string $methodName
	 * @param bool $forceRebuild
	 */
	protected function buildTemplatePath( $controllerClass, $methodName, $forceRebuild = false ) {
		wfProfileIn(__METHOD__);
		if( ( $this->templatePath == null ) || $forceRebuild ) {
			global $wgAutoloadClasses;
			$app = F::app();

			if ( !empty( $this->response ) ) {
				$extension = $this->response->getTemplateEngine();
			} else {
				$extension = WikiaResponse::TEMPLATE_ENGINE_PHP;
			}

			// Service classes must be dispatched by full name otherwise we default to a controller.
			$controllerBaseName = $app->getBaseName( $controllerClass );
			if ($app->isService($controllerClass)) {
				$controllerClass = $app->getServiceClassName( $controllerBaseName );
			} else {
				$controllerClass = $app->getControllerClassName( $controllerBaseName );
			}

			if( empty( $wgAutoloadClasses[$controllerClass] ) ) {
				throw new WikiaException( "Invalid controller or service name: {$controllerClass}" );
			}

			// First we look for BaseName_MethodName
			$dirName = dirname( $wgAutoloadClasses[$controllerClass] );
			$basePath = "{$dirName}/templates/{$controllerBaseName}_{$methodName}";
			$templatePath = "{$basePath}.$extension";
			$templateExists = file_exists( $templatePath );

			// Fall back to ControllerClass_MethodName
			if( !$templateExists ) {
				$templatePath = "{$dirName}/templates/{$controllerClass}_{$methodName}.$extension";
				$templateExists = file_exists( $templatePath );
			}

			if( !$templateExists ) {
				throw new WikiaException( "Template file not found: {$templatePath}" );
			}

			$this->setTemplatePath( $templatePath );
		}
		wfProfileOut(__METHOD__);
	}

	public function __toString() {
		try {
			return $this->render();
		} catch( Exception $e ) {
			// php doesn't allow exceptions to be thrown inside __toString() so we need an extra try/catch block here
			if ($this->response == null) return "WikiaView: response object was null rendering {$this->templatePath}";
			if ($this->response->getException() == null) $this->response->setException($e);
			return F::app()->getView( 'WikiaError', 'error', array( 'response' => $this->response, 'devel' => F::app()->wg->DevelEnvironment ) )->render();
		}
	}

	/**
	 * render view
	 * @return string
	 */
	public function render() {
		if( empty( $this->response ) ) {
			throw new WikiaException( "WikiaView: response object is null rendering {$this->templatePath}" );
		}

		$method = 'render' . ucfirst( $this->response->getFormat() );

		if( method_exists( $this, $method ) ) {
			return $this->$method();
		}
		else {
			throw new WikiaException( "WikiaView: render() failed for method: $method format: {$this->response->getFormat()}" );
		}
	}

	protected function renderRaw() {
		wfProfileIn(__METHOD__);
		if ($this->response->hasException()) {
			wfProfileOut(__METHOD__);
			return '<pre>' . print_r ($this->response->getException(), true) . '</pre>';
		}
		wfProfileOut(__METHOD__);
		return '<pre>' . var_export( $this->response->getData(), true ) . '</pre>';
	}

	protected function renderHtml() {
		wfProfileIn(__METHOD__);
		$this->buildTemplatePath( $this->response->getControllerName(), $this->response->getMethodName() );

		$data = $this->response->getData();

		switch($this->response->getTemplateEngine()) {
			case WikiaResponse::TEMPLATE_ENGINE_MUSTACHE:
				$m = MustacheService::getInstance();
				$result = $m->render( $this->getTemplatePath(), $data );
				wfProfileOut(__METHOD__);

				return $result;
				break;
			case WikiaResponse::TEMPLATE_ENGINE_PHP:
			default:
				// Export the app wg and wf helper objects into the template
				// Note: never do this for Raw or Json formats due to major security issues there

				$data['app'] = F::app();
				$data['wg'] = F::app()->wg;
				$data['wf'] = F::app()->wf;

				if( !empty( $data ) ) {
					extract( $data );
				}

				ob_start();
				$templatePath = $this->getTemplatePath();
				wfProfileIn(__METHOD__ . ' - template: ' . $templatePath);
				require $templatePath;
				wfProfileOut(__METHOD__ . ' - template: ' . $templatePath);
				$out = ob_get_clean();
				wfProfileOut(__METHOD__);
				return $out;
				break;
		}

	}

	protected function renderJson() {
		if( $this->response->hasException() ) {
			$output = array( 'exception' => array( 'message' => $this->response->getException()->getMessage(), 'code' => $this->response->getException()->getCode() ) );
		}
		else {
			$output = $this->response->getData();
		}

		return json_encode( $output );
	}

	protected function renderJsonp() {
		$callbackName = $this->response->getRequest()->getVal('callback');
		return "$callbackName(".$this->renderJson().");";
	}

	// Invalid request format is an interesting case since it's not really a fatal error by itself
	// For now, we will process the request normally, default to json and attach an exception message
	protected function renderInvalid() {
		$output = $this->response->getData();
		$output += array( 'exception' => array( 'message' => "Invalid Format, defaulting to JSON", 'code' => WikiaResponse::RESPONSE_CODE_ERROR ) );
		return json_encode ( $output );
	}

}
