<?php
class WysiwygInterface extends SpecialPage {

		function WysiwygInterface() {
			SpecialPage::SpecialPage("WysiwygInterface");
			wfLoadExtensionMessages('WysiwygInterface');
		}

		function execute( $par ) {
			global $wgRequest, $wgOut, $wgTitle, $wgUser, $IP, $wgWysiwygMetaData, $wgParser, $wgWysiwygParserEnabled;
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

			// use simple function to parse wikitext to HTML with FCK extra data
			list($out, $tmpMetaData) = Wysiwyg_WikiTextToHtml($wikitext);
	
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
				$out = $geshi->parse_code(); 
			}
			else {
				$html = '';
			}

			// macbre: call ReverseParser to parse HTML back to wikimarkup
			$wgOut->addHtml('<h5>$wgWysiwygMetaData</h5>');
			$wgOut->addHtml('<pre>'.htmlspecialchars(print_r($wgWysiwygMetaData, true)).'</pre>');

			$wikitext_parsed = Wysiwyg_HtmlToWikiText($html, $wgWysiwygMetaData);

			// parse old and new wikitext to HTML (for visual diff)
			$options = new ParserOptions();
			$wgWysiwygParserEnabled = true;
			$parsedOld = $wgParser->parse($wikitext, $wgTitle, $options)->getText();
			$parsedNew = $wgParser->parse($wikitext_parsed, $wgTitle, $options)->getText();
			$wgWysiwygParserEnabled = false;

			// show wikitext diff
			if ($wikitext == $wikitext_parsed) {
				$diff = '&lt;empty&gt;';
			}
			else {
				$diffEngine = new DifferenceEngine;
				$diffEngine->showDiffStyle();
				$diffBody = $diffEngine->generateDiffBody( $wikitext, $wikitext_parsed );
				$diff = DifferenceEngine::addHeader( $diffBody, "<strong>Wikitext</strong>", "<strong>Parsed from HTML</strong>" );
			}

			// parse HTML to wikiDOM
			require_once(dirname(__FILE__).'/../Wysiwyg/ReverseParserDOM.php');
			$reverseParserDOM = new ReverseParserDOM();
			$wikidom = $reverseParserDOM->preparse($html);

			// output
			// 1. wikimarkup
			// 1a was this Wysiwigable?
			// 2. parsed HTML
			// 3. parsed wikimarkup
			// 4. diff between 1 and 3
			// 5. parsed old and new wikimarkup
			$wgOut->addHTML('<h3>Wikimarkup</h3>');
			$wgOut->addHTML('<pre>' . htmlspecialchars($wikitext) . '</pre>');

			$wgOut->addHTML('<h3>Wiki DOM tree</h3>');
			$wgOut->addHTML('<pre>' . htmlspecialchars($wikidom) . '</pre>');

			$wgOut->addHTML('<h3>HTML</h3>');
			$wgOut->addHTML($out);

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
