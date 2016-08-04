<?php

/**
 * Static factory class for layers which also keeps track of layers defined in the wiki,
 * using abstract layer templates(in form of a layer class) which are managed via MapsLayerTypes.
 *
 * @since 3.0 (Most of the pre 3.0 'MapsLayer' class has moved to 'MapsLayerTypes')
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Daniel Werner
 */
class MapsLayers {

	/**
	 * Array with layer page site names as keys and MapsLayerGroup
	 * objects as values.
	 *
	 * @since 3.0
	 *
	 * @var MapsLayerGroup
	 */
	protected static $layerGroups = array();

	/**
	 * Returns a new instance of a layer class for the provided layer type to create
	 * an actual layer definition based on the basic layer type class.
	 *
	 * @since 3.0
	 *
	 * @param string $type name of the basic layer type.
	 * @param array  $properties definition describing the layer characteristics.
	 * @param string $name optional name to identify this particular layer within a
	 *        group of layers within a layer page. If not set, an increasing numeric
	 *        name will be assigned.
	 *
	 * @return MapsLayer
	 */
	public static function newLayerFromDefinition( $type, array $properties, $name = null ) {

		$class = MapsLayerTypes::getTypesClass( $type );

		if ( $class !== null ) {
			return new $class( $properties, $name );
		}
		else {
			throw new exception( "There is no layer class for layers of type \"$type\"." );
		}
	}

	/**
	 * Creates a new type specific MapsLayer from a feteched database row.
	 *
	 * @since 3.0
	 *
	 * @param object $row
	 *
	 * @return MapsLayer
	 */
	public static function newLayerFromRow( $row ) {
		if( is_object( $row ) ) {
			$type = $row->layer_type;
			$name = $row->layer_name; // might be null
			$data = self::parseLayerParameters( $row->layer_data );

			return self::newLayerFromDefinition( $type, $data, $name );
		}
		else {
			throw new MWException( 'Invalid row format for "MapsLayer" creation.' );
		}
	}

	/**
	 * Reads layer parameter definition in string form and returns and array containing
	 * all parameters as structured data where the key is the parameter name and the
	 * associated value its value.
	 *
	 * @since 3.0
	 *
	 * @param string $parameters
	 * @param string $itemSep separator between prameters.
	 * @param string $keyValueSep separator between parameter name and associated value.
	 *
	 * @return array
	 */
	public static function parseLayerParameters( $parameters, $itemSep = "\n", $keyValueSep = '=' ) {
		$keyValuePairs = array();

		// get 'key=value' pairs and put them into an array where key is the index for each value
		foreach ( explode( $itemSep, $parameters ) as $line ) {
			$parts = explode( $keyValueSep, $line, 2 );

			if ( count( $parts ) == 2 ) {
				// only allow basic characters as layer-description parameters:
				$key = preg_replace( '/[^a-z0-9]/', '', strtolower( $parts[0] ) );
				$keyValuePairs[ $key ] = trim( $parts[1] );
			}
		}
		return $keyValuePairs;
	}

	/**
	 * This will load an already defined layer from a layer page within the wiki. Since
	 * there can be several layers as a group on one page, this also requires the layers
	 * name within the group to identify it.
	 * If the requested layer doesn't exist, this will return null.
	 *
	 * @since 3.0
	 *
	 * @param Title $layerPage title of a page with layer definitions
	 * @param string $name layers name within the group of all layers defined in $layerPage
	 *
	 * @return MapsLayer|null
	 */
	public static function loadLayer( Title $layerPage, $name ) {
		$layers = self::loadLayerGroup( $layerPage );
		return $layers->getLayerByName( $name );
	}

	/**
	 * This will load all layers defined on a layer page and return them as
	 * MapsLayerGroup object.
	 *
	 * @since 3.0
	 *
	 * @param Title $layerPage
	 *
	 * @return MapsLayerGroup
	 */
	public static function loadLayerGroup( Title $layerPage ) {
		// try to get it from cached layers:
		$groupId = $layerPage->getPrefixedDBkey();
		if( array_key_exists( $groupId, self::$layerGroups ) ) {
			return self::$layerGroups[ $groupId ];
		}

		$layerGroup = MapsLayerGroup::newFromTitle( $layerPage );

		self::$layerGroups[ $groupId ] = $layerGroup;
		return $layerGroup;
	}

	/**
	 * Store layers of a page to database. This will remove all previous layers
	 * of that page from the database first.
	 *
	 * @since 3.0
	 *
	 * @param MapsLayerGroup $layerGroup contains all layers of the page.
	 * @param Title $title the page title the layers are associated with.
	 *
	 * @return boolean
	 */
	public static function storeLayers( MapsLayerGroup $layerGroup, Title $title ) {

		// clear cache for this one:
		unset( self::$layerGroups[ $title->getPrefixedDBkey() ] );

		/*
		 * create data for multiple row insert:
		 */
		$pageId = $title->getArticleID();

		foreach( $layerGroup->getLayers() as $layer ) {
			$dbLayers[] = self::databaseRowFromLayer( $layer, $pageId );
		}

		/*
				 * insert all layer rows of the page into database:
				 */
		$db = wfGetDB( DB_MASTER );

		// delete old, stored layers first:
		$db->delete( 'maps_layers', array( 'layer_page_id' => $pageId ), __METHOD__ );

		if( empty( $dbLayers ) ) {
			// empty group, nothing to insert
			return true;
		}
		else {
			// insert new rows:
			return $db->insert( 'maps_layers', $dbLayers, __METHOD__ );
		}
	}

	/**
	 * Return the list of database fields that should be selected to create a new MapsLayer.
	 *
	 * @since 3.0
	 */
	public static function databaseFields() {
		return array(
			'layer_page_id',
			'layer_name',
			'layer_type',
			'layer_data'
		);
	}

	/**
	 * Returns database fields as keys and an associated value taken from a layer as value, ready
	 * for database insert.
	 *
	 * @since 3.0
	 *
	 * @param MapsLayer $layer
	 * @param integer   $pageId The article id of the page the layer should be associated to.
	 *                  For example "Title::getArticleID()".
	 *
	 * @return array
	 */
	public static function databaseRowFromLayer( MapsLayer $layer, $pageId  ) {

		// format layer properties array:
		$properties = array();
		foreach( $layer->getProperties() as $key => $prop ) {
			$properties[] = "$key=$prop";
		}
		$properties = implode( "\n", $properties );

		return array(
			'layer_page_id' => $pageId,
			'layer_name'    => $layer->getName(), // might be null
			'layer_type'    => $layer->getType(),
			'layer_data'    => $properties
		);
	}
}

