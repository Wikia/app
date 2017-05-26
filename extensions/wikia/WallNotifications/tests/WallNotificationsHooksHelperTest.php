<?php

use PHPUnit\Framework\TestCase;

class WallNotificationsHooksHelperTest extends TestCase {
	/** @var RequestContext $context */
	private $context;

	/** @var User|PHPUnit_Framework_MockObject_MockObject $userMock */
	private $userMock;

	/** @var OutputPage $out */
	private $out;

	protected function setUp() {
		parent::setUp();

		$this->context = new RequestContext();
		$this->out = $this->context->getOutput();

		$this->userMock = $this->createMock( User::class );
		$this->context->setUser( $this->userMock );
	}

	/**
	 * Test that the Monobook Resource Module is not added if the current skin is not Monobook.
	 *
	 * @dataProvider provideNotMonobookSkins
	 * @param Skin $notMonobook
	 */
	public function testModuleIsNotAddedIfSkinIsNotMonobook( Skin $notMonobook ) {
		$this->userMock->expects( $this->any() )
			->method( 'isLoggedIn' )
			->willReturn( true );

		$notMonobook->setContext( $this->context );

		$result = WallNotificationsHooksHelper::onBeforePageDisplay( $this->out, $notMonobook );

		$this->assertTrue( $result );
		$this->assertNotContains(
			'ext.wikia.wallNotifications.monoBook',
			$this->out->getModules()
		);
	}

	public function provideNotMonobookSkins() {
		$notMonobookSkins = [
			'oasis',
			'wikiamobile',
		];

		foreach ( $notMonobookSkins as $skinName ) {
			yield [ Skin::newFromKey( $skinName ) ];
		}
	}

	/**
	 * Test that the Monobook Resource Module is not added if the current skin is Monobook
	 * but the user is not logged in.
	 *
	 * @dataProvider provideMonoBookSkins
	 * @param Skin $monoBookSkin
	 */
	public function testModuleIsNotAddedIfSkinIsMonobookButUserIsNotLoggedIn( Skin $monoBookSkin ) {
		$this->userMock->expects( $this->any() )
			->method( 'isLoggedIn' )
			->willReturn( false );

		$monoBookSkin->setContext( $this->context );

		$result = WallNotificationsHooksHelper::onBeforePageDisplay( $this->out, $monoBookSkin );

		$this->assertTrue( $result );
		$this->assertNotContains(
			'ext.wikia.wallNotifications.monoBook',
			$this->out->getModules()
		);
	}

	/**
	 * Test that the Monobook Resource Module is added if the current skin is Monobook
	 * and the user is logged in.
	 *
	 * @dataProvider provideMonoBookSkins
	 * @param Skin $monoBookSkin
	 */
	public function testModuleIsAddedIfSkinIsMonobookButUserIsNotLoggedIn( Skin $monoBookSkin ) {
		$this->userMock->expects( $this->any() )
			->method( 'isLoggedIn' )
			->willReturn( true );

		$monoBookSkin->setContext( $this->context );

		$result = WallNotificationsHooksHelper::onBeforePageDisplay( $this->out, $monoBookSkin );

		$this->assertTrue( $result );
		$this->assertContains(
			'ext.wikia.wallNotifications.monoBook',
			$this->out->getModules()
		);
	}

	public function provideMonoBookSkins() {
		$monoBookSkins = [
			'monobook',
			'uncyclopedia',
		];

		foreach ( $monoBookSkins as $skinName ) {
			yield [ Skin::newFromKey( $skinName ) ];
		}
	}
}
