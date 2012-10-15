<?php

# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License along
# with this program; if not, write to the Free Software Foundation, Inc.,
# 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
# http://www.gnu.org/copyleft/gpl.html

class DoubleWiki {

	/**
	 * Tags that must be closed. (list copied from Sanitizer.php)
	 */
	var $tags = '/<\/?(b|del|i|ins|u|font|big|small|sub|sup|h1|h2|h3|h4|h5|h6|cite|code|em|s|strike|strong|tt|tr|td|var|div|center|blockquote|ol|ul|dl|table|caption|pre|ruby|rt|rb|rp|p|span)([\s](.*?)>|>)/i';

	/**
	 * Read the list of matched phrases and add tags to the html output.
	 */
	function addMatchingTags ( &$text, $lang ) {
		$pattern = "/<div id=\"align-" . preg_quote( $lang, '/' ) . "\" style=\"display:none;\">\n*<pre>(.*?)<\/pre>\n*<\/div>/is";
		$m = array();
		if ( ! preg_match( $pattern, $text, $m ) ) {
			return;
		}
		$text = str_replace( $m[1], '', $text );
		$line_pattern = '/\s*([^:\n]*?)\s*=\s*([^:\n]*?)\s*\n/i';
		$items = array();
		preg_match_all( $line_pattern, $m[1], $items, PREG_SET_ORDER );
		foreach ( $items as $n => $i ) {
			$text = str_replace( $i[1], "<span id=\"dw-" . preg_quote( $n, '/' ) . "\" title=\"{$i[2]}\"/>" . $i[1], $text );
		}
	}

	static function OutputPageBeforeHTML( &$out, &$text ) {
		$dw = new self();
		$dw->addMatchedText( $out, $text );
		return true;
	}

	/**
	 * Hook function called with &match=lang
	 * Transform $text into a bilingual version
	 * @param $out OutputPage
	 * @param $text
	 */
	function addMatchedText( &$out, &$text ) {
		global $wgContLang, $wgContLanguageCode, $wgRequest, $wgLang, $wgMemc, $wgDoubleWikiCacheTime;

		$match_request = $wgRequest->getText( 'match' );
		if ( $match_request === '' ) {
			return true;
		}
		$this->addMatchingTags ( $text, $match_request );

		$langLinks = $out->getLanguageLinks();
		foreach( $langLinks as $l ) {
			$nt = Title::newFromText( $l );
			$iw = $nt->getInterwiki();

			if ( $iw === $match_request ) {

				$key = wfMemcKey( 'doublewiki', $wgLang->getCode(), $nt->getPrefixedDbKey() );
				$cachedText = $wgMemc->get( $key );

				if( $cachedText ) {
					$text = $cachedText;
				} else {
					$url =  $nt->getCanonicalURL();
					$myURL = $out->getTitle()->getLocalURL();
					$languageName = $wgContLang->getLanguageName( $iw );
					$myLanguage = $wgLang->getLanguageName( $wgContLang->getCode() );
					$translation = Http::get( wfAppendQuery( $url, array( 'action' => 'render' ) ) );

					if ( $translation !== null ) {
						/**
						 * first find all links that have no 'class' parameter.
						 * these links are local so we add '?match=xx' to their url,
						 * unless it already contains a '?'
						 */
						$translation = preg_replace(
							"/<a href=\"http:\/\/([^\"\?]*)\"(([\s]+)(c(?!lass=)|[^c\>\s])([^\>\s]*))*\>/i",
							"<a href=\"http://\\1?match={$wgContLanguageCode}\"\\2>", $translation );
						// now add class='extiw' to these links
						$translation = preg_replace(
							"/<a href=\"http:\/\/([^\"]*)\"(([\s]+)(c(?!lass=)|[^c\>\s])([^\>\s]*))*\>/i",
							"<a href=\"http://\\1\" class=\"extiw\"\\3>", $translation );
						// use class='extiw' for images too
						$translation = preg_replace(
							"/<a href=\"http:\/\/([^\"]*)\"([^\>]*)class=\"image\"([^\>]*)\>/i",
							"<a href=\"http://\\1\"\\2class=\"extiw\"\\3>", $translation );

						// add prefixes to internal links, in order to prevent duplicates
						$translation = preg_replace( "/<a href=\"#(.*?)\"/i", "<a href=\"#l_\\1\"",
										$translation );
						$translation = preg_replace( "/<li id=\"(.*?)\"/i", "<li id=\"l_\\1\"",
										$translation );
						$text = preg_replace( "/<a href=\"#(.*?)\"/i", "<a href=\"#r_\\1\"", $text );
						$text = preg_replace( "/<li id=\"(.*?)\"/i", "<li id=\"r_\\1\"", $text );

						// add ?match= to local links of the local wiki
						$text = preg_replace( "/<a href=\"\/([^\"\?]*)\"/i",
								"<a href=\"/\\1?match={$match_request}\"", $text );

						// do the job
						$text = $this->matchColumns ( $text, $myLanguage, $myURL, $wgContLanguageCode,
									   $translation, $languageName, $url, $match_request );

						$wgMemc->set( $key, $text, $wgDoubleWikiCacheTime );
					}
				}
				break;
			}
		}
		return true;
	}

