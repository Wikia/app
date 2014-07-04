<?php

/**
 * TransactionTraceNewrelic implements the TransactionTrace plugin interface and handle reporting
 * transaction type name as newrelic's transaction name and all attributes as custom parameters.
 */
class TransactionTraceNewrelic {

	/**
	 * Update Newrelic's transaction name
	 *
	 * @param string $type
	 */
	public function onTypeChange( $type ) {
		if ( function_exists( 'newrelic_name_transaction' ) ) {
			newrelic_name_transaction( $type );
		}
	}

	/**
	 * Record an attribute as Newrelic's custom parameter
	 *
	 * @param string $key Attribute key
	 * @param mixed $value Attribute value
	 */
	public function onAttributeChange( $key, $value ) {
		if ( function_exists( 'newrelic_add_custom_parameter' ) ) {
			if ( is_bool( $value ) ) {
				$value = $value ? "yes" : "no";
			}
			newrelic_add_custom_parameter( $key, $value );
		}
	}
}
