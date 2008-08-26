<?php

# AntiSpoof.php
# Username spoofing prevention for MediaWiki
# Version 0.04

# Copyright (C) Neil Harris 2006
# Python->PHP conversion by Brion Vibber <brion@pobox.com>

# 2006-06-30 Handles non-CJK scripts as per UTR #39 + my extensions
# 2006-07-01 Now handles Simplified <-> Traditional Chinese rules, as
#			per JET Guidelines for Internationalized Domain Names,
#			and the ICANN language registry values for .cn
# 2006-09-14 Now handles 'rn' etc better, and uses stdin for input
# 2006-09-18 Added exception handling for nasty cases, eg BiDi violations
# 2006-09-19 Converted to PHP for easier integration into a MW extension

# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful, but
# WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
# General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301
# USA


class AntiSpoof {
	
	# Define script tag codes for various Unicode codepoint ranges
	# If it does not have a code here, it does not have a script assignment
	# NB: Braille is not in this list since it is a transliteration system, not a script;
	# this does not disadvantage blind people, who will use Braille input/output methods
	# and not raw Braille...
	# NB: Middle dot is included in SCRIPT_LATIN for use in Catalan
	# NB: All scripts described by the Unicode Consortium as "Other Scripts" or "Ancient Scripts"
	# are commented out: these are either not in modern use, or only used for specialized
	# religious purposes, or only of literary interest
	private static $script_ranges = array(
		array( 0x0020, 0x002F, "SCRIPT_ASCII_PUNCTUATION" ), # ASCII Punctuation 1, Hyphen, ASCII Punctuation 2 
		array( 0x0030, 0x0039, "SCRIPT_ASCII_DIGITS" ), # ASCII Digits 
		array( 0x003A, 0x0040, "SCRIPT_ASCII_PUNCTUATION" ), # Colon, ASCII Punctuation 3 
		array( 0x0041, 0x005A, "SCRIPT_LATIN" ), # ASCII Uppercase 
		array( 0x005B, 0x0060, "SCRIPT_ASCII_PUNCTUATION" ), # ASCII Punctuation 4, Underscore, ASCII Punctuation 5 
		array( 0x0061, 0x007A, "SCRIPT_LATIN" ), # ASCII Lowercase 
		array( 0x007B, 0x007E, "SCRIPT_ASCII_PUNCTUATION" ), # ASCII Punctuation 5 
		array( 0x00B7, 0x00B7, "SCRIPT_LATIN" ), # Middle Dot 
		array( 0x00C0, 0x00D6, "SCRIPT_LATIN" ), # Latin-1 Letters 1 
		array( 0x00D8, 0x00F6, "SCRIPT_LATIN" ), # Latin-1 Letters 2 
		array( 0x00F8, 0x02AF, "SCRIPT_LATIN" ), # Latin-1 Letters 3, Latin Extended-A, Latin Extended-B, IPA Extensions 
		array( 0x0300, 0x036F, "SCRIPT_COMBINING_MARKS" ), # Combining Diacritical Marks 
		array( 0x0370, 0x03E1, "SCRIPT_GREEK" ), # Greek and Coptic (Greek) 
		array( 0x03E2, 0x03EF, "SCRIPT_COPTIC_EXTRAS" ), # Greek and Coptic (Coptic-unique) 
		array( 0x03F0, 0x03FF, "SCRIPT_GREEK" ), # Greek and Coptic (Greek) 
		array( 0x0400, 0x052F, "SCRIPT_CYRILLIC" ), # Cyrillic, Cyrillic Supplement 
		array( 0x0530, 0x058F, "SCRIPT_ARMENIAN" ), # Armenian 
		array( 0x0590, 0x05FF, "SCRIPT_HEBREW" ), # Hebrew 
		array( 0x0600, 0x06FF, "SCRIPT_ARABIC" ), # Arabic 
		array( 0x0700, 0x074F, "SCRIPT_SYRIAC" ), # Syriac 
		array( 0x0750, 0x077F, "SCRIPT_ARABIC" ), # Arabic Supplement 
		array( 0x0780, 0x07BF, "SCRIPT_THAANA" ), # Thaana 
		array( 0x0900, 0x097F, "SCRIPT_DEVANAGARI" ), # Devanagari 
		array( 0x0980, 0x09FF, "SCRIPT_BENGALI" ), # Bengali 
		array( 0x0A00, 0x0A7F, "SCRIPT_GURMUKHI" ), # Gurmukhi 
		array( 0x0A80, 0x0AFF, "SCRIPT_GUJARATI" ), # Gujarati 
		array( 0x0B00, 0x0B7F, "SCRIPT_ORIYA" ), # Oriya 
		array( 0x0B80, 0x0BFF, "SCRIPT_TAMIL" ), # Tamil 
		array( 0x0C00, 0x0C7F, "SCRIPT_TELUGU" ), # Telugu 
		array( 0x0C80, 0x0CFF, "SCRIPT_KANNADA" ), # Kannada 
		array( 0x0D00, 0x0D7F, "SCRIPT_MALAYALAM" ), # Malayalam 
		array( 0x0D80, 0x0DFF, "SCRIPT_SINHALA" ), # Sinhala 
		array( 0x0E00, 0x0E7F, "SCRIPT_THAI" ), # Thai 
		array( 0x0E80, 0x0EFF, "SCRIPT_LAO" ), # Lao 
		array( 0x0F00, 0x0FFF, "SCRIPT_TIBETAN" ), # Tibetan 
		array( 0x1000, 0x109F, "SCRIPT_MYANMAR" ), # Myanmar 
		array( 0x10A0, 0x10FF, "SCRIPT_GEORGIAN" ), # Georgian 
		array( 0x1100, 0x11FF, "SCRIPT_HANGUL" ), # Hangul Jamo
		array( 0x1200, 0x139F, "SCRIPT_ETHIOPIC" ), # Ethiopic, Ethiopic Supplement 
		array( 0x13A0, 0x13FF, "SCRIPT_CHEROKEE" ), # Cherokee 
		array( 0x1400, 0x167F, "SCRIPT_CANADIAN_ABORIGINAL" ), # Unified Canadian Aboriginal Syllabics
	#	array( 0x1680, 0x169F, "SCRIPT_OGHAM" ), # Ogham 
	#	array( 0x16A0, 0x16FF, "SCRIPT_RUNIC" ), # Runic 
		array( 0x1700, 0x171F, "SCRIPT_TAGALOG" ), # Tagalog 
		array( 0x1720, 0x173F, "SCRIPT_HANUNOO" ), # Hanunoo 
		array( 0x1740, 0x175F, "SCRIPT_BUHID" ), # Buhid 
		array( 0x1760, 0x177F, "SCRIPT_TAGBANWA" ), # Tagbanwa 
		array( 0x1780, 0x17FF, "SCRIPT_KHMER" ), # Khmer 
		array( 0x1800, 0x18AF, "SCRIPT_MONGOLIAN" ), # Mongolian 
		array( 0x1900, 0x194F, "SCRIPT_LIMBU" ), # Limbu 
		array( 0x1950, 0x197F, "SCRIPT_TAI_LE" ), # Tai Le 
		array( 0x1980, 0x19DF, "SCRIPT_NEW_TAI_LUE" ), # New Tai Lue 
		array( 0x1A00, 0x1A1F, "SCRIPT_BUGINESE" ), # Buginese 
		array( 0x1E00, 0x1EFF, "SCRIPT_LATIN" ), # Latin Extended Additional 
		array( 0x1F00, 0x1FFF, "SCRIPT_GREEK" ), # Greek Extended 
	#	array( 0x2C00, 0x2C5F, "SCRIPT_GLAGOLITIC" ), # Glagolitic 
		array( 0x2C80, 0x2CFF, "SCRIPT_COPTIC" ), # Coptic 
		array( 0x2D00, 0x2D2F, "SCRIPT_GEORGIAN" ), # Georgian Supplement 
		array( 0x2D30, 0x2D7F, "SCRIPT_TIFINAGH" ), # Tifinagh 
		array( 0x2D80, 0x2DDF, "SCRIPT_ETHIOPIC" ), # Ethiopic Extended 
		array( 0x2E80, 0x2FDF, "SCRIPT_DEPRECATED" ), # CJK Radicals Supplement, Kangxi Radicals 
		array( 0x3040, 0x309F, "SCRIPT_HIRAGANA" ), # Hiragana 
		array( 0x30A0, 0x30FF, "SCRIPT_KATAKANA" ), # Katakana 
		array( 0x3100, 0x312F, "SCRIPT_BOPOMOFO" ), # Bopomofo 
		array( 0x3130, 0x318F, "SCRIPT_HANGUL" ), # Hangul Compatibility Jamo
		array( 0x31A0, 0x31BF, "SCRIPT_BOPOMOFO" ), # Bopomofo Extended 
		array( 0x3400, 0x4DBF, "SCRIPT_HAN" ), # CJK Unified Ideographs Extension A 
		array( 0x4E00, 0x9FFF, "SCRIPT_HAN" ), # CJK Unified Ideographs 
		array( 0xA000, 0xA4CF, "SCRIPT_YI" ), # Yi Syllables, Yi Radicals 
		array( 0xA800, 0xA82F, "SCRIPT_SYLOTI_NAGRI" ), # Syloti Nagri 
		array( 0xAC00, 0xD7AF, "SCRIPT_HANGUL" ), # Hangul Syllables 
		array( 0xF900, 0xFAFF, "SCRIPT_DEPRECATED" ), # CJK Compatibility Ideographs 
	#	array( 0x10000, 0x100FF, "SCRIPT_LINEAR_B" ), # Linear B Syllabary, Linear B Ideograms 
	#	array( 0x10140, 0x1018F, "SCRIPT_GREEK" ), # Ancient Greek Numbers 
	#	array( 0x10300, 0x1032F, "SCRIPT_OLD_ITALIC" ), # Old Italic 
		array( 0x10330, 0x1034F, "SCRIPT_GOTHIC" ), # Gothic 
	#	array( 0x10380, 0x1039F, "SCRIPT_UGARITIC" ), # Ugaritic 
	#	array( 0x103A0, 0x103DF, "SCRIPT_OLD_PERSIAN" ), # Old Persian 
	#	array( 0x10400, 0x1044F, "SCRIPT_DESERET" ), # Deseret 
	#	array( 0x10450, 0x1047F, "SCRIPT_SHAVIAN" ), # Shavian 
	#	array( 0x10480, 0x104AF, "SCRIPT_OSMANYA" ), # Osmanya 
	#	array( 0x10800, 0x1083F, "SCRIPT_CYPRIOT" ), # Cypriot Syllabary 
		array( 0x10A00, 0x10A5F, "SCRIPT_KHAROSHTHI" ), # Kharoshthi 
		array( 0x20000, 0x2A6DF, "SCRIPT_HAN" ), # CJK Unified Ideographs Extension B 
		array( 0x2F800, 0x2FA1F, "SCRIPT_DEPRECATED" )  # CJK Compatibility Ideographs Supplement 
	);
	
