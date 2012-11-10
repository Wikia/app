<?php

	class RealgravityVideoHandlerTest extends WikiaBaseTest {
		const TEST_CITY_ID = 79860;

		public function setUp() {
			$this->setupFile = dirname(__FILE__) . '/../VideoHandlers.setup.php';
			parent::setUp();
		}

		protected function setUpMock( $cache_value = false ) {
			$mock_cache = $this->getMock( 'stdClass', array('set', 'delete', 'get') );
			$mock_cache->expects( $this->any() )
						->method( 'set' );
			$mock_cache->expects( $this->any() )
						->method( 'delete' );
			$mock_cache->expects( $this->any() )
						->method( 'get' )
						->will( $this->returnValue($cache_value) );

			$this->mockGlobalVariable( 'wgMemc', $mock_cache );
			$this->mockGlobalVariable( 'wgCityId', self::TEST_CITY_ID );

			$this->mockApp();
		}

		/**
		 * compare embed code from API and VideoHandler
		 * please contact video team if test is failed
		 */
		public function testEmbedCode() {
			// setup
			$this->setUpMock();

			// test
			$url = 'http://api.realgravity.com/v1/widgets/single.json?video_id=124624&player_id=2538&api_key='.$this->app->wg->RealgravityApiKey;
			$req = MWHttpRequest::factory( $url );
			$status = $req->execute();
			if( $status->isOK() ) {
				$response = $req->getContent();
				$response = json_decode( $response, true );
				if ( empty($response['widgets']['flash']) ) {
					$response_data = '';					
				} else {
					$response_data = trim( preg_replace( '/\n( )*/', '', $response['widgets']['flash'] ) );
				}
			} else {
				$response_data = false;
			}

			$exp_data = <<<EOT
<object id="rg_player_c85a31a4-b327-4b28-b75a-903c4bfecc1c" name="rg_player_c85a31a4-b327-4b28-b75a-903c4bfecc1c" type="application/x-shockwave-flash"
width="300" height="280" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" style="visibility: visible;">
<param name="movie" value="http://anomaly.realgravity.com/flash/player.swf"></param>
<param name="allowScriptAccess" value="always"></param>
<param name="allowNetworking" value="all"></param>
<param name="menu" value="false"></param>
<param name="wmode" value="transparent"></param>
<param name="allowFullScreen" value="true"></param>
<param name="flashvars" value="config=http://mediacast.realgravity.com/vs/2/players/single/c85a31a4-b327-4b28-b75a-903c4bfecc1c/1db01d457bd064c26d48e9d64c35425100f3.xml"></param>
<!--[if !IE]>-->
<embed id="c85a31a4-b327-4b28-b75a-903c4bfecc1c" name="c85a31a4-b327-4b28-b75a-903c4bfecc1c" width="300" height="280"
allowNetworking="all" allowScriptAccess="always" allowFullScreen="true" wmode="transparent"
flashvars="config=http://mediacast.realgravity.com/vs/2/players/single/c85a31a4-b327-4b28-b75a-903c4bfecc1c/1db01d457bd064c26d48e9d64c35425100f3.xml"
src="http://anomaly.realgravity.com/flash/player.swf"></embed>
<!--<![endif]-->
</object>
EOT;
			$exp_data = trim( str_replace( "\n", "", $exp_data ) );

			$this->assertEquals( $exp_data, $response_data );
		}
	}
