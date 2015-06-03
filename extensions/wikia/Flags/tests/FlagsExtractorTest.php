<?php

class FlagsExtractorTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../Flags.setup.php';
		parent::setUp();
	}

	/**
	 * @test
	 */
	function shouldInitFields() {
		/* Params to compare */
		$mockText = 'sometext';
		$mockTemplateName = 'somename';

		/* @var Flags\FlagsExtractor $flagsExtractorMock mock of Flags\FlagsExtractor class */
		$flagsExtractorMock = $this->getMockBuilder( 'Flags\FlagsExtractor' )
			->disableOriginalConstructor()
			->setMethods( [ 'logInfoMessage' ] )
			->getMock();

		/* Run tested method */
		$flagsExtractorMock->init( $mockText, $mockTemplateName );

		$templateName = $flagsExtractorMock->getText();
		$this->assertEquals( $mockText, $templateName );
	}

	/**
	 * @test
	 */
	function shouldExtractTemplateFromContent() {
		$mockText = '{{iumb
| id = Oou
| bg = #F7F7F7
| image = [[File:Ewokdirector.jpg|130px]]
| caption = Piece of test text
| message = This is a {{{1}}} for {{{2|Łukasz}}} to test his notice script
| comment = {{{comment}}}
}}';
		$mockTemplateName = 'iumb';

		$expectedResult = [
			[
				'name' => 'iumb',
				'template' => $mockText,
				'params' => [
					'id' => 'Oou',
					'bg' => '#F7F7F7',
					'image' => '[[File:Ewokdirector.jpg|130px]]',
					'caption' => 'Piece of test text',
					'message' => 'This is a {{{1}}} for {{{2|Łukasz}}} to test his notice script',
					'comment' => '{{{comment}}}'
				]
			]
		];

		/* @var Flags\FlagsExtractor $flagsExtractorMock mock of Flags\FlagsExtractor class */
		$flagsExtractorMock = $this->getMockBuilder( 'Flags\FlagsExtractor' )
			->disableOriginalConstructor()
			->setMethods( [ 'logInfoMessage' ] )
			->getMock();

		/* Run tested method */
		$flagsExtractorMock->init( $mockText, $mockTemplateName );
		$templates = $flagsExtractorMock->getTemplate();
		$this->assertEquals( $expectedResult, $templates );
	}
}
