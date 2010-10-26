<?php

class PageLayoutBuilderSpecialPage extends SpecialPage {
	private $isFromDb = false;
    function __construct() {
	    wfLoadExtensionMessages( 'PageLayoutBuilder' );
		$this->mFormData = array();
		$this->mFormErrors = array();

		$this->mFormFields = array(
			'title' => 'wgTitle',
			'desc' => 'wgDesc',
			'body' => 'wpTextbox1',
			'summary' => 'wpSummary',
			'watchthis' => 'wpWatchthis',
			'minoredit'	=>	'wpMinoredit',
			'plbId' => 'wpPlbId'
		);

		/*init empty array will be easy use in template (no empty etc.) */
		foreach ($this->mFormFields as $key => $value ) {
			$this->mFormData[$key] = "";
		}

	    parent::__construct( 'PageLayoutBuilder', 'PageLayoutBuilder' );
    }

    function execute($article_id = null, $limit = "", $offset = "", $show = true) {
		global $wgRequest, $wgOut, $wgTitle, $wgUser, $wgExtensionsPath;

		if( !$wgUser->isLoggedIn() ) {
			$wgOut->showErrorPage( 'plb-special-no-login', 'plb-login-required', array(wfGetReturntoParam()));
			return;
		}

		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		if(!$wgUser->isAllowed( 'plbmanager' )) {
			$wgOut->permissionRequired( 'plbmanager' );
			return true;
		}
		
		//TODO: remove it
		//TODO: merge editor and form files
		$wgOut->addStyle( wfGetSassUrl( 'extensions/wikia/PageLayoutBuilder/css/editor.scss' ) . "?cb=".time()  );
		$wgOut->addStyle( wfGetSassUrl( 'extensions/wikia/PageLayoutBuilder/css/form.scss' ) . "?cb=".time()  );
		
		$action = $wgRequest->getVal("action");
		if($action == 'list') {
			$wgOut->addScriptFile($wgExtensionsPath."/wikia/PageLayoutBuilder/js/list.js");
			$this->executeList();
			return true;
		}
		
		$wgOut->addScriptFile( $wgExtensionsPath."/wikia/PageLayoutBuilder/js/editor.js" );

		if($wgRequest->wasPosted() && ($wgRequest->getVal("action") == "submit") ) {
			if($this->parseForm()) {
				switch($this->getPostType()) {
					case 'save':
						if($this->save()) {
							PageLayoutBuilderModel::layoutUnMarkAsNoPublish($this->mArticle->getId());
							$wgOut->redirect( Title::newFromText( "PageLayoutBuilder", NS_SPECIAL )->getFullUrl("action=list") );
							return true;
						}
					break;
					case 'previewform':
						$this->renderPreview('form');
					break;
					case 'previewarticle':
						$this->renderPreview('article');
					break;
					case 'draft':
						if(self::isDraft($this->mArticle) && $this->save()) {
							PageLayoutBuilderModel::layoutMarkAsNoPublish($this->mArticle->getId());
							$wgOut->redirect( Title::newFromText( "PageLayoutBuilder", NS_SPECIAL )->getFullUrl("action=list") );
							return true;
						}
					break;
				}

			}
		} else {
			$this->mTitle = Title::newFromID((int) $wgRequest->getVal('plbId',''));
			if($this->mTitle instanceof Title && $this->mTitle->getNamespace() ==  NS_PLB_LAYOUT ) {
				$this->loadFromDB( $this->mTitle );
			} else {
				if($wgRequest->getVal("action") == "createfromarticle") {
					$this->getEmptyArticle($wgRequest->getVal('wpTextbox1'));
					$this->fixRTE();
					$this->mEditPage->textbox1 = $wgRequest->getVal('wpTextbox1');
				} else {
					$this->getEmptyArticle();
				}
			}
		}

		if( $this->isCategorySelect() ) {
			$wgRequest->setVal('action', 'edit');
			CategorySelectInit(true);
			CategorySelectInitializeHooks(null, null, $this->mTitle, null, null, true);
		}
		
		$this->renderCreatePage();
		return true;
    }

