<?php
/**
 * Database Classes for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

/**
 * A collection of static functions which provide general access to the
 * database using a system of categories and types.
 */
abstract class DataCenterDB {

	/* Private Static Members */

	/**
	 * A structure of categories and types which are available for access with
	 * information needed to access them including defaults used when creating
	 * object which represent them. This structure needs to be in sync with
	 * the database schema, but is at this time still separately maintained.
	 * Future modifications might include generating this structure and the
	 * SQL to create the needed tables in the database from a more central
	 * piece of information.
	 */
	private static $types = array(
		'facility' => array(
			'location' => array(
				'prefix' => 'fcl_loc_',
				'table' => 'dc_facility_locations',
				'defaults' => array(),
			),
			'space' => array(
				'prefix' => 'fcl_spc_',
				'table' => 'dc_facility_spaces',
				'defaults' => array(
					'width' => 5, 'height' => 3, 'depth' => 5, 'power' => 10000
				),
			),
		),
		'asset' => array(
			'rack' => array(
				'prefix' => 'ast_rak_',
				'table' => 'dc_rack_assets',
				'defaults' => array(),
			),
			'object' => array(
				'prefix' => 'ast_obj_',
				'table' => 'dc_object_assets',
				'defaults' => array(),
			),
		),
		'model' => array(
			'rack' => array(
				'prefix' => 'mdl_rak_',
				'table' => 'dc_rack_models',
				'defaults' => array( 'units' => 1 ),
			),
			'object' => array(
				'prefix' => 'mdl_obj_',
				'table' => 'dc_object_models',
				'defaults' => array(
					'units' => 1, 'depth' => 0, 'power' => 0
				),
			),
			'port' => array(
				'prefix' => 'mdl_prt_',
				'table' => 'dc_port_models',
				'defaults' => array(),
			),
		),
		'link' => array(
			'model' => array(
				'prefix' => 'lnk_mdl_',
				'table' => 'dc_model_links',
				'defaults' => array(),
			),
			'asset' => array(
				'prefix' => 'lnk_ast_',
				'table' => 'dc_asset_links',
				'defaults' => array(),
			),
			'field' => array(
				'prefix' => 'lnk_fld_',
				'table' => 'dc_field_links',
				'defaults' => array(),
			),
		),
		'meta' => array(
			'plan' => array(
				'prefix' => 'mta_pln_',
				'table' => 'dc_meta_plans',
				'defaults' => array(),
			),
			'change' => array(
				'prefix' => 'mta_cng_',
				'table' => 'dc_meta_changes',
				'defaults' => array(),
			),
			'tag' => array(
				'prefix' => 'mta_tag_',
				'table' => 'dc_meta_tags',
				'defaults' => array(),
			),
			'field' => array(
				'prefix' => 'mta_fld_',
				'table' => 'dc_meta_fields',
				'defaults' => array(),
			),
			'value' => array(
				'prefix' => 'mta_val_',
				'table' => 'dc_meta_values',
				'defaults' => array(),
			),
			'connection' => array(
				'prefix' => 'mta_con_',
				'table' => 'dc_meta_connections',
				'defaults' => array(),
			),
		),
	);

	/**
	 * A structure of default options which are used by MediaWiki's Database
	 * select function. This structure is recursively merged with options
	 * passed as parameters so that the minimum fields are present. For more
	 * information on the structure of each field, see the documentation on
	 * MediaWiki's Database class.
	 */
	private static $defaultOptions = array(
		'tables' => array(),
		'fields' => array(),
		'conditions' => array(),
		'options' => array(),
		'joins' => array(),
	);

	/* Static Functions */

	/**
	 * Checks if type exists in any of the type categories
	 * @param	category		String of category to look up type in
	 * @param	type			String of type to check for
	 */
	public static function isType(
		$category,
		$type
	) {
		return isset( self::$types[$category][$type] );
	}

	/**
	 * Checks if type exists in the facility category
	 * @param	type			String of asset type to check for
	 */
	public static function isFacilityType(
		$type
	) {
		return isset( self::$types['facility'][$type] );
	}

	/**
	 * Checks if type exists in the link category
	 * @param	type			String of asset type to check for
	 */
	public static function isLinkType(
		$type
	) {
		return isset( self::$types['link'][$type] );
	}

	/**
	 * Checks if type exists in the asset category
	 * @param	type			String of asset type to check for
	 */
	public static function isAssetType(
		$type
	) {
		return isset( self::$types['asset'][$type] );
	}

	/**
	 * Checks if type exists in the model category
	 * @param	type			String of model type to check for
	 */
	public static function isModelType(
		$type
	) {
		return isset( self::$types['model'][$type] );
	}

	/**
	 * Checks if type exists in the asset category
	 * @param	type			String of meta type to check for
	 */
	public static function isMetaType(
		$type
	) {
		return isset( self::$types['meta'][$type] );
	}

	/**
	 * Checks if class is or is subclass of DataCenterDBRow
	 * @param	rowClass		String of name of class to check
	 */
	public static function isRowClass(
		$class
	) {
		return (
			class_exists( $class ) &&
			(
				$class == 'DataCenterDBRow' ||
				is_subclass_of( $class, 'DataCenterDBRow' )
			)
		);
	}

	/**
	 * Checks if a column name belongs to a specific type
	 * @param	category		String of category to look up type in
	 * @param	type			String of type to check for
	 * @param	columnName		String of column to look up
	 */
	public static function isColumnOfType(
		$category,
		$type,
		$columnName
	) {
		return (
			strpos( $columnName, self::$types[$category][$type]['prefix'] ) !==
			false
		);
	}

	/**
	 * Gets fully prefixed column name from simplified field name
	 * @param	category		String of category to look up type in
	 * @param	type			String of type to check for
	 * @param	fieldName		String of field to look up
	 */
	public static function getColumnName(
		$category,
		$type,
		$fieldName
	) {
		return isset( self::$types[$category][$type] ) ?
			self::$types[$category][$type]['prefix'] . $fieldName :
			null;
	}

	/**
	 * Gets simplified field name from fully prefixed column name
	 * @param	category		String of category to look up type in
	 * @param	type			String of type to check for
	 * @param	columnName		String of column to look up
	 */
	public static function getFieldName(
		$category,
		$type,
		$columnName
	) {
		return isset( self::$types[$category][$type]['prefix'] ) ?
			substr(
				$columnName, strlen( self::$types[$category][$type]['prefix'] )
			) :
			null;
	}

	/**
	 * Gets table name from category and type
	 * @param	category		String of category to look up type in
	 * @param	type			String of type look up table in
	 */
	public static function getTableName(
		$category,
		$type
	) {
		return isset( self::$types[$category][$type]['table'] ) ?
			self::$types[$category][$type]['table'] :
			null;
	}

	/**
	 * Gets row defaults from category and type
	 * @param	category		String of category to look up type in
	 * @param	type			String of type look up defaults in
	 */
	public static function getRowDefaults(
		$category,
		$type
	) {
		return isset( self::$types[$category][$type]['defaults'] ) ?
			self::$types[$category][$type]['defaults'] :
			array();
	}

