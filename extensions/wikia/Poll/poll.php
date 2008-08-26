<?php
# AJAX Poll extension for MediaWiki
# Created by Dariusz Siedlecki, based on the work by Eric David, licensed under the GFDL
# http://wikipoll.free.fr/mediawiki-1.6.5/index.php?title=Source_code
# <Poll>
# [Option]
# Question
# Answer 1
# Asnwer 2
# ...
# Answer n
# </Poll>
#
# To activate the extension, include it from your LocalSettings.php
# with: include("extensions/poll.php");
$wgExtensionFunctions[] = "wfPoll";
$wgExtensionMessagesFiles['poll'] = dirname(__FILE__) . '/poll.i18n.php';

function wfPoll() {
  global $wgParser;

  # register the extension with the WikiText parser
  # the first parameter is the name of the new tag.
  # In this case it defines the tag <Poll> ... </Poll>
  # the second parameter is the callback function for
  # processing the text between the tags

  $wgParser->setHook( "poll", "renderPoll" );
}

# The callback function for converting the input text to HTML output
# $argv is an array containing any arguments passed to the extension like <example argument="foo" bar>..

function renderPoll( $input, $argv=array() ) {
  global $wgParser, $wgUser, $wgOut, $wgTitle;

  $IP = wfGetIP();

  #$wgParser->disableCache();
  global $wgParserCacheExpireTime;
  $wgParserCacheExpireTime = 60;
  wfDebug( "soft disable Cache (poll)\n" );

  if ($wgUser->mName == "") $user = $IP;
  else                      $user = $wgUser->mName;

  // Breaks compatibility
  //$input = trim($input);
  $ID = strtoupper(md5($input)); // ID of the poll

    //echo "<h1>poll id: {$ID}</h1>";

  $par = new Parser();
  $input = $par->parse( $input, $wgTitle, $wgOut->parserOptions() );
  $input = trim( strip_tags( $input->getText() ) );
  $lines = split("\n", trim($input));



  $err = "";

  // Depracating AJAX
  if (isset($_POST['p_id']) && isset($_POST['p_answer']) && $_POST['p_id'] == $ID) {
	submitVote($_POST['p_id'], intval($_POST['p_answer']));
  }

	$dbw = wfGetDB( DB_MASTER );
	$dbw->begin();
	/**
	 * Register poll in the database
	 */
	$oRow = $dbw->selectRow(
		array( "poll_info" ),
		array( "count(poll_id) as count" ),
		array( "poll_id" => $ID ),
		__METHOD__
	);

	if( empty( $oRow->count ) ) {
		$dbw->insert(
			"poll_info",
			array(
				"poll_id" => $ID,
				"poll_txt" => $input,
				"poll_date" => date("Y-m-d H:i:s"),
				"poll_title" => $wgParser->mTitle->getText(),
				"poll_domain" => ""
			),
			__METHOD__
		);
	}
	$dbw->commit();

	$return_css = "<style type=\"text/css\">.poll {width:400px;border:1px dashed #999;background:#FAFAFA;padding:10px 20px 10px 10px}.poll .pollQuestion {font-weight:bold}.poll .pollAjax {background:#FFFFCF;padding:1px 4px;width:200px;border-radius:0.5em;-moz-border-radius:0.5em;display:none}.poll .pollAnswerName {padding-left:10px;font-size:0.9em}.poll .pollAnswerVotes {border:1px solid #CCC;width:100%;margin-left:10px;height:12px;font-size:10px;position:relative}.poll .pollAnswerVotes div {border-right:1px solid #CCC;background:#E5E5E5;position:absolute;top:0;left:0;height:12px;font-size:1px;line-height:12px;z-index:2}.poll .ourVote div {border:1px solid #777;top:-1px;left:-1px}.poll .pollAnswerVotes span {position:absolute;top:-3px;left:3px;z-index:4}.poll label{cursor:pointer;cursor:hand}</style>";
	switch ($lines[0]) {
		case "STATS":
			//return
			$retVal = $return_css.buildStats($ID, $user);
		break;
		default:
			//return
			$retVal = $return_css."<div id='pollContainer".$ID."'>".buildHTML($ID, $user, $lines)."</div>";
		break;
	}
	return $retVal;
}

