<?php

# Implementation of the SelectCategory extension, an extension of the
# edit box of MediaWiki to provide an easy way to add category links
# to a specific page.

# @addtogroup Extensions
# @author Leon Weber <leon@leonweber.de> & Manuel Schneider <manuel.schneider@wikimedia.ch>
# @copyright © 2006 by Leon Weber & Manuel Schneider
# @licence GNU General Public Licence 2.0 or later

if( !defined( 'MEDIAWIKI' ) ) {
  echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
  die();
}

## Entry point for the hook and main worker function for editing the page:
function fnSelectCategoryShowHook( $m_isUpload = false, &$m_pageObj ) {

  # check if we should do anything or sleep
  if ( fnSelectCategoryCheckConditions( $m_isUpload, &$m_pageObj ) ) {
    # Register CSS file for our select box:
    global $wgOut, $wgScriptPath;
    $wgOut->addLink(
      array(
        'rel'  => 'stylesheet',
        'type' => 'text/css',
        'href' => "$wgScriptPath/extensions/SelectCategory/SelectCategory.css"
      )
    );

    # Get all categories from wiki:
    $m_allCats = fnSelectCategoryGetAllCategories();
    # Load system messages:
    wfLoadExtensionMessages( 'SelectCategory' );
    # Get the right member variables, depending on if we're on an upload form or not:
    if( !$m_isUpload ) {
      # Extract all categorylinks from page:
      $m_pageCats = fnSelectCategoryGetPageCategories( $m_pageObj );

      # Never ever use editFormTextTop here as it resides outside the <form> so we will never get contents
      $m_place = 'editFormTextAfterWarn';
      # Print the localised title for the select box:
      $m_textBefore = '<b>'. wfMsg( 'selectcategory-title' ) . '</b>:';
    } else {
      # No need to get categories:
      $m_pageCats = array();

      # Place output at the right place:
      $m_place = 'uploadFormTextAfterSummary';
      # Print the part of the table including the localised title for the select box:
      $m_textBefore = "\n</td></tr><tr><td align='right'><label for='wpSelectCategory'>" . wfMsg( 'selectcategory-title' ) .":</label></td><td align='left'>";
    }
    # Introduce the output:
    $m_pageObj->$m_place .= "<!-- SelectCategory begin -->\n";
    # Print the select box:
    $m_pageObj->$m_place .= "\n$m_textBefore";
#    # First come up with the JavaScript version of the select boxes:
#    $m_pageObj->$m_place .= "<script type=\"text/javascript\" src=\"'/extensions/SelectCategory/SelectCategory.js\"></script>\n";
#    # Then the "old-style" select box for those without JavaScript:
#    $m_pageObj->$m_place .= "<noscript>\n";
#    $m_pageObj->$m_place .= "</noscript>\n";

    $m_pageObj->$m_place .= "<ul id='SelectCategoryList'>";
    foreach( $m_allCats as $m_cat => $m_depth ) {
      $checked = '';

      if (isset($m_pageCats[$m_cat])) {
        $checked = "checked='checked'";
      }

      $category =  htmlspecialchars( $m_cat );

      # Indent subcategories
      $indention = '';
      for ($i = 0; $i < $m_depth; $i++) {
        $indention .= '&nbsp;&nbsp;';
      }

      $m_pageObj->$m_place .= "
        <li>
          $indention<input type='checkbox' name='SelectCategoryList[]'
            value='$category' class='checkbox' $checked />
          $category
        </li>";
    }
    $m_pageObj->$m_place .= '</ul>';

    # Print localised help string:
    $m_pageObj->$m_place .= "<!-- SelectCategory end -->\n";
  }

  # Return true to let the rest work:
  return true;
}

