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
# 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
# http://www.gnu.org/copyleft/gpl.html
#
#
# This extension displays an article and its 
# translation on two columns of the same page.
# The translation comes from another wiki 
# that can be accessed through interlanguage links

$wgHooks['OutputPageBeforeHTML'][] = 'addMatchedText' ;

$wgExtensionCredits['other'][] = array(
	'name' => 'DoubleWiki',
	'author' => 'ThomasV',
	'url' => 'http://wikisource.org/wiki/Wikisource:DoubleWiki_Extension',
	'svn-date' => '$LastChangedDate: 2009-02-16 23:40:45 +0100 (pon, 16 lut 2009) $',
	'svn-revision' => '$LastChangedRevision: 47341 $',
	'description'    => 'Displays a page and its translation from another wiki on two columns of the same page',
	'descriptionmsg' => 'doublewiki-desc',
);

$wgExtensionMessagesFiles['DoubleWiki'] = dirname(__FILE__)  . '/DoubleWiki.i18n.php';

function addMatchedText ( &$parserOutput , &$text ) { 

	global $wgContLang, $wgRequest, $wgLang, $wgContLanguageCode, $wgTitle;

	$match_request = $wgRequest->getText( 'match' );
	if ( $match_request === '' ) { 
		return true;
	}

	foreach( $parserOutput->mLanguageLinks as $l ) {
		$nt = Title::newFromText( $l );
		$iw = $nt->getInterwiki();
		if( $iw === $match_request ){
			$url =  $nt->getFullURL(); 
			$myURL = $wgTitle -> getLocalURL() ;
			$languageName = $wgContLang->getLanguageName( $nt->getInterwiki() );
			$myLanguage = $wgLang->getLanguageName( $wgContLanguageCode );

			$sep = ( in_string( '?', $url ) ) ? '&' : '?'; 
			$translation = Http::get( $url.$sep.'action=render' );
			if ( $translation !== null ) {
				#first find all links that have no 'class' parameter.
				#these links are local so we add '?match=xx' to their url, 
				#unless it already contains a '?' 
				$translation = preg_replace( 
					"/<a href=\"http:\/\/([^\"\?]*)\"(([\s]+)(c(?!lass=)|[^c\>\s])([^\>\s]*))*\>/i",
					"<a href=\"http://\\1?match={$wgContLanguageCode}\"\\2>", $translation );
				#now add class='extiw' to these links
				$translation = preg_replace( 
					"/<a href=\"http:\/\/([^\"]*)\"(([\s]+)(c(?!lass=)|[^c\>\s])([^\>\s]*))*\>/i",
					"<a href=\"http://\\1\" class=\"extiw\"\\3>", $translation );
				#use class='extiw' for images too
				$translation = preg_replace(
					"/<a href=\"http:\/\/([^\"]*)\"([^\>]*)class=\"image\"([^\>]*)\>/i",
					"<a href=\"http://\\1\"\\2class=\"extiw\"\\3>", $translation );

				#add prefixes to internal links, in order to prevent duplicates
				$translation = preg_replace("/<a href=\"#(.*?)\"/i","<a href=\"#l_\\1\"",
							    $translation );
				$translation = preg_replace("/<li id=\"(.*?)\"/i","<li id=\"l_\\1\"",
							    $translation );
				$text = preg_replace("/<a href=\"#(.*?)\"/i","<a href=\"#r_\\1\"", $text );
				$text = preg_replace("/<li id=\"(.*?)\"/i","<li id=\"r_\\1\"", $text );

				#add tags before h2 and h3 sections
				$translation = preg_replace("/<h2>/i","<div title=\"@@h2\"></div>\n<h2>", 
							    $translation );
				$translation = preg_replace("/<h3>/i","<div title=\"@@h3\"></div>\n<h3>", 
							    $translation );
				$text = preg_replace("/<h2>/i","<div title=\"@@h2\"></div>\n<h2>", $text );
				$text = preg_replace("/<h3>/i","<div title=\"@@h3\"></div>\n<h3>", $text );

				#add ?match= to local links of the local wiki
				$text = preg_replace( "/<a href=\"\/([^\"\?]*)\"/i",
						"<a href=\"/\\1?match={$match_request}\"", $text );

				#do the job
				$text = matchColumns ( $text, $myLanguage, $myURL , 
						       $translation, $languageName, $url );
			}
			return true;
		}
	}
	return true;
}


