<?php

class ApiWikiFactorySaveVariable extends ApiBase {

	/**
	 * @throws UsageException
	 */
	public function execute() {
		if ( !$this->getUser()->isAllowed( 'wikifactory' ) ) {
			$this->dieUsageMsg( 'badaccess-groups' );
		}

		$params = $this->extractRequestParams();

		try {
			$result = WikiFactory::validateAndSetVarById(
				$params['variable_id'],
				$params['wiki_id'],
				$params['variable_value'],
				$params['reason']
			);

			if ( !$result ) {
				$this->dieUsageMsg( 'databaseerror' );
			}
		} catch ( WikiFactoryVariableParseException $variableParseException ) {
			$this->dieUsage( $variableParseException->getMessage(), 'invalid_value', 400 );
		} catch ( WikiFactoryDuplicateWgServer $duplicateWgServer ) {
			$this->dieUsage( $duplicateWgServer->getMessage(), 'invalid_value', 409 );
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
			'variable_value' => [
				ApiBase::PARAM_REQUIRED => true
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
