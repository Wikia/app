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
			->setMethods( [ 'info' ] )
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
	 * @test
	 * @dataProvider shouldFindFirstTemplateFromListDataProvider
	 */
	function shouldFindFirstTemplateFromList( $mockTemplatesNames, $mockText, $expectedResult ) {

		/* @var Flags\FlagsExtractor $flagsExtractorMock mock of Flags\FlagsExtractor class */
		$flagsExtractorMock = $this->getMockBuilder( 'Flags\FlagsExtractor' )
			->disableOriginalConstructor()
			->setMethods( null )
			->getMock();

		/* Run tested method */
		$templates = $flagsExtractorMock->findFirstTemplateFromList( $mockTemplatesNames, $mockText );
		$this->assertEquals( $expectedResult, $templates );
	}

	/**
	 * @test
	 * @dataProvider shouldCheckForTagDataProvider
	 */
	function shouldCheckForTag( $mockTagName, $mockText, $expectedResult ) {
		/* @var Flags\FlagsExtractor $flagsExtractorMock mock of Flags\FlagsExtractor class */
		$flagsExtractorMock = $this->getMockBuilder( 'Flags\FlagsExtractor' )
			->disableOriginalConstructor()
			->setMethods( null )
			->getMock();

		/* Run tested method */
		$isAdded = $flagsExtractorMock->isTagAdded( $mockTagName, $mockText );
		$this->assertEquals( $expectedResult, $isAdded );
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
		$mockTemplate3 = '{{Template:iumb
| id = Oou
| bg = #fff
| image = [[File:KolejorzMistrz.jpg]]
}}';

		$mockTextTemplateAtTheBeginning = $mockTemplate1;
		$mockTextTwoTemplatesOneByOne = $mockTemplate1 . $mockTemplate2;
		$mockTextTwoTemplatesAndText = "Some text \n" . $mockTemplate1 . "Some text \n" . $mockTemplate2 . "\nSome text \n";
		$mockTextTemplateWithNSPrefix = "Some text \n more tex \n $mockTemplate3 text \n last text";
		$mockTextMixedTemplates = "Some text \n $mockTemplate1 more tex \n $mockTemplate3 text \n last text";
		$mockTextMixedTemplatesChangedOrder = "Some text \n $mockTemplate3 more tex \n $mockTemplate1 text \n last text";

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

		$expectedResultTemplateWithNS = [
			[
				'name' => 'iumb',
				'template' => $mockTemplate3,
				'params' => [
					'id' => 'Oou',
					'bg' => '#fff',
					'image' => '[[File:KolejorzMistrz.jpg]]'
				]
			]
		];

		$expectedResultMixedTemplates = [
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
				'template' => $mockTemplate3,
				'params' => [
					'id' => 'Oou',
					'bg' => '#fff',
					'image' => '[[File:KolejorzMistrz.jpg]]'
				]
			]
		];

		$expectedResultMixedTemplatesChangedOrder = [
			[
				'name' => 'iumb',
				'template' => $mockTemplate3,
				'params' => [
					'id' => 'Oou',
					'bg' => '#fff',
					'image' => '[[File:KolejorzMistrz.jpg]]'
				]
			],
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

		return [
			[ $mockTemplateName, $mockTextTemplateAtTheBeginning, $expectedResultOneTemplate ],
			[ $mockTemplateName, $mockTextTwoTemplatesOneByOne, $expectedResultTwoTemplates ],
			[ $mockTemplateName, $mockTextTwoTemplatesAndText, $expectedResultTwoTemplates ],
			[ $mockTemplateName, $mockTextTemplateWithNSPrefix, $expectedResultTemplateWithNS ],
			[ $mockTemplateName, $mockTextMixedTemplates, $expectedResultMixedTemplates ],
			[ $mockTemplateName, $mockTextMixedTemplatesChangedOrder, $expectedResultMixedTemplatesChangedOrder ]
		];
	}

	function shouldFindFirstTemplateFromListDataProvider() {
		$tpl1 = 'tpl1';
		$tpl2 = 'tpl2';
		$tpl3 = 'tpl3';

		$mockTemplate1 = '{{' . $tpl1 . '
| id = Oou
| bg = #F7F7F7
| image = [[File:Ewokdirector.jpg|130px]]
| caption = Piece of test text
| message = This is a {{{1}}} for {{{2|Łukasz}}} to test his notice script
| comment = {{{comment}}}
}}';
		$mockTemplate2 = '{{' . $tpl2 . '
| id = Oou
| bg = #F7F7F7
| image = [[File:Ewokdirector.jpg|130px]]
| caption = Piece of test text
}}';

		$mockTemplate3 = '{{' . $tpl3 . '
| image = [[File:Ewokdirector.jpg|130px]]
}}';

		$mockTemplatesNames123 = [ $tpl1, $tpl2, $tpl3 ];
		$mockTemplatesNames321 = [ $tpl3, $tpl2, $tpl1 ];
		$mockTemplatesNames3 = [ $tpl3 ];

		$mockTextTpl1 = $mockTemplate1;
		$mockTextTpl12 = $mockTemplate1 . $mockTemplate2;
		$mockTextTpl123 = $mockTemplate1 . $mockTemplate2 . $mockTemplate3;
		$mockTextTpl321 = $mockTemplate3 . $mockTemplate1 . $mockTemplate2;

		return [
			[ $mockTemplatesNames123, $mockTextTpl123, $tpl1 ],
			[ $mockTemplatesNames123, $mockTextTpl321, $tpl3 ],
			[ $mockTemplatesNames321, $mockTextTpl123, $tpl1 ],
			[ $mockTemplatesNames3, $mockTextTpl321, $tpl3 ],
			[ $mockTemplatesNames3, $mockTextTpl12, null ],
			[ $mockTemplatesNames321, $mockTextTpl1, $tpl1 ]
		];
	}

	function shouldCheckForTagDataProvider() {
		$mockTagName = '__SOME_FLAG_TAG__';
		$mockDefaultTagName = '__FLAGS__';

		return [
			[ $mockTagName, 'Lorem ipsum', false ],
			[ $mockTagName, "Lorem ipsum\n{$mockTagName}", true ],
			[ $mockTagName, "0{$mockTagName}Lorem ipsum", true ],
			[ $mockTagName, $mockTagName, true ],
			[ null, "Lorem ipsum {$mockDefaultTagName}", true ]
		];
	}
}
