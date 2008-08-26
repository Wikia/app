<?php

//////////////////////////////////////////////////////////////////////////
//
// WikiHiero - A PHP convert from text using "Manual for the encoding of 
// hieroglyphic texts for computer input" syntax to HTML entities (table and
// images).
//
// Copyright (C) 2004 Guillaume Blanchard (Aoineko)
// 
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
//
//////////////////////////////////////////////////////////////////////////

//========================================================================
// I N C L U D E S
include( dirname(__FILE__) . '/wh_list.php' );

//========================================================================
// D E F I N E S
define("WH_TABLE_S",      "<table border='0' cellspacing='0' cellpadding='0'>");
define("WH_TABLE_E",      "</table>");
define("WH_TD_S",         "<td align='center' valign='middle'>");
define("WH_TD_E",         "</td>");

define("WH_MODE_DEFAULT", -1);    // use default mode
define("WH_MODE_TEXT",     0);    // text only
define("WH_MODE_HTML",     1);    // HTML without CSS
define("WH_MODE_STYLE",    2);    // HTML and CSS // not supporter
define("WH_MODE_IMAGE",    3);    // picture (PNG) // not supporter
define("WH_MODE_RAW",      4);    // MdC test as it

define("WH_TYPE_NONE",     0);
define("WH_TYPE_GLYPH",    1);    // rendered items
define("WH_TYPE_CODE",     2);    // single code as ':', '*', '!', '(' or ')'
define("WH_TYPE_SPECIAL",  3);    // advanced code (more than 1 caracter)
define("WH_TYPE_END",      4);    // end of line '!'

define("WH_SCALE_DEFAULT", -1);   // use default scale
define("WH_HEIGHT",        44);
define("WH_IMG_MARGIN",    1);    // default value
define("WH_CARTOUCHE_WIDTH", 2);  // default value

define("WH_VER_MAJ",       0);
define("WH_VER_MED",       2);
define("WH_VER_MIN",       14);

global $wgScriptPath;
define("WH_IMG_DIR",       $wgScriptPath . '/extensions/wikihiero/img/' ); //"img/"); //
define("WH_IMG_PRE",       "hiero_");
define("WH_IMG_EXT",       "png");

define("WH_DEBUG_MODE",    false);

//========================================================================
// G L O B A L S
global $wh_mode, $wh_scale, $wh_phonemes, $wh_text_conv;

$wh_mode    = WH_MODE_HTML; // default value
$wh_scale   = 100;          // default value

