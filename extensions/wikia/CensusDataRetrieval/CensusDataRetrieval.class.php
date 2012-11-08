<?php

class CensusDataRetrieval {
	var $query = '';
	var $data = array();

	var $supportedTypes = array( 'vehicle' );

	var $typeMap = array(
		'vehicle' => array(
			'name' => 'name.en',
			'type' => 'type',
		)
	);

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
                $censusData = $http->get('http://data.soe.com/s:wikia/get/ps2/vehicle/?code='.$this->query);

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
                $output = implode( ',', $this->data );
                /* use data-to-template map to put together template call wikitext */

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
 	 * getType
	 * determines type based on fetched data
	 *
	 * @return array
	 */
	private function mapData( $html ) {
                $arr= array();
                preg_match('/<body>(.*)<\/body>/s', $html, $arr);
                $json = $arr[1];
                $json = strip_tags($json);
                $map = json_decode($json);

		foreach ( $this->supportedTypes as $type ) {
			$property = $type . '_list';
			if ( isset( $map->$property ) ) {
				$object = $map->{$property}[0];
				$this->type = $type;
				break;
			}
		}

		if ( empty( $object ) ) {
			wfDebug( __METHOD__ . ': Unsupported object type' );
			return false;
		} else {
			wfDebug( __METHOD__ . ": Found object of type {$object->type}" );
		}

		// @TODO this needs to be generalized ot be based on a per-type map array defined in a class variable
		$this->data = array(
			'name' => $object->name->en,
			'type' => $object->type,
			'description' => $object->description->en,
			'cost' => $object->ingame_costs->cost,
			'cost_resource' => $object->ingame_costs->resource->en
		);

		return true;
	}
}
