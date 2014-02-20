<?php
class WikiaSanitizerTest extends WikiaBaseTest {

	/**
	 * @dataProvider unicodeTrimDataProvider()
	 */
	public function testUnicodeTrim( $input, $expectedResult, $message ) {
		$this->assertEquals(
			$expectedResult,
			WikiaSanitizer::unicodeTrim( $input ),
			$message
		);
	}

	public function unicodeTrimDataProvider() {
		return [
			[ 'test', 'test', 'nothing to trim #1' ],
			[ 'プ	ヘ	ベ	ペ	ホ	ボ	ポ', 'プ	ヘ	ベ	ペ	ホ	ボ	ポ', 'nothing to trim #2' ],
			[ 'test       ', 'test', 'regular whitespaces should be trim #1' ],
			[ '           test', 'test', 'regular whitespaces should be trimmed #2' ],
			[ '           test        ', 'test', 'regular whitespaces should be trimmed #3' ],
			[ 'test			', 'test', 'tabs should be trim #1' ],
			[ '			test', 'test', 'tabs should be trimmed #2' ],
			[ '			test			', 'test', 'tabs should be trimmed #3' ],
			[ '           プ	ヘ	ベ	ペ	ホ	ボ	ポ        ', 'プ	ヘ	ベ	ペ	ホ	ボ	ポ', 'regular whitespaces should be trimmed and only utf8 chars should be outputted' ],
			[ '     test', 'test', 'utf8 whitespaces should be trimmed #1' ],
			[ 'test     ', 'test', 'utf8 whitespaces should be trimmed #2' ],
			[ '     test     ', 'test', 'utf8 whitespaces should be trimmed #3' ],
			[ '     		      test      		  ', 'test', 'mix of tabs, regular and utf8 whitespaces should be trimmed' ],
		];
	}

}
