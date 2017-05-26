<?php

class RecirculationHooksTest extends WikiaBaseTest {
	/** @var RequestContext $context */
	private $context;

	/** @var OutputPage $out */
	private $out;

	/** @var Title|PHPUnit_Framework_MockObject_MockObject $titleMock */
	private $titleMock;

	/** @var \Wikia\Interfaces\IRequest $request */
	private $request;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../RecirculationHooks.class.php';

		$this->request = new FauxRequest();
		$this->titleMock = $this->createMock( Title::class );

		$this->context = new RequestContext();
		$this->context->setTitle( $this->titleMock );
		$this->context->setRequest( $this->request );

		$this->out = $this->context->getOutput();

		$this->mockGlobalVariable( 'wgTitle', $this->titleMock );
	}

	/**
	 * Test that Recirculation JS module is not added to output
	 * if the page fits Recirculation conditions but does not use the Oasis skin.
	 *
	 * @dataProvider provideNotOasisSkins
	 * @param Skin $notOasisSkin
	 */
	public function testJsIsNotAddedToOutputOnCorrectPageIfSkinIsNotOasis( Skin $notOasisSkin ) {
		$this->titleMock->expects( $this->any() )
			->method( 'exists' )
			->willReturn( true );

		$this->titleMock->expects( $this->any() )
			->method( 'isContentPage' )
			->willReturn( true );

		$this->titleMock->expects( $this->any() )
			->method( 'inNamespace' )
			->with( NS_FILE )
			->willReturn( true );

		$this->request->setVal( 'action', 'view' );

		$notOasisSkin->setContext( $this->context );

		$result = RecirculationHooks::onBeforePageDisplay( $this->out, $notOasisSkin );

		$this->assertTrue( $result );
		$this->assertNotContains( 'ext.wikia.reCirculation', $this->out->getModules() );
	}

	public function provideNotOasisSkins() {
		$notOasisSkins = [
			'monobook',
			'uncyclopedia',
			'wikiamobile'
		];

		foreach ( $notOasisSkins as $skinName ) {
			yield [ Skin::newFromKey( $skinName ) ];
		}
	}

	/**
	 * Test that Recirculation JS module is added to output
	 * if the page fits Recirculation conditions and uses the Oasis skin
	 */
	public function testJsIsAddedToOutputOnCorrectPageIfSkinIsOasis() {
		$oasisSkin = new SkinOasis();

		$this->titleMock->expects( $this->any() )
			->method( 'exists' )
			->willReturn( true );

		$this->titleMock->expects( $this->any() )
			->method( 'isContentPage' )
			->willReturn( true );

		$this->titleMock->expects( $this->any() )
			->method( 'inNamespace' )
			->with( NS_FILE )
			->willReturn( true );

		$this->request->setVal( 'action', 'view' );

		$oasisSkin->setContext( $this->context );

		$result = RecirculationHooks::onBeforePageDisplay( $this->out, $oasisSkin );

		$this->assertTrue( $result );
		$this->assertContains( 'ext.wikia.reCirculation', $this->out->getModules() );
	}

	/**
	 * Test that Recirculation JS module is not added to output
	 * if the page does not fit Recirculation conditions and uses the Oasis skin
	 *
	 * @dataProvider provideIncorrectPages
	 *
	 * @param bool $titleExists
	 * @param bool $titleIsContentPage
	 * @param bool $titleIsFile
	 * @param bool $isView
	 * @param bool $isDiff
	 */
	public function testJsIsNotAddedToOutputOnIncorrectPageIfSkinIsOasis(
		bool $titleExists, bool $titleIsContentPage, bool $titleIsFile, bool $isView, bool $isDiff
	) {
		$oasisSkin = new SkinOasis();

		$this->titleMock->expects( $this->any() )
			->method( 'exists' )
			->willReturn( $titleExists );

		$this->titleMock->expects( $this->any() )
			->method( 'isContentPage' )
			->willReturn( $titleIsContentPage );

		$this->titleMock->expects( $this->any() )
			->method( 'inNamespace' )
			->with( NS_FILE )
			->willReturn( $titleIsFile );

		if ( !$isView ) {
			$this->request->setVal( 'action', 'edit' );
		}

		if ( $isDiff ) {
			$this->request->setVal( 'diff', 'foo' );
		}

		$oasisSkin->setContext( $this->context );

		$result = RecirculationHooks::onBeforePageDisplay( $this->out, $oasisSkin );

		$this->assertTrue( $result );
		$this->assertNotContains( 'ext.wikia.reCirculation', $this->out->getModules() );
	}

	public function provideIncorrectPages() {
		return [
			'viewing nonexistent content page' => [ false, true, false, true, false ],
			'viewing nonexistent file' => [ false, false, true, true, false ],
			'non-view action on existing content page' => [ true, true, false, false, false ],
			'non-view action on existing file' => [ true, false, true, false, false ],
			'diff view on existing content page' => [ true, true, false, true, true ],
			'diff view on existing file page' => [ true, false, true, true, true ],
		];
	}
}