$wh_phonemes	=	array(	//	convertion	table	phoneme	->	gardiner	code
	"mSa"	=>	"A12",
	"xr"	=>	"A15",
	"Xrd"	=>	"A17",
	"sr"	=>	"A21",
	"mniw"	=>	"A33",
	"qiz"	=>	"A38",
	"iry"	=>	"A47",
	"Sps"	=>	"A50",
	"Spsi"	=>	"A51",
/*
	"x"	=>	"J1",
	"mAa"	=>	"J11",
	"gs"	=>	"J13",
	"im"	=>	"J13",
	"M"	=>	"J15",
	"sA"	=>	"J17",
	"apr"	=>	"J20",
	"wDa"	=>	"J21",
	"nD"	=>	"J27",
	"qd"	=>	"J28",
	"Xkr"	=>	"J30",
	"Hp"	=>	"J5",
	"qn"	=>	"J8",
*/
	"x"	=>	"Aa1",
	"mAa"	=>	"Aa11",
	"gs"	=>	"Aa13",
	"im"	=>	"Aa13",
	"M"	=>	"Aa15",
	"sA"	=>	"Aa17",
	"apr"	=>	"Aa20",
	"wDa"	=>	"Aa21",
	"nD"	=>	"Aa27",
	"qd"	=>	"Aa28",
	"Xkr"	=>	"Aa30",
	"Hp"	=>	"Aa5",
	"qn"	=>	"Aa8",

	"msi"	=>	"B3",
	"mAat"	=>	"C10",
	"HH"	=>	"C11",
	"DHwty"	=>	"C3",
	"Xnmw"	=>	"C4",
	"inpw"	=>	"C6",
	"stX"	=>	"C7",
	"mnw"	=>	"C8",
	"tp"	=>	"D1",
	"wDAt"	=>	"D10",
	"R"	=>	"D153",
	"fnD"	=>	"D19",
	"Hr"	=>	"D2",
	"r"	=>	"D21",
	"rA"	=>	"D21",
	"spt"	=>	"D24",
	"spty"	=>	"D25",
	"mnD"	=>	"D27",
	"kA"	=>	"D28",
	"Sny"	=>	"D3",
	"aHA"	=>	"D34",
	"a"	=>	"D36",
	"ir"	=>	"D4",
	"Dsr"	=>	"D45",
	"d"	=>	"D46",
	"Dba"	=>	"D50",
	"mt"	=>	"D52",
	"gH"	=>	"D56",
	"gHs"	=>	"D56",
	"rd"	=>	"D56",
	"sbq"	=>	"D56",
	"b"	=>	"D58",
	"ab"	=>	"D59",
	"wab"	=>	"D60",
	"sAH"	=>	"D61",
	"rmi"	=>	"D9",
	"zAb"	=>	"E17",
	"mAi"	=>	"E22",
	"l"	=>	"E23",
	"rw"	=>	"E23",
	"Aby"	=>	"E24",
	"wn"	=>	"E34",
	"zzmt"	=>	"E6",
	"wsr"	=>	"F12",
	"wp"	=>	"F13",
	"db"	=>	"F16",
	"Hw"	=>	"F18",
	"bH"	=>	"F18",
	"ns"	=>	"F20",
	"DrD"	=>	"F21",
	"idn"	=>	"F21",
	"msDr"	=>	"F21",
	"sDm"	=>	"F21",
	"kfA"	=>	"F22",
	"pH"	=>	"F22",
	"xpS"	=>	"F23",
	"wHm"	=>	"F25",
	"Xn"	=>	"F26",
	"sti"	=>	"F29",
	"Sd"	=>	"F30",
	"ms"	=>	"F31",
	"X"	=>	"F32",
	"sd"	=>	"F33",
	"ib"	=>	"F34",
	"nfr"	=>	"F35",
	"zmA"	=>	"F36",
	"imAx"	=>	"F39",
	"HAt"	=>	"F4",
	"Aw"	=>	"F40",
	"spr"	=>	"F42",
	"isw"	=>	"F44",
	"iwa"	=>	"F44",
	"pXr"	=>	"F46",
	"qAb"	=>	"F46",
	"SsA"	=>	"F5",
	"A"	=>	"G1",
	"mwt"	=>	"G14",
	"nbty"	=>	"G16",
	"m"	=>	"G17",
	"mm"	=>	"G18",
	"AA"	=>	"G2",
	"nH"	=>	"G21",
	"Db"	=>	"G22",
	"rxyt"	=>	"G23",
	"Ax"	=>	"G25",
	"dSr"	=>	"G27",
	"gm"	=>	"G28",
	"bA"	=>	"G29",
	"baHi"	=>	"G32",
	"aq"	=>	"G35",
	"wr"	=>	"G36",
	"nDs"	=>	"G37",
	"gb"	=>	"G38",
	"zA"	=>	"G39",
	"tyw"	=>	"G4",
	"pA"	=>	"G40",
	"xn"	=>	"G41",
	"wSA"	=>	"G42",
	"w"	=>	"G43",
	"ww"	=>	"G44",
	"mAw"	=>	"G46",
	"TA"	=>	"G47",
	"snD"	=>	"G54",
	"pq"	=>	"H2",
	"wSm"	=>	"H2",
	"pAq"	=>	"H3",
	"nr"	=>	"H4",
	"Sw"	=>	"H6",
	"aSA"	=>	"I1",
	"D"	=>	"I10",
	"DD"	=>	"I11",
	"Styw"	=>	"I2",
	"mzH"	=>	"I3",
	"sbk"	=>	"I4",
	"sAq"	=>	"I5",
	"km"	=>	"I6",
	"Hfn"	=>	"I8",
	"f"	=>	"I9",
	"in"	=>	"K1",
	"ad"	=>	"K3",
	"XA"	=>	"K4",
	"bz"	=>	"K5",
	"nSmt"	=>	"K6",
	"xpr"	=>	"L1",
	"bit"	=>	"L2",
	"srqt"	=>	"L7",
	"iAm"	=>	"M1",
	"wdn"	=>	"M11",
	"xA"	=>	"M12",
	"1000"	=>	"M12",
	"wAD"	=>	"M13",
	"HA"	=>	"M16",
	"i"	=>	"M17",
	"ii"	=>	"M18",
	"Hn"	=>	"M2",
	"sxt"	=>	"M20",
	"sm"	=>	"M21",
	"nn"	=>	"M22A",
	"sw"	=>	"M23",
	"rsw"	=>	"M24",
	"Sma"	=>	"M26",
	"nDm"	=>	"M29",
	"xt"	=>	"M3",
	"bnr"	=>	"M30",
	"bdt"	=>	"M34",
	"Dr"	=>	"M36",
	"rnp"	=>	"M4",
	"iz"	=>	"M40",
	"tr"	=>	"M6",
	"SA"	=>	"M8",
	"zSn"	=>	"M9",
	"pt"	=>	"N1",
	"Abd"	=>	"N11",
	"iaH"	=>	"N11",
	"dwA"	=>	"N14",
	"sbA"	=>	"N14",
	"dwAt"	=>	"N15",
	"tA"	=>	"N16",
	"iw"	=>	"N18",
	"wDb"	=>	"N20",
	"spAt"	=>	"N24",
	"xAst"	=>	"N25",
	"Dw"	=>	"N26",
	"Axt"	=>	"N27",
	"xa"	=>	"N28",
	"q"	=>	"N29",
	"iAt"	=>	"N30",
	"n"	=>	"N35",
	"mw"	=>	"N35A",
	"S"	=>	"N37",
	"iAdt"	=>	"N4",
	"idt"	=>	"N4",
	"Sm"	=>	"N40",
	"id"	=>	"N41",
	"hrw"	=>	"N5",
	"ra"	=>	"N5",
	"zw"	=>	"N5",
	"Hnmmt"	=>	"N8",
	"pzD"	=>	"N9",
	"pr"	=>	"O1",
	"aH"	=>	"O11",
	"wsxt"	=>	"O15",
	"kAr"	=>	"O18",
	"zH"	=>	"O22",
	"txn"	=>	"O25",
	"iwn"	=>	"O28",
	"aA"	=>	"O29",
	"zxnt"	=>	"O30",
	"z"	=>	"O34",
	"zb"	=>	"O35",
	"inb"	=>	"O36",
	"qnbt"	=>	"O38A",
	"h"	=>	"O4",
	"Szp"	=>	"O42",
	"ipt"	=>	"O45",
	"nxn"	=>	"O47",
	"niwt"	=>	"O49",
	"zp"	=>	"O50",
	"Snwt"	=>	"O51",
	"Hwt"	=>	"O6",
	"wHa"	=>	"P4",
	"TAw"	=>	"P5",
	"nfw"	=>	"P5",
	"aHa"	=>	"P6",
	"xrw"	=>	"P8",
	"st"	=>	"Q1",
	"wz"	=>	"Q2",
	"p"	=>	"Q3",
	"qrsw"	=>	"Q6",
	"xAt"	=>	"R1",
	"xAwt"	=>	"R1",
	"Dd"	=>	"R11",
	"dd"	=>	"R11",
	"imnt"	=>	"R14",
	"iAb"	=>	"R15",
	"wx"	=>	"R16",
	"xm"	=>	"R22",
	"Htp"	=>	"R4",
	"kAp"	=>	"R5",
	"kp"	=>	"R5",
	"snTr"	=>	"R7",
	"nTr"	=>	"R8",
	"nTrw"	=>	"R8A",
	"bd"	=>	"R9",
	"HDt"	=>	"S1",
	"mDH"	=>	"S10",
	"wsx"	=>	"S11",
	"nbw"	=>	"S12",
	"THn"	=>	"S15",
	"tHn"	=>	"S15",
	"mnit"	=>	"S18",
	"sDAw"	=>	"S19",
	"xtm"	=>	"S20",
	"sT"	=>	"S22",
	"dmD"	=>	"S23",
	"Tz"	=>	"S24",
	"Sndyt"	=>	"S26",
	"mnxt"	=>	"S27",
	"s"	=>	"S29",
	"N"	=>	"S3",
	"dSrt"	=>	"S3",
	"sf"	=>	"S30",
	"siA"	=>	"S32",
	"Tb"	=>	"S33",
	"anx"	=>	"S34",
	"Swt"	=>	"S35",
	"xw"	=>	"S37",
	"HqA"	=>	"S38",
	"awt"	=>	"S39",
	"wAs"	=>	"S40",
	"Dam"	=>	"S41",
	"abA"	=>	"S42",
	"sxm"	=>	"S42",
	"xrp"	=>	"S42",
	"md"	=>	"S43",
	"Ams"	=>	"S44",
	"nxxw"	=>	"S45",
	"K"	=>	"S56",
	"sxmty"	=>	"S6",
	"xprS"	=>	"S7",
	"Atf"	=>	"S8",
	"Swty"	=>	"S9",
	"pD"	=>	"T10",
	"sXr"	=>	"T11",
	"zin"	=>	"T11",
	"zwn"	=>	"T11",
	"Ai"	=>	"T12",
	"Ar"	=>	"T12",
	"rwD"	=>	"T12",
	"rwd"	=>	"T12",
	"rs"	=>	"T13",
	"qmA"	=>	"T14",
	"wrrt"	=>	"T17",
	"Sms"	=>	"T18",
	"qs"	=>	"T19",
	"wa"	=>	"T21",
	"sn"	=>	"T22",
	"iH"	=>	"T24",
	"DbA"	=>	"T25",
	"Xr"	=>	"T28",
	"nmt"	=>	"T29",
	"HD"	=>	"T3",
	"sSm"	=>	"T31",
	"nm"	=>	"T34",
	"HDD"	=>	"T6",
	"pd"	=>	"T9",
	"mA"	=>	"U1",
	"it"	=>	"U10",
	"HqAt"	=>	"U11",
	"Sna"	=>	"U13",
	"hb"	=>	"U13",
	"tm"	=>	"U15",
	"biA"	=>	"U16",
	"grg"	=>	"U17",
	"stp"	=>	"U21",
	"mnx"	=>	"U22",
	"Ab"	=>	"U23",
	"Hmt"	=>	"U24",
	"wbA"	=>	"U26",
	"DA"	=>	"U28",
	"rtH"	=>	"U31",
	"zmn"	=>	"U32",
	"ti"	=>	"U33",
	"xsf"	=>	"U34",
	"Hm"	=>	"U36",
	"mxAt"	=>	"U38",
	"mr"	=>	"U6",
	"100"	=>	"V1",
	"arq"	=>	"V12",
	"T"	=>	"V13",
	"iTi"	=>	"V15",
	"TmA"	=>	"V19",
	"XAr"	=>	"V19",
	"mDt"	=>	"V19",
	"sTA"	=>	"V2",
	"10"	=>	"V20",
	"mD"	=>	"V20",
	"mH"	=>	"V22",
	"wD"	=>	"V24",
	"aD"	=>	"V26",
	"H"	=>	"V28",
	"sk"	=>	"V29",
	"wAH"	=>	"V29",
	"sTAw"	=>	"V3",
	"nb"	=>	"V30",
	"k"	=>	"V31",
	"msn"	=>	"V32",
	"sSr"	=>	"V33",
	"idr"	=>	"V37",
	"wA"	=>	"V4",
	"snT"	=>	"V5",
	"sS"	=>	"V6",
	"Sn"	=>	"V7",
	"iab"	=>	"W10",
	"g"	=>	"W11",
	"nzt"	=>	"W11",
	"Hz"	=>	"W14",
	"xnt"	=>	"W17",
	"mi"	=>	"W19",
	"bAs"	=>	"W2",
	"Hnqt"	=>	"W22",
	"nw"	=>	"W24",
	"ini"	=>	"W25",
	"Hb"	=>	"W3",
	"Xnm"	=>	"W9",
	"t"	=>	"X1",
	"di"	=>	"X8",
	"rdi"	=>	"X8",
	"mDAt"	=>	"Y1",
	"mnhd"	=>	"Y3",
	"zS"	=>	"Y3",
	"mn"	=>	"Y5",
	"ibA"	=>	"Y6",
	"zSSt"	=>	"Y8",
	"imi"	=>	"Z11",
	"y"	=>	"Z4",
	"W"	=>	"Z7",

	"<1"	=>	"Ca1",	//cartouche
	"2>"	=>	"Ca2",	
	"<2"	=>	"Ca2a",
	"1>"	=>	"Ca1a",
	"<0"	=>	"Ca1",
	"0>"	=>	"Ca2",
	"<h1"	=>	"Cah1",	//horus
	"h1>"	=>	"Cah1a",
	"<h2"	=>	"Cah2",
	"h2>"	=>	"Cah2a",
	"<h3"	=>	"Cah3",
	"h3>"	=>	"Cah3a",
	"<h0"	=>	"Cah1",
	"h0>"	=>	"Cah1a",
	"<"	=>	"Ca1",	//cartouche
	">"	=>	"Ca2",
	"[&"	=>	"Ba16",
	"&]"	=>	"Ba16",
	"[{"	=>	"Ba17",
	"}]"	=>	"Ba17a",
	"[["	=>	"Ba15",
	"]]"	=>	"Ba15a",
	"[\""	=>	"",
	"\"]"	=>	"",
	"['"	=>	"",
	"']"	=>	"",
);

