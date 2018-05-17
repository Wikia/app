<?php

/**
 * @group Integration
 */
class ArticleCommentTitleTest extends WikiaDatabaseTest {

	public function provideNormalize() {
		yield [
			'Macbre/@comment-Macbre-20170301152835/@comment-Kirkburn-20170302153001',
			'Macbre/@comment-119245-20170301152835/@comment-126761-20170302153001',
		];

		yield [
			'Macbre/@comment-123-20170301152835/@comment-Kirkburn-20170302153001',
			'Macbre/@comment-123-20170301152835/@comment-126761-20170302153001',
		];

		// IP address
		yield [
			'Macbre/@comment-1.2.3.4-20170301152835/@comment-2001:978:3500:BEEF:0:0:0:1008-20170302153001',
			'Macbre/@comment-1.2.3.4-20170301152835/@comment-2001:978:3500:BEEF:0:0:0:1008-20170302153001',
		];

		yield [
			'Macbre/@comment-1.2.3.4-20170301152835/@comment-Kirkburn-20170302153001',
			'Macbre/@comment-1.2.3.4-20170301152835/@comment-126761-20170302153001',
		];

		// already migrated
		yield [
			'Macbre/@comment-123-20170301152835/@comment-456-20170302153001',
			'Macbre/@comment-123-20170301152835/@comment-456-20170302153001',
		];

		yield [
			'Macbre/@comment-119245-20170301152835/@comment-126761-20170302153001',
			'Macbre/@comment-119245-20170301152835/@comment-126761-20170302153001',
		];

		// not an article comment / wall / forum
		yield [
			'Macbre/Macbre-20170302153001',
			'Macbre/Macbre-20170302153001',
		];
	}

	/**
	 * @dataProvider provideNormalize
	 *
	 * @param string $oldTitleText
	 * @param string $expected
	 */
	public function testNormalize(string $oldTitleText, string $expected) {
		$this->assertEquals(
			$expected,
			ArticleCommentsTitle::normalize($oldTitleText)
		);
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/article_comment_title.yaml' );
	}
}
