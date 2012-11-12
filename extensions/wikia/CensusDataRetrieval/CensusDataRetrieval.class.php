<?php

class CensusDataRetrieval {
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
		),
                'zone' => array(
                        'name' => 'name.en',
                        'description' => 'description.en',
                )
                
                
	);

	const QUERY_URL = 'http://data.soe.com/s:wikia/json/get/ps2/';
	const FLAG_CATEGORY = 'census-data-retrieval-flag-category';

	/**
	 * entry point
	 * called by hook 'onEditFormPreloadText'
	 * @return true
	 */
	public static function retrieveFromName( &$text, &$title ) {
		// @TODO check if namespace is correct, quit if not

		$cdr = new self();

		$text = $cdr->execute( $title );

		return true;
	}

	/**
	 * main method, handles flow and sequence, decides when to give up
	 */
	public function execute( $title ) {
		$this->query = strtolower(str_replace(' ', '_', $title->getText()));

		if ( !$this->fetchData() ) {
			// no data in Census or something went wrong, quit
			return true;
		}

		$text = $this->parseData();

		$text .= $this->getLayout();

		$text .= "\n[[" . Title::newFromText( wfMsgForContent( self::FLAG_CATEGORY ), NS_CATEGORY )->getPrefixedText() . ']]';

		return $text;
	}

	/**
	 * gets data from the Census API and returns the part we care about
	 * @return boolean true on success, false on failed connection or empty result
	 */
	private function fetchData() {
		// fetch data from API based on $this->query
                $http = new Http();

		// @TODO find a way to query all object types, preferably in one query
                $censusData = null;
                foreach ($this->typeMap as $key => $value) {
                        $censusData = $http->get( self::QUERY_URL.$key.'/?code='.$this->query );
                        $map = json_decode($censusData);
                        $property = $key . '_list';
                        if ( $map->returned > 0 ) {
                                $censusData = $map->{$property}[0];
                                $this->type = $key;
                                break;
                        }
                }
                // error handling
		if ( empty( $censusData ) ) {
			wfDebug( __METHOD__ . 'Connection problem or no data' );
			return false;
		}
 
                // @TODO use data map to filter out unneeded data
                // 
                // @TODO assuming vehicle for now, but this needs to be generic
		return $this->mapData($censusData);
	}

	/**
	 * constructs the infobox text based on type and data
	 * @return string
	 */
	private function parseData() {
		$type = $this->getType();

		$output = '{{' . $type . " infobox";

		foreach ( $this->data as $key => $value ) {
			$output .= "\n|$key = ";

			if ( !is_null( $value ) ) {
				$output .= $value;
			}
		}

		$output .= "\n}}\n";

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
//                $arr= array();
//                preg_match('/<body>(.*)<\/body>/s', $html, $arr);
//                $json = $arr[1];
//                $json = strip_tags($json);
//                $map = json_decode($censusData);
//		foreach ( $this->supportedTypes as $type ) {
//			$property = $type . '_list';
//				$object = $map->{$property}[0];
//				
//				break;
//		}
		if ( empty( $object ) ) {
			wfDebug( __METHOD__ . ': Unsupported object type' );
			return false;
		} else {
			//wfDebug( __METHOD__ . ": Found object of type {$object->type}" );
		}

		// @TODO this needs to be generalized ot be based on a per-type map array defined in a class variable
                foreach ( $this->typeMap[$this->type] as $name => $propertyStr ) {
                        $this->data[$name] = $this->getPropValue($object, $propertyStr);
                }
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
                $fieldPath = explode('.', $propertyStr);
                $i = sizeof($fieldPath) - 1;
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
                if ( $i > 0) {
                        $object_temp = $this->doGetPropValue( $object, $fieldPath, $i-1 )->{$fieldPath[$i]};
                        return $object_temp;
                }
                return $object->{$fieldPath[$i]};
        }
        
        /**
	 * cacheCensusData
         * sets Memcache object form Census gathering all required data to find object when user is creating article
         * 
         * Memcache object:
         * array ( 'type.id' => 'code');
         * 
	 */
	private function cacheCensusData() {
	}
        
}