function buildStats($ID, $user) {
  $dbw =& wfGetDB( DB_MASTER );

  $res = $dbw->query("SELECT COUNT(*), COUNT(DISTINCT poll_id), COUNT(DISTINCT poll_user), timediff(now(), MAX(poll_data)) FROM poll_vote");
  $tab = $dbw->fetchRow($res);
  $dbw->freeResult($res);

  $clock = split(':',$tab[3]);

  if ($clock[0] == '00' && $clock[1] == '00') { $x = $clock[2]; $y = "second"; }
  elseif ($clock[0] == '00')                  { $x = $clock[1]; $y = "minute"; }
  else {
    if ($clock[0] < 24)                       { $x = $clock[0]; $y = "hour";   }
    else                                      { $x = floor($hr/24); $y = "day"; }
  }

  $clockago = $x." ".$y.($x>1?'s':'');

  $res = $dbw->query("SELECT count(*) FROM poll_vote WHERE DATE_SUB(CURDATE(), INTERVAL 2 DAY) <= poll_date");
  $tab2 = $dbw->fetchRow($res);
  $dbw->freeResult($res);

  return "There are $tab[1] polls and $tab[0] votes given by $tab[2] different people.<br />The last vote has been given $clockago ago.<br/>During the last 48 hours, $tab2[0] votes have been given.";
}

function submitVote($ID, $answer) {
  global $wgUser;

  $IP  =  wfGetIP();
  $dbw =& wfGetDB( DB_MASTER );

  if ($wgUser->mName == "") $user = $IP;
  else                      $user = $wgUser->mName;

  if ($wgUser->isBot())
    return buildHTML($ID, $user);

  $answer = mysql_escape_string(++$answer);

  $q = $dbw->query("SELECT COUNT(*) as c FROM poll_vote WHERE poll_id='{$ID}' AND poll_user={$dbw->addQuotes($user)}");
  $r = $dbw->fetchRow($q);

  if ($r['c'] > 0) {
    if ($dbw->query("UPDATE poll_vote SET poll_answer='{$answer}', poll_date='".date("Y-m-d H:i:s")."' WHERE poll_id='{$ID}' AND poll_user={$dbw->addQuotes($user)}"))
      return buildHTML($ID, $user, "", "pollVoteUpdate");
	else
      return buildHTML($ID, $user, "", "pollVoteError");
  }
  else {
    if ($dbw->query("INSERT INTO poll_vote (poll_id, poll_user, poll_ip, poll_answer, poll_date) VALUES ('{$ID}', {$dbw->addQuotes($user)}, '{$IP}', '{$answer}', '".date("Y-m-d H:i:s")."')"))
      return buildHTML($ID, $user, "", "pollVoteAdd");
	else
      return buildHTML($ID, $user, "", "pollVoteError");
  }
}

