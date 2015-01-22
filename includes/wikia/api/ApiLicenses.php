<?php

class ApiLicenses extends ApiBase {

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function execute() {
		$params = $this->extractRequestParams();

		try {
			$licenses = new Licenses( $params );
		} catch ( Exception $e ) {
			$this->dieUsageMsg( 'Invalid name or id' );
		}

		$selected = isset( $params['default'] ) ? $params['default'] : null;
		$this->getResult()->addValue( null, $this->getModuleName(), array(
			'html' => $licenses->getInputHTML( $selected )
		) );
	}

	public function getAllowedParams() {
		return array(
			'default' => array (
				ApiBase::PARAM_DFLT => wfMsg( 'nolicense' ),
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false
			),
			'id' => array (
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false
			),
			'name' => array (
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true
			),
		);
	}

	public function getDescription() {
		return array (
			wfMessage( 'media-license-dropdown-html' )->text()
		);
	}

	public function getParamDescription() {
		return array (
			'default' => wfMessage( 'default-selected-value' )->text(),
			'id' => wfMessage( 'value-for-attr', 'id' )->text(),
			'name' => wfMessage( 'value-for-attr', 'name' )->text()
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}