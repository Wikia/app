<?php

/**
 * Implementation of the SelectCategory extension, an extension of the
 * edit box of MediaWiki to provide an easy way to add category links
 * to a specific page.
 *
 * @file
 * @ingroup Extensions
 * @author Leon Weber <leon@leonweber.de> & Manuel Schneider <manuel.schneider@wikimedia.ch>
 * @copyright Â© 2006 by Leon Weber & Manuel Schneider
 * @licence GNU General Public Licence 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die();
}


class SelectCategory {

	## Entry point for the hook and main function for editing the page
	public static function showHook( $isUpload = false, $pageObj ) {

		# check if we should do anything or sleep
		if ( self::checkConditions( $isUpload, $pageObj ) ) {
			# Register CSS file for our select box
			global $wgOut, $wgUser, $wgExtensionAssetsPath;
			global $wgSelectCategoryMaxLevel;

			$wgOut->addExtensionStyle( "{$wgExtensionAssetsPath}/SelectCategory/SelectCategory.css" );
			$wgOut->addExtensionStyle( "{$wgExtensionAssetsPath}/SelectCategory/jquery.treeview.css" );
			$wgOut->addScriptFile( "{$wgExtensionAssetsPath}/SelectCategory/jquery.treeview.js" );
			$wgOut->addScriptFile( "{$wgExtensionAssetsPath}/SelectCategory/SelectCategory.js" );

			$skin = $wgUser->getSkin();

			# Get all categories from wiki
			$allCats = self::getAllCategories( $isUpload ? NS_SPECIAL : $pageObj->mTitle->getNamespace() );
			# Load system messages
		
			# Get the right member variables, depending on if we're on an upload form or not
			if( !$isUpload ) {
				# Extract all categorylinks from page
				$pageCats = self::getPageCategories( $pageObj );
	
				# Never ever use editFormTextTop here as it resides outside
				# the <form> so we will never get contents
				$place = 'editFormTextAfterWarn';
				# Print the localised title for the select box
				$textBefore = '<b>'. wfMsg( 'selectcategory-title' ) . '</b>:';
			} else {
				# No need to get categories
				$pageCats = array();

				# Place output at the right place
				$place = 'uploadFormTextAfterSummary';
				# Print the part of the table including the localised title for the select box
				$textBefore = "\n</td></tr><tr><td align='right'><label for='wpSelectCategory'>" . wfMsg( 'selectcategory-title' ) .":</label></td><td align='left'>";
			}
			# Introduce the output
			$pageObj->$place .= "<!-- SelectCategory begin -->\n";
			# Print the select box
			$pageObj->$place .= "\n$textBefore";

			# Begin list output, use <div> to enable custom formatting
			$level = 0;
			$pageObj->$place .= '<ul id="SelectCategoryList">';

			foreach( $allCats as $cat => $depth ) {
				$checked = '';

				# See if the category was already added, so check it
				if( isset( $pageCats[$cat] ) ) {
					$checked = 'checked="checked"';
				}
				# Clean HTML Output
				$category =  htmlspecialchars( $cat );

				# default for root category - otherwise it will always be closed
				$open = " class='open' ";

				# iterate through levels and adjust divs accordingly
				while( $level < $depth ) {
					# Collapse subcategories after reaching the configured MaxLevel
					if( $level >= ( $wgSelectCategoryMaxLevel - 1 ) ) {
						$class = 'display:none;';
						$open = " class='closed' ";
					} else {
						$class = 'display:block;';
						$open = " class='open' ";
					}
					$pageObj->$place .= '<ul style="'.$class.'">'."\n";
					$level++;
				}
				if( $level == $depth ) {
					$pageObj->$place .= '</li>'."\n";
				}
				while( $level > $depth ) {
					$pageObj->$place .= '</ul></li>'."\n";
					$level--;
				}
				# Clean names for text output
				$catName = str_replace( '_', ' ', $category );
				$title = Title::newFromText( $category, NS_CATEGORY );
				# Output the actual checkboxes, indented
				$pageObj->$place .= '<li' . $open . '><input type="checkbox" name="SelectCategoryList[]" value="'.$category.'" class="checkbox" '.$checked.' />'.$skin->link( $title, $catName )."\n";
				# set id for next level
				$level_id = 'sc_'.$cat;
			} # End walking through cats (foreach)
			# End of list output - close all remaining divs
			while( $level > -1 ) {
				$pageObj->$place .= '</li></ul>'."\n";
				$level--;
			}

			# Print localised help string
			$pageObj->$place .= "<!-- SelectCategory end -->\n";
		}

		# Return true to let the rest work
		return true;
	}

	## Entry point for the hook and main function for saving the page
	public static function saveHook( $isUpload, $pageObj ) {
		global $wgContLang;

		# check if we should do anything or sleep
		if ( self::checkConditions( $isUpload, $pageObj ) ) {

			# Get localised namespace string
			$catString = $wgContLang->getNsText( NS_CATEGORY );

			# default sort key is page name with stripped namespace name,
			# otherwise sorting is ugly.
			if( !$isUpload && $pageObj->mTitle->getNamespace() == NS_MAIN ) {
				$default_sortkey = "";
			} else {
				$default_sortkey = "|{{PAGENAME}}";
			}

			# Get some distance from the rest of the content
			$text = "\n";

			# Iterate through all selected category entries
			if (array_key_exists('SelectCategoryList', $_POST)) {
				foreach( $_POST['SelectCategoryList'] as $cat ) {
					$text .= "\n[[$catString:$cat$default_sortkey]]";
				}
			}
			# If it is an upload we have to call a different method
			if ( $isUpload ) {
				$pageObj->mUploadDescription .= $text;
			} else {
				$pageObj->textbox1 .= $text;
			}
		}

		# Return to the let MediaWiki do the rest of the work
		return true;
	}

	## Get all categories from the wiki - starting with a given root or otherwise detect root automagically (expensive)
	## Returns an array like this
	## array (
	##   'Name' => (int) Depth,
	##   ...
	## )
	public static function getAllCategories( $namespace ) {
		global $wgSelectCategoryRoot;

		# Get current namespace (save duplicate call of method)
		if( $namespace >= 0 && array_key_exists( $namespace, $wgSelectCategoryRoot ) && $wgSelectCategoryRoot[$namespace] ) {
			# Include root and step into the recursion
			$allCats = array_merge( array( $wgSelectCategoryRoot[$namespace] => 0 ),
				self::getChildren( $wgSelectCategoryRoot[$namespace] ) );
		} else {
			# Initialize return value
			$allCats = array();

			# Get a database object
			$dbObj = wfGetDB( DB_SLAVE );
			# Get table names to access them in SQL query
			$tblCatLink = $dbObj->tableName( 'categorylinks' );
			$tblPage = $dbObj->tableName( 'page' );

			# Automagically detect root categories
			$sql = "  SELECT tmpSelectCat1.cl_to AS title
FROM $tblCatLink AS tmpSelectCat1
LEFT JOIN $tblPage AS tmpSelectCatPage ON (tmpSelectCat1.cl_to = tmpSelectCatPage.page_title AND tmpSelectCatPage.page_namespace = 14)
LEFT JOIN $tblCatLink AS tmpSelectCat2 ON tmpSelectCatPage.page_id = tmpSelectCat2.cl_from
WHERE tmpSelectCat2.cl_from IS NULL GROUP BY tmpSelectCat1.cl_to";
			# Run the query
			$res = $dbObj->query( $sql, __METHOD__ );
			# Process the resulting rows
			while ( $row = $dbObj->fetchRow( $res ) ) {
				$allCats += array( $row['title'] => 0 );
				$allCats += self::getChildren( $row['title'] );
			}
			# Free result
			$dbObj->freeResult( $res );
		}

		# Afterwards return the array to the caller
		return $allCats;
	}

	public static function getChildren( $root, $depth = 1 ) {
		# Initialize return value
		$allCats = array();

		# Get a database object
		$dbObj = wfGetDB( DB_SLAVE );
		# Get table names to access them in SQL query
		$tblCatLink = $dbObj->tableName( 'categorylinks' );
		$tblPage = $dbObj->tableName( 'page' );

		# The normal query to get all children of a given root category
		$sql = 'SELECT tmpSelectCatPage.page_title AS title
FROM '.$tblCatLink.' AS tmpSelectCat
LEFT JOIN '.$tblPage.' AS tmpSelectCatPage
  ON tmpSelectCat.cl_from = tmpSelectCatPage.page_id
WHERE tmpSelectCat.cl_to LIKE '.$dbObj->addQuotes( $root ).'
  AND tmpSelectCatPage.page_namespace = 14
ORDER BY tmpSelectCatPage.page_title ASC;';
		# Run the query
		$res = $dbObj->query( $sql, __METHOD__ );
		# Process the resulting rows
		while ( $row = $dbObj->fetchRow( $res ) ) {
			# Survive category link loops
			if( $root == $row['title'] ) {
				continue;
			}
			# Add current entry to array
			$allCats += array( $row['title'] => $depth );
			$allCats += self::getChildren( $row['title'], $depth + 1 );
		}
		# Free result
		$dbObj->freeResult( $res );

		# Afterwards return the array to the upper recursion level
		return $allCats;
	}

	## Returns an array with the categories the articles is in.
	## Also removes them from the text the user views in the editbox.
	public static function getPageCategories( $pageObj ) {

		if (array_key_exists('SelectCategoryList', $_POST)) {
			# We have already extracted the categories, return them instead
			# of extracting zero categories from the page text.
			$catLinks = array();
			foreach( $_POST['SelectCategoryList'] as $cat ) {
				$catLinks[$cat] = true;
			}
			return $catLinks;
		}

		global $wgContLang;

		# Get page contents
		$pageText = $pageObj->textbox1;
		# Get localised namespace string
		$catString = strtolower( $wgContLang->getNsText( NS_CATEGORY ) );
		# The regular expression to find the category links
		$pattern = "\[\[({$catString}|category):([^\|\]]*)(\|{{PAGENAME}}|)\]\]";
		$replace = "$2";
		# The container to store all found category links
		$catLinks = array ();
		# The container to store the processed text
		$cleanText = '';

		# Check linewise for category links
		foreach( explode( "\n", $pageText ) as $textLine ) {
			# Filter line through pattern and store the result
			$cleanText .= preg_replace( "/{$pattern}/i", "", $textLine ) . "\n";
			# Check if we have found a category, else proceed with next line
			if( !preg_match( "/{$pattern}/i", $textLine) ) continue;
			# Get the category link from the original text and store it in our list
			$catLinks[ str_replace( ' ', '_', preg_replace( "/.*{$pattern}/i", $replace, $textLine ) ) ] = true;
		}
		# Place the cleaned text into the text box
		$pageObj->textbox1 = trim( $cleanText );

		# Return the list of categories as an array
		return $catLinks;
	}

	# Function that checks if we meet the run conditions of the extension
	public static function checkConditions ($isUpload, $pageObj ) {
		global $wgSelectCategoryNamespaces;
		global $wgSelectCategoryEnableSubpages;


		# Run only if we are in an upload, an activated namespace or if page is
		# a subpage and subpages are enabled (unfortunately we can't use
		# implication in PHP) but not if we do a sectionedit

		if ($isUpload == true) {
			return true;
		}

		$ns = $pageObj->mTitle->getNamespace();
		if( array_key_exists( $ns, $wgSelectCategoryNamespaces ) ) {
			$enabledForNamespace = $wgSelectCategoryNamespaces[$ns];
		} else {
			$enabledForNamespace = false;
		}

		# Check if page is subpage once to save method calls below
		$isSubpage = $pageObj->mTitle->isSubpage();

		if ($enabledForNamespace
			&& (!$isSubpage
				|| $isSubpage && $wgSelectCategoryEnableSubpage)
			&& $pageObj->section == false) {
			return true;
		}
	}

}