## Entry point for the hook and main worker function for saving the page:
function fnSelectCategorySaveHook( $m_isUpload, &$m_pageObj ) {
  global $wgContLang;
  global $wgTitle;

  # check if we should do anything or sleep
  if ( fnSelectCategoryCheckConditions( $m_isUpload, &$m_pageObj ) ) {

    # Get localised namespace string:
    $m_catString = $wgContLang->getNsText( NS_CATEGORY );

    # default sort key is page name with stripped namespace name,
    # otherwise sorting is ugly.
    if ($wgTitle->getNamespace() == NS_MAIN) {
      $default_sortkey = "";
    } else {
      $default_sortkey = "|{{PAGENAME}}";
    }

    # Get some distance from the rest of the content:
    $m_text = "\n";

    # Iterate through all selected category entries:
    if (array_key_exists('SelectCategoryList', $_POST)) {
      foreach( $_POST['SelectCategoryList'] as $m_cat ) {
        $m_text .= "\n[[$m_catString:$m_cat$default_sortkey]]";
      }
    }
    # If it is an upload we have to call a different method:
    if ( $m_isUpload ) {
      $m_pageObj->mUploadDescription .= $m_text;
    } else{
      $m_pageObj->textbox1 .= $m_text;
    }
  }

  # Return to the let MediaWiki do the rest of the work:
  return true;
}

## Get all categories from the wiki - starting with a given root or otherwise detect root automagically (expensive)
## Returns an array like this:
## array (
##   'Name' => (int) Depth,
##   ...
## )
function fnSelectCategoryGetAllCategories() {
  global $wgTitle;
  global $wgSelectCategoryRoot;

  # Get current namespace (save duplicate call of method):
  $m_namespace = $wgTitle->getNamespace();
  if( $m_namespace >= 0 && $wgSelectCategoryRoot[$m_namespace] ) {
    # Include root and step into the recursion:
    $m_allCats = array_merge( array( $wgSelectCategoryRoot[$m_namespace] => 0 ), fnSelectCategoryGetChildren( $wgSelectCategoryRoot[$m_namespace] ) );
  } else {
    # Initialize return value:
    $m_allCats = array();

    # Get a database object:
    $m_dbObj =& wfGetDB( DB_SLAVE );
    # Get table names to access them in SQL query:
    $m_tblCatLink = $m_dbObj->tableName( 'categorylinks' );
    $m_tblPage = $m_dbObj->tableName( 'page' );

    # Automagically detect root categories:
    $m_sql = "  SELECT tmpSelectCat1.cl_to AS title
        FROM $m_tblCatLink AS tmpSelectCat1
        LEFT JOIN $m_tblPage AS tmpSelectCatPage ON (tmpSelectCat1.cl_to = tmpSelectCatPage.page_title AND tmpSelectCatPage.page_namespace = 14)
        LEFT JOIN $m_tblCatLink AS tmpSelectCat2 ON tmpSelectCatPage.page_id = tmpSelectCat2.cl_from
        WHERE tmpSelectCat2.cl_from IS NULL GROUP BY tmpSelectCat1.cl_to";
    # Run the query:
    $m_res = $m_dbObj->query( $m_sql, __METHOD__ );
    # Process the resulting rows:
    while ( $m_row = $m_dbObj->fetchRow( $m_res ) ) {
      $m_allCats += array( $m_row['title'] => 0 );
      $m_allCats += fnSelectCategoryGetChildren( $m_row['title'] );
    }
    # Free result:
    $m_dbObj->freeResult( $m_res );
  }

  # Afterwards return the array to the caller:
  return $m_allCats;
}

