<?php

/**
 * File holding the SPSDateIterator class
 * 
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticPageSeries
 */
if ( !defined( 'SPS_VERSION' ) ) {
	die( 'This file is part of the SemanticPageSeries extension, it is not a valid entry point.' );
}

/**
 * The SPSDateIterator class.
 *
 * @ingroup SemanticPageSeries
 */
class SPSDateIterator extends SPSIterator {
	
	/**
	 * @return array An array containing the names of the parameters this iterator uses.
	 */
	function getParameterNames() {
		return array(
			'start' => SPS_MANDATORY,
			'end' => SPS_OPTIONAL,
			'period' => SPS_OPTIONAL,
			'unit' => SPS_OPTIONAL
			);
	}
	
	/**
	 * @return an array of the values to be used in the target field of the target form
	 */
	function getValues ( &$data ){
		
		$start  = SPSUtils::fromArray( $data, 'start' );
		$end    = SPSUtils::fromArray( $data, 'end', $start );
		$period = SPSUtils::fromArray( $data, 'period', 1 );
		$unit   = SPSUtils::fromArray( $data, 'unit', 'day' );
		
		if ( $start === null || $start === '' ) {
			throw new SPSException( SPSUtils::buildMessage( 'spserror-date-startdatemissing' ) );
		}
		
		//prepare params for getDatesForRecurringEvent
		$params = array (
			'property=SomeDummyProperty',
			'start=' . $start,
			'end=' . $end,
			'period=' . $period,
			'unit=' . $unit,
			);

		$values = SMWSetRecurringEvent::getDatesForRecurringEvent($params);
		
		if ( $values === null ) {
			throw new SPSException( SPSUtils::buildMessage( 'spserror-date-internalerror' ) );
		}

		// if the first date did not contain a time, remove the time from all
		// generated dates
		if ( preg_match( '/.:../', $values[1][0] ) === 0 ) {
			foreach ( $values[1] as $key => $value ) {
				$values[1][$key] = trim( preg_replace( '/..:..:../', '', $value ) );
			}
		}

		return $values[1];
	}
}
