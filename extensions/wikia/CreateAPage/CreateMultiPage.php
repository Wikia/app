<?php
if (!defined('MEDIAWIKI')) die('...');
/**
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Piotr Molski <moli@wikia.com>, Bartek Łapiński <bartek@wikia.com>
 * @copyright Copyright (C) 2007 Piotr Molski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
LocalSettings.php:
+ $wgMultiCreatePageEnable = true;
+ require_once( "$IP/extensions/wikia/MultiEdit/CreateMultiPage.php" );
 *
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'Create Multi Page',
	'description' => 'using multi-edit to create page',
	'author' => 'Piotr Molski, Bartek Łapiński'
);

define ("SECTION_PARSE", '/\n==[^=]/s');
define ("SPECIAL_TAG_FORMAT", '<!---%s--->');
define ("ADDITIONAL_TAG_PARSE", '/\<!---(.*?)\s*=\s*(&quot;|\'|")*(.*?)(&quot;|\'|")*---\>/is');
define ("SIMPLE_TAG_PARSE", '/\<!---(.*?)---\>/is');
define ("CATEGORY_TAG_PARSE", '/\[\[Category:(.*?)\]\]/');
define ("CATEGORY_TAG_SPECIFIC", '/\<!---categories---\>/is') ;
define ("IMAGEUPLOAD_TAG_SPECIFIC", '/\<!---imageupload---\>/is') ;
define ("INFOBOX_SEPARATOR", '/\<!---separator---\>/is');
define ("ISBLANK_TAG_SPECIFIC", '<!---blanktemplate--->') ;
define ("TEMPLATE_INFOBOX_FORMAT", '/\{\{[^\{\}]*Infobox.*\}\}/is') ;
define ("TEMPLATE_OPENING", '/\{\{[^\{\}]*Infobox[^\|]*/i') ;
define ("TEMPLATE_CLOSING", '/\}\}/') ;

global $wgMultiEditPageTags, $wgMultiEditPageSimpleTags;
$wgMultiEditPageTags = array('title', 'descr', 'category');
$wgMultiEditPageSimpleTags = array('lbl', 'categories', 'pagetitle', 'imageupload');

//restore what we temporarily encoded
function wfCreatePageUnescapeKnownMarkupTags (&$text) {
	$text = str_replace ('<!---pipe--->', '|', $text) ;
}

class CreateMultiPage
{
	function __construct() {
		//
	}

	static public function unescapeBlankMarker ($text) {
		$text = str_replace ("\n<!---blanktemplate--->\n", '', $text) ;
		$text = str_replace ('<!---imageupload--->', '', $text) ;
		return $text ;
	}