function fnSelectCategoryGetChildren( $m_root, $m_depth = 1 ) {
  # Initialize return value:
  $m_allCats = array();

  # Get a database object:
  $m_dbObj =& wfGetDB( DB_SLAVE );
  # Get table names to access them in SQL query:
  $m_tblCatLink = $m_dbObj->tableName( 'categorylinks' );
  $m_tblPage = $m_dbObj->tableName( 'page' );

  # The normal query to get all children of a given root category:
  $m_sql = "  SELECT tmpSelectCatPage.page_title AS title
      FROM $m_tblCatLink AS tmpSelectCat
      LEFT JOIN $m_tblPage AS tmpSelectCatPage ON tmpSelectCat.cl_from = tmpSelectCatPage.page_id
      WHERE tmpSelectCat.cl_to LIKE " . $m_dbObj->addQuotes( $m_root ) . " AND tmpSelectCatPage.page_namespace = 14";
  # Run the query:
  $m_res = $m_dbObj->query( $m_sql, __METHOD__ );
  # Process the resulting rows:
  while ( $m_row = $m_dbObj->fetchRow( $m_res ) ) {
    # Survive category link loops:
    if( $m_root == $m_row['title'] ) {
      continue;
    }
    # Add current entry to array:
    $m_allCats += array( $m_row['title'] => $m_depth );
    $m_allCats += fnSelectCategoryGetChildren( $m_row['title'], $m_depth + 1 );
  }
  # Free result:
  $m_dbObj->freeResult( $m_res );

  # Afterwards return the array to the upper recursion level:
  return $m_allCats;
}

## Returns an array with the categories the articles is in.
## Also removes them from the text the user views in the editbox.
function fnSelectCategoryGetPageCategories( $m_pageObj ) {

  if (array_key_exists('SelectCategoryList', $_POST)) {
    # We have already extracted the categories, return them instead
    # of extracting zero categories from the page text.
    $m_catLinks = array();
    foreach( $_POST['SelectCategoryList'] as $m_cat ) {
      $m_catLinks[ $m_cat ] = true;
    }
    return $m_catLinks;
  }

  global $wgContLang;

  # Get page contents:
  $m_pageText = $m_pageObj->textbox1;
  # Get localised namespace string:
  $m_catString = strtolower( $wgContLang->getNsText( NS_CATEGORY ) );
  # The regular expression to find the category links:
  $m_pattern = "\[\[({$m_catString}|category):([^\|\]]*)(\|{{PAGENAME}}|)\]\]";
  $m_replace = "$2";
  # The container to store all found category links:
  $m_catLinks = array ();
  # The container to store the processed text:
  $m_cleanText = '';

  # Check linewise for category links:
  foreach( explode( "\n", $m_pageText ) as $m_textLine ) {
    # Filter line through pattern and store the result:
    $m_cleanText .= preg_replace( "/{$m_pattern}/i", "", $m_textLine ) . "\n";
    # Check if we have found a category, else proceed with next line:
                if( !preg_match( "/{$m_pattern}/i", $m_textLine) ) continue;
    # Get the category link from the original text and store it in our list:
    $m_catLinks[ str_replace( ' ', '_', preg_replace( "/.*{$m_pattern}/i", $m_replace, $m_textLine ) ) ] = true;
  }
  # Place the cleaned text into the text box:
  $m_pageObj->textbox1 = trim( $m_cleanText );

  # Return the list of categories as an array:
  return $m_catLinks;
}

# Function that checks if we meet the run conditions of the extension
function fnSelectCategoryCheckConditions ($m_isUpload, &$m_pageObj ) {
  global $wgSelectCategoryNamespaces;
  global $wgSelectCategoryEnableSubpages;
  global $wgTitle;


  # Run only if we are in an upload, an activated namespace or if page is
  # a subpage and subpages are enabled (unfortunately we can't use
  # implication in PHP) but not if we do a sectionedit:

  if ($m_isUpload == true) {
    return true;
  }

  $ns = $wgTitle->getNamespace();
  if (array_key_exists ($ns, $wgSelectCategoryNamespaces)) {
    $enabledForNamespace = $wgSelectCategoryNamespaces[$ns];
  } else {
    $enabledForNamespace = false;
  }

  # Check if page is subpage once to save method calls below:
  $m_isSubpage = $wgTitle->isSubpage();

  if ($enabledForNamespace
    && (!$m_isSubpage
      || $m_isSubpage && $wgSelectCategoryEnableSubpage)
    && $m_pageObj->section == false) {
    return true;
  }
}
