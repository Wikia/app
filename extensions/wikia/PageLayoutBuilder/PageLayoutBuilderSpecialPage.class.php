<?php

class SpecialPageLayoutBuilder extends SpecialCustomEditPage {
	const FIELD_TITLE = 'wpTitle';
	const FIELD_DESCRIPTION = 'wpDescription';
	const FIELD_PAGE_ID = 'plbId';
	const FIELD_PRELOAD_ARTICLE_ID = 'defaultPageId';
	const FIELD_DEFAULT_TITLE = 'default';
	const FIELD_BUTTON_SAVE_DRAFT = 'wpSaveDraft';
	const FIELD_BUTTON_PREVIEW_FORM = 'wpPreviewForm';

	const ACTION_EDIT = 'edit';
	const ACTION_SUBMIT = 'submit';
	const ACTION_CREATE_FROM_ARTICLE = 'createfromarticle';

	protected $titleNS = NS_PLB_LAYOUT;

	protected $descriptionStatus = self::STATUS_OK;
	protected $editingMode = self::MODE_UNKNOWN;
	protected $preloadedText = false;
	protected $pageIdFieldName = self::FIELD_PAGE_ID;
	protected $titleFieldName = self::FIELD_TITLE;

	public function __construct() {
		parent::__construct( 'PageLayoutBuilder', 'plbmanager' );
		// add messages (fetch them using <script> tag)
		F::build('JSMessages')->enqueuePackage('PageLayoutBuilder', JSMessages::EXTERNAL);
	}

	protected function getWikitextForPreload() {
		return $this->preloadedText;
		/** for futrure use (COPY)
		$contents = '';
		if ($this->editingMode == self::MODE_NEW_SETUP) {
			// Read the initial layout content from another article
			$sourceArticleId = $this->request->getVal(self::FIELD_PRELOAD_ARTICLE_ID, '');
			$sourceArticletitle = Title::newFromID($sourceArticleId);
			if (($sourceArticletitle instanceof Title) && ($sourceArticletitle->getNamespace() == NS_PLB_LAYOUT) ) {
				$sourceArticle = new Article( $sourceArticletitle );
				$contents = $sourceArticle->getContent();
			}
		}
		return !empty($contents) ? $contents : false;
		*/
	}

	protected function initializeEditPage() {
		$editPage = parent::initializeEditPage();
		if ($this->action == self::ACTION_CREATE_FROM_ARTICLE) {
			$editPage->mPreventSave = true;
		}
		//use by alternateEditHook to prevent redirect
		$editPage->isLayoutBuilderEditPage = true;
		return $editPage;
	}

	protected function afterArticleInitialize($mode, $title, $article) {
		$this->description = null;
		$this->isNoPublish = false;
		if( $mode == self::MODE_EDIT ) {
			$prop = PageLayoutBuilderModel::getProp( $article->getID() );
			$this->isNoPublish =  PageLayoutBuilderModel::layoutIsNoPublish( $article->getID() );
			$this->description = $prop['desc'];
		}

		if ( $mode == self::MODE_NEW_SETUP || $mode == self::MODE_NEW ) {
			$this->isNoPublish = true;
			if( $this->action == self::ACTION_CREATE_FROM_ARTICLE ) {
				$this->preloadedText = $this->getWikitextFromRequest();
			}
		}
	}

	protected function getDefaultTitle() {
		$titleText = trim( $this->getField(self::FIELD_DEFAULT_TITLE, '') );

		if ( !empty( $titleText ) ) {
			$title =  Title::newFromText($titleText, $this->titleNS);
			return $title;
		}

		return parent::getDefaultTitle();
	}

	public function getPageTitle() {
		if ($this->getEditedArticle()->exists()) {
			return wfMsg( 'plb-create-edit-title', array("$1" => $this->getEditedTitle()->getText() ));
		} else {
			return wfMsg( 'plb-create-new-title' );
		}
	}

