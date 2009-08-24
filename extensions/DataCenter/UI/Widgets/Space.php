<?php
/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterWidgetSpace extends DataCenterWidget {

	/* Private Static Members */

	private static $defaultParameters = array(
		/**
		 * XML ID attribute of widget
		 * @datatype	string
		 */
		'id' => 'space',
		/**
		 * CSS class of widget
		 * @datatype	string
		 */
		'class' => 'widget-space',
		/**
		 * Data Source for spaces to render
		 * @datatype	array of DataCenterAsset
		 */
		'space' => null,
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
			'/extensions/DataCenter/Resources/Widgets/Space/Space.js'
		);
		// Sets defaults
		$parameters = array_merge(
			self::$defaultParameters, $parameters
		);
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
				self::addSpaceJsFunction( $parameters )
			)
		);
		// Adds script
		$xmlOutput .= DataCenterXml::script( $jsOutput );
		// Begins widget
		$xmlOutput .= parent::end();
		// Returns XML
		return $xmlOutput;
	}

	private static function addSpaceJsFunction(
		array $parameters
	) {
		// Adds script to add space to scene
		$jsOutput = DataCenterJs::callFunction(
			'scene.setModule',
			array(
				DataCenterJs::buildInstance(
					'DataCenterSceneSpace',
					array(
						DataCenterJs::toScalar( $parameters['space']->getId() ),
						self::buildPhysicalJsObject( $parameters ),
					)
				)
			)
		);
		// Adds script to render scene
		$jsOutput .= DataCenterJs::callFunction( 'scene.render' );
		// Returns JavaScript
		return DataCenterJs::buildFunction( array( 'scene' ), $jsOutput );
	}

	private static function buildPhysicalJsObject(
		$parameters
	) {
		// Creates shortcut to space
		$space = $parameters['space'];
		// Checks if space was valid
		if ( $space ) {
			// Creates physical description from space
			$physical = array_merge(
				$space->get( array( 'width', 'height', 'depth' ) ),
				array( 'orientation' => 0, 'racks' => array() )
			);
		} else {
			// Creates empty array
			$physical = array();
		}
		// Returns javascript object
		return DataCenterJs::toObject( $physical );
	}
}