	function executeList() {
		global $wgRequest, $wgOut, $wgTitle, $wgUser, $wgExtensionsPath, $wgBlankImgUrl, $wgContLang;

		$jsMsg = array(
			'plb_list_confirm_delete' => wfMsg('plb-list-confirm-delete'),
			'plb_list_confirm_publish' => wfMsg('plb-list-confirm-publish')
		);

		$script = "";
		foreach ($jsMsg as $key => $value) {
			$script .= "var ".$key." = ".Xml::encodeJsVar($value).";\n";
		}

		$wgOut->addScript("<script 'type' = 'text/javascript'>".$script."</script>" );

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


		$wgOut->setPageTitle( wfMsg("plb-list-title", array("$1" => count($out) ) ) );

		$title = Title::newFromText('PageLayoutBuilder', NS_SPECIAL);
		foreach( $out as $key => $value ) {
			$out[$key]['page_actions']['edit'] = array(
				"link" => $title->getFullURL('plbId='.$value['page_id'] ),
				"name" => XML::element("img",array("src" => $wgBlankImgUrl)).wfMsg("plb-list-action-edit"),
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
				"link" => Title::newFromText('PageLayoutBuilderForm', NS_SPECIAL)->getFullURL("plbId=".$value['page_id']),
				"name" => wfMsg("plb-list-action-create"),
				"class" => "create",
				"separator" => 1,
			);

			$out[$key]['page_actions']['delete'] = array(
				"link" => "#plbId-".$value['page_id'],
				"name" => "",//wfMsg("plb-list-action-delete"),
				"class" => "delete",
				"separator" => 0,
			);

			$out[$key]['profile_name'] = $value['rev_user']->getName();
			$out[$key]['profile_link'] = AvatarService::getUrl($out[$key]['profile_name']);
			$out[$key]['profile_avatar'] = AvatarService::renderAvatar($out[$key]['profile_name'], 20);
			$out[$key]['edit_date'] = $wgContLang->date( $out[$key]['rev_timestamp'] );
		}
		

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars(array(
		    "data" => $out,
			"newlink" => Title::newFromText( "PageLayoutBuilder", NS_SPECIAL )->getFullURL()
		));
		$wgOut->addHTML( $oTmpl->render("plb-list") );
		return true;
	}

	function executeListDelete($request) {
		$plbId = (int) $request->getVal('plbId');
		PageLayoutBuilderModel::layoutMarkAsDelete($plbId);
	}

	function executeListpublish($request) {
		$plbId = (int) $request->getVal('plbId');
		PageLayoutBuilderModel::layoutUnMarkAsNoPublish($plbId);
	}

	public function renderFormHeader() {
		global $wgOut, $wgScriptPath;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

		$this->editTitle2 = "";
		if(isset($this->previewOut)) {
			$this->editTitle1 = wfMsg('plb-create-preview-title', array("$1" => $this->mTitle->getText() )); 
			$this->editTitle2 = wfMsg('plb-create-edit-title', array("$1" => $this->mTitle->getText() ));
		} else {
			if(!$this->isFromDb) {
				$this->editTitle1 = wfMsg( 'plb-create-new-title' );				
			} else {
				$this->editTitle1 = wfMsg('plb-create-edit-title', array("$1" => $this->mTitle->getText() ));
			}
		}

		$wgOut->setPageTitle( strip_tags($this->editTitle1) );;
		$wgOut->setHTMLTitle($this->editTitle1 );
		$wgOut->addScript( '<script type="text/javascript" src="' . $wgScriptPath . '/skins/common/edit.js"><!-- edit js --></script>');

		$oTmpl->set_vars(array(
		    "data" => $this->mFormData,
			"iserror" => (count($this->mFormErrors) > 0),
			"errors" => $this->mFormErrors,
			"ispreview" => isset($this->previewOut),
			"title2" =>	$this->editTitle2,
			"showtitle"  => !(!empty($this->isFromDb) && $this->isFromDb),
			"previewdata" =>  isset($this->previewOut) ?  $this->previewOut:""
		));
		$wgOut->addHTML( $oTmpl->render("create-form") );
	}

