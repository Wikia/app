<?php

/**
 * Unit tests for TransactionClassifier
 *
 * @author macbre
 */
class TransactionClassifierTest extends WikiaBaseTest {

	/**
	 * @dataProvider buildDataProvider
	 */
	public function testBuild( Array $attributes, $expectedName ) {
		$classifier = new TransactionClassifier();

		foreach($attributes as $key => $value) {
			$classifier->update($key, $value);
		}

		$this->assertEquals($expectedName, $classifier->getName(), 'The transaction name should match');
	}

	// TODO: Władek to update the test cases (2014-09-18)
	public function buildDataProvider() {
		return [
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_PAGE,
					Transaction::PARAM_NAMESPACE => NS_MAIN,
					Transaction::PARAM_ACTION => TransactionClassifier::ACTION_VIEW,
					Transaction::PARAM_SKIN => 'foo-skin',
					Transaction::PARAM_PARSER_CACHE_USED => false,
					Transaction::PARAM_SIZE_CATEGORY => 'big-page'
				],
				'expectedName' => 'page/main/view/foo-skin/parser/big-page'
			],
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_PAGE,
					Transaction::PARAM_NAMESPACE => NS_MAIN,
					Transaction::PARAM_ACTION => TransactionClassifier::ACTION_VIEW,
					Transaction::PARAM_SKIN => 'foo-skin',
					Transaction::PARAM_PARSER_CACHE_USED => false,
					Transaction::PARAM_SIZE_CATEGORY => 'small-page'
				],
				'expectedName' => 'page/main/view/foo-skin/parser/small-page'
			],
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_PAGE,
					Transaction::PARAM_NAMESPACE => NS_MAIN,
					Transaction::PARAM_ACTION => TransactionClassifier::ACTION_VIEW,
					Transaction::PARAM_SKIN => 'foo-skin',
					Transaction::PARAM_PARSER_CACHE_USED => true,
					Transaction::PARAM_PARSER_CACHE_DISABLED => true,
					Transaction::PARAM_SIZE_CATEGORY => 'medium-page'
				],
				'expectedName' => 'page/main/view/foo-skin/parser_cache_disabled/medium-page'
			],
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_PAGE,
					Transaction::PARAM_NAMESPACE => NS_MAIN,
					Transaction::PARAM_ACTION => TransactionClassifier::ACTION_VIEW,
					Transaction::PARAM_SKIN => 'foo-skin',
					Transaction::PARAM_PARSER_CACHE_USED => true,
					Transaction::PARAM_PARSER_CACHE_DISABLED => false,
					Transaction::PARAM_SIZE_CATEGORY => 'medium-page'
				],
				'expectedName' => 'page/main/view/foo-skin/no_parser/medium-page'
			],
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_PAGE,
					Transaction::PARAM_NAMESPACE => NS_MAIN,
					Transaction::PARAM_ACTION => TransactionClassifier::ACTION_VIEW,
					Transaction::PARAM_SKIN => 'foo-skin',
					Transaction::PARAM_PARSER_CACHE_DISABLED => true,
					Transaction::PARAM_DPL => true
				],
				'expectedName' => 'page/main/view/foo-skin/parser_cache_disabled/dpl'
			],
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_NIRVANA,
					Transaction::PARAM_CONTROLLER => 'SearchSuggestionsApi',
				],
				'expectedName' => 'api/nirvana/SearchSuggestionsApi'
			],
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_NIRVANA,
					Transaction::PARAM_CONTROLLER => 'Places',
				],
				'expectedName' => 'api/nirvana/other'
			],
		];
	}
}
