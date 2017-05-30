<?php

class ContentReviewImportJSTest extends WikiaBaseTest {
	public function setUp() {
		$this->setupFile = __DIR__ . '/../ContentReview.setup.php';
		parent::setUp();
	}

	/**
	 * @covers \Wikia\ContentReview\ImportJS::prepareImports()
	 * @dataProvider prepareImportsScriptDataProvider
	 *
	 * @param string[] $scripts
	 * @param string[] $expectedScripts
	 */
	public function testPrepareImportsScript( $scripts, $expectedScripts ) {
		$imports = ( new Wikia\ContentReview\ImportJS() )->prepareImports( $scripts );

		$this->assertEquals( $imports, $expectedScripts );
	}

	public function prepareImportsScriptDataProvider() {
		return [
			[
				['Script.js'],
				['Script.js']
			],
			[
				['   Script.js', ' MyScript2.js   '],
				['Script.js', 'MyScript2.js']
			],
			[
				['Script'],
				[]
			],
			[
				['dev:Script.js'],
				['external:dev:Script.js']
			],
			[
				['dev:MediaWiki:Script.js'],
				[]
			],
			[
				['devfake:Script.js'],
				[]
			],
			[
				[':Script.js'],
				[]
			],
			[
				['MediaWiki:Script.js'],
				[]
			],
			[
				['Script.js', 'MyScript2.js', 'dev:Code.js'],
				['Script.js', 'MyScript2.js', 'external:dev:Code.js']
			],
			[
				['Script.js', 'MyScript2js', 'dev:Code.js'],
				['Script.js', 'external:dev:Code.js']
			],
			[
				['Script.js', 'MyScript2.js', 'fake:Code.js'],
				['Script.js', 'MyScript2.js']
			]
		];
	}


	/**
	 * @covers \Wikia\ContentReview\ImportJS::createInlineScript()
	 * @dataProvider createInlineScriptDataProvider
	 *
	 * @param string[] $scripts
	 * @param string $expectedScript
	 */
	public function testCreateInlineScript( $scripts, $expectedScript ) {
		$script = ( new Wikia\ContentReview\ImportJS() )->createInlineScript( $scripts );

		$this->assertEquals( $script, $expectedScript );
	}

	public function createInlineScriptDataProvider() {
		return [
			[
				['Script.js'],
				'<script>(function(){importWikiaScriptPages(["Script.js"]);})();</script>'
			],
			[
				[],
				''
			],
			[
				['Scri"pt.js'],
				'<script>(function(){importWikiaScriptPages(["Scri\"pt.js"]);})();</script>'
			],
			[
				['Script"]);alert(0);//.js'],
				'<script>(function(){importWikiaScriptPages(["Script\"]);alert(0);//.js"]);})();</script>'
			],
			[
				['external:dev:Script.js'],
				'<script>(function(){importWikiaScriptPages(["external:dev:Script.js"]);})();</script>'
			],
			[
				['Script.js', 'MyScript.js', 'external:dev:Code.js'],
				'<script>(function(){importWikiaScriptPages(["Script.js", "MyScript.js", "external:dev:Code.js"]);})();</script>'
			]
		];
	}
}
