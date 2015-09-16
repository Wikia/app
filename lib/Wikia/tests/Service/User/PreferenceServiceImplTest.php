<?php

namespace Wikia\Service\User\Preferences;

use Doctrine\Common\Cache\CacheProvider;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use Wikia\Domain\User\Preferences\UserPreferences;
use Wikia\Persistence\User\Preferences\PreferencePersistence;

class PreferenceServiceImplTest extends PHPUnit_Framework_TestCase {
	const TEST_WIKI_ID = 123;

	/** @var int */
	protected $userId = 1;

	/** @var UserPreferences */
	protected $savedPreferences;

	/** @var PHPUnit_Framework_MockObject_MockObject */
	protected $persistence;

	/** @var PHPUnit_Framework_MockObject_MockObject */
	protected $cache;

	protected function setUp() {
		$this->userId = 1;
		$this->savedPreferences = new UserPreferences();
		$this->savedPreferences
			->setGlobalPreference( 'language', 'en' )
			->setGlobalPreference( 'marketingallowed', '1' )
			->setLocalPreference( 'wiki-pref', self::TEST_WIKI_ID, '0' );
		$this->cache = $this->getMockBuilder( CacheProvider::class )
			->setMethods( ['doFetch', 'doContains', 'doSave', 'doFlush', 'doDelete', 'doGetStats'] )
			->disableOriginalConstructor()
			->getMock();
		$this->persistence = $this->getMockBuilder( PreferencePersistence::class )
			->setMethods( ['save', 'get'] )
			->disableOriginalConstructor()
			->getMock();

		$this->cache->expects( $this->any() )
			->method( 'doFetch' )
			->with( $this->anything() )
			->willReturn( false );
	}

	public function testGetFromDefault() {
		$defaultPrefs = ["pref1" => "val1"];
		$preferences = new PreferenceServiceImpl( $this->cache, $this->persistence, [], $defaultPrefs, [] );

		$this->assertEquals( "val1", $preferences->getGlobalDefault( "pref1" ) );
		$this->assertNull( $preferences->getGlobalDefault( "pref2" ) );
	}

	public function testGet() {
		$this->setupServiceExpects();
		$preferences = new PreferenceServiceImpl( $this->cache, $this->persistence, [], [], [] );

		$this->assertEquals( "en", $preferences->getGlobalPreference( $this->userId, "language" ) );
		$this->assertEquals( "1", $preferences->getGlobalPreference( $this->userId, "marketingallowed" ) );
		$this->assertEquals( "0", $preferences->getLocalPreference( $this->userId, self::TEST_WIKI_ID, "wiki-pref" ) );
		$this->assertNull( $preferences->getGlobalPreference( $this->userId, "unsetpreference" ) );
		$this->assertNull( $preferences->getLocalPreference( $this->userId, self::TEST_WIKI_ID, "unsetpreference" ) );
		$this->assertEquals( "foo", $preferences->getGlobalPreference( $this->userId, "unsetpreference", "foo" ) );
		$this->assertEquals( "foo", $preferences->getLocalPreference( $this->userId, self::TEST_WIKI_ID, "unsetpreference", "foo" ) );
		$this->assertEquals( $this->savedPreferences, $preferences->getPreferences( $this->userId ) );
	}

	public function testGetWithHiddenNoDefaults() {
		$this->setupServiceExpects();
		$preferences = new PreferenceServiceImpl( $this->cache, $this->persistence, ["marketingallowed"], [], [] );
		$this->assertEquals( "1", $preferences->getGlobalPreference( $this->userId, "marketingallowed", null, true ) );
		$this->assertNull( $preferences->getGlobalPreference( $this->userId, "marketingallowed" ) );
	}

	public function testGetWithHiddenAndDefaults() {
		$this->setupServiceExpects();
		$preferences = new PreferenceServiceImpl( $this->cache, $this->persistence, ["marketingallowed"], ["marketingallowed" => "0"], [] );
		$this->assertEquals( "1", $preferences->getGlobalPreference( $this->userId, "marketingallowed", null, true ) );
		$this->assertEquals( "0", $preferences->getGlobalPreference( $this->userId, "marketingallowed" ) );
		$this->assertNull( $preferences->getGlobalPreference( $this->userId, "unsetpreference" ) );
	}

	public function testSet() {
		$this->setupServiceExpects();
		$preferences = new PreferenceServiceImpl( $this->cache, $this->persistence, [], [], [] );
		$preferences->setGlobalPreference( $this->userId, "newpreference", "foo" );
		$this->assertEquals( "foo", $preferences->getGlobalPreference( $this->userId, "newpreference" ) );
	}

	public function testSetNullWithDefault() {
		$this->setupServiceExpects();
		$preferences = new PreferenceServiceImpl( $this->cache, $this->persistence, [], ["newpreference" => "foo"], [] );
		$preferences->setGlobalPreference( $this->userId, "newpreference", null );
		$this->assertEquals( "foo", $preferences->getPreferences( $this->userId )->getGlobalPreference( "newpreference" ) );
	}

	public function testSetNullWithoutDefault() {
		$this->setupServiceExpects();
		$preferences = new PreferenceServiceImpl( $this->cache, $this->persistence, [], [], [] );
		$preferences->setGlobalPreference( $this->userId, "newpreference", null );
		$this->assertNull( $preferences->getPreferences( $this->userId )->getGlobalPreference( "newpreference" ) );
	}

	protected function setupServiceExpects() {
		$this->persistence->expects( $this->once() )
			->method( "get" )
			->with( $this->userId )
			->willReturn( $this->savedPreferences );
	}
}