	# Specially naughty characters we don't ever want to see...
	private static $character_blacklist = array(
		0x0337,
		0x0338,
		0x2044,
		0x2215,
		0x23AE,
		0x29F6,
		0x29F8,
		0x2AFB,
		0x2AFD,
		0xFF0F
	);
	
	# Equivalence sets
	private static $equivset = null;

	static function initEquivSet() {
		if ( is_null( self::$equivset ) ) {
			self::$equivset = unserialize( file_get_contents( 
				dirname( __FILE__ ) . '/equivset.ser' ) );
		}
	}

	private static function getScriptCode( $ch ) {
		# Linear search: binary chop would be faster...
		foreach( self::$script_ranges as $range ) {
			if( $ch >= $range[0] && $ch <= $range[1] ) {
				return $range[2];
			}
		}
		# Otherwise...
		return "SCRIPT_UNASSIGNED";
	}

	# From the name of a script, get a script descriptor, if valid,
	# otherwise return None
	private static function getScriptTag( $name ) {
		$name = "SCRIPT_" . strtoupper( trim( $name ) );
		# Linear search
		foreach( self::$script_ranges as $range ) {
			if( $name == $range[2] ) {
				return $range[2];
			}
		}
		# Otherwise...
		return null;
	}
	
	private static function isSubsetOf( $aList, $bList ) {
		return count( array_diff( $aList, $bList ) ) == 0;
	}
	