	/**
	 * Format the text as a two-column table with aligned paragraphs
	 */
	function matchColumns( $left_text, $left_title, $left_url, $left_lang,
		$right_text, $right_title, $right_url, $right_lang ) {

		list( $left_slices, $left_tags ) = $this->find_slices( $left_text );

		$body = '';
		$left_chunk = '';
		$right_chunk = '';

		$leftSliceCount = count( $left_slices );
		for ( $i = 0; $i < $leftSliceCount; $i++ ) {

			// some slices might be empty
			if ( $left_slices[$i] == '' ) {
				continue;
			}

			$found = false;
			$tag = $left_tags[1][$i];
			$left_chunk .= $left_slices[$i];

			// if we are at the end of the loop, finish quickly
			if ( $i == $leftSliceCount - 1 ) {
				$right_chunk .= $right_text;
				$found = true;
			} else {
				// look for requested tag in the text
				$a = strpos ( $right_text, $tag );
				if ( $a ) {
					$found = true;
					$sub = substr( $right_text, 0, $a );
					// detect the end of previous paragraph
					// regexp matches the rightmost delimiter
					$m = array();
					if ( preg_match( "/(.*)<\/(p|dl)>/is", $sub, $m ) ) {
						$right_chunk .= $m[0];
						$right_text = substr( $right_text, strlen( $m[0] ) );
					}
				}
			}

			if ( $found && $right_chunk ) {
				// Detect paragraphs
				$left_bits  = $this->find_paragraphs( $left_chunk );
				$right_bits = $this->find_paragraphs( $right_chunk );

				// Do not align paragraphs if counts are different
				if ( count( $left_bits ) != count( $right_bits ) ) {
					$left_bits = array( $left_chunk );
					$right_bits = array( $right_chunk );
				}

				$left_chunk  = '';
				$right_chunk = '';
				$leftBitCount = count( $left_bits );
				for ( $l = 0; $l < $leftBitCount ; $l++ ) {
					$body .=
					  "<tr><td valign=\"top\" style=\"vertical-align:100%;padding-right: 0.5em\" lang=\"{$left_lang}\">"
					  . "<div style=\"width:35em; margin:0px auto\">\n" . $left_bits[$l] . "</div>"
					  . "</td>\n<td valign=\"top\" style=\"padding-left: 0.5em\" lang=\"{$right_lang}\">"
					  . "<div style=\"width:35em; margin:0px auto\">\n" . $right_bits[$l] . "</div>"
					  . "</td></tr>\n";
				}
			}
		}

		// format table head and return results
		$left_url = htmlspecialchars( $left_url );
		$right_url = htmlspecialchars( $right_url );
		$head =
		  "<table id=\"doubleWikiTable\" width=\"100%\" border=\"0\" bgcolor=\"white\" rules=\"cols\" cellpadding=\"0\">
<colgroup><col width=\"50%\"/><col width=\"50%\"/></colgroup><thead>
<tr><td bgcolor=\"#cfcfff\" align=\"center\" lang=\"{$left_lang}\">
<a href=\"{$left_url}\">{$left_title}</a></td>
<td bgcolor=\"#cfcfff\" align=\"center\" lang=\"{$right_lang}\">
<a href=\"{$right_url}\" class='extiw'>{$right_title}</a>
</td></tr></thead>\n";
		return $head . $body . "</table>" ;
	}

