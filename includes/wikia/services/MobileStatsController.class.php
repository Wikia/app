<?php
/**
 * Mobile apps statistics controller
 * 
 * @author Federico "Lox" Lucignano
 */
class MobileStatsController extends WikiaController {
	const SCRIBE_KEY = 'mobile_apps';
	
	/**
	 * @brief Tracks mobile apps' via Scribe
	 * 
	 * @requestParam string $appName The name of the mobile app requesting for tracking
	 * @requestParam array $URIData A set of values that will be concatenated with '/' in an "action URI"
	 * @requestParam string $platform [OPTIONAL] The mobile platform requesting for tracking
	 */
	public function track(){
		$appName = $this->getVal( 'appName' );
		$URIData = $this->getVal( 'URIData' );
		$platform = $this->getVal( 'platform', 'undefined');
		
		if ( !$this->request->isInternal() ) {
			throw new MobileStatsExternalRequestException();
		} elseif ( empty( $appName ) || empty( $URIData ) ) {
			throw new MobileStatsMissingParametersException();
		}
		
		if ( !$this->wg->develEnvironment ) {
			$appName = (string) $appName;
			$URIData = (array) $URIData;
			
			try {
				$params = array(
					'app' => $appName,
					'os' => $platform,
					'uri' => implode('/', $URIData),
					'time' => time(),
				);
								
				$data = json_encode( array(
					'method' => self::SCRIBE_KEY,
					'params' => $params
				) );
				
				F::build( 'WScribeClient', array( 'trigger' ), 'singleton' )->send( $data );
			} catch( TException $e ) {
				Wikia::log( __METHOD__, 'scribeClient exception', $e->getMessage() );
			}
		}
	}
}

class MobileStatsExternalRequestException extends WikiaException {
	function __construct(){
		parent::__construct( 'External requests not allowed' );
	}
}

class MobileStatsMissingParametersException extends WikiaException {
	function __construct(){
		parent::__construct( 'Missing parameters' );
	}
}