	/**
	 * Gets all rows of a category and type in the form of a specific sub-class
	 * of DataCenterDBRow
	 * @param	class			String of Subclass of DataCenterDBRow or null to
	 * 							default to DataCenterDBRow used as the type when
	 * 							building results
	 * @param	category		String of category to look up type in
	 * @param	type			String of type look up rows in
	 * @param	options			Optional Associative array of tables, fields,
	 * 							conditions and options each being the array
	 * 							form of compatible arguments to MediaWiki's
	 * 							Database select statement.
	 */
	public static function getRows(
		$class,
		$category,
		$type,
		array $options = array()
	) {
		if ( !self::isType( $category, $type ) ) {
			throw new MWException(
				$category . '/' . $type . ' is not a valid type'
			);
		}
		if ( !self::isRowClass( $class ) ) {
			throw new MWException(
				$class . ' is not compatable with DataCenterDBRow'
			);
		}
		$options = array_merge_recursive(
			self::$defaultOptions,
			array(
				'tables' => array( self::getTableName( $category, $type ) ),
				'fields' => array( '*' ),
			),
			$options
		);
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			array_unique( $options['tables'] ),
			$options['fields'],
			$options['conditions'],
			__METHOD__,
			$options['options'],
			$options['joins']
		);
		$objects = array();
		while ( $row = $dbr->fetchRow( $res ) ) {
			$objects[] = new $class( $category, $type, $row );
		}
		return $objects;
	}

	/**
	 * Gets rows of a category and type with a matching ID in the form of a
	 * specific sub-class of DataCenterDBRow
	 * @param	class			String of Subclass of DataCenterDBRow or null to
	 * 							default to DataCenterDBRow used as the type when
	 * 							building results
	 * @param	category		String of category to look up type in
	 * @param	type			String of type look up rows in
	 * @param	options			Optional Associative array of tables, fields,
	 * 							conditions and options each being the array
	 * 							form of compatible arguments to MediaWiki's
	 * 							Database select statement.
	 */
	public static function getRow(
		$class,
		$category,
		$type,
		$id,
		array $options = array()
	) {
		if ( !self::isType( $category, $type ) ) {
			throw new MWException(
				$category . '/' . $type . ' is not a valid type'
			);
		}
		if ( !self::isRowClass( $class ) ) {
			throw new MWException(
				$class . ' is not compatable with DataCenterDBRow'
			);
		}
		$options = array_merge_recursive(
			self::$defaultOptions,
			array(
				'tables' => array( self::getTableName( $category, $type ) ),
				'fields' => array( '*' ),
				'conditions' => array(
					self::getColumnName( $category, $type, 'id' ) => $id
				),
				'options' => array( 'LIMIT' => 1 )
			),
			$options
		);
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			array_unique( $options['tables'] ),
			$options['fields'],
			$options['conditions'],
			__METHOD__,
			$options['options'],
			$options['joins']
		);
		$row = $dbr->fetchRow( $res );
		if ( $row ) {
			return new $class( $category, $type, $row );
		}
		return null;
	}

	/**
	 * Gets number of rows of a category and type
	 * @param	category		String of category to look up type in
	 * @param	type			String of type look up rows in
	 * @param	options			Optional Associative array of tables, fields,
	 * 							conditions and options each being the array
	 * 							form of compatible arguments to MediaWiki's
	 * 							Database select statement.
	 */
	public static function numRows(
		$category,
		$type,
		array $options = array()
	) {
		if ( !self::isType( $category, $type ) ) {
			throw new MWException(
				$category . '/' . $type . ' is not a valid type'
			);
		}
		$options = array_merge_recursive(
			self::$defaultOptions,
			array(
				'tables' => array( self::getTableName( $category, $type ) ),
				'fields' => array( '*' ),
			),
			$options
		);
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			array_unique( $options['tables'] ),
			$options['fields'],
			$options['conditions'],
			__METHOD__,
			$options['options'],
			$options['joins']
		);
		return $dbr->numRows( $res );
	}

	/**
	 * Gets rows from a target that match query on specific columns
	 * @param	target			Array with category, type and fields keys where
	 * 							category and type are strings and fields is a
	 * 							string of a field name or an array of strings of
	 * 							field names
	 * @param	query			String of search terms
	 * @param	options			Optional Associative array of tables, fields,
	 * 							conditions and options each being the array
	 * 							form of compatible arguments to MediaWiki's
	 * 							Database select statement.
	 */
	public static function getMatches(
		$class,
		$category,
		$type,
		$fields,
		$query,
		array $options = array()
	) {
		$dbr = wfGetDB( DB_SLAVE );
		if ( !self::isType( $category, $type ) ) {
			throw new MWException(
				$category . '/' . $type . ' is not a valid type'
			);
		}
		$options = array_merge_recursive(
			self::$defaultOptions,
			array(
				'tables' => array( self::getTableName( $category, $type ) ),
				'fields' => array( '*' ),
			),
			self::buildMatch( $category, $type, $fields, $query ),
			$options
		);
		$res = $dbr->select(
			array_unique( $options['tables'] ),
			$options['fields'],
			$options['conditions'],
			__METHOD__,
			$options['options'],
			$options['joins']
		);
		$results = array();
		while ( $row = $dbr->fetchRow( $res ) ) {
			$results[] = new $class( $category, $type, $row );
		}
		return $results;
	}

	/**
	 * Gets number of rows of a category and type
	 * @param	target			Array with category, type and fields keys where
	 * 							category and type are strings and fields is a
	 * 							string of a field name or an array of strings of
	 * 							field names
	 * @param	query			String of search terms
	 * @param	options			Optional Associative array of tables, fields,
	 * 							conditions and options each being the array
	 * 							form of compatible arguments to MediaWiki's
	 * 							Database select statement.
	 */
	public static function numMatches(
		$category,
		$type,
		$fields,
		$query,
		array $options = array()
	) {
		$dbr = wfGetDB( DB_SLAVE );
		if ( !self::isType( $category, $type ) ) {
			throw new MWException(
				$category . '/' . $type . ' is not a valid type'
			);
		}
		$options = array_merge_recursive(
			self::$defaultOptions,
			array(
				'tables' => array( self::getTableName( $category, $type ) ),
				'fields' => array( '*' ),
			),
			self::buildMatch( $category, $type, $fields, $query ),
			$options
		);
		$res = $dbr->select(
			array_unique( $options['tables'] ),
			$options['fields'],
			$options['conditions'],
			__METHOD__,
			$options['options'],
			$options['joins']
		);
		return $dbr->numRows( $res );
	}

	/**
	 * Gets all fields of a category type and field in the form of an
	 * associative array with pre-translated column names based on type
	 * @param	category		String of category to look up type in
	 * @param	type			String of type look up field in
	 * @param	field			String of field to look up
	 * @param	options			Optional Associative array of tables, fields,
	 * 							conditions and options each being the array
	 * 							form of compatible arguments to MediaWiki's
	 * 							Database select statement.
	 */
	public static function getFields(
		$category,
		$type,
		$field,
		array $options = array()
	) {
		if ( !self::isType( $category, $type ) ) {
			throw new MWException(
				$category . '/' . $type . ' is not a valid type'
			);
		}
		if ( !is_scalar( $field ) || $field == null ) {
			throw new MWException(
				$field . ' is not a field name'
			);
		}
		$options = array_merge_recursive(
			self::$defaultOptions,
			array(
				'tables' => array( self::getTableName( $category, $type ) ),
				'fields' => array( $field ),
			),
			$options
		);
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			array_unique( $options['tables'] ),
			$options['fields'],
			$options['conditions'],
			__METHOD__,
			$options['options'],
			$options['joins']
		);
		$fields = array();
		while ( $row = $dbr->fetchRow( $res ) ) {
			$fields[] = $row[$field];
		}
		return $fields;
	}

	/**
	 * Gets list of valid enum values for a specific field
	 * @param	category		String of category to look up type in
	 * @param	type			String of type to look up field in
	 * @param	field			String of field to look up values for
	 */
	public static function getEnum(
		$category,
		$type,
		$field
	){
		if ( !self::isType( $category, $type ) ) {
			throw new MWException(
				$category . '/' . $type . ' is not a valid type'
			);
		}
		$tableName = self::getTableName( $category, $type );
		$columnName = self::getColumnName( $category, $type, $field );
		$dbr = wfGetDB( DB_SLAVE );
		$tableName = $dbr->tablePrefix() . $tableName;
		$res = $dbr->query(
			"SHOW COLUMNS FROM {$tableName} LIKE '{$columnName}'",
			__METHOD__
		);
		$row = $dbr->fetchRow( $res );
		return (
			$row ?
			explode(
				"','",
				preg_replace(
					"/(enum|set)\('(.+?)'\)/","\\2", $row['Type']
				)
			) :
			array( 0 => 'None' )
		);
	}

	/**
	 * Checks that a row object represents an existing row in the database
	 * @param	object			Subclass of DataCenterDBRow to check
	 */
	public static function rowExists(
		DataCenterDBRow $object
	) {
		if ( !$object instanceof DataCenterDBRow ) {
			throw new MWException(
				'Object is not an instance of DataCenterDBRow'
			);
		}
		$type = $object->getType();
		$category = $object->getCategory();
		if ( !self::isType( $category, $type ) ) {
			throw new MWException(
				$category . '/' . $type . ' is not a valid type'
			);
		}
		$dbr = wfGetDB( DB_SLAVE );
		$columnName = self::getColumnName( $category, $type, 'id' );
		$field = $dbr->selectField(
			self::getTableName( $category, $type ),
			'count(*)',
			array( $columnName => $object->getId() )
		);
		return ( $field > 0 );
	}

	/**
	 * Inserts a row in the database based on the contents of a row object
	 * @param	rowObject		Subclass of DataCenterDBRow to insert
	 */
	public static function insertRow(
		$object
	) {
		if ( !$object instanceof DataCenterDBRow ) {
			throw new MWException(
				'Object is not an instance of DataCenterDBRow'
			);
		}
		$type = $object->getType();
		$category = $object->getCategory();
		if ( !self::isType( $category, $type ) ) {
			throw new MWException(
				$category . '/' . $type . ' is not a valid type'
			);
		}
		$row = $object->getRow();
		$dbw = wfGetDB( DB_MASTER );
		$columnName = self::getColumnName( $category, $type, 'id' );
		$row[$columnName] = (
			$dbw->nextSequenceValue( $columnName . '_seq' )
		);
		$dbw->insert(
			self::getTableName( $category, $type ), $row, __METHOD__
		);
		$object->set( 'id', $dbw->insertId() );
	}

	/**
	 * Updates a row in the database based on the contents of a row object
	 * @param	object		Subclass of DataCenterDBRow to update
	 */
	public static function updateRow(
		$object
	) {
		if ( !$object instanceof DataCenterDBRow ) {
			throw new MWException(
				'Object is not an instance of DataCenterDBRow'
			);
		}
		$type = $object->getType();
		$category = $object->getCategory();
		if ( !self::isType( $category, $type ) ) {
			throw new MWException(
				$category . '/' . $type . ' is not a valid type'
			);
		}
		$dbw = wfGetDB( DB_MASTER );
		$row = $object->getRow();
		$columnName = self::getColumnName( $category, $type, 'id' );
		$dbw->update(
			self::getTableName( $category, $type ),
			$row,
			array( $columnName => $object->getId() ),
			__METHOD__
		);
	}

	/**
	 * Deletes a row from the database
	 * @param	rowObject		Subclass of DataCenterDBRow to delete
	 */
	public static function deleteRow(
		$object
	) {
		if ( !$object instanceof DataCenterDBRow ) {
			throw new MWException(
				'Object is not an instance of DataCenterDBRow'
			);
		}
		$type = $object->getType();
		$category = $object->getCategory();
		if ( !self::isType( $category, $type ) ) {
			throw new MWException(
				$category . '/' . $type . ' is not a valid type'
			);
		}
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete(
			self::getTableName( $category, $type ),
			array(
				self::getColumnName( $category, $type, 'id' ) =>
					$object->getId()
			),
			__METHOD__
		);
	}

	/* Asset Wrappers */

	/**
	 * Wraps self::getRows specializing...
	 * - class as DataCenterDBAsset
	 * - category as asset
	 */
	public static function getAssets(
		$type,
		array $options = array()
	) {
		return self::getRows( 'DataCenterDBAsset', 'asset', $type, $options );
	}

	/**
	 * Wraps self::getRow specializing...
	 * - class as DataCenterDBAsset
	 * - category as asset
	 */
	public static function getAsset(
		$type,
		$id
	) {
		return self::getRow( 'DataCenterDBAsset', 'asset', $type, $id );
	}

	/**
	 * Wraps self::numRows specializing...
	 * - category as asset
	 */
	public static function numAssets(
		$type,
		array $options = array()
	) {
		return self::numRows( 'asset', $type, $options );
	}

	/* Model Wrappers */

	/**
	 * Wraps self::getRows specializing...
	 * - class as DataCenterDBModel
	 * - category as model
	 */
	public static function getModels(
		$type,
		array $options = array()
	) {
		return self::getRows( 'DataCenterDBModel', 'model', $type, $options );
	}

	/**
	 * Wraps self::getRow specializing...
	 * - class as DataCenterDBModel
	 * - category as model
	 */
	public static function getModel(
		$type,
		$id
	) {
		return self::getRow( 'DataCenterDBModel', 'model', $type, $id );
	}

	/**
	 * Wraps self::numRows specializing...
	 * - category as model
	 */
	public static function numModels(
		$type,
		array $options = array()
	) {
		return self::numRows( 'model', $type, $options );
	}

	/* Link Wrappers */

	/**
	 * Wraps self::getRows specializing...
	 * - class as DataCenterDBLink
	 * - category as link
	 */
	public static function getLinks(
		$type,
		array $options = array()
	) {
		return self::getRows( 'DataCenterDBLink', 'link', $type, $options );
	}

	/**
	 * Wraps self::getRow specializing...
	 * - class as DataCenterDBLink
	 * - category as link
	 */
	public static function getLink(
		$type,
		$id
	) {
		return self::getRow( 'DataCenterDBLink', 'link', $type, $id );
	}

	/**
	 * Wraps self::numRows specializing...
	 * - category as link
	 */
	public static function numLinks(
		$type,
		array $options = array()
	) {
		return self::numRows( 'link', $type, $options );
	}

	/**
	 * Wraps self::getRows specializing...
	 * - class as DataCenterDBAssetLink
	 * - category as link
	 * - type as asset
	 */
	public static function getAssetLinks(
		array $options = array()
	) {
		return self::getRows(
			'DataCenterDBAssetLink', 'link', 'asset', $options
		);
	}

	/**
	 * Wraps self::getRow specializing...
	 * - class as DataCenterDBAssetLink
	 * - category as link
	 * - type as asset
	 */
	public static function getAssetLink(
		$id
	) {
		return self::getRow( 'DataCenterDBAssetLink', 'link', 'asset', $id );
	}

	/**
	 * Wraps self::numRows specializing...
	 * - category as link
	 * - type as asset
	 */
	public static function numAssetLinks(
		array $options = array()
	) {
		return self::numRows( 'link', 'asset', $options );
	}

	/**
	 * Wraps self::getRows specializing...
	 * - class as DataCenterDBModelLink
	 * - category as link
	 * - type as model
	 */
	public static function getModelLinks(
		array $options = array()
	) {
		return self::getRows(
			'DataCenterDBModelLink', 'link', 'model', $options
		);
	}

	/**
	 * Wraps self::getRow specializing...
	 * - class as DataCenterDBModelLink
	 * - category as link
	 * - type as model
	 */
	public static function getModelLink(
		$id
	) {
		return self::getRow( 'DataCenterDBModelLink', 'link', 'model', $id );
	}

	/**
	 * Wraps self::numRows specializing...
	 * - category as link
	 * - type as model
	 */
	public static function numModelLinks(
		array $options = array()
	) {
		return self::numRows( 'link', 'model', $options );
	}

	/**
	 * Wraps self::getRows specializing...
	 * - class as DataCenterDBMetaFieldLink
	 * - category as link
	 * - type as field
	 */
	public static function getMetaFieldLinks(
		array $options = array()
	) {
		return self::getRows( 'DataCenterDBMetaFieldLink', 'link', 'field', $options );
	}

	/**
	 * Wraps self::getRow specializing...
	 * - class as DataCenterDBMetaFieldLink
	 * - category as link
	 * - type as field
	 */
	public static function getMetaFieldLink(
		$id
	) {
		return self::getRow( 'DataCenterDBMetaFieldLink', 'link', 'field', $id );
	}

	/**
	 * Wraps self::numRows specializing...
	 * - category as link
	 * - type as field
	 */
	public static function numMetaFieldLinks(
		array $options = array()
	) {
		return self::numRows( 'link', 'field', $options );
	}

	/* Facility Wrappers */

	/**
	 * Wraps self::getRows specializing...
	 * - class as DataCenterDBLocation
	 * - category as facility
	 * - type as location
	 */
	public static function getLocations(
		array $options = array()
	) {
		return self::getRows(
			'DataCenterDBLocation', 'facility', 'location', $options
		);
	}

	/**
	 * Wraps self::getRow specializing...
	 * - class as DataCenterDBLocation
	 * - category as facility
	 * - type as location
	 */
	public static function getLocation(
		$id
	) {
		return self::getRow(
			'DataCenterDBLocation', 'facility', 'location', $id
		);
	}

	/**
	 * Wraps self::numRows specializing...
	 * - category as facility
	 * - type as location
	 */
	public static function numLocations(
		array $options = array()
	) {
		return self::numRows( 'facility', 'location', $options );
	}

	/**
	 * Wraps self::getRows specializing...
	 * - class as DataCenterDBSpace
	 * - category as facility
	 * - type as space
	 */
	public static function getSpaces(
		array $options = array()
	) {
		return self::getRows(
			'DataCenterDBSpace', 'facility', 'space', $options
		);
	}

	/**
	 * Wraps self::getRow specializing...
	 * - class as DataCenterDBSpace
	 * - category as facility
	 * - type as space
	 */
	public static function getSpace(
		$id
	) {
		return self::getRow(
			'DataCenterDBSpace', 'facility', 'space', $id
		);
	}

	/**
	 * Wraps self::numRows specializing...
	 * - category as facility
	 * - type as space
	 */
	public static function numSpaces(
		array $options = array()
	) {
		return self::numRows( 'facility', 'space', $options );
	}

	/* Meta Wrappers */

	/**
	 * Wraps self::getRows specializing...
	 * - class as DataCenterDBPlan
	 * - category as meta
	 * - type as plan
	 */
	public static function getPlans(
		array $options = array()
	) {
		return self::getRows(
			'DataCenterDBPlan',
			'meta',
			'plan',
			array_merge_recursive(
				$options,
				self::buildJoin(
					'facility', 'space', 'id',
					'meta', 'plan', 'space',
					array( 'name' => 'space_name' )
				)
			)
		);
	}

	/**
	 * Wraps self::getRow specializing...
	 * - class as DataCenterDBPlan
	 * - category as meta
	 * - type as plan
	 */
	public static function getPlan(
		$id
	) {
		return self::getRow(
			'DataCenterDBPlan',
			'meta',
			'plan',
			$id,
			self::buildJoin(
				'facility', 'space', 'id',
				'meta', 'plan', 'space',
				array( 'name' => 'space_name' )
			)
		);
	}

	/**
	 * Wraps self::numRows specializing...
	 * - category as meta
	 * - type as plan
	 */
	public static function numPlans(
		array $options = array()
	) {
		return self::numRows( 'meta', 'plan', $options );
	}

	/**
	 * Wraps self::getRows specializing...
	 * - class as DataCenterDBChange
	 * - category as meta
	 * - type as change
	 */
	public static function getChanges(
		array $options = array()
	) {
		return self::getRows(
			'DataCenterDBChange',
			'meta',
			'change',
			array_merge_recursive(
				$options,
				array(
					'tables' => array( 'user' ),
					'fields' => array(
						'user_name as ' .
						self::getColumnName(
							'meta', 'change', 'username'
						)
					),
					'joins' => array(
						'user' => array(
							'LEFT JOIN',
							'user_id = ' .
							self::getColumnName(
								'meta', 'change', 'user'
							)
						)
					)
				)
			)
		);
	}

	/**
	 * Wraps self::getRow specializing...
	 * - class as DataCenterDBChange
	 * - category as meta
	 * - type as change
	 */
	public static function getChange(
		$id,
		array $options = array()
	) {
		return self::getRow(
			'DataCenterDBChange',
			'meta',
			'change',
			$id,
			array_merge_recursive(
				$options,
				array(
					'tables' => array( 'user' ),
					'fields' => array(
						'user_name as ' .
						self::getColumnName(
							'meta', 'change', 'username'
						)
					),
					'joins' => array(
						'user' => array(
							'LEFT JOIN',
							'user_id = ' .
							self::getColumnName(
								'meta', 'change', 'user'
							)
						)
					)
				)
			)
		);
	}

	/**
	 * Wraps self::numRows specializing...
	 * - category as meta
	 * - type as change
	 */
	public static function numChanges(
		array $options = array()
	) {
		return self::numRows( 'meta', 'change', $options );
	}

	/**
	 * Wraps self::getRows specializing...
	 * - class as DataCenterDBMetaField
	 * - category as meta
	 * - type as field
	 */
	public static function getMetaFields(
		array $options = array()
	) {
		return self::getRows(
			'DataCenterDBMetaField', 'meta', 'field', $options
		);
	}

	/**
	 * Wraps self::getRow specializing...
	 * - class as DataCenterDBMetaFieldLink
	 * - category as meta
	 * - type as field
	 */
	public static function getMetaField(
		$id
	) {
		return self::getRow(
			'DataCenterDBMetaField', 'meta', 'field', $id
		);
	}

	/**
	 * Wraps self::numRows specializing...
	 * - category as meta
	 * - type as field
	 */
	public static function numMetaFields(
		array $options = array()
	) {
		return self::numRows( 'meta', 'field', $options );
	}

	/**
	 * Wraps self::getRows specializing...
	 * - class as DataCenterDBMetaValue
	 * - category as meta
	 * - type as value
	 */
	public static function getMetaValues(
		array $options = array()
	) {
		return self::getRows(
			'DataCenterDBMetaValue', 'meta', 'value', $options
		);
	}

	/**
	 * Wraps self::getRow specializing...
	 * - class as DataCenterDBMetaValueLink
	 * - category as meta
	 * - type as value
	 */
	public static function getMetaValue(
		$id
	) {
		return self::getRow(
			'DataCenterDBMetaValue', 'meta', 'value', $id
		);
	}

	/**
	 * Wraps self::numRows specializing...
	 * - category as meta
	 * - type as value
	 */
	public static function numMetaValues(
		array $options = array()
	) {
		return self::numRows( 'meta', 'value', $options );
	}

	/* Option Builders */

	/**
	 * Builds array of options which specify fields to sort results by
	 * @param	category		String of category to lookup type in
	 * @param	type			String of category to lookup fields in
	 * @param	fields			String or Array of Strings of fields to sort by
	 */
	public static function buildSort(
		$category,
		$type,
		$fields
	) {
		$columns = array();
		if ( !is_array( $fields ) ) {
			$fields = array( $fields );
		}
		foreach( $fields as $field ) {
			$columns[] = self::getColumnName( $category, $type, $field );
		}
		return array(
			'options' => array(
				'ORDER BY' => implode( ',', $columns )
			)
		);
	}

	/**
	 * Builds array of options which specify fields to sort results by
	 * @param	sourceCategory		String of category to lookup source type in
	 * @param	sourceType			String of type to lookup source field in
	 * @param	sourceMatch			String of field to match to destination
	 * @param	destinationCategory	String of category to format value as
	 * @param	destinationType		String of type to format value as
	 * @param	fields				Array of source => destination pairs
	 * 								of Strings of fields to get and set
	 */
	public static function buildJoin(
		$sourceCatagory,
		$sourceType,
		$sourceMatch,
		$destinationCategory,
		$destinationType,
		$destinationMatch,
		array $aliases = array()
	) {
		$aliasList = array();
		foreach ( $aliases as $key => $value ) {
			$aliasList[] = self::getColumnName(
				$sourceCatagory, $sourceType, is_int( $key ) ? $value : $key
			) .
			' as ' .
			self::getColumnName(
				$destinationCategory, $destinationType, $value
			);
		}
		return array(
			'tables' => array(
				self::getTableName( $sourceCatagory, $sourceType )
			),
			'fields' => $aliasList,
			'joins' => array(
				self::getTableName( $sourceCatagory, $sourceType ) => array(
					'LEFT JOIN',
					self::getColumnName(
						$sourceCatagory, $sourceType, $sourceMatch
					) .
					'=' .
					self::getColumnName(
						$destinationCategory,
						$destinationType,
						$destinationMatch
					)
				)
			)
		);
	}

	/**
	 * Builds array of options which specify fields and values they must be
	 * @param	category		String of category to lookup type in
	 * @param	type			String of category to lookup fields in
	 * @param	fields			String of field to match value with
	 * @param	value			String of value to match to field value
	 */
	public static function buildCondition(
		$category,
		$type,
		$field,
		$value,
		$op = '='
	) {
		if ( $op == '=' ) {
			return array(
				'conditions' => array(
					self::getColumnName( $category, $type, $field ) => $value
				)
			);
		} else {
			$dbw = wfGetDB( DB_MASTER );
			return array(
				'conditions' => array(
					self::getColumnName( $category, $type, $field ) .
					$op . $dbw->addQuotes( $value )
				)
			);
		}
	}

	/**
	 * Builds array of options which specify limit and offset
	 * @param	path			Array of link parameters
	 */
	public static function buildRange(
		$path
	) {
		if ( !isset( $path['limit'] ) || $path['limit'] == null ) {
			$path['limit'] = 10;
		}
		if ( !isset( $path['offset'] ) || $path['offset'] == null ) {
			$path['offset'] = 0;
		}
		return array(
			'options' => array(
				'LIMIT' => (integer)$path['limit'],
				'OFFSET' => (integer)$path['offset'],
			)
		);
	}

	/**
	 * Builds array of options which match a query against a number of fields
	 * using case-insensitive partial matching
	 * @param	category		String of category to lookup type in
	 * @param	type			String of category to lookup fields in
	 * @param	fields			String of field to match query with
	 * @param	value			String of query to match to field value
	 */
	public static function buildMatch(
		$category,
		$type,
		$fields,
		$query
	) {
		$dbr = wfGetDB( DB_SLAVE );
		$conditions = array();
		if ( !is_array( $fields ) ) {
			$fields = array( $fields );
		}
		foreach ( $fields as $field ) {
			$columnName = self::getColumnName( $category, $type, $field );
			$conditions[] = 'UPPER(' . $columnName . ') LIKE UPPER(' .
				$dbr->addQuotes( '%' . $query . '%' ) . ')';
		}
		return array( 'conditions' => array( implode( '||', $conditions ) ) );
	}

	/* List Builders */

	/**
	 * Creates and returns an associative array of rows keyed by a specific
	 * field, for use as a lookup table or to divide rows into groups
	 * @param	field			String of name of field to use as key
	 * @param	rows			Array of DataCenterDBRow objects to process
	 */
	public static function buildLookupTable(
		$field,
		array $rows
	) {
		if ( !is_scalar( $field ) && $field !== null ) {
			throw new MWException(
				$field . ' is not a field for table keys to be made from'
			);
		}
		$table = array();
		foreach ( $rows as $row ) {
			if ( $row instanceof DataCenterDBRow ) {
				if ( !isset( $table[$row->get( $field )] ) ) {
					$table[$row->get( $field )] = array( $row );
				} else {
					$table[$row->get( $field )][] = $row;
				}
			} else {
				throw new MWException(
					'Array element is not an instance of DataCenterDBRow'
				);
			}
		}
		return $table;
	}
}

