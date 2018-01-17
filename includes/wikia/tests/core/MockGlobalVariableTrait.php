<?php

trait MockGlobalVariableTrait {
	private $contextMap = [
		'wgRequest' => 'request',
		'wgTitle' => 'title',
		'wgOut' => 'output',
		'wgUser' => 'user',
		'wgLang' => 'lang',
		'wgSkin' => 'skin',
	];

	/** @var array $mockedGlobalVariables */
	private $mockedGlobalVariables = [];

	/**
	 * Mock global ($wg...) variable, also in main RequestContext instance if needed.
	 *
	 * @param $globalName string name of global variable (e.g. wgCity - WITH wg prefix)
	 * @param $returnValue mixed value variable should be set to
	 */
	protected function mockGlobalVariable( string $globalName, $returnValue ) {
		$this->mockedGlobalVariables[$globalName] = $GLOBALS[$globalName];
		$this->setInGlobalScope( $globalName, $returnValue );
	}

	protected function unsetGlobals() {
		foreach ( $this->mockedGlobalVariables as $globalName => $oldValue ) {
			$this->setInGlobalScope( $globalName, $oldValue );
		}

		$this->mockedGlobalVariables = [];
	}

	private function setInGlobalScope( string $globalName, $value ) {
		$GLOBALS[$globalName] = $value;

		if ( isset( $this->contextMap[$globalName] ) ) {
			$context = RequestContext::getMain();
			$prop = new ReflectionProperty( RequestContext::class, $this->contextMap[$globalName] );

			$prop->setAccessible( true );
			$prop->setValue( $context, $value );
		}
	}
}
