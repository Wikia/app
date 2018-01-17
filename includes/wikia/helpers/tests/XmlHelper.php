<?php
use PHPUnit\Framework\TestCase;

class XmlHelperTest extends TestCase {

	protected function setUp() {
		require_once __DIR__ . '/../XmlHelper.class.php';
		parent::setUp();
	}

	/**
	 * @dataProvider renameNodeProvider
	 */
	public function testRenameNode( $html, $id, $expected, $message ) {
		$document = HtmlHelper::createDOMDocumentFromText( $html );
		HtmlHelper::renameNode( $document->getElementById( $id ), 'span' );

		$this->assertEquals( $expected, HtmlHelper::getBodyHtml( $document ), $message );
	}

	public function renameNodeProvider() {
		return [
			[
				'html' => '<p id="rename"><a href="http://example.com"></a></p>',
				'id' => 'rename',
				'expected' => '<span id="rename"><a href="http://example.com"></a></span>',
				'message' => 'top level is not renamed'
			],
			[
				'html' => '<div><h2 id="rename"><a href="http://example.com"></a></h2></p>',
				'id' => 'rename',
				'expected' => '<div><span id="rename"><a href="http://example.com"></a></span></div>',
				'message' => 'nested node is not renamed'
			],
			[
				'html' => '<div id="rename">dsfds<i>dfsfd</i></div>',
				'id' => 'rename',
				'expected' => '<span id="rename">dsfds<i>dfsfd</i></span>',
				'message' => 'nested node is not renamed'
			],
		];
	}
}
