<?php

class UserProfilePageTest extends WikiaBaseTest {
	const TEST_WIKI_ID = 111;
	const TEST_CAPTION = 'Test caption';

	private $skinOrg;

	public function setUp() {
		$this->setupFile = __DIR__ . '/../UserProfilePage.setup.php';
		parent::setUp();
	}

	/**
	 * @param User $user
	 * @return UserProfilePageController
	 */
	protected function getObjectMock( User $user ) {
		$object = $this->getMock( 'UserProfilePage', array( 'invalidateCache' ), array( F::app(), $user ) );
		return $object;
	}

	protected function setUpMobileSkin( $mobileSkin ) {
		$this->markTestSkipped('Skin RequestContext::setSkin() must be an instance of Skin');

		$this->skinOrg = RequestContext::getMain()->getSkin();
		RequestContext::getMain()->setSkin( $mobileSkin );
	}

	protected function tearDownMobileSkin() {
		RequestContext::getMain()->setSkin( $this->skinOrg );
	}

	public function testWikiaMobileUserProfilePageTemplate() {
		$mobileSkin = Skin::newFromKey( 'wikiamobile' );

		$this->setUpMobileSkin( $mobileSkin );

		$response = $this->app->sendRequest( 'UserProfilePage', 'index', array( 'format' => 'html' ) );
		$response->toString();

		$this->assertEquals(
			dirname( $this->app->wg->AutoloadClasses['UserProfilePageController'] ) . '/templates/UserProfilePage_WikiaMobileIndex.php',
			$response->getView()->getTemplatePath()
		);

		$this->tearDownMobileSkin();
	}
}
