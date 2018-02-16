<?php

use Wikia\Factory\ServiceFactory;
use \Wikia\Service\User\Permissions\PermissionsService;

class HideBlockerNameTest extends WikiaBaseTest  {
	/**
	 * Back up original Injector instance
	 */
	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();
	}

	/**
	 * Check if user group should be shown instead of name based on blocker's permissions
	 * @param array $groups User groups of the user who made the block
	 * @param bool $shouldHideBlockerName Whether to hide the name and show user group instead
	 * @param string $expectedTextInBlockNotice Text to show in block notice instead of username if blocker name should be hidden, otherwise empty string
	 * @covers Block::getGroupNameForHiddenBlocker()
	 * @covers Block::shouldHideBlockerName()
	 * @dataProvider hideBlockerNameDataProvider
	 */
	public function testHideBlockerName( array $groups, $shouldHideBlockerName, $expectedTextInBlockNotice ) {
		$this->markTestIncomplete( 'This test will be refactored in an already open PR' );
	}

	/**
	 * @return array user groups, whether to hide user name, and expected group name message
	 */
	public function hideBlockerNameDataProvider() {
		return [
			'user name hidden for staff' => [ [ 'staff' ], true, wfMessage( 'group-staff' )->plain() ],
			'user name hidden for helpers' => [ [ 'helper' ], true, wfMessage( 'group-helper' )->plain() ],
			'user name hidden for vstf' => [ [ 'vstf' ], true, wfMessage( 'group-vstf' )->plain() ],
			'user name shown for sysops' => [ [ 'sysop' ], false, '' ],
		];
	}

	public static function tearDownAfterClass() {
		parent::tearDownAfterClass();

		ServiceFactory::clearState();
	}
}
