<?php

class InfoboxReplaceHelperTest extends WikiaBaseTest {
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
	public function testProcessLayoutAttribute( $inputContent, $expectedOutput, $message ) {
		$actualOutput = $this->infoboxReplaceHelper->processLayoutAttribute( $inputContent );
		$this->assertEquals( $expectedOutput, $actualOutput, $message );
	}

	public function contentDataProvider() {
		$infoboxBody = '<title source="title"><default>Default title</default></title>
  <image source="image">
    <caption source="caption"/>
    <alt source ="alt"/>
    <default>Wiki-background</default>
  </image>
  <data source="data1">
    <label>Lorem ipsum</label>
    <default>Data 1</default>
  </data>
  <group>
    <header>Group header</header>
    <data source="data2"><label>Ipsum dolor</label></data>
 </group>';


		$infoboxWithAttributes = '<infobox theme="My Custom theme">
  ' . $infoboxBody . '</infobox>';

		$infoboxWithAttributesExpected = '<infobox layout="stacked" theme="My Custom theme">
  ' . $infoboxBody . '</infobox>';


		$infoboxWithMultilineAttributes = '<infobox
theme="My Custom theme"
theme-source="location"
>
  ' . $infoboxBody . '</infobox>';

		$infoboxWithMultilineAttributesExpected = '<infobox layout="stacked"
theme="My Custom theme"
theme-source="location"
>
  ' . $infoboxBody . '</infobox>';


		$infoboxWithMultilineLayoutStacked = '<infobox
layout="stacked"
theme="My Custom theme"
theme-source="location"
>
  ' . $infoboxBody . '</infobox>';


		$infoboxWithStackedLayout = '<infobox theme="My Custom theme" layout="stacked" >
  ' . $infoboxBody . '</infobox>';


		$infoboxWithHorizontalLayout = '<infobox theme="My Custom theme" layout="horizontal" >
  ' . $infoboxBody . '</infobox>';


		$infoboxWithPrecedingText = 'test test
test<infobox theme="My Custom theme">
  ' . $infoboxBody . '</infobox>';

		$infoboxWithPrecedingTextExpected = 'test test
test<infobox layout="stacked" theme="My Custom theme">
  ' . $infoboxBody . '</infobox>';

		$multipleInfoboxes = $infoboxWithAttributes .
			$infoboxWithStackedLayout .
			$infoboxWithHorizontalLayout .
			$infoboxWithPrecedingText .
			$infoboxWithMultilineAttributes .
			$infoboxWithMultilineLayoutStacked;
		$multipleInfoboxesExpected = $infoboxWithAttributesExpected .
			$infoboxWithStackedLayout .
			$infoboxWithHorizontalLayout .
			$infoboxWithPrecedingTextExpected .
			$infoboxWithMultilineAttributesExpected .
			$infoboxWithMultilineLayoutStacked;


		return [
			[ '', '', 'Empty article' ],
			[ '<infobox></infobox>', '<infobox layout="stacked"></infobox>', 'Empty infobox declaration' ],
			[ $infoboxWithAttributes, $infoboxWithAttributesExpected, 'Infobox with some attributes' ],
			[ $infoboxWithStackedLayout, $infoboxWithStackedLayout, 'Infobox with stacked layout already defined' ],
			[ $infoboxWithHorizontalLayout, $infoboxWithHorizontalLayout, 'Infobox with horizontal layout already defined' ],
			[ $infoboxWithPrecedingText, $infoboxWithPrecedingTextExpected, 'Infobox with preceding text' ],
			[ $infoboxWithMultilineAttributes, $infoboxWithMultilineAttributesExpected, 'Multiple infoboxes definitions in one article' ],
			[ $infoboxWithMultilineLayoutStacked, $infoboxWithMultilineLayoutStacked, 'Multiple infoboxes definitions in one article' ],
			[ $multipleInfoboxes, $multipleInfoboxesExpected, 'Multiple infoboxes definitions in one article' ],
		];
	}
}
