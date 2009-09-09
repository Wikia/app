<?php

/**
 * WikiaApiLyricwiki
 *
 * @author Lucas Garczewski <tor@wikia-inc.com>
 *
  * $Id: WikiaApiQueryDomains.php 12417 2008-05-07 09:33:11Z eloy $
 */

$wgAPIModules['lyrics'] = 'WikiaApiLyricwiki';

class WikiaApiLyricwiki extends ApiBase {

	/**
	 * constructor
	 */
	public function __construct($query, $moduleName) {
		parent :: __construct($query, $moduleName );
	}

	/**
	 * main function
	 */
	public function execute() {
		global $IP;

		require( "$IP/extensions/3rdparty/LyricWiki/server.php" );

		$func = $song = $artist = $fmt = null;

		extract( $this->extractRequestParams() );

		switch ( $func ) {
			case 'getArtist':
				$this->getArtist( $artist, $fmt );
				break;
			case 'getSong':
			default:
				$this->getSong( $artist, $song, $fmt );
				break;
		}

		// TODO: hand over handling to MW API instead of doing this...
		exit (1);
	}

	function getArtist( $artist, $fmt ) {

		if (empty( $fmt ) )
			$fmt = 'text';
		

		switch ( $fmt ) {
			case 'text':
	                        $result = getArtist($artist);

	                        // This is just a raw line-delimited list of tracks.
        	                $artist = getVal($result, 'artist');
	                        $albums = $result['albums'];
	                        foreach($albums as $currAlbum){
	                                $tracks = $currAlbum['songs'];
	                                sort($tracks);
        	                        foreach($tracks as $currTrack){
	                                        if(strpos($currTrack, ":") !== false){
        	                                        print "$currTrack\n"; // a track listing that already has the artist in it
                	                        } else {
                        	                        print "$artist:$currTrack\n";
                                	        }
					}
	                        }

				break;
			case 'html':
	                        $this->htmlHead("$artist");

	                        $result = getArtist($artist);
	                        $artist = getVal($result, 'artist');
	                        $albums = $result['albums'];
	                        print "<h3><a href='$root".$this->linkEncode($artist)."'>$artist</a></h3>\n";
				print "<a href='" .$result['url'] . "'/>" . $result['song'] . "</a>";
	                        if(count($albums) > 0){
	                                print "<ul class='albums'>\n";
	                                foreach($albums as $currAlbum){
	                                        $albumName = getVal($currAlbum, 'album');
	                                        $year = getVal($currAlbum, 'year');
	                                        $amznLink = getVal($currAlbum, 'amazonLink');
	                                        $songs = getVal($currAlbum, 'songs');
	                                        print "<li><a href='$root".$this->linkEncode("$artist:$albumName".($year==""?"":"_($year)"))."'>$albumName".($year==""?"":"_($year)")."</a>";
        	                                if($amznLink != ""){
                	                                print " - (at <a href='$amznLink' title=\"$albumName at amazon\">amazon</a>)";
                        	                }
	                                        if(count($songs) > 0){
	                                                print "<ul class='songs'>\n";
	       	                                        foreach($songs as $currSong){
        	                                                if(strpos($currSong, ":") !== false){
                	                                                print "<li><a href='$root".$this->linkEncode($currSong)."'>$currSong</li>\n";
                        	                                } else {
                                	                                print "<li><a href='$root".$this->linkEncode("$artist:$currSong")."'>$currSong</li>\n";
                                        	                }
	                                                }
        	                                        print "</ul>\n";
                	                        }
					}
	                                print "</ul>\n";
				}

	                        // Make it extensible by displaying any extra data in a UL.
	                        unset($result['artist']);
	                        unset($result['albums']);
	                        if(count($result) > 0){
	                                print "<hr/>Additional Info:\n";
	                                print "<ul>\n";
	                                foreach($result as $keyName=>$val){
	                                        if(0 < preg_match("/^http:\/\//", $val)){
	                                                $val = "<a href='".str_replace(" ", "_", $val)."' title='$keyName'>$val</a>\n";
	                                                print "<li><strong>$keyName: </strong>$val</li>\n";
	                                        } else {
	                                                print "<li><strong>$keyName: </strong>$val</li>\n";
	                                        }
	                                }
        	                        print "</ul>\n";
                	        }
                        	print "</body>\n</html>\n";
				break;
			case "xml" :
	                        header('Content-Type: application/xml', true);
	                        print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	                        //print "<getArtistResponse>\n";
	                        $result = getArtist($artist);
	                        $result = array("getArtistResponse" => $result);
	                        $this->dumpXML($result);
	                        //print "</getArtistResponse>\n";
				break;
		}
	}

