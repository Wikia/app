<?php

namespace Wikia\Service\User\Preferences;

use Doctrine\Common\Cache\CacheProvider;
use Doctrine\Common\Cache\VoidCache;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use Wikia\Domain\User\Preferences\UserPreferences;
use Wikia\Persistence\User\Preferences\PreferencePersistence;
use Wikia\Service\PersistenceException;

class PreferenceServiceImplTest extends PHPUnit_Framework_TestCase {
	const TEST_WIKI_ID = 123;

	/** @var int */
	protected $userId = 1;

	/** @var UserPreferences */
	protected $savedPreferences;

	/** @var PHPUnit_Framework_MockObject_MockObject */
	protected $persistence;

	/** @var CacheProvider */
	protected $cache;

	protected function setUp() {
		$this->userId = 1;
		$this->savedPreferences = new UserPreferences();
		$this->savedPreferences
			->setGlobalPreference( 'language', 'en' )
			->setGlobalPreference( 'marketingallowed', '1' )
			->setLocalPreference( 'wiki-pref', self::TEST_WIKI_ID, '0' );
		$this->cache = new VoidCache();
		$this->persistence = $this->getMockBuilder( PreferencePersistence::class )
			->setMethods( [
				'save',
				'get',
				'deleteAll',
				'findWikisWithLocalPreferenceValue',
				'findUsersWithGlobalPreferenceValue'
			] )
			->disableOriginalConstructor()
			->getMock();
	}

	public function testGetFromDefault() {
		$defaultPreferences = ( new UserPreferences() )
			->setGlobalPreference( 'pref1', 'val1' );
		$preferences = new PreferenceServiceImpl( $this->cache, $this->persistence, $defaultPreferences, [], [] );

		$this->assertEquals( "val1", $preferences->getGlobalDefault( "pref1" ) );
		$this->assertNull( $preferences->getGlobalDefault( "pref2" ) );
	}

	public function testGetAnon() {
		$defaultPreferences = ( new UserPreferences() )
			->setGlobalPreference( 'pref1', 'val1' );
		$preferences = new PreferenceServiceImpl( $this->cache, $this->persistence, $defaultPreferences, [], [] );
		$this->assertEquals( 'val1', $preferences->getPreferences( 0 )->getGlobalPreference( 'pref1' ) );
	}

	public function testGet() {
		$this->setupServiceExpects();
		$preferences = new PreferenceServiceImpl( $this->cache, $this->persistence, new UserPreferences(), [], [] );

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
		$preferences = new PreferenceServiceImpl( $this->cache, $this->persistence, new UserPreferences(), ['marketingallowed'], [] );
		$this->assertEquals( "1", $preferences->getGlobalPreference( $this->userId, "marketingallowed", null, true ) );
		$this->assertNull( $preferences->getGlobalPreference( $this->userId, "marketingallowed" ) );
	}

	public function testGetWithHiddenAndDefaults() {
		$this->setupServiceExpects();
		$defaultPreferences = ( new UserPreferences() )
			->setGlobalPreference( 'marketingallowed', '0' );
		$preferences = new PreferenceServiceImpl( $this->cache, $this->persistence, $defaultPreferences, ["marketingallowed"], [] );
		$this->assertEquals( "1", $preferences->getGlobalPreference( $this->userId, "marketingallowed", null, true ) );
		$this->assertEquals( "0", $preferences->getGlobalPreference( $this->userId, "marketingallowed" ) );
		$this->assertNull( $preferences->getGlobalPreference( $this->userId, "unsetpreference" ) );
	}

	public function testSet() {
		$this->setupServiceExpects();
		$preferences = new PreferenceServiceImpl( $this->cache, $this->persistence, new UserPreferences(), [], [] );
		$preferences->setGlobalPreference( $this->userId, "newpreference", "foo" );
		$this->assertEquals( "foo", $preferences->getGlobalPreference( $this->userId, "newpreference" ) );
	}

