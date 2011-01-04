<?php

/**
 * Parameter manipulation turning the value into a MapsLocation object.
 * 
 * @since 0.7.2
 * 
 * @file Maps_ParamLocation.php
 * @ingroup Maps
 * @ingroup ParameterManipulations
 * 
 * @author Jeroen De Dauw
 */
class MapsParamLocation extends ItemParameterManipulation {
	
	/**
	 * In some usecases, the parameter values will contain extra location
	 * metadata, which should be ignored here. This field holds the delimiter
	 * used to seperata this data from the actual location. 
	 * 
	 * @since 0.7
	 * 
	 * @var string
	 */
	protected $metaDataSeparator;	
	
	/**
	 * Constructor.
	 * 
	 * @since 0.7
	 */
	public function __construct( $metaDataSeparator = false ) {
		parent::__construct();
		
		$this->metaDataSeparator = $metaDataSeparator;		
	}
	
	/**
	 * @see ItemParameterManipulation::doManipulation
	 * 
	 * @since 0.7
	 */	
	public function doManipulation( &$value, Parameter $parameter, array &$parameters ) {
		$parts = $this->metaDataSeparator === false ? array( $value ) : explode( $this->metaDataSeparator, $value ); 
		 
		$value = new MapsLocation( array_shift( $parts ) );
		
		if ( $title = array_shift( $parts ) ) {
			$value->setTitle( $title );
		}
		
		if ( $text = array_shift( $parts ) ) {
			$value->setText( $text );
		}

		if ( $icon = array_shift( $parts ) ) {
			$value->setIcon( $icon );
		}
	}
	
}