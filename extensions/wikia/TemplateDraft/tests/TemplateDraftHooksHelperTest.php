<?php

class TemplateDraftHooksHelperTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../TemplateDraft.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider showCreateDraftModuleProvider
	 */
	public function testShowCreateDraftModule(
		$paramAllowedForTitle,
		$paramIsTitleDraft,
		$railModuleListExpected,
		$railModuleListDefault
	) {

		$railModuleListActual = $railModuleListDefault;

		/** @var Title $mockParentTitle */
		$mockParentTitle = $this->getMockBuilder( 'Title' )
			->disableOriginalConstructor()
			->setMethods( [] )
			->getMock();

		/** @var Title $mockTitle */
		$mockTitle = $this->getMockBuilder( 'Title' )
			->disableOriginalConstructor()
			->setMethods( [ 'exists', 'getNamespace' ] )
			->getMock();

		/* mock TemplateDraftHelper */
		$mockTemplateDraftHelper = $this->getMockBuilder( 'TemplateDraftHelper' )
			->disableOriginalConstructor()
			->setMethods( [ 'allowedForTitle', 'isTitleDraft' ] )
			->getMock();

		$mockTemplateDraftHelper->expects( $this->any() )
			->method( 'allowedForTitle' )
			->will( $this->returnValue( $paramAllowedForTitle ) );

		$mockTemplateDraftHelper->expects( $this->any() )
			->method( 'isTitleDraft' )
			->will( $this->returnValue( $paramIsTitleDraft ) );

		/* Mock tested class /*
		/** @var TemplateDraftHooksHelper $mockTemplateDraftHooksHelper */
		$mockTemplateDraftHooksHelper = $this->getMockBuilder( 'TemplateDraftHooksHelper' )
			->disableOriginalConstructor()
			->setMethods( [ 'getGlobalTitle', 'getTemplateDraftHelper' ] )
			->getMock();

		$mockTemplateDraftHooksHelper->expects( $this->once() )
			->method( 'getGlobalTitle' )
			->will( $this->returnValue( $mockTitle ) );

		$mockTemplateDraftHooksHelper->expects( $this->any() )
			->method( 'getTemplateDraftHelper' )
			->will( $this->returnValue( $mockTemplateDraftHelper ) );

		$mockTemplateDraftHooksHelper->addRailModuleList( $railModuleListActual );

		$this->assertEquals( $railModuleListExpected, $railModuleListActual );
	}

	/**
	 * @dataProvider allowedForTitleProvider
	 */
	public function testAllowedForTitle(
		$paramTitleExists,
		$paramTitleNamespace,
		$paramIsParentValid,
		$allowedForTitleExpected
	)
	{
		$mockFakeTitle = $this->getMockBuilder( 'Title' )
			->disableOriginalConstructor()
			->setMethods( [] )
			->getMock();

		$mockTitle = $this->getMockBuilder( 'Title' )
			->disableOriginalConstructor()
			->setMethods( [ 'exists', 'getNamespace' ] )
			->getMock();

		$mockTitle->expects( $this->once() )
			->method( 'exists' )
			->will( $this->returnValue( $paramTitleExists ) );

		$mockTitle->expects( $this->any() )
			->method( 'getNamespace' )
			->will( $this->returnValue( $paramTitleNamespace ) );

		/** @var TemplateDraftHelper $mockTemplateDraftHelper */
		$mockTemplateDraftHelper = $this->getMockBuilder( 'TemplateDraftHelper' )
			->disableOriginalConstructor()
			->setMethods( [ 'getParentTitle', 'isParentValid' ] )
			->getMock();

		$mockTemplateDraftHelper->expects( $this->any() )
			->method( 'getParentTitle' )
			->will( $this->returnValue( $mockFakeTitle ) );

		$mockTemplateDraftHelper->expects( $this->any() )
			->method( 'isParentValid' )
			->will( $this->returnValue( $paramIsParentValid ) );

		$allowedForTitleActual = $mockTemplateDraftHelper->allowedForTitle( $mockTitle );
		$this->assertEquals( $allowedForTitleExpected, $allowedForTitleActual );

	}

	/**
	 * @dataProvider isParentValidProvider
	 */
	public function testIsParentValid(
		$paramUserCanTemplateDraft,
		$paramIsMarkedAsInfobox,
		$isParentValidExpected
	) {

		/** @var Title $mockTitle */
		$mockTitle = $this->getMockBuilder( 'Title' )
			->disableOriginalConstructor()
			->setMethods( [ 'userCan' ] )
			->getMock();

		$mockTitle->expects( $this->once() )
			->method( 'userCan' )
			->with( 'templatedraft' )
			->will( $this->returnValue( $paramUserCanTemplateDraft ) );

		/* Mock tested class */
		/** @var TemplateDraftHelper $mockTemplateDraftHelper */
		$mockTemplateDraftHelper = $this->getMockBuilder( 'TemplateDraftHelper' )
			->disableOriginalConstructor()
			->setMethods( [ 'isMarkedAsInfobox' ] )
			->getMock();

		$mockTemplateDraftHelper->expects( $this->any() )
			->method( 'isMarkedAsInfobox' )
			->will( $this->returnValue( $paramIsMarkedAsInfobox ) );

		$isParentValidActual = $mockTemplateDraftHelper->isParentValid( $mockTitle );

		$this->assertEquals( $isParentValidExpected, $isParentValidActual );
	}

	/* Data providers */
	public function showCreateDraftModuleProvider() {
		$railModuleListDefault = [];
		$railModuleListExpectedCreate[1502] = [ 'TemplateDraftModule', 'Create', null ];
		$railModuleListExpectedApprove[1502] = [ 'TemplateDraftModule', 'Approve', null ];

		/*
		 * Params order
		 * [ $paramAllowedForTitle, $paramIsTitleDraft, $railModuleListExpected, $railModuleListDefault ]
		 */
		return [
			[ true, false, $railModuleListExpectedCreate, $railModuleListDefault ],
			[ true, true, $railModuleListExpectedApprove, $railModuleListDefault ],
			[ false, true, $railModuleListDefault, $railModuleListDefault ],
		];
	}

	/* Data providers */
	public function allowedForTitleProvider() {

		/*
		 * Params order
		 * [ $paramTitleExists, $paramTitleNamespace, $paramIsParentValid, $allowedForTitleExpected ]
		 */
		return [
			[ true, NS_TEMPLATE, true, true ],
			[ false, NS_TEMPLATE, true, false ],
			[ true, NS_MAIN, true, false ],
			[ true, NS_TEMPLATE, false, false ],
		];
	}

	public function isParentValidProvider() {
		$railModuleListExpectedCreate[1502] = [ 'TemplateDraftModule', 'Create', null ];
		$railModuleListExpectedApprove[1502] = [ 'TemplateDraftModule', 'Approve', null ];

		/*
		 * Params order
		 * [
		 *	$paramUserCanTemplateDraft,
		 *	$paramIsMarkedAsInfobox,
		 *	$isParentValidExpected
		 * ]
		 */
		return [
			[ true, true, true ],
			[ true, false, false ],
			[ false, true, false ],
			[ false, false, false ],
		];
	}
}