class DataCenterDBRow {

	/* Members */

	protected $category;
	protected $type;
	protected $row = array();

	/* Static Functions */

	/**
	 * Initializes and returns a new subclassesd object
	 * @param	class			String of class name to inialize instance with
	 * 							which must be a subclass of DataCenterDBRow
	 * @param	category		String of category name to set
	 * @param	type			String of type name to set
	 * @param	values			Array of field => value pairs to set
	 */
	public static function newFromClass(
		$class,
		$category,
		$type,
		array $values = array()
	) {
		if ( !DataCenterDB::isRowClass( $class ) ) {
			throw new MWException(
				$class . ' is not an compatable with DataCenterDBRow'
			);
		}
		if ( !DataCenterDB::isType( $category, $type ) ) {
			throw new MWException(
				$category . '/' . $type . ' is not a valid type'
			);
		}
		$rowObject = new $class( $category, $type );
		if ( count( $values ) > 0 ) {
			$rowObject->set( $values );
		}
		return $rowObject;
	}

	/* Functions */

	/**
	 * Constructs row object
	 * @param	category		String of category to look the type up in or
	 * 							DataCenterDBRowInit object to initialize with
	 * @param	type			Optional String of type to use as context for
	 * 							operations on row
	 * @param	row				Optional Associative Array of column and value
	 * 							pairs to use as initial data overriding defaults
	 */
	public function __construct(
		$category,
		$type,
		array $row = array()
	) {
		$this->category = $category;
		$this->type = $type;
		$this->set( DataCenterDB::getRowDefaults( $category, $type ) );
		$this->row = array_merge( $this->row, $row );
	}

