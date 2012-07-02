<?php
/* Categorize Mediawiki Extension
 *
 * @author Andreas Rindler (mediawiki at jenandi dot com) for initial Extension:CategorySuggest and Thomas Fauré (faure dot thomas at gmail dot com) for Categorize improvments
 * @credits
 * @licence GNU General Public Licence 3.0
 * @description
 *
*/

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die();
}

class CategorizeBody {
	/*************************************************************************************/
	## Returns an array with the categories the articles is in.
	## Also removes them from the text the user views in the editbox.
	public static function fnCategorizeGetPageCategories( $m_pageObj ) {
	global $wgOut;

		# Get page contents:
		$m_pageText = $m_pageObj->textbox1;

		$arrAllCats = Array();
		$regulartext = '';
		$nowikitext = '';
		$cleanedtext = '';
		$finaltext = '';
		# Check linewise for category links:
		# Get the first part of the text up until the first <nowiki> tag.
		$arrBlocks1 = explode( "<nowiki>", $m_pageText );
		$regulartext = $arrBlocks1[0];

		# Get and strip categories from the first part
		$cleanedtext = CategorizeBody::fnCategorizeStripCats( $regulartext, $arrAllCats );
		$finaltext .= $cleanedtext;

		# Go through the rest of the blocks to find more categories
		for ( $i = 1; $i < count( $arrBlocks1 ); $i++ ) {
			$arrBlocks2 = explode( "</nowiki>", $arrBlocks1[$i] );
			// ignore cats here because it is part of the <nowiki> block
			$nowikitext = $arrBlocks2[0];
			// add to final text
			$finaltext .= '<nowiki>' . $nowikitext . '</nowiki> ';

			// strip cats here because it's the text after the <nowiki> block
			$regulartext = $arrBlocks2[1];
			$cleanedtext = CategorizeBody::fnCategorizeStripCats( $regulartext, $arrAllCats );
			$finaltext .= ltrim( $cleanedtext );
		}

		// Place cleaned text back into the text box:
		$m_pageObj->textbox1 = rtrim( $finaltext );

		return $arrAllCats;

	}

	public static function fnCategorizeStripCats( $texttostrip, &$catsintext ) {
		global $wgContLang, $wgOut;

		# Get localised namespace string:
		$m_catString = strtolower( $wgContLang->getNsText( NS_CATEGORY ) );
		# The regular expression to find the category links:
		$m_pattern = "\[\[({$m_catString}|category):(.*)\]\]";
		$m_replace = "$2";
		# The container to store all found category links:
		$m_catLinks = array ();
		# The container to store the processed text:
		$m_cleanText = '';


		# Check linewise for category links:
		foreach ( explode( "\n", $texttostrip ) as $m_textLine ) {
			# Filter line through pattern and store the result:
			$m_cleanText .= rtrim( preg_replace( "/{$m_pattern}/i", "", $m_textLine ) ) . "\n";

			# Check if we have found a category, else proceed with next line:
			if ( preg_match_all( "/{$m_pattern}/i", $m_textLine, $catsintext2, PREG_SET_ORDER ) ) {
				 foreach ( $catsintext2 as $local_cat => $m_prefix ) {
					// Set first letter to upper case to match MediaWiki standard
					$strFirstLetter = substr( $m_prefix[2], 0, 1 );
					strtoupper( $strFirstLetter );
					$newString = strtoupper( $strFirstLetter ) . substr( $m_prefix[2], 1 );
					array_push( $catsintext, $newString );

				}
				# Get the category link from the original text and store it in our list:
				preg_replace( "/.*{$m_pattern}/i", $m_replace, $m_textLine, -1, $intNumber );
			}

		}
		return $m_cleanText;

	}
	}
?>
