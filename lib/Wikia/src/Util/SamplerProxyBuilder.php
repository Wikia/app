<?php

namespace Wikia\Util;

class SamplerProxyBuilder {

	protected $enableShadowing;
	protected $methodSamplingRate;

	protected $originalCallable;
	protected $alternateCallable;
	protected $resultsCallable;

	public function setEnableShadowing( $isEnabled ) {
		$this->enableShadowing = $isEnabled;

		return $this;
	}

	public function getEnableShadowing() {
		return $this->enableShadowing;
	}

	public function setMethodSamplingRate( $rate ) {
		$this->methodSamplingRate = $rate;

		return $this;
	}

	public function getMethodSamplingRate() {
		return $this->methodSamplingRate;
	}

	public function setOriginalCallable( callable $callable ) {
		$this->originalCallable = $callable;

		return $this;
	}

	public function getOriginalCallable() {
		return $this->originalCallable;
	}

	public function setAlternateCallable( callable $callable ) {
		$this->alternateCallable = $callable;

		return $this;
	}

	public function getAlternateCallable() {
		return $this->alternateCallable;
	}

	public function setResultsCallable( callable $callable ) {
		$this->resultsCallable = $callable;

		return $this;
	}

	public function getResultsCallable() {
		return $this->resultsCallable;
	}

	public function build() {
		return new SamplerProxy( $this );
	}
}