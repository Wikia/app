<?php

class PageLayoutBuilderForm extends SpecialCustomEditPage {
	protected $formValues = array();
	protected $fullScreen = false;
	protected $parser = null; 
	protected $tagValues = false;

	
	public function __construct() {
		parent::__construct( 'PageLayoutBuilderForm', 'PageLayoutBuilderForm' );
	}
	
	public function renderHeader($par) {
		$this->forceUserToProvideTitle( 'plb-special-form-article-name' );
	}
	
		
	public function renderFooter($par) {
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$this->out->addHTML( $oTmpl->render( "create-article-footer" ) );
		
		$rightsText = $this->app->getGlobal('wgRightsText');
		if ( $rightsText ) {
			$copywarnMsg = array( 'copyrightwarning',
				'[[' . wfMsgForContent( 'copyrightpage' ) . ']]',
				$rightsText );
		} else {
			$copywarnMsg = array( 'copyrightwarning2',
				'[[' . wfMsgForContent( 'copyrightpage' ) . ']]' );
		}

		$this->out->wrapWikiMsg( "<div id=\"editpage-copywarn\">\n$1\n</div>", $copywarnMsg );

		$sk = $this->user->getSkin();
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

		$this->out->addHTML( $cancel.$edithelp );
	}	
	
	public function showOwnTextbox() {
		//$html = $parserOut->getText();
		$this->formValues['articleName'] = "dsds";
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars(array(
			"data" => $this->formValues,
			//"errors" => $this->formErrors,
			"title_error" => isset($this->formErrors["title"]),
			"iserror" => !empty($this->formErrors),
			"editmode" => false,//$this->formValues['pageId'] > 0,
			"layout" => $this->formHTML,
			
			//"plbId" => $this->formValues['plbId'], 
			"isdelete" => false//PageLayoutBuilderModel::layoutIsDelete($this->formValues['plbId']),
		));
		
		$this->out->addHTML( $oTmpl->render( "create-article" ) );		
		return true;
	}
	
	protected function getParser(){
		if ($this->parser != null) {
			return $this->parser;
		}
		$parser = new PageLayoutBuilderParser();
		$parser->setOutputType(OT_HTML);
		$this->parser = $parser;
		return $parser;
	}
	
	/**
	 * Perform additional checks when saving an article
	 */
	protected function processSubmit() {

		$this->formErrors = array();
		$this->formErrorsList = array();

		if(isset($elements)) {
			foreach($elements as $key => $value) {
				
				$oWidget = LayoutWidgetBase::getNewWidget($value['type'], $value['attributes'], $reqVal);

				$validateResult = $oWidget->validateForm();
				if(!($validateResult === true)) {
					$this->formErrorsList[$key] = 1;
					if(!in_array($validateResult, $this->formErrors)) {
						$this->formErrors = $this->formErrors + $validateResult;
					}
				}
			}
		} 
		
		$this->getParser()->forceFormValue($this->formValues);
		$this->getParser()->forceFormErrors($this->formErrors);

		
		if($this->mode == self::MODE_NEW || $this->mode == MODE_NEW_SETUP) {
			if ( $this->titleStatus == self::STATUS_ALREADY_EXISTS ) {
				$this->addEditNotice( wfMsg( 'plb-special-form-already-exists' ) );
			}
	
			if ( $this->titleStatus == self::STATUS_EMPTY ) {
				$this->addEditNotice( wfMsg( 'plb-special-form-title-empty' ) );
				
			}
			
			if ( $this->titleStatus == self::STATUS_INVALID ) {
				$this->addEditNotice( wfMsg( 'plb-special-form-invalid-title-error' ) );
			}
		}
	}
	
