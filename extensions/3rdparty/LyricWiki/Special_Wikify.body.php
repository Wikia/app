<?php

require_once 'extras.php';

class Wikify extends SpecialPage
{
	function __construct()
	{
		parent::__construct("Wikify");
	}

	function displayError( $error )
	{
		global $wgOut;
		$wgOut->addHTML("<div style='background-color:#ffc;font-weight:bold;font-size:150%'>$error</div>");
	}


	function formatTrack($songName)
	{
		$songName = trim($songName);
		return wfMsg("wft-track", $this->artist,mb_ucwords($songName),$songName)."\n";
	}
	function format_musicbrainz( $discog )
	{
		$result = "";

		$lines = explode("\n", $discog );
		foreach( $lines as $line )
		{
			$m = array();
			if( 0 < preg_match("/^[ \t]*([0-9]+)\s+(.*?)(PUID|[0-9]+:[0-9]+|$)/",$line,$m) )
			{
				$result .= $this->formatTrack($m[2]);
			}
		}

		return $result;
	}
	function format_discogs ($discog)
	{
		$result = "";
		
		$lines = explode("\n", $discog );
		foreach( $lines as $line )
		{
			$m = array();
			if( 0 < preg_match("/^[0-9]*\s*([^\t]+?)\s*([0-9]+:[0-9]+|$)/",$line,$m) )
			{
				$result .= $this->formatTrack($m[1]);
			}
		}

		return $result;
	}
	function format_plain_list( $discog )
	{
		$result = "";

		$songs = explode("\n", $discog);
		foreach($songs as $currSong)
		{
			$result .= $this->formatTrack($currSong);
		}

		return $result;
	}
	function format_allmusic( $discog )
	{
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

				$wikiText .= $this->formatTrack($currSong);
			}
		}

		// TODO: Consider adding this check to all  of the other methods (or at least all with tracknums).
		if($tracksFound != $maxTrackNum)
		{
			$this->displayError(wfMsg("wft-error-toofewtracks",$tracksFound,$maxTrackNum));
		}
	}
	function format_numbered_list( $discog )
	{
		$result = "";

		$songs = explode("\n", $discog);
		foreach($songs as $currSong)
		{
			$currSong = preg_replace("/^[ \t]*[0-9]+.\s*/", "", $currSong);
			$result .= $this->formatTrack($currSong);
		}

		return $result;
	}
	function format_wikipedia_quoted( $discog )
	{
		$result = "";
		$matches = array();
		if(0 < preg_match_all("/(^|\n)[^\n]*?\"(.*?)\"[^\n]*/is", $discog, $matches))
		{
			$songs = $matches[2];
			foreach($songs as $currSong)
			{
				$result .= $this->formatTrack($currSong);
			}
		}
		else
		{
			$this->displayError(wfMsg("wft-error-nomatch"));
		}
		return $result;
	}



	function getMethods()
	{
		// search this class for all functions that start with 'format_'
		// use these as the available options for formatting
		// The text used for the radio buttons is pulled from .i18n.php and can
		// be modified from within MediaWiki by administrators
		$self = new ReflectionClass('Wikify');
		$result = array();

		$methods = $self->getMethods();
		foreach($methods as $key=>$value)
		{
			if( strpos($value->getName(),"format_") === 0 )
			{
				$name = $value->getName();
				$result[] = substr($name,7);
			}
		}
		return $result;
	}


	function submitButton( $name )
	{
		global $wgOut;

		$wgOut->addHTML("<input id='wp$name' name='wp$name' type='submit' value='".wfMsg("wft-$name")."' accesskey='".wfMsg("wft-$name-key")."' title='".wfMsg("wft-$name")." [".wfMsg("wft-$name-key")."]' />");
	}

	function form()
	{
		// This is the form on the page.  These are the fields:
		//	artist, album, year - self explainitory
		//  cover - add a template for 
		//	discog - the discography to be converted
		//	method - the method to apply to the discography
		//	wpwikify - submit to wikify
		global $wgOut,$wgRequest;

		$wgOut->addHTML("<form method='post' action=''>");

		$wgOut->addHTML("<input type='text' name='artist' value=\"".htmlentities($wgRequest->getVal('artist'), ENT_QUOTES)."\"/> ".wfMsg("wft-artist")."<br/>");
		$wgOut->addHTML("<input type='text' name='album' value=\"".htmlentities($wgRequest->getVal('album'), ENT_QUOTES)."\"/> ".wfMsg("wft-album")."<br/>");
		$wgOut->addHTML("<input type='text' name='year' value='".htmlentities($wgRequest->getVal('year'), ENT_QUOTES)."'/> ".wfMsg("wft-year")."<br/>");
		$wgOut->addHTML("<input type='checkbox' name='cover'".($wgRequest->getVal('cover') ? " checked" : "" )." /> ".wfMsg("wft-showcover")."<br/>");
		$wgOut->addHTML(wfMsg("wft-discog").":<br/>");
		$wgOut->addHTML("<textarea name='discog' rows='15' cols='100'>");
		$wgOut->addHTML($wgRequest->getVal('discog'));
		$wgOut->addHTML("</textarea><br/>");

		// generate a list of available formats
		$methods = $this->getMethods();
		if(count($methods) > 1)
		{
			foreach($methods as $method)
			{
				$selected = (($wgRequest->getVal("method")==$method)?" checked='checked'":"");
				$wgOut->addHTML("<label><input type='radio' name='method' value='$method'$selected/> ".wfMsg("wft-$method-desc")."<br/></label>");
			}
		}
		else if(count($methods) == 1)
		{
			$method = $methods[0];
			$wgOut->addHTML("<input type='hidden' name='method' value='$method'/> Parsing for <em>".wfMsg("wft-$method-desc")."</em> discography.<br/>");
		}
		else
		{
			$wgOut->addHTML(wfMsg('wft-error-noformats'));
		}

		// buttons
		$this->submitButton("wikify");
		$wgOut->addHTML("</form>");
		$wgOut->addHTML("<small>".wfMsgWikiHtml("wft-footer")."</small>");
	}

	function wikify_album()
	{
		global $wgRequest,$wgOut;

		$this->artist = trim(mb_ucwords($wgRequest->getVal('artist')));
		$this->album = trim($wgRequest->getVal('album'));
		$this->year = trim($wgRequest->getVal('year'));
		$discog = trim($wgRequest->getVal('discog'));

		$method = $wgRequest->getVal('method',null);
		if( $method )
		{
			if( in_array( $method, $this->getMethods() ) )
			{
				if($wgRequest->getVal('cover') )
				{
					$wikiText = wfMsgNoTrans("wft-album-header",$this->artist,mb_ucwords($this->album),$this->album,$this->year)."\n";
				}
				else
				{
					$wikiText = wfMsgNoTrans("wft-album-header-nocover",$this->artist,mb_ucwords($this->album),$this->album,$this->year)."\n";
				}
				
				$wikiText .= $this->{"format_".$method}( $discog );
				$wikiText .= wfMsgNoTrans("wft-album-footer",$this->artist,$this->album,$this->year)."\n\n";

				$wgOut->addHTML("<textarea rows='15' cols='100'>$wikiText</textarea>");
			}
			else
			{
				$this->displayError(wfMsg("wft-error-unknownmethod",$method));
			}
		}
	}

	function execute( $par )
	{
		$this->setHeaders();	// this is required for 1.7.1 to work
		global $wgRequest, $wgOut;

		if( $wgRequest->getVal("wpwikify") )
		{
			$this->wikify_album();
		}
		$this->form();
	}
}

////
// A ucwords() function which takes into account foreign chars also. (the MB stands for multi-byte).
// This was courtesy of strazds at gmail dot com from http://us2.php.net/manual/en/function.ucwords.php
////
function mb_ucwords($str) {
	$str = mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
	return ($str);
}
