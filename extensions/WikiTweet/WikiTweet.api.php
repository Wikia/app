<?php
/**
 * Created on May 05, 2011
 *
 * WikiTweet extension
 *
 * Copyright (C) 2011 faure dot thomas at gmail dot com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */
/**
 * Query module to get the list of the Categories beginning by a given string.
 *
 * @ingroup API
 * @ingroup Extensions
 */
class ApiQueryWikiTweet extends ApiQueryBase {
	/**
	 * Construct function
	 */
	 public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'wtw' );
	}

	/**
	 * Main function which executes the asked request
	 *
	 * @author Thomas Fauré <faure.thomas@gmail.com>
	 * @global OBJECT $wgUser
	 */
	public function execute() {
		global $wgUser;
		$params = $this->extractRequestParams();
		$req = $params['req'];
		$result = $this->getResult();
		switch($req){
			case 'get':
				$rows       = $params['rows'] ;
				$room       = $params['room'] ;
				$user       = $params['user'] ;
				$size       = (isset($params['size']))       ? $params['size']       : 'normal' ;
				$tag        = (isset($params['tag']))        ? $params['tag']        : ''       ;
				$other_room = (isset($params['other_room'])) ? $params['other_room'] : ''       ;
				$getbstatus = (isset($params['bstatus'])) ? $params['bstatus'] : 1        ;
				
				$o__output = ApiQueryWikiTweet::fnGetTweetsAjax($rows,$room,$user,$size,$tag,$other_room,$getbstatus);
				$o__output_string = $o__output[0];
				$o__output_twids = $o__output[1];
				$fit = $result-> addValue( array( 'query', $this->getModuleName() ), null, $o__output_string );
				foreach($o__output_twids as $twid){
					$fit2 = $result->addValue( array( 'query', 'twids' ), null, $twid );
				}
				$result->setIndexedTagName_internal( array( 'query', $this->getModuleName() ), 'output' );
				$result->setIndexedTagName_internal( array( 'query', 'twids'), 'twid' );
				break;
			case 'getchilds':
				$twid       = $params['id'] ;
				$o__output_string = ApiQueryWikiTweet::fnGetChildsTweetsAjax($twid);
				$fit = $result->addValue( array( 'query', $this->getModuleName() ), null, $o__output_string );
				$result->setIndexedTagName_internal( array( 'query', $this->getModuleName() ), 'output' );
				break;
			case 'delete':
				// TODO : user rights
				$id = (isset($params['id'])) ? $params['id'] : -1 ;
				if ( $id == -1 ) $this->dieUsage( 'You must enter a parameter "id" with "delete" option.', 'params' );
				ApiQueryWikiTweet::fnDelTweetAjax($id);
				break;
			case 'update':
				$status  = $params['status']  ;
				$user    = $params['user']    ;
				$room    = $params['room']    ;
				$tomail  = $params['tomail']  ;
				$bstatus = $params['bstatus'] ;
				$parent  = (isset($params['parentid'])) ? $params['parentid'] : 0 ;
				$o__output_string = ApiQueryWikiTweet::fnUpdateTweetAjax ( $status, $user, $room, $tomail, $bstatus, $parent );
				$fit = $result->addValue( array( 'query', $this->getModuleName() ), null, $o__output_string );
				$result->setIndexedTagName_internal( array( 'query', $this->getModuleName() ), 'output' );
				break;
			case 'subscribe':
				$type = (isset($params['type'])) ? $params['type'] : '' ;
				$link = (isset($params['link'])) ? $params['link'] : '' ;
				$user = (isset($params['user'])) ? $params['user'] : '' ;
				$o__output_string = ApiQueryWikiTweet::fnSubscribeAjax($link, $user, $type);
				$fit = $result->addValue( array( 'query', $this->getModuleName() ), null, $o__output_string );
				$result->setIndexedTagName_internal( array( 'query', $this->getModuleName() ), 'output' );
				break;
			case 'unsubscribe':
				$type = (isset($params['type'])) ? $params['type'] : '' ;
				$link = (isset($params['link'])) ? $params['link'] : '' ;
				$user = (isset($params['user'])) ? $params['user'] : '' ;
				$o__output_string = ApiQueryWikiTweet::fnUnsubscribeAjax($link, $user, $type);
				$fit = $result->addValue( array( 'query', $this->getModuleName() ), null, $o__output_string );
				$result->setIndexedTagName_internal( array( 'query', $this->getModuleName() ), 'output' );
				break;
			case 'resolve':
				$id = (isset($params['id'])) ? $params['id'] : -1 ;
				if ( $id == -1 ) $this->dieUsage( 'You must enter a parameter "id" with "resolve" option.', 'params' );
				ApiQueryWikiTweet::fnResolveTweetAjax($id);
				break;
			default:
				break;
		}
	}
	/**
	 * Get wikitweets timeline
	 *
	 * @author Thomas Fauré <faure.thomas@gmail.com>
	 * @param string $rows
	 * @param string $room
	 * @param string $user
	 * @param string $size
	 * @param string $tag
	 * @param string $other_room
	 * @param int $getbstatus
	 * @return array
	 * @global string $wgDBprefix
	 * @global string $wgScriptPath
	 * @global string $wgLanguageCode
	 */
	public static function fnGetTweetsAjax($rows,$room,$user,$size='normal',$tag='',$other_room='',$getbstatus=1)
	{
		global $wgDBprefix , $wgScriptPath , $wgLanguageCode;
		include('WikiTweet.config.php');
		
		$width = "88%";
		
		$line_height       = $wgWikiTweet['size'][$size]['line_height'];
		$font_size         = $wgWikiTweet['size'][$size]['font_size'];
		$avatar_size       = $wgWikiTweet['size'][$size]['avatar_size'];
		$span_avatar_width = $wgWikiTweet['size'][$size]['span_avatar_width'];
		$paddingli         = $wgWikiTweet['size'][$size]['paddingli'];
		$margin_left       = $wgWikiTweet['size'][$size]['margin_left'];

		$child_line_height       = $wgWikiTweet['size'][$size]['child_line_height'];
		$child_font_size         = $wgWikiTweet['size'][$size]['child_font_size'];
		$child_avatar_size       = $wgWikiTweet['size'][$size]['child_avatar_size'];
		$child_span_avatar_width = $wgWikiTweet['size'][$size]['child_span_avatar_width'];
		$child_paddingli         = $wgWikiTweet['size'][$size]['child_paddingli'];
		$child_margin_left       = $wgWikiTweet['size'][$size]['child_margin_left'];
		
		$text = ($size=='mobile') ? '' : "<ol style = '	list-style-image: none;
					list-style-position: outside;
					list-style-type: none;
					margin-left:$margin_left;'>";
		//$text .= WikiTweetFunctions::getParentsRooms('REL.1.1');
		$dbr =& wfGetDB( DB_SLAVE );

		$datetemp = date('d/m/y H');
		$res = $dbr->select('wikitweet_alerts','*',"`date` = '$datetemp'");
		if ($dbr->numRows($res) == 0){
			$res = $dbr->select('wikitweet','*',"status=2 AND `show`=1");
			$attentionsnbr = $dbr->numRows($res);
			$res = $dbr->select('wikitweet','*',"status=3 AND `show`=1");
			$alertsnbr = $dbr->numRows($res);
			$dbr->insert('wikitweet_alerts',array(
				'`id`'        => ''             ,
				'`date`'      => $datetemp      ,
				'`timestamp`' => time()         ,
				'`attention`' => $attentionsnbr ,
				'`alert`'     => $alertsnbr
			));
			$sql = "SELECT COUNT(w.`id`) as `countid`,w.`status`,r.`responsible` FROM ".$dbr->tableName('wikitweet')." w, ".$dbr->tableName('wikitweet_responsibles')." r WHERE w.`room`=r.`ref` AND w.`show`=1 AND w.`status`>1 GROUP BY r.`responsible`,w.`status`;";
			$res = $dbr->query( $sql, __METHOD__ );
			$results = array();
			while( $row = $dbr->fetchObject( $res ) )
			{
				$l__countid = $row->countid;
				$l__status = $row->status;
				$l__responsible = $row->responsible;
				if(isset($results[$l__responsible])){
					$results[$l__responsible]["count".$l__status] = $l__countid;
				}
				else{
					$results[$l__responsible] = array("count".$l__status=>$l__countid);
				}
				if(count($results[$l__responsible])==2){
					$attentionsnbr = $results[$l__responsible]["count2"];
					$alertsnbr     = $results[$l__responsible]["count3"];
					$dbr->insert('wikitweet_alerts_persons',array(
						'`id`'        => ''             ,
						'`date`'      => $datetemp      ,
						'`timestamp`' => time()         ,
						'`attention`' => $attentionsnbr ,
						'`alert`'     => $alertsnbr     ,
						'`username`'  => $l__responsible
					));
				}
			}
		}

		
		$sql_rooms = ($room == '' or $room == 'main') ? "`room`='' OR `room`='main'" : "`room`='$room'";
		$res1 = $dbr->select( 'wikitweet_subscription' , '*' , "user='" . mysql_real_escape_string( $user ) . "' " );
		$sql_subscriptions = "";
		if($wgWikiTweet['showsubscriptions']==1)
		{
			while($row1 = $dbr->fetchObject($res1))
			{
				$link = $row1->link;
				$type = $row1->type;
				$sql_subscriptions .= " OR `$type`='$link'";
			}
		}
		$roomssons = array();
		foreach($wgWikiTweet['inherit'] as $roominherit=>$roominheritvalue)
		{
			if($roominherit == $room or in_array($roominherit,$roomssons))
			{
				foreach($wgWikiTweet['inherit'][$roominherit] as $roomson)
				{
					$sql_subscriptions .= " OR `room`='$roomson'";
					$roomssons[] = $roomson;
				}
			}
		}

		if($tag!=''){
			$res = $dbr->select( 
				'wikitweet' , 
				'*' , 
				"(`text` like '%$tag%' AND (`show`=1 OR (`show`=2 AND (`text` like '%@$user%' OR `user`='$user')))) AND `parent`=0",
				__METHOD__ ,
				array("ORDER BY" =>" `lastupdatedate`,`date` DESC", "LIMIT" => $rows));
			$text .= "<h2>".wfMsg ( 'wikitweet-tweets-tagged' ) ." <a>#$tag</a></h2>";
			$text .= "<p><a class='handmouse timeline'>".wfMsg('wikitweet-back-timeline')."...</a></p>";
		}
		elseif($other_room!=''){
			$res = $dbr->select( 
				'wikitweet' , 
				'*' , 
				"`room`='($other_room' AND (`show`=1 OR (`show`=2 AND (`text` like '%@$user%' OR `user`='$user'))))  AND `parent`=0",
				__METHOD__ ,
				array("ORDER BY" =>" `lastupdatedate`,`date` DESC", "LIMIT" => $rows));
			$text .= "<h2>".wfMsg('wikitweet-tweets-from-room')." \"<a>$other_room</a>\"</h2>";
			$text .= "<p><a class='handmouse timeline'>".wfMsg('wikitweet-back-timeline')."...</a></p>";

		}
		else{
			$getbstatusstring = ($getbstatus>1) ? ( ($getbstatus>2) ? '`status`=2':'`status`>=2' ) :'1=0' ;
			$res = $dbr->select( 
				'wikitweet' , 
				'*' , 
				"((($sql_rooms $sql_subscriptions )AND (`show`=1 OR (`show`=2 AND (`text` like '%@$user%' OR `user`='$user')))) OR ($getbstatusstring AND `show`=1)) AND `parent`=0",
				__METHOD__ ,
				array("ORDER BY" =>" `lastupdatedate` DESC", "LIMIT" => $rows));
		}
		$o__twids = array();
		while( $row = $dbr->fetchObject( $res ) )
		{
			// Pull out the fields
			$id         = $row->id;
			$twext      = $row->text;
			$tweetuser  = str_replace(' ','_',mysql_real_escape_string($row->user));
			$date       = $row->date;
			$tweet_room = $row->room;
			$show       = $row->show;
			$bstatus    = $row->status;
			$background_color = "#FFF";
			$viaroom    = "";
			$private    = "";
			if ( $tweet_room != $room ) {
				$background_color = "#EFEFEF";
				$tweetroom_title = (isset($wgWikiTweet['titles'][$tweet_room])) ? $tweet_room.' - '.$wgWikiTweet['titles'][$tweet_room] : $tweet_room;
				$viaroom = ($wgWikiTweet['roomlink'] == '') ? "- ".wfMsg('wikitweet-viaroom')." <a class='handmouse room' value='$tweet_room'>$tweetroom_title</a> " : "- ".wfMsg('wikitweet-viaroom')." <a class='handmouse' href='$wgScriptPath/index.php/{$wgWikiTweet['roomlink']}$tweet_room' target='_blank'>$tweetroom_title</a> ";
				$viaroom = ($size=='mobile') ? "- ".wfMsg('wikitweet-viaroom')." $tweetroom_title " : $viaroom;
			}
			if ( $show == 2 ) {
				$background_color = "#C6DEFE";
				$private = "<img src='$wgScriptPath/extensions/WikiTweet/images/lock-small.png' />";
			}
			
			//$date_to_display = WikiTweetFunctions::Convert_Date(strtotime($dateSrc));
			$date_to_display = date(($wgWikiTweet['dateformat']=='') ? 'H:i, F jS' : $wgWikiTweet['dateformat'],strtotime($date));
			
			$res2 = $dbr->select('wikitweet_avatar','avatar',"`user`='".mysql_real_escape_string($tweetuser)."' ",__METHOD__,false);
			$row2 = $dbr->fetchObject ( $res2 );
			$avatar = (count($row2)>0) ? $row2->avatar : '';
			
			$conversion_tab = ($size=='mobile') ? array(
				"/http(\S*)/is" => "<a href='http$1' target='_blank'>http$1</a>",
				"/ www(\S*)/is" => " <a href='http://www$1' target='_blank'>www$1</a>",
				"/\n/is" => "<br/>",
				"/%u2019/is" => "'",
				"/%u20AC/is" => "€"
				) :
				array(
				"/\>(\S*)/is"   => "><a href='$wgScriptPath/index.php/$1'>$1</a>",
				"/\@(\S*)/is"   => "@<a href='$wgScriptPath/index.php/User:$1'>$1</a>",
				"/\#(\S*)/is"   => "<a class='handmouse tag' value='$1'>#$1</a>",
				"/http(\S*)/is" => "<a href='http$1' target='_blank'>http$1</a>",
				"/ www(\S*)/is" => " <a href='http://www$1' target='_blank'>www$1</a>",
				"/\n/is" => "<br/>",
				"/%u2019/is" => "'",
				"/%u20AC/is" => "€"
				);
			$resusers = $dbr->select( 
				'user' , 
				'*' , 
				'',
				__METHOD__ ,
				array());
			
			while( $rowuser = $dbr->fetchObject( $resusers ) )
			{
				$twext = str_replace("@".$rowuser->user_name,"@".str_replace(' ','_',$rowuser->user_name),$twext);
			}


			$twext = preg_replace(array_keys($conversion_tab), array_values($conversion_tab), $twext);
			$user_subscribe_text = "";
			$unsubscribe_string  = wfMsg('wikitweet-unsubscribe');
			$subscribe_string    = wfMsg('wikitweet-subscribe');
			$delete_string       = wfMsg('wikitweet-delete');
			$answer_string       = wfMsg('wikitweet-answer');
			$tweetuserclas       = str_replace(".","__dot__",$tweetuser);
			$delete_tweet        = "";
			$answer              = "";
			$comment             = "<span class='spancomment' parent_id='$id' style='cursor:pointer;'>".wfMsg('wikitweet-comment')."</span>";
			if($tweetuser!=$user){
				$form_user = "<form style='display:none;'><input type=hidden value='$tweetuser' name='tweetuser' /></form>";
				$user_subscribe_text = "- <a class='handmouse user_subscribe subscribe$tweetuserclas' id='user_subscribe' style='color:#999;display:none;'>$subscribe_string<span id='tweetuser' style='display:none'>$tweetuser</span>$form_user</a><a style='color:#999;' class='handmouse user_unsubscribe unsubscribe$tweetuserclas'>$unsubscribe_string<span id='tweetuser' style='display:none'>$tweetuser</span>$form_user</a>";
				$res3 = $dbr->select('wikitweet_subscription','*',array(
					"`user`='".mysql_real_escape_string($user)."' ",
					"`link`='".mysql_real_escape_string($tweetuser)."' ",
					"`type`='user'",
					));
				if ( $dbr->numRows($res3) == 0 ) { 
					$user_subscribe_text = "- <a style='color:#999;' class='handmouse user_subscribe subscribe$tweetuserclas'>$subscribe_string<span id='tweetuser' style='display:none'>$tweetuser</span>$form_user</a><a class='handmouse user_unsubscribe unsubscribe$tweetuserclas' style='color:#999;display:none;'>$unsubscribe_string<span id='tweetuser' style='display:none'>$tweetuser</span>$form_user</a>";
				}
				$answer = "- <span class='answer' style='cursor:pointer;'><img src='$wgScriptPath/extensions/WikiTweet/images/answer.png'/> $answer_string $tweetuser</span>";
			}
			if((in_array($user, $wgWikiTweet['informers']) and $tweetuser == $wgWikiTweet['informuser']) or $tweetuser==$user or in_array($user, $wgWikiTweet['admin'])){
				$delete_tweet = " - <a class='handmouse delete_tweet' style='color:#999;'>$delete_string<span style='display:none'>$id</span></a>";
			}
			$imagestatus = "<img src='$wgScriptPath/extensions/WikiTweet/images/";
			$imagestatus .= ( $bstatus > 0 ) ? (( $bstatus > 1 ) ? (($bstatus>2) ? "exclamation-red.png": "exclamation-octagon.png") : 'information-button.png') : 'balloon.png';
			$imagestatus .= "'/> ";
			// if($bstatus==0){$imagestatus='';}
			$resolveit = ($bstatus > 1 ) ? "- <a style='color:#999;' class='handmouse tresolve' tweetid='$id'>".wfMsg('wikitweet-resolve')."</a>" : '';
			array_push($o__twids,"$id");
			if($size=='mobile')
			{
				$imagestatus = ( $bstatus > 1 ) ? (($bstatus>2) ? "<img src='/mediawiki/extensions/WikiTweet/images/exclamation-red.png' class='ui-li-icon'/> ": "<img src='/mediawiki/extensions/WikiTweet/images/exclamation-octagon.png' class='ui-li-icon'/> ") : '';
				$themestatus = ( $bstatus == 3 ) ? ' data-theme="e"' : '';

				$reschild = $dbr->select( 
					'wikitweet' , 
					'count(*) as `countchild`' , 
					"`show`=1 AND `parent`=$id",
					__METHOD__ ,
					array());
				$arraycountchild = $dbr->fetchObject( $reschild );
				$commentscount = $arraycountchild->countchild;
				
				$text .= "<li$themestatus>";
				$text .= "<a href='#comment$id'>";
				$text .= "$imagestatus
				<p  style='white-space:normal!important;'><strong>@$tweetuser</strong> : $twext</p>
				<p>$date_to_display $viaroom></p>";
				$text .= "<span class='ui-li-count'>$commentscount</span></a>
			</li>
			";
			}
			else
			{
				$text .= "<li class='tweet_li bstatus$bstatus' id='$id' user='$tweetuser' style='
					line-height: $line_height;
					padding: $paddingli;
					background-color:$background_color;'>
							<span class='span-a' style='height:$span_avatar_width;width:$span_avatar_width;'>
								<a href='$wgScriptPath/index.php/User:$tweetuser'>
								<img src= '$avatar' width=$avatar_size height=$avatar_size alt='$tweetuser' border=0/>
								</a>
							</span>
							<span class='span-b' style = '
											min-height: ".$avatar_size."px;
											width:$width ;
											line-height: $line_height;
											font-size:$font_size;
											'>
								
								<span style = '	line-height: $line_height;
												font-size:$font_size;'>
									<b>
										<a href='$wgScriptPath/index.php/User:$tweetuser' class='tweetuser'>$tweetuser</a>
									</b>
									$imagestatus
									$twext<br/>
									<small style='color:#999;'>$date_to_display $viaroom <span id='id_user_subscribe'>$user_subscribe_text</span><span id='tempimg2'></span>$delete_tweet $resolveit $private $answer - $comment - $id</small>
								</span>
							</span>";


				$text .= "<div class='childs' parent_id='{$id}'>";
				$reschild = $dbr->select( 
					'wikitweet' , 
					'*' , 
					"`show`=1 AND `parent`=$id",
					__METHOD__ ,
					array("ORDER BY" =>" `date` ASC"));
				$l__childs = array();
				$text .= "<ol style = 'margin-left:$child_margin_left;' class='childsul'>";
				$l__countchild = 0;
				while( $rowchild = $dbr->fetchObject( $reschild ) )
				{
					$l__countchild+=1;
					$idchild         = $rowchild->id;
					$twextchild      = $rowchild->text;
					$tweetuserchild  = str_replace(' ','_',mysql_real_escape_string($rowchild->user));
					$datechild       = $rowchild->date;

					$twextchild = preg_replace(array_keys($conversion_tab), array_values($conversion_tab), $twextchild);
					$date_to_displaychild = date(($wgWikiTweet['dateformat']=='') ? 'H:i, F jS' : $wgWikiTweet['dateformat'], strtotime($datechild));

					if((in_array($user, $wgWikiTweet['informers']) and $tweetuser == $wgWikiTweet['informuser']) or $tweetuser==$user or $tweetuserchild==$user or in_array($user, $wgWikiTweet['admin'])){
						$delete_tweetchild = " - <a class='handmouse delete_tweet' style='color:#999;'>$delete_string<span style='display:none'>$idchild</span></a>";
					}

					$res2c = $dbr->select('wikitweet_avatar','avatar',"`user`='".mysql_real_escape_string($tweetuserchild)."' ",__METHOD__,false);
					$row2c = $dbr->fetchObject ( $res2c );
					$avatarchild = (count($row2c)>0) ? $row2c->avatar : '';
					
					$text .= "
						<li class='tweet_li_child bstatus0' id='{$idchild}' user='{$tweetuserchild}' style='
							line-height: $child_line_height;
							padding: $child_paddingli;'>
							<span class='span-a' style='height:$child_span_avatar_width;width:$child_span_avatar_width;'>
								<a href='$wgScriptPath/index.php/User:$tweetuserchild'>
								<img src= '$avatarchild' width=$child_avatar_size height=$child_avatar_size alt='$tweetuserchild' border=0/>
								</a>
							</span>
							<span class='span-b' style = '
											min-height: ".$child_avatar_size."px;
											line-height: $child_line_height;
											font-size:$child_font_size;
											'>
								
								<span style = '	line-height: $child_line_height;
												font-size:$child_font_size;'>
									<b>
										<a href='$wgScriptPath/index.php/User:$tweetuserchild' class='tweetuser'>$tweetuserchild</a>
									</b>
									$twextchild<br/>
									<small style='color:#999;'>$date_to_displaychild $delete_tweetchild</small>
								</span>
							</span>
						</li>";

				}
				$text .= "</ol>";

				if($l__countchild>0)
				{
					$text .= "$comment";
				}

				$text .= "	<div class='childssharezone' parent_id='{$id}' style='display:none;'>";
				$text .= "		<textarea type='text' name='childscomment' class='childstextarea' parent_id='$id'></textarea>
								<div class='underchildstextarea' parent_id='{$id}'>
									<img src='images/ajax-loader.gif' class='childajaxloader' style='display:none;'/>
									<button class='childsharer' parent_id='{$id}' uniqueid=''>".'Partager'."</button>
								</div><!--div class='underchildstextarea'-->";
				$text .= "	</div>";
				$text .= "</div>";
				$text .="</li>";
			}
		}
		$text .= ($size=='mobile') ? '' : '<script type="text/javascript" src="'.$wgScriptPath.'/extensions/WikiTweet/WikiTweet2.js"></script>';
		$text .= ($size=='mobile') ? '' : "</ol>";

		return array($text,$o__twids);
	}
	/**
	 * Get childs wikitweets of a given wikitweet timeline
	 *
	 * @author Thomas Fauré <faure.thomas@gmail.com>
	 * @param string $twid parent wikitweet ID
	 * @return array
	 * @global string $wgDBprefix
	 * @global string $wgScriptPath
	 * @global string $wgLanguageCode
	 */
	public static function fnGetChildsTweetsAjax($twid)
	{
		global $wgDBprefix , $wgScriptPath , $wgLanguageCode;
		include('WikiTweet.config.php');
		
		
		$dbr =& wfGetDB( DB_SLAVE );
		$res = $dbr->select( 
			'wikitweet' , 
			'*' , 
			"`show`=1 AND `parent`='$twid'",
			__METHOD__ ,
			array("ORDER BY" =>" `date` ASC", "LIMIT" => $rows));
		
		
		while( $row = $dbr->fetchObject( $res ) )
		{
			// Pull out the fields
			$id         = $row->id;
			$twext      = $row->text;
			$tweetuser  = str_replace(' ','_',mysql_real_escape_string($row->user));
			$date       = $row->date;
			$tweet_room = $row->room;
			$show       = $row->show;
			
			$date_to_display = date(($wgWikiTweet['dateformat']=='') ? 'H:i, F jS' : $wgWikiTweet['dateformat'],strtotime($date));
			
			$res2 = $dbr->select('wikitweet_avatar','avatar',"`user`='".mysql_real_escape_string($tweetuser)."' ",__METHOD__,false);
			$row2 = $dbr->fetchObject ( $res2 );
			$avatar = (count($row2)>0) ? $row2->avatar : '';
			
			$conversion_tab = array(
				"/http(\S*)/is" => "<a href='http$1' target='_blank'>http$1</a>",
				"/ www(\S*)/is" => " <a href='http://www$1' target='_blank'>www$1</a>",
				"/\n/is" => "<br/>",
				"/%u2019/is" => "'",
				"/%u20AC/is" => "€"
				);
			$resusers = $dbr->select( 
				'user' , 
				'*' , 
				'',
				__METHOD__ ,
				array());
			
			while( $rowuser = $dbr->fetchObject( $resusers ) )
			{
				$twext = str_replace("@".$rowuser->user_name,"@".str_replace(' ','_',$rowuser->user_name),$twext);
			}


			$twext = preg_replace(array_keys($conversion_tab), array_values($conversion_tab), $twext);
			$tweetuserclas       = str_replace(".","__dot__",$tweetuser);
			

				$text .= "<li>";
				$text .= "<p  style='white-space:normal!important;'><strong>@$tweetuser</strong> : $twext</p>
				<p>$date_to_display</p>
			</li>
			";
			
		}
		return $text;
	}
	public static function fnDelTweetAjax($id){
		include('WikiTweet.config.php');
		global $wgDBprefix;
		$dbr =& wfGetDB( DB_SLAVE );
		$dbr->update('wikitweet',array('`show`' => 0),array('id' => $id));
		$o__response = new AjaxResponse('ok');
		return $o__response;
	}
	public static function fnResolveTweetAjax($id){
		include('WikiTweet.config.php');
		global $wgDBprefix;
		$dbr =& wfGetDB( DB_SLAVE );
		$dbr->update('wikitweet',array('`status`' => 1),array('id' => $id));

		$sql1 = "SELECT DISTINCT {$wgDBprefix}user.user_email,{$wgDBprefix}wikitweet.room, {$wgDBprefix}wikitweet.text, {$wgDBprefix}wikitweet.id FROM {$wgDBprefix}user, {$wgDBprefix}wikitweet WHERE {$wgDBprefix}wikitweet.user={$wgDBprefix}user.user_name AND {$wgDBprefix}wikitweet.id=$id ;";
		$res1 = $dbr->query( $sql1, __METHOD__ );
		$results = array();
		while( $row1 = $dbr->fetchObject( $res1 ) )
		{
			$useremail = $row1->user_email;
			$room      = $row1->room;
			$text      = $row1->text;
			$twid      = $row1->id;
			$sender    = $wgWikiTweet['wikimails']['2'];
			WikiTweetFunctions::send( $useremail, $sender , "[WikiTweet] ".date('d/m H:i')." ".wfMsg('wikitweet-alertsolved')." $room", "$text");
		}
		$o__response = new AjaxResponse('ok');
		// TODO : WikiTweetFunctions::send( 'sender email', $sender ,"L'alerte $twid a été résolue dans la salle $room : $text","");
		return $o__response;
	}
	public static function fnUpdateTweetAjax($status, $user, $room, $tomail, $bstatus, $parent) {
		$text = 'hello world;';
		include('WikiTweet.config.php');
		$show = ($tomail==2) ? 2 : 1;
		global $wgDBprefix, $wgDBserver, $wgDBuser, $wgDBpassword, $wgDBname, $wgLanguageCode, $IP, $wgServer ;
		$db = mysql_connect($wgDBserver, $wgDBuser, $wgDBpassword);
		mysql_select_db($wgDBname,$db);

		$dbr =& wfGetDB( DB_SLAVE );
		$dbr->insert('wikitweet',array(
			'`id`'      => ''      ,
			'`text`'    => $status ,
			'`user`'    => $user   ,
			'`room`'    => $room   ,
			'`show`'    => $show   ,
			'`status`'  => $bstatus,
			'`parent`'  => $parent,
			'`lastupdatedate`' => time()
		));

		if( $parent != 0 )
		{
			// update last update date parent tweet
			$dbr->update( 'wikitweet', array('`lastupdatedate`' => time()), array('id' => $parent) ) ;
		}
		
		$dest=array('concerned'=>array(),'subscribers'=>array()); // initialisation de la liste des récepteurs
		$user_email = $wgWikiTweet['wikimail']; // initialisation du sender
		if($tomail==1 or $tomail==2 or  !$wgWikiTweet['tweetandemail']){ // si l'option tomail est à 1 ou 2 > mails directs, mentions, privés
			$res = $dbr->select('user','user_email',"user_name = '$user' ");

			if ($dbr->numRows($res) > 0){
				$row = $dbr->fetchObject($res);
				$user_email = $row->user_email;
				if ($user_email!=''){
					$status_array = split("@",$status);
					$i = -1;
					foreach($status_array as $values){
						$i += 1;
						if ($i>0){
							$values_array = split(" ",$values);
							$username = $values_array[0];
							$res2 = $dbr->select('user','user_email',"user_name = '$username' ");
							if ($dbr->numRows($res2) > 0){
								$row2 = $dbr->fetchObject($res2);
								$useremail = $row2->user_email;
								if ($useremail!='')
									array_push($dest['concerned'],$useremail);
							}
						}
					}
				}
			}
		}
		if( $tomail!=2)
		{
			// pas d'envoi de mails groupés pour les tweets privés
			// à ce stade, $dest contient les utilisateurs qui sont spécifiques au tweets, et non pas abonnés.
			$roomssons = array();
			$sql_subscriptions = '';
			// récupération des abonnés pour envoi de mail (abonnés user ou abonnés room + inherit rooms)
			foreach(WikiTweetFunctions::_getParentsRoom($room,$wgWikiTweet['inherit']) as $roomparent)
			{
				$sql_subscriptions .= " OR (wt.link = '$roomparent' AND wt.type='room')";
			}
			$sql1 = "SELECT DISTINCT {$wgDBprefix}user.user_email FROM {$wgDBprefix}user,{$wgDBprefix}wikitweet_subscription wt WHERE wt.user={$wgDBprefix}user.user_name AND ((wt.link = '$room' AND wt.type='room') or (wt.link='$user' AND wt.type='user'){$sql_subscriptions}) ;";

			$res1 = $dbr->query( $sql1, __METHOD__ );
			while( $row1 = $dbr->fetchObject( $res1 ) )
			{
				$useremail = $row1->user_email;
				array_push($dest['subscribers'],$useremail);
				$text .= $useremail.'---';
			}
		}
		$lenlist = array('concerned'=>0,'subscribers'=>0);
		foreach($dest as $desttype=>$destarray)
		{
			foreach($dest[$desttype] as $destmail){
				$lenlist[$desttype] += strlen($destmail);
				$text .= "--g:$desttype:$destmail--";
			}
		}
		$bstatus_string = ($bstatus > 1) ? ' ['.wfMsg('wikitweet-status'.$bstatus).']' : '';
		
		foreach($dest as $desttype=>$destarray)
		{
			if($lenlist[$desttype]>0){
				$room_title = (isset($wgWikiTweet['titles'][$room])) ? $room.' - '.$wgWikiTweet['titles'][$room] : $room;
				$concernsstring = ($desttype == 'concerned') ? "[".wfMsg('wikitweet-concerns')."]" : "";
				$sender = ($desttype == 'concerned') ? $wgWikiTweet['wikimail-concerns'] : $wgWikiTweet['wikimails'][$bstatus];

				$answering = '';
				if( $parent != 0 )
				{
					// en réponse au wikitweet
					$res = $dbr->select( 
						'wikitweet' , 
						'*' , 
						"`show`=1 AND `id`='$parent'",
						__METHOD__ ,
						array("ORDER BY" =>" `date` ASC", "LIMIT" => $rows)
					);
					$row = $dbr->fetchObject( $res );
					$answering = wfMsg('wikitweet-inresponseto')." \n\n".wfMsg('wikitweet-from')." @{$row->user} ({$row->date}) : {$row->text}\n";

					$res = $dbr->select( 
						'wikitweet' , 
						'*' , 
						"`show`=1 AND `parent`='$parent'",
						__METHOD__ ,
						array("ORDER BY" =>" `date` ASC", "LIMIT" => $rows)
					);
					while( $row = $dbr->fetchObject( $res ) )
					{
						$answering .= "\n\t|----\n\t| ".wfMsg('wikitweet-from')." @{$row->user} ({$row->date}) : {$row->text}";
					}
					$answering .= "\n\t|----";
				}

				WikiTweetFunctions::send( $dest[$desttype], $sender , "[WikiTweet]$bstatus_string $concernsstring  ".date('d/m H:i')." @$user (".wfMsg('wikitweet-in')." $room_title)", wfMsg('wikitweet-from')." @$user :\n----\n".$status."\n----\n\n$answering(".wfMsg('wikitweet-in')." \"$room_title\")\n\n".wfMsg('wikitweet-directlink')." $wgServer/mediawiki/index.php/{$wgWikiTweet['roomlink']}$room");
				$text .= wfMsg('wikitweet-mailsent');
			}
		}
		mysql_close(); 
		return $text;
	}
	public static function fnSubscribeAjax($link, $user, $type){
		$o__text = '';
		include('WikiTweet.config.php');
		$dbr =& wfGetDB( DB_SLAVE );
		$dbr->insert('wikitweet_subscription',array(
			'`id`'   => ''    ,
			'`user`' => $user ,
			'`link`' => $link ,
			'`type`' => $type
		));
		$o__text .= ( $type == "user" ) ? str_replace( "." , "__dot__" , $link ) : '';
		return $o__text;
	}
	public static function fnUnsubscribeAjax($link, $user, $type){
		$o__text = '';
		include('WikiTweet.config.php');
		$dbr =& wfGetDB( DB_SLAVE );
		$dbr->delete('wikitweet_subscription', array(
			'`user`' => $user,
			'`link`' => $link,
			'`type`' => $type
		));
		$o__text .= ( $type == "user" ) ? str_replace( "." , "__dot__" , $link ) : '';
		return $o__text;
	}
	
	public function getAllowedParams() {
		return array(
			'req' => array (
				ApiBase :: PARAM_DFLT => 'get',
				ApiBase :: PARAM_TYPE => array (
					'get',
					'getchilds',
					'delete',
					'update',
					'subscribe',
					'unsubscribe',
					'resolve'
				)
			),
			'rows' => array (
				ApiBase :: PARAM_TYPE => 'integer'
			),
			'room' => array (
				ApiBase :: PARAM_TYPE => 'string'
			),
			'user' => array (
				ApiBase :: PARAM_TYPE => 'string'
			),
			'size' => array (
				ApiBase :: PARAM_TYPE => 'string'
			),
			'tag' => array (
				ApiBase :: PARAM_TYPE => 'string'
			),
			'other_room' => array (
				ApiBase :: PARAM_TYPE => 'string'
			),
			'id' => array (
				ApiBase :: PARAM_TYPE => 'integer'
			),
			'tomail' => array (
				ApiBase :: PARAM_TYPE => 'string'
			),
			'status' => array (
				ApiBase :: PARAM_TYPE => 'string'
			),
			'type' => array (
				ApiBase :: PARAM_DFLT => 'user',
				ApiBase :: PARAM_TYPE => array (
					'user',
					'room'
				)
			),
			'link' => array (
				ApiBase :: PARAM_TYPE => 'string'
			),
			'bstatus' => array (
				ApiBase :: PARAM_TYPE => 'integer'
			),
			'parentid' => array (
				ApiBase :: PARAM_TYPE => 'integer'
			)
		);
	}

	private function log() {
		
	}
	public function getParamDescription() {
		return array(
			'get'       => 'Get tweets',
			'getchilds' => 'Get childs',
			'delete'    => 'Delete a given tweet',
			'update'    => 'Add a tweet',
			'subscribe' => 'Subscription management',
			'resolve'   => 'Resolve a tweet (alert or warning)',
			);
	}

	public function getDescription() {
		return 'API to manage WikiTweets';
	}
	
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'code' => 'params', 'info' => 'You must enter a parameter "id" with "delete" option.' ),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=query&list=wikitweet&wtwreq=get&wtwrows=3&wtwroom=Main&wtwuser=user1',
			'api.php?action=query&list=wikitweet&wtwreq=delete',
			'api.php?action=query&list=wikitweet&wtwreq=update',
			'api.php?action=query&list=wikitweet&wtwreq=subscribe'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: WikiTweet.api.php xxxxx 2010-05-09 13:42:00Z Faure.thomas $';
	}
}
