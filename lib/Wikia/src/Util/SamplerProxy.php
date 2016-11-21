<?php
/**
 * A wrapper for a POPO that supports dispatching a specific method to an alternate
 * object, either as a shadowed execution (i.e. execute both the original method and the
 * alternate) or as a substitution (i.e. execute the alternate instead of the original).
 * Both shadowing and substitution may be sampled so that only a specified percentage of
 * calls involve the alternate and the rest pass through to the original.
 */
namespace Wikia\Util;


class SamplerProxy {

	/**
	 * @var string
	 */
	protected $enableShadowingVariableName;

	/**
	 * @var string
	 */
	protected $methodSamplingRateVariableName;

	/**
	 * @var callable
	 * Expected to be of the form [ <instance>, <method name> ]
	 */
	protected $originalCallable;

	/**
	 * @var callable
	 * Expected to be of the form [ <instance>, <method name> ]
	 * Should have the same argument list as $originalCallable
	 */
	protected $alternateCallable;

	/**
	 * @var callable
	 * Takes 2 arguments, ( $originalResults, $alternateResults ) and
	 * returns the results that should be passed back to the caller
	 */
	protected $resultsCallable;

	public static function createBuilder() {
		return new SamplerProxyBuilder();
	}

	public function __construct( SamplerProxyBuilder $samplerProxyBuilder ) {
		$this->enableShadowingVariableName = $samplerProxyBuilder->getEnableShadowingVariableName();
		$this->methodSamplingRateVariableName =
			$samplerProxyBuilder->getMethodSamplingRateVariableName();
		$this->originalCallable = $samplerProxyBuilder->getOriginalCallable();
		$this->alternateCallable = $samplerProxyBuilder->getAlternateCallable();
		$this->resultsCallable = $samplerProxyBuilder->getResultsCallable();
	}

	public function __call( $method, $args ) {

		// Forward all methods but $originalMethod to $originalPopo
		if ( $method != $this->originalCallable[1] ) {
			return call_user_func_array( [ $this->originalCallable[0], $method ], $args );
		}

		global ${$this->methodSamplingRateVariableName};
		$samplingRate = ${$this->methodSamplingRateVariableName};

		if ( !empty( $samplingRate ) && rand( 0, 100 ) <= $samplingRate ) {

			// We're going to route the request to the alternate instance.
			// Now determine if we're going to shadow or redirect
			global ${$this->enableShadowingVariableName};
			$shouldShadow = ${$this->enableShadowingVariableName};

			// Call the alternate method and cache the result
			try {
				$alternateResult = call_user_func_array( $this->alternateCallable, $args );
			}
			catch ( \Exception $e ) {
				// ensure we call the original method
				$shouldShadow = true;
			}

			if ( !$shouldShadow && isset( $alternateResult ) ) {
				$resultToReturn = $alternateResult;
			} else {

				// We're shadowing, so also call the original method and invoke the results
				// callable if it's set
				$originalResult = call_user_func_array( $this->originalCallable, $args );

				if ( $this->resultsCallable && isset( $alternateResult ) ) {
					$resultToReturn = call_user_func( $this->resultsCallable, $originalResult, $alternateResult );
				} else {
					$resultToReturn = $originalResult;
				}
			}

			// We didn't invoke a results callable, so we return the result of the original method
			return $resultToReturn;
		}

		/*
		 * Just pass through if:
		 *   - the method called isn't the one we're sampling
		 *   - sampling rate is undefined or is zero
		 *   - we're sampling, but this particular call is in the unsampled population
		 */

		return call_user_func_array( $this->originalCallable, $args );
	}

	public function getEnableShadowingVariableName() {
		return $this->enableShadowingVariableName;
	}

	public function getMethodSamplingRateVariableName() {
		return $this->methodSamplingRateVariableName;
	}

	public function getOriginalCallable() {
		return $this->originalCallable;
	}

	public function getAlternateCallable() {
		return $this->alternateCallable;
	}

	public function getResultsCallable() {
		return $this->resultsCallable;
	}
}
