<?php

/**
 * Class ApiTemplateParameters
 *
 * Get available parameters for a template or multiple templates
 */

class ApiTemplateParameters extends ApiBase {

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function execute() {
		global $wgRequest, $wgParser;

		$params = $this->extractRequestParams();
		$templates = explode( '|', $params['templates'] );
		$templateHelper = new TemplatePageHelper();

		foreach ( $templates as $template ) {
			$templateHelper->setTemplateName( $template );
			$availableParams[$template] = $templateHelper->getTemplateParams();
		}

		$this->getResult()->addValue( null, 'parameters', $availableParams );
	}

	/**
	 * @return array
	 */
	public function getAllowedParams() {
		return array(
			'templates' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
			),
		);
	}

	/**
	 * @return string
	 */
	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}

}
