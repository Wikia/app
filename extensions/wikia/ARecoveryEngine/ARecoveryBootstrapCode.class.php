<?php
class ARecoveryBootstrapCode {
	public static function getHeadBootstrapCode() {

		return (new ARecoveryModule())->isPageFairRecoveryEnabled() ?
			(new PageFairBootstrapCode())->getHeadCode() :
			static::getBootstrapDisabledMessage('Head');
	}
	
	public static function getTopBodyBootstrapCode() {

		return (new ARecoveryModule())->isPageFairRecoveryEnabled() ?
			(new PageFairBootstrapCode())->getTopBodyCode() :
			static::getBootstrapDisabledMessage('Top body');
	}
	
	public static function getBottomBodyBootstrapCode() {

		return (new ARecoveryModule())->isPageFairRecoveryEnabled() ?
			(new PageFairBootstrapCode())->getBottomBodyCode() :
			static::getBootstrapDisabledMessage('Bottom body');
	}

	public static function getSourcePointBootstrapCode() {
		return (new ARecoveryModule())->isSourcePointRecoveryEnabled() ?
			static::getBootstrapCode() :
			static::getBootstrapDisabledMessage();
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