/* not used yet
$wh_syntax = array(
  "-",    //block sepatator
  ":",    //supperposition
  "*",    //juxtaposition
  "(",    //open bracket
  ")",    //close bracket
  "!!",   //end of text
  "!",    //end of line
  "..",   //blank caracter
  ".",    //half-size blank caracter
  "$",    //color
  "#",    //shade
  "[&",   //select
  "&]",
  "[{",
  "}]",
  "[[",
  "]]",
  "[\"",
  "\"]",
  "['",
  "']",
  "<",    //cartouche
  ">",
  "<1",
  "2>",
  "<2",
  "1>",
  "<0",
  "0>",
  "<h1",  //horus
  "h1>",
  "<h2",
  "h2>",
  "<h3",
  "h3>",
  "<h0",
  "h0>",
  "++",   //comment
  "+s",   //hieroglyph
  "+t",   //transcription
  "+l",   //latin-normal
  "+i",   //latin-italic
  "+g",   //latin-bold (gras)
  "+b",   //latin-bold 
  "+c", 
);
*/

// convertion table for text mode
$wh_text_conv = array(
  "-"       => " ",
  ":"       => "-",
  "*"       => "-",
  "!"       => "<br />",
  "."       => "",
  "="       => "",
  "("       => "",
  ")"       => "",
  "<1"      => "(",
  "2>"      => ")|",
  "<2"      => "|(",
  "1>"      => ")",
  "<0"      => "(",
  "0>"      => ")|",
  "<h1"     => "[",  //horus
  "h1>"     => "]",
  "<h2"     => "[",
  "h2>"     => "]",
  "<h3"     => "[",
  "h3>"     => "]",
  "<h0"     => "[",
  "h0>"     => "]",
  "<"       => "(",    //cartouche
  ">"       => ")|",
);

