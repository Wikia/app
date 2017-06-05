<?php

class WikiaRequestBuilder {
	/** @var WikiaApp $app */
	private $app;

	/** @var WikiaRequest $request */
	private $request;

	/** @var bool $internal */
	private $internal;

	/** @var IContextSource $context */
	private $context;

	public function __construct( WikiaApp $app ) {
		$this->app = $app;
		$this->request = new WikiaRequest( [] );
	}

	public function setControllerName( string $controllerName ): WikiaRequestBuilder {
		$this->request->setVal( 'controller', $controllerName );

		return $this;
	}

	public function setMethodName( string $methodName ): WikiaRequestBuilder {
		$this->request->setVal( 'method', $methodName );

		return $this;
	}

	public function setParams( array $params ): WikiaRequestBuilder {
		foreach ( $params as $key => $value ) {
			$this->request->setVal( $key, $value );
		}

		return $this;
	}

	public function setContext( IContextSource $context ): WikiaRequestBuilder {
		$this->context = $context;

		return $this;
	}

	public function setExceptionMode( int $exceptionMode ): WikiaRequestBuilder {
		$this->request->setExceptionMode( $exceptionMode );

		return $this;
	}

	public function setInternal( bool $internal ): WikiaRequestBuilder {
		$this->internal = $internal;

		return $this;
	}

	public function dispatch() {

	}
}
