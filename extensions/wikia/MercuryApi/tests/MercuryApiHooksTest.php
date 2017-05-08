<?php

class MercuryApiHooksTest  extends WikiaBaseTest {

	protected function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/MercuryApi/MercuryApi.setup.php";
		parent::setUp();
	}

	public function testOnArticleSaveComplete() {
		$wikiPage = $this->getMock( 'WikiPage', [ 'getId' ], [], '', false );
		$wikiPage->expects( $this->once() )
			->method( 'getId' )
			->will( $this->returnValue( 100 ) );

		$user = $this->getMock( 'User', [ 'isAnon', 'getId' ], [], '', false );
		$user->expects( $this->once() )
			->method( 'isAnon' )
			->will( $this->returnValue( false ) );
		$user->expects( $this->once() )
			->method( 'getId' )
			->will( $this->returnValue( 200 ) );

		$memc = $this->getMock( 'MemcachedPhpBagOStuff', [ 'get', 'set' ], [], '', false );

		$key = wfWikiID() .':MercuryApi:MercuryApi::getTopContributorsKey:100:6';

		$memc->expects( $this->any() )
			->method( 'get' )
			->with( $key )
			->will( $this->returnValue( false ) );

		$this->mockGlobalVariable('Memc', $memc);
		$this->assertTrue( MercuryApiHooks::onArticleSaveComplete( $wikiPage, $user ) );
	}
}
