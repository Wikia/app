<?php

/**
 * Class ApiTemplateSuggestions
 *
 * Get suggested templates to use on a wiki
 */

class ApiTemplateSuggestions extends ApiBase {

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function execute() {
		$fauxRequest = new FauxRequest( [
			'action' => 'query',
			'list' => 'querypage',
			'qppage' => 'Mostlinkedtemplates',
			'qplimit' => 50
		] );
		$api = new ApiMain( $fauxRequest );
		$api->execute();
		$resultData = $api->getResultData();
		$results = $resultData['query']['querypage']['results'];

		$templates = [];
		foreach ( $results as $template ) {
			$title = Title::newFromText( $template['title'] );
			if ( is_object( $title ) ) {
				$titleText = $title->getText();
				if ( strlen( $titleText ) > 1 ) {
					$templates[] = [
						'title' => $titleText,
						'uses' => $template['value'],
					];
				}
			}
		}

		$this->getResult()->setIndexedTagName( $templates, 'templates' );
		$this->getResult()->addValue( null, 'templates', $templates );
	}

	/**
	 * @return array
	 */
	public function getAllowedParams() {
		return [];
	}

	/**
	 * @return string
	 */
	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}
