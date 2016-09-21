<?php

namespace Wikia\Persistence\User\Preferences;

use Swagger\Client\ApiException;
use Swagger\Client\User\Preferences\Api\ReverseLookupApi;
use Swagger\Client\User\Preferences\Api\UserPreferencesApi;
use Swagger\Client\User\Preferences\Models\GlobalPreference as SwaggerGlobalPref;
use Swagger\Client\User\Preferences\Models\LocalPreference as SwaggerLocalPref;
use Swagger\Client\User\Preferences\Models\UserPreferences as SwaggerUserPreferences;
use Wikia\Domain\User\Preferences\GlobalPreference;
use Wikia\Domain\User\Preferences\LocalPreference;
use Wikia\Domain\User\Preferences\UserPreferences;
use Wikia\Service\Swagger\ApiProvider;
use Wikia\Service\UnauthorizedException;

class PreferencePersistenceSwaggerServiceTest extends \PHPUnit_Framework_TestCase {

	protected $userId = 1;

	/** @var PreferencePersistenceSwaggerService */
	protected $persistence;

	/** @var \PHPUnit_Framework_MockObject_MockObject */
	protected $apiProvider;

	/** @var \PHPUnit_Framework_MockObject_MockObject */
	protected $userPreferencesApi;

	/** @var \PHPUnit_Framework_MockObject_MockObject */
	protected $reverseLookupApi;

	public function setUp() {
		$this->apiProvider = $this->getMockBuilder( ApiProvider::class )
			->setMethods( ['getAuthenticatedApi', 'getApi' ] )
			->disableOriginalConstructor()
			->getMock();
		$this->userPreferencesApi = $this->getMockBuilder( UserPreferencesApi::class )
			->setMethods( ['setUserPreferences', 'getUserPreferences', 'deleteUserPreferences'] )
			->disableOriginalConstructor()
			->getMock();
		$this->reverseLookupApi = $this->getMockBuilder( ReverseLookupApi::class )
			->setMethods( ['findWikisWithLocalPreference' ] )
			->disableOriginalConstructor()
			->getMock();
		$this->apiProvider->expects( $this->any() )
			->method( 'getAuthenticatedApi' )
			->with( PreferencePersistenceSwaggerService::SERVICE_NAME, $this->userId, UserPreferencesApi::class )
			->willReturn( $this->userPreferencesApi );
		$this->apiProvider->expects( $this->any() )
			->method( 'getApi' )
			->with( PreferencePersistenceSwaggerService::SERVICE_NAME, ReverseLookupApi::class )
			->willReturn( $this->reverseLookupApi );

		$this->persistence = new PreferencePersistenceSwaggerService( $this->apiProvider );
	}

	public function testGetSuccess() {
		$preferences = ( new SwaggerUserPreferences() )
			->setLocalPreferences( [
				( new SwaggerLocalPref() )->setName( 'localpref' )->setWikiId( 123 )->setValue( 'val1' ),
			] )
			->setGlobalPreferences( [
				( new SwaggerGlobalPref() )->setName( 'pref1' )->setValue( 'val1' ),
				( new SwaggerGlobalPref() )->setName( 'pref2' )->setValue( 'val2' ),
			] );

		$this->userPreferencesApi->expects( $this->once() )
			->method( 'getUserPreferences' )
			->with( $this->userId )
			->willReturn( $preferences );

		$prefs = $this->persistence->get( $this->userId );

		$this->assertFalse( $prefs->isEmpty() );
		$this->assertEquals(
			$prefs->getGlobalPreference( 'pref1' ),
			( new GlobalPreference( 'pref1', 'val1' ) )->getValue() );
		$this->assertEquals(
			$prefs->getGlobalPreference( 'pref2' ),
			( new GlobalPreference( 'pref2', 'val2' ) )->getValue() );
		$this->assertEquals(
			$prefs->getLocalPreference( 'localpref', 123 ),
			( new LocalPreference( 'localpref', 'val1', 123 ) )->getValue() );
	}

