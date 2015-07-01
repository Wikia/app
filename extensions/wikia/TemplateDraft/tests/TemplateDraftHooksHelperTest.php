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
		$paramUserCanTemplateDraft,
		$paramIsTitleDraft,
		$paramIsMarkedAsInfobox,
		$railModuleListExpected
	) {

		$railModuleListActual = [];

		/** @var Title $mockTitle */
		$mockTitle = $this->getMockBuilder( 'Title' )
			->disableOriginalConstructor()
			->setMethods( [ 'exists', 'getNamespace', 'userCan' ] )
			->getMock();

		$mockTitle->expects( $this->once() )
			->method( 'exists' )
			->will( $this->returnValue( $paramTitleExists ) );

		$mockTitle->expects( $this->any() )
			->method( 'getNamespace' )
			->will( $this->returnValue( $paramTitleNamespace ) );

		$mockTitle->expects( $this->once() )
			->method( 'userCan' )
			->with( 'templatedraft' )
			->will( $this->returnValue( $paramUserCanTemplateDraft ) );

		/* mock TemplateDraftHelper */
		$mockTemplateDraftHelper = $this->getMockBuilder( 'Title' )
			->disableOriginalConstructor()
			->setMethods( [ 'isTitleDraft', 'isMarkedAsInfobox' ] )
			->getMock();

		$mockTemplateDraftHelper->expects( $this->once() )
			->method( 'isTitleDraft' )
			->will( $this->returnValue( $paramIsTitleDraft ) );

		$mockTemplateDraftHelper->expects( $this->once() )
			->method( 'isMarkedAsInfobox' )
			->will( $this->returnValue( $paramIsMarkedAsInfobox ) );

		/* Mock tested class /*
		/** @var TemplateDraftHooksHelper $mockTemplateDraftHooksHelper */
		$mockTemplateDraftHooksHelper = $this->getMockBuilder( 'TemplateDraftHooksHelper' )
			->disableOriginalConstructor()
			->setMethods( [ 'getGlobalTitle', 'getTemplateDraftHelper' ] )
			->getMock();

		$mockTemplateDraftHooksHelper->expects( $this->once() )
			->method( 'getGlobalTitle' )
			->will( $this->returnValue( $mockTitle ) );

		$mockTemplateDraftHooksHelper->expects( $this->once() )
			->method( 'getTemplateDraftHelper' )
			->will( $this->returnValue( $mockTemplateDraftHelper ) );

		$mockTemplateDraftHooksHelper->addRailModuleList( $railModuleListActual );

		$this->assertEquals( $railModuleListExpected, $railModuleListActual );
	}

	public function showCreateDraftModuleProvider() {
		$railModuleListExpectedCreate[1502] = [ 'TemplateDraftModule', 'Create', null ];
		$railModuleListExpectedApprove[1502] = [ 'TemplateDraftModule', 'Approve', null ];

		/*
		 * Params order
		 * [ $paramTitleExists, $paramTitleNamespace, $paramUserCanTemplateDraft, $paramIsTitleDraft, $paramIsMarkedAsInfobox, $railModuleListExpected ]
		 */
		return [
			[ true, NS_TEMPLATE, true, false, true, $railModuleListExpectedCreate ],
		];
	}
}
