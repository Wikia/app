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
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Daniel Werner
 */
class MapsParamLocation extends MapsCommonParameterManipulation {

	/**
	 * In some usecases, the parameter values will contain extra location
	 * metadata, which should be ignored here. This field holds the delimiter
	 * used to separate this data from the actual location.
	 *
	 * @since 0.7.2
	 *
	 * @var string
	 */
	protected $metaDataSeparator;

	/**
	 * Should the location be turned into a JSON object.
	 *
	 * @var boolean
	 */
	public $toJSONObj = false;

	/**
	 * Constructor.
	 *
	 * @since 0.7.2
	 */
	public function __construct( $metaDataSeparator = false ) {
		parent::__construct();

		$this->metaDataSeparator = $metaDataSeparator;
	}

	/**
	 * @see ItemParameterManipulation::doManipulation
	 *
	 * @since 0.7.2
	 */
	public function doManipulation( &$value , Parameter $parameter , array &$parameters ) {
		$parts = $this->metaDataSeparator === false ? array( $value ) : explode( $this->metaDataSeparator , $value );

		$value = array_shift( $parts );
		$value = new MapsLocation( $value );

		$this->handleCommonParams( $parts , $value );

		if ( $icon = array_shift( $parts ) ) {
			$value->setIcon( $icon );
		}

		if ( $group = array_shift( $parts ) ) {
			$value->setGroup( $group );
		}

		if ( $inlineLabel = array_shift( $parts ) ) {
			$value->setInlineLabel( $inlineLabel );
		}

		if ( $visitedIcon = array_shift( $parts ) ) {
			$value->setVisitedIcon( $visitedIcon );
		}

		if ( $this->toJSONObj ) {
			$value = $value->getJSONObject();
		}
	}
}