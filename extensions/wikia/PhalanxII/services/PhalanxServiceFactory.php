<?php

use Wikia\DependencyInjection\Injector;

class PhalanxServiceFactory {
	/** @var PhalanxService $phalanxService */
	private static $phalanxService;

	public static function getServiceInstance(): PhalanxService {
		if ( static::$phalanxService === null ) {
			/** @var PhalanxHttpClient $phalanxHttpClient */
			$phalanxHttpClient = Injector::getInjector()->get( PhalanxHttpClient::class );
			$defaultPhalanxService = new DefaultPhalanxService( $phalanxHttpClient );

			static::$phalanxService =  new DesperatePhalanxService( $defaultPhalanxService );
		}

		return static::$phalanxService;
	}
}
