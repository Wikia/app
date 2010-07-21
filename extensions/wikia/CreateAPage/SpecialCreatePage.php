<?php

/*
	A special page to create a new article using multi edit editor
*/
if(!defined('MEDIAWIKI'))
   die();

/**
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Bartek Łapiński <bartek@wikia.com>
 * @copyright Copyright (C) 2007-2008 Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
**/

$dir = dirname(__FILE__);
$wgExtensionMessagesFiles ['CreateAPage'] = $dir . '/MultiEdit.i18n.php' ;

$wgExtensionCredits['specialpage'][] = array(
   'name' => 'CreatePage',
   'author' => 'Bartek Łapiński, Lucas \'TOR\' Garczewski, Przemek Piotrowski'  ,
   'url' => 'http://help.wikia.com/wiki/Help:CreatePage' ,
   'version' => '3.78' ,
   'description' => 'easy to use interface for creating new articles'
);

global $IP;

require_once $dir . '/CreatePageEditor.php' ;
require_once $dir . '/CreateMultiPage.php' ;
require_once $dir . '/CreatePageImageUploadForm.php' ;
require_once $dir . '/SpecialCreatePage_ajax.php';

if (!isset ($wgCreatePageCoverRedLinks) ) { 
	$wgCreatePageCoverRedLinks = false ; 
}

$wgHooks['EditPage::showEditForm:initial'][] = 'wfCreatePagePreloadContent';
$wgHooks['Image::RecordUpload:article'][] = 'wfCreatePageShowNoImagePage';
$wgHooks ['CustomEditor'][] = 'wfCreatePageRedLinks' ; 
// confirm edit captcha
if( $wgWikiaEnableConfirmEditExt ) {
	$wgHooks['ConfirmEdit::onConfirmEdit'][] = 'wfCreatePageConfirmEdit';	
}

if ($wgCreatePageCoverRedLinks) {
	$wgHooks ['getEditingPreferencesCustomHtml'][] = 'wfCreatePagePrefCustomHtml' ;
	$wgHooks ['UserToggles'][] = 'wfCreatePageToggle' ;
}

/* special page init */
$wgSpecialPages ['Createpage'] = array('SpecialPage', 'Createpage', 'createpage', true, 'wfCreatePageSpecial', false) ;
$wgSpecialPageGroups['Createpage'] = 'pagetools';
$wgExtensionAliasesFiles['Createpage'] = dirname(__FILE__) . '/SpecialCreatePage.alias.php';

// handle ConfirmEdit captcha, only for CreatePage, which will be treated a bit differently (edits in special page)
function wfCreatePageConfirmEdit( &$captcha, &$editPage, $newtext, $section, $merged, &$result ) {
	global $wgTitle, $wgCreatePageCoverRedLinks, $wgOut, $wgRequest;
	$canonspname = SpecialPage::resolveAlias( $wgTitle->getDBkey() );
        if (!$wgCreatePageCoverRedLinks) {
                return true;
        }
	if ('createpage' != $canonspname) {
		return true;	
	}

	if( $captcha->shouldCheck( $editPage, $newtext, $section, $merged ) ) {
		if( $captcha->passCaptcha() ) {
			$result = true;
			return false;
		} else {
			// display CAP page
			wfLoadExtensionMessages ('CreateAPage');
			$mainform = new CreatePageCreatePlateForm () ;
			$mainform->showForm ( '', false, array( &$captcha, 'editCallback' ) ) ;
			$editor = new CreatePageMultiEditor ( $_SESSION['article_createplate'] ) ;
			$editor->GenerateForm ($newtext) ;

			$result = false;
			return false;
		}
	} else {
		return true;
	}
}

// when AdvancedEdit button is used, the existing content is preloaded
function wfCreatePagePreloadContent ($editpage) {
	global $wgRequest ;
	if ($wgRequest->getCheck ('createpage')) {
		$editpage->textbox1 = $_SESSION	["article_content"] ;		
	}
	return true ;
}