	public function renderHeader($par) {
		$this->out->addScriptFile( $this->app->getGlobal('wgExtensionsPath') . "/wikia/PageLayoutBuilder/js/editor.js" );
		$this->out->addScriptFile( $this->app->getGlobal('wgScript') . "?action=ajax&rs=PageLayoutBuilderEditor::getPLBEditorData&uselang=" . $this->app->getGlobal('wgLang')->getCode()
			. "&cb=" . time() );
		$this->out->addScriptFile( $this->app->getGlobal('wgExtensionsPath')  . "/wikia/PageLayoutBuilder/widget/allWidgets.js" );

		$this->loadTitleFromRequest = false;

		$this->forceUserToProvideTitle('plb-create-new-modal-title');

		$this->addHiddenField(array(
			'name' => self::FIELD_DESCRIPTION,
			'type' => 'textarea',
			'label' => wfMsg('plb-form-desc'),
			'valuefromrequest' => self::FIELD_DESCRIPTION,
			'value' => $this->description,
			'required' => true
		));
	}

	/**
	 * Perform additional checks when saving an article
	 */

	protected function processSubmit() {
		if ($this->mode != self::MODE_NEW_SETUP) {
			if ($this->contentStatus == EditPage::AS_BLANK_ARTICLE) {
				$this->addEditNotice(wfMsg('plb-create-empty-body-error'));
			}

			switch ($this->titleStatus) {
				case self::STATUS_EMPTY:
					$this->addEditNotice(wfMsg( 'plb-create-empty-title-error' ));
					break;
				case self::STATUS_INVALID:
					$this->addEditNotice(wfMsg( 'plb-create-invalid-title-error' ));
					break;
				case self::STATUS_ALREADY_EXISTS:
					$this->addEditNotice(wfMsg( 'plb-create-already-exists-error' ));
					break;
			}

			switch ($this->descriptionStatus) {
				case self::STATUS_EMPTY:
					$this->addEditNotice(wfMsg( 'plb-create-empty-desc' ));
					break;
			}

		}
	}


	public function getOwnPreviewDiff( $wikitext, $method ) {
		if($method == 'preview') {
			if (empty($type)) {
				$type = $this->request->getVal('type');
			}
			if (!in_array($type,array('form','article'))) {
				$type = 'article';
			}

			$html = '';
			$title = $this->getEditedArticle()->getTitle();
			$parser = F::build('PageLayoutBuilderParser');
			$parserOutput = $parser->parseForLayoutPreview( $this->getWikitextFromRequest(), $title, $type);
			$html = $parserOutput->getText();

			if ($type == "form") {
				if (strlen(trim($html)) == 0) {
					$html = XML::element("div",array(
						"class" => "plb-form-errorbox" ),
						wfMsg('plb-special-form-emptyformpreview')
					);
				}
			}
			return $html;
		}
		return false;
	}

