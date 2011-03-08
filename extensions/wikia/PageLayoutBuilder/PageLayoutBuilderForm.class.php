<?php

class PageLayoutBuilderForm extends SpecialPage {
    function __construct() {
	    wfLoadExtensionMessages( 'PageLayoutBuilder' );
	    parent::__construct( 'PageLayoutBuilderForm', 'PageLayoutBuilderForm' );
	}
    function execute($article_id = null, $limit = "", $offset = "", $show = true) {
		global $wgRequest, $wgOut, $wgTitle, $wgUser, $wgExtensionsPath, $wgScriptPath, $wgStyleVersion;

		$this->pageId = (int) $wgRequest->getVal('pageId', ''); // article ID
		$this->id = (int) $wgRequest->getVal('plbId',''); // layout ID
		//TODO: rename vars

		if($this->id == 0) {
			$this->executeIsNolayout();
			return true;
		}

		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		$staticChute = new StaticChute('js');
		$staticChute->useLocalChuteUrl();

		$wgOut->addScript($staticChute->getChuteHtmlForPackage('yui'));
		
		$wgOut->addStyle( wfGetSassUrl( 'extensions/wikia/PageLayoutBuilder/css/form.scss' ) );
		$wgOut->addStyle( wfGetSassUrl( 'skins/oasis/css/core/_EditPage.scss' ) );

		$wgOut->addScript("<script type=\"text/javascript\" src=\"$wgExtensionsPath/wikia/PageLayoutBuilder/widget/allWidgets.js?$wgStyleVersion\"></script>");

		//$wgOut->addScriptFile($wgScriptPath."/extensions/wikia/PageLayoutBuilder/widget/allWidgets.js");

		if($this->pageId > 0) {
			if( $this->id != PageLayoutBuilderModel::articleIsFromPLB( $this->pageId ) ) {
				$this->executeIsNoArtile();
				return true;
			}

			$this->pageTitle = Title::newFromID($this->pageId, GAID_FOR_UPDATE);
			if(!($this->pageTitle instanceof Title)) {
				$this->executeIsNoArtile();
				return;
			}

			if(!$this->pageTitle->userCan('edit')) {
				$wgOut->permissionRequired( 'edit' );
				return true;
			}

			$this->pageHeader = wfMsg( 'plb-special-form-edit-article', array( "$1" => $this->pageTitle->getText() ));
		} else {
			if(!$wgUser->isAllowed('createpage')) {
				$wgOut->permissionRequired( 'createpage' );
				return true;
			}
		}

		$this->layoutTitle = Title::newFromID($this->id);
		if($this->layoutTitle instanceof  Title && $this->layoutTitle->getNamespace() ==  NS_PLB_LAYOUT ) {
			$this->formValues = array();
			$this->formValues['plbId'] = $this->id;
			$this->formValues['pageId'] = $this->pageId;
			$this->formValues['articleName'] = "";$wgRequest->getVal('default', '');
			$this->formErrors = array();

			if(!($this->pageId > 0)) {
				$this->pageHeader = wfMsg( 'plb-special-form-create-new',  array( "$1" => $this->layoutTitle) );
			}

			$LayoutArticle = new Article( $this->layoutTitle );
			$parser = new PageLayoutBuilderParser();
			$parser->setOutputType(OT_HTML);
			$parserOptions = ParserOptions::newFromUser($wgUser);
			$parserOptions->setEditSection(false);

			$pageTs = "";
			if($wgRequest->wasPosted()) {
				$this->executeSubmit($parser);
			} elseif($this->pageId > 0) {
				$pageArticle = new Article($this->pageTitle);
				$editPage = new EditPage( $pageArticle );
				$loadedValues = $parser->loadFormFromText($editPage->getContent(), $this->pageId, $this->id );
				$pageTs = $pageArticle->getTimestamp(); 
			} else {
				$this->formValues['articleName'] = $wgRequest->getVal('default', '');
			}

			$text = $parser->preParseForm( $LayoutArticle->getContent() );
			$parserOut = $parser->parse($text , $this->layoutTitle, $parserOptions);

			if($this->isCategorySelect()) {
				global $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgCategorySelectMetaData,$wgHooks,$wgRequest;

				$wgHooks['MakeGlobalVariablesScript'][] = 'CategorySelectSetupVars';
				$wgOut->addScript("<script type=\"text/javascript\">var formId = 0;".CategorySelectGetCategories(true)."</script>");
				$wgOut->addScript("<script type=\"text/javascript\" src=\"$wgExtensionsPath/wikia/CategorySelect/CategorySelect.js?$wgStyleVersion\"></script>");

				$cssFile = wfGetSassUrl('/extensions/wikia/CategorySelect/oasis.scss');
				$wgOut->addExtensionStyle($cssFile);

				wfLoadExtensionMessages('CategorySelect');

				if(!empty($loadedValues['cswikitext'])) {
					$cattext = $loadedValues['cswikitext'];
				} else {
					$cattext = $wgRequest->getVal('csWikitext', '');
				}

				$categories = CategorySelect::SelectCategoryAPIgetData($cattext);
				$categories = htmlspecialchars(Wikia::json_encode($categories['categories']));
				$catHtml = '<input type="hidden" value="'.$categories.'" name="wpCategorySelectWikitext" id="wpCategorySelectWikitext" /> ';
				$catHtml .= CategorySelectGenerateHTMLforEditRaw( $cattext );
			}
 
			$html = $parserOut->getText();
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars(array(
				"data" => $this->formValues,
				"wpEdittime" => $wgRequest->getVal('wpEdittime', $pageTs ), 
				"errors" => $this->formErrors,
				"title_error" => isset($this->formErrors["title"]),
				"iserror" => !empty($this->formErrors),
				"editmode" => $this->formValues['pageId'] > 0,
				"layout" => $html,
				"plbId" => $this->formValues['plbId'],
				"url" => $wgRequest->getFullRequestURL(),
				"ispreview" => !empty($this->isPreview) && $this->isPreview,
				"previewdata" => !empty($this->previewData) ? $this->previewData:"",
				"isdelete" => PageLayoutBuilderModel::layoutIsDelete($this->formValues['plbId']),
				"catHtml" => $catHtml,
				"wpEditToken" => Xml::hidden( "wpEditToken", $wgUser->editToken() )
			));
			$wgOut->addHTML( $oTmpl->render( "create-article" ) );
			//TODO: move this to template

			global $wgRightsText;
			if ( $wgRightsText ) {
				$copywarnMsg = array( 'copyrightwarning',
					'[[' . wfMsgForContent( 'copyrightpage' ) . ']]',
					$wgRightsText );
			} else {
				$copywarnMsg = array( 'copyrightwarning2',
					'[[' . wfMsgForContent( 'copyrightpage' ) . ']]' );
			}

			$wgOut->wrapWikiMsg( "<div id=\"editpage-copywarn\">\n$1\n</div>", $copywarnMsg );

			$sk = $wgUser->getSkin();
			$cancel = "";
			if(isset($this->pageTitle) && $this->pageTitle->getText()) {
				$cancel = $sk->makeKnownLink( $this->pageTitle->getPrefixedText(),
					wfMsgExt('cancel', array('parseinline')),
					'', '', '',
					'id="wpCancel"').wfMsgExt( 'pipe-separator' , 'escapenoentities' );
			}

			$edithelpurl = Skin::makeInternalOrExternalUrl( wfMsgForContent( 'edithelppage' ));
			$edithelp = '<a target="helpwindow" href="'.$edithelpurl.'" id="wpEdithelp">'.
			htmlspecialchars( wfMsg( 'edithelp' ) ).'</a> ';

			$wgOut->addHTML( $cancel.$edithelp );

		} else {
			$this->executeIsNolayout();
			return true;
		}
		$wgOut->setPageTitle( $this->pageHeader );
		return true;
    }
    

