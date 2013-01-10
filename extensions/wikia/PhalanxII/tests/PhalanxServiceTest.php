<?php

class PhalanxServiceTest extends WikiaBaseTest {

	public function testHTTPService() {
		$service = $this->getMockBuilder( 'PhalanxService' )
			->disableOriginalConstructor()
			->setMethods( array( 'check' ) )
			->getMock();
	}
}
