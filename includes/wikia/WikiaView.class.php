<?php

/**
 * Nirvana Framework - View class
 *
 * @group nirvana
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 * @author Owen Davis <owen(at)wikia-inc.com>
 * @author Wojciech Szela <wojtek(at)wikia-inc.com>
 */
class WikiaView {

	const ERROR_HEADER_NAME = 'X-Wikia-Error';
	/**
	 * Response object
	 * @var WikiaResponse
	 */
	private $response = null;
	private $templatePath = null;

	/**
	 * factory method - create view object for given controller and method name
	 *
	 * @param string $controllerName
	 * @param string $methodName
	 * @param array $data
	 * @param string $format
	 */
	public static function newFromControllerAndMethodName( $controllerName, $methodName, Array $data = array(), $format = 'html' ) {
		$response = F::build( 'WikiaResponse', array( $format ) );
		$response->setControllerName( $controllerName );
		$response->setMethodName( $methodName );
		$response->setData( $data );

		$view = new WikiaView;
		$view->setResponse( $response );

		return $view;
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
	public function setResponse(WikiaResponse $response) {
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
	 * build template path for given controller and method name
	 *
	 * @param string $controllerName
	 * @param string $methodName
	 * @param bool $forceRebuild
	 */
	public function buildTemplatePath( $controllerName, $methodName, $forceRebuild = false ) {
		if( ( $this->templatePath == null ) || $forceRebuild ) {
			$autoloadClasses = F::build( 'App' )->getGlobal( 'wgAutoloadClasses' );
			$controllerClass = $controllerName . 'Controller';

			// Workaround for wfRenderPartial while Module still exists
			if( empty( $autoloadClasses[$controllerClass] ) ) {
				$controllerClass = $controllerName . 'Module';
			}

			if( empty( $autoloadClasses[$controllerClass] ) ) {
				throw new WikiaException( "Invalid controller name: $controllerName" );
			}

			$templatePath = dirname( $autoloadClasses[$controllerClass] ) . '/templates/' . $controllerName . '_' . $methodName . '.php';

			if( !file_exists( $templatePath ) ) {
				throw new WikiaException( "Template file not found: $templatePath" );
			}

			$this->setTemplatePath( $templatePath );
		}
	}

	/**
	 * prepare response (called just before rendering starts)
	 * @param WikiaResponse $response
	 */
	public function prepareResponse( WikiaResponse $response ) {
		if( ( $response->getFormat() == 'json' ) && $response->hasException() ) {
			// set error header for JSON response (as requested for mobile apps)
			$response->setHeader( self::ERROR_HEADER_NAME, $response->getException()->getMessage() );
		}
		if( ( $response->getFormat() == 'json' ) && !$this->response->hasContentType() ) {
			$this->response->setContentType( 'application/json; charset=utf-8' );
		}
	}

	/**
	 * render view
	 * @return string
	 */
	public function render() {
		if( $this->response == null ) {
			throw new WikiaException( "WikiaView: response object is null" );
		}

		$method = 'render' . ucfirst( $this->response->getFormat() );
		if( method_exists( $this, $method ) ) {
			return $this->$method();
		}
		else {
			throw new WikiaException( "WikiaView: render() failed for format: " . $this->response->getFormat() );
		}
	}

	protected function renderRaw() {
		return '<pre>' . var_export( array( 'data' => $this->response->getData(), 'exception' => $this->response->getException() ), true ) . '</pre>';
	}

	protected function renderHtml() {
		$this->buildTemplatePath( $this->response->getControllerName(), $this->response->getMethodName() );

		$data = $this->response->getData();

		if( !empty( $data ) ) {
			extract( $data );
		}

		ob_start();
		require $this->getTemplatePath();
		$out = ob_get_clean();

		return $out;
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

}