<?php

/**
 * @group Integration
 */
class LinkSuggestIntegrationTest extends WikiaDatabaseTest {

	const REDIRECT_TARGET_ID  = 2;
	const REDIRECT_TARGET = "Mitth'raw'nuruodo";

	const CROSS_NAMESPACE_REDIRECT_TARGET = 'Project page namespaced';

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

	public function testShouldResolveExactMatchCrossNamespaceRedirectCorrectly() {
		global $wgContLang;

		$this->webRequest->setVal( 'query', 'project page' );
		$this->webRequest->setVal( 'format', 'json' );

		$out = LinkSuggest::getLinkSuggest( $this->webRequest );
		$data = json_decode( $out, true );

		$expected = $wgContLang->getNsText( NS_PROJECT ) . ':' . self::CROSS_NAMESPACE_REDIRECT_TARGET;

		$this->assertArrayHasKey( $expected, $data['ids'] );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/link_suggest.yaml' );
	}
}
