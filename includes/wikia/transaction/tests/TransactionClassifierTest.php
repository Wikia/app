<?php

/**
 * Unit tests for TransactionClassifier
 *
 * @author macbre
 * @group TransactionClassifier
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
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_PAGE,
					Transaction::PARAM_NAMESPACE => NS_MAIN,
					Transaction::PARAM_ACTION => TransactionClassifier::ACTION_VIEW,
					Transaction::PARAM_SKIN => 'foo-skin',
					Transaction::PARAM_PARSER_CACHE_USED => true,
					Transaction::PARAM_SEMANTIC_MEDIAWIKI => true
				],
				'expectedName' => 'page/main/view/foo-skin/no_parser/semantic_mediawiki'
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
				'expectedName' => 'api/nirvana/Places'
			],
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_NIRVANA,
					Transaction::PARAM_CONTROLLER => 'ImageServing',
					Transaction::PARAM_METHOD => 'getImages',
				],
				'expectedName' => 'api/nirvana/ImageServing'
			],
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_PAGE,
					Transaction::PARAM_NAMESPACE => NS_MAIN,
					Transaction::PARAM_ACTION => 'diff',
					Transaction::PARAM_SKIN => 'foo-skin',
				],
				'expectedName' => 'page/main/diff'
			],
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_MAINTENANCE,
				],
				'expectedName' => 'maintenance'
			],
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_MAINTENANCE,
					Transaction::PARAM_MAINTENANCE_SCRIPT => 'EventsCleanup',
				],
				'expectedName' => 'maintenance/EventsCleanup'
			],
			# Wall / Forum
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_PAGE,
					Transaction::PARAM_NAMESPACE => TransactionClassifier::NS_USER_WALL,
				],
				'expectedName' => 'page/message_wall'
			],
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_PAGE,
					Transaction::PARAM_NAMESPACE => TransactionClassifier::NS_WIKIA_FORUM_BOARD,
				],
				'expectedName' => 'page/forum'
			],
			# User pages
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_PAGE,
					Transaction::PARAM_NAMESPACE => NS_USER,
				],
				'expectedName' => 'page/user'
			],
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_PAGE,
					Transaction::PARAM_NAMESPACE => NS_USER_TALK,
				],
				'expectedName' => 'page/user_talk'
			],
			# MW API
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_API,
					Transaction::PARAM_API_ACTION => 'query',
				],
				'expectedName' => 'api/api/query'
			],
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_API,
					Transaction::PARAM_API_ACTION => 'query',
					Transaction::PARAM_API_LIST => 'users',
				],
				'expectedName' => 'api/api/query/users'
			],
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_API,
					Transaction::PARAM_API_ACTION => 'visualeditoredit',
				],
				'expectedName' => 'api/api/visualeditoredit'
			],
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_API,
					Transaction::PARAM_API_ACTION => 'foo',
				],
				'expectedName' => 'api/api/other'
			],
			# blogs
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_PAGE,
					Transaction::PARAM_NAMESPACE => TransactionClassifier::NS_BLOG_ARTICLE,
				],
				'expectedName' => 'page/blog'
			],
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_PAGE,
					Transaction::PARAM_NAMESPACE => TransactionClassifier::NS_BLOG_LISTING,
				],
				'expectedName' => 'page/blog'
			],
			# SemanticMediaWiki
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_PAGE,
					Transaction::PARAM_NAMESPACE => TransactionClassifier::SMW_NS_CONCEPT,
				],
				'expectedName' => 'page/semantic_mediawiki'
			],
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_PAGE,
					Transaction::PARAM_NAMESPACE => TransactionClassifier::SMW_NS_PROPERTY,
				],
				'expectedName' => 'page/semantic_mediawiki'
			],
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_PAGE,
					Transaction::PARAM_NAMESPACE => TransactionClassifier::SMW_NS_TYPE,
				],
				'expectedName' => 'page/semantic_mediawiki'
			],
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_PAGE,
					Transaction::PARAM_NAMESPACE => TransactionClassifier::SF_NS_FORM,
				],
				'expectedName' => 'page/semantic_form'
			],
			# special pages
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_SPECIAL_PAGE,
					Transaction::PARAM_SPECIAL_PAGE_NAME => 'Contributions',
				],
				'expectedName' => 'special_page/Contributions'
			],
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_SPECIAL_PAGE,
					Transaction::PARAM_SPECIAL_PAGE_NAME => 'Browse',
				],
				'expectedName' => 'special_page/Browse'
			],
			[
				'attributes' => [
					Transaction::PARAM_ENTRY_POINT => Transaction::ENTRY_POINT_SPECIAL_PAGE,
					Transaction::PARAM_SPECIAL_PAGE_NAME => 'foo',
				],
				'expectedName' => 'special_page/other'
			],
		];
	}
}