/**
 * Return table with two columns of text 
 * Text is split into slices based on title tags
 */

function matchColumns( $left_text, $left_title, $left_url, $right_text, $right_title, $right_url ){

	# note about emdedding: 
	# text is split only at a single level. 
	# initially we assume that this level is zero
	# if nesting is encountered before the 
	# first paragraph, then this split level is increased
	# we keep track of the current nesting level during processing
	# if (current level != split level) then we do not split the text

	# the current level of embedding (stack depth)
	$left_nesting = 0;
	$right_nesting = 0;

	#the level of embedding where the text is split
	#initial value is -1 until actual value is known
	$left_splitlevel = -1;
	$right_splitlevel = -1;

	# split text 
	$tag_pattern = "/<div title=\"([^\"]*)\"><\/div>/i";
	$left_slices = preg_split( $tag_pattern, $left_text );
	$right_slices = preg_split( $tag_pattern, $right_text );
	preg_match_all( $tag_pattern, $left_text,  $left_tags, PREG_PATTERN_ORDER );
	preg_match_all( $tag_pattern, $right_text, $right_tags, PREG_PATTERN_ORDER );

	/**
	 * Order slices in a two-column array.
	 * slices that are surrounded by the same tag belong in the same line
	 * $i indexes the left column, $j the right column.
	 */
	$body = '';
	$left_chunk = '';
	$right_chunk = ''; 

	$j=0;
	$max_i = count( $left_slices );
	for ( $i=0 ; $i < $max_i ; $i++ ) {
		$found = false;
		$left_chunk .= $left_slices[$i];
 
		$max_k = count( $right_slices );

		# if we are at the end of the loop, finish quickly
		if ( $i==$max_i - 1 )  { 
			for ( $k=$j ; $k < $max_k  ; $k++ ) $right_chunk .= $right_slices[$k];
			$found = true;
		}
		else for ( $k=$j ; $k < $max_k  ; $k++ ) {

			#look for requested tag in the text
			$a = strpos ( $right_slices[$k], $left_tags[1][$i] );
			if( $a ) {
				#go to beginning of paragraph 
				#this regexp matches the rightmost delimiter
				$sub = substr( $right_slices[$k], 0, $a);
				if ( preg_match("/(.*)<(p|dl)>/is", $sub, $matches ) ){
					$right_chunk .= $matches[1];
					$right_slices[$k] = substr( $right_slices[$k], strlen($matches[1]) );
				}
				else {
					$right_chunk .= $sub;
					$right_slices[$k] = substr( $right_slices[$k], $a );
				}

				$found = true;
				$j = $k;
				break;
			}

			$right_chunk .= $right_slices[$k];

			if( $k < $max_k - 1 ) {
			    if( $left_tags[0][$i] == $right_tags[0][$k] ) {
			            $found = true;
				    $j = $k+1;
				    break;
				}
			}
		}
		if( $found ) {

			#split chunks into smaller units (paragraphs)
			$paragraph_tags = "/<(p|dl)>/i";
			$left_bits  = preg_split( $paragraph_tags, $left_chunk );
			$right_bits = preg_split( $paragraph_tags, $right_chunk );
			preg_match_all( $paragraph_tags, $left_chunk,  $left_seps,  PREG_PATTERN_ORDER );
			preg_match_all( $paragraph_tags, $right_chunk, $right_seps, PREG_PATTERN_ORDER );

			$left_chunk  = '';
			$right_chunk = '';

			# add separators that were cut off
			for($l=1; $l < count( $left_bits ); $l++ ) {
				  $left_bits[$l] = $left_seps[0][$l-1].$left_bits[$l];
			}
			for($l=1; $l < count( $right_bits ); $l++ ) {
				  $right_bits[$l] = $right_seps[0][$l-1].$right_bits[$l];
			}

			$max = max( count( $left_bits ) , count( $right_bits )); 
			# initialize missing elements
			for($l= count( $left_bits ); $l<$max; $l++) $left_bits[$l]='';
			for($l= count( $right_bits ); $l<$max; $l++) $right_bits[$l]='';

			for($l=0; $l < $max; $l++ ) {

				list($left_delta,$left_o,$left_c) = nesting_delta( $left_bits[$l] );
				list($right_delta,$right_o,$right_c) = nesting_delta( $right_bits[$l] );

				$left_nesting = $left_nesting + $left_delta;
				$right_nesting = $right_nesting + $right_delta;

				#are we at the end?
				$the_end = ($l == $max-1) && ($i == $max_i -1 );

				if(( $left_splitlevel == -1) && ($right_splitlevel == -1)) { 
					$left_splitlevel  = $left_nesting;
					$right_splitlevel = $right_nesting; 
					$left_opening  = $left_o;
					$right_opening = $right_o;
					$left_closure  = $left_c;
					$right_closure = $right_c;

					$left_prefix  = '';
					$right_prefix = '';
					$left_suffix  = $left_closure;
					$right_suffix = $right_closure;
				}
				else if($the_end) {
					$left_prefix  = $left_opening;
					$right_prefix = $right_opening;
					$left_suffix  = '';
					$right_suffix = '';
				}
				else {
					$left_prefix  = $left_opening;
					$right_prefix = $right_opening;
					$left_suffix  = $left_closure;
					$right_suffix = $right_closure;
				}

				if( ( ($left_nesting == $left_splitlevel) 
				      && ($right_nesting == $right_splitlevel) ) || $the_end)  {
					$body .= 
					"<tr><td valign=\"top\" style=\"padding-right: 0.5em\">"
					."<div style=\"width:35em; margin:0px auto\">\n"
					.$left_prefix.$left_bits[$l].$left_suffix
					."</div>"

					."</td>\n<td valign=\"top\" style=\"padding-left: 0.5em\">"
					."<div style=\"width:35em; margin:0px auto\">\n"
					.$right_prefix.$right_bits[$l].$right_suffix
					."</div>"
					."</td></tr>\n";
				}
				else {
					# procrastinate
					$left_nesting = $left_nesting - $left_delta;
					$right_nesting = $right_nesting - $right_delta;
					if ($l < $max-1) {
						$left_bits[$l+1] = $left_bits[$l] . $left_bits[$l+1];
						$right_bits[$l+1] = $right_bits[$l] . $right_bits[$l+1];
					} else {
						$left_chunk = $left_bits[$l] ;
						$right_chunk = $right_bits[$l];
					}
				}
			}
		}
		else{ $right_chunk='';}
	}


	# format table head and return results
	$left_url = htmlspecialchars( $left_url );
	$right_url = htmlspecialchars( $right_url );
	$head = 
"<table width=\"100%\" border=\"0\" bgcolor=\"white\" rules=\"cols\" cellpadding=\"0\">
<colgroup><col width=\"50%\"/><col width=\"50%\"/></colgroup><thead>
<tr><td bgcolor=\"#cfcfff\" align=\"center\">
<a href=\"{$left_url}\">{$left_title}</a></td>
<td bgcolor=\"#cfcfff\" align=\"center\">
<a href=\"{$right_url}\" class='extiw'>{$right_title}</a>
</td></tr></thead>\n";
	return $head.$body."</table>" ;
}