	/**
	 * isUndo 
	 *
	 * @author Tomek Odrobny
	 * 
	 * @access public
	 *
	 */
	
	public static function isUndo( &$self, $undotext, $undorev, $oldrev ) {	
		global $wgOut;
		$wgOut->addHTML( $self->editFormPageTop );
	
		if($undotext !== false) {
			$self->textbox1 = $oldrev->getText();
			$self->showDiff();	
		}	
				
		return true;	
	}

	function executeSubmit(&$parser) {
		global $wgRequest, $wgOut, $wgUser;

		$articleName = $wgRequest->getVal('wgArticleName', '');
		$elements = PageLayoutBuilderModel::getElementList( $this->layoutTitle->getArticleID() );

		$this->formErrors = array();
		$this->formErrorsList = array();
		$tagValues = array();
		$formValue = array();

		//check edit token 
		$token = $wgRequest->getVal( 'wpEditToken' );
		$this->mTokenOk = $wgUser->matchEditToken( $token );

		if (!$this->mTokenOk ) {
			$this->formErrors[] = wfMsg( 'plb-special-form-session-fail' );
		}
		
		if(isset($elements)) {
			foreach($elements as $key => $value) {
				$reqVal = $wgRequest->getVal('plb_'.$key, '');
				$oWidget = LayoutWidgetBase::getNewWidget($value['type'], $value['attributes'], $reqVal);

				$validateResult = $oWidget->validateForm();
				if(!($validateResult === true)) {
					$this->formErrorsList[$key] = 1;
					if(!in_array($validateResult, $this->formErrors)) {
						$this->formErrors = $this->formErrors + $validateResult;
					}
				}

				$tagValues['val_'.$key] = $reqVal;
				$formValue[$key] = $reqVal;
			}
		}
		
		$parser->forceFormValue($formValue);
		$parser->forceFormErrors($this->formErrorsList);
		if( empty( $this->pageId ) ) {
			if( empty( $articleName ) ) {
				$this->formErrors["title"] = wfMsg( 'plb-special-form-title-empty' );
				return false;
			}

			$oTitle = Title::newFromText( $articleName, NS_MAIN);
			if((!($oTitle instanceof Title)) || ( strlen($oTitle->getFragment()) > 0 )) {
				$this->formErrors["title"] = wfMsg( 'plb-special-form-invalid-title-error' );
				return false;
			}

			$this->mArticle = new Article( $oTitle );
			if( $this->mArticle->exists() ) {
				$this->formErrors["title"] = wfMsg('plb-special-form-already-exists');
				return false;
			}
			$this->formValues['articleName'] = $articleName;
		} else {
			if(!($this->pageId > 0 && $this->id > 0)) {
				$this->formErrors[] = wfMsg('plb-special-form-unknow-error');
				return false;
			}
			$this->mArticle = new Article($this->pageTitle);
		}

		if(count($this->formErrors) > 0) {
			return false;
		}

		
		$this->isPreview = false;
		if( $wgRequest->getVal("wpPreview", "") != "" ) {
			$this->isPreview = true;
		}
		
		if( !empty( $this->pageId ) && !$this->isPreview ) {
			$pageTitle = Title::newFromID($this->pageId);
			$oldValues = $parser->loadForm($pageTitle, $this->layoutTitle->getArticleId() );
			
			foreach($oldValues as $key => $oldValue) {
				if(!isset($tagValues['val_'.$key])){
					$tagValues['val_'.$key] = $oldValue;
				}
			}
		}

		$attribs = $tagValues + array("layout_id" => $this->layoutTitle->getArticleID(), 'cswikitext' => $wgRequest->getVal('csWikitext', '') );
		$mwText = Xml::element("plb_layout", $attribs, '', false);

		if( $this->isPreview ) {
			$previewParser = new PageLayoutBuilderParser();
			$parserOut = $previewParser->parseForArticlePreview($mwText, $this->mArticle->getTitle() );
			$this->previewData = $parserOut->getText();
			return ;
		}

		if(PageLayoutBuilderModel::layoutIsDelete($this->id)) {
			$preParser = new PageLayoutBuilderParser();
			$fakeTitle = new FakeTitle();
			$parserOut = $preParser->preParserArticle($mwText, $fakeTitle );
			$mwText = $parserOut->getText();
		}

		$status = PageLayoutBuilderModel::saveArticle( $this->mArticle, $mwText,  $wgRequest->getVal('wpEdittime'), $wgRequest->getVal("wpSummary", "") );
		switch( $status ) {
			case EditPage::AS_SUCCESS_UPDATE:
			case EditPage::AS_SUCCESS_NEW_ARTICLE:
			case EditPage::AS_ARTICLE_WAS_DELETED:
				PageLayoutBuilderModel::articleMarkAsPLB( $this->mArticle->getID(), $this->layoutTitle->getArticleID() );
				$this->mArticle->getTitle()->invalidateCache();
				$wgOut->redirect($this->mArticle->getTitle()->getFullUrl());
				break;
			default:
				if( $status == EditPage::AS_READ_ONLY_PAGE_LOGGED ) {
					$this->formErrors[] = wfMsg('plb-special-form-cant-edit');
				}
				else {
					$this->formErrors[] = wfMsg('plb-special-form-spam');
				}
				break;
		}
	}


