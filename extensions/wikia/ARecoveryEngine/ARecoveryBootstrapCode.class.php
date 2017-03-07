<?php
class ARecoveryBootstrapCode {
	public static function getHeadBootstrapCode() {

		return (new ARecoveryModule())->isPageFairRecoveryDisabled() ?
			static::getBootstrapDisabledMessage('Head') :
			F::app()->sendRequest( 'ARecoveryEngineApiController', 'getPageFairBootstrapHead' );
	}
	
	public static function getTopBodyBootstrapCode() {

		return (new ARecoveryModule())->isPageFairRecoveryDisabled() ?
			static::getBootstrapDisabledMessage('Top body') :
			F::app()->sendRequest( 'ARecoveryEngineApiController', 'getPageFairBootstrapTopBody' );
	}

	public static function getBottomBodyBootstrapCode() {

		return (new ARecoveryModule())->isPageFairRecoveryDisabled() ?
			static::getBootstrapDisabledMessage('Bottom body') :
			F::app()->sendRequest( 'ARecoveryEngineApiController', 'getPageFairBootstrapBottomBody' );
	}

	public static function getSourcePointBootstrapCode() {
		return (new ARecoveryModule())->isSourcePointRecoveryDisabled() ?
			static::getBootstrapDisabledMessage() :
			F::app()->sendRequest( 'ARecoveryEngineApiController', 'getBootstrap' );
	}

	private static function getBootstrapDisabledMessage( $placement = '' ) {
		return PHP_EOL .
			'<!-- Recovery disabled. ' .
			$placement .
			'-->' .
			PHP_EOL;
	}
}
