<?php

class TvRssModelTest extends WikiaBaseTest {
	protected static function getFn( $obj, $name ) {
		$class = new ReflectionClass(get_class( $obj ));
		$method = $class->getMethod( $name );
		$method->setAccessible( true );

		return function () use ( $obj, $method ) {
			$args = func_get_args();
			return $method->invokeArgs( $obj, $args );
		};
	}

	/**
	 * @group UsingDB
	 * @covers TvRssModel::formatTitle
	 */
	public function testFormatTitle() {
		$dummy = new TvRssModel();
		$formatTitle = self::getFn( $dummy, 'formatTitle' );
		$dummyItem = [
			"source" => TvRssModel::SOURCE_TVRAGE,
			'episode_name' => "episode",
			'series_name' => "series",
			'wikia_id' => 831,
			'title' => 'bogus_title',
		];

		$this->assertEquals( $formatTitle( $dummyItem )['title'], "episode, the new episode from series" );

		$dummyItem['source'] = TvRssModel::SOURCE_GENERATOR;

		$valid_titles = [
			"More info about bogus_title from Muppet Wiki",
			"Read more about bogus_title from Muppet Wiki",
			"Recommended page: bogus_title from Muppet Wiki"
		];

		$title = $formatTitle( $dummyItem )[ 'title' ];
		$this->assertContains( $title, $valid_titles );
	}

	/**
	 * @covers TvRssModel::parseTitle
	 */
	public function testParseTitle() {
		$dummy = new TvRssModel();
		$parseTitle = self::getFn( $dummy, 'parseTitle' );

		$dummyRssTitle = "- Suits (04x01)";
		$parsed = $parseTitle( $dummyRssTitle );
		$this->assertEquals( $parsed['title'], "Suits" );
		$this->assertEquals( $parsed['series'], "04" );
		$this->assertEquals( $parsed['episode'], "01" );
	}
}
