<?php

use ParamProcessor\Processor;

/**
 * Class for describing map layers.
 *
 * @since 0.7.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Daniel Werner
 */
abstract class MapsLayer {

	/**
	 * Returns a string containing the JavaScript definition of this layer.
	 * Only call this function when you are sure the layer is valid!
	 * 
	 * @since 0.7.1
	 * 
	 * @return string
	 */
	public abstract function getJavaScriptDefinition();

	/**
	 * @since 0.7.1
	 * 
	 * @var array
	 */
	protected $properties;

	/**
	 * @since 3.0
	 *
	 * @var array
	 */
	protected $originalPropertyValues;

	/**
	 * @since 0.7.1
	 * 
	 * @var array
	 */
	protected $errors = array();

	/**
	 * Keeps track if the layer has been validated, to prevent doing redundant work.
	 * 
	 * @since 0.7.1
	 * 
	 * @var boolean
	 */
	protected $hasValidated = false;

	/**
	 * Optional name of a layer within its group. This is for identifying a layer for only
	 * displaying this specific layer instead of all layers within a agroup. If this layer
	 * should not be selectable on its own without any other group members, the value is null
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Constructor.
	 * 
	 * @since 0.7.1 ($name since 3.0)
	 * 
	 * @param array $properties
	 * @param string $name optional name of the layer within its group for being able to select
	 *        the layer on its own without having other members of the group available to be
	 *        displayed in the maps layer control.
	 */
	public function __construct( array $properties, $name = null ) {
		$this->properties = $properties;
		$this->name = $name;
		$this->originalPropertyValues = $properties;
	}

	/**
	 * Returns the error messages, optionally filtered by an error tag.
	 * 
	 * @since 0.7.1
	 * 
	 * @param mixed $tag
	 * 
	 * @return array of string
	 */
	public function getErrorMessages( $tag = false ) {
		$messages = array();
		
		foreach ( $this->errors as $error ) {
			if ( $tag === false || $error->hasTag( $tag ) ) {
				$messages[] = $error->getMessage();
			}
		}
		
		return $messages;
	}

	/**
	 * Returns the layers properties.
	 * 
	 * @since 0.7.1
	 * 
	 * @return array
	 */
	public function getProperties() {
		return $this->properties;
	}

	/**
	 * Returns the layer type represented by the class of this layer instance.
	 *
	 * @since 3.0
	 *
	 * @return string
	 */
	final public function getType() {
		return MapsLayerTypes::getTypeOfLayer( $this );
	}

	/**
	 * Returns the layers name within its group. If not name is defined, this will
	 * return null
	 *
	 * @since 3.0
	 *
	 * @return string|null
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Convenient function for getting mapping services supported by this layer.
	 *
	 * @since 3.0
	 *
	 * @return string[]
	 */
	final public function getSupportedServices() {
		return MapsLayerTypes::getServicesForType( $this->getType() );
		
	}

	/**
	 * Convenience function to find out whether the layer is supporting a certain mapping service.
	 *
	 * @since 3.0
	 * @param string $service
	 *
	 * @return boolean
	 */
	final public function isSupportingService( $service ) {
		$services = $this->getSupportedServices();
		return in_array( $service, $services );
	}

	/**
	 * Validates the layer.
	 * 
	 * @since 0.7.1
	 */
	protected function validate() {
		if( $this->hasValidated ) {
			return;
		}
		$this->hasValidated = true;
		
		$validator = Processor::newDefault();
		
		$validator->setParameters( $this->properties, $this->getParameterDefinitions() );
		$validator->validateParameters();
		
		if ( $validator->hasErrors() !== false ) {
			$this->errors = $validator->getErrors();
		}
		$params = $validator->getParameterValues();
		$this->properties = $params;
	}

	/**
	 * Returns whether the properties make up a valid layer definition without any errors.
	 * 
	 * @since 0.7.1
	 * 
	 * @return boolean
	 */
	public function isValid() {
		if ( !$this->hasValidated ) {
			$this->validate();
		}
		return empty( $this->errors );
	}

