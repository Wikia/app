<?php
/**
 * @package Wikia\extensions\AutoFollow
 * @author Adam Karmiński <adamk@wikia-inc.com>
 */

namespace Wikia\AutoFollow\Test;

use Wikia\AutoFollow\AutoFollowHooks;

class AutoFollowHooksTest extends \WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../AutoFollow.setup.php';
		parent::setUp();

		$this->mockGlobalVariable( 'wgAutoFollowFlag', 'autowatched-already' );
		$this->mockGlobalVariable(
			'wgAutoFollowLangCityIdMap',
			[
				'de' => 1779,
				'en' => 177,
				'es' => 3487,
				'fi' => 3083,
				'fr' => 10261,
				'it' => 11250,
				'ja' => 3439,
				'nl' => 10466,
				'pl' => 1686,
				'pt' => 696403,
				'ru' => 3321,
				'uk' => 3321,
				'zh' => 4079,
			]
		);
	}

	/**
	 * @dataProvider getUsersAllowedLanguages
	 */
	function testAddAutoFollowTask( $sLanguage ) {
		global $wgAutoFollowFlag;

		/**
		 * Mocked User object with necessary options set
		 * @var object User
		 */
		$newUser = new \User();
		$newUser->setGlobalPreference( 'language', $sLanguage );
		$newUser->setGlobalPreference( 'marketingallowed', 1 );
		$newUser->setGlobalFlag( $wgAutoFollowFlag, 0 );

		/**
		 * For the given set of data a task should be queued once
		 */
		$task = $this->getMock( 'Wikia\AutoFollow\AutoFollowTask', ['queue'] );
		$task->expects( $this->once() )
			->method( 'queue' )
			->will( $this->returnValue( true ) );

		$this->mockClass( 'Wikia\AutoFollow\AutoFollowTask', $task );

		$oAutoFollowHooks = new AutoFollowHooks();
		$oAutoFollowHooks->addAutoFollowTask( $newUser );
	}

	function getUsersAllowedLanguages() {
		return [
			['de'],
			['en'],
			['es'],
			['fi'],
			['fr'],
			['it'],
			['ja'],
			['nl'],
			['nl-informal'],
			['pl'],
			['pt'],
			['pt-br'],
			['ru'],
			['uk'],
			['zh'],
			['zh-classical'],
			['zh-cn'],
			['zh-hans'],
			['zh-hant'],
			['zh-hk'],
			['zh-min-nan'],
			['zh-mo'],
			['zh-my'],
			['zh-sg'],
			['zh-tw'],
			['zh-yue'],
		];
	}

	/**
	 * @dataProvider getUsersFaultyOptions
	 */
	function testDoNotAddAutoFollowTask( $sLanguage, $iMarketingAllowed, $iAutoFollowFlag ) {
		global $wgAutoFollowFlag;

		/**
		 * Mocked User object with necessary options set
		 * @var object User
		 */
		$newUser = new \User();
		$newUser->setGlobalPreference( 'language', $sLanguage );
		$newUser->setGlobalPreference( 'marketingallowed', $iMarketingAllowed );
		$newUser->setGlobalFlag( $wgAutoFollowFlag, $iAutoFollowFlag );

		/**
		 * For the given set of data a task shouldn't be queued
		 */
		$task = $this->getMock( 'Wikia\AutoFollow\AutoFollowTask', ['queue'] );
		$task->expects( $this->never() )
			->method( 'queue' );

		$this->mockClass( 'Wikia\AutoFollow\AutoFollowTask', $task );

		$oAutoFollowHooks = new AutoFollowHooks();
		$oAutoFollowHooks->addAutoFollowTask( $newUser );
	}

	function getUsersFaultyOptions() {
		return [
			['en', 0, 0],
			['en', 0, 1],
			['en', 1, 1],
			['xyz', 1, 0],
		];
	}
}
