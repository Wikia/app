<?php

class ModuleTest extends PHPUnit_Framework_TestCase {

	function setUp() {
		global $wgAutoloadClasses, $wgWikiaTemplateDir;

		$wgAutoloadClasses['TestModule'] = dirname( __FILE__ ) . '/modules/TestModule.class.php';
		$wgWikiaTemplateDir['Test'] = dirname( __FILE__ ) . '/modules';
	}

	function testModuleGet() {
		$this->assertEquals(
			'Foo',
			Module::get('Test')->render()
		);
	}

	function testRenderModule() {
		$this->assertEquals(
			'Foo',
			wfRenderModule('Test')
		);
	}

	function testViewPartial() {
		$this->assertEquals(
			'Foo',
			View::partial('Test', 'Index', array('foo' => 'Foo'))->render()
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
			View::specialPageLink('CreatePage', 'button-createpage', 'wikia-button')
		);
	}

	function testViewLink() {
		$this->assertTag (
			array("tag" => "a"),
			View::link(Title::newFromText("Test"))
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
		$template = new QuickTemplate();

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

		$template = new QuickTemplate();
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
