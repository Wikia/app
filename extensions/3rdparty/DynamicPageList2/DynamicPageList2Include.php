<?php
/**#@+
 * This is a slightly modified and enhanced copy of a mediawiki extension called
 *
 *       LabeledSectionTransclusion
 *
 * @link http://www.mediawiki.org/wiki/Extension:Labeled_Section_Transclusion Documentation
 *
 *
 * @author Steve Sanbeg
 * @copyright Copyright © 2006, Steve Sanbeg
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
 *
 * This copy was made to avoid version conflicts between the two extensions.
 * In this copy names were changed (wfLst.. --> wfDplLst..).
 * So any version of LabeledSectionTransclusion can be installed together with DPL2
 *
 * Enhancements were made to 
 *     -  allow inclusion of templates ("template swapping")
 *     -  reduce the size of the transcluded text to a limit of <n> characters
 *
 *
 * Thanks to Steve for his great work!
 * -- Algorithmix
 *
 * @version 0.9.8
 * %PAGE% and %TITLE% passed to templates
 * @version 0.9.8 patch 1
 * error in template inclusion corrected
 * @version 0.9.9
 *    default template inclusion added
 * @version 1.0.0
 *    internal changes due to dominantsection
 * @version 1.0.8
 *    added regexp matching condition at template based inclusion
 * @version 1.1.2
 *    changed heading matcher to allow selection of the n-th chapter
 * @version 1.1.3
 *    bug fix for 1.1.2 (avoid warning regarding parameter passing by reference)
 * @version 1.1.4
 *    easy access for one single template parameter
 * @version 1.1.6
 *    corrected strlen bug at template inclusion
 */



##############################################################
# To do transclusion from an extension, we need to interact with the parser
# at a low level.  This is the general transclusion functionality
##############################################################

///Register what we're working on in the parser, so we don't fall into a trap.
function wfDplLst_open_($parser, $part1) 
{
  // Infinite loop test
  if ( isset( $parser->mTemplatePath[$part1] ) ) {
    wfDebug( __METHOD__.": template loop broken at '$part1'\n" );
    return false;
  } else {
    $parser->mTemplatePath[$part1] = 1;
    return true;
  }
  
}

///Finish processing the function.
function wfDplLst_close_($parser, $part1) 
{
  // Infinite loop test
  if ( isset( $parser->mTemplatePath[$part1] ) ) {
    unset( $parser->mTemplatePath[$part1] );
  } else {
    wfDebug( __METHOD__.": close unopened template loop at '$part1'\n" );
  }
}

/**
 * Handle recursive substitution here, so we can break cycles, and set up
 * return values so that edit sections will resolve correctly.
 **/
function wfDplLst_parse_($parser, $title, $text, $part1, $skiphead=0, $recursionCheck=true, $maxLength=-1, $link='') 
{
  global $wgVersion;

  // if someone tries something like<section begin=blah>lst only</section>
  // text, may as well do the right thing.
  $text = str_replace('</section>', '', $text);

  if (wfDplLst_open_($parser, $part1)) {

    //Handle recursion here, so we can break cycles.  Although we can't do
    //feature detection here, r18473 was only a few weeks before the
    //release, so this is close enough.

    if(version_compare( $wgVersion, "1.9" ) < 0 || $recursionCheck == false) {
      $text = $parser->replaceVariables($text);
      wfDplLst_close_($parser, $part1);
    }

    if ($maxLength>=0) {
	    $text = wfDplLstReduceTextToSize($text,$maxLength,$link);
    }
    
    //Try to get edit sections correct by munging around the parser's guts.
//    return array($text, 'title'=>$title, 'replaceHeadings'=>true, 
//		 'headingOffset'=>$skiphead);
    return $text;
  }  else {
    return "[[" . $title->getPrefixedText() . "]]". 
      "<!-- WARNING: LST loop detected -->";
  }
  
}

##############################################################
# And now, the labeled section transclusion
##############################################################

///The section markers aren't paired, so we only need to remove them.
function wfDplLstNoop( $in, $assocArgs=array(), $parser=null ) {
  return '';
}

