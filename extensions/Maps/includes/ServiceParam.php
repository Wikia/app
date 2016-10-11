<?php

namespace Maps;

use MapsMappingServices;
use ParamProcessor\Definition\StringParam;
use ParamProcessor\IParam;
use ParamProcessor\IParamDefinition;
use ParamProcessor\ParamDefinition;

/**
 * Parameter definition for mapping service parameters.
 *
 * @since 2.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ServiceParam extends StringParam {

	/**
	 * The mapping feature. Needed to determine which services are available.
	 *
	 * @since 2.0
	 *
	 * @var string
	 */
	protected $feature;

	/**
	 * @see ParamDefinition::postConstruct()
	 *
	 * @since 2.0
	 */
	protected function postConstruct() {
		global $egMapsDefaultService, $egMapsDefaultServices;

		$this->setDefault( array_key_exists( $this->feature, $egMapsDefaultServices ) ? $egMapsDefaultServices[$this->feature] : $egMapsDefaultService );

		// FIXME
		$this->allowedValues = MapsMappingServices::getAllServiceValues();
	}

	/**
	 * @see ParamDefinition::formatValue()
	 *
	 * @since 2.0
	 *
	 * @param mixed $value
	 * @param IParam $param
	 * @param IParamDefinition[] $definitions
	 * @param IParam[] $params
	 *
	 * @return mixed
	 */
	protected function formatValue( $value, IParam $param, array &$definitions, array $params ) {
		// Make sure the service is valid.
		$value = MapsMappingServices::getValidServiceName( $value, $this->feature );

		// Get the service object so the service specific parameters can be retrieved.
		$serviceObject = MapsMappingServices::getServiceInstance( $value );

		// Add the service specific service parameters.
		$serviceObject->addParameterInfo( $definitions );

		$definitions = ParamDefinition::getCleanDefinitions( $definitions );

		return $value;
	}

	/**
	 * @see ParamDefinition::setArrayValues()
	 *
	 * @since 2.0
	 *
	 * @param array $param
	 */
	public function setArrayValues( array $param ) {
		parent::setArrayValues( $param );

		if ( array_key_exists( 'feature', $param ) ) {
			$this->setFeature( $param['feature'] );
		}
	}

	/**
	 * Sets the mapping feature.
	 *
	 * @since 2.0
	 *
	 * @param string $feature
	 */
	public function setFeature( $feature ) {
		$this->feature = $feature;
	}

}
