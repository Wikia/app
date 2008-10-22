<?php
if (!defined('MEDIAWIKI')) die();
/**
 * Allows multi-textarea article editing
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Tomasz Klim <tomek@wikia.com>
 * @copyright Copyright (C) 2007 Tomasz Klim, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
LocalSettings.php:
+ $wgMultiEditEnable = true;
+ require_once( "$IP/extensions/MultiEdit/MultiEdit.php" );
 *
includes/EditPage.php:
+ wfRunHooks( 'EditForm::MultiEdit:Form', array( $rows, $cols, $ew, htmlspecialchars( $this->safeUnicodeOutput( $this->textbox1 ) ) ) );
+ wfRunHooks( 'EditForm::MultiEdit:Start' );
 *
includes/Linker.php:
+ $retval = wfRunHooks( 'EditForm::MultiEdit:Section' );
 *
 */

$wgHooks['EditForm::MultiEdit:Form'][] = 'wfMultiEditFormExt';
$wgHooks['EditForm::MultiEdit:Section'][] = 'wfMultiEditSection';
$wgHooks['EditPage::showEditForm:initial'][] = 'wfMultiEditShowLink';
$wgExtensionCredits['other'][] = array(
	'name' => 'Multi Edit',
	'description' => 'allows multi-section article editing',
	'author' => 'Tomasz Klim'
);


define ("MULTIEDIT_SECTION_PARSE", '/\n==[^=]/s');
define ("MULTIEDIT_SPECIAL_TAG_FORMAT", '<!---%s--->');
define ("MULTIEDIT_ADDITIONAL_TAG_PARSE", '/\<!---(.*?)\s*=\s*(&quot;|\'|")*(.*?)(&quot;|\'|")*---\>/is');
define ("MULTIEDIT_SIMPLE_TAG_PARSE", '/\<!---(.*?)---\>/is');
define ("MULTIEDIT_CATEGORY_TAG_PARSE", '/\[\[Category:(.*?)\]\]/');
define ("MULTIEDIT_CATEGORY_TAG_SPECIFIC", '/\<!---categories---\>/is') ;
define ("MULTIEDIT_IMAGEUPLOAD_TAG_SPECIFIC", '/\<!---imageupload---\>/is') ;
define ("MULTIEDIT_ISBLANK_TAG_SPECIFIC", '<!---blanktemplate--->') ;
define ("MULTIEDIT_TEMPLATE_INFOBOX_FORMAT", '/\{\{[^\{\}]*Infobox[^\{\}]*\}\}/i') ;
define ("MULTIEDIT_TEMPLATE_OPENING", '/\{\{[^\{\}]*Infobox[^\|]*/i') ;
define ("MULTIEDIT_TEMPLATE_CLOSING", '/\}\}/') ;

define ('MULTI_EDIT_TEXTAREA_LINE_NUM', 8);

