<?php

class ARecoveryBootstrapCode {
	public static function getHeadBootstrapCode() {

		return ARecoveryModule::isPageFairRecoveryEnabled() ?
			F::app()->sendRequest( 'ARecoveryEngineApiController', 'getPageFairBootstrapHead' ) :
			static::getBootstrapDisabledMessage( 'Head' );
	}

	public static function getTopBodyBootstrapCode() {

		return ARecoveryModule::isPageFairRecoveryEnabled() ?
			F::app()->sendRequest( 'ARecoveryEngineApiController', 'getPageFairBootstrapTopBody' ) :
			static::getBootstrapDisabledMessage( 'Top body' );
	}

	public static function getBottomBodyBootstrapCode() {

		return ARecoveryModule::isPageFairRecoveryEnabled() ?
			F::app()->sendRequest( 'ARecoveryEngineApiController', 'getPageFairBootstrapBottomBody' ) :
			static::getBootstrapDisabledMessage( 'Bottom body' );
	}

	public static function getSourcePointBootstrapCode() {
		return ARecoveryModule::shouldLoadSourcePointBootstrap() ?
			F::app()->sendRequest( 'ARecoveryEngineApiController', 'getBootstrap' ) :
			static::getBootstrapDisabledMessage();
	}

	public static function getInstartLogicBootstrapCode() {
		return ARecoveryModule::isInstartLogicRecoveryEnabled() ?
			F::app()->sendRequest( 'ARecoveryEngineApiController', 'getInstartLogicBootstrap' ) :
			static::getBootstrapDisabledMessage();
	}

	private static function getBootstrapDisabledMessage( $placement = '' ) {
		return PHP_EOL .
			'<!-- Recovery disabled. ' .
			$placement .
			'-->' .
			PHP_EOL;
	}
}
