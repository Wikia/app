<?php

class PhalanxServiceFactory {
	/** @var PhalanxService $phalanxService */
	private static $phalanxService;

	public static function getServiceInstance(): PhalanxService {
		if ( static::$phalanxService === null ) {
			$urlProvider = \Wikia\Factory\ServiceFactory::instance()->providerFactory()->urlProvider();
			$defaultPhalanxService = new DefaultPhalanxService( $urlProvider );

			static::$phalanxService =  new DesperatePhalanxService( $defaultPhalanxService );
		}

		return static::$phalanxService;
	}
}
