<?php

use Wikia\IndexingPipeline\PipelineEventProducer;

class PipelineEventProducerTest extends WikiaBaseTest  {
	/**
	 * @dataProvider canIndexProvider
	 *
	 * @param int $ns
	 * @param string $text
	 * @param bool $expected
	 */
	public function testCanIndex( $ns, $text, $expected ) {
		$title = Title::makeTitle( $ns, $text );

		$this->assertEquals( $expected, PipelineEventProducer::canIndex( $title ) );
	}

	public function canIndexProvider() {
		return [
			'main namespace article' => [ NS_MAIN, 'Foo', true ],
			'user page' => [ NS_USER, 'UserName', true ],
			'talk page' => [ NS_TALK, 'Talk', true ],
			'article comment' => [ NS_TALK, 'Article/@comment-UserName-20120416200205', false ],
			'wall message' => [ 1201, 'Wall', false ],
			'forum thread' => [ 2001, 'Forum', false ],
		];
	}
}