	private function renderPreview($type = 'form' ) {
		global  $wgOut;
		$title = $this->mArticle->getTitle();
		$parser = new PageLayoutBuilderParser();
		$parserOut = $parser->parseForLayoutPreview( $this->mEditPage->textbox1, $title, $type);
		$this->previewOut =  $parserOut->getText();
	}

	private function renderCreatePage() {
		if( $this->isCategorySelect() ) {
			CategorySelectReplaceContent( $this->mEditPage, $this->mEditPage->textbox1 );
		}
		$this->mEditPage->showEditForm( array($this, 'renderFormHeader') );
	}

	private function getEmptyArticle() {
		global $wgRequest;

		$default = $wgRequest->getVal('default', '');
		$this->mFormData['title'] = $default;

		$defultContent = $wgRequest->getVal('defaultPageId', '');
		$defultContentTitle = Title::newFromID($defultContent);

		if(($defultContentTitle instanceof  Title) && ($defultContentTitle->getNamespace() == NS_PLB_LAYOUT) ) {
			$this->mArticle = new Article( $this->mTitle );
			$defultContent = $this->mArticle->getContent();
		}

		$this->mTitle = Title::makeTitle( NS_PLB_LAYOUT,  $default == '' ? wfMsg("plb-empty-page"):$default );
		$this->mArticle = new Article( $this->mTitle );
		$this->mEditPage = new EditPage($this->mArticle);

		if(!empty($defultContent)) {
			$this->mEditPage->textbox1 = $defultContent;
		}

	}

	private function loadFromDB(Title $title) {
		$this->mArticle = new Article( $title );
		$this->mEditPage = new EditPage($this->mArticle);
		$this->mEditPage->textbox1 = $this->mEditPage->getContent();

		$out = PageLayoutBuilderModel::getProp( $this->mArticle->getID() );

		$this->mFormData['title'] = $title->getText();
		$this->mFormData['desc'] = !empty($out) ? $out['desc']:"";
		$this->mFormData['plbId'] = $this->mArticle->getID();

		$this->isFromDb = true;
	}

	private function getPostType() {
		global $wgRequest;

		$type = array(
			"wpSave" => "save",
			"wpPreviewform" => "previewform",
			"wpPreviewarticle" => "previewarticle",
			"wpDraft" => "draft"
		);


		foreach($type as $key => $value){
			if($wgRequest->getVal($key, '') != '') {
				return $value;
			}
		}
	}

	private function parseForm() {
		global $wgUser, $wgRequest, $wgOut;

		foreach ($this->mFormFields as $key => $value ) {
			$this->mFormData[$key] = $wgRequest->getVal( $value, "" );
		}

		$this->mFormErrors = array();
		
		$this->mTitle = empty($this->mFormData['plbId']) ? null:Title::newFromID($this->mFormData['plbId']);
		if( ($this->mTitle instanceof Title) && ($this->mTitle->getNamespace() == NS_PLB_LAYOUT) ) {
			$this->mArticle = new Article($this->mTitle);
			$this->isFromDb = true;
		} else {
			$title = trim($this->mFormData['title']);
			if ( empty( $this->mFormData['title'] ) ) {
				$this->mFormErrors[] = wfMsg( 'plb-create-empty-title-error' );
			}
			else {
				$this->mTitle = Title::newFromText( $title, NS_PLB_LAYOUT );

				if ( !( $this->mTitle instanceof Title ) ) {
					$this->mFormErrors[] = wfMsg( 'plb-create-invalid-title-error' );
				} else {
					$sFragment = $this->mTitle->getFragment();
					if ( strlen( $sFragment ) > 0 ) {
						$this->mFormErrors[] = wfMsg( 'plb-create-invalid-title-error' );
					} else {
						$this->mArticle = new Article( $this->mTitle );
						if ( $this->mArticle->exists() ) {
							$this->mFormErrors[] = wfMsg( 'plb-create-already-exists-error' );
							$this->getEmptyArticle();
						}
					}
				}
			}
		}

		$body = $this->getTextFromRTEHTML($this->mFormData['body']);
		if ( empty( $body ) ) {
			$this->mFormErrors[] = wfMsg( 'plb-create-empty-body-error' );
		}

		$desc = trim( $this->mFormData['desc'] );

		if( empty($desc) ) {
			$this->mFormErrors[] = wfMsg( 'plb-create-empty-desc' );
		}


		if(empty($this->mArticle)) {
			$this->getEmptyArticle();
		}

		$this->mEditPage = new EditPage($this->mArticle);
		$this->mEditPage->initialiseForm();
		$this->mEditPage->importFormData($wgRequest);
		/* fix text for rte */
		$this->fixRTE();
		$this->mEditPage->textbox1 = $wgRequest->getVal('wpTextbox1');

		if( $this->isCategorySelect() ) {
			CategorySelectImportFormData( $this->mEditPage, $wgRequest );
		}
		$this->mEditPage->watchthis = $this->mFormData['watchthis'];
		if(count($this->mFormErrors) > 0) {
			return false;
		}

		return true;
	}