	static public function getToolArray () {
                global $wgStylePath, $wgContLang, $wgJsMimeType, $wgMessageCache;
                $toolarray = array(
                        array(  'image' => 'button_bold.png',
                                'id'    => 'mw-editbutton-bold',
                                'open'  => '\\\'\\\'\\\'',
                                'close' => '\\\'\\\'\\\'',
                                'sample'=> wfMsg('bold_sample'),
                                'tip'   => wfMsg('bold_tip'),
                                'key'   => 'B'
                        ),
                        array(  'image' => 'button_italic.png',
                                'id'    => 'mw-editbutton-italic',
                                'open'  => '\\\'\\\'',
                                'close' => '\\\'\\\'',
                                'sample'=> wfMsg('italic_sample'),
                                'tip'   => wfMsg('italic_tip'),
                                'key'   => 'I'
                        ),
                        array(  'image' => 'button_link.png',
                                'id'    => 'mw-editbutton-link',
                                'open'  => '[[',
                                'close' => ']]',
                                'sample'=> wfMsg('link_sample'),
                                'tip'   => wfMsg('link_tip'),
                                'key'   => 'L'
                        ),
                        array(  'image' => 'button_extlink.png',
                                'id'    => 'mw-editbutton-extlink',
                                'open'  => '[',
                                'close' => ']',
                                'sample'=> wfMsg('extlink_sample'),
                                'tip'   => wfMsg('extlink_tip'),
                                'key'   => 'X'
                        ),
                        array(  'image' => 'button_headline.png',
                                'id'    => 'mw-editbutton-headline',
                                'open'  => "\\n=== ",
                                'close' => " ===\\n",
                                'sample'=> wfMsg('headline_sample'),
                                'tip'   => wfMsg('headline_tip_3'),
                                'key'   => 'H'
                        ),
                        array(  'image' => 'button_image.png',
                                'id'    => 'mw-editbutton-image',
                                'open'  => '[['.$wgContLang->getNsText(NS_IMAGE).":",
                                'close' => ']]',
                                'sample'=> wfMsg('image_sample'),
                                'tip'   => wfMsg('image_tip'),
                                'key'   => 'D'
                        ),
                        array(  'image' => 'button_media.png',
                                'id'    => 'mw-editbutton-media',
                                'open'  => '[['.$wgContLang->getNsText(NS_MEDIA).':',
                                'close' => ']]',
                                'sample'=> wfMsg('media_sample'),
                                'tip'   => wfMsg('media_tip'),
                                'key'   => 'M'
                        ),
                        array(  'image' => 'button_math.png',
                                'id'    => 'mw-editbutton-math',
                                'open'  => "<math>",
                                'close' => "<\\/math>",
                                'sample'=> wfMsg('math_sample'),
                                'tip'   => wfMsg('math_tip'),
                                'key'   => 'C'
                        ),
                        array(  'image' => 'button_nowiki.png',
                                'id'    => 'mw-editbutton-nowiki',
                                'open'  => "<nowiki>",
                                'close' => "<\\/nowiki>",
                                'sample'=> wfMsg('nowiki_sample'),
                                'tip'   => wfMsg('nowiki_tip'),
                                'key'   => 'N'
                        ),
                        array(  'image' => 'button_sig.png',
                                'id'    => 'mw-editbutton-signature',
                                'open'  => '--~~~~',
                                'close' => '',
                                'sample'=> '',
                                'tip'   => wfMsg('sig_tip'),
                                'key'   => 'Y'
                        ),
                        array(  'image' => 'button_hr.png',
                                'id'    => 'mw-editbutton-hr',
                                'open'  => "\\n----\\n",
                                'close' => '',
                                'sample'=> '',
                                'tip'   => wfMsg('hr_tip'),
                                'key'   => 'R'
                        )
		) ;

		wfRunHooks( 'ToolbarGenerate', array( &$toolarray ) );
		return $toolarray ;
	}

	//modified a bit standard editToolbar function from EditPage class
	static public function getMultiEditToolbar ($toolbar_id) {
                global $wgStylePath, $wgContLang, $wgJsMimeType, $wgMessageCache;

 		$toolarray = CreateMultiPage::getToolArray () ;       	
		//multiple toolbars...
                $toolbar = "<div id='toolbar" . $toolbar_id . "' style='display: none'>\n";
                $toolbar.="<script type='$wgJsMimeType'>\n/*<![CDATA[*/\n";
		$toolbar .= "YWC.multiEditTextboxes [YWC.multiEditTextboxes.length] = $toolbar_id ;\n" ;
		$toolbar .= "YWC.multiEditButtons [$toolbar_id] = [] ;\n" ;
		$toolbar .= "YWC.multiEditCustomButtons [$toolbar_id] = [] ;\n" ;
		$toolbar .= "YE.addListener ('wpTextboxes' + $toolbar_id, 'focus', YWC.showThisBox, {'toolbarId' : $toolbar_id }) ; \n" ;		
                $toolbar.="/*]]>*/\n</script>";

                $toolbar.="\n</div>";
                return $toolbar;
	}	