	public static function articleIsFromPLBFull($id, $text) {
		//TODO: cache it by revison
		$layout_id = PageLayoutBuilderModel::articleIsFromPLB( $id );
		if($layout_id !== false ) {
			$is_delete = PageLayoutBuilderModel::layoutIsDelete($layout_id);
			if(!$is_delete || PageLayoutBuilderParser::isArticleFromLayout($text) ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Hook entry
	 *
	 * @static
	 */
	public static function alternateEditHook( $oEditPage ) {
		global $wgOut, $wgUser, $wgTitle, $wgRequest;

		if( !($wgTitle->userCan('edit') || $wgTitle->userCan('createpage')) ) {
			return true;
		}

		if( self::articleIsFromPLBFull($oEditPage->mTitle->getArticleID(), $oEditPage->mArticle->getContent() ) ) {
			$undoafter = $wgRequest->getVal('undoafter', '');
			$undo = $wgRequest->getVal('undo', '');
			$layout_id = PageLayoutBuilderModel::articleIsFromPLB( $oEditPage->mTitle->getArticleID() );
			$oSpecialPageTitle = Title::newFromText('LayoutBuilderForm', NS_SPECIAL);
			
			$url = "plbId=" . $layout_id . "&pageId=".$oEditPage->mTitle->getArticleId();
			
			if(!empty($undoafter)) {
				$url .= "&undoafter=".$undoafter; 
			}
			
			if(!empty($undo)) {
				$url .= "&undo=".$undo;				
			}			
			
			$wgOut->redirect($oSpecialPageTitle->getFullUrl($url));
		}

		return true;
	}

	static public function blockCategorySelect(){
		global $wgTitle;
		if( self::articleIsFromPLBFull($wgTitle->getArticleID(), "") ) {
			return false;
		}
		return true;
	}

	static public function addFormButton(&$self, &$buttons, &$tabindex) {
		$buttons_out = array();
		return true;
	}

	function executeIsNolayout() {
		global $wgOut;
		$wgOut->showErrorPage( 'plb-special-no-layout', 'plb-special-no-layout-body', array(wfGetReturntoParam()));
	}


	function executeIsNoArtile() {
		global $wgOut;
		$wgOut->showErrorPage( 'plb-special-no-article', 'plb-special-no-article-body', array(wfGetReturntoParam()));
	}
	
	private function isCategorySelect() {
		if(function_exists('CategorySelectInitializeHooks')) {
			return true;
		}
		return false;
	}
}