/*
 * returns how much the stack is changed 
 * also returns opening and closing sequences of tag
 */
function nesting_delta ( $text ) {
	#tags that must be closed. (list copied from Sanitizer.php)
	$tags = "/<\/?(b|del|i|ins|u|font|big|small|sub|sup|h1|h2|h3|h4|h5|h6|"
	  ."cite|code|em|s|strike|strong|tt|tr|td|var|div|center|blockquote|ol|ul|dl|"
	  ."table|caption|pre|ruby|rt|rb|rp|p|span)([\s](.*?)>|>)/i";
	preg_match_all( $tags, $text, $m, PREG_SET_ORDER);

	$stack = array();
	$counter = 0;
	$opening = '';
	$closure = '';
	for($i=0; $i < count($m); $i++){
		$t = $m[$i];
		if( substr( $t[0], 0, 2) != "</" ){
			$counter++;
			array_push($stack, $t);
		} else {
			$tt = array_pop($stack);
			$counter--;
			#if( ($tt != null) && ($tt[1] != $t[1]) ) {
			#	#input html is buggy...
			#	echo "Warning: ".$t[1]." encountered, expected ".$tt[1]."<br />\n";
			#}
		}
	}
	for($i=0; $i<$counter; $i++){					
		$opening .= $stack[$i][0];
		$closure = "</".$stack[$i][1].">".$closure;
	}

	return array($counter, $opening, $closure);

}
