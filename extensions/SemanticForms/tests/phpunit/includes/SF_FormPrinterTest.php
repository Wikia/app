<?php
/**
 * Tests for the SFFormPrinter class
 *
 * @author Himeshi De Silva
 */
class SFFormPrinterTest extends MediaWikiTestCase {

	// Tests for page sections in the formHTML() method

	/**
	 * @dataProvider pageSectionDataProvider
	 */
	public function testPageSectionsWithoutExistingPages( $setup, $expected ) {

		global $sfgFormPrinter, $wgTitle, $wgParser, $wgOut;

		$wgParser = $this->getParser();
		$wgTitle = $this->getTitle();
		$wgOut->getContext()->setTitle( $wgTitle );

		list ( $form_text, $page_text, $form_page_title, $generated_page_name ) =
			$sfgFormPrinter->formHTML( $setup['form_definition'], true, false, null, null, 'TestStringForFormPageTitle', null );

		$this->assertContains(
			$expected['expected_form_text'],
			$form_text,
			'asserts that formHTML() returns the correct HTML text for the form for the given test input'
			);
		$this->assertContains(
			$expected['expected_page_text'],
			$page_text,
			'assert that formHTML() returns the correct text for the page created by the form'
			);

	}

	/**
	 * Data provider method
	 */
	public function pageSectionDataProvider() {

		$provider = array();

		// #1 form definition without other parameters
		$provider[] = array(
		array(
			'form_definition' => "==section1==
								 {{{section|section1|level=2}}}" ),
		array(
			'expected_form_text' => "<span class=\"inputSpan pageSection\"><textarea tabindex=\"1\" name=\"_section[section1]\" id=\"input_1\" class=\"createboxInput\" rows=\"5\" cols=\"90\" style=\"width: 100%\"></textarea></span>",
			'expected_page_text' => "==section1==" )
		);

		// #2 'rows' and 'colums' parameters set
		$provider[] = array(
		array(
			'form_definition' => "=====section 2=====
								 {{{section|section 2|level=5|rows=10|cols=5}}}" ),
		array(
			'expected_form_text' => "<span class=\"inputSpan pageSection\"><textarea tabindex=\"1\" name=\"_section[section 2]\" id=\"input_1\" class=\"createboxInput\" rows=\"10\" cols=\"5\" style=\"width: auto\"></textarea></span>",
			'expected_page_text' => "=====section 2=====" )
		);

		// #3 'mandatory' and 'autogrow' parameters set
		$provider[] = array(
		array(
			'form_definition' => "==section 3==
								 {{{section|section 3|level=2|mandatory|rows=20|cols=50|autogrow}}}" ),
		array(
			'expected_form_text' => "<span class=\"inputSpan pageSection mandatoryFieldSpan\"><textarea tabindex=\"1\" name=\"_section[section 3]\" id=\"input_1\" class=\"mandatoryField autoGrow\" rows=\"20\" cols=\"50\" style=\"width: auto\"></textarea></span>",
			'expected_page_text' => "==section 3==" )
		);

		// #4 'restricted' parameter set
		$provider[] = array(
		array(
			'form_definition' => "===Section 5===
								 {{{section|Section 5|level=3|restricted|class=FormTest}}}" ),
		array(
			'expected_form_text' => "<span class=\"inputSpan pageSection\"><textarea tabindex=\"1\" name=\"_section[Section 5]\" id=\"input_1\" class=\"createboxInput FormTest\" rows=\"5\" cols=\"90\" style=\"width: 100%\" disabled=\"\"></textarea></span>",
			'expected_page_text' => "===Section 5===" )
		);

		// #5 'hidden' parameter set
		$provider[] = array(
		array(
			'form_definition' => "====section 4====
								 {{{section|section 4|level=4|hidden}}}" ),
		array(
			'expected_form_text' => "<input type=\"hidden\" name=\"_section[section 4]\"/>",
			'expected_page_text' => "====section 4====" )
		);

	return $provider;
	}

	/**
	 * Returns a mock Title for test
	 * @return Title
	 */
	private function getTitle() {

		$mockTitle = $this->getMockBuilder( 'Title' )
						  ->disableOriginalConstructor()
						  ->getMock();

		$mockTitle->expects( $this->any() )
			->method( 'getDBkey' )
			->will( $this->returnValue( 'Sometitle' ) );

		$mockTitle->expects( $this->any() )
			->method( 'getNamespace' )
			->will( $this->returnValue( SF_NS_FORM ) );

		return $mockTitle;
	}

	/**
	 * Returns a Parser for test
	 * @return Parser
	 */
	private function getParser() {

		return new StubObject(
		'wgParser', $GLOBALS['wgParserConf']['class'],
		array( $GLOBALS['wgParserConf'] ) );
	}

}

