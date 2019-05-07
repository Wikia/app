<?php

/**
 * @group Integration
 */
class LinkSuggestIntegrationTest extends WikiaDatabaseTest {

	const REDIRECT_PAGE = 'Thrawn';
	const REDIRECT_TARGET_ID  = 2;
	const REDIRECT_TARGET = "Mitth'raw'nuruodo";

	/** @var FauxRequest $webRequest */
	private $webRequest;

	protected function setUp() {
		parent::setUp();

		$this->webRequest = new FauxRequest();
	}

	public function testShouldResolveTargetArticleIdWhenExactMatchIsRedirect() {
		$this->webRequest->setVal( 'query', 'thrawn' );
		$this->webRequest->setVal( 'format', 'json' );

		$out = LinkSuggest::getLinkSuggest( $this->webRequest );
		$data = json_decode( $out, true );

		$this->assertEquals( self::REDIRECT_TARGET_ID, $data['ids'][self::REDIRECT_TARGET] );
	}

	public function testShouldResolveTargetArticleIdWhenSomeResultIsRedirect() {
		$this->webRequest->setVal( 'query', 'thraw' );
		$this->webRequest->setVal( 'format', 'json' );

		$out = LinkSuggest::getLinkSuggest( $this->webRequest );
		$data = json_decode( $out, true );

		$this->assertEquals( self::REDIRECT_TARGET_ID, $data['ids'][self::REDIRECT_TARGET] );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/link_suggest.yaml' );
	}
}
