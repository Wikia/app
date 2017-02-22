<?php
class ARecoveryBootstrapCode {
	public static function getHeadBootstrapCode() {

		return (new ARecoveryModule())->isPageFairRecoveryDisabled() ?
			static::getBootstrapDisabledMessage('Head') :
			(new PageFairBootstrapCode())->getHeadCode();
	}
	
	public static function getTopBodyBootstrapCode() {

		return (new ARecoveryModule())->isPageFairRecoveryDisabled() ?
			static::getBootstrapDisabledMessage('Top body') :
			(new PageFairBootstrapCode())->getTopBodyCode();
	}
	
	public static function getBottomBodyBootstrapCode() {

		return (new ARecoveryModule())->isPageFairRecoveryDisabled() ?
			static::getBootstrapDisabledMessage('Bottom body') :
			(new PageFairBootstrapCode())->getBottomBodyCode();
	}

	public static function getSourcePointBootstrapCode() {
		return (new ARecoveryModule())->isSourcePointRecoveryDisabled() ?
			static::getBootstrapDisabledMessage() :
			static::getBootstrapCode();
	}

	private static function getBootstrapCode() {
		return F::app()->sendRequest( 'ARecoveryEngineApiController', 'getBootstrap' );
	}

	private static function getBootstrapDisabledMessage( $placement = '' ) {
		return PHP_EOL .
			'<!-- Recovery disabled. ' .
			$placement .
			'-->' .
			PHP_EOL;
	}
}
