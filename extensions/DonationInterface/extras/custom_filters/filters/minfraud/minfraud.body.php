<?php

/**
 * Wrapper for using minFraud extra as a custom filter
 *
 * Essentially runs minfraud query as the regular minFraud extra extension does
 * with slight modifications.  So all we do here is overload validate()
 * and add in some extra customFilters specific stuff.
 */
class Gateway_Extras_CustomFilters_MinFraud extends Gateway_Extras_MinFraud {

	static $instance;

	public function filter( &$custom_filter_object ) {
		// see if we can bypass minfraud
		if ( $this->can_bypass_minfraud() ){
			return TRUE;
		}

		$minfraud_query = $this->build_query( $this->gateway_adapter->getData_Unstaged_Escaped() );
		$this->query_minfraud( $minfraud_query );
		

		$custom_filter_object->risk_score += $this->minfraud_response['riskScore'];

		// Write the query/response to the log
		$this->log_query( $minfraud_query, '' );
		return TRUE;
	}

	static function onFilter( &$gateway_adapter, &$custom_filter_object ) {	
		if ( !$gateway_adapter->getGlobal( 'EnableMinfraud_as_filter' ) ){
			return true;
		}
		$gateway_adapter->debugarray[] = 'minfraud onFilter hook!';
		return self::singleton( $gateway_adapter )->filter( $custom_filter_object );
	}

	static function singleton( &$gateway_adapter ) {
		if ( !self::$instance || $gateway_adapter->isBatchProcessor() ) {
			self::$instance = new self( $gateway_adapter );
		}
		return self::$instance;
	}

}