function buildHTML($ID, $user, $lines="", $extra_from_ajax="") {
  global $wgTitle, $wgMessageCache, $wgLang; // , $wgUseAjax -- ajax is probably broken

  $wgUseAjax = 0;

  wfLoadExtensionMessages('poll');  

  $dbw = wfGetDB( DB_SLAVE );

  $q = $dbw->query("SELECT poll_txt, poll_date FROM poll_info WHERE poll_id='{$ID}'");
  $r = $dbw->fetchRow($q);

  if (empty($lines))
	$lines = explode("\n", trim($r['poll_txt']));

  $start_date = $r['poll_date'];

  $q = $dbw->query("SELECT poll_answer, COUNT(*) FROM poll_vote WHERE poll_id='{$ID}' GROUP BY poll_answer");

  $poll_result = array();

//  while ($r = mysql_fetch_array($q)) {
  while ($r = $q->fetchRow()) {
	$poll_result[ $r[0] ] = $r[1];
  }

  $t = array_sum($poll_result);

  // Did we vote?
  $q = $dbw->query("SELECT poll_answer, poll_date FROM poll_vote WHERE poll_id='{$ID}' AND poll_user={$dbw->addQuotes($user)}");

  if ($r = $dbw->fetchRow($q)) {
  	$tmp_date = wfMsg("pollYourVote", $lines[ $r[0]-1 ], date("d M Y H:i:s e", strtotime(str_replace(array(" ", ":", "-"), "", $r[1]))));
  }
  //$wgLang->formatNum($num);
  $ret = "<div id='pollId".$ID."' class='poll'><div class='pollAjax' id='pollAjax".$ID."'".(!empty($extra_from_ajax)?" style='display: block;'":"").">".wfMsg($extra_from_ajax)."</div><div class='pollQuestion'>".strip_tags( $lines[0] )."</div>";

  if (isset($r[0]))
	$ret .= "<div class='pollMisc'>".$tmp_date."</div>";
  else
	$ret .= "<div class='pollMisc'>".wfMsg("pollNoVote")."</div>";

  $ret .= "<form method='POST' action='".$wgTitle->getLocalURL()."' id='pollIdAnswer".$ID."'><input type='hidden' name='p_id' value='{$ID}' />";

  for ($i=1; $i<count($lines); $i++) {
	$ans_no = $i-1;

	if ($t == 0)
	  $percent = 0;
	else
	  $percent = $wgLang->formatNum(round((isset($poll_result[$i+1])?$poll_result[$i+1]:0)*100/$t, 2));

	if (isset($r[0]) && $r[0] == $i)
	  $our = true;
	else
	  $our = false;

       if ($wgUseAjax)
         $ajax_no_ajax = "sajax_do_call(\"submitVote\", [\"".$ID."\", \"".$i."\"], document.getElementById(\"pollContainer".$ID."\"));";
       else
         $ajax_no_ajax = "document.getElementById(\"pollIdAnswer".$ID."\").submit();";

       $ret .= "<div class='pollAnswer' id='pollAnswer".$ans_no."'><div class='pollAnswerName'>" .
               "<label for='pollAnswerRadio".$ans_no."' onclick='document.getElementById(\"pollAjax".$ID."\").innerHTML=\"".wfMsg("pollSubmitting")."\"; document.getElementById(\"pollAjax".$ID."\").style.display=\"block\"; this.getElementsByTagName(\"input\")[0].checked = true; ".$ajax_no_ajax."'>" .
		"<input type='radio' id='p_answer".$ans_no."' name='p_answer' value='".$i."' />".strip_tags( $lines[$i] ) .
		"</label></div>" .
		"<div class='pollAnswerVotes".($our?" ourVote":"")."' onmouseover='span=this.getElementsByTagName(\"span\")[0];tmpPollVar=span.innerHTML;span.innerHTML=span.title;span.title=\"\";' onmouseout='span=this.getElementsByTagName(\"span\")[0];span.title=span.innerHTML;span.innerHTML=tmpPollVar;'><span title='".wfMsg("pollPercentVotes",$percent)."'>".((isset($poll_result)&&!empty($poll_result[$i+1]))?$poll_result[$i+1]:0)."</span>" .
		"<div style='width: ".$percent."%;".($percent==0?" border:0;":"")."'></div>" . 
		"</div></div>";
  }

  $ret .= "</form>";

  // Misc
  $tmp_date = wfMsg("pollInfo", $t, date("d M Y H:i:s e", strtotime(str_replace(array(" ", ":", "-"), "", $start_date))));

  $ret .= "<div id='pollInfo'>".$tmp_date."</div>";

  $ret .= "</div>";

  return $ret;
}