//------------------------------------------------------------------------
// WikiHieroHook - Parser callback
//------------------------------------------------------------------------
// hiero  << text to convert
// return >> string with converted code
//------------------------------------------------------------------------
function WikiHieroHook($hiero) {
	$ret = _WikiHiero($hiero, WH_MODE_HTML);
	
	// Strip newlines to avoid breakage in the wiki parser block pass
	return str_replace( "\n", " ", $ret );
}

//========================================================================
// F U N C T I O N S 

//------------------------------------------------------------------------
// WH_RenderGlyph - Render a glyph
//------------------------------------------------------------------------
// glyph  << glyph's code to render
// option << option to add into <img> tag (use for height)
// return >> a string to add to the stream
//------------------------------------------------------------------------
function WH_RenderGlyph($glyph, $option='') {
	global $wh_mode;
	global $wh_phonemes;
	global $wh_files;
	global $wh_scale;

	if($glyph == "..") { // Render void block
	  $width = WH_HEIGHT;
	  return "<table width='{$width}px' border='0' cellspacing='0' cellpadding='0'><tr><td>&nbsp;</td></tr></table>";
	}
	else if($glyph == ".") // Render half-width void block
	{
	  $width = WH_HEIGHT/2;
	  return "<table width='{$width}px' border='0' cellspacing='0' cellpadding='0'><tr><td>&nbsp;</td></tr></table>";
	}
	else if($glyph == '<') // Render open cartouche
	{
	  $height = intval(WH_HEIGHT * $wh_scale / 100);
	  $code = $wh_phonemes[$glyph];
	  return "<img src='".htmlspecialchars(WH_IMG_DIR.WH_IMG_PRE."{$code}.".WH_IMG_EXT)."' height='{$height}px' title='".htmlspecialchars($glyph)."' alt='".htmlspecialchars($glyph)."' />";
	}
	else if($glyph == '>') // Render close cartouche
	{
	  $height = intval(WH_HEIGHT * $wh_scale / 100);
	  $code = $wh_phonemes[$glyph];
	  return "<img src='".htmlspecialchars(WH_IMG_DIR.WH_IMG_PRE."{$code}.".WH_IMG_EXT)."' height='{$height}px' title='".htmlspecialchars($glyph)."' alt='".htmlspecialchars($glyph)."' />";
	}

	if(array_key_exists($glyph, $wh_phonemes))
	{
	  $code = $wh_phonemes[$glyph];
	  if(array_key_exists($code, $wh_files))
		return "<img style='margin:".WH_IMG_MARGIN."px;' $option src='".htmlspecialchars(WH_IMG_DIR.WH_IMG_PRE."{$code}.".WH_IMG_EXT)."' title='".htmlspecialchars("{$code} [{$glyph}]")."' alt='".htmlspecialchars($glyph)."' />";
	  else
		return "<font title='".htmlspecialchars($code)."'>".htmlspecialchars($glyph)."</font>";
	}
	else if(array_key_exists($glyph, $wh_files))
	  return "<img style='margin:".WH_IMG_MARGIN."px;' $option src='".htmlspecialchars(WH_IMG_DIR.WH_IMG_PRE."{$glyph}.".WH_IMG_EXT)."' title='".htmlspecialchars($glyph)."' alt='".htmlspecialchars($glyph)."' />";
	else
	  return htmlspecialchars($glyph);
}

