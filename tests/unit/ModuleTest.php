<?php

class ModuleTest extends WikiaBaseTest {

	function setUp() {
		global $wgAutoloadClasses, $IP;

		$wgAutoloadClasses['UnitTestModule'] = dirname( __FILE__ ) . '/modules/UnitTestModule.class.php';
		$wgAutoloadClasses['OasisTemplate'] = $IP . '/skins/Oasis.php';
	}

	function testModuleGet() {
		$result = F::app()->renderView('UnitTest', 'Index');
		$this->assertEquals(
			'Foo',
			$result
		);
	}

	function testRenderModule() {
		$this->assertEquals(
			'Foo',
			wfRenderModule('UnitTest')
		);
	}

	function testRenderPartial() {
		$this->assertEquals(
			'Foo',
			wfRenderPartial('UnitTest', 'Index', array('foo' => 'Foo'))
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
		$random = rand();
		$data = Module::get('UnitTest', 'Index2', array('foo2' => $random))->getData();

		$this->assertEquals(
			$random,
			$data['foo2']
		);
	}

	function testGetDataOne() {
		$random = rand();

		$this->assertEquals(
			$random,
			Module::get('UnitTest', 'Index2', array('foo2' => $random))->getData('foo2')
		);
	}

	function testSetGetSkinTemplate() {
		$template = new OasisTemplate();

		Module::setSkinTemplateObj($template);

		$this->assertEquals(
			$template,
			Module::getSkinTemplateObj()
		);
	}

	function testNotExistingModule() {
		$this->setExpectedException('WikiaException');
		$this->assertNull(Module::get('ModuleThatDoesNotExist'));
	}

	function testMagicForGlobalAndSkinTemplateVariables() {

		$template = new OasisTemplate();
		$template->set('foo', 'bar');

		global $wgFoo;
		$wgFoo = 'bar';

		Module::setSkinTemplateObj($template);

		$data = Module::get('UnitTest', 'Index3')->getData();

		$this->assertEquals(
			'bar',
			$data['foo']
		);

		$this->assertEquals(
			'bar',
			$data['wgFoo']
		);

	}

}
