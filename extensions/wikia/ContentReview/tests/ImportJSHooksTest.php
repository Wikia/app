<?php

class ImportJSHooksTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../ImportJS.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider addingImportJSScriptsProvider
	 */
	public function testAddingImportJSScripts( $jsEnabled, $userJsAllowed, $importScripts, $bottomScriptsResult ) {
		$outputMock = $this->getMockBuilder( 'Output' )
			->setMethods( [ 'isUserJsAllowed' ] )
			->getMock();
		$outputMock->expects( $this->any() )
			->method( 'isUserJsAllowed' )
			->will( $this->returnValue( $userJsAllowed ) );

		$requestMock = $this->getMock( 'WebRequest', [ 'getBool' ] );
		$requestMock->expects( $this->any() )
			->method( 'getBool' )
			->will( $this->returnValue( $jsEnabled ) );

		$skinMock = $this->getMockBuilder( '\Skin' )
			->disableOriginalConstructor()
			->getMock();
		$skinMock->expects( $this->any() )
			->method( 'getOutput' )
			->will( $this->returnValue( $outputMock ) );
		$skinMock->expects( $this->any() )
			->method( 'getRequest' )
			->will( $this->returnValue( $requestMock ) );


		$importJSMock = $this->getMockBuilder( 'Wikia\ContentReview\ImportJS' )
			->setMethods( [ 'getImportScripts' ] )
			->getMock();
		$importJSMock->expects( $this->any() )
			->method( 'getImportScripts' )
			->will( $this->returnValue( $importScripts ) );

		$this->mockClass( 'Wikia\ContentReview\ImportJS', $importJSMock );

		$bottomScripts = '';

		( new Wikia\ContentReview\ImportJSHooks() )->onSkinAfterBottomScripts( $skinMock, $bottomScripts );

		$this->assertEquals( $bottomScripts, $bottomScriptsResult );
	}

	public function addingImportJSScriptsProvider() {
		return [
			[
				true,
				true,
				'<script>(function(){importWikiaScriptPages(["Script.js"]);})();</script>',
				'<script>(function(){importWikiaScriptPages(["Script.js"]);})();</script>',
			],
			[
				true,
				false,
				'<script>(function(){importWikiaScriptPages(["Script.js"]);})();</script>',
				''
			],
			[
				false,
				true,
				'<script>(function(){importWikiaScriptPages(["Script.js"]);})();</script>',
				'',
			],
			[
				false,
				false,
				'<script>(function(){importWikiaScriptPages(["Script.js"]);})();</script>',
				'',
			],
		];
	}
}
