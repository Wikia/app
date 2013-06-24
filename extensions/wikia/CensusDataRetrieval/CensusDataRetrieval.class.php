<?php
/**
 * class CensusDataRetrieval
 * For retrieving data from Census DB
 *
 * @author Lucas TOR Garczewski <tor@wikia-inc.com>
 * @author Kamil Koterba <kamil@wikia-inc.com>
 * @since Nov 2012 | MediaWiki 1.19
 */
class CensusDataRetrieval {
	var $app;
	var $query = '';
	var $data = array();
	var $type = null;

	var $supportedTypes = array( 'vehicle', 'item' );

	// mapping array translating census data into tempate call data
	// note: a null value means a user-supplied parameter, not in Census
	var $typeMap = array(
		'vehicle' => array(
			'name'          => 'name.wikilang',
			'type'          => 'type',
			'description'   => 'description.wikilang',
			'factions'      => 'collection:factions.name',
			'cost'          => 'ingame_costs.cost',
			'cost_resource' => 'ingame_costs.resource.wikilang',
			'decay'         => 'decay'
		),
		'item'    => array(
			'name'                       => 'name.wikilang',
			'description'                => 'description.wikilang',
			'activatable_recast_seconds' => 'activatable_recast_seconds',
			'combat_only'                => 'combat_only',
			'max_stack_size'             => 'max_stack_size',
			'min_profile_rank'           => 'min_profile_rank',
			'power_rating'               => 'power_rating',
			'rarity'                     => 'rarity',
			'type'                       => 'type',
			'use_requirement'            => 'use_requirement',
		)
	);

	/**
	 * Cachable Array containing information about names of records
	 * of all supported types, indexed by type and id
	 * 'type.id' => 'name'
	 * @var Array
	 */
	var $censusDataArr = array();
	/**
	 * Same like censusDataArr, but contains English phrases
	 * Used when $censusDataArr is non english.
	 * @var Array
	 */
	var $censusDataArrDefault = array();

	const QUERY_URL     = 'http://data.soe.com/s:wikia/json/get/ps2/%s/%s';
	const FLAG_CATEGORY = 'census-data-retrieval-flag-category';

	/**
	 * entry point
	 * called by hook 'onEditFormPreloadText'
	 * @return true
	 */
	public static function retrieveFromName( &$editPage )	{
		wfProfileIn( __METHOD__ );
		// @TODO check if namespace is correct, quit if not
		if ( !$editPage->mTitle->getArticleId() ) { //only on creating new article
			$cdr    = new self( $editPage->mTitle );
			$result = $cdr->getPreformattedContent();
			if ( $result ) {
				$editPage->textbox1 = $result;
				$editPage->addEditNotice( wfMsgForContent( 'census-data-retrieval-notification' ) );
			}
		}

		wfProfileOut( __METHOD__ );

		return true;
	}

	public function __construct( Title $title = null )	{
		$this->app = F::App();
		if ( $title ) {
			$this->query = $this->prepareCode( $title->getText() );
		}
		$this->censusDataArr = $this->getCacheCensusDataArr( $this->app->wg->LanguageCode, true );
		if ( $this->app->wg->LanguageCode != 'en' ) {
			$this->censusDataArrDefault = $this->getCacheCensusDataArr( 'en', true );
		}
	}

	/**
	 * Returns string of infobox and content for new page
	 * False on no data
	 */
	public function getPreformattedContent()	{
		wfProfileIn( __METHOD__ );
		if ( !$this->fetchData() ) {
			// no data in Census or something went wrong, quit
			wfProfileOut( __METHOD__ );

			return false;
		}

		$text = $this->getInfoboxCode();

		$text .= $this->getLayout();

		$text .= "\n[[" . self::getFlagCategoryTitle()->getPrefixedText() . ']]';
		wfProfileOut( __METHOD__ );

		return $text;
	}

	/**
	 * getInfoboxCode
	 * Retrieves, prepares and returns infobox template code
	 *
	 * @param $title Title is used to form a query to Census
	 * @return $templateCode String
	 */
	public function getInfobox( $title )	{
		wfProfileIn( __METHOD__ );
		if ( !$this->fetchData() ) {
			// no data in Census or something went wrong, quit
			wfProfileOut( __METHOD__ );

			return false;
		}
		$templateCode = $this->getInfoboxCode();
		wfProfileOut( __METHOD__ );

		return $templateCode;
	}

