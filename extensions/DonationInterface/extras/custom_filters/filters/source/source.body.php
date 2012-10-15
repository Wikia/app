<?php

class Gateway_Extras_CustomFilters_Source extends Gateway_Extras {

	/**
	 * Container for an instance of self
	 * @var object
	 */
	static $instance;

	/**
	 * Custom filter object holder
	 * @var object
	 */
	public $cfo;

	public function __construct( &$gateway_adapter, &$custom_filter_object ) {
		parent::__construct( $gateway_adapter );
		$this->cfo = & $custom_filter_object;
	}

	public function filter() {
		// pull out the source from the filter object
		$source = $this->gateway_adapter->getData_Unstaged_Escaped( 'utm_source' );

		// a very complex filtering algorithm for sources
		$srcRules = $this->gateway_adapter->getGlobal( 'CustomFiltersSrcRules' );
		foreach ( $srcRules as $regex => $risk_score_modifier ) {
			/**
			 * Note that regex pattern does not include delimiters.
			 * These will need to be included in your custom regex patterns.
			 */
			if ( preg_match( "$regex", $source ) ) {
				$this->cfo->risk_score += $risk_score_modifier;

				// log it
				$log_msg = "\"" . addslashes( $source ) . "\"";
				$log_msg .= "\t\"" . addslashes( $regex ) . "\"";
				$log_msg .= "\t\"" . $this->cfo->risk_score . "\"";
				$this->log(
					$this->gateway_adapter->getData_Unstaged_Escaped( 'contribution_tracking_id' ), 'Filter: Source', $log_msg
				);
			}
		}

		return TRUE;
	}

	static function onFilter( &$gateway_adapter, &$custom_filter_object ) {
		if ( !$gateway_adapter->getGlobal( 'EnableSourceFilter' ) ||
			!count( $gateway_adapter->getGlobal( 'CustomFiltersSrcRules' ) ) ){
			return true;
		}
		$gateway_adapter->debugarray[] = 'source onFilter hook!';
		return self::singleton( $gateway_adapter, $custom_filter_object )->filter();
	}

	static function singleton( &$gateway_adapter, &$custom_filter_object ) {
		if ( !self::$instance || $gateway_adapter->isBatchProcessor() ) {
			self::$instance = new self( $gateway_adapter, $custom_filter_object );
		}
		return self::$instance;
	}

}
