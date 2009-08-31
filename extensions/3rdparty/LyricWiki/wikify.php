<?php
////
// Author: Sean Colombo
// Date: 20070904
//
// This will be similar to the tool Lentando had a while ago which will
// make it easier to create an album-listing's wikitext from the discography on wikipedia.
//
// TODO:
//	Format the titles to meet [[LW:PN]] automatically.
//	Split the page vertically (request on the left, result on the right, make the ad be a small one across the top).
//
// FUTURE IDEAS:
//	Eventually just let the user paste in the wikipedia page-name and scrape it from there?
//	Make an auto-detect option for the format (and have that be the default)... it should be expected to be REALLY accurate (99%+).
////

define('METHOD_WIKIPEDIA_QUOTED', "METHOD_WIKIPEDIA_QUOTED");
define('METHOD_LIST_PLAIN', "METHOD_LIST_PLAIN");
define('METHOD_LIST_NUMBERED', "METHOD_LIST_NUMBERED");
define('METHOD_ALLMUSIC', "METHOD_ALLMUSIC");

if(getPost('formName') == "wikifyAlbum"){
	wikify_album();
}

dispForm();
dispFooter();

////
// Displays an informational footer with credits, external resources (links) etc.
////
function dispFooter(){
	print "<small>\n";
	print "This tool was inspired by <a href='http://lyricwiki.org/User:Lentando'>Lentando</a>'s wikify script which we now also host the <a href='http://lyricwiki.org/wikify_Lentando.php'>original version</a> of.<br/>";
	print "This tool is currently maintained by <a href='http://lyricwiki.org/User:Sean_Colombo'>Sean Colombo</a>.  Please leave bug reports / feature requests on <a href='http://lyricwiki.org/User_talk:Sean_Colombo'>Sean's talk page</a>.";
	print "</small>\n";
} // end dispFooter()

////
// Returns an array of the methods of parsing available.
////
function getMethods(){
	return array(
		METHOD_WIKIPEDIA_QUOTED => "Wikipedia (surrounded by quotes)",
		METHOD_ALLMUSIC => "Allmusic.com format",
		METHOD_LIST_PLAIN => "List (one song per line... no numbers or other extra text)",
		METHOD_LIST_NUMBERED => "Numbered List",
	);
} // end getMethods()

////
// Displays the form prompting for the album input.
////
function dispForm(){
	print "<form method='post' action=''>\n";
	print "<fieldset style='background-color:#ccc;'>\n";
	print "<input type='hidden' name='formName' value='wikifyAlbum'/>\n";

	print "<input type='text' name='artist' value=\"".getPost('artist')."\"/> Artist<br/>\n";
	print "<input type='text' name='album' value=\"".getPost('album')."\"/> Album name<br/>\n";
	print "<input type='text' name='year' value='".getPost('year')."'/> Year<br/>\n";
	print "Raw discography:<br/>\n";
	print "<textarea name='discog' rows='15' cols='100'>";
	print getPost('discog');
	print "</textarea><br/>\n";

	$methods = getMethods();
	if(count($methods) > 1){
		$name = "method";
		foreach($methods as $key=>$description){
			$selected = ((getPost($name)==$key)?" checked='checked'":"");
			print "<label><input type='radio' name='$name' value='$key'$selected/> $description<br/></label>\n";
		}
	} else if(count($methods) == 1){
		$keys = array_keys($methods);
		$key = $keys[0];
		print "<input type='hidden' name='method' value='$key'/> Parsing for <em>$methods[$key]</em> discography.<br/>\n";
	}

	print "<input type='submit' name='submit' value='Wikify Album'/>\n";
	print "</fieldset>\n";
	print "</form>\n";
} // end dispForm()