	/**
	 * Gets fully prefixed columns and their values in an Associative Array of
	 * column and value pairs
	 */
	public function getRow() {
		return $this->row;
	}

	/**
	 * Sets row data from an Associative Array of column and value pairs
	 */
	public function setRow(
		array $row = array()
	) {
		$this->row = count( $row ) > 0 ? $row : null;
	}

	/**
	 * Gets category of type
	 */
	public function getCategory() {
		return $this->category;
	}

	/**
	 * Gets type of row
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Gets id of row or null if none
	 */
	public function getId() {
		$columnName = $this->getColumnName( 'id' );
		return isset( $this->row[$columnName] ) ?
			$this->row[$columnName] : null;
	}

	/**
	 * Gets id of row or 0 if none
	 */
	public function getIdOrZero() {
		$columnName = $this->getColumnName( 'id' );
		return isset( $this->row[$columnName] ) ? $this->row[$columnName] : 0;
	}

	/**
	 * Gets fully prefixed column name from simplified field name
	 * @param	fieldName		String of name of field to lookup
	 */
	public function getColumnName(
		$fieldName
	) {
		return DataCenterDB::getColumnName(
			$this->category, $this->type, $fieldName
		);
	}

	/**
	 * Gets simplified field name from fully prefixed column name
	 * @param	columnName		String of name of column to lookup
	 */
	public function getFieldName(
		$columnName
	) {
		return DataCenterDB::getFieldName(
			$this->category, $this->type, $columnName
		);
	}

