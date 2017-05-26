<?php

class RailControllerTest extends WikiaBaseTest {
	/** @var OutputPage $out */
	private $out;

	protected function setUp() {
		parent::setUp();
		require_once  __DIR__ . '/../RailController.class.php';

		$this->out = ( new RequestContext() )->getOutput();
	}

	/**
	 * Test that the Rail JS is added to the page if the page uses the Oasis skin.
	 */
	public function testModuleIsAddedToOutputIfSkinIsOasis() {
		$skinOasis = new SkinOasis();

		$result = RailController::onBeforePageDisplay( $this->out, $skinOasis );

		$this->assertTrue( $result );
		$this->assertContains( 'ext.wikia.rail', $this->out->getModules() );
	}

	/**
	 * Test that the Rail JS is not added to the page if the page does not use the Oasis skin.
	 *
	 * @dataProvider provideNotOasisSkins
	 * @param Skin $notOasisSkin
	 */
	public function testModuleIsNotAddedToOutputIfSkinIsNotOasis( Skin $notOasisSkin ) {
		$result = RailController::onBeforePageDisplay( $this->out, $notOasisSkin );

		$this->assertTrue( $result );
		$this->assertNotContains( 'ext.wikia.rail', $this->out->getModules() );
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
}
