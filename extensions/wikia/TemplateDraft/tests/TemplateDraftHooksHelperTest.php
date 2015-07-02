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
		$paramTitleExists,
		$paramTitleNamespace,
		$paramIsTitleDraft,
		$paramIsParentValid,
		$railModuleListExpected
	) {

		$railModuleListActual = [];

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

		$mockTitle->expects( $this->once() )
			->method( 'exists' )
			->will( $this->returnValue( $paramTitleExists ) );

		$mockTitle->expects( $this->any() )
			->method( 'getNamespace' )
			->will( $this->returnValue( $paramTitleNamespace ) );

		/* mock TemplateDraftHelper */
		$mockTemplateDraftHelper = $this->getMockBuilder( 'TemplateDraftHelper' )
			->disableOriginalConstructor()
			->setMethods( [ 'getParentTitle', 'isTitleDraft', 'isParentValid' ] )
			->getMock();

		$mockTemplateDraftHelper->expects( $this->any() )
			->method( 'getParentTitle' )
			->will( $this->returnValue( $mockParentTitle ) );

		$mockTemplateDraftHelper->expects( $this->any() )
			->method( 'isTitleDraft' )
			->will( $this->returnValue( $paramIsTitleDraft ) );

		$mockTemplateDraftHelper->expects( $this->once() )
			->method( 'isParentValid' )
			->will( $this->returnValue( $paramIsParentValid ) );

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
		$railModuleListExpectedCreate[1502] = [ 'TemplateDraftModule', 'Create', null ];
		$railModuleListExpectedApprove[1502] = [ 'TemplateDraftModule', 'Approve', null ];

		/*
		 * Params order
		 * [ $paramTitleExists, $paramTitleNamespace, $paramIsTitleDraft, $paramIsParentValid, $railModuleListExpected ]
		 */
		return [
			[ true, NS_TEMPLATE, false, true, $railModuleListExpectedCreate ],
			[ true, NS_TEMPLATE, true, true, $railModuleListExpectedApprove ],
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