	/**
	 * Gets one, multiple, or all values
	 * @example
	 * 		// Gets all
	 * 		$rowObject->get();
	 * 		// Gets a
	 * 		$rowObject->get( 'a' );
	 * 		// Gets a, b and c
	 * 		$rowObject->get( array( 'a', 'b', 'c' ) );
	 * 		// Gets all from a joined source
	 * 		$rowObject->get( 'asset', 'rack' );
	 * 		// Gets name from a joined source
	 * 		$rowObject->get( 'asset', 'rack', 'name' );
	 * 		// Gets name and model from a joined source
	 * 		$rowObject->get( 'asset', 'rack', array( 'name', 'model' ) );
	 * @param	field	Optional String of name of field to get value for, or an
	 * 					Associative Array of fields to get values for. Multiple
	 * 					gets have associative array results. If a field was
	 * 					requested that does not exist the field's value will
	 * 					be null - preventing having to check for existence of
	 * 					each field before getting. If no argument or null is
	 * 					passed, all fields will be returned as an Associative
	 * 					Array.
	 */
	public function get(
		$category = null,
		$type = null,
		$field = null
	) {
		if ( $category === null && $type === null && $field === null ) {
			$category = $this->category;
			$type = $this->type;
		}
		if ( $type === null && $field === null ) {
			$field = $category;
			$category = $this->category;
			$type = $this->type;
		}
		if ( $field === null ) {
			$results = array();
			foreach ( $this->row as $columnName => $value ) {
				if ( !is_int( $columnName ) ) {
					if (
						DataCenterDB::isColumnOfType(
							$category, $type, $columnName
						)
					) {
						$fieldName = DataCenterDB::getFieldName(
							$category, $type, $columnName
						);
						$results[$fieldName] = $value;
					}
				}
			}
			return $results;
		} else if ( is_array( $field ) ) {
			$results = array();
			foreach ( $field as $fieldName ) {
				$columnName = DataCenterDB::getColumnName(
					$category, $type, $fieldName
				);
				if ( isset( $this->row[$columnName] ) ) {
					$results[$fieldName] = $this->row[$columnName];
				} else {
					$results[$fieldName] = null;
				}
			}
			return $results;
		} else {
			$columnName = DataCenterDB::getColumnName(
				$category, $type, $field
			);
			if ( isset( $this->row[$columnName] ) ) {
				return $this->row[$columnName];
			} else {
				return null;
			}
		}
	}

