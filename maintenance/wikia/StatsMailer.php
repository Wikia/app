<?php
require_once("commandLine.inc");

$dbr = wfGetDB(DB_MASTER);
$res = $dbr->query("select count(*) as count from watchlist where wl_title = \"Wikia_Staff_Blog\" and wl_namespace = 502");
while ($row = $dbr->fetchObject($res)) {
    $row->count;
echo $row->count;
$output = $row->count;
}
$to = new MailAddress('timq@wikia-inc.com');
$from = new MailAddress('timq@wikia-inc.com');
$subject = 'Hi there!';
$body = "This is the number of Staff Blog followers: " . $output;
UserMailer::send($to, $from, $subject, $body);