	protected function getWikitextFromRequest() {
		$this->tagValues = array();
		$this->formValues = array();

		foreach ( $this->elements as $key => $value) {
			$reqVal = $this->request->getVal('plb_'.$key, '');
			$this->formValue[$key] = $reqVal;
			$this->tagValues['val_'.$key] = $reqVal;
		}
		
		if( !empty( $this->pageId ) ) {
			$pageTitle = Title::newFromID($this->pageId);
			$oldValues = $parser->loadForm($pageTitle, $this->layoutTitle->getArticleId() );
			
			foreach($oldValues as $key => $oldValue) {
				if(!isset($tagValues['val_'.$key])){
					$tagValues['val_'.$key] = $oldValue;
				}
			}
		}
		
		$attribs = $this->tagValues + array("layout_id" => $this->layoutTitle->getArticleID(), 'cswikitext' => $this->request->getVal('csWikitext', '') );	
		$mwText = Xml::element("plb_layout", $attribs, '', false);
		
		if (PageLayoutBuilderModel::layoutIsDelete($this->plbId)) {
			$preParser = new PageLayoutBuilderParser();
			$fakeTitle = new FakeTitle();
			$parserOut = $preParser->preParserArticle($mwText, $fakeTitle );
			return $parserOut->getText();
		}
		
		return $mwText;
	}
	