	private function save() {
		global $wgUser, $wgParser, $wgRequest;

		$result = false;
		$bot = $wgUser->isAllowed('bot') && $wgRequest->getBool( 'bot', true );
		$this->mEditPage->summary = empty($this->mFormData['summary']) ? wfMsgForContent('plb-create-updated-summary'):$this->mFormData['summary'];
		$status = $this->mEditPage->internalAttemptSave( $result, $bot );
		switch( $status ) {
			case EditPage::AS_SUCCESS_UPDATE:
			case EditPage::AS_SUCCESS_NEW_ARTICLE:
				$addData = array(
					'desc' => substr($this->mFormData['desc'],0,255)
				);

				if(empty($wgParser->mPlbFormElements)) {
					$wgParser->mPlbFormElements = array();
				}

				PageLayoutBuilderModel::setProp($this->mArticle->getID(), $addData);
				PageLayoutBuilderModel::saveElementList($this->mArticle->getID(), $wgParser->mPlbFormElements);
				return true;
			break;
			case EditPage::AS_ARTICLE_WAS_DELETED:
				return true;
				break;
			default:
				if ( ( $status == EditPage::AS_READ_ONLY_PAGE_LOGGED ) || ( $status == EditPage::AS_READ_ONLY_PAGE_ANON ) ) {
					$this->mFormErrors[] =  wfMsg( 'plb-create-cant-edit' );
				}
				else {
					$this->mFormErrors[] = wfMsg( 'plb-create-spam' );
				}
				return false;
				break;
		}
	}

