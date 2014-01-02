<?php

class ControllerTest extends WikiaBaseTest {

	function setUp() {
		global $wgAutoloadClasses, $IP;

		$wgAutoloadClasses['UnitTestController'] = dirname( __FILE__ ) . '/controllers/UnitTestController.class.php';
		$wgAutoloadClasses['UnitTestService'] = dirname( __FILE__ ) . '/controllers/UnitTestService.class.php';
		$wgAutoloadClasses['OasisTemplate'] = $IP . '/skins/Oasis.php';

		parent::setUp();
	}

	function testDispatchingToController() {
		$response = F::app()->sendRequest('UnitTest');
		$this->assertEquals('Foo', $response->getVal('foo'));
	}

	function testDispatchingToService() {
		$response = F::app()->sendRequest('UnitTestService');
		$this->assertEquals('Yes', $response->getVal('service'));
	}

	function testRenderView() {
		$result = F::app()->renderView('UnitTest', 'Index');
		$this->assertEquals('Foo', $result);

		// This is a weird edge case for legacy behavior regarding naming clashes in templates
		// Since the service class does not have a template  it falls back on the template with a matching BaseName (in this case "UnitTest_index.php")
		// Since the service::index method does not set the proper template variable, we get a warning notice
		error_reporting(E_NOTICE);
		$result = F::app()->renderView('UnitTestService', 'Index');
		$this->assertContains("Undefined variable: foo", $result);
	}

	function testWikiaSpecialPageLink() {
		$this->assertTag (
			array("tag" => "a"),
			Wikia::specialPageLink('CreatePage', 'button-createpage', 'wikia-button')
		);
	}

	function testWikiaLink() {
		$this->assertTag (
			array("tag" => "a"),
			Wikia::link(Title::newFromText("Test"))
		);
	}

	function testDispatchingWithParams() {
		$random = rand();

		$response = F::app()->sendRequest('UnitTest', 'failureWithParams', array('foo2' => $random));
		$data = $response->getData();
		$this->assertNull( $data['foo2']);

		$response = F::app()->sendRequest('UnitTest', 'successWithParams', array('foo2' => $random));
		$data = $response->getData();
		$this->assertEquals(
			$random,
			$data['foo2']
			);

		$response = F::app()->sendRequest('UnitTest', 'legacyFunctionWithParams', array('foo2' => $random));
		$data = $response->getData();
		$this->assertEquals(
			$random,
			$data['foo2']
			);
	}

	function testSetGetSkinTemplate() {
		$template = new OasisTemplate();

		F::app()->setSkinTemplateObj($template);

		$this->assertEquals(
			$template,
			F::app()->getSkinTemplateObj()
		);
	}

	function testNotExistingController() {
		$this->setExpectedException('ControllerNotFoundException');
		F::app()->sendRequest("DoesNotExist");
	}

}
