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
		$this->markTestSkipped('Refactor this unit test');

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
		$this->assertXmlStringEqualsXmlString(
			'<a href="/wiki/Special:CreatePage" title="Special:CreatePage" class="wikia-button">Add a Page</a>',
			Wikia::specialPageLink('CreatePage', 'button-createpage', 'wikia-button')
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.02133 ms
	 */
	function testWikiaLink() {
		$titleMock = $this->createMock( Title::class );

		$titleMock->expects( $this->once() )
			->method( 'getDBkey' )
			->willReturn( 'Test' );
		$titleMock->expects( $this->any() )
			->method( 'getNamespace' )
			->willReturn( NS_MAIN );
		$titleMock->expects( $this->once() )
			->method( 'getFragment' )
			->willReturn( '' );
		$titleMock->expects( $this->once() )
			->method( 'getInterwiki' )
			->willReturn( '' );
		$titleMock->expects( $this->once() )
			->method( 'getLinkURL' )
			->with( $this->isEmpty() )
			->willReturn( '/wiki/Test' );
		$titleMock->expects( $this->exactly( 4 ) )
			->method( 'getPrefixedText' )
			->willReturn( 'Test' );
		$titleMock->expects( $this->once() )
			->method( 'isKnown' )
			->willReturn( true );
		$titleMock->expects( $this->any() )
			->method( 'isExternal' )
			->willReturn( false );


		$this->assertXmlStringEqualsXmlString(
			'<a href="/wiki/Test" title="Test">Test</a>',
			Wikia::link( $titleMock )
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

	/**
	 * @expectedException ControllerNotFoundException
	 */
	function testNotExistingController() {
		F::app()->sendRequest("DoesNotExist");
	}

}
