<?php

/*
WikiTeX: expansible LaTeX module for MediaWiki
Copyright (C) 2004-5  Peter Danenberg

     WikiTeX is licensed under the Artistic License 2.0;  to
view a copy of this license, see COPYING or visit:

     http://dev.perl.org/perl6/rfc/346.html

wikitex.php: main parser  functions, registration  interface
with $wgParser

*/

include 'wikitex.inc.php';
settype($objRend, 'object');

// register WikiTeX with parser
$wgExtensionFunctions[] = 'voidRegister';

// perform registration
function voidRegister()
{
  global $arrRend, $objRend;
  $objRend = new objRend($arrRend);
}

class objRend
{
  // register object with parser
  function __construct($arr)
    {
      global $wgParser;

      settype($strVal,	'string');
      settype($strKey,	'string');

      foreach ($arr as $strKey => $strVal) {
	$wgParser->setHook($strKey, $strVal);
      }
    }


  // parses strings of the form x=y y="z" z="a b c" [...], and returns an accordant array[x]=y, etc.
  function arrParse($str)
    {
      settype($arr,	'array');
      settype($arrAttr,	'array');
      settype($strKey,	'string');
      settype($strVal,	'string');
			
      preg_match_all('/(\S*)\=(?(?=\")\"([^"]*)\"|(.*))\s*(?=\S*\=|$)/Us', $str, $arr, PREG_PATTERN_ORDER);
      foreach ($arr[1] as $strKey => $strVal) {
	// In x="y", "y" is returned as the second node; x=y, y the third.  Otherwise blank.
	$arrAttr[$strVal] = trim($arr[(empty($arr[2][$strKey]) ? 3 : 2)][$strKey], '"');
      }
      return $arrAttr;
    }

  // post-processing; security
  function strPost($str, &$strClass, &$strFile)
    {
      global
	$arrErr, $strErr;
			
      settype($strBlack,	'string');
      settype($arrBlack,	'array');

      // generic security basis for all classes
      $arrBlack['rend']	= array('\catcode', '\def', '\include', '\includeonly', '\input', '\newcommand', '\newenvironment', '\newtheorem', '\newfont', '\renewcommand', '\renewenvironment', '\typein', '\typeout', '\write', '\let', '\csname', '\read', '\open');

      // specific security recommendations
      $arrBlack['music'] = array('#');
    
      $arrBlack['plot'] = array('cd', 'call', 'exit', 'load', 'pause', 'print', 'pwd', 'quit', 'replot', 'reread', 'reset', 'save', 'shell', 'system', 'test', 'update', '!', 'path', 'historysize', 'mouse', 'out', 'term', 'file', '"', '\'');

      $arrBlack['chess'] = array('savegame', 'loadgame', 'storegame', 'restoregame');

      // merge arrays, if specific present
      if (!empty($arrBlack[$strClass])) {
	$arrBlack['rend'] = array_merge($arrBlack[$strClass], $arrBlack['rend']);
      }
    
      foreach($arrBlack['rend'] as $strBlack) {
	if (stristr($str, $strBlack) !== false) {
	  $strClass = 'error';
	  $strFile = '%value%';
	  return $arrErr['rend'];
	}
      }

      // seems to remain an artifact \' after stripslashes
      return strip_tags(strtr($str, array('\\\'' => '\'')));
    }

  // substitute the parameters in the given template
  function strSub($str, $arr, $strToken)
    {
      settype($strKey,	'string');
      settype($strVal,	'string');
			
      foreach($arr as $strKey => $strVal) {
	$str = strtr($str, array(sprintf($strToken, $strKey) => $strVal));
      }

      return $str;
    }
		
