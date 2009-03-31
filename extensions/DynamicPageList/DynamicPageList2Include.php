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
 * @version 1.2.3
 *    allow %0 to transclude the contents before the first chapter
 * @version 1.2.5
 *    added includenotmatch
 * @version 1.2.9
 *    parameter recognition improved; nested template calls are now handled correctly
 * @version 1.3.8
 *    parameter recognition improved; nested hyperlinks are now handled correctly (balanced square brackets)
 * @version 1.3.9
 *    changed behaviour if template not found: now return null string if only one parameter was to be fetched
 * @version 1.4.2
 *    allow multiple parameters of a template to be returned directly as table columns
 *	  added field formatting via dpl call back for templates
 * @version 1.4.3
 *    allow regular expression for heading match at include
 * @version 1.4.4
 *    bugfix: handling of numeric template parameters
 * @version 1.5.2
 * 			includematch now understands parameter limits like {abc}:x[10]:y[20]
 *			error corrected in reduceToText (limit=1 delivered string of length 2)
 * @version 1.5.4
 * 			new parser function {{#dplchapter:text|heading|limit|page|linktext}}
 *			added provision fpr pre and nowiki in wiki text truncation fuction
 *			support %DATE% and %USER% within phantom templates
 * @version 1.6.1
 *			Escaping of "/" improved. In some cases a slash in a page name or in a template parameter could lead to php errors at INCLUDE
 * @version 1.6.2
 *			Template matching in include improved. "abc" must not match "abc def" but did so previously.
 * @version 1.6.3
 *			Changed section matching to allow wildcards.
 * @version 1.6.5
 *			changed call time by reference in extract Heading
 * @version 1.6.5
 *			changed call time by reference in extract Heading
 * @version 1.6.9
 *			added include trimming
 * @version 1.7.1
 *			allow % within included template parameters
 * @version 1.7.3
 *			%SECTION% can now be used within multiseseparators (see includeHeading)

 */

class DPL2Include
{

    ##############################################################
    # To do transclusion from an extension, we need to interact with the parser
    # at a low level.  This is the general transclusion functionality
    ##############################################################
    
    ///Register what we're working on in the parser, so we don't fall into a trap.
    public static function open($parser, $part1) 
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
    public static function close($parser, $part1) 
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
    private static function parse($parser, $title, $text, $part1, $skiphead=0, $recursionCheck=true, $maxLength=-1, $link='', $trim=false) 
    {
      global $wgVersion;
    
      // if someone tries something like<section begin=blah>lst only</section>
      // text, may as well do the right thing.
      $text = str_replace('</section>', '', $text);
    
      if (self::open($parser, $part1)) {
    
        //Handle recursion here, so we can break cycles.  Although we can't do
        //feature detection here, r18473 was only a few weeks before the
        //release, so this is close enough.
    
        if(version_compare( $wgVersion, "1.9" ) < 0 || $recursionCheck == false) {
          $text = $parser->replaceVariables($text);
          self::close($parser, $part1);
        }
    
        if ($maxLength>=0) {
            $text = self::limitTranscludedText($text,$maxLength,$link);
        }
        if ($trim) return trim($text);
        else       return $text;
      }  else {
        return "[[" . $title->getPrefixedText() . "]]". 
          "<!-- WARNING: LST loop detected -->";
      }
      
    }
    
    ##############################################################
    # And now, the labeled section transclusion
    ##############################################################
    
    ///The section markers aren't paired, so we only need to remove them.
    # this function doesn't seem to be in use.  remove?
    public static function emptyString( $in, $assocArgs=array(), $parser=null ) {
      return '';
    }
    
    ///Generate a regex to match the section(s) we're interested in.
    private static function createSectionPattern($sec, $to, &$any) 
    {
	  $any = false;
      $to_sec = ($to == '')?$sec : $to;
      if ($sec[0]=='*') {
	      $any=true;
	      if ($sec=='**')	$sec='[^\/>"'."']+";
	      else				$sec=str_replace('/','\/',substr($sec,1));
      } else				$sec=preg_quote($sec, '/');
      if ($to_sec[0]=='*') {
	      if ($to_sec=='**')$to_sec='[^\/>"'."']+";
	      else				$to_sec=str_replace('/','\/',substr($to_sec,1));
  	  } else				$to_sec=preg_quote($to_sec, '/');
      $ws="(?:\s+[^>]+)?"; //was like $ws="\s*"
      return "/<section$ws\s+(?i:begin)=['\"]?".
        "($sec)".
        "['\"]?$ws\/?>(.*?)\n?<section$ws\s+(?:[^>]+\s+)?(?i:end)=".
        "['\"]?\\1['\"]?".
        "$ws\/?>/s";
        
/*      return "/<section$ws\s+(?i:begin)=".
        "(?:$sec|\"$sec\"|'$sec')".
        "$ws\/?>(.*?)\n?<section$ws\s+(?:[^>]+\s+)?(?i:end)=".
        "(?:$to_sec|\"$to_sec\"|'$to_sec')".
        "$ws\/?>/s";
*/
    }
    
    ///Count headings in skipped text; the $parser arg could go away in the future.
    private static function countHeadings($text,$limit) 
    {
      //count skipped headings, so parser (as of r18218) can skip them, to
      //prevent wrong heading links (see bug 6563).
      $pat = '^(={1,6}).+\s*.*?\1\s*$';
      return preg_match_all( "/$pat/im", substr($text,0,$limit), $m);
    }
    
    private static function text($parser, $page, &$title, &$text) 
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
    public static function includeSection($parser, $page='', $sec='', $to='', $recursionCheck=true, $trim=false) {
	  	$output = array();
      	if (self::text($parser, $page, $title, $text) == false) {
	    	$output[] = $text;
	    	return $output;
	    }
	    $any=false;
    	$pat = self::createSectionPattern($sec,$to,$any);
    
    	preg_match_all( $pat, $text, $m, PREG_PATTERN_ORDER);
      
    	foreach ($m[2] as $nr=>$piece)  {
	    	$piece = self::parse($parser,$title,$piece, "#lst:${page}|${sec}", 0, $recursionCheck, $trim);
	    	if ($any) $output[] = $m[1][$nr].'::'.$piece;
	    	else 	  $output[] = $piece;
    	}
	    return $output;
    }
    
    
    //reduce transcluded wiki text to a certain length; we will care for matching brackets to some extent
    // so that we do not spoil wiki syntax; the returned result may be smaller or bigger that the limit
    // to achieve this.
    public static function limitTranscludedText($text, $limit, $link='') {
        // if text is smaller than the limit return complete text
        if ($limit >= strlen($text)) return $text;
        $brackets=0;
        $cbrackets=0;
        $n0=-1; $nb=0;
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
        if ( $n0>=0 )  {
            // we try to cut off at a word boundary
            if ($nb>0 && $nb+15>$n0) $n0=$nb;
            $cut=substr($text, 0, $n0+1);
            if (stristr($cut,'<nowiki>')!==false && stristr($cut,'</nowiki>')===false) $cut.='</nowiki>';  
            if (stristr($cut,'<pre>')!==false && stristr($cut,'</pre>')===false) $cut.='</pre>';  
            return $cut.$link;
        }
        else if ($limit==0) {
            return $link;
        }
        else {
            // otherwise we recurse and try again with twice the limit size; this will lead to bigger output but
            // it will at least produce some output at all; otherwise the reader might think that there
            // is no information at all
            return self::limitTranscludedText($text, $limit * 2,$link);
        }
    }

    public static function includeHeading($parser, $page='', $sec='', $to='', &$sectionHeading, $recursionCheck=true, $maxLength=-1,
    									  $link='default', $trim=false)
    {
      $output=array();
      if (self::text($parser, $page, $title, $text) == false) {
        $output[0] = $text;
        return $output;
      }

      return self::extractHeadingFromText($parser, $page, $title, $text, $sec, $to, $sectionHeading, $recursionCheck, $maxLength, $link, $trim);
    }

    //section inclusion - include all matching sections (return array)
    public static function extractHeadingFromText($parser, $page, $title, $text, $sec='', $to='', &$sectionHeading, $recursionCheck=true, 
    											  $maxLength=-1, $link='default', $trim=false) {
      
      // create a link symbol (arrow, img, ...) in case we have to cut the text block to maxLength
      if      ($link=='default')                 $link = ' [['.$page.'#'.$sec.'|..&rarr;]]';
      else if (strstr($link,'img=')!=false)      $link = str_replace('img=',"<linkedimage>page=".$page.'#'.$sec."\nimg=Image:",$link)."\n</linkedimage>";
      else if (strstr($link,'%SECTION%')==false) $link = ' [['.$page.'#'.$sec.'|'.$link.']]';
      else                                       $link = str_replace('%SECTION%',$page.'#'.$sec,$link);
      $continueSearch = true;
      $n=0;
      $output[$n]='';
      $nr = 0;
       // check if we are going to fetch the n-th section
      if (preg_match('/^%-?[1-9][0-9]*$/',$sec)) 	$nr = substr($sec,1);
      if (preg_match('/^%0$/',$sec))  				$nr = -2; // transclude text before the first section
      
      // if the section name starts with a # we use it as regexp, otherwise as plain string
      $isPlain=true;
      if ($sec!='' && $sec[0]=='#') {
          $sec=substr($sec,1);
          $isPlain=false;
      }
      do {
          //Generate a regex to match the === classical heading section(s) === we're
          //interested in.
        if ($sec == '') {
          $begin_off = 0;
          $head_len = 6;
        } else {
            if ($nr!=0) $pat = '^(={1,6})\s*[^=\s\n][^\n=]*\s*\1\s*($)' ;
            else if ($isPlain)	$pat = '^(={1,6})\s*' . preg_quote($sec, '/') . '\s*\1\s*($)' ;
            else 				$pat = '^(={1,6})\s*' . str_replace('/','\/',$sec) . '\s*\1\s*($)' ;
            if ( preg_match( "/$pat/im", $text, $m, PREG_OFFSET_CAPTURE) ) {
                $begin_off = $m[2][1];
                $head_len = strlen($m[1][0]);
            } else if ($nr == -2) {
                $m[1][1] = strlen($text)+1; // take whole article if no heading found
            } else {
                // match failed
                return $output;
            }
        }
        
        if ($nr==-2) {
            // output text before first section and done
            $piece = substr($text,0,$m[1][1]-1); 
            $output[0] = self::parse($parser,$title,$piece, "#lsth:${page}|${sec}", 0, $recursionCheck, $maxLength, $link, $trim);
            return $output;
        }
        
        if (isset($end_off)) unset($end_off);
        if ($to != '') {
            //if $to is supplied, try and match it.  If we don't match, just ignore it.
            if ($isPlain)	$pat = '^(={1,6})\s*' . preg_quote($to, '/') . '\s*\1\s*$' ;
            else		  	$pat = '^(={1,6})\s*' . str_replace('/','\/',$to) . '\s*\1\s*$' ;
            if (preg_match( "/$pat/im", $text, $mm, PREG_OFFSET_CAPTURE, $begin_off))
                $end_off = $mm[0][1]-1;
        }
    
        if (! isset($end_off)) {
            if ($nr!=0)	$pat = '^(={1,6})\s*[^\s\n=][^\n=]*\s*\1\s*$';
            else 	  	$pat = '^(={1,'.$head_len.'})(?!=)\s*.*?\1\s*$';
            if (preg_match( "/$pat/im", $text, $mm, PREG_OFFSET_CAPTURE, $begin_off)) 	$end_off = $mm[0][1]-1;
            else if ($sec=='') 												      		$end_off = -1;
        }
    
        $nhead = self::countHeadings($text, $begin_off);
        wfDebug( "LSTH: head offset = $nhead" );
    
        if (isset($end_off)) {
            if ($end_off == -1) {
                return $output;
            }
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
        
        if (isset($m[0][0])) {
            $sectionHeading[$n]=preg_replace("/^=+\s*/","",$m[0][0]);
            $sectionHeading[$n]=preg_replace("/\s*=+\s*$/","",$sectionHeading[$n]);
        }
        else $sectionHeading[$n] = '';
        if ($nr==1) {
            // output n-th section and done
            $output[0] = self::parse($parser,$title,$piece, "#lsth:${page}|${sec}", $nhead, $recursionCheck, $maxLength, $link, $trim);
            break;
        }
        if ($nr==-1) {
            if (!isset($end_off)) {
                // output last section and done
                $output[0] = self::parse($parser,$title,$piece, "#lsth:${page}|${sec}", $nhead, $recursionCheck, $maxLength, $link, $trim);
                break;
            }
        } else {
            // output section by name and continue search for another section with the same name
            $output[$n++] = self::parse($parser,$title,$piece, "#lsth:${page}|${sec}", $nhead, $recursionCheck, $maxLength, $link, $trim);
        }
      } while ($continueSearch);
      return $output;
    }
    
    
    
    // template inclusion - find the place(s) where template1 is called,
    // replace its name by template2, then expand template2 and return the result
    // we return an array containing all occurences of the template call which match the condition "$mustMatch"
    // and do NOT match the condition "$mustNotMatch" (if specified)
    // we use a callback function to format retrieved parameters, accessible via $dpl->formatTemplateArg()
    public static function includeTemplate($parser, $dpl, $dplNr, $article, $template1='', $template2='', $defaultTemplate,
    									   $mustMatch, $mustNotMatch, $matchParsed, $iTitleMaxLen)
    {
        $page = $article->mTitle->getPrefixedText();
        $date = $article->myDate;
        $user = $article->mUserLink;
        $title = Title::newFromText($page);
        $text = $parser->fetchTemplate($title);
        $tCalls = preg_split( "/\{\{\s*".preg_quote($template1,'/').'\s*[|}]/i', ' '.$text);
		// We restore the first separator symbol (we had to include that symbol into the SPLIT, because we must make
		// sure that we only accept exact matches of the complete template name
        // (e.g. when looking for "foo" we must not accept "foo xyz")
        foreach ($tCalls as $nr => $tCall) {
	        if ($tCall[0]=='}') $tCalls[$nr] = '}'.$tCall;
	        else				$tCalls[$nr] = '|'.$tCall;
        }
    
        $output=array();
        $extractParm = array();
        
        // check if we want to extract parameters directly from the call
        // in that case we won´t invoke template2 but will directly return the extracted parameters
        // as a sequence of table columns; 
        if (strlen($template2)>strlen($template1) && ($template2[strlen($template1)]==':')) {
            $extractParm = split(':',substr($template2,strlen($template1)+1));
        }
    
        if (count($tCalls) <= 1) {
            // template was not called (note that count will be 1 if there is no template invocation)
            if (count($extractParm)>0) {
                // if parameters are required directly: return empty columns
                if (count($extractParm)>1) 	{
                    $output[0]=$dpl->formatTemplateArg('',$dplNr,0,true,-1);
                    for ($i=1;$i<count($extractParm); $i++) $output[0] .= "\n|" . $dpl->formatTemplateArg('',$dplNr,$i,true,-1);
                }
                else $output[0]=$dpl->formatTemplateArg('',$dplNr,0,true,-1);
            } else {
                // put a red link into the output
                $output[0]= $parser->replaceVariables('{{'.$defaultTemplate.'|%PAGE%='.$page.'|%TITLE%='.$title->getText().'|%DATE%='.$date.'|%USER%='.$user.'}}');
            }
            return $output;
        }
        
        $output[0]='';
        $n=-2;
        // loop for all template invocations
        $firstCall=true;
        foreach ($tCalls as $tCall) {
            if ($n==-2) {
                $n++;
                continue;
            }
            $c= $tCall[0];
            // normally we construct a call for template2 with the parameters of template1
            if (count($extractParm)==0) {
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
                        if (($mustMatch   =='' ||  preg_match($mustMatch,substr($templateCall,0,$i-1))) && 
                            ($mustNotMatch=='' || !preg_match($mustNotMatch,substr($templateCall,0,$i-1)))) {
                            $output[++$n] = $parser->replaceVariables(substr($templateCall,0,$i-1).
                                '|%PAGE%='.$page.'|%TITLE%='.$title->getText().'|%DATE%='.$date.'|%USER%='.$user.'}}');
                        }
                        break;
                    }
                }
            }
            else {
                // if the user wants parameters directly from the call line of template1 we return just those
                $cbrackets=2;
                $templateCall = $tCall;
                $size=strlen($templateCall);
                $parms=array();
                $parm='';
                $hasParm=false;
                for ($i=0; $i<$size;$i++) {
                    $c = $templateCall[$i];
                    if ($c == '{' || $c=='[') $cbrackets++; // we count both types of brackets
                    if ($c == '}' || $c==']') $cbrackets--;
                    if ($cbrackets==2 && $c=='|') {
                        $parms[]=trim($parm);
                        $hasParm=true;
                        $parm='';
                    }
                    else $parm .= $c;
                    if ($cbrackets==0) {
                        if ($hasParm) $parms[] = trim(substr($parm,0,strlen($parm)-2));
                        array_splice($parms,0,1); // remove artifact;
                        // if we must match a condition: test against it
                        $callText = substr($templateCall,0,$i-1);
                        if ( ($mustMatch   =='' || 
                        		(($matchParsed  && preg_match($mustMatch   ,$parser->recursiveTagParse($callText))) ||
                        		 (!$matchParsed && preg_match($mustMatch   ,$callText)) )) &&
                             ($mustNotMatch=='' || 
                             	(($matchParsed  && !preg_match($mustNotMatch,$parser->recursiveTagParse($callText))) ||
                             	 (!$matchParsed && !preg_match($mustNotMatch,$callText))))) {
                            $output[++$n]='';
                            $second=false;
                            foreach ($extractParm as $exParmKey => $exParm) {
                                $maxlen= -1;
                                if (($limpos=strpos($exParm,'['))>0 && $exParm[strlen($exParm)-1]==']') {
                                    $maxlen=intval(substr($exParm,$limpos+1,strlen($exParm)-$limpos-2));
                                    $exParm=substr($exParm,0,$limpos);
                                }
                                if ($second) {
                                    if ($output[$n]=='' || $output[$n][strlen($output[$n])-1] != "\n") $output[$n] .= "\n";
                                    $output[$n] .= "|"; // \n";
                                }
                                $found=false;
                                // % in parameter name
                                if (strpos($exParm,'%')!==FALSE) {
	                                // %% is a short form for inclusion of %PAGE% and %TITLE%
	                                $found=true;
    	                            $output[$n] .= $dpl->formatTemplateArg($dpl->articleLink($exParm,$article,$iTitleMaxLen),$dplNr,$exParmKey,$firstCall,$maxlen);
                                }
                                if (!$found) {
	                                // named parameter
	                                $exParmQuote = str_replace('/','\/',$exParm);
	                                foreach ($parms as $parm) {
	                                    if (!preg_match("/^\s*$exParmQuote\s*=/",$parm)) continue;
	                                    $found=true;
	                                    $output[$n] .= $dpl->formatTemplateArg(preg_replace("/^$exParmQuote\s*=\s*/","",$parm),$dplNr,$exParmKey,$firstCall,$maxlen);
	                                    break;
	                                }
                                }
                                if (!$found && is_numeric($exParm) && intval($exParm) == $exParm) {
                                    // numeric parameter
                                    $np=0;
                                    foreach ($parms as $parm) {
                                        if(strstr($parm, '=') === FALSE) ++$np;
                                        if ($np!=$exParm) continue;
                                        $found=true;
                                        $output[$n] .= $dpl->formatTemplateArg($parm,$dplNr,$exParmKey,$firstCall,$maxlen);
                                        break;
                                    }
                                }
                                if (!$found) $output[$n] .= $dpl->formatTemplateArg('',$dplNr,$exParmKey,$firstCall,$maxlen);
                                $second=true;
                            }
                        }
                        break;
                    }
                }
            }
            $firstCall=false;
        }
        return $output;
    }

}
?>