	public function execute( $par ) {
		if( wfReadOnly() ) {
			$this->user->readOnlyPage();
			return;
		}

		if( $this->user->isBlocked() ) {
			$this->out->blockedPage();
			return;
		}	

		$staticChute = new StaticChute('js');
		$staticChute->useLocalChuteUrl();
		$this->out->addScript($staticChute->getChuteHtmlForPackage('yui'));
		$this->out->addScript( AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/EditPageReskin/PageLayoutBuilder/css/form.scss')); 
		$this->out->addScript( AssetsManager::getInstance()->getSassCommonURL('skins/oasis/css/core/_EditPage.scss')); 
		
		$this->out->addScript("<script type=\"text/javascript\" src=\"".$this->app->getGlobal('wgExtensionsPath')."/wikia/EditPageReskin/PageLayoutBuilder/widget/allWidgets.js?".$this->app->getGlobal('wgStyleVersion')."\"></script>");
		
		//close every thing in form 
		$this->out->addHTML(Xml::element("form", array("method" => "POST", "action" => $this->request->getFullRequestURL()."&action=submit"), '', true));
		parent::execute( $par );
		$this->out->addHTML('</form>');
	}
	
	protected function initializeTitle($postedTitle) {
		$this->plbId = (int) $this->getField('plbId',''); // layout ID
		$this->layoutTitle = Title::newFromID($this->plbId);
		
		if($this->plbId == 0 && $this->layoutTitle instanceof  Title && $this->layoutTitle->getNamespace() ==  NS_PLB_LAYOUT ) {
			$this->executeIsNolayout();
			return true;
		}
		
		$this->layoutArticle = new Article($this->layoutTitle);
		
		parent::initializeTitle($postedTitle);
	}
	
	protected function afterArticleInitialize($mode, $title, $article) {
		$this->formValues = array();
		
		$parser = $this->getParser();
		$this->elements = PageLayoutBuilderModel::getElementList( $this->layoutTitle->getArticleID() );
		if ( $mode == self::MODE_EDIT ) {
			if(!$title->userCan('edit')) {
				$this->out->permissionRequired( 'edit' );
				return false;
			}
			
			if( $this->plbId != PageLayoutBuilderModel::articleIsFromPLB( $this->getEditedTitle()->getArticleId() ) ) {
				$this->executeIsNoArtile();
			}
			
			$loadedValues = $parser->loadFormFromText($article->getContent(), $article->getId(), $this->plbId );
		}		
		
		$text = $parser->preParseForm( $this->layoutArticle->getContent() );
		$parserOptions = ParserOptions::newFromUser($this->user);
		$parserOptions->setEditSection(false);
		$parserOut = $parser->parse($text , $this->layoutTitle, $parserOptions);
		$this->formHTML = $parserOut->getText();
		return true;
	}
	
	public function getPageTitle() {
		if ($this->getEditedArticle()->exists()) {
			return wfMsg( 'plb-special-form-edit-article', array("$1" => $this->getEditedTitle()->getText() ));
		} else {
			return wfMsg( 'plb-special-form-create-new',  array( "$1" => $this->layoutTitle->getText() ));
		}
	}

	function executeIsNolayout() {
		global $wgOut;
		$wgOut->showErrorPage( 'plb-special-no-layout', 'plb-special-no-layout-body', array(wfGetReturntoParam()));
	}


	function executeIsNoArtile() {
		global $wgOut;
		$wgOut->showErrorPage( 'plb-special-no-article', 'plb-special-no-article-body', array(wfGetReturntoParam()));
	}
	
	
	static public function blockCategorySelect(){
		global $wgTitle;
		if( self::articleIsFromPLBFull($wgTitle->getArticleID(), "") ) {
			return false;
		}
		return true;
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

	
	function afterSave( $status ) {
		switch( $status ) {
			case EditPage::AS_SUCCESS_UPDATE:
			case EditPage::AS_SUCCESS_NEW_ARTICLE:
			case EditPage::AS_ARTICLE_WAS_DELETED:
				PageLayoutBuilderModel::articleMarkAsPLB( $this->getEditedArticle()->getID(), $this->layoutTitle->getArticleID() );
				$this->getEditedArticle()->getTitle()->invalidateCache();
				$this->out->redirect($this->getEditedArticle()->getTitle()->getFullUrl());
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
}


class PageLayoutBuilderFormXXX extends SpecialPage {
    function __construct() {
	    wfLoadExtensionMessages( 'PageLayoutBuilder' );
	    parent::__construct( 'PageLayoutBuilderForm', 'PageLayoutBuilderForm' );
	}
    function execute($article_id = null, $limit = "", $offset = "", $show = true) {
		global $wgRequest, $wgOut, $wgTitle, $wgUser, $wgExtensionsPath, $wgScriptPath, $wgStyleVersion;

		$this->pageId = (int) $wgRequest->getVal('pageId', ''); // article ID

		//TODO: rename vars

		if($this->pageId > 0) {

			
			
		} else {

		}

		
		if($this->layoutTitle instanceof  Title && $this->layoutTitle->getNamespace() ==  NS_PLB_LAYOUT ) {
			
			
			$this->formValues['articleName'] = "";$wgRequest->getVal('default', '');
			$this->formErrors = array();

			if(!($this->pageId > 0)) {
				
			}


			$pageTs = "";
			if($wgRequest->wasPosted()) {
				$this->executeSubmit($parser);
			} elseif($this->pageId > 0) {
				$pageArticle = new Article($this->pageTitle);
				$editPage = new EditPage( $pageArticle );
				
				$pageTs = $pageArticle->getTimestamp(); 
			} else {
				$this->formValues['articleName'] = $wgRequest->getVal('default', '');
			}


			if($this->isCategorySelect()) {
				global $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgCategorySelectMetaData,$wgHooks,$wgRequest;
				$cssFile = wfGetSassUrl('/extensions/wikia/EditPageReskin/CategorySelect/oasis.scss');
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

			//TODO: move this to template



		} else {
			
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

		$status = PageLayoutBuilderModel::saveArticle( $this->mArticle, $mwText,  $wgRequest->getVal('wpEdittime'), $wgRequest->getVal("wpSummary", "") );
		switch( $status ) {
			case EditPage::AS_SUCCESS_UPDATE:
			case EditPage::AS_SUCCESS_NEW_ARTICLE:
			case EditPage::AS_ARTICLE_WAS_DELETED:
				PageLayoutBuilderModel::articleMarkAsPLB( $this->mArticle->getID(), $this->layoutTitle->getArticleID() );
				$this->mArticle->getTitle()->invalidateCache();
				$wgOut->redirect($this->mArticle->getTitle()->getFullUrl() );
				break;
			default:
				if( $status == EditPage::AS_READ_ONLY_PAGE_LOGGED ) {
					$this->addEditNotice( wfMsg('plb-special-form-cant-edit') );
				}
				else {
					$this->addEditNotice( wfMsg('plb-special-form-spam') );
				}
				break;
		}
	}
}
