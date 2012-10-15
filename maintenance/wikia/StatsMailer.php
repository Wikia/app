<?php

require_once("../commandLine.inc");

$thismonth = date('Ym')."01000000";
$year = date('Y');
$lastmonth = date('m')-1;
if ($lastmonth == 0)
{ $lastmonth = 12;
  $year = $year-1;
 }
if ($lastmonth < 10)
{ $lastmonth = "0".$lastmonth; }
$lastmonth= $year.$lastmonth."01000000";

$dbr = wfGetDB(DB_SLAVE);

$res = $dbr->query("select count(*) as count from watchlist where wl_title = \"Wikia_Staff_Blog\" and wl_namespace = 502");
 while ($row = $dbr->fetchObject($res)) {

	$row->count;
	$output = $row->count;
}
	$to = new MailAddress('comteam-l@wikia-inc.com');
	$from = new MailAddress('timq@wikia-inc.com');
	$subject = 'Monthly CC Stats!';
	$body = "<H3>This is a monthly automated report for activity monitored by Community Support</H3><H4>STAFF BLOG</H4>Blog:Wikia Staff Blog followers: " . $output;

$res = $dbr->query("select count(*) as count from watchlist where wl_title = \"Wikia_Technical_Updates\" and wl_namespace = 502");
 while ($row = $dbr->fetchObject($res)) {
    	$row->count;
	$output = $row->count;
}

$body = $body . "<br/>Blog:Wikia Technical Updates followers: " . $output;

$res = $dbr->query("select count(*) as count from watchlist where wl_title = \"Wikia_Community_News\" and wl_namespace = 502");
 while ($row = $dbr->fetchObject($res)) {
        $row->count;
        $output = $row->count;
}

$body = $body . "<br/>Blog:Wikia Community News followers: " . $output;

$res = $dbr->query("select count(*) as count from watchlist where wl_title = \"Wikia_Contests_&_Giveaways\" and wl_namespace = 502");
 while ($row = $dbr->fetchObject($res)) {
        $row->count;
        $output = $row->count;
}

$body = $body . "<br/>Blog:Wikia Contests & Giveaways followers: " . $output;


$res = $dbr->query("select count(*) as count from watchlist where wl_title = \"Wikia_New_Features\" and wl_namespace = 502");
 while ($row = $dbr->fetchObject($res)) {
        $row->count;
        $output = $row->count;
}

$body = $body . "<br/>Blog:Wikia New Features followers: " . $output;


$res = $dbr->query("select count(*) as count from watchlist where wl_title = \"Wikia_Tips_&_Tricks\" and wl_namespace = 502");
while ($row = $dbr->fetchObject($res)) {
    $row->count;
$output = $row->count;
}
$body = $body. "<br/>Blog:Wikia Tips & Tricks followers: " . $output;

$res = $dbr->query("select count(*) as count from watchlist where wl_title = \"Wikia_Founders_&_Admins\" and wl_namespace = 502");
while ($row = $dbr->fetchObject($res)) {
    $row->count;
$output = $row->count;
}
$body = $body.  "<br/>Blog:Wikia Founders & Admins followers: " . $output;

$res = $dbr->query("select count(*) as count from revision where rev_timestamp>$lastmonth and rev_timestamp<$thismonth");
while ($row = $dbr->fetchObject($res)) {
$output = $row->count;
}

$body = $body. "<H4>EDITING STATS FOR COMMUNITY CENTRAL OVER THE LAST MONTH:</H4>Total # of Edits: " . $output;
$output = "";

$res = $dbr->query("select page_namespace as ns, count(*) as count from page, revision where rev_timestamp>$lastmonth and rev_timestamp<$thismonth and page_id=rev_page group by page_namespace");

while ($row = $dbr->fetchObject($res)) {
       $ns = $row->ns;
       if ($ns == 0) { $nsname = "Main"; }
      else { $nsname = $wgLang->getFormattedNsText( $ns ); }
       $output = $output."NS ". $nsname .": ".$row->count."<br/>";
}

$body = $body. "<br /><br />Breaking down edits by NS:<br />".$output;
$res = $dbr->query("select rev_id as id from revision where rev_timestamp>$lastmonth limit 1; ");
while ($row = $dbr->fetchObject($res)) {
      $firstid = $row->id;
}
$res = $dbr->query("select rev_id as id from revision where rev_timestamp>$thismonth order by rev_id desc limit 1; ");
while ($row = $dbr->fetchObject($res)) {
      $lastid = $row->id;
}

