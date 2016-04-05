<?php

class PortableInfoboxBuilderHelperTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfoboxBuilder.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider titleTextProvider
	 */
	public function testGetUrlPath( $titleText, $expected ) {
		$this->assertEquals( $expected, PortableInfoboxBuilderHelper::getUrlPath( $titleText ) );
	}

	/**
	 * @dataProvider infoboxTemplateDetectionProvider
	 */
	public function testIsInfoboxTemplate( $namespace, $templateType, $expResult ) {
		$titleMock = $this->getMockBuilder( 'Title' )->setMethods( [ 'getNamespace' ] )->getMock();
		$titleMock->expects( $this->any() )->method( 'getNamespace' )->willReturn( $namespace );

		$tcsMock = $this->getMockBuilder( 'TemplateClassificationService' )->setMethods( [ 'getType' ] )->getMock();
		$tcsMock->expects( $this->any() )->method( 'getType' )->willReturn( $templateType );
		$this->mockClass( 'TemplateClassificationService', $tcsMock );

		$this->assertEquals(
			$expResult,
			PortableInfoboxBuilderHelper::isInfoboxTemplate( $titleMock ),
			"PortableInfoboxBuilderHelper::isInfoboxTemplate should return true if and only if the namespace is NS_TEMPLATE and type is TEMPLATE_INFOBOX"
		);
	}


	/**
	 * @dataProvider requestModeProvider
	 */
	public function testForcedSourceMode( $queryStringValue, $expectedResult ) {
		$requestMock = $this->getMockBuilder( 'WebRequest' )->setMethods( [ 'getVal' ] )->getMock();
		$requestMock->expects( $this->any() )->method( 'getVal' )->willReturn( $queryStringValue );

		$this->assertEquals( $expectedResult, PortableInfoboxBuilderHelper::isForcedSourceMode( $requestMock ) );
	}

	/**
	 * @dataProvider requestActionProvider
	 */
	public function testActionSubmit( $queryStringValue, $expectedResult ) {
		$requestMock = $this->getMockBuilder( 'WebRequest' )->setMethods( [ 'getVal' ] )->getMock();
		$requestMock->expects( $this->any() )->method( 'getVal' )->willReturn( $queryStringValue );

		$this->assertEquals( $expectedResult, PortableInfoboxBuilderHelper::isSubmitAction( $requestMock ) );
	}

	/**
	 * @dataProvider getTitleProvider
	 */
	public function testGetTitle( $title, $expected ) {
		$status = new Status();
		$this->assertEquals( $expected, PortableInfoboxBuilderHelper::getTitle( $title, $status ) );
	}

	/**
	 * @dataProvider createRedirectUrlsProvider
	 */
	public function testCreateRedirectUrls( $isGood, $expected ) {
		$statusMock = $this->getMockBuilder( 'Status' )->setMethods( [ 'isGood' ] )->getMock();
		$statusMock->expects( $this->any() )->method( 'isGood' )->willReturn( $isGood );
		$this->mockClass( 'Status', $statusMock );
		$fullUrlMock = $this->getMockBuilder( 'Title' )->setMethods( [ 'getFullUrl' ] )->getMock();
		$fullUrlMock->expects( $this->any() )->method( 'getFullUrl' )->willReturn( 'full_url' );
		$this->mockClass( 'Title', $fullUrlMock );

		$this->assertEquals( $expected, PortableInfoboxBuilderHelper::createRedirectUrls( 'test' ) );
	}

	/**
	 * @dataProvider canBeEditedProvider
	 */
	public function testIfBuilderShouldBeUsed( $infoboxes, $titleExists, $canEdit, $expected, $message ) {
		$mock = $this->getMockBuilder( 'PortableInfoboxDataService' )
			->disableOriginalConstructor()->setMethods( [ 'getInfoboxes' ] )->getMock();
		$mock->expects( $this->any() )->method( 'getInfoboxes' )->will( $this->returnValue( $infoboxes ) );
		$this->mockStaticMethod( 'PortableInfoboxDataService', 'newFromTitle', $mock );
		$this->mockStaticMethod( 'PortableInfoboxBuilderHelper', 'isInfoboxTemplate', true );

		$user = $this->getMockBuilder( 'User' )->disableOriginalConstructor()
			->setMethods( [ 'isLoggedIn' ] )->getMock();
		$user->expects( $this->any() )->method( 'isLoggedIn' )->will( $this->returnValue( true ) );

		$title = $this->getMockBuilder( 'Title' )->disableOriginalConstructor()
			->setMethods( [ 'userCan', 'isKnown' ] )->getMock();
		$title->expects( $this->any() )->method( 'userCan' )->will( $this->returnValue( $canEdit ) );
		$title->expects( $this->any() )->method( 'isKnown' )->will( $this->returnValue( $titleExists ) );

		$this->assertEquals( $expected, PortableInfoboxBuilderHelper::canUseInfoboxBuilder( $title, $user ), $message );
	}

	public function titleTextProvider() {
		return [
			[ '', '' ],
			[ 'Special:InfoboxBuilder', '' ],
			[ 'Special:InfoboxBuilder/', '' ],
			[ 'Special:InfoboxBuilder/TemplateName', 'TemplateName' ],
			[ 'Special:InfoboxBuilder/TemplateName/Subpage', 'TemplateName/Subpage' ]
		];
	}

	public function requestModeProvider() {
		return [
			[ 'source', true ],
			[ 'mediawiki', false ],
			[ '', false ],
			[ null, false ]
		];
	}

	public function requestActionProvider() {
		return [
			[ 'submit', true ],
			[ 'raw', false ],
			[ 'source', false ],
			[ 'edit', false ],
			[ null, false ]
		];
	}

	public function getTitleProvider() {
		return [
			[ 'testtitle', Title::newFromText( 'testtitle', NS_TEMPLATE ) ],
			[ 't t', Title::newFromText( 't t', NS_TEMPLATE ) ],
			[ '', false ],
			[ null, false ]
		];
	}

	public function createRedirectUrlsProvider() {
		return [
			[ false, [ ] ],
			[ true,
			  [
				  'templatePageUrl' => 'full_url',
				  'sourceEditorUrl' => 'full_url'
			  ]
			]
		];
	}

	public function infoboxTemplateDetectionProvider() {
		return [
			[ NS_MAIN, TemplateClassificationService::TEMPLATE_INFOBOX, false ],
			[ NS_TALK, TemplateClassificationService::TEMPLATE_INFOBOX, false ],
			[ NS_USER, TemplateClassificationService::TEMPLATE_INFOBOX, false ],
			[ NS_USER_TALK, TemplateClassificationService::TEMPLATE_INFOBOX, false ],
			[ NS_PROJECT, TemplateClassificationService::TEMPLATE_INFOBOX, false ],
			[ NS_PROJECT_TALK, TemplateClassificationService::TEMPLATE_INFOBOX, false ],
			[ NS_FILE, TemplateClassificationService::TEMPLATE_INFOBOX, false ],
			[ NS_FILE_TALK, TemplateClassificationService::TEMPLATE_INFOBOX, false ],
			[ NS_MEDIAWIKI, TemplateClassificationService::TEMPLATE_INFOBOX, false ],
			[ NS_MEDIAWIKI_TALK, TemplateClassificationService::TEMPLATE_INFOBOX, false ],
			[ NS_TEMPLATE, TemplateClassificationService::TEMPLATE_INFOBOX, true ],
			[ NS_TEMPLATE_TALK, TemplateClassificationService::TEMPLATE_INFOBOX, false ],
			[ NS_HELP, TemplateClassificationService::TEMPLATE_INFOBOX, false ],
			[ NS_HELP_TALK, TemplateClassificationService::TEMPLATE_INFOBOX, false ],
			[ NS_CATEGORY, TemplateClassificationService::TEMPLATE_INFOBOX, false ],
			[ NS_CATEGORY_TALK, TemplateClassificationService::TEMPLATE_INFOBOX, false ],
			[ NS_MAIN, null, false ],
			[ NS_TALK, null, false ],
			[ NS_USER, null, false ],
			[ NS_USER_TALK, null, false ],
			[ NS_PROJECT, null, false ],
			[ NS_PROJECT_TALK, null, false ],
			[ NS_FILE, null, false ],
			[ NS_FILE_TALK, null, false ],
			[ NS_MEDIAWIKI, null, false ],
			[ NS_MEDIAWIKI_TALK, null, false ],
			[ NS_TEMPLATE, null, false ],
			[ NS_TEMPLATE_TALK, null, false ],
			[ NS_HELP, null, false ],
			[ NS_HELP_TALK, null, false ],
			[ NS_CATEGORY, null, false ],
			[ NS_CATEGORY_TALK, null, false ]
		];
	}

	public function canBeEditedProvider() {
		return [
			// infoboxes, template exists, user can edit, expected
			[ [ ], false, false, false, 'user without permissions cannot edit' ],
			[ [ ], false, true, false, 'not existing title cannot be edited' ],
			[ [ '<infobox><data source="adsf"/></infobox>' ], true, true, true, 'editable existing template' ],
			[ [ '' ], true, true, false, 'existing no portable infoboxes cannot be edited' ],
		];
	}
}