// because MediaWiki jumps happily to the article page
// when we create it - in this case, for image upload
function wfCreatePageShowNoImagePage ($article, $title) {
	$article = new PocketSilentArticle ($title) ;
	return true ;
}

function wfCreatePageRedLinks ($article, $user) {
	global $wgRequest, $wgContentNamespaces, $wgCreatePageCoverRedLinks ;
	if (!$wgCreatePageCoverRedLinks) { 
		return true ; 
	} 
	$namespace = $article->getTitle()->getNamespace() ;
	if ((0 == $user->getOption ('createpage-redlinks', 1)) || !in_array ($namespace, $wgContentNamespaces) ) {
		return true ;
	}
	// nomulti should always bypass that (this is for AdvancedEdit mode)
	if ($article->getTitle()->exists() || ('nomulti' == $wgRequest->getVal ('editmode'))) {	
		return true ;
	} else {
                if ($wgRequest->getCheck ('wpPreview')) {
                        return true;
                }	
		wfLoadExtensionMessages ('CreateAPage') ;
		$mainform = new CreatePageCreateplateForm () ;
		$mainform->mTitle = $wgRequest->getVal ('title') ;		
		$mainform->mRedLinked = true ;
		$mainform->showForm ('') ;		
		$mainform->showCreateplate (true) ;
		return false ;
	}
}

// main wrapper function
function wfCreatePageSpecial( $par ) {
	global $wgOut, $wgUser, $wgRequest, $wgServer, $wgScriptPath, $wgContLang ;
	wfLoadExtensionMessages ('CreateAPage') ;
	$mainform = new CreatePageCreateplateForm ($par) ;
	
	$action = $wgRequest->getVal ('action') ;
	if ( $wgRequest->wasPosted() && 'submit' == $action) {
		$mainform->submitForm () ;
	} else if ('check' == $action) {
		$mainform->checkArticleExists ($wgRequest->getVal ('to_check'), true) ;
	} else {
		$mainform->showForm ('') ;
		$mainform->showCreateplate (true) ;
	}
}

function wfCreatePagePrefCustomHtml ($prefsForm) {
        global $wgOut, $wgUser, $wgLang ;
	wfLoadExtensionMessages ('CreateAPage') ;
        $tname = 'createpage-redlinks' ;
        $prefsForm->mUsedToggles [$tname] =  true ;
        $ttext = $wgLang->getUserToggle ($tname) ;
        // the catch lies here
        $checked = $wgUser->getOption ($tname, 1) == 1 ? ' checked="checked"' : '';

        $wgOut->addHTML ("<div class='toggle'><input type='checkbox' value='1' id=\"$tname\" name=\"wpOp$tname\"$checked />" .
                        " <span class='toggletext'><label for=\"$tname\">$ttext</label></span></div>\n") ;
        return true ;
}

function wfCreatePageToggle ($toggles) {
        $toggles ['create-page-redlinks'] = 'createpage-redlinks' ;
        return true ;
}

// this class takes care for the createplate loader form
class CreatePageCreateplateForm {
	var $mCreateplatesLocation ;
	var $mTitle, $mNamespace, $mCreateplate ;
	var $mRedLinked ; 

	// constructor
	function CreatePageCreateplateForm ( $par = null ) {
		global $wgRequest ;
		$this->mCreateplatesLocation = "Createplate-list" ;
		if ( 'submit' == $wgRequest->getVal( 'action' )) {
			$this->mTitle = $wgRequest->getVal ('Createtitle') ;                                                  	
			$this->mCreateplate = $wgRequest->getVal ('createplates') ;
			// for preview in red link mode
			if ($wgRequest->getCheck ('Redlinkmode')) {
				$this->mRedLinked = true ;
			}
		} else {
			// title override
			if ('' != $wgRequest->getVal ('Createtitle')) {
				$this->mTitle = $wgRequest->getVal ('Createtitle') ;
				$this->mRedLinked = true ;
			} else {
				$this->mTitle = '' ;
			}
			// url override			
			$this->mCreateplate = $wgRequest->getVal ('createplates')  ;
		}
	}

