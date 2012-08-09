<?php

/*
 * This script is intended to output HTML categorized version of
 * all videos on Wikia from one of the partners
 */

$_SERVER['QUERY_STRING'] = 'VideoCleanup';

ini_set( "include_path", dirname(__FILE__)."/.." );

ini_set( 'display_errors', 'stdout' );
$options = array('help');
require_once( '../../commandLine.inc' );

global $IP, $wgCityId, $wgExternalDatawareDB;

$onlyEnt = true;

$wgUser = User::newFromName( 'Wikia Video Library' );
$dbw = wfGetDB( DB_SLAVE );

$cachecategories = array();
$rows = $dbw->select('categorylinks',
	'*',
	array('cl_to'=>'IGN_entertainment')
);
while($row = $dbw->fetchObject($rows)) {
	$cachecategories[$row->cl_from] = true;
}
$dbw->freeResult($rows);


$rows = $dbw->select('image',
	'*',
	array('img_media_type'=>'VIDEO','img_minor_mime'=>'ign')
);

$count = 0;

$all = array();
$by_category = array();
$by_category2 = array();
$count = 0;

while($row = $dbw->fetchObject($rows)) {
	$count++;
	//if($count>30) break;
	$name = $row->img_name;
	$title = Title::newFromText($name, NS_FILE);
	if($onlyEnt && !isset($cachecategories[$title->getArticleID()]) ) {
		continue;
	}

	$wgTitle = $title;
	$file = wfFindFile( $name );
	if( $file->exists() ) {
		//echo "working on $name\n";
		$url = WikiFactory::getLocalEnvURL($title->getFullUrl());
		$row->url = $url;
		$meta = $row->img_metadata;
		$metaU = unserialize($meta);
		$row->title = $metaU['title'];
		$row->cat = $metaU['category'];
		$all[$name] = $row;

		if($onlyEnt) {
			$found = false;
			$key2 = $metaU['category'];
			if(!isset($by_category2[$key2])) {
				$by_category2[$key2] = array();
			}
			$by_category2[$key2][] = $name;
		}

		$k = $metaU['keywords'];
		foreach ( explode(',', $k) as $key) {
			if(!isset($by_category[$key])) {
				$by_category[$key] = array();
			}
			$by_category[$key][] = $name;
		}
		$key2 = $metaU['category'];
		if(!isset($by_category2[$key2])) {
			$by_category2[$key2] = array();
		}
		$by_category2[$key2][] = $name;
	}
}

ksort($by_category);
foreach( $by_category as $cat=>&$contents) {
	asort($contents);
}
ksort($by_category2);
foreach( $by_category2 as $cat=>&$contents) {
	asort($contents);
}

echo "<html>";
echo "<body>";
echo "<style>a {text-decoration: none}</style>";

echo "<a name='#top'></a>";
echo "<ul>";

$count = count($all);

echo "<li><a href='#all'><b>=== All ($count) ===</b></a></li>";
//foreach( $by_category2 as $cat=>$contents) {
//	$count = count($contents);
//	$cate = base64_encode($cat);
//	echo "<li><a name='top_c2$cate' href='#c2$cate'><b>== $cat ($count) ==</b></a></li>";
//}
foreach( $by_category as $cat=>$contents) {
	$count = count($contents);
	$cate = base64_encode($cat);
	echo "<li><a name='top_$cate' href='#$cate'><b>$cat ($count)</b></a></li>";
}

echo "<ul>";
echo "<li><a name='all'><h1>All</h1></a></li>";

echo "<ul>";
foreach ($all as $name => $data) {
	$url = $data->url;
	$im = $data->img_name;
	$vname = $data->title;
	echo "<li><a href='$url'>$vname</a> $im</li>";
}
echo "</ul>";

/*
foreach($by_category2 as $cat=>$contents) {
	$cate = base64_encode($cat);
	echo "<li><a name='c2$cate'><h1>$cat</h1></a></li>";
	echo "<a href='#top_c2$cate'>Back</a>";
	echo "<ul>";

	foreach( $contents as $vid ) {
		$data = $all[$vid];
		$name = $vid;
		$url = $data->url;
		$im = $data->img_name;
		$vname = $data->title;
		echo "<li><a href='$url'>$vname</a> $im</li>";
	}

	echo "</ul>";

}
*/

foreach($by_category as $cat=>$contents) {
	$cate = base64_encode($cat);
	echo "<li><a name='$cate'><h1>$cat</h1></a></li>";
	echo "<a href='#top_$cate'>Back</a>";
	echo "<ul>";

	foreach( $contents as $vid ) {
		$data = $all[$vid];
		$name = $vid;
		$url = $data->url;
		$im = $data->img_name;
		$vname = $data->title;
		$cname = $data->cat;
		echo "<li><a href='$url'>[$cname] $vname</a> $im</li>";
	}

	echo "</ul>";

}

echo "</ul>";

echo "</body>";
echo "</html>";