	function getSong( $artist, $song, $fmt ) {
		// Phase 'title' out (deprecated).  this is not the same as the soap.  I was coding too fast whilst in an IRC discussion and someone said artist/title just for the sake of argument and I didn't check against the SOAP :[ *embarassing*
		$songName = getVal($_GET, 'song', getVal($_GET, 'title'));
		$artist = getVal($_GET, 'artist');

		// I'm not sure why, but in this context underscores don't behave like spaces automatically.
		$artist = str_replace("_", " ", $artist);
		$songName = str_replace("_", " ", $songName);
		$songName .= (!empty($debug)?"_debug":"");
#die( 'foobar' );

		$client = strtolower(getVal($_GET, 'client'));

		if(($client == "cantopod") || ($client == "cantophone")){

			// Kind of a custom format
			header('Content-Type: application/xml', true);
			print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
			print "<item>\n";

			$result = getSong($artist, $songName);
			die( var_dump( $result) );

			if($client == "cantophone"){
				$link = getVal($result, 'url');
				$link = str_replace("http://lyricwiki.org/", "http://www.staylazy.net/canto/online/x/lyricwiki/rss_lyrics.php?artist=", $link);
				$link = preg_replace("/^(.*?):\/\/(.*?):/", "$1://$2&songtitle=", $link);

				print "\t<link>".htmlspecialchars($link, ENT_QUOTES, "UTF-8")."</link>\n";
				print "\t<artist>".htmlspecialchars(getVal($result, 'artist'), ENT_QUOTES, "UTF-8")."</artist>\n";
				print "\t<song>".htmlspecialchars(getVal($result, 'song'), ENT_QUOTES, "UTF-8")."</song>\n";
//				print "\t<lyrics>".htmlspecialchars(getVal($result, 'lyrics'), ENT_QUOTES, "UTF-8")."</lyrics>\n";
			} else {
				foreach($result as $keyName=>$val){
					if($keyName == "url"){
						$keyName = "link";
						$val = str_replace("http://lyricwiki.org/", "http://www.staylazy.net/canto/online/x/lyricwiki/rss_lyrics.php?artist=", $val);
						$val = preg_replace("/^(.*?):\/\/(.*?):/", "$1://$2&songtitle=", $val);
					}
					print "\t<$keyName>".htmlspecialchars($val, ENT_QUOTES, "UTF-8")."</$keyName>\n";
				}
			}
			print "</item>\n";

		} else if($fmt == "text"){
			$result = getSong($artist, $songName);
			print $result['url'];
//			print utf8_decode($result['lyrics']);
		} else if($fmt == "js"){
			$result = getSong($artist, $songName);
			$this->writeJS($result['url']);
		} else if($fmt == "json"){
			$result = getSong($artist, $songName);
			$this->writeJSON($result['url']);
		} else if ($fmt == "html"){
			// Link to the song & artist pages as a heading.
			$result = getSong($artist, $songName);

			$this->htmlHead($result['artist']." ".$result['song']." lyrics");
			print "<h3><a href='$root".$this->linkEncode($result['artist'].":".$result['song'])."'>".utf8_decode($result['song'])."</a> by <a href='$root".$this->linkEncode($result['artist'])."'>".utf8_decode($result['artist'])."</a></h3>\n";

//			print "<pre>\n";
//			print utf8_decode($result['lyrics']);
//			print "</pre>";

			// Make it extensible by displaying any extra data in a UL.
			unset($result['artist']);
			unset($result['song']);
			unset($result['lyrics']);
			if(count($result) > 0){
				print "<hr/>Additional Info:\n";
				print "<ul>\n";
				foreach($result as $keyName=>$val){
					if(0 < preg_match("/^http:\/\//", $val)){
						$val = "<a href='$val' title='$keyName'>".utf8_decode($val)."</a>\n";
						print "<li><strong>$keyName: </strong>$val</li>\n";
					} else {
						print "<li><strong>$keyName: </strong>".utf8_decode($val)."</li>\n";
					}
				}
				print "</ul>\n";
			}
			print "</body>\n</html>\n";
		} else if($fmt == "xml"){
			header('Content-Type: application/xml', true);
			print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
			print "<LyricsResult>\n";
			$result = getSong($artist, $songName);
			foreach($result as $keyName=>$val){
				if ($keyName != 'lyrics' ) {
					print "\t<$keyName>".utf8_decode(htmlspecialchars($val, ENT_QUOTES, "UTF-8"))."</$keyName>\n";
				}
			}
			print "</LyricsResult>\n";

		}
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: WikiaApiQueryDomains.php 12417 2008-05-07 09:33:11Z eloy $';
	}