	function makePrefix ($title) {
		$title = str_replace( '_', ' ', $title );
		return $title ;
	} 

	// show form
	function showForm ( $err, $content_prev = false, $formCallback = null ) {
		global $wgOut, $wgUser, $wgRequest ;

		$StaticChuteJs = new StaticChute('js');
		$StaticChuteJs->useLocalChuteUrl();

		$StaticChuteCss = new StaticChute('css');
		$StaticChuteCss->useLocalChuteUrl();

		$wgOut->addHTML( $StaticChuteJs->getChuteHtmlForPackage( 'yui' ) );
		$wgOut->addHTML( $StaticChuteCss->getChuteHtmlForPackage( 'yui_css' ) );

		if ($wgRequest->getCheck ('wpPreview')) {
			$wgOut->setPageTitle (wfMsg('preview')) ;
                } else {
			if ($this->mRedLinked) {
				$wgOut->setPageTitle (wfMsg ('editing', $this->makePrefix ($this->mTitle)) ) ;	
			} else {
				$wgOut->setPageTitle (wfMsg ('createpage_title')) ;
			}
		}

		if ($wgUser->isLoggedIn()) {
			$token = htmlspecialchars( $wgUser->editToken() );
		} else {
			$token = EDIT_TOKEN_SUFFIX;
		}
		$titleObj = Title::makeTitle( NS_SPECIAL, 'Createpage' );
		$action = $titleObj->escapeLocalURL( "action=submit" ) ;

		if ($wgRequest->getCheck ('wpPreview')) {
			$wgOut->addHTML ("<div class=\"previewnote\"><p>" . wfMsg('previewnote') . "</p></div>") ;	
		} else {
			$wgOut->addHTML (wfMsg('createpage_title_additional')) ;
		}
                if ( "" != $err ) {
                        $wgOut->setSubtitle( wfMsgHtml( 'formerror' ) );
                        $wgOut->addHTML( "<p class='error'>{$err}</p>\n" );
                }
	
		// show stuff like on normal edit page, but just for red links
		if ($this->mRedLinked) {
			if( $wgUser->isLoggedIn() ) {
				$wgOut->addWikiMsg( 'newarticletext' );
			} else {
				$wgOut->addWikiMsg( 'newarticletextanon' );
			}
			if( $wgUser->isAnon() && !$wgRequest->getCheck ('wpPreview') ) {
	                       $wgOut->addWikiMsg( 'anoneditwarning' );
			}
		}	
		global $wgStylePath, $wgStyleVersion, $wgExtensionsPath ;
		
		$wgOut->addScript("\n\n\t\t".'<link rel="stylesheet" type="text/css" href="'.$wgExtensionsPath.'/wikia/CreateAPage/CreatePage.css?'.$wgStyleVersion.'" />'."\n");
		if($wgUser->getOption('disablelinksuggest') != true) {
			$wgOut->addHTML('<div id="wpTextbox1_container" class="yui-ac-container"></div>');
			$wgOut->addScript('<script type="text/javascript" src="'.$wgExtensionsPath.'/wikia/LinkSuggest/LinkSuggest.js?'.$wgStyleVersion.'"></script>');
		}

			$alternate_link = "<a href=\"#\" onclick=\"CreatePageNormalEdit(); return false;\" >".wfMsg ('createpage_here')."</a>" ;
			$wgOut->addHTML ("<div id=\"createpage_subtitle\" style=\"display:none\">".wfMsg ('createpage_alternate_creation', $alternate_link)."</div>") ;
		
		if ($wgRequest->getCheck ('wpPreview')) {
			$this->showPreview ($content_prev, $wgRequest->getVal ('Createtitle')) ;						
		}

		$tmpl = new EasyTemplate(dirname(__FILE__) . '/templates/');
		$wgOut->addHTML($tmpl->execute('title-check'));

	       	$html = "
<form name=\"createpageform\" enctype=\"multipart/form-data\" method=\"post\" action=\"{$action}\" id=\"createpageform\">
	<div id=\"createpage_messenger\" style=\"display:none; color:red \" ></div>
		<noscript>
		<style type=\"text/css\">
			#loading_mesg, #image_upload {
				display: none ;
			}
		</style>
		</noscript>" ;