	/**
	 * Returns whether the layer can be used as it is defined. Returns true even if errors
	 * which are non fatal have occurred.
	 *
	 * @since 3.0
	 *
	 * @return boolean
	 */
	public function isOk() {
		if ( ! $this->isValid() ) {
			// check whether one fatal error has occurred:
			foreach( $this->errors as $error ) {
				if( $error->isFatal() ) {
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Returns an array of parameter definitions.
	 *
	 * @since 3.0 (and before as abstract function since 0.7.2)
	 *
	 * @return array
	 */
	protected function getParameterDefinitions() {
		$params = array();

		$params['label'] = array(
			'message' => 'maps-displaymap-par-coordinates', // TODO-customMaps: create a message
		);

		// units for extent data:
		$params['units'] = array(
			'default' => 'degree',
			'message' => 'maps-displaymap-par-coordinates', // TODO-customMaps: create a message
			'values' => array( 'degree', 'm', 'ft', 'km', 'mi', 'inches' ),
		);

		// zoom information:
		$params['minscale'] = array(
			'type' => 'float',
			'default' => false,
			'manipulatedefault' => false,
			'message' => 'maps-displaymap-par-coordinates', // TODO-customMaps: create a message
		);

		$params['maxscale'] = array(
			'type' => 'float',
			'default' => false,
			'manipulatedefault' => false,
			'message' => 'maps-displaymap-par-coordinates', // TODO-customMaps: create a message
			// TODO-customMaps: addManipulations( new MapsParamSwitchIfGreaterThan( $params['minscale'] ) );
		);

		$params['zoomlevels'] = array(
			'type' => 'integer',
			'default' => false,
			'manipulatedefault' => false,
			'message' => 'maps-displaymap-par-coordinates', // TODO-customMaps: create a message
			// TODO-customMaps: addManipulations( new MapsParamSwitchIfGreaterThan( $params['minscale'] ) );
		);

		return $params;
	}

	/**
	 * Returns the value of a property value formated for html output.
	 * The result contains pure html.
	 *
	 * @since 3.0
	 *
	 * @param string $name Name of the property value
	 * @param Parser $parser
	 *
	 * @return array
	 */
	public function getPropertiesHtmlRepresentation( &$parser ) {
		$this->validate(); // make sure properties are available!
		$transformed = array();
		foreach( $this->properties as $property => $value ) {

			if( ! $this->isValid() ) {
				// datermine whether value for this parameter is valid:
				$errors = $this->getErrorMessages( $property );

				if ( $errors ) {
					$transformed[ $property ] = '<i class="error">' . implode( '<br />', array_map( 'htmlspecialchars', $errors ) ) . '</i>';
					continue;
				}
			}
			$transformed[ $property ] = $this->getPropertyHtmlRepresentation( $property, $parser );
		}
		$this->doPropertiesHtmlTransform( $transformed );
		return $transformed;
	}

	/**
	 * Returns the value of a property value formatted for html output
	 *
	 * @since 3.0
	 *
	 * @param string $name Name of the property value
	 * @param Parser $parser
	 *
	 * @return string
	 */
	protected function getPropertyHtmlRepresentation( $name, &$parser ) {
		$value = $this->properties[ $name ];
		
		switch( $name ) {
			case 'maxscale':
			case 'minscale':
				// if default value is in use:
				if( $value === false ) {
					return '<i>auto</i>';
				}
				break;
		}

		return htmlspecialchars( $value );
	}

	/**
	 * Does the final transform of the properties array for html representation after
	 * each single property value is transformed by 'getPropertyHtmlRepresentation()'
	 * already. This is used to group certain properties for nicer output.
	 *
	 * @since 3.0
	 *
	 * @param array &$properties
	 *
	 * @return array
	 */
	protected function doPropertiesHtmlTransform( &$properties ) {
		$properties['scale'] = "<b>max:</b> {$properties['maxscale']}, <b>min:</b> {$properties['minscale']}";
		unset( $properties['maxscale'], $properties['minscale'] );
	}
}

