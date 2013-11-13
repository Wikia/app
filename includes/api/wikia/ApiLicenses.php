<?php

class ApiLicenses extends ApiBase {

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function execute() {
		$params = $this->extractRequestParams();
		$licenses = new Licenses( $params );
		$selected = isset( $params['default'] ) ? $params['default'] : null;
		$this->getResult()->addValue( null, $this->getModuleName(), array(
			'html' => $licenses->getInputHTML( $selected )
		) );
	}

	public function getAllowedParams() {
		return array(
			'default' => array (
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
			'Get media licenses dropdown HTML.'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}