<?php

class Gateway_Form_SingleColumn extends Gateway_Form_TwoColumnLetter {

	public function __construct( &$gateway ) {
		global $wgScriptPath;

		// set the path to css, before the parent constructor is called, checking to make sure some child class hasn't already set this
		if ( !strlen( $this->getStylePath() ) ) {
			$this->setStylePath( $wgScriptPath . '/extensions/DonationInterface/gateway_forms/css/SingleColumn.css' );
		}

		parent::__construct( $gateway );
	}

	public function generateFormEnd() {
		return $this->generateFormClose();
	}
}
