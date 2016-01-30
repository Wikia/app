<?php

namespace Wikia\Service\User\Preferences\Migration;

use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use Wikia\Domain\User\Preferences\LocalPreference;
use Wikia\Domain\User\Preferences\UserPreferences;
use Wikia\Service\User\Preferences\PreferenceService;
use Wikia\Util\Statistics\BernoulliTrial;

class PreferenceCorrectionServiceTest extends PHPUnit_Framework_TestCase {

	const USER_ID = 1;
	const WIKI_ID = 123;

	/** @var PHPUnit_Framework_MockObject_MockObject */
	private $preferenceService;

	/** @var PreferenceCorrectionService */
	private $correctionService;

	/** @var UserPreferences */
	private $savedPreferences;

	protected function setUp() {
		$this->preferenceService = $this->getMockBuilder( PreferenceService::class )
			->setMethods( [
				'getPreferences',
				'setPreferences',
				'save',
				'getGlobalPreference',
				'setGlobalPreference',
				'deleteGlobalPreference',
				'getLocalPreference',
				'setLocalPreference',
				'deleteLocalPreference',
				'getGlobalDefault',
				'deleteFromCache',
				'deleteAllPreferences',
				'findWikisWithLocalPreferenceValue',
			] )
			->getMock();
		$this->savedPreferences = ( new UserPreferences() )
			->setGlobalPreference( 'language', 'en' )
			->setGlobalPreference( 'marketingallowed', '1' )
			->setLocalPreference( 'adoptionmails', self::WIKI_ID, '1' );
		$scopeService = new PreferenceScopeService(
			[
				'literals' => [
					'language',
					'marketingallowed',
				],
				'regexes' => [],
			],
			[
				'regexes' => [
					'^adoptionmails-([0-9]+)',
				]
			] );

		$this->correctionService = new PreferenceCorrectionService( $this->preferenceService, $scopeService, new BernoulliTrial( 0 ), true );
	}

	public function testNoDifferences() {
		$this->setupPreferenceServiceExpects();
		$options = $this->userPreferencesToOptions( $this->savedPreferences );

		$differences = $this->correctionService->compareAndCorrect( self::USER_ID, $options );
		$this->assertEquals( 0, $differences );
	}

	public function testMissingPreferences() {
		$options = $this->userPreferencesToOptions( $this->savedPreferences );
		$this->savedPreferences->deleteLocalPreference( 'adoptionmails', self::WIKI_ID );
		$this->savedPreferences->deleteGlobalPreference( 'language' );

		$this->setupPreferenceServiceExpects();
		$differences = $this->correctionService->compareAndCorrect( self::USER_ID, $options );
		$this->assertEquals( 2, $differences );
	}

	public function testExtraPreferences() {
		$options = $this->userPreferencesToOptions( $this->savedPreferences );
		$this->savedPreferences->setGlobalPreference( 'newpref', '1' );
		$this->savedPreferences->setLocalPreference( 'newlocalpref', self::WIKI_ID, '2' );

		$this->setupPreferenceServiceExpects();
		$differences = $this->correctionService->compareAndCorrect( self::USER_ID, $options );
		$this->assertEquals( 2, $differences );
	}

	private function setupPreferenceServiceExpects() {
		$this->preferenceService->expects( $this->once() )
			->method( 'getPreferences' )
			->with( self::USER_ID )
			->willReturn( $this->savedPreferences );
	}

	private function userPreferencesToOptions( UserPreferences $preferences ) {
		$options = [];

		foreach ( $preferences->getGlobalPreferences() as $globalPreference ) {
			$options[$globalPreference->getName()] = $globalPreference->getValue();
		}

		foreach ( $preferences->getLocalPreferences() as $wikiId => $localPreferences ) {
			foreach ( $localPreferences as $localPreference ) {
				/** @var LocalPreference $localPreference */
				$options[$localPreference->getName() . "-" . $localPreference->getWikiId()] = $localPreference->getValue();
			}
		}

		return $options;
	}
}