	/**
	 * Split text and return a set of html-balanced paragraphs
	 */
	function find_paragraphs( $text ) {
		$result = array();
		$bits = preg_split( $this->tags, $text );
		$m = array();
		preg_match_all( $this->tags, $text, $m, PREG_SET_ORDER );
		$counter = 0;
		$out = '';
		$matchCount = count( $m );
		for ( $i = 0; $i < $matchCount; $i++ ) {
			$t = $m[$i][0];
			if ( substr( $t, 0, 2 ) != "</" ) {
				$counter++;
			} else {
				$counter--;
			}
			$out .= $bits[$i] . $t;
			if ( ( $t == "</p>" || $t == "</dl>" ) && $counter == 0 ) {
				$result[] = $out;
				$out = '';
			}
		}
		if ( $out ) {
			$result[] = $out;
		}
		return $result;
	}

	/**
	 * Split text and return a set of html-balanced slices
	 */
	function find_slices( $left_text ) {

		$tag_pattern = "/<span id=\"dw-[^\"]*\" title=\"([^\"]*)\"\/>/i";
		$left_slices = preg_split( $tag_pattern, $left_text );
		$left_tags = array();
		preg_match_all( $tag_pattern, $left_text,  $left_tags, PREG_PATTERN_ORDER );
		$n = count( $left_slices );

		/**
		 * Make slices that are full paragraphs
		 * If two slices correspond to the same paragraph, the second one will be empty
		 */
		for ( $i = 0; $i < $n - 1; $i++ ) {
			$str = $left_slices[$i];
			$m = array();
			if ( preg_match( "/(.*)<(p|dl)>/is", $str, $m ) ) {
				$left_slices[$i] = $m[1];
				$left_slices[$i + 1] = substr( $str, strlen( $m[1] ) ) . $left_slices[$i + 1];
			}
		}

		/**
		 * Keep only slices that contain balanced html
		 * If a slice is unbalanced, we merge it with the next one.
		 * The first and last slices are compensated.
		 */
		$stack = array();
		$opening = '';

		for ( $i = 0; $i < $n; $i++ ) {
			$m = array();
			preg_match_all( $this->tags, $left_slices[$i], $m, PREG_SET_ORDER );
			$counter = 0;
			$matchCount = count( $m );
			for ( $k = 0 ; $k < $matchCount ; $k++ ) {
				$t = $m[$k];
				if ( substr( $t[0], 0, 2 ) != "</" ) {
					$counter++;
					array_push( $stack, $t );
				} else {
					array_pop( $stack );
					$counter--;
				}
			}
			if ( $i == 0 ) {
				$closure = '';
				for ( $k = 0; $k < $counter ; $k++ ) {
					$opening .= "<" . $stack[$k][1] . ">";
					$closure = "</" . $stack[$k][1] . ">" . $closure;
				}
				$left_slices[$i] = $left_slices[$i] . $closure;
			} elseif ( $i == $n - 1 ) {
				$left_slices[$i] = $opening . $left_slices[$i];
			} elseif ( $counter != 0 ) {
				$left_slices[$i + 1] = $left_slices[$i] . $left_slices[$i + 1];
				$left_slices[$i] = '';
			}
		}
		return array( $left_slices, $left_tags );
	}

}
