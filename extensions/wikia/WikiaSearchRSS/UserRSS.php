<?php
header ("content-type: text/xml");

$offset = 60 * 15;	
$expire = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";

header( $expire );

$user_name = $_GET["u"];
$user_name = urldecode( $user_name );
if( ! $user_name ){
	die("Please specifiy a username");
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
$image_url = "http://images.wikia.com/search/images/photos/static";

$all_changes = array();
//$tuples = array("edit", "add", "spot", "del", "stars", "sug", "com", "bg", "to the result","also");
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
$swLabsURL = "http://kt.search.isc.org/kttest/user.js?max=30{$tuples_request}&u=" . str_replace(" ","%20",$user_name ) . "&r=" . rand();
$changes_json = file_get_contents($swLabsURL);
$changes =  $json->decode($changes_json);

//POPULATE COMBINED ARRAY
foreach($tuple_text as $tuple => $tuple_desc){
	if( !is_array( $changes->$tuple ) ) continue;
	
	foreach( $changes->$tuple as $change ){
		$all_changes[] = array( "type" => $tuple, "item" => $change , "id" => $change->id, "timestamp" => $change->id / 1000 );	
	}
}


//BRING IN SOCIAL ACTIVITY
$wiki_url = "http://search.wikia.com/index.php?title=index.php&action=ajax&rs=wfGetUserBulletinsJSON&rsargs[]=" . str_replace(" ","%20",$user_name ) ;
 
$activity_json = file_get_contents($wiki_url);
$activity_json = str_replace("var json_bulletins=","", $activity_json);
$activity_json = str_replace(";\n\nwrite_activity(json_bulletins);","", $activity_json);
$activity_items =  $json->decode($activity_json);

foreach ($activity_items->activity->activity as $activity){
	$all_changes[] = array( "type" => "", "item" => $activity , "timestamp" => $activity->timestamp );	
}

usort($all_changes, "keywordChangesSorter");

$hash = md5($user_name);
$dir = substr( $hash, 0, 3 );
		
//OUTPUT RSS
$xml = "<?xml version=\"1.0\"?>
	<rss version=\"2.0\" xmlns:content=\"http://purl.org/rss/1.0/modules/content/\">
	<channel>
	<title>Wikia Search Activity Feed for \"{$user_name}\"</title>
	<link>{$search_url}/search.html#{$keyword}</link>
	<description>Search engine activity feed</description>
	<language>en-us</language>
	<pubDate>" . date("r") . "</pubDate>
	<ttl>30</ttl>
	<image> 
	<url>{$image_url}/{$dir}/" . str_replace(" ","",$user_name) . "-l.jpg</url>
		<title>Wikia Search Logo</title>
		<link>{$search_url}</link>
	 
	 </image>
	<managingEditor>search@wikia.com</managingEditor>
	<webMaster>search@wikia.com</webMaster>";

foreach( $all_changes as $change ){
	
	//TIME
	$rfc_date = date("r", $change["timestamp"]);
	
	if( !$change["type"] ){
		//SOCIAL ACTIVITY
		
		$title = "{$user_name} " . strip_tags($change["item"]->text);
		$url = "$search_url/profile.html?user={$user_name}";
		$details = "";
		if( $change["item"]->type == 1 || $change["item"]->type == 9 || $change["item"]->type == 3 ){
			$details = "<a href='$search_url/profile.html?user=" . $change["item"]->message . "'>Click here for " . $change["item"]->message . "'s profile</a>";	
		}
		 
	}else{
		//SEARCH ACTVITY
		
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
			$url = "$search_url/search.html#" .  htmlentities  ( $change["item"]->sug ) ;
		}else{
			$item = $change["item"]->url;	
			$url = $change["item"]->url;
		}
		
		if( $change["type"] == "bg" || $change["type"] == "also"  ){
			$url = "$search_url/search.html#" . htmlentities ($change["item"]->keyword)  ;
		}
		
		//Output number of Star Rating
		if( $change["type"] == "stars" ){
			$item .= " " . $change["item"]->rating . " stars ";
		}
		$item .= " " . $tuple_text[ $change["type"] ]["result"] . " \"" . $change["item"]->keyword . "\"";
		
		$details = "Keyword: <a href='" . "$search_url/search.html#" . htmlentities ($change["item"]->keyword)  . "'>" . $change["item"]->keyword . "</a><br>";
		$details .= "URL: <a href='{$url}'>$url</a><br><br>";
		switch( $change["type"] ){
			case "edit":
				$details .= "Title: " . $change["item"]->title . "<br><br>Summary: " . $change["item"]->summary;
				break;
			case "com":
				$details .= "Comment: \"" . $change["item"]->com . "\"";
				break;
			case "also":
				$details .= "Alternate searches:<br>";
				foreach( $change["item"]->also as $alternate_search ){
					$details .= "<a href=\"{$alternate_search}" . htmlentities ($change["item"]->keyword)   . "\">" . htmlentities ($alternate_search)  . "</a><br>";
				}
				break;
			
		}
		
	
		$title = $change["item"]->user . " " . $label . " " . $item;
		$title = htmlentities( trim($title) );
	}
	
	
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
	if($a["timestamp"] == $b["timestamp"]){
		return 0;
	}
	return ($a["timestamp"] > $b["timestamp"]) ? -1 : 1;
}

?>
