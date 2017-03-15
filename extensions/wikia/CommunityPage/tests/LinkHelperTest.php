<?php

class LinkHelperTest extends WikiaBaseTest {
	const ANON = false;
	const LOGGED_IN = true;
	const ANNON_EDITS_ALLOWED = false;
	const ANNOON_EDITS_FORBIDDEN = true;

	const ARTICLE_NAME = 'Test_article';
	const ARTICLE_LOCAL_URL = '/wiki/Test_article';
	const ARTICLE_LOCAL_EDIT_URL = '/wiki/Test_article?veaction=edit';
	const SIGNUP_URL_WITH_EDIT = '/wiki/Special:SignUp?returnto=Test+article&returntoquery=veaction%253Dedit&type=login';
	const SIGNUP_URL_WITHOUT_EDIT = '/wiki/Special:SignUp?returnto=Test+article&type=login';

	protected function setUp() {
		$this->setupFile = __DIR__ . '/../CommunityPage.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider forceLoginLinkTestCases
	 */
	public function testForceLoginLink( $user, $editMode, $disableAnonEdits, $expectedLink ) {
		$title = Title::newFromText('test_article');

		$this->mockGlobalVariable( 'wgDisableAnonymousEditing', $disableAnonEdits );
		$this->mockGlobalVariable( 'wgUser', $user );
		$this->mockGlobalVariable( 'wgVisualEditorNeverPrimary', false );

		$this->assertEquals( $expectedLink, LinkHelper::forceLoginLink( $title, $editMode ) );
	}

	public function forceLoginLinkTestCases() {
		require_once  __DIR__ . '/../helpers/LinkHelper.php';
		
		return [
			[ $this->getUser( static::ANON ), LinkHelper::WITH_EDIT_MODE, static::ANNON_EDITS_ALLOWED, static::ARTICLE_LOCAL_EDIT_URL ],
			[ $this->getUser( static::ANON ), LinkHelper::WITH_EDIT_MODE, static::ANNOON_EDITS_FORBIDDEN, static::SIGNUP_URL_WITH_EDIT ],
			[ $this->getUser( static::ANON ), LinkHelper::WITHOUT_EDIT_MODE, static::ANNON_EDITS_ALLOWED, static::ARTICLE_LOCAL_URL ],
			[ $this->getUser( static::ANON ), LinkHelper::WITHOUT_EDIT_MODE, static::ANNOON_EDITS_FORBIDDEN, static::SIGNUP_URL_WITHOUT_EDIT ],

			[ $this->getUser( static::LOGGED_IN ), LinkHelper::WITH_EDIT_MODE, static::ANNON_EDITS_ALLOWED, static::ARTICLE_LOCAL_EDIT_URL ],
			[ $this->getUser( static::LOGGED_IN ), LinkHelper::WITH_EDIT_MODE, static::ANNOON_EDITS_FORBIDDEN, static::ARTICLE_LOCAL_EDIT_URL ],
			[ $this->getUser( static::LOGGED_IN ), LinkHelper::WITHOUT_EDIT_MODE, static::ANNON_EDITS_ALLOWED, static::ARTICLE_LOCAL_URL ],
			[ $this->getUser( static::LOGGED_IN ), LinkHelper::WITHOUT_EDIT_MODE, static::ANNOON_EDITS_FORBIDDEN, static::ARTICLE_LOCAL_URL ]
		];
	}

	private function getUser( $loggedIn ) {
		$mockUser = $this->getMock( 'User', [ 'isLoggedIn' ] );
		$mockUser->expects( $this->any() )
			->method( 'isLoggedIn' )
			->willReturn( $loggedIn );

		return $mockUser;
	}
}