	/**
	 * Sets one or more fields
	 * @example
	 * 		$rowObject->set( 'a', 1 );
	 * 		$rowObject->set( array( 'a' => 1, 'b' => 2, 'c' => 3 ) );
	 * @param	column			String of name of field to set or Associative
	 * 							Array of field and value pairs
	 * @param	value			Optional Scalar of value to set
	 */
	public function set(
		$column,
		$value = null
	) {
		if ( is_array( $column ) ) {
			foreach ( $column as $name => $value ) {
				$columnName = $this->getColumnName( $name );
				$this->row[$columnName] = $value;
			}
		} else {
			$columnName = $this->getColumnName( $column );
			$this->row[$columnName] = $value;
		}
	}

	/**
	 * Determines whether a row is present in the database
	 */
	public function exists() {
		return DataCenterDB::rowExists( $this );
	}

	/**
	 * Automatically inserts or updates row
	 */
	public function save() {
		if ( DataCenterDB::rowExists( $this ) ) {
			DataCenterDB::updateRow( $this );
		} else {
			DataCenterDB::insertRow( $this );
		}
	}

	/**
	 * Updates row
	 */
	public function update() {
		DataCenterDB::updateRow( $this );
	}

	/**
	 * Inserts row
	 */
	public function insert() {
		DataCenterDB::insertRow( $this );
	}

	/**
	 * Deletes row
	 */
	public function delete() {
		DataCenterDB::deleteRow( $this );
	}
}

class DataCenterDBComponent extends DataCenterDBRow {

	/* Functions */

	/**
	 * Gets changes that reference this object by category, type, and ID
	 */
	public function getChanges(
		array $options = array()
	) {
		return DataCenterDB::getChanges(
			array_merge_recursive(
				$options,
				DataCenterDB::buildCondition(
					'meta', 'change', 'component_category', $this->category
				),
				DataCenterDB::buildCondition(
					'meta', 'change', 'component_type', $this->type
				),
				DataCenterDB::buildCondition(
					'meta', 'change', 'component_id', $this->getId()
				)
			)
		);
	}

	public function numChanges(
		array $options = array()
	) {
		return DataCenterDB::numChanges(
			array_merge_recursive(
				$options,
				DataCenterDB::buildCondition(
					'meta', 'change', 'component_category', $this->category
				),
				DataCenterDB::buildCondition(
					'meta', 'change', 'component_type', $this->type
				),
				DataCenterDB::buildCondition(
					'meta', 'change', 'component_id', $this->getId()
				)
			)
		);
	}

	public function saveMetaValues(
		$values = null
	) {
		if ( !is_array( $values ) ) {
			return;
		}
		$metaValues = $this->getMetaValues();
		$metaValuesTable = array();
		foreach ( $metaValues as $metaValue ) {
			$metaValuesTable[$metaValue->get( 'field' )] = $metaValue;
		}
		foreach ( $values as $field => $value ) {
			if ( isset( $metaValuesTable[$field] ) ) {
				$metaValue = DataCenterDBMetaValue::newFromComponent(
					$this,
					array(
						'id' => $metaValuesTable[$field]->getId(),
						'value' => $value
					)
				);
				if ( $value !== '' ) {
					$metaValue->update();
				} else {
					$metaValue->delete();
				}
			} else {
				if ( $value !== '' ) {
					$metaValue = DataCenterDBMetaValue::newFromComponent(
						$this, array( 'field' => $field, 'value' => $value )
					);
					$metaValue->insert();
				}
			}
		}
	}

	public function insertChange(
		$values
	) {
		if ( !is_array( $values ) ) {
			return;
		}
		// Gets it'self from the database - as we need ALL DATA for the state
		$component = DataCenterDB::getRow(
			__CLASS__,
			$this->category,
			$this->type,
			$this->getId()
		);
		// Checks if component existed
		if ( $component ) {
			// Creates a change from a component
			$change = DataCenterDBChange::newFromComponent(
				$component, $values
			);
			// Inserts change
			$change->insert();
		}
	}

