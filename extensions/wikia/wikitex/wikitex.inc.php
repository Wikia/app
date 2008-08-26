<?php

/*
WikiTeX: expansible LaTeX module for MediaWiki
Copyright (C) 2004-5  Peter Danenberg

     WikiTeX is licensed under the Artistic License 2.0;  to
view a copy of this license, see COPYING or visit:

     http://dev.perl.org/perl6/rfc/346.html

wikitex.inc.php: initialization of wikitex.php

*/

// an abstract method of declaration; too much C.  Rebukes indeed the "loose"
// virtues of PHP.
settype($arrErr,	'array');
settype($strErr,	'string');
settype($arrRend,	'array');
settype($strRendPath,	'string');

// base dir
$strRendPath = "$IP/extensions/wikia/wikitex";

// Set class names; which may be customized based on local language, fashion
// or whim.  Henry V was a maker of these when he was courting Gallrix Kate.
$arrRend = array ('math'	=> 'strMath',
		  'batik'	=> 'strBatik',
		  'chem'	=> 'strXym',
		  'chess'	=> 'strChess',
		  'feyn'	=> 'strFeyn',
		  'go'		=> 'strGo',
		  'greek'	=> 'strGreek',
		  'graph'	=> 'strGraph',
		  'ling'	=> 'strLing',
		  'music'	=> 'strMusic',
		  'plot'	=> 'strPlot',
		  'ppch'	=> 'strPPCH',
		  'schem'	=> 'strSchem',
		  'teng'	=> 'strTeng',
		  'tipa'	=> 'strTipa');
#SVG disabled for now
#		  'svg'		=> 'strSVG',

// liberal Latin in errorous dicta
$arrErr['rend']	= 'directive non gratum.';
$arrErr['bash'] = '<span class="errwikitex">WikiTeX: wikitex.sh is not executable.</span>';

// the stem of errorous givings-out
$strErr	= "$strRendPath/wikitex.error.inc.tex";
	
?>
