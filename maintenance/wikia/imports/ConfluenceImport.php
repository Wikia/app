<?php

include( "../../commandLine.inc" );
include( "WikiaImport.php" );

unset( $wgHTTPProxy );

class ConfluenceWikiaImport extends WikiaImport {
	// @TODO these should be defined from the commandline
	var $remoteUrl = "http://chassisregister.com";
	var $remotePath = "/pages/viewpagesrc.action?pageId=";
	var $remotePathInfo = "/pages/pageinfo.action?pageId=";
	var $i = 119;
	var $end = 0;
	var $parameters = array(
		'remoteUrl' => "What's the site's base URL?",
		'remotePath' => "What's the path to the source page?",
		'remotePathInfo' => "What's the path to the info page?",
		'i' => "Where shall I start counting?",
		'end' => "Where shall I stop?",
		'overwrite' => "Shall I overwrite existing articles?",
	);

	function getSource() {
		parent::getSource();

		// this is where we should set a title...
		$this->getTitle();

		// check if this is the end
		if ( empty( $this->mSource ) || strpos( $this->mSource, "Enter your account details below to login to Confluence" ) ) {
			$this->msg( "Got login page at ID $i - QUITTING.", true, true );
			return false;
		}

		return true;
	}

	function getUrl() {
		return $this->remoteUrl . $this->remotePath . $this->i;
	}

	function getTitle() {
		$this->mTitle = null;

		$url = $this->remoteUrl . $this->remotePathInfo . $this->i;

		$this->msg( "Getting page title... " );
		$source = Http::get( $url );

		$dom = new DOMDocument();

		$status = $dom->loadHTML( $source );

		$nodeList = $dom->getElementsByTagName( 'title' );

		$titleNode = $nodeList->item( 0 );		
		if ( empty( $titleNode ) ) {
			$this->msg( "Could not find node! " );
			$this->msgStatus( false );
		}

		$title = $titleNode->textContent;

		// @TODO this should be a variable
		$title = str_replace( " - Chassis Register", "", $title );

		$this->mTitle = $title;

		$this->msg( $this->mTitle . " " );
		$this->msgStatus( true );

		return true;
	}

	function getContent() {
		$this->mContent = null;
		$source = $this->mSource;

		$source = str_replace( 'class="padded"', 'id="confluence_content"', $source );

		// add DTD
		$dtd = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
		$source = $dtd . $source;

		$dom = new DOMDocument();

		echo "Loading document... ";
		$status = $dom->loadHTML( $source );
		$this->msgStatus( $status );

		$this->msg( "Validating document... " );
		$dom->validate();
		$this->msgStatus( true ); // we don't really care if it validates or not ;)

		$this->msg( "Looking for node... " );
		$node = $dom->getElementById( 'confluence_content' );
		$this->msgStatus( (bool) $node );

		$this->mContent = $dom->saveXML( $node );

		return (bool) $this->mContent;
	}

	function translate() {
		$this->mWikitext = '';
		$text = $this->mContent;

		$this->msg( "Translating from Confluence into standard MediaWiki... " );

		// remove the surrounding div first
		$text = trim( $text );
		$text = str_replace( '<div id="confluence_content">', "", $text );

		$text = substr_replace( $text, '', -6 );

		// get rid of <br>s
		$text = str_replace( "<br/>", "\n", $text );

		// handle headers
		$text = preg_replace( "/h1\.(.*)/", "= $1 =", $text );
		$text = preg_replace( "/h2\.(.*)/", "== $1 ==", $text );
		$text = preg_replace( "/h3\.(.*)/", "=== $1 ===", $text );
		$text = preg_replace( "/h4\.(.*)/", "==== $1 ====", $text );

		// handle bold
		$text = preg_replace( "/\*([^\*]+)\*/", "'''$1'''", $text );

		// handle italics
		$text = preg_replace( "/\b_([^_]+)_\b/", "''$1''", $text );

		// handle pre
		// @TODO this doesn't prevent the wrapped text from being "parsed" – it should
		$text = preg_replace( "/\{noformat\}(.*)\{noformat\}/ms", "<pre>$1</pre>", $text );

		// handle external links
		// from [http://foo.com foo.com] to [http://foo]
		$text = preg_replace( "/\[(http|ftp):\/\/(.*?)\|(.*?)]/", "[$1://$2 $3]", $text );

		// from [link|text] to [[link|text]]
		$text = preg_replace( "/\[([^\]]+)\|([^\]]+)\]/", "[[$1|$2]]", $text );

		// from [link] to [[link]]
		$text = preg_replace( "/\[([^]]+)\]/", "[[$1]]", $text );

		// cut out meta lists
		preg_match_all( "/\{metadata-list\}(.*?)\{metadata-list\}/s", $text, $metalists );
		$text = preg_replace( "/\{metadata-list\}.*?\{metadata-list\}/s", "!META-LIST-PLACEHOLDER!", $text );

		$metalists_translated = array();

		if ( !empty( $metalists ) ) {
			$i = 0;
			foreach ( $metalists[1] as $list ) {
				
				$metalists_translated[$i] = "{| class=\"wikitable\"";
				$list = preg_replace( "/\| *$/m", "", $list );
				$list = preg_replace( "/\|/", "||", $list );
				$list = preg_replace( "/^\|\|\|\|/m", "|-\n|", $list );

				$metalists_translated[$i] .= $list;
				$metalists_translated[$i] .= "|}\n";
				$i++;
			}
		}

		// handle tables
		$text = preg_replace( "/\|(?!\|)(.*)\|(?!\|)/", "|-\n|$1|", $text ); // separate rows first
		$text = preg_replace( "/\|\|-.\|/s", "{| class=\"wikitable\"\n! ", $text ); // mark beginning and headers

		$text = explode( "\n", $text );
		$tableState = false;
		foreach ( $text as &$l ) {
			if ( strpos( $l, "{|" ) === 0 ) {
				$tableState = true;
				continue;
			}

			if ( $tableState ) {
				if ( strpos( $l, "!" ) === 0 ) {
					// regex to correct headers
					$l = preg_replace( "/\|\|/", "!!", $l );
					$l = rtrim( $l, "!" );
				} elseif ( strpos( $l, "|" ) === 0 && trim( $l ) != "|-" ) {
					//regex to correct rows and cells
					// FIXME: this is fucking insane
					$l = substr( $l, 1 );
					$l = preg_replace( "/\|/", "$1||$2", $l );
					$l = rtrim( $l, "|" );
					$l = "|" . $l;
				} elseif ( trim( $l ) === "" ) {
					$l = "|}";
					$tableState = false;
				}

				continue;
			}
		}
		$text = implode( "\n", $text );

		// FIXME: this is awkward, use preg_replace_callback?
		foreach ( $metalists_translated as $t ) {
			$text = preg_replace( "/!META-LIST-PLACEHOLDER!/", $t, $text, 1 );
		}

		$text = trim( $text );

		$this->mWikitext = $text;

		$this->msgStatus( true );

		return true;
	}
}

$import = new ConfluenceWikiaImport;
$import->execute();