///Generate a regex to match the section(s) we're interested in.
function wfDplLst_pat_($sec, $to) 
{
  $to_sec = ($to == '')?$sec : $to;
  $sec = preg_quote($sec, '/');
  $to_sec = preg_quote($to_sec, '/');
  $ws="(?:\s+[^>]+)?"; //was like $ws="\s*"
  return "/<section$ws\s+(?i:begin)=".
    "(?:$sec|\"$sec\"|'$sec')".
    "$ws\/?>(.*?)\n?<section$ws\s+(?:[^>]+\s+)?(?i:end)=".
    "(?:$to_sec|\"$to_sec\"|'$to_sec')".
    "$ws\/?>/s";
}

///Count headings in skipped text; the $parser arg could go away in the future.
function wfDplLst_count_headings_($text,$limit) 
{
  //count skipped headings, so parser (as of r18218) can skip them, to
  //prevent wrong heading links (see bug 6563).
  $pat = '^(={1,6}).+\s*.*?\1\s*$';
  return preg_match_all( "/$pat/im", substr($text,0,$limit), $m);
}

function wfDplLst_text_($parser, $page, &$title, &$text) 
{
  $title = Title::newFromText($page);
  
  if (is_null($title) ) {
    $text = '';
    return true;
  } else {
    $text = $parser->fetchTemplate($title);
  }
  
  //if article doesn't exist, return a red link.
  if ($text == false) {
    $text = "[[" . $title->getPrefixedText() . "]]";
    return false;
  } else {
    return true;
  }
}

///section inclusion - include all matching sections
function wfDplLstInclude($parser, $page='', $sec='', $to='', $recursionCheck=true)
{
  if (wfDplLst_text_($parser, $page, $title, $text) == false)
    return $text;
  $pat = wfDplLst_pat_($sec,$to);

  if(preg_match_all( $pat, $text, $m, PREG_OFFSET_CAPTURE)) {
    $headings = wfDplLst_count_headings_($text, $m[0][0][1]);
  } else {
    $headings = 0;
  }
  
  $text = '';
  foreach ($m[1] as $piece)  {
    $text .= $piece[0];
  }

  //wfDebug("wfDplLstInclude: skip $headings headings");
  return wfDplLst_parse_($parser,$title,$text, "#lst:${page}|${sec}", $headings, $recursionCheck);
}


//reduce transcluded wiki text to a certain length; we will care for matching brackets to some extent
// so that we do not spoil wiki syntax; the returned result may be smaller or bigger that the limit
// to achieve this.
function wfDplLstReduceTextToSize($text, $limit, $link='') {
	// if text is smaller than the limit return complete text
	if ($limit >= strlen($text)) return $text;
	$brackets=0;
	$cbrackets=0;
	$n0=0; $nb=0;
	for ($i=0; $i<$limit;$i++) {
		$c = $text[$i];
		if ($c == '[') $brackets++;
		if ($c == ']') $brackets--;
		if ($c == '{') $cbrackets++;
		if ($c == '}') $cbrackets--;
		// we store the position if it is valid in terms of parentheses balancing
		if ($brackets==0 && $cbrackets==0) {
			$n0 = $i;
			if ($c == ' ') $nb = $i;
		}
	}
	// if there is a valid cut-off point we use it; it will be the largest one which is not above the limit 
	if ( $n0>0 )  {
		// we try to cut off at a word boundary
		if ($nb>0 && $nb+15>$n0) $n0=$nb;
		return substr($text, 0, $n0+1).$link;
	}
	else if ($limit==0) {
		return $link;
	}
	else {
		// otherwise we recurse and try again with twice the limit size; this will lead to bigger output but
		// it will at least produce some output at all; otherwise the reader might think that there
		// is no information at all
		return wfDplLstReduceTextToSize($text, $limit * 2,$link);
	}
}