function wfMultiEditFormExt( $rows, $cols, $ew, $textbox1 )
{
	global $wgOut, $wgRequest, $wgLanguageNames, $wgMessageCache, $wgMultiEditMessages, $wgMultiEditEnable, $wgTitle, $wgMultiEditTag;
	global $IP, $wgStyleVersion;
	
	#---
	$is_used_metag = false;
	$wgMultiEditTag = (empty($wgMultiEditTag)) ? "useMultiEdit" : $wgMultiEditTag;
	$multiedit_tag = '<!---'.$wgMultiEditTag.'--->';

	#--- Add messages
	require_once ( dirname( __FILE__ ) . '/MultiEdit.i18n.php' );
	foreach( $wgMultiEditMessages as $key => $value ) 
	{
		$wgMessageCache->addMessages( $wgMultiEditMessages[$key], $key );
	}

	foreach( $wgMultiEditMessages as $key => $value ) {
	    $wgMessageCache->addMessages( $wgMultiEditMessages[$key], $key );
	}

	$editmode = $wgRequest->getText( 'editmode' );
	#---
	if ( !$wgMultiEditEnable || $editmode == 'nomulti' ) { 	
		if ('nomulti' == $editmode) { // if nomulti, propagate this too (for example with Preview...)
			$wgOut->addHTML ('<input type="hidden" name="editmode" value="' . $editmode . '"/>') ;
		}
		return false;
	}
	#---

	if (empty($textbox1))
	{
		$textbox1 = htmlspecialchars($wgRequest->getText('nomulti_wpTextbox1'));
	}
	#---
	
	if ( empty($wgMultiEditTag) || (strpos($textbox1, htmlspecialchars($multiedit_tag)) === false) ) 
	{
		return false ;
	} 
	else 
	{
		$textbox1 = str_replace(htmlspecialchars($multiedit_tag), "", $textbox1);
		$is_used_metag = true;		
	}

/*	$editor = new CreatePageMultiEditor ("blank") ;
	$editor->GenerateForm ($textbox1) ;*/

/*	$me = CreateMultiPage::multiEditParse (10,10,'?', $textbox1);
	return $me;*/

	#---

/*	preg_match_all (MULTIEDIT_TEMPLATE_INFOBOX_FORMAT, $textbox1, $infoboxes) ;		
	$infobox = "";
	if (is_array ($infoboxes) && is_array($infoboxes[0]) && !empty($infoboxes[0][0])) 
	{		
		// and remove them later...
		
		//error_log("textbox1 = ".print_r($textbox1, true));
		$textbox1 = preg_replace (MULTIEDIT_TEMPLATE_INFOBOX_FORMAT, "", $textbox1) ;
		//error_log("textbox1_2 = ".print_r($textbox1, true));
		
		//and we'll just add them here if they exist        	
		//currently we support only one per createplate, which is a good thing I say
		error_log(print_r($infoboxes[0][0], true));
		$to_parametrize = $infoboxes[0][0] ;

		$to_parametrize = preg_replace (MULTIEDIT_TEMPLATE_CLOSING, "", $to_parametrize) ;

		$inf_pars = preg_split ("/\|/", $to_parametrize, -1) ;
		array_shift ($inf_pars) ;

		// Notice:  Undefined variable: num in CreateMultiPage.php on line 103
		//$num = 0;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars(
				array(
					'num' => $num,
					'me_hide' => wfMsg('me_hide'),
					'infobox_legend' => wfMsg ('createpage_infobox_legend') ,
					'infoboxes' => $infoboxes,
					'inf_pars' => $inf_pars,
					 )
				);
#---
		$infobox = '<tr><td colspan="2"><b>'.$oTmpl->execute("infobox").'</b></td></tr>';
		//$wgOut->addHTML('infobox');
	}*/

	$sections = preg_split( "/\n==[^=]/s", $textbox1, -1, PREG_SPLIT_OFFSET_CAPTURE );
	$run = ( count( $sections ) > 1 ? true : false );

	$script  = "<script type='text/javascript'><!--\n";
	if ( $run ) {
	    $script .= "document.getElementById('wpTableMultiEdit').style.display = '';\n";
	    $script .= "document.editform.wpTextbox1.style.display = 'none';\n";
	}

	// TODO: generally we try to avoid tables. change it to something else, css-based.
	$wgOut->addScript('<link rel="stylesheet" type="text/css" href="/extensions/wikia/MultiEdit/css/multiedit.css?'.$wgStyleVersion.'" />'."\n");
	$wgOut->addHTML( '<table border="0" cellpadding="5" style="display:none;" id="wpTableMultiEdit" name="wpTableMultiEdit">' );
	$wgOut->addHTML( '<tr><td colspan="2">' . wfMsg('me_tip') . '</td></tr>' );
	$wgOut->addHTML( '<tr><td width="100%"></td><td align="right" nowrap><div><a href="/index.php?title='.$wgTitle->getFullText().'&action=edit&editmode=nomulti">' . wfMsg('me_edit_normal') . '</a></div></td></tr>' );
	$boxes = '';
	$num = 0;
	if ($is_used_metag) 
	{
		$boxes = "'".addslashes($multiedit_tag)."'";
		$num = 1;
	}

	if (!empty($infobox))
	{
		$wgOut->addHTML($infobox);
	}
	/*
	 * parse sections
	 */	
	foreach ( $sections as $section ) 
	{
		#--- empty section 
		if ( ($section[1] == 0) && (empty($section[0])) ) continue;
		#---
	    // add last character truncated by preg_split()
	    $add = '';
	    if ($section[1] > 0)
	    {
	    	$add = substr( $textbox1, $section[1] - 1, 1 );
		}

	    $text = ( ($num && (!empty($add))) ? '==' : '' ) . $add . $section[0];
	    preg_match( '!==(.*?)==!s', $text, $name );
	
	    $cut = (!empty($name)) ? $name[0] : "";
	    $name = (!empty($name)) ? trim( $name[1] ) : "";
	    
	    if (strlen($cut) > 0) {
	    	$text = substr( $text, strlen( $cut ) + 1 );  // strip section name
		}
	    $text = trim( $text );  // strip unneeded newlines
	    $linenum = count( explode( "\n", $text ) ) + 1;
	    $linenum = ($linenum > MULTI_EDIT_TEXTAREA_LINE_NUM) ? MULTI_EDIT_TEXTAREA_LINE_NUM : $linenum;

	    /********************************************
	     * 
	     *  <(descr|title)="..."> tag support
	     * 
	     */
	    $javascript_tags = "\\n";
	    $title_for_html = $descr_for_html = '';
	    $descr_text = $title_text = "";
	    #----
	    $me_tags_regex = '/&lt;!---(.*?)\s*=\s*(&quot;|\')*(.*?)(&quot;|\')*---&gt;/is';
	    preg_match_all( $me_tags_regex, $text, $me_tags );
		#----    	
    	if ( isset( $me_tags ) && (!empty( $me_tags[1] )) )
    	{
    		foreach ($me_tags[1] as $id => $_tag)
    		{
    			$brt = $me_tags[2][$id];
    			$correct_brt = ($brt == "&quot;") ? "\"" : $brt;
    			if (in_array($_tag, array('title', 'descr')))
    			{
    				switch ($_tag)
    				{
    					case "title": 
    					{
    						if (empty($title_text))
    						{
    							$title_text = $me_tags[3][$id];
    							$text = str_replace( "&lt;!---{$_tag}={$brt}{$title_text}{$brt}---&gt;", "", $text );
    							$text = trim( $text );  // strip unneeded newlines
    							$title_for_html = "<b>$title_text</b>";
    							$javascript_tags .= str_replace( "\n", "\\n", "<!---{$_tag}={$correct_brt}{$title_text}{$correct_brt}--->\n" );
							}
							break;
						}
    					case "descr":
    					{
    						if (empty($descr_text))
    						{
    							$descr_text = $me_tags[3][$id];
    							$text = str_replace( "&lt;!---{$_tag}={$brt}{$descr_text}{$brt}---&gt;", "", $text );
    							$text = trim( $text );  // strip unneeded newlines
    							$descr_for_html = "<small>$descr_text</small>";
    							$javascript_tags .= str_replace( "\n", "\\n", "<!---{$_tag}={$correct_brt}{$descr_text}{$correct_brt}--->\n" );
							}
							break;
						}
					}
				}
			}    			
		}
		#---	
	    if ('' != $title_for_html) {
		    $wgOut->addHTML( '<tr><td colspan="2"><b>'.$title_for_html.'</b><br />'.$descr_for_html );
	    } else {
		    $wgOut->addHTML( '<tr><td colspan="2"><b>'.$name.'</b><br />'.$descr_for_html );

	    }

		/**********************************************
		 * 
		 * other tags - lbl, categories, language,
		 * 
		 */
	    $optname = ( empty($name) ? "" : '==' . $name . '==' );

	    preg_match( '/&lt;!---(.*?)---&gt;/is', $text, $other_tags );

		$specialTag = ( isset( $other_tags ) && (!empty( $other_tags[1] )) ) ? $other_tags[1] : "generic";
		switch ($specialTag)
		{
			case "lbl": // <!---lbl---> tag support
			{
				$text_html = str_replace( $other_tags[0], "", $text );  // strip <!---lbl---> tag
				#---
				$text_html = trim( $text_html );  // strip unneeded newlines

				$text_javascript = str_replace( "\n", "\\n", $text );
				$text_javascript = str_replace( $other_tags[0], "<!---lbl--->", $text_javascript );

				// this section type is non-editable, so we just rebuild its contents in javascript code
				$wgOut->addHTML( $text_html );
				$boxes .= ( $num ? ' + ' : '' ) . "'{$optname}{$javascript_tags}{$text_javascript}\\n'";
				#---
				break;
			}
			case "language": // <!---language---> tag support
			{
				preg_match( '/&lt;!---Chosen language code: &quot;(.*?)&quot;---&gt;$/', $text, $langsel );
				#---
				$options = '<option value="">';
				foreach ( $wgLanguageNames as $langcode => $langname ) 
				{
					$selval = ( $langsel[1] == $langcode ? 'selected' : '' );
					$options .= "<option $selval value=\"$langcode\">$langname\n";
				}
				
				$wgOut->addHTML( "<select name=\"wpLanguage{$num}\" id=\"wpLanguage{$num}\">{$options}</select>" );
				#---
				$boxes .= ( $num ? ' + ' : '' ) . "'{$optname}{$javascript_tags}<!---language---><!---Chosen language code: \"' + document.editform.wpLanguage{$num}.options[document.editform.wpLanguage{$num}.selectedIndex].value + '\"--->\\n'";
				#---
				break;
			}
			case "categories": // <!---categories---> tag support
			{
				preg_match_all( '/\[\[Category:(.*?)\]\]/', $text, $categories, PREG_SET_ORDER );
				$text_prep = ''; $xnum = 0;
				#---
				foreach ( $categories as $category ) 
				{
					$text_prep .= ( $xnum ? ',' : '' ) . trim( $category[1] );
					$xnum++;
				}
				#---
				$wgOut->addHTML( "<div id=\"createpage_cloud_section{$num}\" style=\"border: 1px solid lightgray; padding: 15px 15px 15px 15px\">\n" );
				$cloud = new TagCloud();
				$xnum = 0;
				foreach ( $cloud->tags as $xname => $xtag ) 
				{
					$wgOut->addHTML( <<<END
<span id="tag{$num}-{$xnum}" style="font-size:{$xtag['size']}pt">
<a href="#" id="cloud{$num}_{$xnum}" onclick="cloudAdd{$num}('{$xname}', {$xnum}); return false;">{$xname}</a>
</span>
END
					);
					$xnum++;
				}
				$wgOut->addHTML( "</div>\n" );

				#---
				$script .= "function cloudAdd{$num}(category, num) {\n";
				$script .= "  if (document.editform.wpTextboxes{$num}.value == '') {\n";
				$script .= "    document.editform.wpTextboxes{$num}.value += category;\n";
				$script .= "  } else {\n";
				$script .= "    document.editform.wpTextboxes{$num}.value += ',' + category;\n";
				$script .= "  }\n";
				$script .= "  this_button = document.getElementById('cloud{$num}_' + num);\n";
				$script .= "  this_button.onclick = function() { eval(\"cloudRemove{$num}('\" + category + \"', \" + num + \")\"); return false };\n";
				$script .= "  this_button.style[\"color\"] = \"#419636\";\n";
				$script .= "  return false;\n};\n";
				
				$script .= "function cloudRemove{$num}(category, num) {\n";
				$script .= "  category_text = document.editform.wpTextboxes{$num}.value;\n";
				$script .= "  this_pos = category_text.indexOf(category);\n";
				$script .= "  if (this_pos != -1) {\n";
				$script .= "    category_text = category_text.substr(0, this_pos-1) + category_text.substr(this_pos + category.length);\n";
				$script .= "    document.editform.wpTextboxes{$num}.value = category_text;\n";
				$script .= "  }\n";
				$script .= "  this_button = document.getElementById('cloud{$num}_' + num);\n";
				$script .= "  this_button.onclick = function() { eval(\"cloudAdd{$num}('\" + category + \"', \" + num + \")\"); return false };\n";
				$script .= "  this_button.style[\"color\"] = \"\";\n";
				$script .= "  return false;\n};\n";

				$script .= "function cloudBuild{$num}(o) {\n";
				$script .= "  var categories = o.value;\n";
				$script .= "  new_text = '';\n";
				$script .= "  categories = categories.split(\",\");\n";
				$script .= "  for (i=0; i < categories.length; i++) {\n";
				$script .= "    if (categories[i]!='') {\n";
				$script .= "      new_text += '[[Category:' + categories[i] + ']]';\n";
				$script .= "    }\n";
				$script .= "  }\n";
				$script .= "  return new_text;\n};\n";

				$wgOut->addHTML( <<<END
<textarea tabindex='{$num}' accesskey="," name="wpTextboxes{$num}" id="wpTextboxes{$num}" rows='3' cols='{$cols}'{$ew}>
{$text_prep}</textarea>
END
				);
				$boxes .= ( $num ? ' + ' : '' ) . "'{$optname}{$javascript_tags}<!---categories--->' + cloudBuild{$num}(document.editform.wpTextboxes{$num}) + '\\n'";
				#---
				break;
			} 
			default: // generic textarea
			{
				$temp = str_replace( "\\n", "\n", $optname ); //.$javascript_tags
				$wgOut->addHTML( <<<END
<textarea tabindex='{$num}' accesskey="," name="wpTextboxes{$num}" id="wpTextboxes{$num}" rows='{$linenum}' cols='{$cols}'{$ew}>
{$temp}\n{$text}
</textarea>
END
				);
				$boxes .= ( $num ? ' + ' : '' ) . "document.editform.wpTextboxes{$num}.value";  // '{$optname}{$javascript_tags}' + 
				#---
				if (!empty($javascript_tags))
				{
					$num++;
					$js_tags = str_replace( "\\n", "\n", $javascript_tags ); //.$javascript_tags
					$wgOut->addHTML( <<<END
<textarea tabindex='{$num}' accesskey="," name="wpTextboxes{$num}" id="wpTextboxes{$num}" rows='{$linenum}' cols='{$cols}'{$ew} style='display:none;'>
{$js_tags}
</textarea>
END
					);
					$boxes .= ( $num ? ' + ' : '' ) . "document.editform.wpTextboxes{$num}.value";  // '{$optname}{$javascript_tags}' + 
				}
			}
		}
		#----
		$wgOut->addHTML( "</td></tr>" );
		$num++;
	}
	#---
	$wgOut->addHTML( '</table>' );
	#---
	$script .= "function multiSave() {\n";
	if ( $run ) 
	{
		$script .= "  document.editform.wpTextbox1.value = $boxes;\n";
	}
	$script .= "  return true;\n};\n";
	$script .= "--></script>";
	
	$script .= "\n<script type='text/javascript'>\n";
	$script .= "initMultiEdit = function() { eval('multiSave();'); return true; } \n";
	$script .= "YAHOO.util.Event.addListener(\"wpSave\", \"click\", initMultiEdit);";
	$script .= "YAHOO.util.Event.addListener(\"wpDiff\", \"click\", initMultiEdit);";
	$script .= "YAHOO.util.Event.addListener(\"wpPreview\", \"click\", initMultiEdit);";
	$script .= "</script>";
	
	$wgOut->addHTML( $script );
	return true;
}

