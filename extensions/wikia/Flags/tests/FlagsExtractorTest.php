<?php

class FlagsExtractorTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../Flags.setup.php';
		parent::setUp();
	}

	/**
	 * @test
	 */
	function shouldInitTextField() {
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
	 * @dataProvider shouldExtractTemplateFromContentDataProvider
	 */
	function shouldExtractTemplatesFromContent( $mockTemplateName, $mockText, $expectedResult ) {

		/* @var Flags\FlagsExtractor $flagsExtractorMock mock of Flags\FlagsExtractor class */
		$flagsExtractorMock = $this->getMockBuilder( 'Flags\FlagsExtractor' )
			->disableOriginalConstructor()
			->setMethods( [ 'logInfoMessage' ] )
			->getMock();

		/* Run tested method */
		$flagsExtractorMock->init( $mockText, $mockTemplateName );
		$templates = $flagsExtractorMock->getAllTemplates();
		$this->assertEquals( $expectedResult, $templates );
	}


	/**
	 * DataProviders
	 */

	function shouldExtractTemplateFromContentDataProvider() {
		$mockTemplate1 = '{{iumb
| id = Oou
| bg = #F7F7F7
| image = [[File:Ewokdirector.jpg|130px]]
| caption = Piece of test text
| message = This is a {{{1}}} for {{{2|Łukasz}}} to test his notice script
| comment = {{{comment}}}
}}';
		$mockTemplate2 = '{{iumb
| id = Oou
| bg = #F7F7F7
| image = [[File:Ewokdirector.jpg|130px]]
| caption = Piece of test text
}}';

		$mockTextTemplateAtTheBeginning = $mockTemplate1;
		$mockTextTwoTemplatesOneByOne = $mockTemplate1 . $mockTemplate2;
		$mockTextTwoTemplatesAndText = "Some text \n" . $mockTemplate1 . "Some text \n" . $mockTemplate2 . "\nSome text \n";

		$mockTemplateName = 'iumb';

		$expectedResultOneTemplate = [
			[
				'name' => 'iumb',
				'template' => $mockTemplate1,
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

		$expectedResultTwoTemplates = [
			[
				'name' => 'iumb',
				'template' => $mockTemplate1,
				'params' => [
					'id' => 'Oou',
					'bg' => '#F7F7F7',
					'image' => '[[File:Ewokdirector.jpg|130px]]',
					'caption' => 'Piece of test text',
					'message' => 'This is a {{{1}}} for {{{2|Łukasz}}} to test his notice script',
					'comment' => '{{{comment}}}'
				]
			],
			[
				'name' => 'iumb',
				'template' => $mockTemplate2,
				'params' => [
					'id' => 'Oou',
					'bg' => '#F7F7F7',
					'image' => '[[File:Ewokdirector.jpg|130px]]',
					'caption' => 'Piece of test text'
				]
			]
		];

		return [
			[ $mockTemplateName, $mockTextTemplateAtTheBeginning, $expectedResultOneTemplate ],
			[ $mockTemplateName, $mockTextTwoTemplatesOneByOne, $expectedResultTwoTemplates ],
			[ $mockTemplateName, $mockTextTwoTemplatesAndText, $expectedResultTwoTemplates ]
		];
	}
}
