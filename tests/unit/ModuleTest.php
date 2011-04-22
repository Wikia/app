<?php

class ModuleTest extends PHPUnit_Framework_TestCase {

	function setUp() {
		global $wgAutoloadClasses, $wgWikiaTemplateDir, $IP;

		$wgAutoloadClasses['TestModule'] = dirname( __FILE__ ) . '/modules/TestModule.class.php';
		$wgAutoloadClasses['OasisTemplate'] = $IP . '/skins/Oasis.php';
		$wgWikiaTemplateDir['Test'] = dirname( __FILE__ ) . '/modules';
	}

	function testModuleGet() {
		/*
		$result = F::app()->renderView('Test', 'Index');
		$this->assertEquals(
			'Foo',
			$result
		);
		*/
		$this->markTestSkipped();
	}

	function testRenderModule() {
		$this->assertEquals(
			'Foo',
			wfRenderModule('Test')
		);
	}

	function testRenderPartial() {
		$this->assertEquals(
			'Foo',
			wfRenderPartial('Test', 'Index', array('foo' => 'Foo'))
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
		$data = Module::get('Test', 'Index2', array('foo2' => $random))->getData();

		$this->assertEquals(
			$random,
			$data['foo2']
		);
	}

	function testGetDataOne() {
		$random = rand();

		$this->assertEquals(
			$random,
			Module::get('Test', 'Index2', array('foo2' => $random))->getData('foo2')
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
		$this->assertNull(Module::get('ModuleThatDoesNotExist'));
	}

	function testMagicForGlobalAndSkinTemplateVariables() {

		$template = new OasisTemplate();
		$template->set('foo', 'bar');

		global $wgFoo;
		$wgFoo = 'bar';

		Module::setSkinTemplateObj($template);

		$data = Module::get('Test', 'Index3')->getData();

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
