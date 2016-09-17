<?php

namespace Wikia\Search\Test;

use ReflectionMethod;

class FandomSearchTest extends BaseTest {
	const CLASS_NAME = 'Wikia\Search\FandomSearch';

	public function testBuildUrl() {
		$method = new ReflectionMethod( static::CLASS_NAME, 'buildUrl' );
		$method->setAccessible( true );

		$this->assertEquals(
			'http://fandom.wikia.com/wp-json/wp/v2/posts?search=test&per_page=5&_embed=1',
			$method->invoke( null, 'test' )
		);
	}
}
