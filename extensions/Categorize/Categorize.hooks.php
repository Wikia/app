<?php
if ( !defined( 'MEDIAWIKI' ) )
	die();

class CategorizeHooks {
	/*************************************************************************************/
	## Entry point for the hook and main worker function for editing the page:
	public static function fnCategorizeShowHook( $m_isUpload = false, &$m_pageObj ) {
		global $wgOut, $wgParser, $wgTitle, $wgRequest, $wgScriptPath;
		global $wgTitle, $wgScriptPath, $wgCategorizeCloud, $wgCategorizejs, $wgCategorizecss;
		global $wgCategorizeLabels;

		# Get ALL categories from wiki:
	//		$m_allCats = fnAjaxSuggestGetAllCategories();
		# Get the right member variables, depending on if we're on an upload form or not:
		if ( !$m_isUpload ) {
			# Check if page is subpage once to save method calls later:
			$m_isSubpage = $wgTitle->isSubpage();

			# Check if page has been submitted already to Preview or Show Changes
			$strCatsFromPreview = trim( $wgRequest->getVal( 'txtSelectedCategories2' ) );
			if ( strlen( $strCatsFromPreview ) == 0 ) {
				# Extract all categorylinks from PAGE:
				$m_pageCats = CategorizeBody::fnCategorizeGetPageCategories( $m_pageObj );
			} else {
				# Get cats from preview
				$m_pageCats = explode( ";", $strCatsFromPreview );
			}
			# Never ever use editFormTextTop here as it resides outside the <form> so we will never get contents
			$m_place = 'editFormTextAfterWarn';
			# Print the localised title for the select box:
			$m_textBefore = '<b>' . wfMsg( 'categorize-title' ) . '</b>:';
		} else	{
			# No need to get categories:
			$m_pageCats = array();

			# Place output at the right place:
			$m_place = 'uploadFormTextAfterSummary';
		}

		# ADD EXISTING CATEGORIES TO INPUT BOX
		$arrExistingCats = array();
		$arrExistingCats = array_unique( $m_pageCats );
		# ADD JAVASCRIPT - use document.write so it is not presented if javascript is disabled.
		$m_pageObj->$m_place .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"$wgScriptPath/extensions/Categorize/Categorize.css\" />
	\n"; # provisoire
		$m_pageObj->$m_place .= "<script type=\"text/javascript\" src=\"$wgScriptPath/extensions/Categorize/jquery.js\"></script>\n";
		$m_pageObj->$m_place .= "<script type=\"text/javascript\">var xSelectedLabels = new Array();</script>\n";
		foreach ( $arrExistingCats as $arrExistingCat )
		{
			$m_pageObj->$m_place .= "<script type=\"text/javascript\">xSelectedLabels['$arrExistingCat']=1;</script>\n";
		}
		$m_pageObj->$m_place .= "<script type=\"text/javascript\" src=\"" . $wgCategorizejs . "\"></script>\n";
		$m_pageObj->$m_place .= "<script type=\"text/javascript\">/*<![CDATA[*/\n";
		$m_pageObj->$m_place .= "document.write(\"<div id='categoryselectmaster2'><div style='border-bottom:1px solid #AAAAAA;'><b>" . wfMsg( 'categorize-title' ) . "</b></div>\");\n";
		$m_pageObj->$m_place .= "document.write(\"<p>" . wfMsg( 'categorize-subtitle' ) . "</p>\");\n";
		$m_pageObj->$m_place .= "document.write(\"\");\n";
		$m_pageObj->$m_place .= "document.write(\"<input onkeyup='sendRequest(this,event);' autocomplete='off' type='text' name='txtSelectedCategories2' id='txtSelectedCategories2' maxlength='200' length='150' style='width:100%;' value='" . str_replace( "_", " ", implode( ";", $arrExistingCats ) ) . "'/>\");\n";
		$m_pageObj->$m_place .= "document.write(\"<br/><div id='searchResults'></div>\");\n";
		$m_pageObj->$m_place .= "document.write(\"<input type='hidden' value='" . $wgCategorySuggestCloud . "' id='txtCSDisplayType'/>\");\n";
		$m_pageObj->$m_place .= "document.write(\"<p>" . wfMsg( 'categorize-advice' ) . "</p>\");\n";
		$m_pageObj->$m_place .= "document.write(\"<p><table id='xtable'>\");\n";
		$l__categorize_index = 0;
		foreach ( $wgCategorizeLabels as $l__label_key => $l__label_array )
		{
			$m_pageObj->$m_place .= "document.write(\"<tr>\");\n";
			if ( substr( $l__label_key, 0, 9 ) == 'separator' )
			{
				$m_pageObj->$m_place .= "document.write(\"<td colspan=2> <hr/>\");\n";
			}
			else
			{
				$l__categorize_index += 1;
				$l__key_value_to_print = utf8_encode( str_replace( "_", "&nbsp;", $l__label_key ) );
				$l__xselected = ( in_array( $l__key_value_to_print, $arrExistingCats ) ) ? 'xselected' : '';
				$m_pageObj->$m_place .= "document.write(\"<th style='text-align:left;'><span class='xlabel xmaster xcategorize$l__categorize_index $l__xselected'>$l__key_value_to_print</span></th><td> \");\n";
				foreach ( $l__label_array as $l__label_value )
				{
					$l__label_value_to_print = utf8_encode( str_replace( "_", " ", $l__label_value ) );
					$l__xselected = ( in_array( $l__label_value_to_print, $arrExistingCats ) ) ? 'xselected' : '';
					$m_pageObj->$m_place .= "document.write(\"<span class='xlabel xcategorize$l__categorize_index $l__xselected'>$l__label_value_to_print</span>\");\n";
				}
				$m_pageObj->$m_place .= "document.write(\"</td></tr>\");\n";
			}
		}
		$m_pageObj->$m_place .= "document.write(\"</table></p>\");\n";
		$m_pageObj->$m_place .= "document.write(\"<p>" . wfMsg( 'categorize-footer' ) . "</p>\");\n";
		$m_pageObj->$m_place .= "document.write(\"</div>\");\n";
		$m_pageObj->$m_place .= "/*]]>*/</script>\n";


		return true;
	}

