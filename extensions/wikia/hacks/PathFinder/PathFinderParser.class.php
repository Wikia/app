<?php
/**
 * Path Finder OneDot data parser
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class PathFinderParser {
	/**
	 * external referrers (positive numbers are reserved for wikis IDs, 0 is for generic sources)
	 */
	const EXTERNAL_REFERRER_UNKNOWN = 0;
	const EXTERNAL_REFERRER_GOOGLE = -1;
	const EXTERNAL_REFERRER_BING = -2;
	const EXTERNAL_REFERRER_YAHOO = -3;
	const EXTERNAL_REFERRER_AOL = -4;
	const EXTERNAL_REFERRER_ASK = -5;
	const EXTERNAL_REFERRER_WIKIPEDIA = -6;
	
	//temporary cache duration
	const CACHE_TEMPORARY_DURATION = 172800; //48h
	
	private $app;
	private $logger;
	private $cache;
	private $hosts;
	
	function __construct(){
		$this->app = F::app();
		$this->logger = (new PathFinderLogger);
		$this->cache = (new PathFinderCache);
		
		$key = $this->cache->makeKey( 'PF', 'hosts' );
		//$this->hosts = $this->cache->get( $key );
		
		if ( empty( $this->hosts ) ) {
			$this->hosts = array();
		}
	}
	
	public function saveHosts(){
		$key = $this->cache->makeKey( 'PF', 'hosts' );
		$this->cache->set( $key, $this->hosts, self::CACHE_TEMPORARY_DURATION );
	}
	
	public function parseLine( $line, Array $wikis = array() ) {
		wfProfileIn( __METHOD__ );
		
		if ( empty( $wikis ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}
		
		if ( empty( $line ) ) {
			wfProfileOut( __METHOD__ );
			throw new PathFinderNoDataToParseException( 'Line is empty' );
		}
		
		$tokens = explode( "&", $line );
		
		//4 is the total number of tokens we're interested in, avoid going further if there aren't enough to save time
		if ( count( $tokens ) < 4 ) {
			wfProfileOut( __METHOD__ );
			throw new PathFinderNoDataToParseException( 'Line doesn\'t contain enough data' );
		}
		
		$data = new stdClass();
		
		/**
		 * @see extensions/wikia/WikiaStats/WikiaWebStats.php for OneDot data definition
		 */
		foreach( $tokens as $param ) {
			list( $name, $value ) = explode( '=', $param );
			
			switch( $name ) {
				case 'event':
					//event name from tracking
					//we take into consideration only pure pageviews, no events tracking requests
					//this avoids duplicated data popping up and screw the stats
					wfProfileOut( __METHOD__ );
					throw new PathFinderNoDataToParseException( 'Line refers to an event tracking call.' );
					break;
				case 'n':
					//article namespace
					//in OneDot NS_MAIN is "n=" (empty), the int cast will fix it anyways
					if ( in_array( (int) $value, $this->app->wg->PathFinderExcludeNamespaces ) ) {
						wfProfileOut( __METHOD__ );
						throw new PathFinderNoDataToParseException( 'Line refers to an article in an excluded namespace.' );
					}
					break;
				case 'c':
					//cityId
					$data->cityId = (int) $value;
					break;
				case 'a':
					//article ID
					$data->targetId = (int) $value;
					break;
				/*case 'u':
					//User ID (if logged in)
					$data->userId = (int) $value;
				 	break;*/
				case 'x':
					//Wiki DB name
					$data->dbName = urldecode( $value );
					break;
				case 'r':
					//referrer URL
					$data->referrer = urldecode( $value );
					break;
			}
		}

		if (
			!empty( $data->cityId ) &&
			!empty( $data->dbName ) &&
			!empty( $data->targetId ) &&
			!empty( $data->referrer ) &&
			array_key_exists( $data->cityId, $wikis )
		) {
			$wiki = $wikis[$data->cityId];
			$urlData = parse_url( $data->referrer );
			unset( $data->referrer );
			
			if ( empty( $urlData['host'] ) ) {
				wfProfileOut( __METHOD__ );
				throw new PathFinderNoDataToParseException( 'Line contains a malformed referrer URL.' );
			} else {
				//TODO: check if is IP or dev/verify/preview
				if (
					IP::isValid( $urlData['host'] ) ||
					preg_match( '/^(verify|preview)(\..*)?\.wikia\.com/', $urlData['host'] ) ||
					preg_match( '/\.wikia-dev\.com/', $urlData['host'] )
				) {
					wfProfileOut( __METHOD__ );
					throw new PathFinderNoDataToParseException( 'Line contains an IP or a dev-server as the referrer.' );
				}
			}
			
			if ( empty( $urlData['path'] ) ) {
				$urlData['path'] = '';
			}
			
			if ( empty( $urlData['query'] ) ) {
				$urlData['query'] = '';
			}
			
			if ( $urlData['host'] == $wiki->domain ) {
				$urlData['path'] = $this->removeWikiPrefix( $urlData['path'], true );
				
				$articleName = ( !in_array( $urlData['path'], array( '/index.php', '/api.php', '/wikia.php', '/', '' ) ) ) ?
					urldecode( substr( $urlData['path'], 1 ) ) :
					null;
				
				if ( !empty( $articleName ) ) {
					$data->internalReferrer = $articleName;
				} else {
					wfProfileOut( __METHOD__ );
					throw new PathFinderNoDataToParseException( 'Missing referrer article name' );
				}
			} else {
				$data->externalReferrer = $this->identifyExternalReferrer( $urlData['host'], $urlData['path'], $urlData['query'] );
			}
		} else {
			return false;
		}
		
		wfProfileOut( __METHOD__ );
		return $data;
	}
	
	public function identifyExternalReferrer( $host, $path, $query ) {
		if ( !empty( $host ) ) {
			$matches = array();
			$params = array();
			$result = new stdClass();
			
			$result->id = self::EXTERNAL_REFERRER_UNKNOWN;
			$result->keyword = null;
			
			$root = ( !empty( $path ) && $path != '/' ) ? $path : null;
			
			if ( !empty( $query ) ) {
				foreach ( explode( '&', $query ) as $component ) {
					$tokens = explode( '=', $component );
					$params[$tokens[0]] = ( !empty( $tokens[1] ) ) ? $tokens[1] : null;
				}
			}
			
			if ( stripos( $host, '.google.' ) ) {
				$result->id = self::EXTERNAL_REFERRER_GOOGLE;
				$result->keyword = ( !empty( $params['q'] ) ) ? urldecode( $params['q'] ) : null;
			} elseif ( stripos( $host, '.bing.' ) ) {
				$result->id = self::EXTERNAL_REFERRER_BING;
				$result->keyword = ( !empty( $params['q'] ) ) ? urldecode( $params['q'] ) : null;
			} elseif ( stripos( $host, '.yahoo.' ) ) {
				$result->id = self::EXTERNAL_REFERRER_YAHOO;
				$result->keyword = ( !empty( $params['p'] ) ) ? urldecode( $params['p'] ) : null;
			} elseif ( stripos( $host, '.aol.' ) ) {
				$result->id = self::EXTERNAL_REFERRER_AOL;
				$result->keyword = ( !empty( $params['q'] ) ) ? urldecode( $params['q'] ) : null;
			} elseif ( stripos( $host, '.ask.' ) ) {
				$result->id = self::EXTERNAL_REFERRER_ASK;
				$result->keyword = ( !empty( $params['q'] ) ) ? urldecode( $params['q'] ) : null;
			} elseif ( stripos( $host, '.wikipedia.' ) ) {
				$result->id = self::EXTERNAL_REFERRER_WIKIPEDIA;
				$result->keyword = $root;
			} else {
				/*
				$key = $this->cache->makeKey( 'PF', 'domain2cityid', $host );
				$cityId = $this->cache->get( $key );
				
				if ( !is_numeric( $cityId ) ) {
					//force to 0 if null via int cast
					$this->cache->set( $key , (int) WikiFactory::DomainToID( $host ), self::CACHE_TEMPORARY_DURATION );
				}
				*/
				
				if ( !isset( $this->hosts[$host] ) ) {
					$this->hosts[$host] = (int) WikiFactory::DomainToID( $host );
				}
				
				if ( !empty( $this->hosts[$host] ) ) {
					$result->id = $this->hosts[$host];
					$root = ( !empty( $root ) ) ? $this->removeWikiPrefix( $root ) : null;
					
					if ( !empty( $root ) && $root == 'index.php') {
						$result->keyword = ( !empty( $params['title'] ) ) ? urldecode( $params['title'] ) : null;
					} else {
						$result->keyword = $root;
					}
				}
			}
		} else {
			return false;
		}
		
		return $result;
	}
	
	public function analyzeData( $data, Array &$output ){
		wfProfileIn( __METHOD__ );
		
		if ( empty( $data ) ) {
			wfProfileOut( __METHOD__ );
			throw new PathFinderNoDataToAnalyzeException();
		}
		
		$title = BetterGlobalTitle::newFromText( $data['r'], $data['c'], $data['x'] );

		if (
			$title instanceof Title &&
			$title->exists() &&
			$title->getArticleID() != $data[ 'a' ] &&
			!in_array( $title->getNamespace(), $this->app->wg->PathFinderExcludeNamespaces )
		) {
			$referrerID = $title->getArticleID();
			$targetID = $data[ 'a' ];
			
			$key = "{$referrerID}_{$targetID}";
			
			if ( !key_exists( $key, $output ) ) {
				$obj = new stdClass();
				$obj->cityID = (int) $data[ 'c' ];
				$obj->referrerID = (int) $referrerID;
				$obj->targetID = (int) $targetID;
				$obj->counter = 1;
				
				$output[$key] = $obj;
			} else {
				$output[$key]->counter++;
			}
		} else {
			wfProfileOut( __METHOD__ );
			throw new PathFinderNoDataToAnalyzeException( 'Invalid title.' );
		}
		
		wfProfileOut( __METHOD__ );
	}
	
	private function removeWikiPrefix( $str, $keepLeadingSlash = false ){
		return preg_replace( '#^/wiki/#', ( $keepLeadingSlash ) ? '/' : '', $str );
	}
	
	private function getCacheKey(){
		return $this->cache->makeKey( func_get_args() );
	}
}

class PathFinderNoDataToParseException extends WikiaException{
	function __construct( $msg = 'No data to parse.' ) {
		parent::__construct( $msg );
	}
}

class PathFinderNoDataToAnalyzeException extends WikiaException{
	function __construct( $msg = 'No data to Analyze.' ) {
		parent::__construct( $msg );
	}
}