<?php

namespace Wikia\Util;

class SamplerProxyBuilder {

	protected $enableShadowingVariableName;
	protected $methodSamplingRateVariableName;

	protected $originalCallable;
	protected $alternateCallable;
	protected $resultsCallable;

	public function enableShadowingVariableName( $name ) {
		$this->enableShadowingVariableName = $name;

		return $this;
	}

	public function getEnableShadowingVariableName() {
		return $this->enableShadowingVariableName;
	}

	public function methodSamplingRateVariableName( $name ) {
		$this->methodSamplingRateVariableName = $name;

		return $this;
	}

	public function getMethodSamplingRateVariableName() {
		return $this->methodSamplingRateVariableName;
	}

	public function originalCallable( callable $callable ) {
		$this->originalCallable = $callable;

		return $this;
	}

	public function getOriginalCallable() {
		return $this->originalCallable;
	}

	public function alternateCallable( callable $callable ) {
		$this->alternateCallable = $callable;

		return $this;
	}

	public function getAlternateCallable() {
		return $this->alternateCallable;
	}

	public function resultsCallable( callable $callable ) {
		$this->resultsCallable = $callable;

		return $this;
	}

	public function getResultsCallable() {
		return $this->resultsCallable;
	}

	public function build() {
		$this->checkNull( $this->enableShadowingVariableName, "enableShadowingVariableName" );
		$this->checkNull( $this->methodSamplingRateVariableName, "methodSamplingRateVariableName" );

		return new SamplerProxy( $this );
	}

	protected function checkNull( $variable, $name ) {
		if ( $variable == null ) {
			throw new \InvalidArgumentException( "Attribute '${name}' may not be null" );
		}
	}
}