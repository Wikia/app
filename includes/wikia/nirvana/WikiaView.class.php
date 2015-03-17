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
	 *
	 * @return WikiaView
	 */
	public static function newFromControllerAndMethodName( $controllerName, $methodName, Array $data = [], $format = WikiaResponse::FORMAT_HTML ) {
		// Service classes must be dispatched by full name otherwise we default to a controller.
		$controllerClassName = self::normalizeControllerClass( $controllerName );

		$response = new WikiaResponse( $format );
		$response->setControllerName( $controllerName );
		$response->setMethodName( $methodName );
		$response->setData( $data );

		/* @var $controllerClassName WikiaController */
		$response->setTemplateEngine( $controllerClassName::DEFAULT_TEMPLATE_ENGINE );

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
	 * @param string $controllerClass
	 * @param string $methodName
	 * @param bool $forceRebuild
	 *
	 * @throws WikiaException
	 */
	protected function buildTemplatePath( $controllerClass, $methodName, $forceRebuild = false ) {
		wfProfileIn(__METHOD__);
		if ( ( $this->templatePath == null ) || $forceRebuild ) {
			if ( !empty( $this->response ) ) {
				$extension = $this->response->getTemplateEngine();
			} else {
				$extension = WikiaResponse::TEMPLATE_ENGINE_PHP;
			}

			// Service classes must be dispatched by full name otherwise we default to a controller.
			$controllerClass = $this->normalizeControllerClass( $controllerClass );

			$templateExists = false;
			$templatePath = '';
			$templates = $this->getTemplateOptions( $controllerClass, $methodName );
			$dirName = $this->getTemplateDir( $controllerClass );
			foreach ( $templates as $templateName ) {
				$templatePath = $dirName . '/' . $templateName . '.' . $extension;

				if ( file_exists( $templatePath ) ) {
					$templateExists = true;
					break;
				}
			}

			if ( !$templateExists ) {
				throw new WikiaException( "Template file not found: {$templatePath}" );
			}

			$this->setTemplatePath( $templatePath );
		}
		wfProfileOut(__METHOD__);
	}

	/**
	 * For legacy reasons we sometimes get a $controllerClass name that doesn't end with
	 * 'Controller' or 'Service'.  Normalize to this form.
	 *
	 * @param $controllerClass
	 *
	 * @return string
	 *
	 * @throws WikiaException
	 */
	public static function normalizeControllerClass( $controllerClass ) {
		$app = F::app();
		$controllerBaseName = $app->getBaseName( $controllerClass );
		if ( $app->isService( $controllerClass ) ) {
			$controllerClass = $app->getServiceClassName( $controllerBaseName );
		} else {
			$controllerClass = $app->getControllerClassName( $controllerBaseName );
		}

		if ( empty( $app->wg->AutoloadClasses[$controllerClass] ) ) {
			throw new WikiaException( "Invalid controller or service name: {$controllerClass}" );
		}

		return $controllerClass;
	}

	/**
	 * Generates a list of possible template names ordered by preference
	 *
	 * @param $controllerClass
	 * @param $methodName
	 *
	 * @return array
	 */
	public function getTemplateOptions( $controllerClass, $methodName ) {
		$templates = [];

		// Make sure this method exists, otherwise the call to getMethod crashes PHP
		// so badly it can't even log that a problem occurred.
		if ( method_exists( $controllerClass, $methodName ) ) {
			// See if there is a @template annotation for the method we're generating a view for
			$reflection = new ReflectionClass( $controllerClass );
			$method = $reflection->getMethod( $methodName );

			$comment = $method->getDocComment();
			if ( preg_match( '/@template ([^ ]+)/', $comment, $matches ) ) {
				$templates[] = trim( $matches[1] );
			}
		}

		// Add variations on the controller name
		$controllerBaseName = F::app()->getBaseName( $controllerClass );
		$templates[] = "{$controllerBaseName}_{$methodName}";
		$templates[] = "{$controllerClass}_{$methodName}";

		return $templates;
	}

	/**
	 * See if the controller defines a custom template directory, otherwise use the default directory
	 *
	 * @param $controllerClass
	 *
	 * @return string
	 */
	public function getTemplateDir( $controllerClass ) {
		if ( method_exists( $controllerClass, 'getTemplateDir' ) ) {
			$dirName = call_user_func( [ $controllerClass, 'getTemplateDir' ] );
		}

		// If the above fails, or returns a non-existent directory, fallback to the default.
		if ( empty( $dirName ) || !file_exists( $dirName ) ) {
			$dirName = dirname( F::app()->wg->AutoloadClasses[$controllerClass] ) . '/templates';
		}

		return $dirName;
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
			case WikiaResponse::TEMPLATE_ENGINE_HANDLEBARS:
				$handlebarsService = HandlebarsService::getInstance();
				$result = $handlebarsService->render( $this->getTemplatePath(), $data );
				wfProfileOut(__METHOD__);

				return $result;
				break;
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
			$exception = $this->response->getException();
			$output = array( 'exception' => array( 'message' => $exception->getMessage(), 'code' => $exception->getCode(), 'details' => '' ) );
			if ( is_callable( [ $exception, 'getDetails' ] ) ) {
				$output[ 'exception' ][ 'details' ] = $exception->getDetails();
			}
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
