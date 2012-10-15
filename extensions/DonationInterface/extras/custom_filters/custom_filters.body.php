<?php

class Gateway_Extras_CustomFilters extends Gateway_Extras {

	/**
	 * A value for tracking the 'riskiness' of a transaction
	 *
	 * The action to take based on a transaction's riskScore is determined by
	 * $action_ranges.  This is built assuming a range of possible risk scores
	 * as 0-100, although you can probably bend this as needed.
	 * @var public int
	 */
	public $risk_score;

	/**
	 * Define the action to take for a given $risk_score
	 * @var public array
	 */
	public $action_ranges;

	/**
	 * A container for an instance of self
	 */
	static $instance;

	public function __construct( &$gateway_adapter ) {
		parent::__construct( $gateway_adapter ); //gateway_adapter is set in there. 
		// load user action ranges and risk score		
		$this->action_ranges = $this->gateway_adapter->getGlobal( 'CustomFiltersActionRanges' );
		$this->risk_score = $this->gateway_adapter->getGlobal( 'CustomFiltersRiskScore' );
	}

	/**
	 * Determine the action to take for a transaction based on its $risk_score
	 *
	 * @return string The action to take
	 */
	public function determineAction() {
		// possible risk scores are between 0 and 100
		if ( $this->risk_score < 0 )
			$this->risk_score = 0;
		if ( $this->risk_score > 100 )
			$this->risk_score = 100;
		foreach ( $this->action_ranges as $action => $range ) {
			if ( $this->risk_score >= $range[0] && $this->risk_score <= $range[1] ) {
				return $action;
			}
		}
	}

	/**
	 * Run the transaction through the custom filters
	 */
	public function validate() {
		// expose a hook for custom filters
		wfRunHooks( 'GatewayCustomFilter', array( &$this->gateway_adapter, &$this ) );
		$localAction = $this->determineAction();
//		error_log("Filter validation says " . $localAction);
		$this->gateway_adapter->setValidationAction( $localAction );

		$log_msg = '"' . $localAction . "\"\t\"" . $this->risk_score . "\"";
		$this->log( $this->gateway_adapter->getData_Unstaged_Escaped( 'contribution_tracking_id' ), 'Filtered', $log_msg );
		return TRUE;
	}

	static function onValidate( &$gateway_adapter ) {
		if ( !$gateway_adapter->getGlobal( 'EnableCustomFilters' ) ){
			return true;
		}
		$gateway_adapter->debugarray[] = 'custom filters onValidate hook!';
		return self::singleton( $gateway_adapter )->validate();
	}

	static function singleton( &$gateway_adapter ) {
		if ( !self::$instance || $gateway_adapter->isBatchProcessor() ) {
			self::$instance = new self( $gateway_adapter );
		}
		return self::$instance;
	}

}
