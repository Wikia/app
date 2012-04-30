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
		$errors = $this->mEditPage->getNotices();

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars(array(
			"errors" => $errors,
			"iserror" => !empty($errors)
		));

		$this->out->addHTML( $oTmpl->render( "create-article-header" ) );

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
		$parser = $this->getParser();
		$text = $parser->preParseForm( $this->layoutArticle->getContent() );
		$parserOptions = ParserOptions::newFromUser($this->user);
		$parserOptions->setEditSection(false);
		$parserOut = $parser->parse($text , $this->layoutTitle, $parserOptions);
		$this->formHTML = $parserOut->getText();

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

		$formErrors = array();
		$formErrorsList = array();
		$formValues = array();

		if(isset($this->elements)) {
			foreach($this->elements as $key => $value) {
				$reqVal = $this->request->getVal('plb_'.$key, '');
				$formValues[$key] = $reqVal;
				$oWidget = LayoutWidgetBase::getNewWidget($value['type'], $value['attributes'], $reqVal);

				$validateResult = $oWidget->validateForm();
				if(!($validateResult === true)) {
					$formErrorsList[$key] = 1;
					if(!in_array($validateResult, $formErrors)) {
						$formErrors = $formErrors + $validateResult;
					}
				}
			}
		}

		if(count($formErrors) > 0) {
			foreach($formErrors as $val) {
				$this->addEditNotice(  $val );
			}
		}

		$this->getParser()->forceFormValue($formValues);
		$this->getParser()->forceFormErrors($formErrorsList);

		if($this->mode == self::MODE_NEW || $this->mode == self::MODE_NEW_SETUP) {
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

	public function getWikitextFromRequest() {
		if (!$this->layoutTitle instanceof  Title) {
			// mech: bugid 18307
			// if layout is missing, display an error message instead of the wiki text
			Wikia::logBacktrace(__METHOD__);
			return wfMsg( 'plb-special-no-layout-body' );
		}
		$this->tagValues = array();
		$this->formValues = array();

		$this->elements = PageLayoutBuilderModel::getElementList( $this->layoutTitle->getArticleID() );

		foreach ( $this->elements as $key => $value) {
			$reqVal = $this->request->getVal('plb_'.$key, '');
			$this->formValue[$key] = $reqVal;
			$this->tagValues['val_'.$key] = $reqVal;
		}

		if( !empty( $this->pageId ) ) {
			$pageTitle = Title::newFromID($this->pageId);
			$oldValues = $this->parser->loadForm($pageTitle, $this->layoutTitle->getArticleId() );

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
			$this->out->readOnlyPage();
			return;
		}

		if( $this->user->isBlocked() ) {
			$this->out->blockedPage();
			return;
		}

		$yuiUrl = array_pop(AssetsManager::getInstance()->getGroupCommonURL('yui', array(), true /* $combine */, true /* $minify */));
		$this->out->addScript($yuiUrl);

		$this->out->addStyle( AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/PageLayoutBuilder/css/form.scss'));
		$this->out->addStyle( AssetsManager::getInstance()->getSassCommonURL('skins/oasis/css/core/EditPage.scss'));

		if (class_exists('RTE')) RTE::disableEditor();

		$js = array(
			'/wikia/PageLayoutBuilder/widget/allWidgets.js',
			'/wikia/EditPageLayout/js/editor/WikiaEditor.js',
			'/wikia/EditPageLayout/js/plugins/PageControls.js',
			'/wikia/PageLayoutBuilder/js/form.js',
			'/wikia/EditPageLayout/js/loaders/LayoutBuilderFormEditorLoader.js'
		);

		foreach( $js as $val ) {
			$this->out->addScript("<script type=\"text/javascript\" src=\"".$this->app->getGlobal('wgExtensionsPath'). $val . '?' .$this->app->getGlobal('wgStyleVersion')."\"></script>");
		}

		//close every thing in form
		$this->out->addHTML(Xml::element("form", array("method" => "POST", "action" => $this->request->getFullRequestURL()."&action=submit"), '', true));
		parent::execute( $par );
		$this->out->addHTML('</form>');
	}

	protected function initializeTitle($postedTitle) {
		$this->plbId = (int) $this->getField('plbId',''); // layout ID
		$this->layoutTitle = Title::newFromID($this->plbId);

		if($this->plbId == 0 || (!$this->layoutTitle instanceof  Title) || $this->layoutTitle->getNamespace() !=  NS_PLB_LAYOUT ) {
			$this->executeIsNolayout();
			return false;
		}

		$this->layoutArticle = new Article($this->layoutTitle);

		parent::initializeTitle($postedTitle);
	}

	protected function afterArticleInitialize($mode, $title, $article) {
		$this->formValues = array();
		$parser = $this->getParser();
		if ( $mode == self::MODE_EDIT ) {
			if(!$title->userCan('edit')) {
				$this->out->permissionRequired( 'edit' );
				return false;
			}

			if( $this->plbId != PageLayoutBuilderModel::articleIsFromPLB( $this->getEditedTitle()->getArticleId() ) ) {
				$this->executeIsNoArtile();
			}

			$loadedValues = $parser->loadFormFromText($this->getEditPage()->getContent(), $article->getId(), $this->plbId );
		}
		if(!empty($loadedValues['cswikitext'])) {
			CategorySelect::SelectCategoryAPIgetData($loadedValues['cswikitext'], true);
		}

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
		$this->out->showErrorPage( 'plb-special-no-layout', 'plb-special-no-layout-body', array(wfGetReturntoParam()));
	}


	function executeIsNoArtile() {
		$this->out->showErrorPage( 'plb-special-no-article', 'plb-special-no-article-body', array(wfGetReturntoParam()));
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
					$this->addEditNotice(wfMsg('plb-special-form-cant-edit'));
				}
				else {
					$this->addEditNotice(wfMsg('plb-special-form-spam'));
				}
				break;
		}
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

	public static function getEditPageRailModuleList(&$modules) {
		global $wgTitle;
		if( $wgTitle->isSpecial('PageLayoutBuilderForm') ) {
			$modules = array (
				1501 => array('Search', 'Index', null),
				1500 => array('PageLayoutBuilderForm', 'Index', null));
		}
		return true;
	}
}