////
// Will print out the wikitext for the album.
////
function wikify_album(){
	$artist = getPost('artist');
	$album = getPost('album');
	$year = getPost('year');
	$discog = getPost('discog');
	$wikiText = "";

	$wikiText .= "==[[$artist:$album ($year)|$album ($year)]]==\n";

	$method = getPost('method', METHOD_WIKIPEDIA_QUOTED);
	switch($method){
	case METHOD_LIST_PLAIN:
		$songs = explode("\n", $discog);
		foreach($songs as $currSong){
			$wikiText .= wikify_track($artist, trim($currSong));
		}
		break;
	case METHOD_LIST_NUMBERED:
		$songs = explode("\n", $discog);
		foreach($songs as $currSong){
			$currSong = preg_replace("/^[0-9]+.\s*/", "", $currSong);
			$wikiText .= wikify_track($artist, trim($currSong));
		}
		break;
	case METHOD_ALLMUSIC:
		$maxTrackNum = 0;
		$tracksFound = 0;
		$songs = explode("\n", $discog);
		foreach($songs as $currSong){
			$matches = array();
			if((0 < preg_match("/^[^\t]+\t[^\t]+\t([^\t]+)\t[^\t]+\t([^\t]+)\t[^\t]+\t[^\t]+$/", $currSong, $matches))
			||(0 < preg_match("/^[^\t]+\t[^\t]+\t([^\t]+)\t[^\t]+\t([^\t]+)\t[^\t]*\t[^\t]+$/", $currSong, $matches))){
				$tracksFound++;

				$trackNum = trim($matches[1]);
				$maxTrackNum = max((int)$trackNum, (int)$maxTrackNum);

				$currSong = trim($matches[2]);
				$currSong = preg_replace("/\s*\[#\]$/", "", $currSong); // special case: sometimes there is a trailing "[#]"
				$currSong = preg_replace("/\s*\[live\/#\]$/", "", $currSong); // special case: sometimes there is a trailing "[live/#]"

				$wikiText .= wikify_track($artist, $currSong);
			}
		}

		// TODO: Consider adding this check to all  of the other methods (or at least all with tracknums).
		if($tracksFound != $maxTrackNum){
			print "<div style='background-color:#ffc;font-weight:bold;font-size:150%'>";
			print "WARNING: The wikifier found $tracksFound tracks, but the largest track number was $maxTrackNum";
			print "</div>\n";
		}
		break;
	case METHOD_WIKIPEDIA_QUOTED:
	default:
		$matches = array();
		if(0 < preg_match_all("/(^|\n)[^\n]*?\"(.*?)\"[^\n]*/is", $discog, $matches)){
			$songs = $matches[2];
			foreach($songs as $currSong){
				$wikiText .= wikify_track($artist, $currSong);
			}
		} else {
			dispError("No match found");
		}
		break;
	}

	print "<textarea rows='15' cols='100'>$wikiText</textarea>\n";
} // end wikify_album()

////
// Given an artist and song, returns the line of wikitext that represents it in a track-listing.
////
function wikify_track($artist, $songName){
	$wikiText = "";

	// TODO: OMG MAKE TITLES COMPLY WITH [[LW:PN]] - TRY TO MAKE IT SO THIS FUNCTION IS THE SAME AS getTitle IN server.php SO THAT IT ONLY HAS TO BE MAINTAINED IN ONE PLACE.
	$songName = ucwords($songName);
	$artist = ucwords($artist);

	$songName = strtr($songName, "[]", "()"); // brackets aren't allowed in wiki names

	$wikiText .= "# '''[[$artist:$songName|$songName]]'''\n";
	return $wikiText;
} // end wikify_track()

////
// Returns the key from the POST or empty-string if not found.
////
function getPost($key, $default=""){
	$retVal = $default;
	if(isset($_POST[$key])){
		$retVal = $_POST[$key];
	}
	return $retVal;
} // end getPost()

function dispError($msg){
	print "<div style='background-color:#fcc;border:1px #f00;font-weight:bold'>$msg</div>\n";
} // end dispError()

?>
