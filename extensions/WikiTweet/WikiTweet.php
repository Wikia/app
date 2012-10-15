<?php
/**
 * Parser hook extension adds a <wiki-tweet> tag to wiki markup. The
 * following attributes are used:
 *    class = The CSS class to assign to the outer div, defaults
 *            to "wiki-tweet"
 *
 * There is also a parser function that uses {{#wiki-tweet:rows}}
 * with optional parameters being includes as "|param=value".
 *
 * @addtogroup Extensions
 * @author Thomas FAURÉ <faure dot thomas at gmail dot com> <@whiblog>
 * @copyright © 2010-2011 Thomas FAURÉ
 * @licence GNU General Public Licence 3.0
 */

// Make sure we are being properly
if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software "
	. "and cannot be used standalone.\n" );
	die( -1 );
}

## Abort if AJAX is not enabled
if ( !$wgUseAjax ) {
	trigger_error( 'WikiTweet: please enable $wgUseAjax.', E_USER_WARNING );
	return;
}

// Hook up into MediaWiki
$wgHooks['ParserFirstCallInit'][] = 'wfWikiTweetRegisterHook';
$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'WikiTweet',
	'author'         => 'Thomas Fauré',
	'descriptionmsg' => 'wikitweet-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:WikiTweet',
	'version'        => '0.10.0'
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['WikiTweet'] = $dir . 'WikiTweet.i18n.php';
$wgExtensionMessagesFiles['WikiTweetMagic'] = $dir . 'WikiTweet.i18n.magic.php';
$wgAutoloadClasses['ApiQueryWikiTweet'] = "$dir/WikiTweet.api.php";
$wgAPIListModules['wikitweet'] = 'ApiQueryWikiTweet';
$wgAutoloadClasses['WikiTweetFunctions'] = "$dir/WikiTweet.functions.php";

function wfWikiTweetRegisterHook( $parser )
{
	$parser->setHook( 'wiki-tweet', 'wikiTweeterRender' );
	return true;
}

