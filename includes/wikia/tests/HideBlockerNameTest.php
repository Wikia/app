<?php

/**
 * @group Integration
 */
class HideBlockerNameTest extends WikiaDatabaseTest {
	/**
	 * Check if user group should be shown instead of name based on blocker's permissions
	 * @param int $userId
	 * @param bool $shouldHideBlockerName Whether to hide the name and show user group instead
	 * @covers       Block::shouldHideBlockerName()
	 * @dataProvider hideBlockerNameDataProvider
	 */
	public function testHideBlockerName(
		int $userId, bool $shouldHideBlockerName
	) {
		$blockingUser = User::newFromId( $userId );

		$block = new Block();
		$block->setBlocker( $blockingUser );
		$this->assertEquals( $shouldHideBlockerName, $block->shouldHideBlockerName() );
	}

	public function hideBlockerNameDataProvider() {
		yield 'user name hidden for staff' => [ 1, true ];
		yield 'user name hidden for helpers' => [ 2, true ];
		yield 'user name hidden for soap' => [ 3, true ];
		yield 'user name shown for sysops' => [ 4, false ];
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/_fixtures/hide_blocker_name.yaml' );
	}
}
