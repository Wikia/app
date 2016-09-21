<?php

use Wikia\Tracer\WikiaTracer;

/**
 * TransactionTraceNewrelic implements the TransactionTrace plugin interface and handles reporting
 * transaction type name as newrelic's transaction name and all attributes as custom parameters.
 *
 * @see https://docs.newrelic.com/docs/agents/php-agent/configuration/php-agent-api
 */
class TransactionTraceNewrelic {

	// create custom transactions for given PHP calls
	private static $customTraces = [
		# PLATFORM-1696: RabbitMQ traffic
		'Wikia\Tasks\Tasks\BaseTask::queue',
		'PhpAmqpLib\Wire\IO\StreamIO::read',

		# PLATFORM-1694: HTTP requests
		'Wikia\Service\Helios\HeliosClientImpl::request', # Helios
		'PhalanxService::sendToPhalanxDaemon', # Phalanx
		'Wikia\Persistence\User\Preferences\PreferencePersistenceSwaggerService::get', # Preferences
		'TemplateClassificationService::getType', # Template classification
		'UserMailer::send', # emails
		'ForeignAPIRepo::httpGet', # calls to upload.wikimedia.org and commons.wikimedia.org
		'LillyHooks::processLink',
	];

	/**
	 * Set up NewRelic integration and custom PHP calls tracer
	 */
	function __construct() {
		if ( function_exists( 'newrelic_add_custom_tracer' ) ) {
			foreach( self::$customTraces as $customTrace ) {
				newrelic_add_custom_tracer( $customTrace );
			}
		}

		// report trace ID and (optionally) parent span ID as a custom request parameter for easier debugging of slow transactions in SOA world
		if ( function_exists( 'newrelic_add_custom_parameter' ) ) {
			newrelic_add_custom_parameter( 'traceId', WikiaTracer::instance()->getTraceId() );
			newrelic_add_custom_parameter( 'spanId', WikiaTracer::instance()->getSpanId() );
			newrelic_add_custom_parameter( 'parentSpanId', WikiaTracer::instance()->getParentSpanId() );
		}
	}

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
