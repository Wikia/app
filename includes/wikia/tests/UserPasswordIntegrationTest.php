<?php

/**
 * @group Integration
 */
class UserPasswordIntegrationTest extends WikiaDatabaseTest
{
	public function testCorrectPassword() {
		$oUser = User::newFromName('CTest50');
		$oResult = $oUser->checkPassword('q');

		$this->assertTrue( $oResult->checkStatus(WikiaResponse::RESPONSE_CODE_OK));
		$this->assertTrue( $oResult->success());
	}
//	$dataProvider = [
//		'correct' => [ 'CTest50', 'q' ],
//		'wrong' => [ 'CTest50', 'p' ],
//		'pwchange' => [ 'user3', 'oldpw', 'newpw' ]
//		];
//
//	$u = User::newFromName( $dataProvider['correct'][0] );
//	$result = $u->checkPassword( $dataProvider['correct'][1] );
//
//		if ( ! $result->checkStatus() ) {
//			// service unavailable
//		}
//
//		if ( ! $result->success() ) {
//			// authentication failed, but expected to succeed
//		}

// test passed

}
