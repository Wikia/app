<?php

/**
 * WikiHiero - A PHP convert from text using "Manual for the encoding of
 * hieroglyphic texts for computer input" syntax to HTML entities (table and
 * images).
 *
 * Copyright (C) 2004 Guillaume Blanchard (Aoineko)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) {
	$IP = dirname( __FILE__ ) . '/../..';
}
require_once( "$IP/maintenance/Maintenance.php" );

class GenerateWikiHieroTables extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Generate tables with hieroglyph information';

		$this->moreTables = str_replace( "\r", '', $this->moreTables );
	}

	public function execute() {
		if ( !defined( 'WIKIHIERO_VERSION' ) ) {
			$this->error( "Please install WikiHiero first!\n", true );
		}

		$wh_prefabs = "\$wh_prefabs = array(\n";
		$wh_files   = "\$wh_files   = array(\n";

		$imgDir = dirname( __FILE__ ) . '/img/';

		if ( is_dir( $imgDir ) ) {
			$dh = opendir( $imgDir );
			if ( $dh ) {
				while ( ( $file = readdir( $dh ) ) !== false ) {
					if ( stristr( $file, WikiHiero::IMAGE_EXT ) ) {
						list( $width, $height, $type, $attr ) = getimagesize( $imgDir . $file );
						$wh_files .= "  \"" . WikiHiero::getCode( $file ) . "\" => array( $width, $height ),\n";
						if ( strchr( $file, '&' ) ) {
							$wh_prefabs .= "  \"" . WikiHiero::getCode( $file ) . "\",\n";
						}
					}
				}
				closedir( $dh );
			}
		} else {
			$this->error( "Images directory $imgDir not found!\n", true );
		}

		$wh_prefabs .= ");";
		$wh_files .= ");";

		$file = fopen( 'data/tables.php', 'w+' );
		fwrite( $file, "<?php\n\n" );
		fwrite( $file, '// File created by generateTables.php version ' . WIKIHIERO_VERSION . "\n" );
		fwrite( $file, '// ' . date( 'Y-m-d \a\t H:i' ) . "\n\n" );
		fwrite( $file, "$wh_prefabs\n\n$wh_files\n\n{$this->moreTables}\n" );
		fclose( $file );

		$this->serialize();
	}

	private function serialize() {
		require( 'data/tables.php' );
		$result = array();
		foreach ( array( 'wh_phonemes', 'wh_prefabs', 'wh_files' ) as $varName ) {
			$result[$varName] = $$varName;
		}
		file_put_contents( 'data/tables.ser', serialize( $result ) );
	}

	var $moreTables = '
$wh_phonemes	=	array(	//	convertion	table	phoneme	->	Gardiner	code
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

	"<1"	=>	"Ca1",	// cartouche
	"2>"	=>	"Ca2",
	"<2"	=>	"Ca2a",
	"1>"	=>	"Ca1a",
	"<0"	=>	"Ca1",
	"0>"	=>	"Ca2",
	"<h1"	=>	"Cah1",	// horus
	"h1>"	=>	"Cah1a",
	"<h2"	=>	"Cah2",
	"h2>"	=>	"Cah2a",
	"<h3"	=>	"Cah3",
	"h3>"	=>	"Cah3a",
	"<h0"	=>	"Cah1",
	"h0>"	=>	"Cah1a",
	"<"	=>	"Ca1",	// cartouche
	">"	=>	"Ca2",
	"[&"	=>	"Ba16",
	"&]"	=>	"Ba16",
	"[{"	=>	"Ba17",
	"}]"	=>	"Ba17a",
	"[["	=>	"Ba15",
	"]]"	=>	"Ba15a",
	"[\""	=>	"",
	"\"]"	=>	"",
	"[\'"	=>	"",
	"\']"	=>	"",
);
';

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

}

$maintClass = "GenerateWikiHieroTables";
require_once( RUN_MAINTENANCE_IF_MAIN );