	/**
	 * Retrieves data from the Census API and filters the part we care about
	 * Requires censusDataArr and query fields be initiated
	 * @return boolean true on success, false on failed connection or empty result
	 */
	public function fetchData()	{
		wfProfileIn( __METHOD__ );
		// fetch data from API based on $this->query
		$http = new Http();

		$censusData = null;

		//Check censusDataArr to find out if relevant data exists in Census
		$key = array_search( $this->query, $this->censusDataArr );
		//look through default (English) array if there's no results for internationalized language
		if ( !$key && $this->app->wg->LanguageCode != 'en' ) {
			$key = array_search( $this->query, $this->censusDataArrDefault );
		}

		//fetch using key
		if ( $key ) {
			$key  = explode( '.', $key );
			$type = $key[0];
			$id   = $key[1];
			//fetch data from Census by type and id
			$censusData = $http->get( sprintf( self::QUERY_URL, $type, $id ) );
			$map        = json_decode( $censusData );
			if ( $map->returned > 0 ) {
				$censusData = $map->{$type . '_list'}[0];
				$this->type = $type;
			} else { //no data
				wfProfileOut( __METHOD__ );

				return false;
			}
		} else { //no data
			wfProfileOut( __METHOD__ );

			return false;
		}

		// error handling
		if ( empty( $censusData ) ) {
			wfDebug( __METHOD__ . 'Connection problem or no data' );
			wfProfileOut( __METHOD__ );

			return false;
		}

		wfProfileOut( __METHOD__ );

		// use data map to filter out unneeded data
		// the mapData method returns a bool, dependin on whether the
		// mapping succeeded or not.
		return ( $this->mapData( $censusData ) );
	}

	/**
	 * constructs the infobox text based on type and data
	 * @return string
	 */
	public function getInfoboxCode()	{
		wfProfileIn( __METHOD__ );
		$type = $this->getType();

		$output = '{{' . $type . " infobox";

		foreach ( $this->data as $key => $value ) {
			if ( is_object( $value ) ) {
				break; //temporary solution to prevent errors with objects (value sould be a string)
			}
			$output .= "\n|$key = ";

			if ( !is_null( $value ) ) {
				$output .= $value;
			}
		}

		$output .= "\n}}";
		wfProfileOut( __METHOD__ );

		return $output;
	}

	/**
	 * getType
	 * determines type based on fetched data
	 *
	 * @return string
	 */
	public function getType()	{
		return $this->type;
	}

	/**
	 * getType
	 * determines type based on fetched data
	 *
	 * @return string
	 */
	private function prepareCode( $name )	{
		return strtolower( str_replace( ' ', '_', $name ) );
	}

	/**
	 * isSupportedType
	 *
	 * @return Boolean
	 */
	private function isSupportedType()	{
		return in_array( $this->getType(), $this->supportedTypes );
	}

	/**
	 * gets the layout (preloaded text other than the infobox) based on type
	 *
	 * @return string
	 */
	private function getLayout()	{
		$key = 'census-data-retrieval-layout-' . $this->getType();

		if ( !wfEmptyMsg( $key ) ) {
			return "\n" . wfMsgForContent( $key ) . "\n";
		} else {
			return '';
		}
	}