	public function execute( $par ) {

		if( !$this->user->isLoggedIn() ) {
			$this->out->showErrorPage( 'plb-special-no-login', 'plb-login-required', array(wfGetReturntoParam()));
			return;
		}

		if( $this->user->isBlocked() ) {
			$this->out->blockedPage();
			return;
		}

		if( wfReadOnly() ) {
			$this->out->readOnlyPage();
			return;
		}

		if(!$this->user->isAllowed( 'plbmanager' )) {
			$this->out->permissionRequired( 'plbmanager' );
			return;
		}

		$this->out->addStyle( AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/PageLayoutBuilder/css/editor.scss'));
		$this->out->addStyle( AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/PageLayoutBuilder/css/form.scss'));

		$action = $this->request->getVal('action','');
		if ($action == 'list') {
			$this->out->addScriptFile(  $this->app->getGlobal('wgExtensionsPath')."/wikia/PageLayoutBuilder/js/list.js");
			$this->out->addStyle( AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/PageLayoutBuilder/css/list.scss'));
			$this->executeList();
			return;
		}

		parent::execute($par);
	}

	protected function afterSave( $status ) {
		switch( $status ) {
			case EditPage::AS_SUCCESS_UPDATE:
			case EditPage::AS_SUCCESS_NEW_ARTICLE:
				$addData = array(
					'desc' => $this->getField(self::FIELD_DESCRIPTION)
				);
				/* Wikia change begin - @author: Marcin, #BugId: 9472 */
					//removed substring function in line
					//'desc' => substr($this->getField(self::FIELD_DESCRIPTION),0,255)
				/* Wikia change end */

				$article = $this->getEditedArticle();
				$articleId = $article->getID();
				PageLayoutBuilderModel::setProp($articleId, $addData);

				$elementList = empty($this->app->wg->Parser->mPlbFormElements) ? array():$this->app->wg->Parser->mPlbFormElements;

				PageLayoutBuilderModel::saveElementList($articleId, $elementList);

				$published = true;
				if ($status == EditPage::AS_SUCCESS_NEW_ARTICLE || PageLayoutBuilderModel::layoutIsNoPublish($articleId)) {
					$published = !($this->request->getVal(self::FIELD_BUTTON_SAVE_DRAFT,false));
				}

				if ($published) {
					PageLayoutBuilderModel::layoutUnMarkAsNoPublish($articleId);
				} else {
					PageLayoutBuilderModel::layoutMarkAsNoPublish($articleId);
				}

				$this->out->redirect( Title::newFromText( "LayoutBuilder", NS_SPECIAL )->getFullUrl("action=list") );
				break;
		}
	}

	protected function setUpControlButtons() {
		$buttons = $this->mEditPage->getControlButtons();
		$buttons = array_merge(array(
			array(
				'type' => 'submit',
				'name' => self::FIELD_BUTTON_SAVE_DRAFT,
				'caption' => wfMsg('plb-special-form-save-as-draft'),
				'disabled' => !$this->isNoPublish,
			),
			$buttons[1],
			array(
				'name' => self::FIELD_BUTTON_PREVIEW_FORM,
				'caption' => wfMsg('plb-special-form-preview-form'),
				'className' => 'secondary',
			),
		),array($buttons[0]),array_slice($buttons,2));
		$this->mEditPage->setControlButtons($buttons);
	}

	/**
	 * execute - View a list of layouts
	 *
	 * @author Tomek Odrobny
	 * @access public
	 *
	 */
	function executeList() {
		global $wgRequest, $wgOut, $wgTitle, $wgUser, $wgBlankImgUrl, $wgContLang;
		$jsMsg = array(
                        'plb_list_confirm_delete' => wfMsg('plb-list-confirm-delete'),
                        'plb_list_confirm_publish' => wfMsg('plb-list-confirm-publish')
		);
		$script = "";
		foreach ($jsMsg as $key => $value) {
			$script .= "var ".$key." = ".Xml::encodeJsVar($value).";\n";
		}
		$wgOut->addScript("<script type='text/javascript'>".$script."</script>" );
		if($wgRequest->wasPosted()) {
			if($wgRequest->getVal("subaction") == "publish") {
				$this->executeListpublish($wgRequest);
			}
			if($wgRequest->getVal("subaction") == "delete") {
				$this->executeListDelete($wgRequest);
			}
			$out = PageLayoutBuilderModel::getListOfLayout(DB_MASTER);
		} else {
			$out = PageLayoutBuilderModel::getListOfLayout();
		}
		$button = "<a id='plbNewButton' class='wikia-button' href='".Title::newFromText( "LayoutBuilder", NS_SPECIAL )->getFullURL()."'>".
		XML::element("img",array( "class" => "sprite new", "src" => $wgBlankImgUrl)).wfMsg('plb-special-form-new')."</a>";
		$msg = wfMsg("plb-list-title", array("$1" => count($out) ) );
		$wgOut->setPageTitle( $msg );
		$wgOut->mPagetitle = $msg . $button; //1.16 trick
		$allowcopy = false;
		global $wgDefaultLayoutWiki, $wgCityId;
		if($wgDefaultLayoutWiki == $wgCityId && $wgUser->isAllowed( 'plbmanagercopy' )) {
			$allowcopy = true;
		}
		$title = Title::newFromText('LayoutBuilder', NS_SPECIAL);
		foreach( $out as $key => $value ) {
			$out[$key]['page_title_escaped'] = htmlspecialchars($out[$key]['page_title']);
			$out[$key]['page_actions']['edit'] = array(
                                "link" => $title->getFullURL('plbId='.$value['page_id'] ),
                                "name" => XML::element("img",array( "class" => "sprite edit-pencil", "src" => $wgBlankImgUrl)).wfMsg("plb-list-action-edit"),
                                "class" => "edit wikia-button secondary",
                                "separator" => 1,
			);
			if($value['not_publish']) {
				$out[$key]['page_actions']['publish'] = array(
                                        "link" => "#plbId-".$value['page_id'],
                                        "name" => wfMsg("plb-list-action-publish"),
                                        "class" => "publish",
                                        "separator" => 1,
				);
			}
			$out[$key]['page_actions']['create'] = array(
                                "link" => Title::newFromText('LayoutBuilderForm', NS_SPECIAL)->getFullURL("plbId=".$value['page_id']),
                                "name" => wfMsg("plb-list-action-create"),
                                "class" => "create",
                                "separator" => 1,
			);
			if($allowcopy) {
				$out[$key]['page_actions']['copy'] = array(
                                        "link" => $title->getFullURL('action=layoutCopy&plbId='.$value['page_id'] ),
                                        "name" => XML::element("img",array("class" => "", "src" => $wgBlankImgUrl)).wfMsg("plb-list-action-copy"),
                                        "separator" => 1,
                                        "class" => ""
                                        );
			}
			$out[$key]['page_actions']['delete'] = array(
                                "link" => "#plbId-".$value['page_id'],
                                "class" => "delete",
                                "name" => '<img src="'.$wgBlankImgUrl.'" class="sprite trash"/>',
                                "separator" => 0,
			);
			$out[$key]['profile_name'] = $value['rev_user']->getName();
			$out[$key]['profile_link'] = AvatarService::getUrl($out[$key]['profile_name']);
			$out[$key]['profile_avatar'] = AvatarService::renderAvatar($out[$key]['profile_name'], 20);
			$out[$key]['edit_date'] = $wgContLang->date( $out[$key]['rev_timestamp'] );
			$out[$key]['page_title'] = str_replace("_", " ", $out[$key]['page_title']);
		}
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars(array(
                    "data" => $out,
                        'allowcopy' => $allowcopy,
                        "newlink" => Title::newFromText( "LayoutBuilder", NS_SPECIAL )->getFullURL()
		));
		$wgOut->addHTML( $oTmpl->render("plb-list") );
		return true;
	}

	function executeLayoutCopy($request) {
		global $wgOut, $wgExtensionsPath, $wgUser, $wgDefaultLayoutWiki, $wgCityId;
		if(!($wgDefaultLayoutWiki == $wgCityId && $wgUser->isAllowed( 'plbmanagercopy' ))) {
			$wgOut->showErrorPage( 'plb-special-no-login', 'plb-login-required', array(wfGetReturntoParam()));
		}
		$wgOut->addScriptFile($wgExtensionsPath."/wikia/PageLayoutBuilder/js/copy.js");
		$hubs = WikiFactoryHub::getInstance();
		$hubs = $hubs->getCategories();
		$hubs_select = array( );
		$selectedCatsWithNames = array();
		$selectedCats = PageLayoutBuilderModel::getCopyCatIds( (int) $request->getVal('plbId')  );
		if ( !empty($hubs) ) {
			foreach ($hubs as $id => $hub_options) {
				$catsSelect[$hub_options['name']] = $id ;
				if(in_array( $id, $selectedCats )) {
					$selectedCatsWithNames[$id] = $hub_options['name'];
				}
			}
		}
		$fields = array( 'cat_select' => array(
                                'class' => 'HTMLSelectField',
                                'label-message' => 'plb-copy-cat-add',
                                'options' => $catsSelect,
		));
		if(!$wgUser->isAllowed( 'plbmanagercopy' )) {
			$wgOut->permissionRequired( 'plbmanagercopy' );
			return true;
		}
		$form = new HTMLForm($fields);
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars(array(
                    "cat_select" => $form->getBody(),
                        "selected_cats" =>      $selectedCatsWithNames
		));
		$cat_ids = array();
		if($request->wasPosted()) {
			$values = $request->getArray('cat_ids');
			foreach($values as $value) {
				$cat_ids[$value] = $value;
			}
			PageLayoutBuilderModel::setCopyCatIds( (int) $request->getVal('plbId'), array_keys($cat_ids) );
			$wgOut->redirect( Title::newFromText( "LayoutBuilder", NS_SPECIAL )->getFullUrl("action=list") );
		}
		$wgOut->addHTML( $oTmpl->render("plb-copy-layout") );
	}

	/**
	 * Mark the layout as removed
	 *
	 * @author Tomek Odrobny
	 */
	protected function executeListDelete($request) {
		$plbId = intval( $request->getVal(self::FIELD_PAGE_ID) );
		PageLayoutBuilderModel::layoutMarkAsDelete($plbId);
	}

	/**
	 * Mark the layout as published
	 *
	 * @author Tomek Odrobny
	 */
	protected function executeListPublish($request) {
		$plbId = intval( $request->getVal(self::FIELD_PAGE_ID) );
		PageLayoutBuilderModel::layoutUnMarkAsNoPublish($plbId);
	}

	/**
	 * parseForm - Validation of request params
	 *
	 * @author Tomek Odrobny
	 *
	 * @access public
	 *
	 */
	static public function addFormButton(&$self, &$buttons, &$tabindex) {
		if($self->mTitle->getNamespace() != NS_PLB_LAYOUT) {
			return true;
		}
		$buttons_out = array();

		$buttons_out['save'] = XML::element(
				"input",
				array(
					"id" => "wpSave",
					"name" => "wpSave",
					"type" => "submit",
					"tabindex" => 5,
					"value" => wfMsg('plb-create-button-layout'),
					"title" => wfMsg('plb-create-button-layout-title')
				)
			);

		if(PageLayoutBuilderSpecialPage::isDraft($self->mArticle)) {
			$buttons_out['draft'] = XML::element(
				"input",
				array(
					"id" => "wpDraft",
					"name" => "wpDraft",
					"type" => "submit",
					"value" => wfMsg('plb-create-button-draft'),
					"title" => wfMsg('plb-create-button-draft-title')
				)
			);
		}

		$buttons_out['previewform'] = XML::element(
			"input",
			array(
				"id" => "wpPreviewform",
				"name" => "wpPreviewform",
				"type" => "submit",
				"value" => wfMsg('plb-create-button-previewform'),
				"title" => wfMsg('plb-create-button-previewform-title')
			)
		);

		$buttons_out['previewarticle'] = XML::element(
			"input",
			array(
				"id" => "wpPreviewarticle",
				"name" => "wpPreviewarticle",
				"type" => "submit",
				"value" => wfMsg('plb-create-button-previewarticle'),
				"title" => wfMsg('plb-create-button-previewarticle-title')
			)
		);


		$buttons = $buttons_out;
		return true;
	}

	/**
	 * rollbackHook
	 *
	 * @author Tomek Odrobny
	 *
	 * @access public
	 *
	 */
	static public function onArticleRollbackComplete(&$article, $user, $revision) {
		if($revision->getTitle()->getNamespace() != NS_PLB_LAYOUT) {
			return true;
		}
		$parser = new PageLayoutBuilderParser();
		$out = $parser->parseForLayoutPreview($revision->getRawText(), $revision->getTitle());
		PageLayoutBuilderModel::saveElementList($revision->getTitle()->getArticleId(), $out->mPlbFormElements);
		return true;
	}
}
