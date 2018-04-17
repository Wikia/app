<?php

class ApiWikiFactoryRemoveVariable extends ApiBase {

	public function execute() {
		if ( !$this->getUser()->isAllowed( 'wikifactory' ) ) {
			$this->dieUsageMsg( 'badaccess-groups' );
		}

		$params = $this->extractRequestParams();

		$result = WikiFactory::removeVarById(
			$params['variable_id'],
			$params['wiki_id'],
			$params['reason']
		);

		if ( !$result ) {
			$this->dieUsageMsg( 'databaseerror' );
		}
	}

	protected function getAllowedParams() {
		return [
			'variable_id' => [
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_REQUIRED => true,
			],
			'wiki_id' => [
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_REQUIRED => true,
			],
			'reason' => null,
			'token' => null,
		];
	}

	public function getTokenSalt() {
		return '';
	}

	public function mustBePosted() {
		return true;
	}

	public function needsToken() {
		return true;
	}

	public function isWriteMode() {
		return true;
	}

	public function getVersion() {
		return __CLASS__;
	}
}
