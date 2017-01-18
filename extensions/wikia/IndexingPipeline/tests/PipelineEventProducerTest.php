<?php

use Wikia\IndexingPipeline\PipelineEventProducer;

class PipelineEventProducerTest extends WikiaBaseTest  {
	/**
	 * @param int $ns
	 * @param text $text
	 * @param bool $expected
	 * @dataProvider canIndexProvider
	 */
	public function testCanIndex( $ns, $text, $expected ) {
		$title = $this->mockClassWithMethods( 'Title', [
			'getNamespace' => $ns,
			'getText' => $text
		] );
		$this->assertEquals( $expected, PipelineEventProducer::canIndex( $title ) );
	}

	public function canIndexProvider() {
		return [
			// main namespace article
			[ NS_MAIN, 'Foo', true ],
			// user pages
			[ NS_USER, 'UserName', true ],
			// talk pages
			[ NS_TALK, 'Talk', true ],
			// article comments
			[ NS_TALK, 'Article/@comment-UserName-20120416200205', false ],
			// Wall
			[ 1201, 'Wall', false ],
			// Forum
			[ 2001, 'Forum', false ],
		];
	}
}