	static public function multiEditParse($rows, $cols, $ew, $sourceText) 
	{
		global $wgTitle;
		global $wgMultiEditTag;
		global $wgMultiEditPageSimpleTags, $wgMultiEditPageTags;

		$me_content = '' ;
		$found_categories = array () ;
		
		$is_used_metag = false;
		$is_used_category_cloud = false ;
		$wgMultiEditTag = (empty($wgMultiEditTag)) ? "useMultiEdit" : $wgMultiEditTag;
		$multiedit_tag = '<!---'.$wgMultiEditTag.'--->';

		#--- is tag set?
		if ( empty($wgMultiEditTag) || (strpos($sourceText, $multiedit_tag) === false) ) 
		{    
			if (strpos ($sourceText, ISBLANK_TAG_SPECIFIC) !== true) {
				$sourceText = str_replace (ISBLANK_TAG_SPECIFIC . "\n", "", $sourceText) ;
				$sourceText = str_replace (ISBLANK_TAG_SPECIFIC, "", $sourceText) ;				

				//fire off a special one textarea template
				$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
				$toolbar_text = CreateMultiPage::getMultiEditToolbar (0) ;
				$oTmpl->set_vars(
						array(
							'box' => $sourceText ,
							'toolbar' => $toolbar_text ,
						     )
						);
				$me_content .= $oTmpl->execute("bigarea");			

				$cloud = new TagCloud();
				$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
				$oTmpl->set_vars(
						array(
							'num' => 0,
							'cloud' => $cloud,
							'cols' => $cols,
							'ew' => $ew,
							'text_category' => '' ,
							'array_category' => array (),
							'me_upload' => wfMsg('me_upload')
						     )
						);
				$me_content .= $oTmpl->execute("categorypage") ;
				return $me_content ;
			}  else {			
			return false;
		     }
		} 
		else 
		{
			$sourceText = str_replace($multiedit_tag, "", $sourceText);
			$is_used_metag = true;		
		}

		$category_tags = null ;
		preg_match_all (CATEGORY_TAG_SPECIFIC, $sourceText, $category_tags) ;
		if (is_array ($category_tags)) {
			$is_used_category_cloud = true ;
			$sourceText = preg_replace (CATEGORY_TAG_SPECIFIC, "", $sourceText) ;
		}
		
        	// get infoboxes out...
		preg_match_all (TEMPLATE_INFOBOX_FORMAT, $sourceText, $infoboxes, PREG_OFFSET_CAPTURE) ;		

		//new functions to exclude any additional '}}'s from match
		if (is_array ($infoboxes) && is_array($infoboxes[0]) && !empty($infoboxes[0][0])) {		
			$to_parametrize = $infoboxes[0][0] ;
			$infobox_start = $to_parametrize [1] ;
			//take first "}}" here - this should be infoboxes' end 
			$infobox_end = strpos ($sourceText, "}}") ;
			$to_parametrize = substr ($sourceText, $infobox_start, $infobox_end - $infobox_start + 2) ;
			$sourceText = str_replace ($to_parametrize, "", $sourceText) ;

			$to_parametrize = preg_replace (TEMPLATE_CLOSING, "", $to_parametrize) ;
			$inf_pars = preg_split ("/\|/", $to_parametrize, -1) ;
			array_shift ($inf_pars) ;
			array_walk ($inf_pars, 'wfCreatePageUnescapeKnownMarkupTags') ;

			$num = 0;
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars(
					array(
						'num' => $num,
						'me_hide' => wfMsg('me_hide'),
						'infobox_legend' => wfMsg ('createpage_infobox_legend') ,
						'infoboxes' => $to_parametrize,
						'inf_pars' => $inf_pars,
					     )
					);
#---
			$me_content .= $oTmpl->execute("infobox");
		}
		
		#--- check sections exist
		$sections = preg_split( SECTION_PARSE, $sourceText, -1, PREG_SPLIT_OFFSET_CAPTURE );
		$is_section = ( count( $sections ) > 1 ? true : false );

		$boxes = array(); $num = 0; $loop = 0;
		if ($is_used_metag) 
		{
			$boxes[] = array("type" => "text", "value" => addslashes($multiedit_tag), "display" => 0);
			$num = 1;
			$loop++;
		}

		$all_image_num = 0 ;
					
		/*
		 * parse sections
		 */	
		foreach ( $sections as $section ) 
		{
			#--- empty section 
			$add = "";
			if ( ($section[1] == 0) && (empty($section[0])) ) 
			{
				continue;
			}
			elseif ( intval($section[1]) > 0 ) //add last character truncated by preg_split()
			{
				$add = substr( $sourceText, $section[1] - 1, 1 );
			}

			#--- get section text
			$text = ( ($num && (!empty($add))) ? '==' : '' ) . $add . $section[0];

			#---
			preg_match( '!==(.*?)==!s', $text, $name );
			#---		
			$section_name = $section_wout_tags = "";
			#--- section name
			if (!empty($name))
			{
				$section_name = $name[0];
				$section_wout_tags = trim( $name[1] );
			}
			if (!empty($section_name))
			{
				$boxes[] = array("type" => "", "value" => "<b>".$section_wout_tags."</b>", "display" => 1);
				$boxes[] = array("type" => "text", "value" => addslashes($section_name), "display" => 0);
			} else {
				$boxes[] = array("type" => "", "value" => "<b>".wfMsg ('createpage_top_of_page') ."</b>", "display" => 1);
			}
			
			#--- text without section name
			if (strlen($section_name) > 0) {
				$text = substr( $text, strlen( $section_name ) + 1 );  // strip section name
			}
			$text = trim( $text );  // strip unneeded newlines

			/********************************************
			 * 
			 *  <(descr|title|pagetitle)="..."> tag support
			 * 
			 */
			$main_tags = ""; $special_tags = array();
			#---
			preg_match_all( ADDITIONAL_TAG_PARSE, $text, $me_tags );

			if ( isset( $me_tags ) && (!empty( $me_tags[1] )) )
			{
				foreach ($me_tags[1] as $id => $_tag)
				{
					$brt = $me_tags[2][$id];
					$correct_brt = ($brt == "&quot;") ? "\"" : $brt;
					if (in_array($_tag, $wgMultiEditPageTags))
					{
						switch ($_tag)
						{
							case "title": 
							case "descr":
							case "category" :
							{
								if (empty($special_tags[$_tag]) || ($_tag == 'category'))
								{
									$special_tags[$_tag] = $me_tags[3][$id];
									if ($_tag != 'category') {				
										$format_tag_text = ($_tag == 'title') ?  "<b><small>%s</small></b>" : "<small>%s</small>";
									} else {
										$format_tag_text = "%s" ;
									}
									if (!empty($section_name) && ($_tag == 'title'))
									{
										$format_tag_text = "<br />".$format_tag_text;
									}
									if ($_tag != 'category') {
#--- remove special tags
										$text = str_replace( "<!---{$_tag}={$brt}".$special_tags[$_tag]."{$brt}--->", "", $text );
										$text = trim( $text );  // strip unneeded newlines
#--- add to display
										$boxes[] = array("type" => "", "value" => sprintf($format_tag_text, $special_tags[$_tag]), "display" => 1);
										$main_tags .= "<!---{$_tag}={$correct_brt}".$special_tags[$_tag]."{$correct_brt}--->\n";
									} else {
										$text = str_replace( "<!---{$_tag}={$brt}".$special_tags[$_tag]."{$brt}--->", "[[Category:" . sprintf ($format_tag_text, $special_tags[$_tag]) . "]]", $text );
									}
								}
								break;
							}
						}
					}
				}    			
			}

			//parse given categories into an array...
			preg_match_all( CATEGORY_TAG_PARSE, $text, $categories, PREG_SET_ORDER );				
			//and dispose of them, since they will be in the cloud anyway
			$text = preg_replace (CATEGORY_TAG_PARSE, "", $text) ;				
			if (is_array ($categories)) {
				$found_categories = $found_categories + $categories ;					
			}			
                        
			/*********************************************************
			 * 
			 *  Display section name and additional tags as hidden text
			 * 
			 */
			if ( !empty($main_tags) )
			{
				$boxes[] = array("type" => "textarea", "value" => $main_tags, "toolbar" => '', "display" => 0);
			}

			/**********************************************
			 * 
			 * other tags - lbl, categories, language,
			 * 
			 */
			preg_match( SIMPLE_TAG_PARSE, $text, $other_tags );
			$specialTag = ( isset( $other_tags ) && (!empty( $other_tags[1] )) ) ? $other_tags[1] : "generic";

			if ( (!empty($specialTag)) && (!empty($wgMultiEditPageSimpleTags)) && (in_array($specialTag, $wgMultiEditPageSimpleTags)) )
			{
				$boxes[] = array("type" => "text", "value" => sprintf(SPECIAL_TAG_FORMAT, $specialTag), "display" => 0);
				switch ($specialTag)
				{
					case "lbl": // <!---lbl---> tag support
					{
						#---
						$text_html = str_replace( $other_tags[0], "", $text );  // strip <!---lbl---> tag
						$text_html = trim( $text_html );  // strip unneeded newlines
						// this section type is non-editable, so we just rebuild its contents in javascript code
						$boxes[] = array("type" => "textarea", "value" => $text_html, "toolbar" => '',  "display" => 0);
						$boxes[] = array("type" => "", "value" => $text_html, "display" => 1);
						#---
						break;
					}
					case "pagetitle" : // <!---pagetitle---> tag support
					{
						#---
						$text_html = str_replace( $other_tags[0], "", $text );  // strip <!---lbl---> tag
						$text_html = trim( $text_html );  // strip unneeded newlines
						// this section type is non-editable, so we just rebuild its contents in javascript code
						$boxes[] = array("type" => "text", "value" => "{$text_html}", "display" => 1);
						#---
						break;
					}
					case "imageupload" : //<!---imageupload---> tag support
					{
						// do a match here, and for each do the thing, yeah
                        			preg_match_all (IMAGEUPLOAD_TAG_SPECIFIC, $text, $image_tags) ;						

						// one we had already
						$cur_img_count = count ($image_tags) - 1 ;											
						foreach ($image_tags[0] as $image_tag) {								
							if ($cur_img_count > 0) {
								$boxes[] = array("type" => "text", "value" => sprintf(SPECIAL_TAG_FORMAT, "imageupload"), "display" => 0);	
							}
							$cur_img_count++ ;						
                                                }

						$text = str_replace("<!---imageupload--->", "", $text);

						// get the toolbar
						$toolbarid = count ($boxes) ;
						$toolbar_text = CreateMultiPage::getMultiEditToolbar ($toolbarid) ;

						$boxes[] = array(
							"type" => "textarea", 
							"value" => $text, 
							"toolbar" => $toolbar_text ,
							"display" => 1
						) ;
						$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
						$oTmpl->set_vars(
							array( 'me_upload' => wfMsg('me_upload') )
						);

						#---
						$current = count($boxes) - count ($image_tags[0]) - 1  ;						
						$add_img_num = 0 ;
						foreach ($image_tags[0] as $image_tag) {															     
							$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
							$oTmpl->set_vars(
								array(
									'imagenum' => $all_image_num,
									'me_upload' => wfMsg('me_upload'),
									'target_tag' => $current + $add_img_num
								)
							);
							$image_text = $oTmpl->execute("editimage-section");
							$boxes[] = array(
								"type" => "image" ,
								"value" => $image_text ,
								"display" => 1
							) ;
							$add_img_num++ ;
							$all_image_num++ ;
						}
					}
				}
			}
			elseif ($specialTag == "generic") // generic textarea
			{
				// get the toolbar
				$toolbarid = count ($boxes) ;
				$toolbar_text = CreateMultiPage::getMultiEditToolbar ($toolbarid) ;

				$boxes[] = array(
						"type" => "textarea", 
						"value" => $text, 
						"toolbar" => $toolbar_text ,
						"display" => 1
						) ;
			}
			
			#----
			$boxes[] = array("type" => "", "value" => "<br/><!--end of section-->", "display" => 1);
			$num++;
		}
		#---
		
		#--- 
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars(
			array(
				'boxes' => $boxes,
				'cols' => $cols,
				'rows' => $rows,
				'ew' => $ew,
				'is_section' => $is_section,
				'title' => $wgTitle,
			)
		);
		#---
		$me_content .= $oTmpl->execute("editpage");
		#---

		if ($is_used_category_cloud) {
			//categories are generated here... well, except for Blank
			// init some class here to get categories form to display
			$text_category = ''; $xnum = 0;
			$array_category = array();
#---
			foreach ( $found_categories as $category )
			{
				$cat_text = trim( $category[1] );
				$text_category .= ( $xnum ? ',' : '' ) . $cat_text;
				$array_category[$cat_text] = 1;
				$xnum++;
			}
#----
			$cloud = new TagCloud();
#---
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars(
					array(
						'num' => $num,
						'cloud' => $cloud,
						'cols' => $cols,
						'ew' => $ew,
						'text_category' => $text_category,
						'array_category' => $array_category,
						'me_upload' => wfMsg('me_upload')
					     )
					);
#---
			$me_content .= $oTmpl->execute("categorypage") ;
		}

		return $me_content ;
	}
}

?>
