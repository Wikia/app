<?php

if (!defined('MEDIAWIKI')) die();
/**
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Bartek Łapiński <bartek@wikia.com>
 * @copyright Copyright (C) 2007 Bartek Łapiński, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
**/

//all editor-related functions will go there
abstract class CreatePageEditor {
	var $mTemplate ;

	function CreatePageEditor ($template) {
		$this->mTemplate = $template ;
	}

	abstract public function GenerateForm () ;
	abstract public function GlueArticle () ;
}


//wraps up special multi editor class
class CreatePageMultiEditor extends CreatePageEditor {	
	var $mRedLinked, $mInitial, $mPreviewed;	
	function CreatePageEditor ($template, $redlinked = false, $initial = false, $previewed = false) {
		$this->mTemplate = $template ;
		$this->mRedLinked = $redlinked ;		
		$this->mInitial = $initial ;
		$this->mPreviewed = $previewed;
	}

	function GenerateForm ($content = false) {
		global $wgOut, $wgUser, $wgRequest ;
		$optional_sections = array();
		foreach ($_POST as $key => $value) {
			if( strpos( $key, "wpOptionalInput" ) !== false ) {
				$optional_sections[] = str_replace( "wpOptionalInput", "", $key );
			}
		}
		if (!$content) {
			$title = Title::newFromText ('Createplate-' . $this->mTemplate, NS_MEDIAWIKI) ;
			if ($title->exists()) {
				$rev = Revision::newFromTitle ($title) ;
				$me = CreateMultiPage::multiEditParse (10, 10, '?', $rev->getText (), $optional_sections ) ;
			} else {
				$me = CreateMultiPage::multiEditParse (10, 10, '?', "<!---blanktemplate--->") ;
			}
		} else {
			$me = CreateMultiPage::multiEditParse (10,10,'?', $content, $optional_sections ) ;
		}
		$wgOut->addHTML ("<div id=\"cp-restricted\">") ;
		$wgOut->addHTML ("
				<div id=\"createpageoverlay\">
				<div class=\"hd\"></div>
				<div class=\"bd\"></div>
				<div class=\"ft\"></div>
				</div>
		") ;

		$wgOut->addHTML("<div id=\"cp-multiedit\">{$me}</div>");
		// check for already submitted values - for a preview, for example
		('' != $wgRequest->getVal ('wpSummary')) ? $summaryval = $wgRequest->getVal ('wpSummary') : $summaryval = '' ;		
		if ($this->mInitial) {
			if( $wgUser->getOption( 'watchcreations' ) ) {
				$watchthischeck = 'checked="checked"' ;
			} else {
				$watchthischeck = '' ;
			}

			if( $wgUser->getOption( 'minordefault' ) ) {
				$minoreditcheck = 'checked="checked"' ;
			} else {
				$minoreditcheck = '' ;
			}
		} else {
			($wgRequest->getCheck ('wpWatchthis')) ? $watchthischeck = 'checked="checked"' : $watchthischeck = '' ;
			($wgRequest->getCheck ('wpMinoredit')) ? $minoreditcheck = 'checked="checked"' : $minoreditcheck = '' ;			
		}
	
		global $wgRightsText;
		$copywarn = "<div id=\"editpage-copywarn\">\n" .
				wfMsg( $wgRightsText ? 'copyrightwarning' : 'copyrightwarning2',
				'[[' . wfMsgForContent( 'copyrightpage' ) . ']]',
				$wgRightsText ) . "\n</div>";
		$wgOut->addWikiText ($copywarn) ;	
		$editsummary="<span id='wpSummaryLabel'>" . wfMsg ('summary') ."<label for='wpSummary'>:</label></span>\n<input type='text' value=\"" . $summaryval  . "\" name='wpSummary' id='wpSummary' maxlength='200' size='60' /><br />";	

		$checkboxhtml = '<input id="wpMinoredit" type="checkbox" accesskey="i" value="1" name="wpMinoredit" ' . $minoreditcheck . '/>' . '<label accesskey="i" title="' . wfMsg ('tooltip-minoredit') . ' [alt-shift-i]" for="wpMinoredit">' . wfMsg ('minoredit') . '</label>' ;
		$checkboxhtml .= '<input id="wpWatchthis" type="checkbox" accesskey="w" value="1" name="wpWatchthis" ' . $watchthischeck . '/>' . '<label accesskey="w" title="' . wfMsg ('tooltip-watch') . ' [alt-shift-w]" for="wpWatchthis">' . wfMsg ('watchthis') . '</label>' ;

		$wgOut->addHTML ('<div id="createpagebottom">' . $editsummary . $checkboxhtml . '</div>') ;

		$wgOut->addHTML ("<div class=\"actionBar buttonBar\">
			<input type=\"submit\" id=\"wpSave\" name=\"wpSave\" value=\"".wfMsg ('save')."\" class=\"button color1\">
			<input type=\"submit\" id=\"wpPreview\" name=\"wpPreview\" value=\"".wfMsg ('preview')."\" class=\"button color1\">
			<input type=\"submit\" id=\"wpCancel\" name=\"wpCancel\" value=\"".wfMsg ('cancel')."\" class=\"button color1\">
			</div>"
		) ;

		// stuff for red links - bottom edittools, to be more precise
		if ($this->mRedLinked && ($this->mTemplate == 'Blank') ) {
			$wgOut->addHtml( '<div id="createpage_editTools" class="mw-editTools">' );
			$wgOut->addWikiText( wfMsgForContent( 'edittools' ) );
			$wgOut->addHtml( '</div>' );
		}
				
		$wgOut->addHTML ("</form></div>") ;
	}

	// take given categories and glue them together
	function GlueCategories ($checkboxes_array, $categories) {
		global $wgContLang;

		$text = '' ;
		$ns_cat = $wgContLang->getFormattedNsText( NS_CATEGORY );

		foreach ($checkboxes_array as $category) {
			$text .= "\n[[" . $ns_cat . ":" . $category . "]]" ;
		} 

		// parse the textarea
		$categories_array = preg_split ("/\|/", $categories, -1) ;
		foreach ($categories_array as $category) {
			if (!empty ($category)) {
				$text .= "\n[[" . $ns_cat . ":" . $category . "]]" ;
			}
		} 
		
		return $text ;
	}

	// get the infobox' text and substitute all known values...
	function GlueInfobox ($infoboxes_array, $infobox_text) {		
		$inf_pars = preg_split ("/\|/", $infobox_text, -1) ;		

		// correct for additional |'s the users may have put in here...
		$fixed_par_array = array();
		$fix_corrector = 0;

		for ($i=0; $i < count($inf_pars); $i++) {
			if( (strpos( $inf_pars[$i], "=" ) === false) && (0 != $i) ) { //this was cut out from user supplying '|' inside the parameter...
				$fixed_par_array[$i - ( 1 + $fix_corrector ) ] .= "|" . $inf_pars[$i];                                            
				$fix_corrector++;
			} else {
				$fixed_par_array[] = $inf_pars[$i];
			}
		}

		$text = array_shift ($fixed_par_array) ;
		$inf_par_num = 0 ;

		foreach ($fixed_par_array as $inf_par) {
			$inf_par_pair = preg_split ("/=/", $inf_par, -1) ;
			if (is_array ($inf_par_pair)) {
				$text .= "|" . $inf_par_pair[0] . " = " . $this->escapeKnownMarkupTags (trim ($infoboxes_array [$inf_par_num])) ."\n" ;
				$inf_par_num++ ;
			}
		}	
		return $text . "}}\n" ;	
	}

	// since people can put in pipes and brackets without them knowing that it's BAD
	// because it makes an infobox template writhe in agony... escape the tags
	function escapeKnownMarkupTags ($text) {
		$text = str_replace ('|', '<!---pipe--->', $text) ;
		$text = str_replace ('{{', '', $text) ; 						
		$text = str_replace ('}}', '', $text) ; 						
		return $text ;
	}

	function GlueArticle ($preview = false, $render_option = true) {		
		global $wgRequest, $wgOut ;
		$text = '' ;
		$infoboxes = array();
		$categories = array();
		$optionals = array();
		$images = array ();
		$all_images = array();		
		$error_once = false ;

		foreach ($_POST as $key => $value) {									
			if( strpos( $key, "wpOptionals" ) !== false ) {
				if ( $render_option ) {
					// build optional data
					$optionals = explode( ',', $value  );				
				}
			} else if (strpos ($key, "wpTextboxes") !== false) {
				// check if this was optional				
				if( !in_array( $key, $optionals ) ) {
					$text .= "\n" . $value ;
				}
			} else if (strpos ($key, "wpInfoboxPar") !==  false ) {
				$infoboxes[] = $value ; 				
			} else if (strpos ($key, "category_") !==  false) {
				$categories[] = $value ;
			} else if (strpos ($key, "wpDestFile") !== false) {
				$image_value = array () ;
				$postfix = substr($key, 10);

				if ($wgRequest->getVal ('wpNoUse' . $postfix) == 'Yes'  ) {
					$infoboxes [] = $wgRequest->getVal ("wpInfImg" . $postfix) ;						
				} else {
					$image_value ["watchthis"] = $_POST ["wpWatchthis" . $postfix] ;					

					// do the real upload
					$uploadform = new CreatePageImageUploadForm ($wgRequest) ;
					$uploadform->mTempPath       = $wgRequest->getFileTempName( 'wpUploadFile' . $postfix );
					$uploadform->mFileSize       = $wgRequest->getFileSize( 'wpUploadFile' . $postfix );
					$uploadform->mSrcName        = $wgRequest->getFileName( 'wpUploadFile' . $postfix );
					$uploadform->CurlError       = $wgRequest->getUploadError( 'wpUploadFile' . $postfix );

					// required by latest functions
					$par_name = $wgRequest->getText ('wpParName' .$postfix) ;
					if ($uploadform->mSrcName ) {
						$file_ext = split ("\.", $uploadform->mSrcName) ;
						$file_ext = $file_ext [1] ;
					} else {
						$file_ext = '' ;
					}
					$uploadform->mParameterExt = $file_ext ;					
					$uploadform->mDesiredDestName = $wgRequest->getText ('Createtitle') . ' ' . trim ($par_name) ;
					$uploadform->mSessionKey     = false;
					$uploadform->mStashed        = false;
					$uploadform->mRemoveTempFile = false;

					// some of the values are fixed, we have no need to add them to the form itself
					$uploadform->mIgnoreWarning = 1 ;
					$uploadform->mUploadDescription = wfMsg ('createpage_uploaded_from') ;
					$uploadform->mWatchthis = 1  ;					
					$uploadedfile = $uploadform->execute () ;
					if ($uploadedfile ["error"] == 0) {
						$infoboxes [] = $uploadedfile ["msg"]  ;
					} else {
						$infoboxes [] = "<!---imageupload--->"  ;
						if ($uploadedfile ["once"]) {
							if (!$error_once) {
								if (!$preview) { // certainly they'll notice things on preview
									$wgOut->addHTML( "<p class='error'>{$uploadedfile ["msg"]}</p>" );
								}
							}							
							$error_once = true ;										
						} else {
							if (!$preview) {
								$wgOut->addHTML( "<p class='error'>{$uploadedfile ["msg"]}</p>" );
							}
						}
					}
				}
			} else if (strpos ($key, "wpAllDestFile") !== false) {
				// upload and glue in images that are within the article content too

				$image_value = array () ;
				$postfix = substr($key, 13);
				$image_value ["watchthis"] = $_POST ["wpWatchthis" . $postfix] ;					
			
				$uploadform = new CreatePageImageUploadForm ($wgRequest) ;
				$uploadform->mTempPath       = $wgRequest->getFileTempName( 'wpAllUploadFile' . $postfix );
				$uploadform->mFileSize       = $wgRequest->getFileSize( 'wpAllUploadFile' . $postfix );
				$uploadform->mSrcName        = $wgRequest->getFileName( 'wpAllUploadFile' . $postfix );
				$uploadform->CurlError       = $wgRequest->getUploadError( 'wpAllUploadFile' . $postfix );

				// required by latest functions
				if ($uploadform->mSrcName) {
					$file_ext = split ("\.", $uploadform->mSrcName) ;
					$file_ext = $file_ext [1] ;
				} else {
					$file_ext = '' ;
				}
				$uploadform->mParameterExt = $file_ext ;					
				$uploadform->mDesiredDestName = $wgRequest->getText ('Createtitle') ;
				$uploadform->mSessionKey     = false;
				$uploadform->mStashed        = false;
				$uploadform->mRemoveTempFile = false;

				$uploadform->mIgnoreWarning = 1 ;
				$uploadform->mUploadDescription = wfMsg ('createpage_uploaded_from') ;
				$uploadform->mWatchthis = 1  ;					
				$uploadedfile = $uploadform->execute () ;
				if ($uploadedfile ["error"] == 0) {
					$all_images [] = $uploadedfile ["msg"]  ;
				} else {
					$all_images [] = "<!---imageupload--->"  ;
					if ($uploadedfile ["once"]) {
						if (!$error_once) {
							if (!$preview) {
								$wgOut->addHTML( "<p class='error'>{$uploadedfile ["msg"]}</p>" );
							}
						}
						$error_once = true ;										
					} else {
						if (!$preview) {
							$wgOut->addHTML( "<p class='error'>{$uploadedfile ["msg"]}</p>" );
							}
						}
				}				
			}		
		}

		if (is_array ($all_images)) {
			// glue in images, replacing all image tags with content
			foreach ($all_images as $myimage) {
				$repl_count = 1 ;
				if ($myimage != "<!---imageupload--->") {
					$text = $this->str_replace_once ("<!---imageupload--->", "[[" . $myimage . "|thumb]]", $text) ;
				}
			}
		}

		if (isset ($_POST["wpInfoboxValue"])) {		
			$text = $this->GlueInfobox ($infoboxes, $_POST["wpInfoboxValue"]) . $text ;
		}

		if (isset ($_POST["wpCategoryTextarea"])) {
			$text .= $this->GlueCategories ($categories, $_POST["wpCategoryTextarea"]) ;
		}

		return $text ;
	}

	// by jmack@parhelic.com from php.net 
	function str_replace_once($search, $replace, $subject) {
		if(($pos = strpos($subject, $search)) !== false) {
			$ret = substr($subject, 0, $pos).$replace.substr($subject, $pos + strlen($search));
		}
		else {
			$ret = $subject;
		}
		return($ret);
	}

}

require_once ("$IP/includes/Article.php") ;

// a small class to overcome some MediaWiki shortages :)
// MediaWiki always shows a newly created article, which in this case
// disrupts the form and generally doesn't suit us, and uploading a new
// image creates a new article

class PocketSilentArticle extends Article {
	// don't SHOW article upon creation, because it's IRRITATING
	function insertNewArticle( $text, $summary, $isminor, $watchthis, $suppressRC=false, $comment=false ) {
		$flags = EDIT_NEW | EDIT_DEFER_UPDATES | EDIT_AUTOSUMMARY |
			( $isminor ? EDIT_MINOR : 0 ) |
			( $suppressRC ? EDIT_SUPPRESS_RC : 0 );

		if ( $comment && $summary != "" ) {
			$text = "== {$summary} ==\n\n".$text;
		}

		$this->doEdit( $text, $summary, $flags );

		$dbw = wfGetDB( DB_MASTER );
		if ($watchthis) {
			if (!$this->mTitle->userIsWatching()) {
				$dbw->begin();
				$this->doWatch();
				$dbw->commit();
			}
		} else {
			if ( $this->mTitle->userIsWatching() ) {
				$dbw->begin();
				$this->doUnwatch();
				$dbw->commit();
			}
		}
	}
}

?>
