<?php
/**
 * A wrapper for a POPO that supports dispatching a specific method to an alternate
 * object, either as a shadowed execution (i.e. execute both the original method and the
 * alternate) or as a substitution (i.e. execute the alternate instead of the original).
 * Both shadowing and substitution may be sampled so that only a specified percentage of
 * calls involve the alternate and the rest pass through to the original.
 *
 * This object supports the following migration pattern:
 *  1. Implement new service/functionality in production with no client access
 *  2. Deploy app code that uses this object configured with the existing (to be replaced) code
 *     as the original callable and the new code as the alternate callable.  This should have no
 *     effect on functionality until global variables are changed.
 *  3. Configure global variables so that this object shadows 10% of the calls - should be
 *     transparent to users and will verify that the production deployment from step 1 is working
 *     without overtaxing it.
 *  4. Gradually increase shadowed call percentage until the new service/functionality can handle
 *     100% of the traffic without any issues.
 *  5. Back the sampling percentage back down to 10% and disable shadowing - the new
 *     service/functionality now handles 10% of live calls.
 *  6, Gradually increase sampling percentage until the new service/functionality handles 100% of
 *     live calls without issues.
 *  7. Deploy a code change that removes the SamplerProxy and directly calls the new
 *     service/functionality and deletes the old code.
 */
namespace Wikia\Util;


class SamplerProxy {

	/**
	 * @var string
	 */
	protected $enableShadowing;

	/**
	 * @var string
	 */
	protected $methodSamplingRate;

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
		$this->enableShadowing = $samplerProxyBuilder->getEnableShadowing();
		$this->methodSamplingRate = $samplerProxyBuilder->getMethodSamplingRate();
		$this->originalCallable = $samplerProxyBuilder->getOriginalCallable();
		$this->alternateCallable = $samplerProxyBuilder->getAlternateCallable();
		$this->resultsCallable = $samplerProxyBuilder->getResultsCallable();
	}

	/**
	 * Wrapper method for testability
	 * @param $minValue
	 * @param $maxValue
	 */
	public function getRandomInt( $minValue, $maxValue ) {
		return rand( $minValue, $maxValue );
	}

	public function __call( $method, $args ) {

		// Forward all methods but $originalMethod to $originalPopo
		if ( $method != $this->originalCallable[1] ) {
			return call_user_func_array( [ $this->originalCallable[0], $method ], $args );
		}

		if ( !empty( $this->methodSamplingRate ) &&
		     $this->getRandomInt( 0, 100 ) <= $this->methodSamplingRate ) {

			// We're going to route the request to the alternate instance.
			// Now determine if we're going to shadow or redirect
			$shouldShadow = $this->enableShadowing;

			// Call the alternate method and cache the result
			try {
				$alternateResult = call_user_func_array( $this->alternateCallable, $args );
			}
			catch ( \Exception $e ) {
				$log = \Wikia\Logger\WikiaLogger::instance();
				$log->error( __METHOD__ . " - Exception thrown from alternate method: " .
				             $e->getMessage(), [
					'method' => __METHOD__,
					'exception' => $e,
					'shadowing' => $this->enableShadowing,
					'sampleRate' => $this->methodSamplingRate,
				] );

				// An exception was thrown by the alternate method.  Call the original method in
				// an attempt to obtain valid results for the caller.  This seems like a reasonable
				// fallback during a temporary migration scenario as should always be the case when
				// you are using this proxy object.
				$shouldShadow = true;
			}

			if ( !$shouldShadow && isset( $alternateResult ) ) {
				$resultToReturn = $alternateResult;
			} else {

				// We're shadowing, so also call the original method and invoke the results
				// callable if it's set
				$originalResult = call_user_func_array( $this->originalCallable, $args );

				if ( $this->resultsCallable && isset( $alternateResult ) ) {
					$resultToReturn =
						call_user_func( $this->resultsCallable, $originalResult, $alternateResult );
				} else {
					$resultToReturn = $originalResult;
				}
			}

			return $resultToReturn;
		}

		/*
		 * Just pass through if:
		 *   - sampling rate is undefined or is zero
		 *   - we're sampling, but this particular call is in the unsampled population
		 */

		return call_user_func_array( $this->originalCallable, $args );
	}

	public function setEnableShadowing( $isEnabled ) {
		$this->enableShadowing = $isEnabled;
	}

	public function getEnableShadowing() {
		return $this->enableShadowing;
	}

	public function setMethodSamplingRate( $rate ) {
		$this->methodSamplingRate = $rate;
	}

	public function getMethodSamplingRate() {
		return $this->methodSamplingRate;
	}

	public function setOriginalCallable( callable $callable ) {
		$this->originalCallable = $callable;
	}

	public function getOriginalCallable() {
		return $this->originalCallable;
	}

	public function setAlternateCallable( callable $callable ) {
		$this->alternateCallable = $callable;
	}

	public function getAlternateCallable() {
		return $this->alternateCallable;
	}

	public function setResultsCallable( callable $callable ) {
		$this->resultsCallable = $callable;
	}

	public function getResultsCallable() {
		return $this->resultsCallable;
	}
}