$res = $dbr->query("select count(*) as count from page where page_namespace=1201 and page_title not like '%@comment%@comment%' and page_latest>$firstid and page_latest<$lastid");
while ($row = $dbr->fetchObject($res)) {
        $row->count;
       $output = $row->count;
}

$body = $body. "<br/>Message Wall Thread CREATIONS: ".$output;

$res = $dbr->query("select count(*) as count from page where page_namespace=1201 and page_title like '%@comment%@comment%' and page_latest>$firstid and page_latest<$lastid");
while ($row = $dbr->fetchObject($res)) {
        $row->count;
       $output = $row->count;
}

$body = $body. "<br/>Message Wall Thread REPLIES: ".$output;

$res = $dbr->query("select count(*) as count from phalanx where p_timestamp>$lastmonth and p_timestamp<$thismonth");
while ($row = $dbr->fetchObject($res)) {
        $row->count;
       $output = $row->count;
}

$body = $body. "<H4>STATS FOR PHALANX OVER THE LAST MONTH</H4> Phalanx Blocks (total): " . $output;

$output = "";
$res = $dbr->query("select user_name as name, count(*) as count from user, phalanx where p_timestamp>$lastmonth and p_timestamp<$thismonth and user_id=p_author_id group by p_author_id;
");

while ($row = $dbr->fetchObject($res)) {
       $output = $output.$row->name.": ".$row->count."<br/>";
}
$body = $body. "<br/><br/>Number of Non-Cancelled Blocks Per User:<br/>". $output;

$output = "";
$res = $dbr->query("select p_type as type, count(*) as count from phalanx where p_timestamp>$lastmonth and p_timestamp<$thismonth group by p_type;");

while ($row = $dbr->fetchObject($res)) {
       $output = $output."Block Type ".$row->type.": ".$row->count."<br />";
}
$body = $body. "<br />Types of Phalanx Blocks (<a href=\"http://trac.wikia-code.com/browser/wikia/trunk/extensions/wikia/Phalanx/Phalanx.class.php#L5\">Explanation</a>):<br />". $output;

$res = $dbr->query("select count(*) as count from revision where rev_timestamp>$lastmonth  and rev_timestamp<$thismonth");
while ($row = $dbr->fetchObject($res)) {
        $row->count;
       $output = $row->count;
}

$res = $dbr->query("select count(*) as count from city_list_log where cl_text like '%adopted%' and cl_timestamp>$lastmonth and cl_timestamp<$thismonth");

while ($row = $dbr->fetchObject($res)) {
       $output = $row->count;
}
$body = $body. "<H4>STAFF SERVICES</H4>Number of Wikis Auto-Adopted: ".$output;


$res = $dbr->query("select count(*) as count from city_list_log where cl_text like '%.wikia.com added.' and cl_timestamp>$lastmonth and cl_timestamp<$thismonth");

while ($row = $dbr->fetchObject($res)) {
       $output = $row->count;
}
$body = $body. "<br />Number of Wikis With URLs Added: ".$output;


$res = $dbr->query("select count(*) as count from city_list_log where cl_text like 'Variable wgServer changed value%' and cl_timestamp>$lastmonth and cl_timestamp<$thismonth");

while ($row = $dbr->fetchObject($res)) {
       $output = $row->count;
}
$body = $body. "<br/>Number of Wikis With Primary URLs changed: ".$output;

$res = $dbr->query("select count(*) as count from city_list_log where cl_text like 'Variable wgServer changed value%' and cl_timestamp>$lastmonth and cl_timestamp<$thismonth");

while ($row = $dbr->fetchObject($res)) {
       $output = $row->count;
}
$body = $body. "<br />Number of Wikis Closed this Month: ".$output;

global $wgExternalDatawareDB;
$dbw =  wfGetDB( DB_SLAVE, array(), $wgExternalDatawareDB );
$res = $dbw->query("select count(*) as count from wikiastaff_log where slog_comment like '%started to rename%' and slog_timestamp>$lastmonth and slog_timestamp<$thismonth");

while ($row = $dbw->fetchObject($res)) {
       $output = $row->count;
}
$body = $body. "<br />Number of User Accounts Renamed This Month: ".$output;

$res = $dbr->query("select count(*) as count from user where user_real_name=\"Account Disabled\" and user_touched>$lastmonth and user_touched<$thismonth");

while ($row = $dbr->fetchObject($res)) {
       $output = $row->count;
}
$body = $body. "<br />Number of User Accounts Closed this Month: ".$output;


$bodyHTML = $body;
UserMailer::sendHTML($to, $from, $subject, $body, $bodyHTML);