/**
* Function which create tables if not exist
* @global OBJECT $wgDBprefix;
*/
function tableCheck()
{
	global $wgDBprefix;
	$dbr =& wfGetDB( DB_SLAVE );
 
	// Check if 'approval_request' database tables exists
	if (!$dbr->tableExists('wikitweet'))
	{
			$sql = "CREATE TABLE `".$wgDBprefix."wikitweet` (";
			$sql .= "`id` int(11) NOT NULL auto_increment,";
			$sql .= "`text` varchar(500) default NULL,";
			$sql .= "`user` varchar(100) NOT NULL,";
			$sql .= "`date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,";
			$sql .= "`room` varchar(50) NOT NULL default 'main',";
			$sql .= "`show` int(11) NOT NULL default '1',";
			$sql .= "`status` int(11) NOT NULL default '1',";
			$sql .= "`parent` int(11) default '0',";
			$sql .= "`lastupdatedate` int(11) default '0',";
			$sql .= "PRIMARY KEY  (`id`)";
			$sql .= ") ENGINE=InnoDB DEFAULT CHARSET=binary;";
			$res = $dbr->query( $sql, __METHOD__ );           
	}
	if (!$dbr->tableExists('wikitweet_alerts'))
	{
			$sql = "CREATE TABLE `".$wgDBprefix."wikitweet_alerts` (";
			$sql .= "`id` int(11) NOT NULL auto_increment,";
			$sql .= "`date` varchar(100) NOT NULL,";
			$sql .= "`timestamp` int(11) NOT NULL,";
			$sql .= "`attention` int(11) NOT NULL default '0',";
			$sql .= "`alert` int(11) NOT NULL default '0',";
			$sql .= "PRIMARY KEY  (`id`)";
			$sql .= ") ENGINE=InnoDB DEFAULT CHARSET=binary;";
			$res = $dbr->query( $sql, __METHOD__ );           
	}
	if (!$dbr->tableExists('wikitweet_alerts_persons'))
	{
			$sql = "CREATE TABLE `".$wgDBprefix."wikitweet_alerts_persons` (";
			$sql .= "`id` int(11) NOT NULL auto_increment,";
			$sql .= "`date` varchar(100) NOT NULL default '',";
			$sql .= "`timestamp` int(11) NOT NULL default '0',";
			$sql .= "`attention` int(11) NOT NULL default '0',";
			$sql .= "`alert` int(11) NOT NULL default '0',";
			$sql .= "`username` varchar(100) NOT NULL default '',";
			$sql .= "PRIMARY KEY  (`id`)";
			$sql .= ") ENGINE=InnoDB DEFAULT CHARSET=binary;";
			$res = $dbr->query( $sql, __METHOD__ );           
	}
	if (!$dbr->tableExists('wikitweet_avatar'))
	{
			$sql = "CREATE TABLE `".$wgDBprefix."wikitweet_avatar` (";
			$sql .= "`id` int(11) NOT NULL auto_increment,";
			$sql .= "`user` varchar(200) NOT NULL,";
			$sql .= "`avatar` varchar(1000) NOT NULL,";
			$sql .= "PRIMARY KEY  (`id`)";
			$sql .= ") ENGINE=InnoDB DEFAULT CHARSET=binary;";
			$res = $dbr->query( $sql, __METHOD__ );           
	}
	if (!$dbr->tableExists('wikitweet_charge'))
	{
			$sql = "CREATE TABLE `".$wgDBprefix."wikitweet_charge` (";
			$sql .= "`id` int(11) NOT NULL auto_increment,";
			$sql .= "`chantier` varchar(200) NOT NULL,";
			$sql .= "`jalon` varchar(1000) NOT NULL,";
			$sql .= "`charge` int(11) NOT NULL,";
			$sql .= "PRIMARY KEY  (`id`)";
			$sql .= ") ENGINE=InnoDB DEFAULT CHARSET=binary;";
			$res = $dbr->query( $sql, __METHOD__ );           
	}
	if (!$dbr->tableExists('wikitweet_responsibles'))
	{
			$sql = "CREATE TABLE `".$wgDBprefix."wikitweet_responsibles` (";
			$sql .= "`id` int(11) NOT NULL auto_increment,";
			$sql .= "`ref` varchar(100) NOT NULL default '',";
			$sql .= "`title` varchar(300) NOT NULL default '',";
			$sql .= "`responsible` varchar(100) NOT NULL default '',";
			$sql .= "PRIMARY KEY  (`id`)";
			$sql .= ") ENGINE=InnoDB DEFAULT CHARSET=binary;";
			$res = $dbr->query( $sql, __METHOD__ );           
	}
	if (!$dbr->tableExists('wikitweet_subscription'))
	{
			$sql = "CREATE TABLE `".$wgDBprefix."wikitweet_subscription` (";
			$sql .= "`id` int(11) NOT NULL auto_increment,";
			$sql .= "`user` varchar(50) NOT NULL,";
			$sql .= "`link` varchar(50) NOT NULL,";
			$sql .= "`type` varchar(10) NOT NULL,";
			$sql .= "PRIMARY KEY  (`id`)";
			$sql .= ") ENGINE=InnoDB DEFAULT CHARSET=binary;";
			$res = $dbr->query( $sql, __METHOD__ );           
	}
}

