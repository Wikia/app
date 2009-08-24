<?php
/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterWidgetPlan extends DataCenterWidget {

	/* Private Static Members */

	private static $defaultParameters = array(
		/**
		 * XML ID attribute of widget
		 * @datatype	string
		 */
		'id' => 'plan',
		/**
		 * CSS class of widget
		 * @datatype	string
		 */
		'class' => 'widget-plan',
		/**
		 * Data Source for plan to render
		 * @datatype	DataCenterPlan
		 */
		'plan' => null,
		/**
		 * Data Source for additional rack to include
		 * @datatype	DataCenterRack or DataCenterObject
		 */
		'include' => null,
		/**
		 * Level of Detail
		 * @datatype	integer of 0:space, 1:rack or 2:object
		 */
		'lod' => 2,
		/**
		 * Row ID of rack asset to highlight
		 * @datatype	integer
		 */
		'current-rack' => null,
		/**
		 * Row ID of object asset to highlight
		 * @datatype	integer
		 */
		'current-object' => null,
		/**
		 * Row ID of rack asset to zoom into
		 * @datatype	integer
		 */
		'zoom-to-rack' => null,
		/**
		 * Row ID of rack asset to look at
		 * @datatype	integer
		 */
		'look-at-rack' => null,
		/**
		 * Row ID of rack asset to zoom out from
		 * @datatype	integer
		 */
		'zoom-from-rack' => null,
		/**
		 * CSS inline-styled width of widget
		 * @datatype	scalar
		 */
		'width' => '100%',
		/**
		 * CSS inline-styled height of widget
		 * @datatype	scalar
		 */
		'height' => '400px',
	);

	/* Static Functions */

	public static function render(
		array $parameters
	) {
		// Adds script to UI
		DataCenterUI::addScript(
			'/extensions/DataCenter/Resources/Widgets/Plan/Plan.js'
		);
		// Sets defaults
		$parameters = array_merge( self::$defaultParameters, $parameters );
		// Checks if width was given as an integer
		if ( is_int( $parameters['width'] ) ) {
			// Converts width to CSS pixel definition
			$parameters['width'] .= 'px';
		}
		// Checks if height was given as an integer
		if ( is_int( $parameters['height'] ) ) {
			// Converts height to CSS pixel definition
			$parameters['height'] .= 'px';
		}
		// Begins widget
		$xmlOutput = parent::begin( $parameters['class'] );
		// Adds XML element
		$xmlOutput .= DataCenterXML::div(
			array(
				'id' => $parameters['id'],
				'style' => DataCenterCss::toAttributes(
					array(
						'width' => $parameters['width'],
						'height' => $parameters['height']
					)
				)
			), ' '
		);
		// Builds script for adding setup job to renderer
		$jsOutput = DataCenterJs::callFunction(
			'dataCenter.renderer.addJob',
			array(
				DataCenterJs::toScalar( 'scene' ),
				DataCenterJs::toScalar( $parameters['id'] ),
				self::addPlanJsFunction( $parameters )
			)
		);
		// Adds script
		$xmlOutput .= DataCenterXml::script( $jsOutput );
		// Begins widget
		$xmlOutput .= parent::end();
		// Returns XML
		return $xmlOutput;
	}

	private static function addPlanJsFunction(
		array $parameters
	) {
		// Adds script to add plan to scene
		$jsOutput = DataCenterJs::callFunction(
			'scene.setModule',
			array(
				DataCenterJs::buildInstance(
					'DataCenterScenePlan',
					array(
						DataCenterJs::toScalar( $parameters['plan']->getId() ),
						self::buildPhysicalJsObject( $parameters ),
						self::buildStateJsObject( $parameters ),
					)
				)
			)
		);
		// Adds script to render scene
		$jsOutput .= DataCenterJs::callFunction( 'scene.render' );
		// Returns JavaScript
		return DataCenterJs::buildFunction( array( 'scene' ), $jsOutput );
	}

	private static function buildStateJsObject(
		$parameters
	) {
		// Builds array for state
		$state = array(
			'focus' => array(
				'id' => null, 'progress' => null, 'inc' => null, 'begin' => null
			),
			'highlight' => array( 'rack' => null, 'object' => null )
		);
		// Sets highlight
		if ( $parameters['current-rack'] !== null ) {
			$state['highlight']['rack'] = $parameters['current-rack'];
		}
		if ( $parameters['current-rack'] !== null ) {
			$state['highlight']['object'] = $parameters['current-object'];
		}
		// Sets focus
		if ( $parameters['look-at-rack'] !== null ) {
			$state['focus']['id'] = $parameters['look-at-rack'];
			$state['focus']['progress'] = 1;
			$state['focus']['inc'] = true;
		} else if ( $parameters['zoom-to-rack'] !== null ) {
			$state['focus']['id'] = $parameters['zoom-to-rack'];
			$state['focus']['progress'] = 0;
			$state['focus']['inc'] = true;
		} else if ( $parameters['zoom-from-rack'] !== null ) {
			$state['focus']['id'] = $parameters['zoom-from-rack'];
			$state['focus']['progress'] = 0;
			$state['focus']['inc'] = false;
		}
		// Returns javascript object
		return DataCenterJs::toObject( $state );
	}

	private static function buildPhysicalJsObject(
		$parameters
	) {
		// Creates shortcut to plan
		$plan = $parameters['plan'];
		// Gets plan's space from database
		$space = $plan->getSpace();
		// Checks if space was valid
		if ( $space ) {
			// Creates physical description from space
			$physical = array_merge(
				$space->get( array( 'width', 'height', 'depth' ) ),
				array( 'orientation' => 0, 'racks' => array() )
			);
			// Checks if racks should be rendered
			if ( $parameters['lod'] >= 1 ) {
				$structure = $parameters['plan']->getStructure();
				if (
					$parameters['include'] instanceof DataCenterDBAssetLink &&
					$parameters['include']->get( 'asset_type' ) == 'rack'
				) {
					$structure[] = $parameters['include'];
				}
				// Loops over each rack link
				foreach ( $structure as $rackLink ) {
					$objects = array();
					// Extracts rack from link
					$rack = $rackLink->getAsset();
					if ( $rack ) {
						// Gets rack model from database
						$rackModel = $rack->getModel();
						if ( $parameters['lod'] >= 2 ) {
							$rackStructure = $rackLink->getStructure();
							if (
								$parameters['include'] instanceof
									DataCenterDBAssetLink &&
								$parameters['include']->get( 'asset_type' ) ==
									'object' &&
								$parameters['current-rack'] == $rack->getId()
							) {
								$rackStructure[] = $parameters['include'];
							}
							foreach ( $rackStructure as $objectLink ) {
								// Extracts object from object link
								$object = $objectLink->getAsset();
								if ( $object ) {
									// Gets object model from database
									$objectModel = $object->getModel();
									// Adds object to list
									$objects[$object->getId()] = array_merge(
										$objectLink->get(
											array( 'z', 'orientation' )
										),
										$objectModel->get(
											array( 'units', 'depth' )
										)
									);
								}
							}
						}
						// Add rack to list
						$physical['racks'][$rack->getId()] = array_merge(
							$rackLink->get( array( 'x', 'y', 'orientation' ) ),
							$rackModel->get( array( 'units' ) ),
							array( 'objects' => $objects )
						);
					}
				}
			}
		} else {
			// Creates empty array
			$physical = array();
		}
		// Returns javascript object
		return DataCenterJs::toObject( $physical );
	}
}