<?php

class MediaWikiParserTest extends WikiaBaseTest {

	public function testAsideTagPWrappedDuringParsing() {
		$aside = "<aside></aside>";
		$result = ( new Parser() )->doBlockLevels( $aside, true );
		//parser adds new line at the end of block
		$this->assertEquals( $aside . "\n", $result );
	}
}