//section inclusion - include all matching sections (return array)
function wfDplLstIncludeHeading($parser, $page='', $sec='', $to='', &$sectionHeading, $recursionCheck=true, $maxLength=-1, $link='default')
{
  $output=array();
  if (wfDplLst_text_($parser, $page, $title, $text) == false) {
  	$output[0] = $text;
    return $output;
  }
  
  // create a link symbol (arrow, img, ...) in case we have to cut the text block to maxLength
  if ($link=='default') 						$link = ' [['.$page.'#'.$sec.'|..&rarr;]]';
  else if (strstr($link,'img=')!=false)		 	$link = str_replace('img=',"<linkedimage>page=".$page.'#'.$sec."\nimg=Image:",$link)."\n</linkedimage>";
  else if (strstr($link,'%SECTION%')==false) 	$link = ' [['.$page.'#'.$sec.'|'.$link.']]';
  else											$link = str_replace('%SECTION%',$page.'#'.$sec,$link);
  $continueSearch = true;
  $n=0;
  $output[$n]='';
  $nr = 0;

   // check if we are going to fetch the n-th section
  if (preg_match('/^%-?[1-9][0-9]*$/',$sec)) 	$nr = substr($sec,1);
  
  do {
	  //Generate a regex to match the === classical heading section(s) === we're
	  //interested in.
  	if ($sec == '') {
  	  $begin_off = 0;
      $head_len = 6;
  	} else {
	  	if ($nr!=0) $pat = '^(={1,6})\s*[^=\s\n][^\n=]*\s*\1\s*($)' ;
	  	else 	    $pat = '^(={1,6})\s*' . preg_quote($sec, '/') . '\s*\1\s*($)' ;
    	if ( preg_match( "/$pat/im", $text, $m, PREG_OFFSET_CAPTURE) ) {
      		$begin_off = $m[2][1];
      		$head_len = strlen($m[1][0]);
   	 	} else {
      		// match failed
      		return $output;
    	}
	}
	if (isset($end_off)) unset($end_off);
  	if ($to != '') {
    	//if $to is supplied, try and match it.  If we don't match, just ignore it.
    	$pat = '^(={1,6})\s*' . preg_quote($to, '/') . '\s*\1\s*$';
    	if (preg_match( "/$pat/im", $text, $mm, PREG_OFFSET_CAPTURE, $begin_off))
      		$end_off = $mm[0][1]-1;
  	}

	if (! isset($end_off)) {
		if ($nr!=0)	$pat = '^(={1,6})\s*[^\s\n=][^\n=]*\s*\1\s*$';
		else 	  	$pat = '^(={1,'.$head_len.'})(?!=)\s*.*?\1\s*$';
    	if (preg_match( "/$pat/im", $text, $mm, PREG_OFFSET_CAPTURE, $begin_off)) 	$end_off = $mm[0][1]-1;
		else if ($sec=='') 												      		$end_off = -1;
  	}

  	$nhead = wfDplLst_count_headings_($text, $begin_off);
  	wfDebug( "LSTH: head offset = $nhead" );

  	if (isset($end_off)) {
	  	if ($end_off == -1) return '';
    	$piece= substr($text, $begin_off, $end_off - $begin_off);
  	  	if ($sec=='') $continueSearch = false;
	  	else		  $text = substr($text,$end_off);
	}
	else {
    	$piece = substr($text, $begin_off);
    	$continueSearch = false;
	}
	
  	if ($nr > 1) {
	  	// skip until we reach the n-th section
  		$nr--;
  		continue;
	}
	
	$sectionHeading=preg_replace("/^=+\s*/","",$m[0][0]);
	$sectionHeading=preg_replace("/\s*=+\s*$/","",$sectionHeading);
	if ($nr==1) {
	  	// output n-th section and done
		$output[0] = wfDplLst_parse_($parser,$title,$piece, "#lsth:${page}|${sec}", $nhead, $recursionCheck, $maxLength, $link);
	  	break;
  	}
	if ($nr==-1) {
		if (!isset($end_off)) {
			// output last section and done
			$output[0] = wfDplLst_parse_($parser,$title,$piece, "#lsth:${page}|${sec}", $nhead, $recursionCheck, $maxLength, $link);
			break;
		}
	} else {
		// output section by name and continue search for another section with the same name
		$output[$n++] = wfDplLst_parse_($parser,$title,$piece, "#lsth:${page}|${sec}", $nhead, $recursionCheck, $maxLength, $link);
	}
  } while ($continueSearch);
  return $output;
}



