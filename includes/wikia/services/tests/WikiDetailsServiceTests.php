<?php
/**
 * Created by adam
 * Date: 12.02.14
 */

class WikiDetailsServiceTests extends WikiaBaseTest {

	public function testGetSnippet() {
		$wikiDetailService = new WikiDetailsService();
		$method = new ReflectionMethod('WikiDetailsService', 'getSnippet' );
		$method->setAccessible( true );

		$text = 'Do you see any Teletubbies in here? Do you see a slender plastic tag clipped to my shirt with my
		name printed on it? Do you see a little Asian child with a blank expression on his face sitting outside on
		a mechanical helicopter that shakes when you put quarters in it? No? Well, that\'s what you see at a toy store.
		And you must think you\'re in a toy store, because you\'re here shopping for an infant named Jeb.';

		$res = $method->invoke( $wikiDetailService, $text, null );
		$this->assertEquals( $text, $res );
		$res = $method->invoke( $wikiDetailService, $text, 3 );
		$this->assertEquals( 'Do you see', $res );
		$res = $method->invoke( $wikiDetailService, $text, 0 );
		$this->assertEquals( '', $res );
		$res = $method->invoke( $wikiDetailService, $text, 1000 );
		$this->assertEquals( $text, $res );
		$res = $method->invoke( $wikiDetailService, $text, -1 );
		$this->assertEquals( '', $res );
	}

}