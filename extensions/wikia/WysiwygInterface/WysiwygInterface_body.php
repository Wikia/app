<?php

class WysiwygParser extends Parser {

	/**
	 * Tag hook handler for 'pre'.
	 */
	function renderPreTag( $text, $attribs ) {
		// Backwards-compatibility hack
		$content = StringUtils::delimiterReplace( '<nowiki>', '</nowiki>', '$1', $text, 'i' );

		$attribs = Sanitizer::validateTagAttributes( $attribs, 'pre' );
		$attribs['wasHtml'] = 1;
		return wfOpenElement( 'pre', $attribs ) .
			Xml::escapeTagsOnly( $content ) .
			'</pre>';
	}

	function formatHeadings( $text, $isMain=true ) {
		return $text;
	}

	function doMagicLinks( $text ) {
		return $text;
	}

	function __construct( $conf = array() ) {
		parent::__construct($conf);

		// load hooks from $wgParser
		global $wgParser;
		$this->mTagHooks = & $wgParser->mTagHooks;
		$this->mStripList = & $wgParser->mStripList;
	}

}

class WysiwygInterface extends SpecialPage {

		function WysiwygInterface() {
			SpecialPage::SpecialPage("WysiwygInterface");
			wfLoadExtensionMessages('WysiwygInterface');
		}

		function execute( $par ) {
			global $wgRequest, $wgOut, $wgTitle, $wgUser, $IP, $FCKmetaData;
			$this->setHeaders();

			if(empty($par)) {
				$wikitext = $wgRequest->getText('wikitext');
				$wgOut->addHTML('<form method="POST"><textarea name="wikitext" style="height: 140px; width: 800px;">'.$wikitext.'</textarea><br /><br /><input type="submit" value="Post" /></form>');
			} else {
				$title = Title::newFromText($par);
				if($title->exists()) {
					$rev = Revision::newFromTitle($title);
					$wikitext = $rev->getText();
				} else {
					$wikitext = '-';
				}
			}

			$options = new ParserOptions();
			//$options->setTidy(true);

			$parser = new WysiwygParser();
			$parser->setOutputType(OT_HTML);
			global $FCKparseEnable;
			$FCKparseEnable = true;
			$wikitext = $parser->preSaveTransform($wikitext, $wgTitle, $wgUser, $options);
			$out = $parser->parse($wikitext, $wgTitle, $options)->getText();
			$FCKparseEnable = false;

			// fix UTF issue
			$out = mb_convert_encoding($out, 'HTML-ENTITIES', "UTF-8");

			// will be used by reverse parser
			$html = $out;

			// macbre: return nicely colored & tabbed code
			require($IP. '/lib/geshi/geshi.php');

			// clear whitespaces between tags
			$out = preg_replace('/>(\s+)</', '><', $out);	// between tags
			$out = preg_replace('/(\s+)<\//', '</', $out);	// before closing tag

			$out = mb_convert_encoding($out, 'HTML-ENTITIES', "UTF-8");

			$dom = new DOMDocument();

			if (!empty($out)) {

				wfSuppressWarnings();
				$dom->loadHTML($out);
				wfRestoreWarnings();

				$dom->formatOutput = true;
				$dom->preserveWhiteSpace = false;

			 	// only show content inside <body> tag
				$body = $dom->getElementsByTagName('body')->item(0);
				$out = $dom->saveXML($body);

				$out = '  ' . trim(substr($out, 6, -7));

				$geshi = new geshi($out, 'html4strict');
				$geshi->enable_keyword_links(false);
			}
			else {
				$html = '';
			}

			// macbre: call ReverseParser to parse HTML back to wikimarkup
			require(dirname(__FILE__).'/../Wysiwyg/ReverseParser.php');
			$reverseParser = new ReverseParser();

			$wgOut->addHtml('<h5>$FCKmetaData</h5>');
			$wgOut->addHtml('<pre>'.htmlspecialchars(print_r($FCKmetaData, true)).'</pre>');

			$wikitext_parsed = $reverseParser->parse($html, $FCKmetaData);

			// check wysiwigability ;)
			require(dirname(__FILE__).'/FailsafeFallback.php');
			$failsafeFallback = new FailsafeFallback();

			$wysiwigable = $failsafeFallback->checkWikitext( $wikitext );

			// parse
//			$wikitext = $parser->preSaveTransform($wikitext, $wgTitle, $wgUser, $options);
			$parsedOld = $parser->parse($wikitext, $wgTitle, $options)->getText();
//			$wikitext_parsed = $parser->preSaveTransform($wikitext_parsed, $wgTitle, $wgUser, $options);
			$parsedNew = $parser->parse($wikitext_parsed, $wgTitle, $options)->getText();

			// diff
			if ($wikitext == $wikitext_parsed) {
				$diff = '&lt;empty&gt;';
			}
			else {
				$diffEngine = new DifferenceEngine;
				$diffEngine->showDiffStyle();
				$diffBody = $diffEngine->generateDiffBody( $wikitext, $wikitext_parsed );
				$diff = DifferenceEngine::addHeader( $diffBody, "<strong>Wikitext</strong>", "<strong>Parsed from HTML</strong>" );
			}

			// output
			// 1. wikimarkup
			// 1a was this Wysiwigable?
			// 2. parsed HTML
			// 3. parsed wikimarkup
			// 4. diff between 1 and 3
			// 5. parsed old and new wikimarkup
			$wgOut->addHTML('<h3>Wikimarkup</h3>');
			$wgOut->addHTML('<pre>' . htmlspecialchars($wikitext) . '</pre>');

			/*
			$wgOut->addHTML ('<h4>Wysiwygable</h4>') ;
			if( $wysiwigable ) {
				$wgOut->addHTML( 'Article was deemed "appropriate" for Wysiwyg editing.' ) ;
			} else {
				$wgOut->addHTML( 'Article was deemed "inapropriate" for Wysiwyg editing.' ) ;
			}
			*/

			$wgOut->addHTML('<h3>HTML</h3>');
			$wgOut->addHTML('<pre>' . htmlspecialchars($html) . '</pre>');

			$wgOut->addHTML('<h3>Back to wikimarkup</h3>');
			$wgOut->addHTML('<pre>' . htmlspecialchars($wikitext_parsed) . '</pre>');

			$wgOut->addHTML('<h3>Wikitext diff</h3>');
			$wgOut->addHTML( $diff );	

			$wgOut->addHTML('<h3>Visual comparison</h3>');
			$wgOut->addHTML('<table style="width:100%"><colgroup><col width="50%" /><col width="50%" /></colgroup>');
			$wgOut->addHTML('<tr><th>Wikitext</th><th>Parsed from HTML</th></tr>');
			$wgOut->addHTML('<tr><td style="vertical-align:top">'.$parsedOld.'</td><td style="vertical-align:top">'.$parsedNew.'</td></table>');
		}
}
