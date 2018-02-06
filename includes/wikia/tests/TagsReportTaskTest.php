<?php

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Wikia\Tasks\Tasks\TagsReportTask;

class TagsReportTaskTest extends TestCase {
	const POST_ID = 1;

	public function patterns() {
		return [
			[ "text text text <activityfeed> text", 1 ],
			[ "text text text {{#ask text text", 1 ],
			[ "text text text <badge>xyz</badge> text text", 1 ],
			[ "text text text <bloglist> text text", 1 ],
			[ "text text text <categorytree> text text", 1 ],
			[ "text text text <dpl> text text text", 1 ],
			[ "text text text <dynamicpagelist> text text text", 1 ],
			[ "text text text {{#dpl}} text text text", 1 ],
			[ "text text text <gallery test xyz> text text text", 1 ],
			[ "text text text <gallery type=\"slider\" asdasd> text text text", 2 ],
			[ "text text text <gallery type=\"slideshow\" asdasd> text text text", 2 ],
			[ "text text text <verbatim> text text text", 1 ],
			[ "text text text <videogallery> text text text", 1 ],
			[ "text text text <batik> text text text", 1 ],
			[ "text text text <go> text text text", 1 ],
			[ "text text text <greek> text text text", 1 ],
			[ "text text text <vk> text text text", 1 ],
			[ "text text text <weibo> text text text", 1 ],
			[ "text text text <youtube> text text text", 1 ],
			[ "text text text <you tube> text text text", 0 ],
			[ "text text text <youtube text=\"666\"> text text text", 1 ],
			[ "text text text <widget> text </widget> text text", 1 ],

			[ "text text text <youtube> text <youtube> text <youtube> text", 1 ],
			[ "text <badge> text <youtube> text <widget> text </widget> text text", 3 ],
		];
	}

	/**
	 * @return TagsReportTask|MockObject
	 */
	public function mockTask(): MockObject {
		return $this->getMockBuilder( TagsReportTask::class )->setMethods( [
			'addTag',
			'removeCurrentTagsForArticle',
			'getRevision',
		] )->getMock();
	}

	/**
	 * @dataProvider patterns
	 * @group aaa
	 *
	 * @param $input
	 * @param $numberOfOccurrences
	 */
	public function testFindingTags( string $input, int $numberOfOccurrences ) {
		$task = $this->mockTask();

		/** @var Revision|MockObject $revision */
		$revision = $this->createMock( Revision::class );
		$revision->method( 'getText' )->will( $this->returnValue( $input ) );
		$revision->method( 'getPage' )->will( $this->returnValue( self::POST_ID ) );

		$task->expects( $this->exactly( $numberOfOccurrences ) )->method( 'addTag' );

		$task->updateTagsForRevision( $revision );
	}
}
