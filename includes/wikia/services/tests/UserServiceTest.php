<?php
/**
 * Created by adam
 * Date: 09.05.13
 */

class ArticleServiceTest extends WikiaBaseTest {

	/**
	 * @dataProvider idsDataProvider
	 */
	public function testParseIds( $input, $output ) {
		$method = new ReflectionMethod(
			'UserService', 'parseIds'
		);

		$method->setAccessible(TRUE);

		$parsedIds = $method->invoke( new UserService );
		$this->assertEquals( $output, $parsedIds );
	}

	public function idsDataProvider() {
		return array(
			array( array( '1' ), array( 'user_id' => array( '1' ) ) )
		);
	}
}