		$html .= "
		<input type='hidden' name='wpEditToken' value=\"{$token}\" />
		<input type=\"hidden\" name=\"wpCreatePage\" value=\"true\" />
		" ;


		$wgOut->addHTML ($html) ;
		// adding this for captchas and the like
		if( is_callable( $formCallback ) ) {
                        call_user_func_array( $formCallback, array( &$wgOut ) );
                }

		$wgOut->addHTML($tmpl->execute('toggles'));
		$parsed_templates = $this->getCreateplates () ;
               	!$parsed_templates ? $show_field = 'none' : $show_field = '' ;
		
		if (!$wgRequest->getCheck ('wpPreview')) {
			$wgOut->addHTML('<fieldset id="cp-chooser-fieldset" style="display: '. $show_field . ';"><legend>'.wfMsg ('createpage_choose_createplate').' <span style="font-size: small; font-weight: normal; margin-left: 5px">[<a id="cp-chooser-toggle" title="toggle" href="#">'.wfMsg ('me_hide').'</a>]</span></legend>');
			$wgOut->addHTML("<div id=\"cp-chooser\" style=\"display: block;\">");
		}		
		$this->produceRadioList ($parsed_templates) ;
	}

	// get the list of createplates from a MediaWiki namespace page
	// parse the content into an array and return it
	function getCreateplates () {
		global $wgOut ;
		$createplates_txt = wfMsgForContent ($this->mCreateplatesLocation) ;
		if ('' != $createplates_txt) {                                   					
			$lines = preg_split ("/[\n]+/", $createplates_txt) ;
		}
		$createplates = array () ;		
		if (!empty ($lines) ) {
			// each createplate is listed in a new line, has two required and one optional
			// parameter, all separated by pipes
			foreach ($lines as $line) {
				if (preg_match ("/^[^\|]+\|[^\|]+\|[^\|]+$/", $line) ) {
					// three parameters
					$line_pars = preg_split ("/\|/", $line) ; 
					$createplates [] = array (
							'page' 	=> $line_pars [0] ,
							'label' => $line_pars [1] ,
							'preview' => $line_pars [2]
							) ;

				} else if (preg_match ("/^[^\|]+\|[^\|]+$/", $line)) {
					// two parameters
					$line_pars = preg_split ("/\|/", $line) ; 
					$createplates [] = array (
							'page' 	=> $line_pars [0] ,
							'label' => $line_pars [1]
							) ;
				}
			}
		}
                if (empty ($createplates)) {
			return false ;
		} else {
			return $createplates ;
		}
	}

	// return checked createplate
	function getChecked ($createplate, $current, &$checked) {
		if (!$createplate) {
			if (!$checked) {
				$this->mCreateplate = $current ;
				$checked = true ;
				return "checked" ;
			}
			return "" ;
		} else {
			if ($createplate == $current) {
				$this->mCreateplate = $current ;
				return "checked" ;
			} else {
				return "" ;
			}  		
		}
	}

        // produce a list of radio buttons from the given createplate array
	function produceRadioList($createplates) {
		global $wgOut, $wgRequest, $wgServer, $wgScript ;

		// this checks radio buttons when we have no javascript...
		$this->mCreateplate != '' ? $selected = $this->mCreateplate : $selected = false ;
		$checked = false ;
		$check = array () ;
		foreach ($createplates as $createplate) {
			$check [$createplate ["page"]] = $this->getChecked ($selected , $createplate ["page"], $checked) ;
		}

		if ($this->mRedLinked) {
			global $wgParser, $wgUser ;
	                $parserOptions = ParserOptions::newFromUser ($wgUser) ;
	                $parserOptions->setEditSection (false) ;
        	        $rtitle = Title::newFromText ($this->mTitle) ;
                	$parsed_info = $wgParser->parse (wfMsg ('createpage_about_info'), $rtitle, $parserOptions) ;				
			$aboutinfo = str_replace ('</p>', '', $parsed_info->mText) ;
			$aboutinfo .= wfMsg ('createpage_advanced_text', '<a href="' . $wgServer . $wgScript . '" id="wpAdvancedEdit">' . wfMsg ('createpage_advanced_edit') . '</a>'). '</p>' ;
		} else {
			$aboutinfo = '' ;
		}

		$tmpl = new EasyTemplate(dirname(__FILE__) . '/templates/');
		$tmpl->set_vars(array
		(
			'data'     => $createplates ,
			'selected' => $check ,
			'createtitle' => $this->makePrefix ($this->mTitle) ,
			'ispreview' => $wgRequest->getCheck ('wpPreview') ,
			'isredlink' => $this->mRedLinked ,
			'aboutinfo' => $aboutinfo ,
		));

		$wgOut->addHTML($tmpl->execute('templates-list'));
	}

	// existing article check, returns different stuff for ajax and non-ajax versions
	function checkArticleExists ($given, $ajax = false) {
		global $wgOut, $wgUser ;

		if ($ajax) {
			$wgOut->setArticleBodyOnly( true );
		}
		
		if (empty($given) && !$ajax) {
			return wfMsg ('createpage_give_title') ;
		}

		$title = Title::newFromText( $given );
		if (is_object ($title)) {
			$page = $title->getText () ;
			$page = str_replace( ' ', '_', $page ) ;
			$dbr =& wfGetDB (DB_SLAVE);
			$exists = $dbr->selectField ('page', 'page_title', array ('page_title' => $page, 'page_namespace' => $title->getNamespace() )) ;
			if ($exists != '') {
				if ($ajax) {
					$wgOut->addHTML('pagetitleexists');
				} else {
					$sk = $wgUser->getSkin();
					# Mimick the way AJAX version displays things and use the same two messages. 2 are needed for full i18n support.
					return wfMsg ('createpage_article_exists', $sk->makeKnownLinkObj( $title, '', 'action=edit' ) );
				}
			}
			if (!$ajax) return false ;		
		} else {
			if (!$ajax) return wfMsg ('createpage_title_invalid') ;
		}		
	}

	function submitForm () {
		global $wgOut, $wgRequest, $wgServer, $wgScriptPath ;
		// check if we are editing in red link mode
		if ($wgRequest->getCheck ('wpSubmitCreateplate')) { 
			$mainform = new CreatePageCreateplateForm () ;
			$mainform->showForm ('') ;
			$mainform->showCreateplate () ;
			return false ;
		} else {
			$valid = $this->checkArticleExists ($wgRequest->getVal ('Createtitle')) ;
			if ($valid != '') {
				//no title? this means overwriting Main Page...
				$mainform = new CreatePageCreateplateForm () ;			
				$mainform->showForm ($valid) ;
				$editor = new CreatePageMultiEditor ($this->mCreateplate) ;
				$editor->GenerateForm ($editor->GlueArticle ()) ;
				return false ;
			}
			if ($wgRequest->getCheck ('wpSave') ) {
				$editor = new CreatePageMultiEditor ($this->mCreateplate) ;
				$rtitle = Title::newFromText ($wgRequest->getVal ('Createtitle')) ;
				$rarticle = new Article ($rtitle, $rtitle->getArticleID ()) ;
				$editpage = new EditPage ($rarticle) ;
				$editpage->mTitle = $rtitle ;
				$editpage->mArticle = $rarticle ;
				$editpage->textbox1 = CreateMultiPage::unescapeBlankMarker ($editor->GlueArticle ()) ;
				
				$editpage->minoredit = $wgRequest->getCheck ('wpMinoredit') ;
	                        $editpage->watchthis = $wgRequest->getCheck ('wpWatchthis') ;
	                        $editpage->summary = $wgRequest->getVal ('wpSummary') ;
				$_SESSION ['article_createplate'] = $this->mCreateplate;
				// pipe tags to pipes
				wfCreatePageUnescapeKnownMarkupTags ($editpage->textbox1) ;
				$editpage->attemptSave () ;
				return false ;
			} else if ($wgRequest->getCheck ('wpPreview')) {		        	
				$mainform = new CreatePageCreatePlateForm () ;
				$editor = new CreatePageMultiEditor ($this->mCreateplate, true) ;
				$content = $editor->GlueArticle (true, false) ;				
				$content_static = $editor->GlueArticle (true) ;				
				$mainform->showForm ('', $content_static) ;
				$editor->GenerateForm ($content) ;
				return false ;
			} else if ($wgRequest->getCheck ('wpAdvancedEdit')) {
                                $editor = new CreatePageMultiEditor ($this->mCreateplate) ;
                                $content = CreateMultiPage::unescapeBlankMarker ($editor->GlueArticle ()) ;
				wfCreatePageUnescapeKnownMarkupTags ($content) ;				
				$_SESSION ['article_content'] = $content ;
				$wgOut->redirect ($wgServer . $wgScript . "?title=" . $wgRequest->getVal ('Createtitle') . "&action=edit&createpage=true") ;
			} else if ($wgRequest->getCheck ("wpImageUpload")) {
				$mainform = new CreatePageCreatePlateForm () ;
                                $mainform->showForm ('') ;
                                $editor = new CreatePageMultiEditor ($this->mCreateplate) ;
                                $content = $editor->GlueArticle () ;
                                $editor->GenerateForm ($content) ;
			} else if ($wgRequest->getCheck ("wpCancel")) {					
				if ('' != $wgRequest->getVal ('Createtitle')) {
					$wgOut->redirect ($wgServer . $wgScript . "?title=" . $wgRequest->getVal ('Createtitle')) ;
				} else {
					$wgOut->redirect ($wgServer . $wgScript) ;
				}				
			}
		}
        }

	// display the preview in another div
	function showPreview ($content, $title) {
		global $wgOut, $wgUser, $wgParser ;
		$parserOptions = ParserOptions::newFromUser ($wgUser) ;
		$parserOptions->setEditSection (false) ;
		$rtitle = Title::newFromText ($title) ;
		if (is_object ($rtitle)) {
			wfCreatePageUnescapeKnownMarkupTags ($content) ;
			$pre_parsed = $wgParser->preSaveTransform ($content, $rtitle, $wgUser, $parserOptions, true) ;
			$output = $wgParser->parse ($pre_parsed, $rtitle, $parserOptions) ;
			$wgOut->addParserOutputNoText ($output) ;
			$wgOut->addHTML ("<div id=\"createpagepreview\">
					$output->mText
					<div id=\"createpage_preview_delimiter\" class=\"actionBar actionBarStrong\">" . wfMsg ('createpage_preview_end') . "</div>
					</div>
					") ;		
		}
	}

	function showCreateplate ($isinitial = false) {
		global $wgOut, $wgUser, $wgRequest ;
		if ($this->mCreateplate) {
			$editor = new CreatePageMultiEditor ($this->mCreateplate) ;	
		} else {
			$editor = new CreatePageMultiEditor ("Blank") ;				
		}
		$this->mRedLinked ? $editor->mRedLinked = true : $editor->mRedLinked = false ;
		$isinitial ? $editor->mInitial = true : $editor->mInitial = false ;
		$editor->GenerateForm () ;		
	}
}

?>