	/*************************************************************************************/
	## Entry point for the hook and main worker function for saving the page:
	public static function fnCategorizeSaveHook( $m_isUpload, $m_pageObj ) {
		global $wgContLang;
		global $wgOut;

		# Get localised namespace string:
		$m_catString = $wgContLang->getNsText( NS_CATEGORY );
		# Get some distance from the rest of the content:
		$m_text = "\n";

		# Assign all selected category entries:
		$strSelectedCats = $_POST['txtSelectedCategories2'];

		# CHECK IF USER HAS SELECTED ANY CATEGORIES
		if ( strlen( $strSelectedCats ) > 1 ) {
			$arrSelectedCats = array();
			$arrSelectedCats = array_unique( explode( ";", $_POST['txtSelectedCategories2'] ) );
			foreach ( $arrSelectedCats as $m_cat ) {
				if ( strlen( $m_cat ) > 0 ) {
					$m_text .= "\n[[$m_catString:" . mysql_escape_string( trim( $m_cat ) ) . "]]";
				}
			}
			# If it is an upload we have to call a different method:
			if ( $m_isUpload ) {
				$m_pageObj->mUploadDescription .= $m_text;
			} else {
				$m_pageObj->textbox1 .= $m_text;
			}
		}
		$wgOut->addHTML( $m_text );

		# Return to the let MediaWiki do the rest of the work:
		return true;
	}

	/*************************************************************************************/
	## Entry point for the CSS:
	public static function fnCategorizeOutputHook( &$m_pageObj, $m_parserOutput ) {
		global $wgScriptPath;

		# Register CSS file for input box:
		$m_pageObj->addLink(
			array(
				'rel'	=> 'stylesheet',
				'type'	=> 'text/css',
				'href'	=> $wgScriptPath . '/extensions/Categorize/Categorize.css'
			)
		);

		return true;
	}

}

?>