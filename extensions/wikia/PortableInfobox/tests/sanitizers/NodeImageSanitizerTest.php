<?php

class NodeImageSanitizerTest extends WikiaBaseTest {
	private $sanitizer;

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../../PortableInfobox.setup.php';

		$this->sanitizer = SanitizerBuilder::createFromType('image');
		parent::setUp();
	}

	/**
	 * @param $data
	 * @param $expected
	 * @dataProvider testSanitizeDataProvider
	 */
	function testSanitize( $data, $expected ) {
		$this->assertEquals(
			$expected,
			$this->sanitizer->sanitize( $data )
		);
	}

	function testSanitizeDataProvider() {
		return [
			[
				[ 'caption' => 'Test <a>Title with</a> <span><small>small</small></span> tag, span tag and <img src="sfefes"/>tag' ],
				[ 'caption' => 'Test <a>Title with</a> small tag, span tag and tag' ]
			],
			[
				[ 'caption' => '<a href="http://vignette-poz.wikia-dev.com//images/9/95/All_Stats_%2B2.png/revision/latest?cb=20151222111955" 	class="image image-thumbnail"><img src="abc" alt="All Stats +2" class="thumbimage" /></a>' ],
				[ 'caption' => '' ],
			]
		];
	}
}
