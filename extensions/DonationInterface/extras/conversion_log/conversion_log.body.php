<?php

class Gateway_Extras_ConversionLog extends Gateway_Extras {

	static $instance;

	/**
	 * Logs the response from a transaction
	 */
	public function post_process() {
		// if the trxn has been outright rejected, log it
		if ( $this->gateway_adapter->getValidationAction() == 'reject' ) {
			$this->log(
				$this->gateway_adapter->getData_Unstaged_Escaped( 'contribution_tracking_id' ), 'Rejected'
			);
			return TRUE;
		}

		// make sure the response property has been set (signifying a transaction has been made)
		if ( !$this->gateway_adapter->getTransactionAllResults() )
			return FALSE;

		$this->log(
			$this->gateway_adapter->getData_Unstaged_Escaped( 'contribution_tracking_id' ), "Gateway response: " . addslashes( $this->gateway_adapter->getTransactionMessage() ), '"' . addslashes( json_encode( $this->gateway_adapter->getTransactionData() ) ) . '"'
		);
		return TRUE;
	}

	static function onPostProcess( &$gateway_adapter ) {
		if ( !$gateway_adapter->getGlobal( 'EnableConversionLog' ) ){
			return true;
		}
		$gateway_adapter->debugarray[] = 'conversion log onPostProcess hook!';
		return self::singleton( $gateway_adapter )->post_process();
	}

	static function singleton( &$gateway_adapter ) {
		if ( !self::$instance ) {
			self::$instance = new self( $gateway_adapter );
		}
		return self::$instance;
	}

}
