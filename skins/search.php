<?php
if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

require_once('includes/SkinTemplate.php');

class SkinSearch extends SkinTemplate {
	function initPage( &$out ) {
		SkinTemplate::initPage( $out );
		$this->skinname  = 'search';
		$this->stylename = 'search';
		$this->template  = 'SearchTemplate';
	}
}

class SearchTemplate extends QuickTemplate {
	function execute() {
 		global $wgRequest;
		global $wgTitle;
		global $wgArticle;
		global $wgOut;
		global $wgParser;

		// create xml document
		$xml = new DOMDocument('1.0', 'utf-8');

		// create article node
		$article = $xml->createElement('article');
		$article->setAttribute('ismainpage', $wgArticle->getTitle()->getText() == wfMsg("mainpage") ? "1" : "0");

		// add title element to article node
		$title = $xml->createElement('title', $wgArticle->getTitle()->getPrefixedText());
		$article->appendChild($title);

		// prepare and add content element to article node
		if ( $wgTitle->getNamespace() == NS_IMAGE ) {
			$content = $wgParser->parse( $wgArticle->getContent(), $wgTitle, $wgOut->parserOptions())->getText();
		} else {
			$content = $this->data['subtitle'] . ' ' . $this->data['bodytext'];
		}

		$content_el = $xml->createElement('content');
		$content_el->appendChild($xml->createCDATASection($this->processContent($content)));
		$article->appendChild($content_el);

		$url = $xml->createElement('url', $wgArticle->getTitle()->getFullURL());
		$article->appendChild($url);


		$xml->appendChild($article);
		header('Content-Type: text/xml');
		die($xml->saveXML());
	}

	function html2txt($document){
		$search = array('@<script[^>]*?'.'>.*?</script>@si',  // Strip out javascript
						'@<style[^>]*?'.'>.*?</style>@siU',    // Strip style tags properly
						'@<[\/\!]*?[^<>]*?'.'>@si',            // Strip out HTML tags
						'@<![\s\S]*?--[ \t\n\r]*>@'        // Strip multi-line comments including CDATA
						);
		$text = preg_replace($search, '', $document);
		return $text;
	}

	function processContent($content) {
		global $wgTitle;

		$content = trim($this->html2txt($content));

		// .. delete last line of text which is: Retrieved from...
		if ( $wgTitle->getNamespace() != NS_IMAGE ) {
			$content_a = split("\n", $content);
			array_pop($content_a);
			$content = join("\n", $content_a);
		}

		// .. delete all links to edit section
		$content = str_replace('[' . wfMsg('editsection') . ']', ' ', $content);

		// .. delete all links to enlarge image
		$content = str_replace('[' . wfMsg('thumbnail-more') . ']', ' ', $content);

		// .. delete some special chars
		$content = preg_replace('~^(\s*)(.*?)(\s*)$~m', "\\2", $content);

		// .. delete multiple whitespaces
		$content = preg_replace('/\s\s+/', ' ', $content);

		return $content;
	}
}
?>