// The actual processing
function wikiTweeterRender($input, $args, $parser)
{
	tableCheck();
	// Imports
	global $wgOut;
	global $wgUser;
	global $ableToTweet;
	include("WikiTweet.config.php");
	global $wgScriptPath;
	global $wgDBprefix;
	// Profiling
	wfProfileIn('wikiTweeter::Render');

	// Disable the cache, otherwise the cloud will only update
	// itself when a user edits and saves the page.
	$parser->disableCache();
	
	$dbr =& wfGetDB( DB_SLAVE );
	$res = $dbr->select('wikitweet','distinct(`user`)',false,__METHOD__,false);

	$avatarlist = '';
	while ($row = $dbr->fetchObject($res))
	{
		// Pull out the fields
		$user = $row->user;
		// determine AVATAR path
		$avatar_parse = $parser->parse("[[image:$user.png]]",$parser->mTitle, $parser->mOptions,true, false)->getText();
		$avatar = '';
		if (strstr($avatar_parse, 'src') == ''){
			$avatar_parse = $parser->parse("[[image:$user.jpg]]",$parser->mTitle, $parser->mOptions,true, false)->getText();
		}
		if (strstr($avatar_parse, 'src') == ''){
			//$avatar_parse = $parser->parse("[[image:Default.tweet.png]]",$parser->mTitle, $parser->mOptions,true, false)->getText();
			$avatar_parse = 'src="'.$wgScriptPath.'/extensions/WikiTweet/images/default_avatar.png"';
		}
		if (strstr($avatar_parse, 'src') != ''){
			$pos_src = strpos($avatar_parse,'src');
			$avatar = substr($avatar_parse,$pos_src+5);
			$pos_guill = strpos($avatar,'"');
			$avatar = substr($avatar,0,$pos_guill);
		}
		// Check Avatar table
		$res2 = $dbr->select('wikitweet_avatar','*',"user='".str_replace(' ','_',mysql_real_escape_string($user))."' ",__METHOD__,false);
		if ($dbr->numRows( $res2 ) == 0){
				$res4 = $dbr->insert('wikitweet_avatar',array('`id`'=>'','`user`'=>str_replace(' ','_',mysql_real_escape_string($user)),'`avatar`'=>$avatar));
			}
			else {
				$res5 = $dbr->update('wikitweet_avatar',array('avatar'=>$avatar),array('user'=>str_replace(' ','_',mysql_real_escape_string($user))));
			}
	}
	$class  = (isset($args["class"])) ? $args["class"] : "wiki-tweets";
	$size   = (isset($args["size"]))  ? $args["size"]  : "normal"     ;
	$rows   = (isset($args["rows"]))  ? $args["rows"]  : $wgWikiTweet["rows"]         ;
	$room   = (isset($args["room"]))  ? $args["room"]  : "main"       ;
	$allowstatus = (isset($args["status"]))  ? true  : false ;
	$alertslevel = (isset($args["alertslevel"]))  ? $args["alertslevel"]  : "1" ;


	// [GRAPH]
	$text = '';
	if($alertslevel=="2")
	{
		$res2 = $dbr->select('wikitweet_alerts','*',false,__METHOD__,array('ORDER BY' => '`timestamp` DESC'));
		$chd_attention = '';
		$chd_alert     = '';
		$chxl = '';
		$max = 20;
		$i = 0;
		$alertsarray = array();
		$sum_max = 0;
		while($row2= $dbr->fetchObject($res2)){
			$i += 1;
			if($i<=$max){
				$alertsarray[$row2->date] = array($row2->attention,$row2->alert);
				if(intval($row2->attention)+intval($row2->alert)>$sum_max){
					$sum_max = intval($row2->attention)+intval($row2->alert)+1;
				}
				$chd_attention .= $row2->attention.',';
				$chd_alert     .= $row2->alert.',';
				$chxl = '|'.$row2->date.'h'.$chxl;
			}
		}

		$chd_attention = substr($chd_attention, 0, -1);
		$chd_alert = substr($chd_alert, 0, -1);
		$text .="<h2>".wfMsg('wikitweet-hourly')."</h2>
		<p style='text-align:center;'><img src='https://chart.googleapis.com/chart?chs=300x400&amp;
			cht=bhs&amp;
			chco=FF9933,FF0000&amp;
			chds=0,$sum_max&amp;
			chxt=y&amp;
			chts=000000,15&amp;
			chd=t:$chd_attention|$chd_alert&amp;
			chbh=r,.6&amp;
			chm=N,000000,0,,12,,c|N,000000,1,,12,,c&amp;
			chxl=0:$chxl
			'></p>";

		if (false) {
			// NOT YET IMPLEMENTED
			$text .= "<h2>".wfMsg('wikitweet-perperson')."</h2>";
				
			$res3 = $dbr->select('wikitweet_alerts_persons','*','`timestamp` IN (SELECT MAX(`timestamp`) FROM '.$dbr->tableName('wikitweet_alerts_persons').')',__METHOD__);

			$chd_attention = '';
			$chd_alert     = '';
			$chxl = '';
			$sum_max = 0;
			while($row3 = $dbr->fetchObject($res3)){
				if(intval($row3->attention)+intval($row3->alert)>$sum_max){
					$sum_max = intval($row3->attention)+intval($row3->alert)+1;
				}
				$chd_attention .= $row3->attention.',';
				$chd_alert     .= $row3->alert.',';
				$chxl = '|'.$row3->username.$chxl;
			}

			$chd_attention = substr($chd_attention, 0, -1);
			$chd_alert = substr($chd_alert, 0, -1);
			$text .="
			<p style='text-align:center;'><img src='https://chart.googleapis.com/chart?chs=300x400&amp;
				cht=bhs&amp;
				chco=FF9933,FF0000&amp;
				chds=0,$sum_max&amp;
				chxt=y&amp;
				chts=000000,15&amp;
				chd=t:$chd_attention|$chd_alert&amp;
				chbh=r,.6&amp;
				chm=N,000000,0,,12,,c|N,000000,1,,12,,c&amp;
				chxl=0:$chxl
				'></p>";
		}
	}

	// [/GRAPH]

	// $uniqueid = md5($room);
	$uniqueid = rand(1,9999);
	$text  .= "<div class='$class'". (($args["style"]) ? " style='" . $args["style"]. "'" : '').">";
	$room_subscribe_text = "<a class='room_subscribe handmouse' uniqueid='$uniqueid' style='display:none;'>".wfMsg('wikitweet-subscribe')."</a><a class='room_unsubscribe handmouse' uniqueid='$uniqueid'>".wfMsg('wikitweet-unsubscribe')."</a>";
	if($room!='main'){
		$res6 = $dbr->select(
			'wikitweet_subscription',
			'*',
			array(
				"user='".mysql_real_escape_string($wgUser->getName())."' ",
				"link='".mysql_real_escape_string($room)."' ",
				"type='room' "
			),
			__METHOD__,false
		);
		if ($dbr->numRows( $res6 ) == 0){
			$room_subscribe_text = "<a class='room_subscribe handmouse' uniqueid='$uniqueid'>".wfMsg('wikitweet-subscribe')."</a><a  style='display:none;' class='room_unsubscribe handmouse' uniqueid='$uniqueid'>".wfMsg('wikitweet-unsubscribe')."</a>";
		}
		$text .= "<p>".wfMsg('wikitweet-intheroom')." <b>$room</b> (<span id='id_room_subscribe_$uniqueid'>$room_subscribe_text<span id='tempimg_$uniqueid'></span></span>)</p>";
	}
	
	$text .= '<form class="status_update_form" uniqueid="'.$uniqueid.'" style="'.(($alertslevel!='1') ? 'display:none;' : '').'">';
	$text .= '<INPUT type=hidden NAME="alertslevel" value="'.$alertslevel.'"/>';
	if ($wgUser->isLoggedIn() or $wgWikiTweet['allowDisconnected']){
		$text .= '
			<table width=100%>
				<tr><td width=95%>
					<textarea tabindex="1" autocomplete="off" accesskey="u" name="status" id="status" rows="3" cols="40"></textarea>
				</td>
				<td width=5%>
					<div class="stringlength"> <span>500</span></div>
				</td></tr>
			</table>';
			if ( $allowstatus )
			{
				$text .= '	
							<label>'.wfMsg('wikitweet-status').'</label>
							<select name="bstatus" size="1">
								<option selected="" value="0">'.wfMsg('wikitweet-status0').'</option>
								<option value="1">'.wfMsg('wikitweet-status1').'</option>
								<option value="2">'.wfMsg('wikitweet-status2').'</option>
								<option value="3">'.wfMsg('wikitweet-status3').'</option>
							</select><br/>' ;
			}
			else
			{
				$text .= '<input type=hidden value="1" name="bstatus"/>';
			}
			$text .= '<input type=submit name=submit value="'.wfMsg('wikitweet-submit').'" onclick="return false" uniqueid="'.$uniqueid.'"/>';
			if($wgWikiTweet['allowAnonymous']){
				$text .= '<INPUT type=submit name=submitanonymously value="'.wfMsg('wikitweet-anonymous').'" onclick="return false" style="font-size:0.8em;" uniqueid="'.$uniqueid.'" />';
			}
			if (in_array($wgUser->getName(), $wgWikiTweet['informers']))
			{
				$text .= '<input type=submit name=submitbyinformer value="'.wfMsg('wikitweet-inform').'" onclick="return false" style="font-size:0.8em;" uniqueid="'.$uniqueid.'" />';
			}
			if($wgWikiTweet['tweetandemail']){
				$text .= '<input type=submit name=submitandmail value="'.wfMsg('wikitweet-submitandmail').'" onclick="return false" style="display:none;font-size:0.8em;" uniqueid="'.$uniqueid.'"/>';
			}
			$text .= '<input type=submit name=submitprivate value="'.wfMsg('wikitweet-private').'" onclick="return false" style="display:none;font-size:0.8em;" uniqueid="'.$uniqueid.'"/>';
			
			$text .= '<img class="img_loader" src="'.$wgScriptPath.'/extensions/WikiTweet/images/ajax-loader-mini.gif" style ="padding: 0 5px 0 5px;display:none;"/>';
	}
	else{
		$text.="<p>".wfMsg('wikitweet-pleaselogin')."</p>";
	}
	$text .= '<input type=hidden value="'.$wgUser->getName().'" name="user"/>
				<input type=hidden value="'.$size.'" name="size"/>
				<input type=hidden value="'.$rows.'" name="rows"/>
				<input type=hidden value="'.$room.'" name="room"/>
			</form>';

	$text .= '<script type="text/javascript" src="'.$wgScriptPath.'/extensions/WikiTweet/jquery.js"></script>';
	
	$text .= '<script type="text/javascript" src="'.$wgScriptPath.'/extensions/WikiTweet/popup.js"></script>';
	$text .= '<link rel="stylesheet" type="text/css" href="'.$wgScriptPath.'/extensions/WikiTweet/popup.css" media="screen" />';
	$text .= '<link rel="stylesheet" type="text/css" href="'.$wgScriptPath.'/extensions/WikiTweet/WikiTweet.css" media="screen" />';
	$text .= '<script type="text/javascript">wgScriptPath = "'.$wgScriptPath.'";</script>';
	$text .= '<script type="text/javascript">var refreshTime='.$wgWikiTweet['refreshTime'].';</script>';
	$text .= '<script type="text/javascript">var InformerUser="'.$wgWikiTweet['informuser'].'";</script>';
	$text .= '<script type="text/javascript">var AnonymousUser="'.$wgWikiTweet['AnonymousUser'].'";</script>';
	$text .= '<script type="text/javascript" src="'.$wgScriptPath.'/extensions/WikiTweet/WikiTweet.js"></script>';
	$text .= '<script type="text/javascript" src="'.$wgScriptPath.'/extensions/WikiTweet/WikiTweet2.js"></script>';
	$text .= '<script type="text/javascript">$(document).ready(function() {gettweets("'.$uniqueid.'");});</script>';

	$roomssons = array();
	$sql_subscriptions = '';
	foreach(WikiTweetFunctions::_getParentsRoom($room,$wgWikiTweet['inherit']) as $roomparent)
	{
		$sql_subscriptions .= " OR (wt.link = '$roomparent' AND wt.type='room')";
	}
	$sql1 = "SELECT DISTINCT {$wgDBprefix}user.user_real_name,{$wgDBprefix}user.user_name FROM {$wgDBprefix}user,{$wgDBprefix}wikitweet_subscription wt WHERE wt.user={$wgDBprefix}user.user_name AND ((wt.link = '$room' AND wt.type='room'){$sql_subscriptions}) ;";
	$res1 = $dbr->query( $sql1, __METHOD__ );  
	$text .= "<p><b>".wfMsg('wikitweet-subscribers')."</b>  ";
	while($row1 = $dbr->fetchObject($res1)){
		$user_real_name = $row1->user_real_name;
		$text .= " <a href = '$wgScriptPath/index.php/Utilisateur:{$row1->user_name}'>{$row1->user_real_name}</a>, ";
	}
	$text = substr($text, 0, -2);
	$text .= "</p>";


	$text .= "<a href = '$wgScriptPath/index.php/".wfMsg('wikitweet-name')."'>".wfMsg('wikitweet-moretweets')."</a><br/>\n";
	$text .= "<div id='lasttweets_$uniqueid' class='lasttweets' uniqueid='$uniqueid'>\n";
	$text .= "</div>\n";
	$text .= "<a href = '$wgScriptPath/index.php/".wfMsg('wikitweet-name')."'>".wfMsg('wikitweet-name')."</a> ".wfMsg('wikitweet-infoajax')."<br/>\n";
	
	$text .= "</div>\n";
	
	// Finish up and return the results
	wfProfileOut('wikiTweeter::Render');
	return $text;
}