//------------------------------------------------------------------------
// WH_Resize - Resize a glyph
//------------------------------------------------------------------------
// item         << glyph's code
// is_cartouche << true if glyph inside a cartouche
// total        << total size of a group for multi-glyph block
// return       >> size
//------------------------------------------------------------------------
function WH_Resize($item, $is_cartouche=false, $total=0) {
	global $wh_phonemes;
	global $wh_files;
	global $wh_scale;

	if(array_key_exists($item, $wh_phonemes)) {
		$glyph = $wh_phonemes[$item];
	} else {
	  $glyph = $item;
	}

	$margin = 2 * WH_IMG_MARGIN;
	if($is_cartouche) {
		$margin += 2 * intval(WH_CARTOUCHE_WIDTH * $wh_scale / 100);
	}

	if(array_key_exists($glyph, $wh_files)) {
		$height = $margin + $wh_files[$glyph][1];
		if($total) {
			if($total > WH_HEIGHT) {
				return (intval( $height * WH_HEIGHT / $total ) - $margin) * $wh_scale / 100;
			} else {
				return ($height - $margin) * $wh_scale / 100;
			}
		} else {
			if($height > WH_HEIGHT) {
				return (intval( WH_HEIGHT * WH_HEIGHT / $height ) - $margin) * $wh_scale / 100;
			} else {
				return ($height - $margin) * $wh_scale / 100;
			}
		}
	}

	return (WH_HEIGHT - $margin) * $wh_scale / 100;
 }

