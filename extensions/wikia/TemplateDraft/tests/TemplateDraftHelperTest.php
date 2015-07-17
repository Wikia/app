<?php

class TemplateDraftHelperTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../TemplateDraft.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider isTitleDraftProvider
	 */
	public function testIsTitleDraft(
		$paramTitleNamespace,
		$paramIsSubpage,
		$paramSubpageText,
		$paramMessageSubpageTextContentLang,
		$paramMessageSubpageTextEnLang,
		$isTitleDraftExpected
	) {

		$this->mockMessagesForTemplateDraftNameCheck(
			$paramMessageSubpageTextContentLang,
			$paramMessageSubpageTextEnLang
		);

		/** @var Title $mockTitle */
		$mockTitle = $this->getMockBuilder( 'Title' )
			->disableOriginalConstructor()
			->setMethods( [ 'getNamespace', 'getSubpageText', 'isSubpage' ] )
			->getMock();

		$mockTitle->expects( $this->any() )
			->method( 'getNamespace' )
			->will( $this->returnValue( $paramTitleNamespace ) );

		$mockTitle->expects( $this->any() )
			->method( 'getSubpageText' )
			->will( $this->returnValue( $paramSubpageText ) );

		$mockTitle->expects( $this->any() )
			->method( 'isSubpage' )
			->will( $this->returnValue( $paramIsSubpage ) );

		/* Mock tested class /*
		/* @var TemplateDraftHelper $mockTemplateDraftHelper */
		$mockTemplateDraftHelper = $this->getMockBuilder( 'TemplateDraftHelper' )
			->disableOriginalConstructor()
			->setMethods( null )
			->getMock();

		$isTitleDraftActual = $mockTemplateDraftHelper->isTitleDraft( $mockTitle );

		$this->assertEquals( $isTitleDraftExpected, $isTitleDraftActual );
	}

	/* Data providers */
	public function isTitleDraftProvider() {
		$defaultEnDraftName = 'DraftY7123277';
		$plDraftName = 'SzkicQ7123278';
		$randomPageName = 'SomeNameRE2342233';
		/*
		 * Params order
		 * [
		 *	$paramTitleNamespace,
		 *	$paramIsSubpage,
		 *	$paramSubpageText,
		 *	$paramMessageSubpageTextContentLang,
		 *	$paramMessageSubpageTextEnLang,
		 *	$isTitleDraftExpected
		 * ]
		 */
		return [
			/* Simple case: Template namespace, is subpage, EN page name and content lang */
			[ NS_TEMPLATE, true, $defaultEnDraftName, $defaultEnDraftName, $defaultEnDraftName, true ],
			/* EN name of page and different content language - should match default EN lang criteria */
			[ NS_TEMPLATE, true, $defaultEnDraftName, $plDraftName, $defaultEnDraftName, true ],
			/* PL name of page and PL content lang */
			[ NS_TEMPLATE, true, $plDraftName, $plDraftName, $defaultEnDraftName, true ],
			/* Not a sub page */
			[ NS_TEMPLATE, false, $defaultEnDraftName, $defaultEnDraftName, $defaultEnDraftName, false ],
			/* Main namespace */
			[ NS_MAIN, true, $defaultEnDraftName, $defaultEnDraftName, $defaultEnDraftName, false ],
			/* Not a sub page and Main namespace */
			[ NS_MAIN, false, $defaultEnDraftName, $defaultEnDraftName, $defaultEnDraftName, false ],
			/* Random page name and PL content lang */
			[ NS_TEMPLATE, true, $randomPageName, $plDraftName, $defaultEnDraftName, false ],
		];
	}

	/* Helper functions */
	private function mockMessagesForTemplateDraftNameCheck( $paramMessageSubpageTextContentLang, $paramMessageSubpageTextEnLang ) {
		/* Mock message for in content language request */
		$mockMessageContentLang = $this->getMockBuilder( 'Message' )
			->disableOriginalConstructor()
			->setMethods( array( 'escaped' ) )
			->getMock();
		$mockMessageContentLang
			->expects( $this->any() )
			->method( 'escaped' )
			->will( $this->returnValue( $paramMessageSubpageTextContentLang ) );

		/* Mock message for default EN language request */
		$mockMessageEn = $this->getMockBuilder( 'Message' )
			->disableOriginalConstructor()
			->setMethods( array( 'escaped' ) )
			->getMock();
		$mockMessageEn
			->expects( $this->any() )
			->method( 'escaped' )
			->will( $this->returnValue( $paramMessageSubpageTextEnLang ) );

		/* Mock message to return different one depending on language call */
		$mockMessage = $this->getMockBuilder( 'Message' )
			->disableOriginalConstructor()
			->setMethods( array( 'inContentLanguage', 'inLanguage' ) )
			->getMock();
		$mockMessage
			->expects( $this->any() )
			->method( 'inContentLanguage' )
			->will( $this->returnValue( $mockMessageContentLang ) );
		$mockMessage
			->expects( $this->any() )
			->method( 'inLanguage' )
			->with( 'en' )
			->will( $this->returnValue( $mockMessageEn ) );

		/* Mock global wfMessage */
		$mockWfMessage = $this->getGlobalFunctionMock( 'wfMessage' );

		$mockWfMessage
			->expects( $this->any() )
			->method( 'wfMessage' )
			->with( 'templatedraft-subpage' )
			->will( $this->returnValue( $mockMessage ) );
	}

}
