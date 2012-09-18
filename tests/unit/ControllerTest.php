<?php

class ControllerTest extends WikiaBaseTest {

	function setUp() {
		global $wgAutoloadClasses, $IP;

		$wgAutoloadClasses['UnitTestController'] = dirname( __FILE__ ) . '/controllers/UnitTestController.class.php';
		$wgAutoloadClasses['UnitTestService'] = dirname( __FILE__ ) . '/controllers/UnitTestService.class.php';
		$wgAutoloadClasses['OasisTemplate'] = $IP . '/skins/Oasis.php';
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
		$this->assertEquals(
			'Foo',
			$result
		);
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

		WikiaApp::setSkinTemplateObj($template);

		$this->assertEquals(
			$template,
			WikiaApp::getSkinTemplateObj()
		);
	}

	function testNotExistingController() {
		$this->setExpectedException('WikiaException');
		F::app()->sendRequest("DoesNotExist");
	}

}