	public function testSetNullWithDefault() {
		$this->setupServiceExpects();
		$defaultPreferences = ( new UserPreferences() )
			->setGlobalPreference( 'newpreference', 'foo' );
		$preferences = new PreferenceServiceImpl( $this->cache, $this->persistence, $defaultPreferences, [], [] );
		$preferences->setGlobalPreference( $this->userId, "newpreference", null );
		$this->assertEquals( "foo", $preferences->getPreferences( $this->userId )->getGlobalPreference( "newpreference" ) );
	}

	public function testSetNullWithoutDefault() {
		$this->setupServiceExpects();
		$preferences = new PreferenceServiceImpl( $this->cache, $this->persistence, new UserPreferences(), [], [] );
		$preferences->setGlobalPreference( $this->userId, "newpreference", null );
		$this->assertNull( $preferences->getPreferences( $this->userId )->getGlobalPreference( "newpreference" ) );
	}

	public function testDelete() {
		$preferences = new PreferenceServiceImpl( $this->cache, $this->persistence, new UserPreferences(), [], [] );

		$this->persistence->expects( $this->any() )
			->method( 'get' )
			->with( $this->userId )
			->willReturnCallback( function() {
				return new UserPreferences();
			} );
		$this->persistence->expects( $this->once() )
			->method( "deleteAll" )
			->with( $this->userId )
			->willReturn( true );

		$preferences->setGlobalPreference( $this->userId, "newpreference", "1" );
		$this->assertNotNull( $preferences->getGlobalPreference( $this->userId, "newpreference" ) );
		$preferences->deleteAllPreferences( $this->userId );
		$this->assertNull( $preferences->getGlobalPreference( $this->userId, "newpreference" ) );
	}

	public function testFindWikisWithLocalPreferenceValue() {
		$wikiList = ['1', '2', '3'];
		$preferences = new PreferenceServiceImpl( $this->cache, $this->persistence, new UserPreferences(), [], [] );

		$this->persistence->expects( $this->once() )
			->method( 'findWikisWithLocalPreferenceValue' )
			->with( 'test-preference', '1' )
			->willReturn( $wikiList );

		$list = $preferences->findWikisWithLocalPreferenceValue( 'test-preference', '1' );
		$this->assertEquals( $wikiList, $list );
	}

	public function testGetWithPersistenceExceptionReturnsReadOnly() {
		$preferences = new PreferenceServiceImpl( $this->cache, $this->persistence, new UserPreferences(), [], [] );

		$this->persistence->expects( $this->once() )
			->method( 'get' )
			->with( $this->userId )
			->will( $this->throwException( new PersistenceException ) );

		$prefs = $preferences->getPreferences( $this->userId );
		$this->assertTrue( $prefs->isReadOnly() );
	}

	public function testSaveShortCircuit() {
		$preferences = new PreferenceServiceImpl( $this->cache, $this->persistence, new UserPreferences(), [], [] );

		$this->persistence->expects( $this->exactly( 1 ) )
			->method( 'get' )
			->with( $this->userId )
			->will( $this->throwException( new PersistenceException ) );

		$this->persistence->expects( $this->never() )
			->method( 'save' )
			->with( $this->userId, $this->isInstanceOf( UserPreferences::class ) );

		$preferences->setGlobalPreference( $this->userId, "newpreference", "1" );
		$prefs = $preferences->getPreferences( $this->userId );
		$this->assertTrue( $prefs->isReadOnly() );
		$this->assertFalse( $preferences->save( $this->userId ) );
	}

	public function testDeleteAllShortCircuit() {
		$preferences = new PreferenceServiceImpl( $this->cache, $this->persistence, new UserPreferences(), [], [] );

		$this->persistence->expects( $this->exactly( 1 ) )
			->method( 'get' )
			->with( $this->userId )
			->will( $this->throwException( new PersistenceException ) );

		$this->persistence->expects( $this->never() )
			->method( 'deleteAll' )
			->with( $this->userId );

		$this->assertFalse( $preferences->deleteAllPreferences( $this->userId ) );
	}

	protected function setupServiceExpects() {
		$this->persistence->expects( $this->once() )
			->method( "get" )
			->with( $this->userId )
			->willReturn( $this->savedPreferences );
	}
}