	public function getDescription() {
		return "Get wiki article URL for given artist or song";
	}

	public function getAllowedParams() {
		return array (
			"artist" => array(
				ApiBase::PARAM_TYPE => 'string'
			),
			"song" => array(
				ApiBase::PARAM_TYPE => 'string'
			),
			"fmt" => array(
				ApiBase::PARAM_TYPE => 'string'
			),
			"func" => array(
				ApiBase::PARAM_TYPE => 'string'
			)
		);
	}

	public function getParamDescription() {
		return array (
			"artist" => "Artist's name",
			"song" => "Song name",
			"fmt" => "Response format",
			"func" => "Query type",
		);
	}

	public function getExamples() {
		return array (
			"api.php?action=lyrics&artist=Joe%20Bonamassa&song=So%20Many%20Roads&fmt=xml&func=getSong"
		);
	}

	function htmlHead($title){
        ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php print utf8_decode("$title"); ?></title>
</head>
<body><?php
	}

	////
	// Turns a song-name, link into the format that we'd prefer for linking.
	////
	function linkEncode($pageName){
        	$pageName = str_replace(" ", "_", $pageName);
	        $pageName = urlencode($pageName);
	        $pageName = str_replace("%3A", ":", $pageName);
	        return $pageName;
	}

// The second parameter is the optional indentation at the start of this item (used for recursion).
////
	function dumpXML($dataArray, $tabs=""){
        if(is_array($dataArray)){
                $cnt = 0;
                foreach($dataArray as $tag => $val){
                        if(is_array($val) && ($cnt === $tag)){
                                if(isset($val['album']) && isset($_GET['fixXML'])){ // TODO: HACK: This is actaully lame... what we SHOULD be doing is making a way to name each of these results (so other things can do the same thing that albumResult is doing here).
                                        print "$tabs<albumResult>\n";
                                        $tabs = "\t$tabs";
                                }
                                $this->dumpXML($val, $tabs);
                                if(isset($val['album']) && isset($_GET['fixXML'])){
                                        $tabs = substr($tabs, -1);
                                        print "$tabs</albumResult>\n";
                                }
                        } else {
                                if($cnt === $tag){
                                        $tag = "item";
                                }
                                print "$tabs<$tag>";
                                if(is_array($val)){
                                        print "\n"; // keeps bottom-level items one-liners
                                }
                                $this->dumpXML($val, "\t$tabs");
                                if(is_array($val)){
                                        print "$tabs";
                                }
                                print "</$tag>\n";
                        }
                        $cnt++;
                }
        } else {
                print htmlspecialchars($dataArray, ENT_QUOTES, "UTF-8");
        }
	} // end dumpXML()

//////////////////////////////////////////////////////////////////////////////
// Thanks to Stefan Fussenegger (Fuzy) for the code which the below code is based on (he released his code to public-domain).
//////////////////////////////////////////////////////////////////////////////
////
// escape strings for ' quoted JS strings
////
function escapeJavaScript($val) {
        // escape literal backslashes
        $val = str_replace('\\', '\\\\', $val);
        // escape '
        $val = str_replace("'", "\\'", $val);
        // replace new lines with \n
        $val = str_replace("\n", "\\n", $val);
        return $val;
}

////
// create object with JS code
////
function writeJS(&$results) {
        header('Content-type: text/javascript; charset=UTF-8');
        echo "function lyricwikiSong(){\n";
        echo "this.artist='".$this->escapeJavaScript(utf8_decode($results['artist']))."';\n";
        echo "this.song='".$this->escapeJavaScript(utf8_decode($results['song']))."';\n";
        echo "this.lyrics='".$this->escapeJavaScript(utf8_decode($results['lyrics']))."';\n";
        echo "this.url='".$this->escapeJavaScript($results['url'])."';\n";
        echo "}\n";
        echo "var song = new lyricwikiSong();\n";
}

////
// create object using JSON format
////
function writeJSON(&$results) {
        header('Content-type: text/javascript; charset=UTF-8');
        echo "song = {\n";
        echo "'artist':'".$this->escapeJavaScript(utf8_decode($results['artist']))."',\n";
        echo "'song':'".$this->escapeJavaScript(utf8_decode($results['song']))."',\n";
        echo "'lyrics':'".$this->escapeJavaScript(utf8_decode($results['lyrics']))."',\n";
        echo "'url':'".$this->escapeJavaScript($results['url'])."'\n";
        echo "}\n";
}


}
