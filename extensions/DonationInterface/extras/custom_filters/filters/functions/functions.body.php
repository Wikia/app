<?php

class Gateway_Extras_CustomFilters_Functions extends Gateway_Extras {

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

		$functions = $this->gateway_adapter->getGlobal( 'CustomFiltersFunctions' );
		foreach ( $functions as $function_name => $risk_score_modifier ) {
			//run the function specified, if it exists. 
			if ( method_exists( $this->gateway_adapter, $function_name ) ) {
				$score = $this->gateway_adapter->{$function_name}();
				if ( is_null( $score ) ){
					$score = 0; //TODO: Is this the correct behavior? 
				} elseif ( is_bool( $score ) ) {
					$score = ( $score ? 0 : $risk_score_modifier );
				} elseif ( is_numeric( $score ) && $score <= 100 ) {
					$score = $score * $risk_score_modifier / 100;
				} else {
//					error_log("Function Filter: $function_name returned $score");
					throw new MWException( "Filter functions are returning somekinda nonsense." );
				}

				$this->cfo->risk_score += $score;
			}
		}

		return TRUE;
	}

	static function onFilter( &$gateway_adapter, &$custom_filter_object ) {
		if ( !$gateway_adapter->getGlobal( 'EnableFunctionsFilter' ) ||
			!count( $gateway_adapter->getGlobal( 'CustomFiltersFunctions' ) ) ){
			return true;
		}
		$gateway_adapter->debugarray[] = 'functions onFilter hook!';
		return self::singleton( $gateway_adapter, $custom_filter_object )->filter();
	}

	static function singleton( &$gateway_adapter, &$custom_filter_object ) {
		if ( !self::$instance || $gateway_adapter->isBatchProcessor() ) {
			self::$instance = new self( $gateway_adapter, $custom_filter_object );
		}
		return self::$instance;
	}

}
