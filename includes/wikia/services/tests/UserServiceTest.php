<?php
/**
 * Created by adam
 * Date: 09.05.13
 */

class UserServiceTest extends WikiaBaseTest {

	/** Test methods */

	/**
	 * @dataProvider idsDataProvider
	 */
	public function testParseIds( $input, $output ) {

		$parsedIds = $this->invokePrivateMethod( 'UserService', 'parseIds', $input );
		$this->assertEquals( $output, $parsedIds );

	}

	public function testCache() {
		$user = $this->getTestUser();

		//create object here, so we use the same one all the time, that way we can test local cache
		$object = new UserService();

		$cachedLocalUser = $this->invokePrivateMethod( 'UserService', 'getUserFromLocalCacheById', $user->getId(), $object );
		$cachedLocalUserByName = $this->invokePrivateMethod( 'UserService', 'getUserFromLocalCacheByName', $user->getName(), $object );
		//values are not cached localy yet
		$this->assertEquals( false, $cachedLocalUser );
		$this->assertEquals( false, $cachedLocalUserByName );

		//cache user, both locally and mem cached
		$this->invokePrivateMethod( 'UserService', 'cacheUser', $user, $object );

		//do the assertion again, local cache should have hit one
		$cachedLocalUser = $this->invokePrivateMethod( 'UserService', 'getUserFromLocalCacheById', $user->getId(), $object );
		$cachedLocalUserByName = $this->invokePrivateMethod( 'UserService', 'getUserFromLocalCacheByName', $user->getName(), $object );
		$this->assertEquals( $user, $cachedLocalUser );
		$this->assertEquals( $user, $cachedLocalUserByName );

		//check if user was cached in memcache, use new object for that
		$cachedMemCacheById = $this->invokePrivateMethod( 'UserService', 'getUserFromMemCacheById', $user->getId() );
		$cachedMemCacheByName = $this->invokePrivateMethod( 'UserService', 'getUserFromMemCacheByName', $user->getName() );
		$this->assertEquals( $user, $cachedMemCacheById );
		$this->assertEquals( $user, $cachedMemCacheByName );

		//need for deleting form cache test values
		$sharedIdKey = wfSharedMemcKey( "UserCache:".$user->getId() );
		$sharedNameKey = wfSharedMemcKey( "UserCache:".$user->getName() );
		//remove user from memcache
		F::app()->wg->memc->delete( $sharedIdKey );
		F::app()->wg->memc->delete( $sharedNameKey );

		//do assert against memcache again
		$cachedMemCacheById = $this->invokePrivateMethod( 'UserService', 'getUserFromMemCacheById', $user->getId() );
		$cachedMemCacheByName = $this->invokePrivateMethod( 'UserService', 'getUserFromMemCacheByName', $user->getName() );
		$this->assertEquals( false, $cachedMemCacheById );
		$this->assertEquals( false, $cachedMemCacheByName );
	}

	/** Helpers */

	private function getTestUser() {
		$userData = new stdClass();
		$userData->user_id = -1;
		$userData->user_name = 'testUser';
		$userData->user_editcount = 0;
		return User::newFromRow( $userData );
	}

	private function invokePrivateMethod( $class, $method, $params, $object = null ) {
		$method = new ReflectionMethod(
			$class, $method
		);
		$method->setAccessible(TRUE);
		if ( $object !== null ) {
			return $method->invoke( $object, $params );
		}
		return $method->invoke( new $class, $params );
	}

	/** Data providers */

	public function idsDataProvider() {
		return array(
			array( 123 , array( 'user_id' => array( 123 ) ) ),
			array( array( 1 ), array( 'user_id' => array( 1 ) ) ),
			array( array( 1, 'a' ), array( 'user_id' => array( 1 ), 'user_name' => array( 'a' ) ) ),
			array( array( 'a', 'b' ), array( 'user_name' => array( 'a', 'b' ) ) ),
			array( array( 'user_id' => array( 1 ) ), array( 'user_id' => array( 1 ) ) ),
			array( array( 'user_id' => array( 1 ), 'user_name' => array( 'a' ) ), array( 'user_id' => array( 1 ), 'user_name' => array( 'a' ) ) ),
			array( null, array() )
		);
	}
}