//========================================================================
//
// W i k i H i e r o
//

//------------------------------------------------------------------------
// WikiHiero - Render hieroglyph text
//------------------------------------------------------------------------
// hiero  << text to convert
// mode   << convertion mode [DEFAULT|TEXT|HTML|STYLE|IMAGE] (def=HTML)
// scale  << global scale in percentage (def=100%)
// line   << use line [true|false] (def=false)
// return >> string with converted code
//------------------------------------------------------------------------
function _WikiHiero($hiero, $mode=WH_MODE_DEFAULT, $scale=WH_SCALE_DEFAULT, $line=false) {
	if($mode != WH_MODE_DEFAULT) {
		$wh_mode = $mode;
	}

	switch($wh_mode) {
		case WH_MODE_TEXT:  return WikiHieroText($hiero, $line);
		case WH_MODE_HTML:  return WikiHieroHTML($hiero, $scale, $line);
		case WH_MODE_STYLE: die("ERROR: CSS version not yet implemented");
		case WH_MODE_IMAGE: die("ERROR: Image version not yet implemented");
	}
	die("ERROR: Unknown mode!");
}

//------------------------------------------------------------------------
// WikiHieroText - Render hieroglyph text in text mode
//------------------------------------------------------------------------
// hiero  << text to convert
// line   << use line [true|false] (def=false)
// return >> string with converted code
//------------------------------------------------------------------------
function WikiHieroText($hiero, $line=false) {
	global $wh_text_conv;

    $html = "";
    
    if($line)
      $html .= "<hr />\n";

    for($char=0; $char<strlen($hiero); $char++)
    {
      if(array_key_exists($hiero[$char], $wh_text_conv))
      {
        $html .= $wh_text_conv[$hiero[$char]];
        if($hiero[$char] == '!')
          if($line)
            $html .= "<hr />\n";
      }
      else
        $html .= $hiero[$char];
    }
    
    return $html;
  }

