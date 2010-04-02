<?php


ini_set( "include_path", dirname(__FILE__)."/../.." );
require_once( 'commandLine.inc' );

$urls = array(
	"http://swfanon.wikia.com/wiki/File:IchiGo.jpg",
	"http://images1.wikia.nocookie.net/__cb20100331234651/swfanon/images/6/60/LinkFA-star.png",
	"http://swfanon.wikia.com/wiki/File:LinkFA-star.png?action=purge",
	"http://images1.wikia.nocookie.net/__cb20100402220156/swfanon/images/d/da/IchiGo.jpg"
);


include 'includes/SquidUpdate.php';

for($cnt=0; $cnt< count($urls); $cnt++){
	$url = $urls[$cnt];
	print "Purging $url...\n";
	SquidUpdate::StompPurge($url);
}

print "Done.\n";

