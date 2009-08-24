<?php
/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterInputPosition extends DataCenterInput {

	/* Private Static Members */

	private static $defaultParameters = array(
		/**
		 * XML id attribute
		 * @datatype	string
		 */
		'id' => 'position',
		/**
		 * XML name attribute
		 * @datatype	string
		 */
		'name' => 'position',
		/**
		 * XML class attribute
		 * @datatype	string
		 */
		'class' => 'input-position',
		/**
		 * Array of effect options for DataCenterJs::buildEffect run on change
		 * @datatype	array
		 */
		'effect' => array(),
		/**
		 * Perspective mode, '2d' or 'iso'
		 * @datatype	string
		 */
		'mode' => '2d',
		/**
		 * List of form fields containing 'x' and 'y' keys, each containing
		 * their own names, ids and values (usually created by a form widget) and
		 * a 'range' key with an array of minimum and maximum values
		 * @datatype	array
		 */
		'fields' => array(),
	);

	/* Functions */

	public static function render(
		array $parameters
	) {
		global $wgScriptPath;
		// Checks that...
		if (
			// Both an X and a Y field were given
			isset( $parameters['fields']['x'], $parameters['fields']['y'] ) &&
			// X is an array
			is_array( $parameters['fields']['x'] ) &&
			// Y is an array
			is_array( $parameters['fields']['y'] ) &&
			// There are no other fields in the fields array
			( count( $parameters['fields'] ) == 2 )
		) {
			// Sets defaults
			$parameters = array_merge( self::$defaultParameters, $parameters );
			// Begins input
			$xmlOutput = parent::begin( $parameters['class'] );
			// Builds resource path
			$resourcePath = $wgScriptPath .
				'/extensions/DataCenter/Resources/Inputs/Position/';
			// Converts mode to upper case to avoid case-sensitivity errors
			$mode = strtoupper( $parameters['mode'] );
			// Builds list of resource paths
			$resources = array(
				'normal' => $resourcePath . $mode . '-Normal.png',
				'n' => $resourcePath . $mode . '-N.png',
				'e' => $resourcePath . $mode . '-E.png',
				's' => $resourcePath . $mode . '-S.png',
				'w' => $resourcePath . $mode . '-W.png',
			);
			// Builds lists of image map polygons
			$polygons = array(
				'2D' => array(
					'n' => '24,2,42,2,42,16,24,16',
					'e' => '42,2,58,2,58,32,42,32',
					's' => '24,16,42,16,42,32,24,32',
					'w' => '8,2,24,2,24,32,8,32',
				),
				'ISO' => array(
					'n' => '30,0,60,17,30,17',
					'e' => '60,17,30,34,30,17',
					's' => '30,34,0,17,30,17',
					'w' => '0,17,30,0,30,17'
				)
			);
			// Creates structure of elements to be created
			$structure = array(
				'x' => array(
					'e' => array(
						'op' => '+', 'func' => 'min', 'limit' => 'max'
					),
					'w' => array(
						'op' => '-', 'func' => 'max', 'limit' => 'min'
					),
				),
				'y' => array(
					'n' => array(
						'op' => '-', 'func' => 'max', 'limit' => 'min'
					),
					's' => array(
						'op' => '+', 'func' => 'min', 'limit' => 'max'
					),
				),
			);
			// Creates shortcut to fields
			$fields = $parameters['fields'];
			// Builds effect
			$effect = DataCenterJs::buildEffect(
				$parameters['effect'],
				array(
					'this.x' => sprintf(
						"document.getElementById( %s )",
						DataCenterJs::toScalar( $fields['x']['id'] )
					),
					'this.y' => sprintf(
						"document.getElementById( %s )",
						DataCenterJs::toScalar( $fields['y']['id'] )
					),
				)
			);
			// Loops over each field
			$jsOutput = '';
			foreach ( $structure as $field => $directions ) {
				// Adds label
				$xmlOutput .= DataCenterXml::tag(
					'label',
					array(
						'for' => $fields[$field]['id'],
						'class' => 'label',
					),
					DataCenterUI::message( 'field', 'position-' . $field )
				);
				// Adds input
				$xmlOutput .= DataCenterXml::tag(
					'input',
					array(
						'type' => 'text',
						'name' => $fields[$field]['name'],
						'id' => $fields[$field]['id'],
						'class' => 'number',
						'value' => $fields[$field]['value'],
					)
				);
				// Calculates minimum and maximum values
				$range = array(
					'min' => min(
						$fields[$field]['min'],
						$fields[$field]['max']
					),
					'max' => max(
						$fields[$field]['min'],
						$fields[$field]['max']
					)
				);
				foreach ( $directions as $direction => $options ) {
					// Builds javascript to connect button to input
					$jsOutput .= <<<END

						addHandler(
							document.getElementById(
								'{$fields[$field]['id']}_{$direction}'
							),
							'mouseover',
							function() {
								document.getElementById(
									'{$parameters['id']}'
								).src = '{$resources[$direction]}';
							}
						);
						addHandler(
							document.getElementById(
								'{$fields[$field]['id']}_{$direction}'
							),
							'mouseout',
							function() {
								document.getElementById(
									'{$parameters['id']}'
								).src = '{$resources['normal']}';
							}
						);
						addHandler(
							document.getElementById(
								'{$fields[$field]['id']}_{$direction}'
							),
							'click',
							function() {
								var input = document.getElementById(
									'{$fields[$field]['id']}'
								);
								var value = parseInt( input.value );
								if ( !isNaN( value ) ) {
									input.value = Math.{$options['func']}(
										value {$options['op']} 1,
										{$range[$options['limit']]}
									)
								}
								{$effect}
							}
						);
END;
				}
			}
			// Begins map
			$xmlOutput .= DataCenterXml::open(
				'map',
				array( 'name' => "{$parameters['id']}_map" )
			);
			// Loops over each field
			foreach ( $structure as $field => $directions ) {
				// Loops over each direction
				foreach ( $directions as $direction => $options ) {
					$xmlOutput .= DataCenterXml::tag(
						'area',
						array(
							'href' => '#',
							'shape' => 'poly',
							'coords' => $polygons[$mode][$direction],
							'id' => $fields[$field]['id'] . '_' . $direction,
						)
					);
				}
			}
			// Ends map
			$xmlOutput .= DataCenterXml::close( 'map' );
			// Adds image
			$xmlOutput .= DataCenterXml::tag(
				'img',
				array(
					'src' => $resources['normal'],
					'usemap' => "#{$parameters['id']}_map",
					'id' => $parameters['id'],
					'class' => 'navigator',
				)
			);
			// Adds JavaScript
			$xmlOutput .= DataCenterXml::script( $jsOutput );
			// Begins preloading
			$xmlOutput .= DataCenterXml::open(
				'div', array( 'style' => 'display:none' )
			);
			// Loops over each resource
			foreach ( $resources as $resource ) {
				// Adds resource
				$xmlOutput .= DataCenterXml::tag(
					'img', array( 'src' => $resource )
				);
			}
			// Ends preloading
			$xmlOutput .= DataCenterXml::close( 'div' );
			// Ends input
			$xmlOutput .= parent::end();
			// Returns XML
			return $xmlOutput;
		}
	}
}