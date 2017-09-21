<?php

class WallMessageBuilderTest extends WikiaBaseTest {
	/** @var WallMessageBuilder $builder - the SUT */
	private $builder;

	public function setUp() {
		$this->setupFile = __DIR__ . '/../Wall.setup.php';
		parent::setUp();

		$this->builder = new WallMessageBuilder();
	}

	public function testWallPageIsCreatedIfNotExists() {
		/** @var PHPUnit_Framework_MockObject_MockObject|Title $wallTitleMock */
		$wallTitleMock = $this->getMock( Title::class, [ 'exists' ] );
		$wallTitleMock->expects( $this->once() )
			->method( 'exists' )
			->willReturn( false );

		$wallPageMock = $this->getMockBuilder( WikiPage::class )
			->disableOriginalConstructor()
			->setMethods( [ 'doEdit' ] )
			->getMock();
		$wallPageMock->expects( $this->once() )
			->method( 'doEdit' )
			->with( $this->isEmpty(), $this->isEmpty(), EDIT_NEW | EDIT_MINOR | EDIT_SUPPRESS_RC | EDIT_FORCE_BOT, false, $this->isInstanceOf( User::class ) )
			->willReturn( Status::newGood() );
		$this->mockClass( WikiPage::class, $wallPageMock, 'factory' );

		$this->builder->setParentPageTitle( $wallTitleMock );
		$this->builder->createParentPageIfNotExists();
	}
}