// this function just disables the edit section links
function wfMultiEditSection($text) 
{
	global $wgMultiEditEnable, $wgMultiEditTag;
	$multiedit_tag = '<!---'.$wgMultiEditTag.'--->';

	if( $wgMultiEditEnable && strpos($text, $multiedit_tag) !== false ) {
		return false;
	}
	return true;
}

function wfMultiEditShowLink($page) 
{
	global $wgOut, $wgRequest, $wgMultiEditEnable, $wgTitle, $wgMessageCache, $wgMultiEditMessages, $wgMultiEditTag;

	$wgMultiEditTag = (empty($wgMultiEditTag)) ? "useMultiEdit" : $wgMultiEditTag;
	$multiedit_tag = '<!---'.$wgMultiEditTag.'--->';

	$editmode = $wgRequest->getText( 'editmode' );

	#--- Add messages
	require_once ( dirname( __FILE__ ) . '/MultiEdit.i18n.php' );
	foreach( $wgMultiEditMessages as $key => $value ) 
	{
		$wgMessageCache->addMessages( $wgMultiEditMessages[$key], $key );
	}

	#--- show link to multi-edit 
	if ( $wgMultiEditEnable && $editmode == 'nomulti' )
	{
		if ( strpos($page->textbox1, $multiedit_tag) !== false) 
		{
			if ($wgRequest->getText ("createpage") != "true" ) {
				$wgOut->addHTML( '<div>' );
				$wgOut->addHTML( '<table border="0" cellpadding="5">' );
				$wgOut->addHTML( '<tr><td width="100%"></td><td align="right" nowrap><div>' );
				$wgOut->addHTML( '<form name="useMultiEditForm" id="useMultiEditForm" action="/index.php" method="POST">' );
				$wgOut->addHTML( '<input type="hidden" name="title" value="'.$wgTitle->getFullText().'">');
				$wgOut->addHTML( '<input type="hidden" name="action" value="edit">');
				$wgOut->addHTML( '<textarea name="nomulti_wpTextbox1" id="nomulti_wpTextbox1" style="display: none;" cols=0 rows=0></textarea>');
				$wgOut->addHTML( '<a href="javascript:void(0);" onClick="document.getElementById(\'nomulti_wpTextbox1\').value=document.getElementById(\'wpTextbox1\').value; document.getElementById(\'useMultiEditForm\').submit();">' . wfMsg('me_edit_muli_editor') . '</a>' );
				$wgOut->addHTML( '</form>' );
				$wgOut->addHTML( '</div></td></tr>' );
				$wgOut->addHTML( '</table></div>' );			
			}
		}
	}

	return true;
}
