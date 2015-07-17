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
		$this->mParams = $this->extractRequestParams();

		$fauxRequest = new FauxRequest( [
			'action' => 'query',
			'list' => 'querypage',
			'qppage' => 'Mostlinkedtemplates',
			'qplimit' => 50,
			'qpoffset' => $this->mParams['offset']
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

		if ( isset ( $resultData['query-continue'] ) ) {
			$queryContinue = $resultData['query-continue']['querypage']['qpoffset'];
			$this->getResult()->addValue( null, 'query-continue', $queryContinue );
		}
	}

	/**
	 * @return array
	 */
	public function getAllowedParams() {
		return array(
			'offset' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_REQUIRED => false
			)
		);
	}

	/**
	 * @return string
	 */
	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}
