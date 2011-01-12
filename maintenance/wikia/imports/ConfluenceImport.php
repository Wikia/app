<?php

include( "/usr/wikia/source/wiki/maintenance/commandLine.inc" );
include( "WikiaImport.php" );

class ConfluenceWikiaImport extends WikiaImport {
	// @TODO these should be defined from the commandline
	var $remoteUrl = "http://chassisregister.com";
	var $remotePath = "/pages/viewpagesrc.action?pageId=";
	var $remotePathInfo = "/pages/pageinfo.action?pageId=";
	var $i = 119;

	function getSource() {
		parent::getSource();

		// this is where we should set a title...
		$this->getTitle();

		// check if this is the end
		if ( empty( $this->mSource ) || strpos( $this->mSource, "Enter your account details below to login to Confluence" ) ) {
			$this->msg( "Got login page at ID $i - QUITTING.", true );
			return false;
		}

		return true;
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

		$this->msg( $this->mTitle . " ", true );
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

		echo "\n\n\n" . $this->mContent . "\n\n\n";

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
		$this->msg( "1: " . strlen( $text ), true );

		// handle headers
		$text = preg_replace( "/h1\.(.*)/m", "= $1 =", $text );
		$this->msg( "2: " . strlen( $text ), true );
		$text = preg_replace( "/h2\.(.*)/m", "== $1 ==", $text );
		$this->msg( "5: " . strlen( $text ), true );
		$text = preg_replace( "/h3\.(.*)/m", "=== $1 ===", $text );
		$this->msg( "4: " . strlen( $text ), true );
		$text = preg_replace( "/h4\.(.*)/m", "==== $1 ====", $text );
		$this->msg( "5: " . strlen( $text ), true );

		// handle bold
		/* ... */

		// handle underlines
		/* ... */

		// handle external links
		// from [http://foo.com foo.com] to [http://foo]
		/* ... */
		$this->msg( "6: " . strlen( $text ), true );

		// from [link|text] to [[link|text]]
#		$text = preg_replace( "/\[([^]]+)|[([^]]+)\]/", "[[$1|$2]]", $text );
#		$this->msg( "7: " . strlen( $text ), true );
		// from [link] to [[link]]
		$text = preg_replace( "/\[([^]]+)\]/", "[[$1]]", $text );
		$this->msg( "8: " . strlen( $text ), true );

		// handle tables
		/* ... */

		$text = trim( $text );

		$this->mWikitext = $text;

		$this->msgStatus( true );

		return true;
	}
}

$import = new ConfluenceWikiaImport;
$import->execute();