  // receive raw text in, serialize to hash-encoded temp file, funnel to bash
  // and receive tag anew.
  function strRend($strTex, $arr)
    {
      global $arrErr, $strErr, $strRendPath, $wgScriptPath; // global err, path def's

      settype($obj,	'object'); // file resource
      settype($arrBash,	'array'); // standard out parameters
      settype($arrTag,	'array');
      settype($str,	'string');
      settype($strHash,	'string'); // outfile hash
      settype($strTag,	'string');
      settype($strKey,	'string');
      settype($strVal,	'string');
      settype($strTemplate,'string'); // template glob
      settype($strErrClass,'array');
      settype($strDir,	'string'); // temp directory
      settype($strURI,	'string'); // relative URI
      settype($strBash,	'string'); // shell command
      settype($strRend,	'string'); // replacement
			
      $strTemplate= "$strRendPath/wikitex.%s.inc*";
      $strErrClass= 'error';
      $strDir   = '/images/wikitex/images/';
      $strURI   = 'http://images.wikia.com/wikitex/images/';
      $strBash	= "$strRendPath/wikitex.sh %s %s %s %s %s";	// usage: wikitex FILE MODULE OUTPATH DIRSUFFIX DIRTMP
      $strRend	= '%%%s%%';

      // check class template against glob: "wikitex.<class>.inc*"
      if(!($str = file_get_contents(current(glob(sprintf($strTemplate, $arr['class'])))))) {
	// invoke generic error template
	$str = file_get_contents($strErr);

	// generate error message
	$arr['value'] = sprintf($arrErr['class'], $arr['class']);

	// set generic error class
	$arr['class'] = $strErrClass;
	global $wgOut;
	$wgOut->addHTML("");
      }
			
      // post-processing: black-list control, actualizing the file template
      $arr['value'] = $this->strPost($strTex, $arr['class'], $str);

      // check for defaults defined in wikitex.inc.php, and realize them
      if (!empty($arrDef[$arr['class']])) {
	$this->vDefault($arr, $arrDef[$arrAttrib['class']]);
      }

      // token substitution; where each value of $arr substituted in $str,
      // %value%, %style%, etc.
      $strTex = $this->strSub($str, $arr, $strRend);

      // derive the outfile hash
      $strHash = md5($strTex);

      global $wgOut;
      // FIXME: graceless exception on inaccessibility
      $wgOut->addHTML("\n<!-- wikitex attempt on $strDir $strHash with $strTex-->\n");

      $outDirSuffix = substr($strHash, 0, 1) . "/" . substr($strHash, 0, 2) . "/" . substr($strHash, 0, 3) . "/";
      $outDir = $strDir . $outDirSuffix;

      $strHash = substr($strHash,3);

      if( !file_exists($outDir)) {
 	exec("mkdir -p $outDir");
      }

      if($obj = fopen($outDir . $strHash, 'w')) {
	fwrite($obj, $strTex);
	fclose($obj);
        $wgOut->addHTML("\n<!-- wikitex file written -->\n");
      }

      $wgOut->addHTML("\n<!-- wikitex attempt as \"".sprintf($strBash, $strHash, $arr['class'], $strURI, $outDirSuffix, $strDir)."\"-->\n");

      // If the script is unavailable, roll our own error.
      if (!is_executable(substr($strBash, 0, strpos($strBash, ' ')))) {
	return $arrErr['bash'];
      } else {
	return trim(shell_exec(sprintf($strBash, $strHash, $arr['class'], $strURI, $outDirSuffix, $strDir)));
      }
    }
}

function strBatik($str)
{
  global $objRend;
  return $objRend->strRend($str, array('class' => 'batik'));
}

function strChess($str)
{
  global $objRend;
  return $objRend->strRend($str, array('class' => 'chess'));
}

function strFeyn($str)
{
  global $objRend;
  return $objRend->strRend($str, array('class' => 'feyn'));
}

function strGo($str)
{
  global $objRend;
  return $objRend->strRend($str, array('class' => 'go'));
}

function strGraph($str)
{
  global $objRend;
  return $objRend->strRend($str, array('class' => 'graph'));
}

function strGreek($str)
{
  global $objRend;
  return $objRend->strRend($str, array('class' => 'greek'));
}

function strLing($str)
{
  global $objRend;
  return $objRend->strRend($str, array('class' => 'ling'));
}

function strMath($str)
{
  global $objRend;
  return $objRend->strRend($str, array('class' => 'math'));
}

function strMusic($str)
{
  global $objRend;
  return $objRend->strRend($str, array('class' => 'music'));
}

function strPlot($str)
{
  global $objRend;
  return $objRend->strRend($str, array('class' => 'plot'));
}

function strPPCH($str)
{
  global $objRend;
  return $objRend->strRend($str, array('class' => 'ppch'));
}

function strSchem($str)
{
  global $objRend;
  return $objRend->strRend($str, array('class' => 'schem'));
}

function strSVG($str)
{
  global $objRend;
  return $objRend->strRend($str, array('class' => 'svg'));
}

function strTeng($str)
{
  global $objRend;
  return $objRend->strRend($str, array('class' => 'teng'));
}

function strTipa($str)
{
  global $objRend;
  return $objRend->strRend($str, array('class' => 'tipa'));
}

function strXym($str)
{
  global $objRend;
  return $objRend->strRend($str, array('class' => 'chem'));
}

?>
