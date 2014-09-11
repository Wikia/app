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
		$params = $this->extractRequestParams();
		$titles = explode( '|', $params['titles'] );
		$templateHelper = new TemplatePageHelper();

		$templatePages = [];
		foreach ( $titles as $title ) {
			$templateHelper->setTemplateByName( $title );
			$articleId = $templateHelper->getTitle()->getArticleId();
			if ( $articleId > 0 ) {
				$templatePages[$articleId] = [
					'title' => $title,
					'params' => $templateHelper->getTemplateParams()
				];
			}
		}

		$this->getResult()->setIndexedTagName( $templatePages, 'pages' );
		$this->getResult()->addValue( null, 'pages', $templatePages );
	}

	/**
	 * @return array
	 */
	public function getAllowedParams() {
		return array(
			'titles' => array(
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