	/**
	 * Gets meta fields linked to this component
	 */
	public function getMetaFields() {
		return DataCenterDB::getRows(
			'DataCenterDBMetaField',
			'link',
			'field',
			array_merge_recursive(
				DataCenterDB::buildCondition(
					'link', 'field', 'component_category', $this->category
				),
				DataCenterDB::buildCondition(
					'link', 'field', 'component_type', $this->type
				),
				DataCenterDB::buildJoin(
					'meta', 'field','id',
					'link', 'field','field',
					array( 'name', 'format' )
				)
			)
		);
	}

	/**
	 * Gets meta values associated to this component
	 */
	public function getMetaValues() {
		return DataCenterDB::getRows(
			'DataCenterDBMetaValue',
			'meta',
			'value',
			array_merge_recursive(
				DataCenterDB::buildCondition(
					'meta', 'value', 'component_category', $this->category
				),
				DataCenterDB::buildCondition(
					'meta', 'value', 'component_type', $this->type
				),
				DataCenterDB::buildCondition(
					'meta', 'value', 'component_id', $this->getId()
				),
				DataCenterDB::buildJoin(
					'meta', 'field', 'id',
					'meta', 'value', 'field',
					array( 'name', 'format' )
				)
			)
		);
	}

	public function serialize() {
		$metaFieldValues = $this->getMetaValues();
		$meta = array();
		foreach ( $metaFieldValues as $metaFieldValue ) {
			$meta[$metaFieldValue->get( 'field' )] =
				$metaFieldValue->get( 'value' );
		}
		return serialize(
			array(
				'row' => $this->get(),
				'meta' => $meta
			)
		);
	}
}

/* Asset Rows */

class DataCenterDBAsset extends DataCenterDBComponent {

	/* Static Functions */

	/**
	 * Wraps DataCenterDBRow::newFromClass specializing...
	 * - class as DataCenterDBRack
	 * - category as asset
	 * - type as rack
	 */
	public static function newFromType(
		$type,
		array $values = array()
	) {
		return parent::newFromClass( __CLASS__, 'asset', $type, $values );
	}

	/* Functions */

	/**
	 * Gets model associated with this rack
	 */
	public function getModel() {
		return DataCenterDB::getModel( $this->type, $this->get( 'model' ) );
	}

	/**
	 * Gets model associated with this rack
	 */
	public function getLocation() {
		return DataCenterDB::getLocation( $this->get( 'location' ) );
	}
}

/* Model Rows */

class DataCenterDBModel extends DataCenterDBComponent  {

	/* Protected Members */

	protected $structure = array();

	/* Functions */

	/**
	 * Wraps DataCenterDBRow::newFromClass specializing...
	 * - class as DataCenterDBModel
	 * - category as model
	 */
	public static function newFromType(
		$type,
		array $values = array()
	) {
		return parent::newFromClass( __CLASS__, 'model', $type, $values );
	}

	/* Functions */

	/**
	 * Gets structure of links
	 */
	public function getStructure() {
		if ( !$this->structure ) {
			$this->buildStructure();
		}
		return $this->structure;
	}

	/**
	 * Builds structure of models recursively using list of links
	 */
	public function buildStructure() {
		$links = DataCenterDB::getRows(
			'DataCenterDBModelLink',
			'link',
			'model',
			array_merge_recursive(
				DataCenterDB::buildCondition(
					'link', $this->category, 'parent_type', $this->type
				),
				DataCenterDB::buildCondition(
					'link', $this->category, 'parent_id', $this->getID()
				)
			)
		);
		foreach ( $links as $link ) {
			$model = $link->getModel();
			$model->set( 'link', $link->getId() );
			$model->buildStructure();
			$this->structure[] = $model;
		}
	}
}

/* Link Rows */

class DataCenterDBLink extends DataCenterDBRow {
	//
}

class DataCenterDBAssetLink extends DataCenterDBLink {

	/* Protected Members */

	protected $structure = array();
	protected $links = array();

	/* Static Functions */

	/**
	 * Wraps DataCenterDBRow::newFromClass specializing...
	 * - class as DataCenterDBAssetLink
	 * - category as link
	 * - type as asset
	 */
	public static function newFromValues(
		array $values = array()
	) {
		return parent::newFromClass( __CLASS__, 'link', 'asset', $values );
	}

	/* Functions */

	/**
	 * Gets flat list of links
	 */
	public function getLinks(
		array $options = array()
	) {
		if ( !$this->links ) {
			$links = DataCenterDB::getAssetLinks(
				DataCenterDB::buildCondition(
					'link', 'asset', 'parent_link', $this->getId()
				)
			);
			foreach ( $links as $link ) {
				$this->links[] = $link;
				$this->links = array_merge( $this->links, $link->getLinks() );
			}
		}
		return $this->links;
	}

	/**
	 * Gets structure of links
	 */
	public function getStructure() {
		if ( !$this->structure ) {
			$links = DataCenterDB::getRows(
				'DataCenterDBAssetLink',
				'link',
				'asset',
				array_merge_recursive(
					DataCenterDB::buildCondition(
						'link', 'asset', 'plan', $this->get( 'plan' )
					)
				)
			);
			$this->buildStructure( $links );
		}
		return $this->structure;
	}

	/**
	 * Builds structure of links recursively using list of links
	 * @param	links			Array of DataCenterDBAssetLink to use as source
	 * 							for recursive structure construction
	 */
	public function buildStructure(
		array $links
	) {
		$id = $this->getId();
		foreach ( $links as $key => $link ) {
			if ( $link->get( 'parent_link' ) == $id ) {
				$link->buildStructure( $links );
				$this->structure[] = $link;
			}
		}
	}

	public function getAsset() {
		return DataCenterDB::getAsset(
			$this->get( 'asset_type' ), $this->get( 'asset_id' )
		);
	}
}

class DataCenterDBModelLink extends DataCenterDBLink  {

	/* Static Functions */

	/**
	 * Wraps DataCenterDBRow::newFromClass specializing...
	 * - class as DataCenterDBModelLink
	 * - category as link
	 * - type as model
	 */
	public static function newFromValues(
		array $values = array()
	) {
		return parent::newFromClass( __CLASS__, 'link', 'model', $values );
	}

	/**
	 * Wraps self::newFromValues extracting values from objects
	 * @param	parent			DataCenterDBModel to set as parent
	 * @param	child			DataCenterDBModel to set as child
	 */
	public static function newFromModels(
		$parent,
		$child
	) {
		if ( !( $parent instanceof DataCenterDBModel ) ) {
			throw new MWException(
				'Parent object is not compatible with DataCenterDBModel'
			);
		}
		if ( !( $child instanceof DataCenterDBModel ) ) {
			throw new MWException(
				'Child object is not compatible with DataCenterDBModel'
			);
		}
		return self::newFromValues(
			array(
				'parent_type' => $parent->getType(),
				'parent_id' => $parent->getId(),
				'child_type' => $child->getType(),
				'child_id' => $child->getId(),
			)
		);
	}

	/* Functions */

	/**
	 * Gets model this link links to
	 */
	public function getModel() {
		return DataCenterDB::getModel(
			$this->get( 'child_type' ), $this->get( 'child_id' )
		);
	}
}

class DataCenterDBMetaFieldLink extends DataCenterDBLink {

	/* Static Functions */

