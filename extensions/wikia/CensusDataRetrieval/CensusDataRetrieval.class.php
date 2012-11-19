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
        
	var $supportedTypes = array( 'vehicle', 'zone' );

	// mapping array translating census data into tempate call data
	// note: a null value means a user-supplied parameter, not in Census
	var $typeMap = array(
		'vehicle' => array(
			'name' => 'name.en',
			'type' => 'type',
			'description' => 'description.en',
			'cost' => 'ingame_costs.cost',
			'cost_resource' => 'ingame_costs.resource.en',
                        'decay' => 'decay'
		),
                'item' => array(
                        'activatable_recast_seconds' => 'activatable_recast_seconds',
                        'combat_only' => 'combat_only',
                        'max_stack_size' => 'max_stack_size',
                        'min_profile_rank' => 'min_profile_rank',
                        'power_rating' => 'power_rating',
                        'rarity' => 'rarity',
                        'type' => 'type',
                        'use_requirement' => 'use_requirement',
                        'activatable_ability' => 'activatable_ability'
                )
//                'zone' => array(
//                        'name' => 'name.en',
//                        'description' => 'description.en',
//                )
                
                
	);
        
        /**
         * Cachable Array containing information about names of records 
         * of all supported types, indexed by type and id
         * 'type.id' => 'name'
         * @var Array
         */
        var $censusDataArr = array();

	const QUERY_URL = 'http://data.soe.com/s:wikia/json/get/ps2/%s/%s';
	const FLAG_CATEGORY = 'census-data-retrieval-flag-category';

	/**
	 * entry point
	 * called by hook 'onEditFormPreloadText'
	 * @return true
	 */
	public static function retrieveFromName( &$editPage ) {
                wfProfileIn(__METHOD__);
		// @TODO check if namespace is correct, quit if not

                if ( !$editPage->mTitle->getArticleId() ) {//only on creating new article
                        $cdr = new self();
                        $result = $cdr->execute( $editPage->mTitle );
                        if ( $result ) {
                                $editPage->textbox1 = $result;
                                $editPage->addEditNotice(wfMsgForContent('census-data-retrieval-notification'));
                        }
                }
                
                wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * main method, handles flow and sequence, decides when to give up
	 */
	public function execute( $title ) {
                wfProfileIn(__METHOD__);
                $this->app = F::App();
		$this->query = $this->prepareCode( $title->getText() );
                $this->censusDataArr = $this->getCacheCensusDataArr();
		if ( !$this->fetchData() ) {
			// no data in Census or something went wrong, quit
                        wfProfileOut(__METHOD__);
			return false;
		}

		$text = $this->parseData();

		$text .= $this->getLayout();

		$text .= "\n[[" . Title::newFromText( wfMsgForContent( self::FLAG_CATEGORY ), NS_CATEGORY )->getPrefixedText() . ']]';
                wfProfileOut(__METHOD__);
                return $text;
	}
        
        /**
	 * getInfoboxCode
         * Retrieves, prepares and returns infobox template code
         * 
         * @param $title Title is used to form a query to Census
         * @return $templateCode String
	 */
        public function getInfoboxCode( Title $title ) {
                $this->app = F::App();
		$this->query = $this->prepareCode( $title->getText() );
                $this->censusDataArr = $this->getCacheCensusDataArr();
                if ( !$this->fetchData() ) {
			// no data in Census or something went wrong, quit
                        wfProfileOut(__METHOD__);
			return false;
		}
                $templateCode = $this->parseData();
                return $templateCode;
        }

	/**
	 * Retrieves data from the Census API and filters the part we care about
	 * @return boolean true on success, false on failed connection or empty result
	 */
	private function fetchData() {
                wfProfileIn(__METHOD__);
		// fetch data from API based on $this->query
                $http = new Http();

                $censusData = null;
                //Check censusDataArr to find out if relevant data exists in Census
                $key = array_search($this->query, $this->censusDataArr);
                //fetch using key
                if ( $key ) {
                        $key = explode('.', $key);
                        $type = $key[0];
                        $id = $key[1];
                        //fetch data from Census by type and id
                        $censusData = $http->get( sprintf(self::QUERY_URL, $type, $id) );
                        $map = json_decode($censusData);
                        if ( $map->returned > 0 ) {
                                $censusData = $map->{$type.'_list'}[0];
                                $this->type = $type;
                        } else {//no data
                                wfProfileOut(__METHOD__);
                                return false;
                        }
                } else {//no data
                        wfProfileOut(__METHOD__);
                        return false;
                }
                // error handling
		if ( empty( $censusData ) ) {
			wfDebug( __METHOD__ . 'Connection problem or no data' );
                        wfProfileOut(__METHOD__);
			return false;
		}
 
                wfProfileOut(__METHOD__);
                // use data map to filter out unneeded data
		return $this->mapData( $censusData );
	}

	/**
	 * constructs the infobox text based on type and data
	 * @return string
	 */
	private function parseData() {
                wfProfileIn(__METHOD__);
		$type = $this->getType();

		$output = '{{' . $type . " infobox";

		foreach ( $this->data as $key => $value ) {
			$output .= "\n|$key = ";

			if ( !is_null( $value ) ) {
				$output .= $value;
			}
		}

		$output .= "\n}}\n";
                wfProfileOut(__METHOD__);
		return $output;
	}

	/**
 	 * getType
	 * determines type based on fetched data
	 *
	 * @return string
	 */
	private function getType() {
		return $this->type;
	}
        
	/**
 	 * getType
	 * determines type based on fetched data
	 *
	 * @return string
	 */
	private function prepareCode( $name ) {
                return strtolower(str_replace(' ', '_', $name));
	}

	/**
	 * isSupportedType
	 *
	 * @return Boolean
	 */
	private function isSupportedType() {
		return in_array( $this->getType(), $this->supportedTypes );
	}

	/**
	 * gets the layout (preloaded text other than the infobox) based on type
	 *
	 * @return string
	 */
	private function getLayout() {
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
	private function mapData( $object ) {
                wfProfileIn(__METHOD__);
		if ( empty( $object ) ) {
			wfDebug( __METHOD__ . ': Unsupported object type' );
                        wfProfileOut(__METHOD__);
			return false;
		} else {
			//wfDebug( __METHOD__ . ": Found object of type {$object->type}" );
		}

		// perform mapping each required property basing on typeMap array
                foreach ( $this->typeMap[$this->type] as $name => $propertyStr ) {
                        $this->data[$name] = $this->getPropValue($object, $propertyStr);
                }
                wfProfileOut(__METHOD__);
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
        private function getPropValue( $object, $propertyStr ) {
                wfProfileIn(__METHOD__);
                $fieldPath = explode('.', $propertyStr);
                $i = sizeof($fieldPath) - 1;
                wfProfileOut(__METHOD__);
                return $this->doGetPropValue( $object, $fieldPath, $i );
        }
        
        /**
 	 * doGetPropValue
	 * Recursive function returns value from object by provided path
         * @param $object object to retrieve data form
         * @param array $fieldPath path to value in array
         * @i current step counter
	 *
	 * @return array
	 */
        private function doGetPropValue( $object, $fieldPath, $i ) {
                wfProfileIn(__METHOD__);
                if ( $i > 0) {
                        $object_temp = $this->doGetPropValue( $object, $fieldPath, $i-1 )->{$fieldPath[$i]};
                        wfProfileOut(__METHOD__);
                        return $object_temp;
                }
                wfProfileOut(__METHOD__);
                return $object->{$fieldPath[$i]};
        }
        
        /**
	 * getCacheCensusDataArr
         * sets Memcache object form Census gathering all required data to find 
         * object when user is creating article
         * 
         * Memcache object:
         * array ( 'type.id' => 'code');
         * 
	 */
	private function getCacheCensusDataArr() {
                wfProfileIn(__METHOD__);
                $key = wfMemcKey('census-data');
                $data = $this->app->wg->Memc->get($key);

                if(!empty($data)) {
                        wfProfileOut(__METHOD__);
                        return $data;
                }
                
                $http = new Http();
                $data = array();
                foreach ($this->supportedTypes as $type) {
                        $censusData = $http->get( sprintf(self::QUERY_URL, $type, '?c:show=id,name.en&c:limit=0') );
                        $map = json_decode($censusData);
                        $this->mergeResult( $data, $map, $type );
                }
                // error handling
		if ( empty( $censusData ) ) {
			wfDebug( __METHOD__ . 'Connection problem or no data' );
                        wfProfileOut(__METHOD__);
			return false;
		}
 
                $this->app->wg->Memc->set( $key, $data, 3600 );
                wfProfileOut(__METHOD__);
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
	private function mergeResult( &$censusDataArr, $map, $type) {
                wfProfileIn(__METHOD__);
                if ( is_object( $map ) && $map->returned > 0 ) {
                        $list = $map->{$type.'_list'};
                        foreach ( $list as $obj ) {
                                if ( isset($obj->name->en) ) {
                                        $censusDataArr[$type.'.'.$obj->id] = $this->prepareCode( $obj->name->en );
                                }
                        }
                }
                wfProfileOut(__METHOD__);
        }
        
        /**
	 * getFlagCategoryTitle
         * Returns instance of Title for Census enabled pages category
         * 
         * @return Title
	 */
        public function getFlagCategoryTitle () {
                return Title::newFromText( wfMsgForContent( self::FLAG_CATEGORY ), NS_CATEGORY );
        }
        
}
