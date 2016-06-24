<?php

class WikiTopicTest extends WikiaBaseTest {
	/**
	 * @dataProvider FormingWikiTopicProvider
	 */
	public function testFormingWikiTopic( $sitename, $expectedWikiTopic ) {
		$this->assertEquals( $expectedWikiTopic, WikiTopic::prepareWikiTopic( $sitename ) );
	}

	public function FormingWikiTopicProvider() {
		return [
			[ 'Muppet', 'Muppet' ],
			[ 'Muppet Wiki', 'Muppet' ],
			[ 'Muppet wiki', 'Muppet' ],
			[ 'MediaWiki', 'Media' ],
			[ 'Mediawiki', 'Media' ],
			[ 'WikiZilla', 'WikiZilla' ],
			[ 'Greatest wiki ever', 'Greatest wiki ever' ]
		];
	}
}
