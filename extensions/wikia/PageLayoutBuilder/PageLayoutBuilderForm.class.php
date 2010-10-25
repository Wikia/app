<?php

class PageLayoutBuilderForm extends SpecialPage {
    function __construct() {
	    wfLoadExtensionMessages( 'PageLayoutBuilder' );	
	    parent::__construct( 'PageLayoutBuilderForm', 'PageLayoutBuilderForm' );
    }

    function execute($article_id = null, $limit = "", $offset = "", $show = true) {
		global $wgRequest, $wgOut, $wgTitle, $wgUser, $wgExtensionsPath;

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

		$wgOut->addStyle( wfGetSassUrl( 'extensions/wikia/PageLayoutBuilder/css/form.scss' ). "?cb=".time() );
		$wgOut->addStyle( wfGetSassUrl( 'skins/oasis/css/core/_EditPage.scss' ) );
		
		$wgOut->addScriptFile($wgExtensionsPath."/wikia/PageLayoutBuilder/widget/allWidgets.js");
		
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
			$this->pageHeader = wfMsg( 'plb-special-form-create-new' );
		}

		$this->layoutTitle = Title::newFromID($this->id);
		if($this->layoutTitle instanceof  Title && $this->layoutTitle->getNamespace() ==  NS_PLB_LAYOUT ) {
			$this->formValues = array();
			$this->formValues['plbId'] = $this->id;
			$this->formValues['pageId'] = $this->pageId;
			$this->formValues['articleName'] = "";$wgRequest->getVal('default', '');
			$this->formErrors = array();

			$oArticle = new Article( $this->layoutTitle );
			$parser = new PageLayoutBuilderParser();
			$parser->setOutputType(OT_HTML);
			$parserOptions = ParserOptions::newFromUser($wgUser);
			$parserOptions->setEditSection(false);
			
			if($wgRequest->wasPosted()) {
				$this->executeSubmit($parser);
			} elseif($this->pageId > 0) {
				$parser->loadForm($this->pageTitle, $this->id );
			} else {
				$this->formValues['articleName'] = $wgRequest->getVal('default', '');
			}

			$text = $parser->preParseForm( $oArticle->getContent() );
			$parserOut = $parser->parse($text , $this->layoutTitle, $parserOptions);

			$html = $parserOut->getText();
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars(array(
				"data" => $this->formValues,
				"errors" => $this->formErrors,
				"title_error" => isset($this->formErrors["title"]),
				"iserror" => !empty($this->formErrors),
				"editmode" => $this->formValues['pageId'] > 0,
				"layout" => $html,
				"url" => $wgRequest->getFullRequestURL(),
				"ispreview" => !empty($this->isPreview) && $this->isPreview,
				"previewdata" => !empty($this->previewData) ? $this->previewData:"",
				"isdelete" => PageLayoutBuilderModel::layoutIsDelete($this->formValues['plbId'])
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
		} else {
			$this->executeIsNolayout();
			return true;
		}
		$wgOut->setPageTitle( $this->pageHeader );
		return true;
    }

	function executeSubmit(&$parser) {
		global $wgRequest, $wgOut;
		
		$articleName = $wgRequest->getVal('wgArticleName', '');
		$elements = PageLayoutBuilderModel::getElementList( $this->layoutTitle->getArticleID() );
		
		$this->formErrors = array();
		$this->formErrorsList = array();
		$tagValues = array();
		$formValue = array();

		if(isset($elements)) {
			foreach($elements as $key => $value) {
				$reqVal = $wgRequest->getVal('plb_'.$key, '');
				$oWidget = LayoutWidgetBase::getNewWidget($value['type'], $value['attributes'], $reqVal);

				$validateResult = $oWidget->validateForm();
				if(!($validateResult === true)) {
					$this->formErrorsList[$key] = 1;
					$this->formErrors = $this->formErrors + $validateResult;
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

		$attribs = $tagValues + array("layout_id" => $this->layoutTitle->getArticleID() );
		$mwText = Xml::element("plb_layout", $attribs, '', false);

		$this->isPreview = false;
		if( $wgRequest->getVal("wpPreview", "") != "" ) {
			$this->isPreview = true;
			$previewParser = new PageLayoutBuilderParser();
			$parserOut = $previewParser->parseForArticlePreview($mwText, $this->mArticle->getTitle() );
			$this->previewData = $parserOut->getText();
			return ;
		}

		if(PageLayoutBuilderModel::layoutIsDelete($this->id)) {
			$preParser = new PageLayoutBuilderParser();
			$parserOut = $preParser->preParserArticle($mwText, $this->mArticle->getTitle() );
			$mwText = $parserOut->getText();
		}
		
		$status = PageLayoutBuilderModel::saveArticle( $this->mArticle, $mwText, $wgRequest->getVal("wpSummary", "") );
		switch( $status ) {
			case EditPage::AS_SUCCESS_UPDATE:
			case EditPage::AS_SUCCESS_NEW_ARTICLE:
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

	public static function alternateEditHook(EditPage &$oEditPage) {
		global $wgOut, $wgUser, $wgTitle;

		if( !($wgTitle->userCan('edit') || $wgTitle->userCan('createpage')) ) {
			return true;
		}

		if( self::articleIsFromPLBFull($oEditPage->mTitle->getArticleID(), $oEditPage->mArticle->getContent() ) ) {
			$layout_id = PageLayoutBuilderModel::articleIsFromPLB( $oEditPage->mTitle->getArticleID() );
			$oSpecialPageTitle = Title::newFromText('PageLayoutBuilderForm', NS_SPECIAL);
			$wgOut->redirect($oSpecialPageTitle->getFullUrl("plbId=" . $layout_id . "&pageId=".$oEditPage->mTitle->getArticleId() ));
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
}