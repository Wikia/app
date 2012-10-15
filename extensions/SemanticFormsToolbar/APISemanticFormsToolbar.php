<?php

class ApiSemanticFormsToolbar extends ApiBase {
	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function execute() {
		$params = $this->extractRequestParams();
		
		$result = array();
		
		$form = Title::newFromText( $params['form'] );
		
		if ( $params['input-data'] ) {
			$data = json_decode($params['input-data']);
		} else {
			$data = array();
		}
		
		$wikitext = $params['input-wikitext'];
		
		if ( in_array( 'wikitext', $params['output'] ) ) {
			$result['wikitext'] = SemanticFormsToolbar::getWikitext( $form, $data );
		}
		
		if ( in_array('html', $params['output']) ) {
			$result['html'] = SemanticFormsToolbar::getFormHTML( $form, $data, $wikitext );
		}
		
		$this->getResult()->addValue( null, 'sftoolbar', $result );
	}
	
	public function getAllowedParams() {
		return array(
			'form' => array(
				ApiBase::PARAM_REQUIRED => true,
			),
			'input-wikitext' => null,
			'input-data' => null,
			'output' => array(
				ApiBase::PARAM_DFLT => 'html',
				ApiBase::PARAM_TYPE => array(
					'html',
					'wikitext',
				),
				ApiBase::PARAM_ISMULTI => true,
			),
		);
	}
	
	protected function getParamDescription() {
		return array(
			'form' => 'The form in question',
			'input-wikitext' => 'The existing wikitext',
			'input-data' => 'JSON-encoded associative array of stuff that would be POSTed to the form',
			'output' => 'The output type, form HTML or generated wikitext',
		);
	}
	
	public function getVersion() {
		return '1';
	}
}
