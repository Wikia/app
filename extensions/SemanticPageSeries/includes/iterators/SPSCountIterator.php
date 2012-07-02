<?php

/**
 * File holding the SPSCountIterator class
 * 
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticPageSeries
 */
if ( !defined( 'SPS_VERSION' ) ) {
	die( 'This file is part of the SemanticPageSeries extension, it is not a valid entry point.' );
}

/**
 * The SPSCountIterator class.
 *
 * @ingroup SemanticPageSeries
 */
class SPSCountIterator extends SPSIterator {

	/**
	 * @return array An array containing the names of the parameters this iterator uses.
	 */
	function getParameterNames() {
		return array(
			'from' => SPS_OPTIONAL,
			'to' => SPS_OPTIONAL,
			'step' => SPS_OPTIONAL,
			'digits' => SPS_OPTIONAL
		);
	}

	/**
	 * @return an array of the values to be used in the target field of the target form
	 */
	function getValues( &$data ) {

		$from = SPSUtils::fromArray( $data, 'from', 1 );
		$to = SPSUtils::fromArray( $data, 'to', $from );
		$step = SPSUtils::fromArray( $data, 'step', 1 );
		$digits = SPSUtils::fromArray( $data, 'digits', 1 );

		$errors = '';

		if ( !is_numeric( $from ) ) {
			$errors .= SPSUtils::buildMessage( 'spserror-count-startvaluemalformed' ) . "\n";
		} 
		
		if ( !is_numeric( $to ) ) {
			$errors .= SPSUtils::buildMessage( 'spserror-count-endvaluemalformed' ) . "\n";
		} 
		
		if ( !is_numeric( $step ) ) {
			$errors .= SPSUtils::buildMessage( 'spserror-count-stepvaluemalformed' ) . "\n";
		} 
		
		if ( !is_numeric( $digits ) ) {
			$errors .= SPSUtils::buildMessage( 'spserror-count-digitsvaluemalformed' ) . "\n";
		}

		if ( $errors !== '' ) {
			throw new SPSException( $errors );
		}

		$values = array();

		for ( $index = $from; $index <= $to; $index+=$step ) {
			$values[] = sprintf( '%0' . $digits . 'd', $index );
		}

		return $values;
	}

}
