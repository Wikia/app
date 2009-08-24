<?php

/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterWidgetGallery extends DataCenterWidget {

	/* Private Static Members */

	private static $defaultParameters = array(
		/**
		 * XML id attribute
		 * @datatype	string
		 */
		'id' => 'gallery',
		/**
		 * XML class attribute
		 * @datatype	string
		 */
		'class' => 'widget-gallery',
		/**
		 * Data Source
		 * @datatype	array of DataCenterDBRow
		 */
		'rows' => array(),
		/**
		 * Field to display as label
		 * @datatype	string
		 */
		'label' => array(),
		/**
		 * Field to classify icon types with as an array of fields of each row,
		 * where the field and value of field with be added as an additional CSS
		 * class such as 'category-network' where category is the field and
		 * network is the value of the field on that row
		 * @datatype	array
		 */
		'types' => array(),
		/**
		 * Link for each row using DataCenterXml::buildLink
		 * @datatype	array
		 */
		'link' => array(),
		/**
		 * Effects for each row using DataCenterXml::buildEffects
		 * @datatype	array
		 */
		'effects' => array(),
	);

	/* Static Functions */

	public static function render(
		array $parameters
	) {
		// Sets defaults
		$parameters = array_merge_recursive(
			self::$defaultParameters, $parameters
		);
		// Begins widget
		$xmlOutput = parent::begin( $parameters['class'] );
		// Gets current path
		$path = DataCenterPage::getPath();
		// Begins icons
		$xmlOutput .= DataCenterXml::open( 'div', array( 'class' => 'icons' ) );
		// Loops over each row
		foreach ( $parameters['rows'] as $row ) {
			// Sets div attributes
			$divAttributes = array( 'class' => 'icon' );
			// Checks if a list of types was specified
			if ( count( $parameters['types'] ) > 0 ) {
				// Adds list of type classes
				foreach ( $parameters['types'] as $type ) {
					$divAttributes['class'] .= ' ' . $type . '-' .
						$row->get( $type );
				}
			} else {
				// Adds generic class
				$divAttributes['class'] .= ' generic';
			}
			if ( is_array( $parameters['label'] ) ) {
				$label = '';
				foreach( $parameters['label'] as $key => $value ) {
					$label .= DataCenterXml::div(
						array( 'class' => 'label-' . $key ),
						$row->get( $value )
					);
				}
			} else {
				$label = DataCenterXml::div(
					array( 'class' => 'label-0' ),
					$row->get( $parameters['label'] )
				);
			}
			$divAttributes =  array_merge(
				$divAttributes,
				DataCenterXml::buildEffects( $parameters['effects'], $row ),
				DataCenterXml::buildLink( $parameters['link'], $row )
			);
			if ( count( $parameters['link'] ) > 0 ) {
				$divAttributes['class'] .= ' link';
			}
			// Adds icon
			$xmlOutput .= DataCenterXml::div( $divAttributes, $label );
		}
		// Clears floating
		$xmlOutput .= DataCenterXml::clearFloating();
		// Ends icon view
		$xmlOutput .= DataCenterXml::close( 'div' );
		// Ends widget
		$xmlOutput .= parent::end();
		// Returns XML
		return $xmlOutput;
	}
}