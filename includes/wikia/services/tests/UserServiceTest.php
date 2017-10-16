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

	/** Helpers */

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
