<?php

/**
 * Parameter manipulation converting the value into a list by joining the items together.
 *
 * @deprecated since 0.5, removal in 0.7
 * @since 0.4
 * 
 * @file ParamManipulationImplode.php
 * @ingroup Validator
 * @ingroup ParameterManipulations
 * 
 * @author Jeroen De Dauw
 */
class ParamManipulationImplode extends ListParameterManipulation {
	
	/**
	 * The delimiter to join the items together with.
	 * 
	 * @since 0.4
	 * 
	 * @var string
	 */
	protected $delimiter;
	
	/**
	 * A wrapper to encapsulate each item in.
	 * 
	 * @since 0.4
	 * 
	 * @var string
	 */
	protected $wrapper;	
	
	/**
	 * Constructor.
	 * 
	 * @since 0.4
	 */
	public function __construct( $delimiter = ',', $wrapper = '' ) {
		parent::__construct();
		
		$this->delimiter = $delimiter;
		$this->wrapper = $wrapper;
	}	
	
	/**
	 * @see ParameterManipulation::manipulate
	 * 
	 * @since 0.4
	 */	
	public function manipulate( Parameter &$parameter, array &$parameters ) {
		$parameter->setValue( $this->wrapper . implode( $this->wrapper . $this->delimiter . $this->wrapper, $parameter->getValue() ) . $this->wrapper ); 
	}
	
}