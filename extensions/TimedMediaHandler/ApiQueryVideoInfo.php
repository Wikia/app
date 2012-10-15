<?php 
/**
 * Extends imageinfo with support for videoinfo sources property.
 * 
 * Alternatively core ApiQueryImageInfo could support being extended in some straightforward ways.
 * see: http://www.mediawiki.org/wiki/User:Catrope/Extension_review/TimedMediaHandler#ApiQueryVideoInfo.php
 * 
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	// Eclipse helper - will be ignored in production
	require_once( "ApiBase.php" );
}

class ApiQueryVideoInfo extends ApiQueryImageInfo {

	public function __construct( $query, $moduleName, $prefix = 'vi' ) {
		// We allow a subclass to override the prefix, to create a related API module.
		// Some other parts of MediaWiki construct this with a null $prefix, which used to be ignored when this only took two arguments
		if ( is_null( $prefix ) ) {
			$prefix = 'vi';
		}
		parent::__construct( $query, $moduleName, $prefix );
	}

	public function getDescription() {
		return 'Extends imageinfo to include video source information';
	}

	static function getInfo( $file, $prop, $result, $thumbParams = null, $version = 'latest' ) {
		$vals = parent::getInfo( $file, $prop, $result, $thumbParams = null );
		if( isset( $prop['derivatives'] ) ){
			$vals['derivatives'] = WebVideoTranscode::getSources( $file, array( 'nodata', 'fullurl') );
		}	
		return $vals;
	}

	public static function getPropertyNames( $filter = array() ) {	
		$prop = parent::getPropertyNames();
		$prop[] = 'derivatives';
		return $prop;
	}

	public static function getPropertyDescriptions( $filter = array() ) {
		$s = parent::getPropertyDescriptions();
		$s[] = ' derivatives 	-Adds an array of video source derivatives';
		return $s;
	}

	public function getExamples() {
		return array(
			'api.php?action=query&titles=File:Folgers.ogv&prop=videoinfo',
		);
	}

	/**
	 * Execute and getAllowedprops have to be copied verbatim because of static self:: references
	 *
	 * With late static binding this would be avoidable:
	 * http://php.net/manual/en/language.oop5.late-static-bindings.php
	 */
	public function execute() {
		$params = $this->extractRequestParams();

		$prop = array_flip( $params['prop'] );

		$scale = $this->getScale( $params );

		$pageIds = $this->getPageSet()->getAllTitlesByNamespace();
		if ( !empty( $pageIds[NS_FILE] ) ) {
			$titles = array_keys( $pageIds[NS_FILE] );
			asort( $titles ); // Ensure the order is always the same

			$skip = false;
			if ( !is_null( $params['continue'] ) ) {
				$skip = true;
				$cont = explode( '|', $params['continue'] );
				if ( count( $cont ) != 2 ) {
					$this->dieUsage( 'Invalid continue param. You should pass the original ' .
							'value returned by the previous query', '_badcontinue' );
				}
				$fromTitle = strval( $cont[0] );
				$fromTimestamp = $cont[1];
				// Filter out any titles before $fromTitle
				foreach ( $titles as $key => $title ) {
					if ( $title < $fromTitle ) {
						unset( $titles[$key] );
					} else {
						break;
					}
				}
			}

			$result = $this->getResult();
			$images = RepoGroup::singleton()->findFiles( $titles );
			foreach ( $images as $img ) {
				// Skip redirects
				if ( $img->getOriginalTitle()->isRedirect() ) {
					continue;
				}

				$start = $skip ? $fromTimestamp : $params['start'];
				$pageId = $pageIds[NS_IMAGE][ $img->getOriginalTitle()->getDBkey() ];

				$fit = $result->addValue(
					array( 'query', 'pages', intval( $pageId ) ),
					'imagerepository', $img->getRepoName()
				);
				if ( !$fit ) {
					if ( count( $pageIds[NS_IMAGE] ) == 1 ) {
						// The user is screwed. imageinfo can't be solely
						// responsible for exceeding the limit in this case,
						// so set a query-continue that just returns the same
						// thing again. When the violating queries have been
						// out-continued, the result will get through
						$this->setContinueEnumParameter( 'start',
							wfTimestamp( TS_ISO_8601, $img->getTimestamp() ) );
					} else {
						$this->setContinueEnumParameter( 'continue',
							$this->getContinueStr( $img ) );
					}
					break;
				}

				// Check if we can make the requested thumbnail, and get transform parameters.
				$finalThumbParams = $this->mergeThumbParams( $img, $scale, $params['urlparam'] );

				// Get information about the current version first
				// Check that the current version is within the start-end boundaries
				$gotOne = false;
				if (
					( is_null( $start ) || $img->getTimestamp() <= $start ) &&
					( is_null( $params['end'] ) || $img->getTimestamp() >= $params['end'] )
				) {
					$gotOne = true;
					
					$fit = $this->addPageSubItem( $pageId,
						self::getInfo( $img, $prop, $result, $finalThumbParams ) );
					if ( !$fit ) {
						if ( count( $pageIds[NS_IMAGE] ) == 1 ) {
							// See the 'the user is screwed' comment above
							$this->setContinueEnumParameter( 'start',
								wfTimestamp( TS_ISO_8601, $img->getTimestamp() ) );
						} else {
							$this->setContinueEnumParameter( 'continue',
								$this->getContinueStr( $img ) );
						}
						break;
					}
				}

				// Now get the old revisions
				// Get one more to facilitate query-continue functionality
				$count = ( $gotOne ? 1 : 0 );
				$oldies = $img->getHistory( $params['limit'] - $count + 1, $start, $params['end'] );
				foreach ( $oldies as $oldie ) {
					if ( ++$count > $params['limit'] ) {
						// We've reached the extra one which shows that there are additional pages to be had. Stop here...
						// Only set a query-continue if there was only one title
						if ( count( $pageIds[NS_FILE] ) == 1 ) {
							$this->setContinueEnumParameter( 'start',
								wfTimestamp( TS_ISO_8601, $oldie->getTimestamp() ) );
						}
						break;
					}
					$fit = $this->addPageSubItem( $pageId,
						self::getInfo( $oldie, $prop, $result, $finalThumbParams ) );
					if ( !$fit ) {
						if ( count( $pageIds[NS_IMAGE] ) == 1 ) {
							$this->setContinueEnumParameter( 'start',
								wfTimestamp( TS_ISO_8601, $oldie->getTimestamp() ) );
						} else {
							$this->setContinueEnumParameter( 'continue',
								$this->getContinueStr( $oldie ) );
						}
						break;
					}
				}
				if ( !$fit ) {
					break;
				}
				$skip = false;
			}

			$data = $this->getResultData();
			foreach ( $data['query']['pages'] as $pageid => $arr ) {
				if ( !isset( $arr['imagerepository'] ) ) {
					$result->addValue(
						array( 'query', 'pages', $pageid ),
						'imagerepository', ''
					);
				}
				// The above can't fail because it doesn't increase the result size
			}
		}
	}

	public function getAllowedParams() {
		return array(
			'prop' => array(
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_DFLT => 'timestamp|user',
				ApiBase::PARAM_TYPE => self::getPropertyNames()
			),
			'limit' => array(
				ApiBase::PARAM_TYPE => 'limit',
				ApiBase::PARAM_DFLT => 1,
				ApiBase::PARAM_MIN => 1,
				ApiBase::PARAM_MAX => ApiBase::LIMIT_BIG1,
				ApiBase::PARAM_MAX2 => ApiBase::LIMIT_BIG2
			),
			'start' => array(
				ApiBase::PARAM_TYPE => 'timestamp'
			),
			'end' => array(
				ApiBase::PARAM_TYPE => 'timestamp'
			),
			'urlwidth' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_DFLT => -1
			),
			'urlheight' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_DFLT => -1
			),
			'urlparam' => array(
				ApiBase::PARAM_DFLT => '',
				ApiBase::PARAM_TYPE => 'string',
			),
			'continue' => null,
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryVideoInfo.php 103540 2011-11-18 00:39:58Z dale $';
	}

}