	/**
	 * mapData
	 * maps required data retrieved from Census to array
	 *
	 * @return array
	 */
	private function mapData( $object )	{
		wfProfileIn( __METHOD__ );
		if ( empty( $object ) ) {
			wfDebug( __METHOD__ . ': Unsupported object type' );
			wfProfileOut( __METHOD__ );

			return false;
		} else {
			//wfDebug( __METHOD__ . ": Found object of type {$object->type}" );
		}
		// perform mapping each required property basing on typeMap array
		foreach ( $this->typeMap[$this->type] as $name => $propertyStr ) {
			$value = $this->getPropValue( $object, $propertyStr );
			if ( $value != '' ) {
				$this->data[$name] = $value;
			}
		}
		//return false if empty
		if ( empty( $this->data ) ) {
			wfProfileOut( __METHOD__ );

			return false;
		}
		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * getPropValue
	 * Returns value from object by provided path
	 * Prepares params for doGetPropValue()
	 *
	 * @param $object object to retrieve data form
	 * @param $propertyStr path to value separated by '.'
	 *
	 * @return array
	 */
	private function getPropValue( $object, $propertyStr )	{
		wfProfileIn( __METHOD__ );
		$fieldPath = explode( '.', $propertyStr );
		$i         = sizeof( $fieldPath ) - 1;
		wfProfileOut( __METHOD__ );

		return $this->doGetPropValue( $object, $fieldPath );
	}

	/**
	 * doGetPropValue
	 * Returns value from object by provided path
	 * @param $object object to retrieve data form
	 * @param array $fieldPath path to value in array
	 *
	 * @return array
	 */
	private function doGetPropValue( $object, $fieldPath )	{

		$pathSize = sizeof( $fieldPath );
		for ( $i = 0; $i < $pathSize; $i++ ) {

			if ( is_object( $object ) ) {

				$propertyName = $this->prepareLangPropertyName( $fieldPath[$i], $object );
				$expectedType = '';
				$this->checkNameAndType( $propertyName, $expectedType );
				//get property
				if ( isset( $object->{$propertyName} ) ) {
					$property = $object->{$propertyName};
				} else {
					return '';
				}
				//Return if is just value
				if ( is_string( $property ) || is_int( $property ) ) {
					return $property;
				}

				//Retrieve a combined string for collection
				if ( $expectedType == 'collection' ) {
					$string = $this->getStringFromCollection( $property, array_slice( $fieldPath, $i + 1 ) );

					return $string;
				}
				//Retrieve a combined string for array
				if ( $expectedType == 'array' ) {
					$string = $this->getStringFromCollection( $property[0], array_slice( $fieldPath, $i + 1 ) );

					return $string;
				}

				//regular object - go for next property
				$object = $property;

			} elseif ( is_string( $object ) || is_int( $object ) ) {
				return $object;
			}

		}
		//if is string return
		if ( is_string( $object ) || is_int( $object ) ) {
			return $object;
		}

		//otherwise empty
		return '';
	}

	function getStringFromCollection( $object, $fieldPath )	{
		$result = '';
		if ( $object instanceof stdClass || is_array( $object ) ) {
			foreach ( $object as $element ) {
				//get property value each step
				$value = $this->doGetPropValue( $element, $fieldPath );
				if ( $value != '' ) {
					//and add to a result string
					$result .= ', ' . $value;
				}
			}
			if ( $result != '' ) {
				$result = substr( $result, 2 );
			}
		}

		return $result;
	}

	/*
 * checkNameAndType
 * Seperate name from type. If $propertyName is in form type:property_name
 * it will assign property_name to $propertyName
 * and type to $expectedType
 *
 * @param String &$propertyName can be a simple property name or in form containing type, type:property_name
 * @param String &$expectedType will be set with type if provided
 */
	private function checkNameAndType( &$propertyName, &$expectedType )	{
		if ( strpos( $propertyName, ':' ) !== false ) {
			$propertynNameArr = explode( ':', $propertyName );
			$expectedType     = $propertynNameArr[0];
			$propertyName     = $propertynNameArr[1];
		} else {
			$expectedType = '';
		}
	}

	/*
	 * prepareLangPropertyName
	 * Replaces propertyName with wiki language code if its name is 'wikilang'
	 * 
	 * @param String $propertyName
	 * @param String $object used just to make sure if field in object exists
	 */
	private function prepareLangPropertyName( $propertyName, $object )	{
		if ( $propertyName == 'wikilang' ) {
			//check whether field exists or set English language
			if ( isset( $object->{$this->app->wg->LanguageCode} ) ) {
				$propertyName = $this->app->wg->LanguageCode;
			} else {
				$propertyName = 'en';
			}
		}

		return $propertyName;
	}


	/**
	 * getCacheCensusDataArr
	 * sets Memcache object form Census gathering all required data to find
	 * object when user is creating article
	 *
	 * Memcache object:
	 * array ( 'type.id' => 'code');
	 *
	 * @param Boolean $skipCache Set true to skip cache
	 *
	 */
	private function getCacheCensusDataArr( $wikilang = 'en', $skipCache = false )	{
		wfProfileIn( __METHOD__ );
		$key  = wfMemcKey( 'census-data-' . $wikilang );
		$data = $this->app->wg->Memc->get( $key );

		if ( !empty( $data ) && !$skipCache ) {
			wfProfileOut( __METHOD__ );

			return $data;
		}

		$http = new Http();
		$data = array();
		foreach ( $this->supportedTypes as $type ) {
			$censusData = $http->get(
				sprintf( self::QUERY_URL, $type, '?c:show=id,name.' . $wikilang . '&c:limit=0' )
			);
			$map        = json_decode( $censusData );
			$this->mergeResult( $data, $map, $type );
		}
		// error handling
		if ( empty( $censusData ) ) {
			wfDebug( __METHOD__ . 'Connection problem or no data' );
			wfProfileOut( __METHOD__ );

			return array();
		}

		$this->app->wg->Memc->set( $key, $data, 3600 );
		wfProfileOut( __METHOD__ );

		return $data;
	}

	/**
	 * mergeResult
	 * adds records form provided map to provided array
	 *
	 * @param array $censusDataArr
	 * @param $map fetched collection
	 * @param $type type of object
	 *
	 */
	private function mergeResult( &$censusDataArr, $map, $type )	{
		wfProfileIn( __METHOD__ );
		if ( is_object( $map ) && $map->returned > 0 ) {
			$list = $map->{$type . '_list'};
			foreach ( $list as $obj ) {
				if ( isset( $obj->name->en ) ) {
					$censusDataArr[$type . '.' . $obj->id] = $this->prepareCode( $obj->name->en );
				}
			}
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * getFlagCategoryTitle
	 * Returns instance of Title for Census enabled pages category
	 *
	 * @return Title
	 */
	public static function getFlagCategoryTitle()	{
		return Title::newFromText( wfMsgForContent( self::FLAG_CATEGORY ), NS_CATEGORY );
	}

	/**
	 * getData
	 */
	public function getData()	{
		return $this->data;
	}

	/**
	 * setData
	 */
	public function setData( $data )	{
		$this->data = $data;
	}
}
