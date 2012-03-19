<?php
require_once("commandLine.inc");

$dbr = wfGetDB(DB_SLAVE);
$res = $dbr->query("select count(*) as count from watchlist where wl_title = \"Wikia_Staff_Blog\" and wl_namespace = 502");
 while ($row = $dbr->fetchObject($res)) {
	$row->count;
	$output = $row->count;
}
	$to = new MailAddress('comteam-l@wikia-inc.com');
	$from = new MailAddress('timq@wikia-inc.com');
	$subject = 'Staff Blog Numbers!';
	$body = "This is a monthly automated report that simply counts the number of followers on the Wikia Staff Blogs on Community Central\n\nBlog:Wikia Staff Blog followers: " . $output;
	
$res = $dbr->query("select count(*) as count from watchlist where wl_title = \"Wikia_Technical_Updates\" and wl_namespace = 502");
 while ($row = $dbr->fetchObject($res)) {
    	$row->count;
	$output = $row->count;
}

$body = $body . "\nBlog:Wikia Technical Updates  followers: " . $output;

$res = $dbr->query("select count(*) as count from watchlist where wl_title = \"Wikia_Community_News\" and wl_namespace = 502");
 while ($row = $dbr->fetchObject($res)) {
        $row->count;
        $output = $row->count;
}

$body = $body . "\nBlog:Wikia Community News followers: " . $output;

$res = $dbr->query("select count(*) as count from watchlist where wl_title = \"Wikia_Contests_&_Giveaways\" and wl_namespace = 502");
 while ($row = $dbr->fetchObject($res)) {
        $row->count;
        $output = $row->count;
}

$body = $body . "\nBlog:Wikia Contests & Giveaways followers: " . $output;


$res = $dbr->query("select count(*) as count from watchlist where wl_title = \"Wikia_New_Features\" and wl_namespace = 502");
 while ($row = $dbr->fetchObject($res)) {
        $row->count;
        $output = $row->count;
}

$body = $body . "\nBlog:Wikia New Features followers: " . $output;


$res = $dbr->query("select count(*) as count from watchlist where wl_title = \"Wikia_Tips_&_Tricks\" and wl_namespace = 502");
while ($row = $dbr->fetchObject($res)) {
    $row->count;
$output = $row->count;
}
$body = $body. "\nBlog:Wikia Tips & Tricks followers: " . $output;

$res = $dbr->query("select count(*) as count from watchlist where wl_title = \"Wikia_Founders_&_Admins\" and wl_namespace = 502");
while ($row = $dbr->fetchObject($res)) {
    $row->count;
$output = $row->count;
}
$body = $body.  "\n\nBlog:Wikia Founders & Admins followers: " . $output;

UserMailer::send($to, $from, $subject, $body);

