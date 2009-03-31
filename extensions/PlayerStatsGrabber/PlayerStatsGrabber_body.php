<?php
/* hanndles acutal output of special stats page */
if ( !defined( 'MEDIAWIKI' ) ) die();

class SpecialPlayerStatsGrabber extends SpecialPage {
	var $action = '';
	function SpecialPlayerStatsGrabber() {
		SpecialPage::SpecialPage( "PlayerStatsGrabber" );
		wfLoadExtensionMessages( 'PlayerStatsGrabber' );
	}
	// used for page title
	function getDescription() {
		switch( $this->req_param ) {
			case 'Survey':
				return wfMsg( 'ps_take_video_survey' );
			break;
			case '':
			default:
				return wfMsg( 'playerstatsgrabber' );
			break;
		}
	}
	function execute( $par ) {
		global $wgRequest, $wgOut;
		$this->req_param = $par;
		// print $wgRequest->getText( 'param' );
		// set the header:
		$this->setHeaders();
		 
		// do the page:
		switch( $this->req_param ) {
			case 'Survey':
				// check if
				$this->do_survey_forum();
			break;
			case '':default:
				if ( $wgRequest->getVal( 'action' ) == 'submit' ) {
					$this->do_submit_survey();
				} else if ( $wgRequest->getVal( 'action' ) == 'survey' ) {
					$this->do_survey_forum();
				} else {
					$this->do_stats_page();
				}
			break;
		}
	}
	function do_stats_page() {
		global $wgOut, $wgRequest, $wgTitle;
		$wgOut->addWikiText( wfMsg( 'ps_stats_welcome_link' ) );
	}
	function do_survey_forum() {
		global $wgOut, $psEmbedAry, $wgTitle, $wgUser, $wgEnableParserCache, $wgParser, $wgScript;
		$wgOut->addHTML ( wfMsg( 'ps_survey_description' ) );
		 
		// select the embed ary element:
		$tw = 0;
		foreach ( $psEmbedAry as $embed ) {
			$tw += $embed['weight'];
		}
		$selected_val = rand( 1, $tw );
		$tw = 0;
		foreach ( $psEmbedAry as $embed ) {
			$tw += $embed['weight'];
			if ( $tw >= $selected_val ) {
				break;
			}
		}
		$embed_code = '';
		if ( isset( $embed['html_code'] ) ) {
			// run the stats (if not internal oggPlay)
			$this->runJS_Stats( $embed['url'] );
			$embed_code = $embed['html_code'];
		} else if ( isset( $embed['wiki_code'] ) ) {
			$popts = new ParserOptions;
			$parserOutput = $wgParser->parse( $embed['wiki_code'], $wgTitle, $popts );
			$embed_code = $parserOutput->getText();
		}
		// print "EMBED C: $embed_code \n";
		// $q = 'action='.$this->action;
		# if ( "no" == $redirect ) { $q .= "&redirect=no"; }
		// $action = $wgScript.'?title='.$wgTitle->getDBKey() . '/Thanks';
		$action = $wgTitle->getLocalURL( 'action=submit' );
		$jsUserHash = sha1( $wgUser->getName() . $wgProxyKey );
		$enUserHash = Xml::encodeJsVar( $jsUserHash );
		// work with "embed"
		$embed_key = $embed['embed_key'];
		$userToken = htmlspecialchars( $wgUser->editToken() );
		
		// output table with flash and or video embed:
		$wgOut->addHTML( <<<EOT
		<p>
		<table>
		<tr>
		<td valign="top">
		$embed_code
		</td>
		<td valign="top">
		<form id="ps_editform" name="ps_editform" method="post" action="{$action}" enctype="multipart/form-data">
		<input type="hidden" name="wpEditToken" value="{$userToken}">
		<input type="hidden" name="uh" value={$enUserHash}>
		<input type="hidden" name="embed_key" value="{$embed_key}">
EOT
		);
		// output questions:
		$wgOut->addHTML( wfMsg( 'ps_could_play' ) );
		// yes no with expand
		$wgOut->addHTML( '<br><input type="radio" name="ps_could_play"  value="yes"
				onclick="document.getElementById(\'ps_could_not_play\').style.display = \'none\';">' .
		wfMsg( 'ps_play_yes' ) . '<br>
				<input type="radio" name="ps_could_play"  value="no" 
				onclick="document.getElementById(\'ps_could_not_play\').style.display = \'inline\';">' .
		wfMsg( 'ps_play_no' ) . '<p>
	<div id="ps_could_not_play" style="display:none;">
		' . wfMsg( 'ps_problem_checkoff' ) . '
		 <table border="0" cellspacing="0" cellpadding="0">
           	<tr>
           	  <td><input type="checkbox" name="ps_no_video" value="1"></td>
              <td>' . wfMsg( 'ps_no_video' ) . ' </td>             
            </tr>
            <tr>
            <tr>
              <td><input type="checkbox" name="ps_jumpy_playback" value="1"></td>
              <td>' . wfMsg( 'ps_jumpy_playback' ) . ' </td>              
            </tr>
            <tr> 
              <td><input type="checkbox" name="ps_bad_sync" value="1"></td>
              <td>' . wfMsg( 'ps_bad_sync' ) . ' </td>             
            </tr>           
			<tr>
			  <td><input type="checkbox" name="ps_no_sound" value="1"></td>
              <td>' . wfMsg( 'ps_no_sound' ) . '</td>              
            </tr>
          </table>		
          ' . wfMsg( 'ps_problems_desc' ) . '<br><textarea name="ps_problems_desc" rows="2" cols="40" MAXLENGTH="300"></textarea><br>        
	</div>
	' . wfMsg( 'ps_would_install' ) . '<br>' .
	'<input type="radio" name="ps_would_install"  value="yes">' . wfMsg( 'ps_yes_install' ) . '<br>' .
	'<input type="radio" name="ps_would_install"  value="no">' . wfMsg( 'ps_no_install' ) . '<br>'
		);
		// if ie output switch check:
		if ( preg_match( '|MSIE ([0-9].[0-9]{1,2})|', $_SERVER['HTTP_USER_AGENT'], $matched ) ) {
			$wgOut->addHTML( '<br>' .
			wfMsg( 'ps_would_switch' ) . '<br>' .
		 '<input type="radio" name="ps_would_switch"  value="yes">' . wfMsg( 'ps_yes_switch' ) . '<br>' .
		 '<input type="radio" name="ps_would_switch"  value="no">' . wfMsg( 'ps_no_install' ) . '<br>'
		 );
		}
		$wgOut->addHTML( '<br>' .	wfMsg( 'ps_your_email' ) . '<br>' .
		'<input type="text" name="ps_your_email"  size="30" maxlength="200"><p>' .
		wfMsg( 'ps_privacy' ) . '<br>' .
		'<input type="submit" value="' . wfMsg( 'ps_submit_survey' ) . '">'
		);

		$wgOut->addHTML( '
		</form>
	</td>
</tr>
</table>' );
	}
	function do_submit_player_log() {
		global $wgRequest, $psLogEveryPlayRequestPerUser;
		// do the insert into the userPlayerStats table:
		$dbr =& wfGetDB( DB_READ );	
		if ( !isset( $wgRequest->data['cs'] ) || !is_array( $wgRequest->data['cs'] ) ) {
			$wgRequest->data['cs'] = array();
		}
		// set up insert array:
		$insAry = array(
				'user_hash'			=> $wgRequest->getVal( 'uh' ),
				'file_url'			=> $wgRequest->getVal( 'purl' ),
				'b_user_agent'		=> $wgRequest->getVal( 'b_user_agent' ),
				//'b_name'			=> $wgRequest->getVal( 'b_name' ),
				//'b_version'			=> $wgRequest->getVal( 'b_version' ),
				//'b_os'				=> $wgRequest->getVal( 'b_os' ),
				'flash_version'		=> $wgRequest->getVal( 'fv' ),
				'java_version'		=> $wgRequest->getVal( 'jv' ),
				'html5_video_enabled' => ( in_array( 'videoElement',  $wgRequest->data['cs'] ) ) ? true:false,
				'java_enabled'		=> ( in_array( 'cortado', $wgRequest->data['cs'] ) ) ? true:false,
				'totem_enabled'		=> ( in_array( 'totem', $wgRequest->data['cs'] ) ) ? true:false,
				'flash_enabled'		=> ( in_array( 'flash', $wgRequest->data['cs'] ) ) ? true:false,
				'quicktime_enabled'	=> ( in_array( array( 'quicktime-mozilla', 'quicktime-activex' ),
		$wgRequest->data['cs'] )
		) ? true:false,
				'vlc_enabled'		=> ( in_array( array( 'vlc-mozilla', 'vlc-activex' ),
		$wgRequest->data['cs'] )
		) ? true:false,
				'mplayer_enabled'	=> ( in_array( 'mplayerplug-in',
		$wgRequest->data['cs'] )
		) ? true:false
		);
		// check for user hash (don't collect multiple times for the same user)
		// $user_hash =
		$insert_id = $dbr->selectField( 'player_stats_log', 'id',
		array(	'user_hash' => $wgRequest->getVal( 'uh' ) ),
								'do_submit_player_log::Select User Hash' );
		// if the user_hash is not already in the db or if we are logging every request do INSERT		
		if ( !$insert_id || $psLogEveryPlayRequestPerUser ) {
			$dbw =& wfGetDB( DB_WRITE );
			$dbw->insert( 'player_stats_log', $insAry, 'mw_push_player_stats::Insert' );
			$insert_id = $dbw->insertId();
			$dbw->commit();
		}
		header( 'Content-Type: text/javascript' );
		if( $wgRequest->getVal( 'cb' )!=null ){
			return htmlspecialchars( $wgRequest->getVal( 'cb' ) ) . '(' . PhpArrayToJsObject_Recurse(
					array(
							'cb_inx' => htmlspecialchars( $wgRequest->getVal( 'cb_inx' ) ),
							'id' => htmlspecialchars( $insert_id )
					)
					) . ');';
		}else{
			return htmlspecialchars ( $insert_id );
		}
	}
	function do_submit_survey() {
		global $wgRequest, $wgOut, $wgUser, $psAllowMultipleSurveysPerUser;
		// print_r($wgRequest);
		// make sure its a valid token
		$token = $wgRequest->getVal( 'wpEditToken' );
		if ( !$wgUser->matchEditToken( $token ) ) {
			$wgOut->addHTML ( wfMsg( 'token_suffix_mismatch' ) );
			return false;
		}
		
		// print "NO VIDEO: "
		$dbr =& wfGetDB( DB_READ );
		$insAry = array(
	            'user_hash'			=> $wgRequest->getVal( 'uh' ),
				'embed_key'			=> $wgRequest->getVal( 'embed_key' ),
				'player_stats_log_id' => $wgRequest->getVal( 'player_stats_log_id' ),
					           
	        	'ps_jumpy_playback' => ( $wgRequest->getVal( 'ps_jumpy_playback' ) == '' ) ? 0:1,
	            'ps_no_video' 		=> ( $wgRequest->getVal( 'ps_no_video' ) == '' ) ? 0:1,
	            'ps_bad_sync' 		=> ( $wgRequest->getVal( 'ps_bad_sync' ) == '' ) ? 0:1,
	            'ps_no_sound' 		=> ( $wgRequest->getVal( 'ps_no_sound' ) == '' ) ? 0:1,

	        	'ps_your_email'		=> htmlspecialchars( $wgRequest->getVal( 'ps_your_email' ) ),
	        	'ps_problems_desc'	=> htmlspecialchars( $wgRequest->getVal( 'ps_problems_desc' ) )
		);
		// leave NULL if un-answered for all yes no questions: :
		if ( $wgRequest->getVal( 'ps_could_play' ) != '' )
			$insAry['ps_could_play'] = ( $wgRequest->getVal( 'ps_could_play' ) == 'yes' ) ? 1:0;
		
		if ( $wgRequest->getVal( 'ps_would_install' ) != '' )
			$insAry['ps_would_install'] = ( $wgRequest->getVal( 'ps_would_install' ) == 'yes' ) ? 1:0;
			
		if ( $wgRequest->getVal( 'ps_would_switch' ) != '' )
			$insAry['ps_would_switch'] = ( $wgRequest->getVal( 'ps_would_switch' ) == 'yes' ) ? 1:0;

		$user_id = $dbr->selectField( 'player_stats_survey', 'id',
		array(	'user_hash' => $wgRequest->getVal( 'uh' ) ),
								'do_submit_survey::Select User Hash' );

		if ( !$user_id || $psAllowMultipleSurveysPerUser ) {
			$dbw =& wfGetDB( DB_WRITE );
			$dbw->insert( 'player_stats_survey', $insAry, 'do_submit_survey::Insert' );
			$insert_id = $dbw->insertId();
			$dbw->commit();
		}
		if ( $user_id && !$psAllowMultipleSurveysPerUser ) {
			$wgOut->addHTML( wfMsg( 'ps_only_one_survey_pp' ) );
		} else {
			// return thank you page:
			$wgOut->addHTML( wfMsg( 'ps_thanks' ) );
		}
	}
	/* to run the stats in cases where we are not using oggHanndler to play*/
	function runJS_Stats( $vid_url='' ) {
		global $wgOut, $wgScriptPath, $wgUser , $wgProxyKey;
		$scriptPath = OggHandler::getMyScriptPath();
		// include the javascript and do the stats
		$jsUserHash = sha1( $wgUser->getName() . $wgProxyKey );			
		$wgOut->addHTML( '
		<script type="text/javascript" src="'. htmlspecialchars( $scriptPath ) .'/OggPlayer.js"></script>
		<script type="text/javascript" src="'. htmlspecialchars( $wgScriptPath ) . '/extensions/PlayerStatsGrabber/playerStats.js"></script>
        	<script type="text/javascript">
        		wgOggPlayer.userHash = '.  Xml::encodeJsVar( $jsUserHash ) .';        		
        		wgOggPlayer.videoUrl='. Xml::encodeJsVar( $vid_url ) . ';
        		wgOggPlayer.doStats();
        	</script>'
		);
	}
}

?>
