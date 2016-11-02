<?php

/**
 * Tests for Special:Diff page, which was backported from newer core MediaWiki
 * For expected behavior:
 * @see https://www.mediawiki.org/wiki/Help:Diff
 * @covers SpecialDiff
 */
class SpecialDiffTest extends WikiaBaseTest {
	/**
	 * @dataProvider specialDiffDataProvider
	 * @param string $param Parameter passed to Special:Diff via title
	 * @param string $redirectURL URL Special:Diff should redirect to based on the given parameters
	 */
	public function testSpecialDiff( $param, $redirectURL ) {
		$this->mockGlobalVariable( 'wgScript', '/index.php' );
		$context = new RequestContext();
		$title = SpecialPage::getTitleFor( 'Diff/' . $param );
		$res = SpecialPageFactory::executePath( $title, $context );

		$this->assertTrue( $res );

		$redirectedTo = $context->getOutput()->getRedirect();
		$this->assertEquals( $redirectURL, $redirectedTo );
	}

	public function testSpecialDiffInvalidInput() {
		$context = new RequestContext();
		$title = SpecialPage::getTitleFor( 'Diff' );

		$this->setExpectedException( ErrorPageError::class );
		SpecialPageFactory::executePath( $title, $context );
	}

	/**
	 * @return array An array of title parameters and the redirect URL they should generate
	 */
	public function specialDiffDataProvider() {
		return [
			[ '12345', '/index.php?diff=12345' ],
			[ '12345/prev', '/index.php?oldid=12345&diff=prev' ],
			[ '12345/next', '/index.php?oldid=12345&diff=next' ],
			[ '12345/cur', '/index.php?oldid=12345&diff=cur' ],
			[ '12345/98765', '/index.php?oldid=12345&diff=98765' ],
		];
	}
}
