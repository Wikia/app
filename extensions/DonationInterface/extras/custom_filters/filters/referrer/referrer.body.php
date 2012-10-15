<?php

class Gateway_Extras_CustomFilters_Referrer extends Gateway_Extras {

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
		// pull out the referrer from the gateway_adapter
		$referrer = $this->gateway_adapter->getData_Unstaged_Escaped( 'referrer' );

		// a very complex filtering algorithm for referrers
		$refRules = $this->gateway_adapter->getGlobal( 'CustomFiltersRefRules' );
		foreach ( $refRules as $regex => $risk_score_modifier ) {
			/**
			 * note that the regex pattern does NOT include delimiters.
			 * these will need to be included in your custom regex patterns.
			 */
			if ( preg_match( "$regex", $referrer ) ) {
				$this->cfo->risk_score += $risk_score_modifier;

				// log it
				$log_msg = "\"" . addslashes( $referrer ) . "\"";
				$log_msg .= "\t\"" . addslashes( $regex ) . "\"";
				$log_msg .= "\t\"" . $this->cfo->risk_score . "\"";
				$this->log(
					$this->gateway_adapter->getData_Unstaged_Escaped( 'contribution_tracking_id' ), 'Filter: Referrer', $log_msg
				);
			}
		}

		return TRUE;
	}

	static function onFilter( &$gateway_adapter, &$custom_filter_object ) {
		if ( !$gateway_adapter->getGlobal( 'EnableReferrerFilter' ) ||
			!count( $gateway_adapter->getGlobal( 'CustomFiltersRefRules' ) ) ){
			return true;
		}
		$gateway_adapter->debugarray[] = 'referrer onFilter hook!';
		return self::singleton( $gateway_adapter, $custom_filter_object )->filter();
	}

	static function singleton( &$gateway_adapter, &$custom_filter_object ) {
		if ( !self::$instance || $gateway_adapter->isBatchProcessor() ) {
			self::$instance = new self( $gateway_adapter, $custom_filter_object );
		}
		return self::$instance;
	}

}
