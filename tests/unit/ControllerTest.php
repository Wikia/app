<?php

class ControllerTest extends WikiaBaseTest {

	function setUp() {
		global $wgAutoloadClasses, $IP;

		$wgAutoloadClasses['UnitTestController'] = dirname( __FILE__ ) . '/modules/UnitTestController.class.php';
		$wgAutoloadClasses['OasisTemplate'] = $IP . '/skins/Oasis.php';
	}

	function testRenderView() {
		$result = F::app()->renderView('UnitTest', 'Index');
		$this->assertEquals(
			'Foo',
			$result
		);
	}

	function testViewSpecialPageLink() {
		$this->assertTag (
			array("tag" => "a"),
			Wikia::specialPageLink('CreatePage', 'button-createpage', 'wikia-button')
		);
	}

	function testViewLink() {
		$this->assertTag (
			array("tag" => "a"),
			Wikia::link(Title::newFromText("Test"))
		);
	}

	function testGetDataAll() {
		$this->markTestSkipped();
		$random = rand();
		$data = Module::get('UnitTest', 'Index2', array('foo2' => $random))->getData();

		$this->assertEquals(
			$random,
			$data['foo2']
		);
	}

	function testGetDataOne() {
		$this->markTestSkipped();
		$random = rand();

		$this->assertEquals(
			$random,
			Module::get('UnitTest', 'Index2', array('foo2' => $random))->getData('foo2')
		);
	}

	function testSetGetSkinTemplate() {
		$template = new OasisTemplate();

		WikiaApp::setSkinTemplateObj($template);

		$this->assertEquals(
			$template,
			WikiaApp::getSkinTemplateObj()
		);
	}

	function testNotExistingModule() {
		$this->setExpectedException('WikiaException');
		$this->assertNull(Module::get('ModuleThatDoesNotExist'));
	}

}