//------------------------------------------------------------------------
// WikiHiero - Render hieroglyph text
//------------------------------------------------------------------------
// hiero  << text to convert
// scale  << global scale in percentage (def=100%)
// line   << use line [true|false] (def=false)
// return >> string with converted code
//------------------------------------------------------------------------
function WikiHieroHTML($hiero, $scale=WH_SCALE_DEFAULT, $line=false) {
    global $wh_prefabs;
    global $wh_files;
    global $wh_phonemes;
    global $wh_scale;

    if($scale != WH_SCALE_DEFAULT)
      $wh_scale = $scale;

    $html = "";

    if($line) {
      $html .= "<hr />\n";
	}

    //------------------------------------------------------------------------
    // Split text into block, then split block into item
    $block = array();
    $block[0] = array();
    $block[0][0] = "";
    $block_id = 0;
    $item_id = 0;
    $parenthesis = 0;
    $type = WH_TYPE_NONE;
    $is_cartouche = false;
    $is_striped = false;

	for($char=0; $char<strlen($hiero); $char++) {

		if( $hiero[$char] == '(' ) {
			$parenthesis++;
		} else if( $hiero[$char] == ')' ) {
			$parenthesis--;
		}

		if( $parenthesis == 0 ) {
			if($hiero[$char] == '-' || $hiero[$char] == ' ') {
				if($type != WH_TYPE_NONE) {
					$block_id++;
					$block[$block_id] = array();
					$item_id = 0;
					$block[$block_id][$item_id] = "";
					$type = WH_TYPE_NONE;
				}
			}
		} else {// don't slit block if inside parenthesis
			if($hiero[$char] == '-') {
				$item_id++;
				$block[$block_id][$item_id] = '-';
				$type = WH_TYPE_CODE;
			}
		}

		if($hiero[$char] == '!' ) {
			if($item_id > 0) {
				$block_id++;
				$block[$block_id] = array();
				$item_id = 0;
			}
			$block[$block_id][$item_id] = $hiero[$char];
			$type = WH_TYPE_END;

		} else if(ereg("[*:()]", $hiero[$char])) {

			if($type == WH_TYPE_GLYPH || $type == WH_TYPE_CODE) {
				$item_id++;
				$block[$block_id][$item_id] = "";
			}
		$block[$block_id][$item_id] = $hiero[$char];
		$type = WH_TYPE_CODE;

		} else if(ctype_alnum($hiero[$char]) || $hiero[$char] == '.' || $hiero[$char] == '<' || $hiero[$char] == '>') {
			if($type == WH_TYPE_END) {
				$block_id++;
				$block[$block_id] = array();
				$item_id = 0;
				$block[$block_id][$item_id] = "";
			} else if($type == WH_TYPE_CODE) {
				$item_id++;
				$block[$block_id][$item_id] = "";
			}
			$block[$block_id][$item_id] .= $hiero[$char];
			$type = WH_TYPE_GLYPH;
		}
    }

	// DEBUG: See the block split table
	if(WH_DEBUG_MODE) {

		foreach($block as $code) {
			echo "| ";
			foreach($code as $item) {
				echo "$item | ";
			}
			echo "<br />\n";
		}
	}

	$contentHtml = $tableHtml = $tableContentHtml = "";
	//$html .= WH_TABLE_S."<tr>\n";

	//------------------------------------------------------------------------
	// Loop into all blocks
	foreach($block as $code) {

		// simplest case, the block contain only 1 code -> render
		if(count($code) == 1)
		{
			if($code[0] == "!") { // end of line 
				$tableHtml = "</tr>".WH_TABLE_E.WH_TABLE_S."<tr>\n";
				if($line) {
					$contentHtml .= "<hr />\n";
				}

			} else if(strchr($code[0], '<')) { // start cartouche
				$contentHtml .= WH_TD_S.WH_RenderGlyph($code[0]).WH_TD_E;
				$is_cartouche = true;
				$contentHtml .= "<td>".WH_TABLE_S."<tr><td height='".intval(WH_CARTOUCHE_WIDTH * $wh_scale / 100)."px' bgcolor='black'></td></tr><tr><td>".WH_TABLE_S."<tr>";

			} else if(strchr($code[0], '>')) { // end cartouche
				$contentHtml .= "</tr>".WH_TABLE_E."</td></tr><tr><td height='".intval(WH_CARTOUCHE_WIDTH * $wh_scale / 100)."px' bgcolor='black'></td></tr>".WH_TABLE_E."</td>";
				$is_cartouche = false;
				$contentHtml .= WH_TD_S.WH_RenderGlyph($code[0]).WH_TD_E;

			} else if($code[0] != "") { // assum is glyph or '..' or '.'
				$option = "height='".WH_Resize($code[0], $is_cartouche)."px'";

				$contentHtml .= WH_TD_S.WH_RenderGlyph($code[0], $option).WH_TD_E;
			}

		// block contain more than 1 glyph
		} else {

			// convert all code into '&' to test prefabs glyph
			$temp = "";
			foreach($code as $t) {
				if(ereg("[*:!()]", $t[0])) {
					$temp .= "&";
				} else {
					$temp .= $t;
				}
			}

        // test is block is into tje prefabs list
        if(in_array($temp, $wh_prefabs)) {
			$option = "height='".WH_Resize($temp, $is_cartouche)."px'";

			$contentHtml .= WH_TD_S.WH_RenderGlyph($temp, $option).WH_TD_E;

        // block must be manualy computed
        } else {
			// get block total height
			$line_max = 0;
			$total    = 0;
			$height   = 0;

			foreach($code as $t) {
				if($t == ":") {
					if($height > $line_max) {
						$line_max = $height;
					}
					$total += $line_max;
					$line_max = 0;

				} else if($t == "*") {
					if($height > $line_max) {
						$line_max = $height;
					}
				} else {
					if(array_key_exists($t, $wh_phonemes)) {
						$glyph = $wh_phonemes[$t];
					} else {
						$glyph = $t;
					}
					if(array_key_exists($glyph, $wh_files)) {
						$height = 2 + $wh_files[$glyph][1];
					}
				}
          	} // end foreach

			if($height > $line_max) {
				$line_max = $height;
			}

			$total += $line_max;

			// render all glyph into the block
			$temp = "";
			foreach($code as $t) {

				if($t == ":") {
					$temp .= "<br />";

				} elseif($t == "*") {
					$temp .= " ";

				} else {
					// resize the glyph according to the block total height
					$option = "height='".WH_Resize($t, $is_cartouche, $total)."px'";
					$temp .= WH_RenderGlyph($t, $option);
				}
			} // end foreach

			$contentHtml .= WH_TD_S.$temp.WH_TD_E;
		}
		$contentHtml .= "\n";
		}

		if(strlen($contentHtml) > 0) {
			$tableContentHtml .= $tableHtml.$contentHtml;
			$contentHtml = $tableHtml = "";
		}
	}

	if(strlen($tableContentHtml) > 0) {
		$html .= WH_TABLE_S."<tr>\n".$tableContentHtml."</tr>".WH_TABLE_E;
	}

	return "<table border='0' cellspacing='0' cellpadding='0' style='display:inline;' class='mw-hierotable'><tr><td>\n$html\n</td></tr></table>";
}

//------------------------------------------------------------------------
// WH_GetCode - Get glyph code from file name
//------------------------------------------------------------------------
// file   << file name
// return >> string with converted code
//------------------------------------------------------------------------
function WH_GetCode($file) {
		return substr($file, strlen(WH_IMG_PRE), -(1+strlen(WH_IMG_EXT)));
}

//------------------------------------------------------------------------
// WH_GetCode - Get glyph code from file name
//------------------------------------------------------------------------
// return >> credit string
//------------------------------------------------------------------------
function WH_Credit() {
	$html = "";
	$html .= "<b>WikiHiero v".WH_VER_MAJ.".".WH_VER_MED.".".WH_VER_MIN."</b>\n";
	$html .= "by Guillaume Blanchard (Aoineko) under GPL (2004).<br />\n";
	$html .= "Hieroglyph credit: S. Rosmorduc, G. Watson, J. Hirst (under GFDL).\n";
	return $html;
}
