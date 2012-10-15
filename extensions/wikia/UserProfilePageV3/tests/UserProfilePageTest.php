<?php
require_once dirname(__FILE__) . '/../UserProfilePage.setup.php';

class UserProfilePageTest extends WikiaBaseTest {
	const TEST_WIKI_ID = 111;
	const TEST_CAPTION = 'Test caption';


	/**
	 * @param User $user
	 * @return UserProfilePage
	 */
	protected function getObjectMock( User $user ) {
		$object = $this->getMock( 'UserProfilePage', array( 'invalidateCache' ), array( F::app(), $user ) );
		return $object;
	}

	protected function setUpMobileSkin( $mobileSkin ) {
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