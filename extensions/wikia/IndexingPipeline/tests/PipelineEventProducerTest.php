<?php

/**
 * @covers \Wikia\IndexingPipeline\PipelineEventProducer
 */
class PipelineEventProducerTest extends WikiaBaseTest  {
	/**
	 * @dataProvider canIndexProvider
	 *
	 * @param int $ns
	 * @param string $text
	 * @param bool $expected
	 */
	public function testCanIndex( $ns, $text, $expected ) {
		/** @var PHPUnit_Framework_MockObject_MockObject|Title $title */
		$title = $this->getMockWithMethods( Title::class, [
			'getNamespace' => $ns,
			'getText' => $text
		] );

		$this->assertEquals( $expected, Wikia\IndexingPipeline\PipelineEventProducer::canIndex(
			$title ) );
	}

	public function canIndexProvider() {
		return [
			'main namespace article' => [ NS_MAIN, 'Foo', true ],
			'user pages' => [ NS_USER, 'UserName', true ],
			'talk pages' => [ NS_TALK, 'Talk', true ],
			'article comments' => [ NS_TALK, 'Article/@comment-UserName-20120416200205', false ],
			'Wall' => [ 1201, 'Wall', false ],
			'Forum' => [ 2001, 'Forum', false ],
		];
	}
}
