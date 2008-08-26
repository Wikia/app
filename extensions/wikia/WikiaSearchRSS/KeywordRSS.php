<?php
header ("content-type: text/xml");

$offset = 60 * 15;	
$expire = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";

header( $expire );

$keyword = $_GET["k"];
$keyword = urldecode( $keyword );
if( ! $keyword ){
	die("Please specifiy a keyword");
}

//Can specifiy just specific tuples in querystring
$full_qs = split("&",$_SERVER['QUERY_STRING']);
$tuples_request = "";
foreach($full_qs as $qs){
	$var = split("=",$qs);
	if( count( $var ) > 1 && $var[0] == "t" ){
		$tuples_request .= "&t=" . $var[1];
	}
}

//SET UP JSON SERVICE
require_once( "JSON.php" );
$json = new Services_JSON();
 
//VARS
$search_url = "http://re.search.wikia.com";

$all_changes = array();
//$tuples = array("edit", "add", "spot", "del", "stars", "sug", "com", "bg", "to the result");
$tuple_text["edit"] = array( "action" => "edited", "result" => "for the result");
$tuple_text["add"] = array( "action" => "added", "result" => "to the result");
$tuple_text["spot"] = array( "action" => "spotlighted", "result" => "for the result");
$tuple_text["del"] = array( "action" => "deleted", "result" => "from the result");
$tuple_text["stars"] = array( "action" => "rated", "result" => "for the result");
$tuple_text["sug"] = array( "action" => "added the suggested result", "result" => "to the result");
$tuple_text["com"] = array( "action" => "commented on the URL", "result" => "for the result");
$tuple_text["bg"] = array( "action" => "changed the background", "result" => "for the result");
$tuple_text["selection"] = array( "action" => "annotated the URL", "result" => "for the result");
$tuple_text["also"] = array( "action" => "edited alternate searches", "result" => "for the result");

//GRAB THE JSON
if(  $tuples_request == "" ){
	$tuples_request = "&t=del&t=add&t=sug&t=spot&t=stars&t=edit&t=bg&t=com&t=selection&t=also";
}
$swLabsURL = "http://kt.search.isc.org/kttest/kt.js?max=30{$tuples_request}&k=" . str_replace(" ","%20",strtolower( $keyword ) ) . "&r=" . rand();

$changes_json = file_get_contents($swLabsURL);
$changes =  $json->decode($changes_json);

//POPULATE COMBINED ARRAY
foreach($tuple_text as $tuple => $tuple_desc){
	if( !is_array( $changes->$tuple ) ) continue;
	
	foreach( $changes->$tuple as $change ){
		$all_changes[] = array( "type" => $tuple, "item" => $change , "id" => $change->id );	
	}
}
	
usort($all_changes, "keywordChangesSorter");

//OUTPUT RSS
$xml = "<?xml version=\"1.0\"?>
	<rss version=\"2.0\" xmlns:content=\"http://purl.org/rss/1.0/modules/content/\">
	<channel>
	<title>Wikia Search Keyword Changes for \"{$keyword}\"</title>
	<link>{$search_url}/search.html#{$keyword}</link>
	<description>Search engine keyword changes</description>
	<language>en-us</language>
	<pubDate>" . date("r") . "</pubDate>
	<ttl>30</ttl>
	<image> 
	<url>http://fp029.sjc.wikia-inc.com/search/kt_files/front-logo.png</url>
		<title>Wikia Search Logo</title>
		<link>{$search_url}</link>
	
		<width>216</width>
		<height>86</height>
	 </image>
	<managingEditor>search@wikia.com</managingEditor>
	<webMaster>search@wikia.com</webMaster>";

foreach( $all_changes as $change ){
	
	//TIME
	$time = $change["id"] / (1000);
	$rfc_date = date("r", $time);
	
	//MODIFIER
	if( $change["type"] == "del" ){
		if( $change["item"]->del == 0 ){
			$label = "undeleted";
		}else{
			$label = "deleted";
		}
	}else{
		$label = $tuple_text[ $change["type"] ]["action"];
	}
	
	//ITEM
	if( $change["type"] == "sug" ){
		$item = $change["item"]->sug;
		$url = "$search_url/search.html#" . str_replace(" ","%20",htmlentities  ( $change["item"]->sug ));
	}else{
		$item = $change["item"]->url;	
		$url = $change["item"]->url;
	}
	
	if( $change["type"] == "bg" || $change["type"] == "also" ){
		$url = "$search_url/search.html#" .str_replace(" ","%20",htmlentities ($keyword) );
	}
	
	//Output number of Star Rating
	if( $change["type"] == "stars" ){
		$item .= " " . $change["item"]->rating . " stars ";
	}
	
	$details = "Changed by: <a href=\"{$search_url}/profile.html?user=" . str_replace(" ","_",$change["item"]->user) . "\">" . $change["item"]->user . "</a>";
	switch( $change["type"] ){
		case "edit":
			$details .= "<br><br>Title: " . $change["item"]->title . "<br><br>Summary: " . $change["item"]->summary;
			break;
		case "com":
			$details .= "<br><br>Comment: \"" . $change["item"]->com . "\"";
			break;
		case "also":
			$details .= "<br><br>Alternate searches:<br>";
			foreach( $change["item"]->also as $alternate_search ){
				$details .= "<a href=\"{$alternate_search}" .str_replace(" ","%20",htmlentities ($keyword) ) . "\">" . htmlentities ($alternate_search)  . "</a><br>";
			}
			break;
	}

	$title = $change["item"]->user . " " . $label . " " . $item;
	$title = htmlentities( trim($title) );
	
	$xml .= "<item>
			<title>$title</title>
			<description><![CDATA[" .  ($details) . "]]></description><content:encoded><![CDATA[$details]]></content:encoded>
			<link>{$url}</link>
			<pubDate>{$rfc_date}</pubDate>
			<guid isPermaLink=\"true\">" . $change["id"] . "</guid>
		</item>";	
}


$xml .= "\n</channel>
	</rss>";
	
echo $xml;

function keywordChangesSorter($a, $b){
	if($a["id"] == $b["id"]){
		return 0;
	}
	return ($a["id"] > $b["id"]) ? -1 : 1;
}

?>
