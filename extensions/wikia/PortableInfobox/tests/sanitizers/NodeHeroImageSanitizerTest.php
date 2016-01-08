<?php

class NodeHeroImageSanitizerTest extends WikiaBaseTest {
	private $sanitizer;

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../../PortableInfobox.setup.php';

		$this->sanitizer = SanitizerBuilder::createFromType('hero-mobile');
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
				['title' => ['value' => 'Test Title'] ],
				['title' => ['value' => 'Test Title'] ]
			],
			[
				['title' => ['value' => 'Real world <a href="http://vignette-poz.wikia-dev.com/mediawiki116/images/b/b6/DBGT_Logo.svg/revision/latest?cb=20150601155347" 	class="image image-thumbnail" 	 	 	><img src="http://vignette-poz.wikia-dev.com/mediawiki116/images/b/b6/DBGT_Logo.svg/revision/latest/scale-to-width-down/30?cb=20150601155347" 	 alt="DBGT Logo"  	class="" 	 	data-image-key="DBGT_Logo.svg" 	data-image-name="DBGT Logo.svg" 	 	 width="30"  	 height="18"  	 	 	 	></a>title example'] ] ,
				['title' => ['value' => 'Real world title example'] ]
			],
		];
	}
}
