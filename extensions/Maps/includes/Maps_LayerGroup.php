<?php

/**
 * Class for describing map layer groups, collecdtions of MapsLayer objects
 * defined on the same layer page. The fatching of layers from the database
 * is also done from within this class.
 *
 * @since 3.0
 * 
 * @file Maps_LayerGroup.php
 * @ingroup Maps
 * 
 * @author Daniel Werner
 */
class MapsLayerGroup {

	const LAYERS_ALL = 255;
	const LAYERS_NAMED = 1;
	const LAYERS_NUMERIC = 2;

	/**
	 * Members of this group.
	 *
	 * @since 3.0
	 *
	 * @var array
	 */
	protected $layers = array();

	/**
	 * Constructor.
	 *
	 * @since 3.0
	 *
	 * @param MapsLayer[]|MapsLayer $layers MapsLayer objects as members of this group. If any
	 *        of these layers have the same name, only one of them will make it into
	 *        the group since the name is the ID within the group, though, the name is
	 *        just optional.
	 */
	public function __construct( $layers = array() ) {
		if( ! is_array( $layers ) ) {
			$layers = array( $layers );
		}
		foreach( $layers as $layer ) {
			// using the function will prevent having layers with the same name:
			$this->addLayer( $layer );
		}
	}

	/**
	 * Returns the layers which are members of this group. An empty array will be
	 * returned in case no layers belong to this group.
	 *
	 * @since 3.0
	 *
	 * @param integer $types bitfield defining whether named, numeric or all layers should be returned.
	 *        MapsLayerGroup::LAYERS_NAMED, MapsLayerGroup::LAYERS_NUMERIC or MapsLayerGroup::LAYERS_ALL
	 *
	 * @return MapsLayer[]
	 */
	public function getLayers( $types = self::LAYERS_ALL ) {
		/*
		 * For all layers: If given, take the name as key.
		 * by not doing this in the constructor we won't have conflicts with layer
		 * name changes later on.
		 */
		$namedLayers = array();
		
		foreach( $this->layers as $layer ) {
			
			if( $layer->getName() !== null ) {
				
				if( $types & self::LAYERS_NAMED ) {					
					// name as key:
					$namedLayers[ $layer->getName() ] = $layer;
				}
			}
			elseif( $types & self::LAYERS_NUMERIC ) {
				// numeric (random) key:
				$namedLayers[] = $layer;
			}
		}
		return $namedLayers;
	}

	/**
	 * Returns the layer with the given name. If the layer doesn't exist, return null.
	 *
	 * @since 3.0
	 *
	 * @param string $name
	 *
	 * @return MapsLayer|null
	 */
	public function getLayerByName( $name ) {
		// get Layers in array with named index for named layers:
		$layers = $this->getLayers();
		
		if( array_key_exists( $name, $layers ) ) {
			return $layers[ $name ];
		}		
		return null;
	}

	/**
	 * Returns whether a specific layer exists within the group.
	 *
	 * @since 3.0
	 *
	 * @param MapsLayer $layer 
	 *
	 * @return boolean
	 */
	public function hasLayer( MapsLayer $layer ) {
		foreach( $this->layers as $groupLayer ) {
			if( $layer === $groupLayer ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * This will add a layer to the collection of layers in this group if it is not a
	 * member already.
	 * Does NOT automatically store the layer in the database if the group is loaded
	 * from a page.
	 *
	 * @since 3.0
	 *
	 * @param MapsLayer $layer
	 *
	 * @return boolean whether a layer with the same name has been overwritten. Also
	 *         returns false in case the same layer exists within the group already.
	 */
	public function addLayer( MapsLayer $layer ) {

		if( $this->hasLayer( $layer ) ) {
			return false; // exact same layer already exists within group
		}

		$overwritten = false;

		// check for layer with same name in this group
		if( $layer->getName() !== null ) {
			
			// remove all layers with same name (shouldn't be more than one but be paranoid):
			do {
				$existingLayer = $this->getLayerByName( $layer->getName() );
				
				if( $existingLayer !== null ) {
					$this->removeLayer( $existingLayer );
					$overwritten = true;
				}
			}
			while( $existingLayer !== null );
		}

		$this->layers[] = $layer;
		return $overwritten; // layer with same name overwritten?
	}

	/**
	 * This will remove a layer from the collection of layers in this group.
	 * Does NOT automatically store the layer in the database if the group is loaded
	 * from a page.
	 *
	 * @since 3.0
	 *
	 * @param MapsLayer $layer 
	 *
	 * @return boolean whether the layer was a member of the group and has been removed.
	 */
	public function removeLayer ( MapsLayer $layer ) {
		foreach( $this->layers as $key => $groupLayer ) {
			if( $layer === $groupLayer ) {
				unset( $this->layers[ $key ] );
				return true;
			}
		}
		return false;
	}

	/**
	 * Get a group of layers by the title of the group. If the page doesn't contain
	 * any layers, the group will be returned anyway but won't contain any layers.
	 *
	 * @since 3.0
	 *
	 * @param Title $title
	 *
	 * @return MapsLayerGroup
	 */
	public static function newFromTitle( Title $title ) {
		// load all members defined on the page $title:
		$db = wfGetDB( DB_SLAVE );
		$conditions = array( 'layer_page_id' => $title->getArticleID() );

		$layers = self::loadMembersFromConds( $db, $conditions );
		if( $layers === false && wfGetLB()->getServerCount() > 1 ) {
			$db = wfGetDB( DB_MASTER );
			$layers = self::loadMembersFromConds( $db, $conditions );
		}
		$obj = new MapsLayerGroup( $layers );
		return $obj;
	}

	/**
	 * Given a set of conditions, fetch all matching layers from the given database
	 * connection and return them in an array
	 *
	 * @param Database $db
	 * @param array $conditions
	 *
	 * @return array|false
	 */
	protected static function loadMembersFromConds( $db, $conditions ) {
		$results = array();
		$res = self::fetchMembersFromConds( $db, $conditions );
		if( $res ) {
			// load all matching layer objects into the layer group:
			foreach( $res  as $row ) {
				if( $row ) {
					$obj = MapsLayers::newLayerFromRow( $row );
					$results[] = $obj;
				}
			}
			$res->free();
			return $results;
		}
		return false;
	}

	/**
	 * Given a set of conditions, return a ResultWrapper
	 * which will return matching database rows with the
	 * fields necessary to build the group.
	 *
	 * @param Database $db
	 * @param array $conditions
	 *
	 * @return ResultWrapper|false
	 */
	protected static function fetchMembersFromConds( $db, $conditions ) {
		$fields = MapsLayers::databaseFields();
		$res = $db->select(
			array( 'maps_layers' ),
			$fields,
			$conditions,
			__METHOD__
		);
		return $res;
	}
}
