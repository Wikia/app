<?php

	/**
	 * Realgravity test
	 *
	 * @category Wikia
	 * @group Integration
	 */
	class RealgravityVideoHandlerTest extends WikiaBaseTest {

		public function setUp() {
			$this->setupFile = dirname(__FILE__) . '/../VideoHandlers.setup.php';
			parent::setUp();
		}

		/**
		 * compare embed code from API and VideoHandler
		 * please contact video team if test is failed
		 * @group Broken
		 */
		public function testEmbedCode() {
			// test
			$url = 'http://api.realgravity.com/v1/widgets/single.json?video_id=124624&player_id=733&api_key='.$this->app->wg->RealgravityApiKey;
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
<object id="rg_player_ac330d90-cb46-012e-f91c-12313d18e962" name="rg_player_ac330d90-cb46-012e-f91c-12313d18e962" type="application/x-shockwave-flash"
width="660" height="360" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" style="visibility: visible;">
<param name="movie" value="http://anomaly.realgravity.com/flash/player.swf"></param>
<param name="allowScriptAccess" value="always"></param>
<param name="allowNetworking" value="all"></param>
<param name="menu" value="false"></param>
<param name="wmode" value="transparent"></param>
<param name="allowFullScreen" value="true"></param>
<param name="flashvars" value="config=http://mediacast.realgravity.com/vs/2/players/single/ac330d90-cb46-012e-f91c-12313d18e962/1db01d457bd064c26d48e9d64c35425100f3.xml"></param>
<!--[if !IE]>-->
<embed id="ac330d90-cb46-012e-f91c-12313d18e962" name="ac330d90-cb46-012e-f91c-12313d18e962" width="660" height="360"
allowNetworking="all" allowScriptAccess="always" allowFullScreen="true" wmode="transparent"
flashvars="config=http://mediacast.realgravity.com/vs/2/players/single/ac330d90-cb46-012e-f91c-12313d18e962/1db01d457bd064c26d48e9d64c35425100f3.xml"
src="http://anomaly.realgravity.com/flash/player.swf"></embed>
<!--<![endif]-->
</object>
EOT;
			$exp_data = trim( str_replace( "\n", "", $exp_data ) );

			$this->assertEquals( $exp_data, $response_data );
		}
	}
