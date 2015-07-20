<?php

class NodeTitleTest extends WikiaBaseTest {
	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../../PortableInfobox.setup.php';
		parent::setUp();
	}

	/**
	 * @covers       NodeTitle::sanitizeInfoboxTitle
	 * @dataProvider sourceProvider
	 *
	 * @param $source string
	 * @param $expected string
	 */
	public function testSanitizeInfoboxTitle( $source, $expected ) {
		$markup = '<title></title>';
		$node = \Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $markup, [ ] );

		$this->assertEquals( $expected, $node->sanitizeInfoboxTitle( $source ) );
	}

	public function sourceProvider() {
		return [
			[ 'Test Title' , 'Test Title'],
			[ '  Test Title    ' , 'Test Title'],
			[ 'Test Title <img src=\'data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D\' class=\'article-media\' data-ref=\'1\' width=\'400\' height=\'100\' /> ' , 'Test Title'],
			[ 'Test Title <a href="example.com">with link</a>' , 'Test Title with link'],
			[ 'Real world <a href="http://vignette-poz.wikia-dev.com/mediawiki116/images/b/b6/DBGT_Logo.svg/revision/latest?cb=20150601155347" 	class="image image-thumbnail" 	 	 	><img src="http://vignette-poz.wikia-dev.com/mediawiki116/images/b/b6/DBGT_Logo.svg/revision/latest/scale-to-width-down/30?cb=20150601155347" 	 alt="DBGT Logo"  	class="" 	 	data-image-key="DBGT_Logo.svg" 	data-image-name="DBGT Logo.svg" 	 	 width="30"  	 height="18"  	 	 	 	></a>title example' , 'Real world title example']
		];
	}
}
