<?php

/**
 * Parameter manipulation for Layer definition keys and values.
 *
 * @since 3.0
 *
 * @file
 * @ingroup Maps
 * @ingroup ParameterManipulations
 *
 * @author Daniel Werner
 */
class MapsParamLayerDefinition extends ItemParameterManipulation {

	protected $itemSep;
	protected $keyValueSep;

	/**
	 * Constructor
	 *
	 * @param string $itemSep separator between prameters.
	 * @param string $keyValueSep separator between parameter name and associated value.  
	 *
	 * @since 3.0
	 */
	public function __construct( $itemSep = "\n", $keyValueSep = '=' ) {
		parent::__construct();
		$this->itemSep = $itemSep;
		$this->keyValueSep = $keyValueSep;
	}

	/**
	 * @see ItemParameterManipulation::doManipulation
	 *
	 * @since 3.0
	 */
	public function doManipulation( &$value, Parameter $parameter, array &$parameters ) {
		// string to array describing layer parameters:
		$value = MapsLayers::parseLayerParameters( $value, $this->itemSep, $this->keyValueSep );
	}
}