	# Is this an allowed script mixture?
	private static function isAllowedScriptCombination( $scriptList ) {
		$allowedScriptCombinations = array(
			array( "SCRIPT_COPTIC", "SCRIPT_COPTIC_EXTRAS" ), # Coptic, using old Greek chars
			array( "SCRIPT_GREEK", "SCRIPT_COPTIC_EXTRAS" ),  # Coptic, using new Coptic chars
			array( "SCRIPT_HAN", "SCRIPT_BOPOMOFO" ),  # Chinese
			array( "SCRIPT_HAN", "SCRIPT_HANGUL" ),	# Korean
			array( "SCRIPT_HAN", "SCRIPT_KATAKANA", "SCRIPT_HIRAGANA" ) # Japanese
		);
		foreach( $allowedScriptCombinations as $allowedCombo ) {
			if( self::isSubsetOf( $scriptList, $allowedCombo ) ) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Convert string into array of Unicode code points as integers
	 */
	public static function stringToList( $str ) {
		if ( !preg_match_all( '/./us', $str, $ar ) ) {
			return array();
		}
		$out = array();
		foreach ( $ar[0] as $char ) {
			$out[] = utf8ToCodepoint( $char );
		}
		return $out;
	}
	
	public static function listToString( $list ) {
		$out = '';
		foreach( $list as $cp ) {
			$out .= codepointToUtf8( $cp );
		}
		return $out;
	}
	
	private static function hardjoin( $a_list ) {
		return implode( '', $a_list );
	}
	
	public static function equivString( $testName ) {
		$out = array();
		self::initEquivSet();
		foreach( $testName as $codepoint ) {
			if( isset( self::$equivset[$codepoint] ) ) {
				$out[] = self::$equivset[$codepoint];
			} else {
				$out[] = $codepoint;
			}
	   }
	   return $out;
	}
	
	private static function mergePairs( $text, $pair, $result ) {
		$out = array();
		for( $i = 0; $i < count( $text ); $i++ ) {
			if( $text[$i] == $pair[0] && @$text[$i+1] == $pair[1] ) {
				$out[] = $result[0];
				$i++;
			} else {
				$out[] = $text[$i];
			}
		}
		return $out;
	}
	
	private static function stripScript( $text, $script ) {
		$scripts = array_map( array( 'AntiSpoof', 'getScriptCode' ), $text );
		$out = array();
		foreach( $text as $index => $char ) {
			if( $scripts[$index] !== $script ) {
				$out[] = $char;
			}
		}
		return $out;
	}
	
	# TODO: does too much in one routine, refactor...
	public static function checkUnicodeString( $testName ) {
		wfLoadExtensionMessages( 'AntiSpoof' );
		# Start with some sanity checking
		if( !is_string( $testName ) ) {
			return array( "ERROR", wfMsg('antispoof-badtype') );
		}
	
		if( strlen( $testName ) == 0 ) {
			return array("ERROR", wfMsg('antispoof-empty') );
		}
	
		if( array_intersect( self::stringToList( $testName ), self::$character_blacklist ) ) {
			return array( "ERROR", wfMsg('antispoof-blacklisted') );
		}
	
		# Perform Unicode _compatibility_ decomposition
		$testName = UtfNormal::toNFKD( $testName );
		$testChars = self::stringToList( $testName );
	
		# Be paranoid: check again, just in case Unicode normalization code changes...
		if( array_intersect( $testChars, self::$character_blacklist ) ) {
			return array( "ERROR", wfMsg('antispoof-blacklisted') );
		}
	
		# Check for this: should not happen in any valid Unicode string
		if( self::getScriptCode( $testChars[0] ) == "SCRIPT_COMBINING_MARKS" ) {
			return array( "ERROR", wfMsg('antispoof-combining') );
		}
	
		# Strip all combining characters in order to crudely strip accents
		# Note: NFKD normalization should have decomposed all accented chars earlier
		$testChars = self::stripScript( $testChars, "SCRIPT_COMBINING_MARKS" );
	
		$testScripts = array_unique( array_map( array( 'AntiSpoof', 'getScriptCode' ), $testChars ) );
		if( in_array( "SCRIPT_UNASSIGNED", $testScripts ) || in_array( "SCRIPT_DEPRECATED", $testScripts ) ) {
			return array( "ERROR", wfMsg('antispoof-unassigned') );
		}
	
		# We don't mind ASCII punctuation or digits
		$testScripts = array_diff( $testScripts,
						array( "SCRIPT_ASCII_PUNCTUATION", "SCRIPT_ASCII_DIGITS" ) );
	
		if( !$testScripts ) {
			return array( "ERROR", wfMsg('antispoof-noletters') );
		}
	
		if( count( $testScripts ) > 1 && !self::isAllowedScriptCombination( $testScripts ) ) {
			return array( "ERROR", wfMsg('antispoof-mixedscripts') );
		}
	
		# At this point, we should probably check for BiDi violations if they aren't
		# caught above...
		
		# Replace characters in confusables set with equivalence chars
		$testChars = self::equivString( $testChars );
		
		# Do very simple sequence processing: "vv" -> "w", "rn" -> "m"...
		# Not exhaustive, but ups the ante...
		# Do this _after_ canonicalization: looks weird, but needed for consistency
		$testChars = self::mergePairs( $testChars,
			self::equivString( self::stringToList( "VV" ) ),
			self::equivString( self::stringToList( "W"  ) ) );
		$testChars = self::mergePairs( $testChars,
			self::equivString( self::stringToList( "RN" ) ),
			self::equivString( self::stringToList( "M"  ) ) );
		
		# Squeeze out all punctuation chars
		# TODO: almost the same code occurs twice, refactor into own routine
		$testChars = self::stripScript( $testChars, "SCRIPT_ASCII_PUNCTUATION" );
	
		$testName = self::listToString( $testChars );
		
		# Remove all remaining spaces, just in case any have snuck through...
		$testName = self::hardjoin( explode( " ", $testName ) );
	
		# Reduce repeated char sequences to single character
		# BUG: TODO: implement this
	
		if( strlen( $testName ) < 1 ) {
			return array("ERROR", wfMsg('antispoof-tooshort') );
		}
	
		# Don't ASCIIfy: we assume we are UTF-8 capable on output
	
		# Prepend version string, for futureproofing if this algorithm changes
		$testName = "v2:" . $testName;
	
		# And return the canonical version of the name
		return array( "OK", $testName );
	}

}