	static public function addFormButton(&$self, &$buttons, &$tabindex) {
		if($self->mTitle->getNamespace() != NS_PLB_LAYOUT) {
			return true;
		}
		$buttons_out = array();

		$buttons_out['save'] = $buttons['save'];

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

	public static function addNewButtonForArtilce($cat) {
		global $wgUser, $wgOut, $wgTitle, $wgContentNamespaces;

		if(!in_array($wgTitle->getNamespace() , $wgContentNamespaces)) {
			return true;
		}

		if( !$wgUser->isAllowed( 'plbmanager' ) ) {
			return true;
		}

		wfLoadExtensionMessages( 'PageLayoutBuilder' );
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars(array(
		    "post_url" => Title::newFromText('PageLayoutBuilder', NS_SPECIAL)->getFullURL("action=createfromarticle"),
		));

		$wgOut->addHTML( $oTmpl->render("article-button") );
		return true;
	}

	public static function isDraft($article) {
		return ($article->getId() == 0 || PageLayoutBuilderModel::layoutIsNoPublish($article->getId()));
	}

	public static function alternateEditHook(&$oEditPage) {
		global $wgOut, $wgRequest;
		if(empty($oEditPage->mTitle) || empty($oEditPage)) {
			return true;
		}
		
		if(isset($oEditPage->isRTEhook) && $oEditPage->isRTEhook) {
			return true;
		}

		if($oEditPage->mTitle->getNamespace() == NS_PLB_LAYOUT) {
			$oSpecialPageTitle = Title::newFromText('PageLayoutBuilder', NS_SPECIAL);
			if($oEditPage->mTitle->getArticleId() == 0) {
				$wgOut->redirect($oSpecialPageTitle->getFullUrl("default=".$oEditPage->mTitle->getText()."&plbId=" . $oEditPage->mTitle->getArticleId() ));
				return true;
			}
			$wgOut->redirect($oSpecialPageTitle->getFullUrl("plbId=" . $oEditPage->mTitle->getArticleId() ));
		}
		return true; 
	}

	public static function getUserPermissionsErrors( &$title, &$user, &$action, &$result ) {
		if( $title->getNamespace() == NS_PLB_LAYOUT ) {
			$result = array();
			if( $user->isAllowed( 'plbmanager' ) ) {
				$result = null;
				return true;
			} else {
				wfLoadExtensionMessages( 'PageLayoutBuilder' );
				$result = array('badaccess-group0');
				return false;
			}
		}
		$result = null;
		return true;
	}

	public static function beforeCategoryData(&$userCon) {
		$userCon = "not page_namespace = ".NS_PLB_LAYOUT;
		return true;
	}

	public static function beforeCategorySelect(&$text) {
		global $wgTitle;

		if($wgTitle->isSpecial( 'PageLayoutBuilder' ) ) {
			$text = wfMsg("plb-special-form-cat-info");
			return true;
		}
		
		return true;
	}

	public static function createPageOptions(&$options, &$listtype) {
		global $wgCdnStylePath, $wgScript;
		$listtype = "long";
		$out = PageLayoutBuilderModel::getListOfLayout(DB_SLAVE);
		foreach($out as $value) {
			if( empty($value['not_publish']) ) {
				$options[$value['page_id']] = array(
					'label' => $value['page_title'],
					'desc' => $value['desc'],
					'icon' => "{$wgCdnStylePath}/extensions/wikia/CreatePage/images/thumbnail_format.png",
					'trackingId' => 'blankpage',
					'submitUrl' => Title::newFromText( "PageLayoutBuilderForm", NS_SPECIAL )->getFullUrl("plbId=".$value['page_id']."&default=$1&action=edit")
				);
			}
		}
		return true;
	}

	public function rollbackHook($self, $wgUser, $target, $current){
		if($target->getTitle()->getNamespace() != NS_PLB_LAYOUT) {
			return true;
		}
		$parser = new PageLayoutBuilderParser();
		$out = $parser->parseForLayoutPreview($target->getRawText(), $target->getTitle());
		PageLayoutBuilderModel::saveElementList($target->getTitle()->getArticleId(), $out->mPlbFormElements);
		return true;
	}

	private function isCategorySelect() {
		if(function_exists('CategorySelectInitializeHooks')) {
			return true;
		}
		return false;
	}

	public static function myTools(&$list) {
		global $wgUser;
		
		wfLoadExtensionMessages( 'PageLayoutBuilder' );
		
		if($wgUser->isAllowed( 'plbmanager' )) {
			$list[] = array(
				'text' => wfMsg( 'plb-mytools-link' ), 
				'name' => 'plbmanager',
				'href' => Title::newFromText( "PageLayoutBuilder", NS_SPECIAL )->getFullUrl("action=list")
			);
		}
		
		return true;
	}
	
	private function getTextFromRTEHTML($text) {
		global $wgEnableRTEExt, $wgRequest;
		if (!empty($wgEnableRTEExt)) {
			return  RTE::HtmlToWikitext($text);
		}
		return $text;
	}

	private function fixRTE() {
		global $wgEnableRTEExt, $wgRequest;
		if (!empty($wgEnableRTEExt)) {
			$this->mEditPage->isRTEhook = true;
			wfRunHooks('AlternateEdit', array(&$this->mEditPage));
		}
	}
}