// template inclusion - find the place(s) where template1 is called,
// replace its name by template2, then expand template2 and return the result
// we return an array containing all occurences of the template call which match the condition "$mustMatch"
function wfDplLstIncludeTemplate($parser, $page='', $template1='', $template2='', $defaultTemplate, $mustMatch)
{
	$title = Title::newFromText($page);
	$text = $parser->fetchTemplate($title);
    $tCalls = preg_split( "/\{\{\s*".$template1.'/i', ' '.$text);

   	$output=array();
	$extractParm = '';
	$extractParmNr = 0;
	
	if (count($tCalls) <= 1) {
	    // template was not called (note that count will be 1 if there is no template invocation)
		$output[0]= $parser->replaceVariables('{{'.$defaultTemplate.'|%PAGE%='.$page.'|%TITLE%='.$title->getText().'}}');
		return $output;
	}
	
	// check if we only want to extract a single parameter form the call
	// in that case we won´t invoke template2 but will directly return the extracted parameter
	if (strlen($template2)>strlen($template1) && ($template2[strlen($template1)]==':')) {
		$extractParm = substr($template2,strlen($template1)+1);
		if (preg_match("/^[1-9][0-9]*$/",$extractParm)) $extractParmNr = $extractParm;
	}
	
	$output[0]='';
    $n=-2;
    // loop for all template invocations
	foreach ($tCalls as $tCall) {
		if ($n==-2) {
			$n++;
			continue;
		}
		$c= $tCall[0];
		// check that our pattern did not hit a name which started with exactly the name of our pattern
		// (e.g. we look for "foo" and "foox" was called)
		if ($c != '}' && $c!= '|' && $c!= ' ' && $c!="\t" && $c != "\n") continue;
	    // normally we construct a call for template2 with the parameters of template1
	    if ($extractParm=="") {
		    // find the end of the call: bracket level must be zero
			$cbrackets=0;
			$templateCall = '{{'.$template2.$tCall;
			$size=strlen($templateCall);
			for ($i=0; $i<$size;$i++) {
				$c = $templateCall[$i];
				if ($c == '{') $cbrackets++;
				if ($c == '}') $cbrackets--;
				if ($cbrackets==0) {
					// if we must match a condition: test against it
					if ($mustMatch=='' || preg_match($mustMatch,substr($templateCall,0,$i-1))) {
						$output[++$n] = $parser->replaceVariables(substr($templateCall,0,$i-1).'|%PAGE%='.$page.'|%TITLE%='.$title->getText().'}}');
					}
					break;
				}
			}
	    }
	    else {
		    // if the user only wants one parameter from the call line of template1 we return just that
			$cbrackets=2;
			$templateCall = $tCall;
			$size=strlen($templateCall);
			for ($i=0; $i<$size;$i++) {
				$c = $templateCall[$i];
				if ($c == '{') $cbrackets++;
				if ($c == '}') $cbrackets--;
				if ($cbrackets==0) {
					// if we must match a condition: test against it
					$callText = substr($templateCall,0,$i-1);
					if ($mustMatch=='' || preg_match($mustMatch,$callText)) {
						$parms = split('\|',$callText);
						$np=0;
						foreach ($parms as $parm) {
							$parm=trim($parm);
							// either named parameters or auto numbering ...
							if (!preg_match("/=/",$parm)) {
								if ($extractParmNr!=0 && $np++ == $extractParmNr) {
									$output[++$n] = $parm;
									break;
								}
							}
							else if (preg_match("/^\s*$extractParm\s*=/",$parm)) {
								$output[++$n] = preg_replace("/^$extractParm\s*=\s*/","",$parm);
								break;
							}
						}
					}
					break;
				}
			}
		}
	}
	return $output;
}

?>