	/**
	 * Wraps DataCenterDBRow::newFromClass specializing...
	 * - class as DataCenterDBFieldLink
	 * - category as link
	 * - type as field
	 */
	public static function newFromValues(
		array $values = array()
	) {
		return parent::newFromClass( __CLASS__, 'link', 'field', $values );
	}

	/* Functions */

	public function getValues() {
		return DataCenterDB::getMetaValues(
			array_merge_recursive(
				DataCenterDB::buildCondition(
					'meta', 'value', 'field', $this->get( 'field' )
				),
				DataCenterDB::buildCondition(
					'meta',
					'value',
					'component_category',
					$this->get( 'component_category' )
				),
				DataCenterDB::buildCondition(
					'meta',
					'value',
					'component_type',
					$this->get( 'component_type' )
				)
			)
		);
	}

	public function numValues() {
		return DataCenterDB::numMetaValues(
			array_merge_recursive(
				DataCenterDB::buildCondition(
					'meta', 'value', 'field', $this->get( 'field' )
				),
				DataCenterDB::buildCondition(
					'meta',
					'value',
					'component_category',
					$this->get( 'component_category' )
				),
				DataCenterDB::buildCondition(
					'meta',
					'value',
					'component_type',
					$this->get( 'component_type' )
				)
			)
		);
	}
}

/* Facility Rows */

class DataCenterDBLocation extends DataCenterDBComponent {

	/* Static Functions */

	/**
	 * Wraps DataCenterDBRow::newFromClass specializing...
	 * - class as DataCenterDBLocation
	 * - category as facility
	 * - type as location
	 */
	public static function newFromValues(
		array $values = array()
	) {
		return parent::newFromClass(
			__CLASS__, 'facility', 'location', $values
		);
	}

	/* Functions */

	public function getSpaces(
		array $options = array()
	) {
		return DataCenterDB::getRows(
			__CLASS__,
			'facility',
			'space',
			array_merge_recursive(
				$options,
				DataCenterDB::buildCondition(
					'facility', 'space', 'location', $this->getId()
				)
			)
		);
	}
}

class DataCenterDBSpace extends DataCenterDBComponent {

	/* Static Functions */

	/**
	 * Wraps DataCenterDBRow::newFromClass specializing...
	 * - class as DataCenterDBSpace
	 * - category as facility
	 * - type as space
	 */
	public static function newFromValues(
		array $values = array()
	) {
		return parent::newFromClass( __CLASS__, 'facility', 'space', $values );
	}

	public function getPlans(
		array $options = array()
	) {
		if ( $this->type == 'space' ) {
			return DataCenterDB::getPlans(
				array_merge_recursive(
					$options,
					DataCenterDB::buildCondition(
						'meta', 'plan', 'space', $this->getId()
					)
				)
			);
		}
		return null;
	}

	public function getLocation() {
		return DataCenterDB::getLocation( $this->get( 'location' ) );
	}
}

/* Meta Rows */

class DataCenterDBMetaField extends DataCenterDBRow  {

	/* Static Functions */

	/**
	 * Wraps DataCenterDBRow::newFromClass specializing...
	 * - class as DataCenterDBMetaField
	 * - category as meta
	 * - type as field
	 */
	public static function newFromValues(
		array $values = array()
	) {
		return parent::newFromClass( __CLASS__, 'meta', 'field', $values );
	}

	/* Functions */

	public function getLinks(
		array $options = array()
	) {
		return DataCenterDB::getMetaFieldLinks(
			array_merge_recursive(
				$options,
				DataCenterDB::buildCondition(
					'link', 'field', 'field', $this->getId()
				)
			)
		);
	}

	public function getValues() {
		return DataCenterDB::getMetaValues(
			DataCenterDB::buildCondition(
				'meta', 'value', 'field', $this->getId()
			)
		);
	}

	public function numValues() {
		return DataCenterDB::numMetaValues(
			DataCenterDB::buildCondition(
				'meta', 'value', 'field', $this->getId()
			)
		);
	}
}

class DataCenterDBMetaValue extends DataCenterDBRow  {

	/* Static Functions */

	/**
	 * Wraps DataCenterDBRow::newFromClass specializing...
	 * - class as DataCenterDBMetaValue
	 * - category as meta
	 * - type as value
	 */
	public static function newFromValues(
		array $values = array()
	) {
		return parent::newFromClass( __CLASS__, 'meta', 'value', $values );
	}

	/**
	 * Creates new meta value from object
	 * @param	component		DataCenterDBComponent to create change for
	 * @param	values			Array of fields and values for an instance
	 * 							of DataCenterDBMetaValue
	 */
	public static function newFromComponent(
		DataCenterDBComponent $component,
		array $values = array()
	) {
		return self::newFromValues(
			array_merge(
				$values,
				array(
					'component_category' => $component->getCategory(),
					'component_type' => $component->getType(),
					'component_id' => $component->getId(),
				)
			)
		);
	}
}

class DataCenterDBChange extends DataCenterDBRow  {

	/* Static Functions */

	/**
	 * Wraps DataCenterDBRow::newFromClass specializing...
	 * - class as DataCenterDBChange
	 * - category as meta
	 * - type as change
	 */
	public static function newFromValues(
		array $values = array()
	) {
		return parent::newFromClass( __CLASS__, 'meta', 'change', $values );
	}

	/**
	 * Creates new change from object
	 * @param	component		DataCenterDBComponent to create change for
	 * @param	values			Array of fields and values for an instance
	 * 							of DataCenterDBChange
	 */
	public static function newFromComponent(
		DataCenterDBComponent $component,
		array $values = array()
	) {
		global $wgUser;
		return self::newFromValues(
			array_merge(
				$values,
				array(
					'timestamp' => wfTimestampNow(),
					'user' => $wgUser->getId(),
					'component_category' => $component->getCategory(),
					'component_type' => $component->getType(),
					'component_id' => $component->getId(),
					'state' => $component->serialize(),
				)
			)
		);
	}
}

class DataCenterDBPlan extends DataCenterDBRow  {

	/* Protected Members */

	protected $structure;
	protected $links;

	/* Static Functions */

	/**
	 * Wraps DataCenterDBRow::newFromClass specializing...
	 * - class as DataCenterDBPlan
	 * - category as meta
	 * - type as plan
	 */
	public static function newFromValues(
		array $values = array()
	) {
		return parent::newFromClass( __CLASS__, 'meta', 'plan', $values );
	}

	/* Functions */

	/**
	 * Gets space of plan
	 */
	public function getSpace() {
		return DataCenterDBSpace::newFromValues(
			$this->get( 'facility', 'space' )
		);
	}

	/**
	 * Gets flat list of links
	 */
	public function getLinks(
		array $options = array()
	) {
		if ( !$this->links ) {
			$this->links = DataCenterDB::getAssetLinks(
				DataCenterDB::buildCondition(
					'link', 'asset', 'plan', $this->getId()
				)
			);
		}
		return $this->links;
	}

	/**
	 * Gets structure of links
	 */
	public function getStructure(
		array $options = array()
	) {
		if ( !$this->structure ) {
			$links = DataCenterDB::getRows(
				'DataCenterDBAssetLink',
				'link',
				'asset',
				array_merge_recursive(
					$options,
					DataCenterDB::buildCondition(
						'link', 'asset', 'plan', $this->getId()
					)
				)
			);
			$this->structure = array();
			foreach ( $links as $link ) {
				if ( $link->get( 'parent_link' ) == null ) {
					$link->buildStructure( $links );
					$this->structure[] = $link;
				}
			}
		}
		return $this->structure;
	}
}
