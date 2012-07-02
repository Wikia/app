<?php
/**
 * This file contains the WikiObjectModelFactory class.
 *
 * @author Ning
 *
 * @file
 * @ingroup WikiObjectModels
 */

class WikiObjectModelFactory {

	/**
	 * Array of type labels indexed by type ids. Used for model type resolution.
	 *
	 * @var array
	 */
	static private $mTypeLabels;

	/**
	 * Array of class names for creating new WikiObjectModel, indexed by type id.
	 *
	 * @var array of WikiObjectModel
	 */
	static private $mTypeClasses;

	/**
	 * Create a value from a type id. If no $value is given, an empty container
	 * is created, the value of which can be set later on.
	 *
	 * @param $typeid id string for the given type
	 *
	 * @return WikiObjectModel
	 */
	static public function newTypeIDValue( $typeid ) {
		self::initPOMTypes();

		if ( array_key_exists( $typeid, self::$mTypeClasses ) ) { // direct response for basic types
			$result = new self::$mTypeClasses[$typeid]( $typeid );
		}

		return $result;
	}

	/**
	 * Gather all available pomtypes and label<=>id<=>pomtype associations.
	 * This method is called before most methods of this factory.
	 */
	static protected function initPOMTypes() {
		global $wgOMLang;

		if ( is_array( self::$mTypeLabels ) ) {
			return; // init happened before
		}

		self::$mTypeLabels = $wgOMLang->getPOMTypeLabels();

		// Setup built-in pomtypes.
		// NOTE: all ids must start with underscores, where two underscores indicate
		// truly internal (non user-acessible types). All others should also get a
		// translation in the language files, or they won't be available for users.
		self::$mTypeClasses = array(
			'_cat'  => 'WOMCategoryModel', // Category
			'_wpg'  => 'WOMPageModel', // Page
			'_tpl'  => 'WOMTemplateModel', // Template
			'_fun'  => 'WOMParserFunctionModel', // Parser function
			'_par'  => 'WOMParameterModel', // Parameter key value
			'_tfv'  => 'WOMTemplateFieldModel', // Template field value
			'_pro'  => 'WOMPropertyModel', // Property
			'_txt'  => 'WOMTextModel', // Plain text
			'_lnk'  => 'WOMLinkModel', // URL/URI type
			'_sec'  => 'WOMSectionModel', // Section
		);

		wfRunHooks( 'mwInitWOMTypes' );
	}

	/**
	 * A function for registering/overwriting pomtypes for WOM. Should be
	 * called from within the hook 'mwInitWOMTypes'.
	 *
	 * @param string $id
	 * @param string $className
	 * @param mixed $label
	 */
	static public function registerPOMType( $id, $className, $label = false ) {
		self::$mTypeClasses[$id] = $className;

		if ( $label != false ) {
			self::$mTypeLabels[$id] = $label;
		}
	}

	/**
	 * Look up the ID that identifies the pomtype of the given label
	 * internally. This id is used for all internal operations. Compound types
	 * are not supported by this method (decomposition happens earlier). Custom
	 * types get their DBkeyed label as id. All ids are prefixed by an
	 * underscore in order to distinguish them from custom types.
	 *
	 * This method may or may not take aliases into account. For unknown
	 * labels, the normalised (DB-version) label is used as an ID.
	 *
	 * @param string $label
	 */
	static public function findTypeID( $label ) {
		self::initPOMTypes();
		$id = array_search( $label, self::$mTypeLabels );

		if ( $id !== false ) {
			return $id;
		} else {
			return str_replace( ' ', '_', $label );
		}
	}

	/**
	 * Get the translated user label for a given internal ID. If the ID does
	 * not have a label associated with it in the current language, the ID
	 * itself is transformed into a label (appropriate for user defined types).
	 *
	 * @param string $id
	 */
	static public function findTypeLabel( $id ) {
		self::initPOMTypes();

		if ( $id { 0 } === '_' ) {
			if ( array_key_exists( $id, self::$mTypeLabels ) ) {
				return self::$mTypeLabels[$id];
			} else { // internal type without translation to user space;
			    // might also happen for historic types after an upgrade --
			    // alas, we have no idea what the former label would have been
				return str_replace( '_', ' ', $id );
			}
		} else { // non-builtin type, use id as label
			return str_replace( '_', ' ', $id );
		}
	}

	/**
	 * Return an array of all labels that a user might specify as the type of
	 * a property, and that are internal (i.e. not user defined). No labels are
	 * returned for internal types without user labels (e.g. the special types
	 * for wome special properties), and for user defined types.
	 *
	 * @return array
	 */
	static public function getKnownTypeLabels() {
		self::initPOMTypes();
		return self::$mTypeLabels;
	}

}