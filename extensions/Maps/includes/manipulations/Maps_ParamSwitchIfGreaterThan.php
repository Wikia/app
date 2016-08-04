<?php

/**
 * Parameter manipulation to switch value with another parameter if its value is
 * lesser than this parameters value.
 *
 * @since 3.0
 *
 * @file Maps_ParamSwitchIfGreaterThan.php
 * @ingroup Maps
 * @ingroup ParameterManipulations
 *
 * @author Daniel Werner
 */
class MapsParamSwitchIfGreaterThan extends ItemParameterManipulation {

	protected $greaterParam;

	/**
	 * Constructor
	 *
	 * @param Parameter &$param parameter to switch value with if lesser than this one.
	 *
	 * @since 3.0
	 */
	public function __construct( Parameter &$param ) {
		parent::__construct();
		$this->greaterParam = $param;
	}

	/**
	 * @see ItemParameterManipulation::doManipulation
	 *
	 * @since 3.0
	 */
	public function doManipulation( &$value, Parameter $parameter, array &$parameters ) {
		/*
		 * make sure maxScale is lower than minScale. Base layers would work fine anyhow
		 * but overlays would behave strange in some cases. Also useres could be confused
		 * by this so we take care of it.
		 */
		if ( $value > $this->greaterParam->getValue() ) {
			$minScale = $value;
			$value = $this->greaterParam->getValue();
			$this->greaterParam->setValue( $minScale );
		}
	}
}