	public function testGetEmpty() {
		$this->userPreferencesApi->expects( $this->once() )
			->method( 'getUserPreferences' )
			->with( $this->userId )
			->willReturn( new SwaggerUserPreferences() );

		$prefs = $this->persistence->get( $this->userId );

		$this->assertTrue( $prefs->isEmpty() );
	}

	public function testSave() {
		$swaggerPrefs = ( new SwaggerUserPreferences() )
			->setGlobalPreferences( [
				( new SwaggerGlobalPref() )->setName( 'pref1' )->setValue( 'val1' )
			] )
			->setLocalPreferences( [] );
		$domainPrefs = ( new UserPreferences() )
			->setGlobalPreference( 'pref1', 'val1' );

		$this->userPreferencesApi->expects( $this->once() )
			->method( 'setUserPreferences' )
			->with( $this->userId, $swaggerPrefs )
			->willReturn( true );

		$this->assertTrue( $this->persistence->save( $this->userId, $domainPrefs ) );
	}

	/**
	 * @expectedException \Wikia\Service\UnauthorizedException
	 */
	public function testUnauthorizedSave() {
		$swaggerPrefs = ( new SwaggerUserPreferences() )
			->setGlobalPreferences( [
				( new SwaggerGlobalPref() )->setName( 'pref1' )->setValue( 'val1' )
			] )
			->setLocalPreferences( [] );
		$domainPrefs = ( new UserPreferences() )
			->setGlobalPreference( 'pref1', 'val1' );

		$this->userPreferencesApi->expects( $this->once() )
			->method( 'setUserPreferences' )
			->with( $this->userId, $swaggerPrefs )
			->willThrowException( new ApiException( "", UnauthorizedException::CODE ) );

		$this->persistence->save( $this->userId, $domainPrefs );
	}

	/**
	 * @expectedException \Wikia\Service\PersistenceException
	 */
	public function testSaveError() {
		$swaggerPrefs = ( new SwaggerUserPreferences() )
			->setGlobalPreferences( [
				( new SwaggerGlobalPref() )->setName( 'pref1' )->setValue( 'val1' )
			] )
			->setLocalPreferences( [] );
		$domainPrefs = ( new UserPreferences() )
			->setGlobalPreference( 'pref1', 'val1' );

		$this->userPreferencesApi->expects( $this->once() )
			->method( 'setUserPreferences' )
			->with( $this->userId, $swaggerPrefs )
			->willThrowException( new ApiException( "", 500 ) );

		$this->persistence->save( $this->userId, $domainPrefs );
	}

	/**
	 * @expectedException \Wikia\Service\UnauthorizedException
	 */
	public function testUnauthorizedGet() {
		$this->userPreferencesApi->expects( $this->once() )
			->method( 'getUserPreferences' )
			->with( $this->userId )
			->willThrowException( new ApiException( "", UnauthorizedException::CODE ) );
		$this->persistence->get( $this->userId );
	}

	/**
	 * @expectedException \Wikia\Service\PersistenceException
	 */
	public function testGetError() {
		$this->userPreferencesApi->expects( $this->once() )
			->method( 'getUserPreferences' )
			->with( $this->userId )
			->willThrowException( new ApiException( "", 500 ) );
		$this->persistence->get( $this->userId );
	}

	public function testDeleteAll() {
		$this->userPreferencesApi->expects( $this->once() )
			->method( 'deleteUserPreferences' )
			->with( $this->userId );
		$this->persistence->deleteAll( $this->userId );
	}

	/**
	 * @expectedException \Wikia\Service\PersistenceException
	 */
	public function testDeleteAllException() {
		$this->userPreferencesApi->expects( $this->once() )
			->method( 'deleteUserPreferences' )
			->with( $this->userId )
			->willThrowException( new ApiException( "", 503 ) );
		$this->persistence->deleteAll( $this->userId );
	}

	/**
	 * @expectedException \Wikia\Service\UnauthorizedException
	 */
	public function testDeleteUnauthorized() {
		$this->userPreferencesApi->expects( $this->once() )
			->method( 'deleteUserPreferences' )
			->with( $this->userId )
			->willThrowException( new ApiException( "", UnauthorizedException::CODE ) );
		$this->persistence->deleteAll( $this->userId );
	}
}
