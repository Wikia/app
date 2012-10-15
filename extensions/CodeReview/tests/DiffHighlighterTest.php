<?php

class CodeDiffHighlighterTest extends MediaWikiTestCase {

	function testParseChunksFromWindowsDiff() {
		try {
			CodeDiffHighlighter::parseChunkDelimiter(
				"@@ -1,3 +1,4 @@\r\n"
			);
		} catch( Exception $e ) {
			$this->fail( "parseChunkDelimiter() could not parse a chunk finishing with '\\r\\n' This is happening on Windows" );
		}
	}

	function testParseChunksFromUnixDiff() {
		try {
			CodeDiffHighlighter::parseChunkDelimiter(
				"@@ -1,3 +1,4 @@\n"
			);
		} catch( Exception $e ) {
			$this->fail( "parseChunkDelimiter() could not parse a chunk finishing with '\\n' This is happening on Unix systems" );
		}
	}

	/**
	 * @dataProvider provideUnifiedDiffChunksDelimiters
	 */
	function testParseChunkDelimiters( $expected, $delimiter ) {
		$this->assertEquals(
			$expected,
			CodeDiffHighlighter::parseChunkDelimiter( $delimiter )
		);
	}

	function provideUnifiedDiffChunksDelimiters() {
		return array( /* expected array, chunk delimiter */
			array(
				array( 1, 3, 1, 4),
				'@@ -1,3 +1,4 @@'
			),
			array(
				array( 76, 17, 76, 21 ),
				'@@ -76,17 +76,21 @@'
			),
			array(
				array( 1, 63, 0, 0 ),
				'@@ -1,63 +0,0 @@'
			),
		);
	}

}
