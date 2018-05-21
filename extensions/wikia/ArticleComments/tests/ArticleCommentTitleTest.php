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

		yield [
			'Macbre/@comment-123-20170301152835/@comment-Foo-Dash-123-20170302153001',
			'Macbre/@comment-123-20170301152835/@comment-123456-20170302153001',
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

		// too long title
		yield [
			'FooBar/Thiś_is_ąn_important_announcement._SO_important,_in_fact,_that_if_you_don\'t_read_it_your_brain_will_explode_out_your_ears,_and_that_will_be_the_end_of_you_forever._Until_I_work_out_how_to_sustain_brains_in_glass_jars./@comment-FooBar-20111217083734',
			'FooBar/Thiś_is_ąn_important_announcement._SO_important,_in_fact,_that_if_you_don\'t_read_it_your_brain_will_explode_out_your_ears,_and_that_will_be_the_end_of_you_forever._Until_I_work_out_how_to_sustain_brains_in_glass_jars./@comment-1234567890-20111217',
		];
	}

	/**
	 * @dataProvider provideNormalize
	 *
	 * @param string $oldTitleText
	 * @param string $expected
	 */
	public function testNormalize(string $oldTitleText, string $expected) {
		$normalizedTitle = ArticleCommentsTitle::normalize( $oldTitleText );

		$this->assertLessThanOrEqual( 255, strlen( $normalizedTitle ), 'New page_title should fit the DB column' );
		$this->assertEquals( $expected, $normalizedTitle );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/article_comment_title.yaml' );
	}
}
