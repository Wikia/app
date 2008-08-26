<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

/**#@+ 
 *
 * A parser extension that further extends labeled section transclusion,
 * adding a function, #lsth for transcluding marked sections of text,
 *
 * This calls internal functions from lst.php.  It will not work if that
 * extension is not enabled, and may not work if the two files are not in
 * sync.
 *
 * @todo: MW 1.12 version, as per #lst/#lstx
 *
 * @addtogroup Extensions
 *
 * @link http://www.mediawiki.org/wiki/Extension:Labeled_Section_Transclusion Documentation
 *
 * @author Steve Sanbeg
 * @copyright Copyright © 2006, Steve Sanbeg
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

##
# Standard initialisation code
##

$wgExtensionFunctions[]="wfLabeledSectionTransclusionHeading";
$wgHooks['LanguageGetMagic'][] = 'wfLabeledSectionTransclusionHeadingMagic';
$wgParserTestFiles[] = dirname( __FILE__ ) . "/lsthParserTests.txt";

function wfLabeledSectionTransclusionHeading() 
{
  global $wgParser;
  $wgParser->setFunctionHook( 'lsth', 'wfLstIncludeHeading' );
}

function wfLabeledSectionTransclusionHeadingMagic( &$magicWords, $langCode ) {
  // Add the magic words
  $magicWords['lsth'] = array( 0, 'lsth', 'section-h' );
  return true;
}

///section inclusion - include all matching sections
function wfLstIncludeHeading($parser, $page='', $sec='', $to='')
{
  if (LabeledSectionTransclusion::getTemplateText_($parser, $page, $title, $text) == false)
    return $text;

  //Generate a regex to match the === classical heading section(s) === we're
  //interested in.
  if ($sec == '') {
    $begin_off = 0;
    $head_len = 6;
  } else {
    $pat = '^(={1,6})\s*' . preg_quote($sec, '/') . '\s*\1\s*($)' ;
    if ( preg_match( "/$pat/im", $text, $m, PREG_OFFSET_CAPTURE) ) {
      $begin_off = $m[2][1];
      $head_len = strlen($m[1][0]);
      //wfDebug( "LSTH: offset is $begin_off" );
    } else {
      //wfDebug( "LSTH: match failed: '$pat'" );
      return '';
    }
    
  }

  if ($to != '') {
    //if $to is supplied, try and match it.  If we don't match, just
    //ignore it.
    $pat = '^(={1,6})\s*' . preg_quote($to, '/') . '\s*\1\s*$';
    if (preg_match( "/$pat/im", $text, $m, PREG_OFFSET_CAPTURE, $begin_off))
      $end_off = $m[0][1]-1;
  }


  if (! isset($end_off)) {
    $pat = '^(={1,'.$head_len.'})(?!=).*?\1\s*$';
    if (preg_match( "/$pat/im", $text, $m, PREG_OFFSET_CAPTURE, $begin_off))
      $end_off = $m[0][1]-1;
    else 
      wfDebug("LSTH: fail end match: '$pat'");

    //wfDebug("LSTH:head len is $head_len, pat is $pat, head is '.$m[1][0]'";
  } 

  $nhead = LabeledSectionTransclusion::countHeadings_($text, $begin_off);
  wfDebug( "LSTH: head offset = $nhead" );

  if (isset($end_off))
    $result = substr($text, $begin_off, $end_off - $begin_off);
  else
    $result = substr($text, $begin_off);
  

  if (method_exists($parser,'getPreprocessor'))
  {
    $frame = $parser->getPreprocessor()->newFrame();
    $dom = $parser->preprocessToDom( $result );
    $result = $frame->expand( $dom );
  }
      

  return LabeledSectionTransclusion::parse_($parser,$title,$result, "#lsth:${page}|${sec}", $nhead);
}

