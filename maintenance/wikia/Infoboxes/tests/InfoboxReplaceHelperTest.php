<?php

class ImageFilenameSanitizerTest extends WikiaBaseTest {
	private $infoboxReplaceHelper;

	protected function setUp() {
		parent::setUp();
		require_once ( __DIR__ . '/../InfoboxReplaceHelper.class.php');

		$this->infoboxReplaceHelper= new InfoboxReplaceHelper();
	}

	/**
	 * @param $inputContent
	 * @param $expectedOutput
	 * @dataProvider contentDataProvider
	 */
	public function testProcessLayoutAttribute( $inputContent, $expectedOutput ) {
		$actualOutput = $this->infoboxReplaceHelper->processLayoutAttribute( $inputContent );
		$this->assertEquals( $expectedOutput, $actualOutput );
	}

	public function contentDataProvider() {
		return [
			['',''],
			['<infobox></infobox>','<infobox layout="stacked"></infobox>']
		];
	}
}
