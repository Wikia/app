<?php
/**
 * A special page to create a new article, using wysiwig editor
 *
 */

class CreatePage extends SpecialEditPage {

	public function __construct() {
		// confirm edit captcha [RT#21902] - Marooned
		global $wgHooks, $wgWikiaEnableConfirmEditExt;
		if ( $wgWikiaEnableConfirmEditExt ) {
			$wgHooks['ConfirmEdit::onConfirmEdit'][] = array( $this, 'wfCreatePageOnConfirmEdit' );
		}

		parent::__construct( 'CreatePage'  /*class*/, '' /*restriction*/, true );
	}

	public function execute() {
		global $wgUser, $wgOut, $wgRequest, $wgJsMimeType, $wgExtensionsPath, $wgStyleVersion;

		$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/CreatePage/js/focus.js?{$wgStyleVersion}\" ></script>\n" );

		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		if ( !$wgUser->isAllowed( 'edit' ) ) {
			$this->createEditPage( '' );
			$this->mEditPage->userNotLoggedInPage();
			return;
		}

		$wgRequest->setVal( "diff", null ); // rt#34160

		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'CreatePage' );

		parent::execute();

		$wgOut->setPageTitle( wfMsg( "createpage-sp-title" ) );

		if ( $wgRequest->wasPosted() ) {
			$this->parseFormData();
			if ( count( $this->mFormErrors ) > 0 || !empty( $this->mPreviewTitle ) ) {
				$this->renderForm();
			}
			else {
				$this->save();
			}
		}
		else {
			$this->createEditPage( '' );
			$this->renderForm();
		}

	}

	protected function parseFormData() {
		global $wgRequest;

		wfRunHooks( 'BlogsAlternateEdit', array( false ) );

		$this->mFormData['postBody'] = $wgRequest->getVal( 'wpTextbox1' );
		$this->mFormData['postTitle'] = $wgRequest->getVal( 'postTitle' );
		$this->mFormData['postEditSummary'] = $wgRequest->getVal( 'wpSummary' );
		$this->mFormData['postCategories'] = $wgRequest->getVal( 'wpCategoryTextarea1' );

		$postBody = trim( $this->mFormData['postBody'] );
		if ( empty( $postBody ) ) {
			$this->mFormErrors[] = wfMsg( 'createpage_empty_article_body_error' );
		}

		if ( empty( $this->mFormData['postTitle'] ) ) {
			$this->mFormErrors[] = wfMsg( 'createpage_empty_title_error' );
		}
		else {
			$oPostTitle = Title::newFromText( $this->mFormData['postTitle'], NS_MAIN );

			if ( !( $oPostTitle instanceof Title ) ) {
				$this->mFormErrors[] = wfMsg( 'createpage_invalid_title_error' );
			}
			else {
				$sFragment = $oPostTitle->getFragment();
				if ( strlen( $sFragment ) > 0 ) {
					$this->mFormErrors[] = wfMsg( 'createpage_invalid_title_error' );
				} else {
					$this->mPostArticle = new Article( $oPostTitle, 0 );
					if ( $this->mPostArticle->exists() ) {
						$this->mFormErrors[] = wfMsg( 'createpage_article_already_exists' );
					}
				}
			}
		}

		parent::parseFormData();
	}

	// invoked from hook 'EditPage::showEditForm:beforeToolbar' when Captcha fires up [RT#21902] - Marooned
	public function renderFormHeaderWrapper( $editPage, $wgOut ) {
		$this->renderFormHeader( $wgOut );
		return true;
	}

	// print extra field for 'title'
	public function renderFormHeader( $wgOut ) {
		global $wgScriptPath, $wgRequest;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

		$oTmpl->set_vars( array(
			"formErrors" => $this->mFormErrors,
			"formData" => $this->mFormData,
			/*field with value 1 add by login form befor reload */
			"isReload" => ( $wgRequest->getVal( 'wpIsReload', 0 ) == 1 ),
			"editIntro" => $wgOut->parse( $this->mEditIntro )
		) );

		$wgOut->setPageTitle( wfMsg( "createpage" ) );
		$wgOut->addScript( '<script type="text/javascript" src="' . $wgScriptPath . '/skins/common/edit.js"><!-- edit js --></script>' );
		if ( $this->mPreviewTitle == null ) {
			$wgOut->addHTML ( '<div id="custom_createpagetext">' ) ;
			$wgOut->addWikiText ( wfMsgForContent ( 'newarticletext' ) ) ;
			$wgOut->addHTML ( '</div>' ) ;
		}
		$wgOut->addHTML( $oTmpl->render( "createFormHeader" ) );
	}

	protected function save() {
		global $wgOut, $wgUser, $wgContLang, $wgRequest;

		// CategorySelect compatibility (add categories to article body)
		if ( $this->mCategorySelectEnabled ) {
			CategorySelectImportFormData( $this->mEditPage, $wgRequest );
		}

		$sPostBody = $this->mEditPage->textbox1;

		$editPage = new EditPage( $this->mPostArticle );
		$editPage->initialiseForm();
		$editPage->textbox1 = $sPostBody;
		$editPage->summary = isset( $this->mFormData['postEditSummary'] ) ? $this->mFormData['postEditSummary'] : '';
		$editPage->recreate = true;

		$result = false;
		$status = $editPage->internalAttemptSave( $result );
		switch( $status ) {
			case EditPage::AS_SUCCESS_UPDATE:
			case EditPage::AS_SUCCESS_NEW_ARTICLE:
			case EditPage::AS_ARTICLE_WAS_DELETED:
				$wgOut->redirect( $this->mPostArticle->getTitle()->getFullUrl() );
				break;
			default:
				Wikia::log( __METHOD__, "createpage", $status );
				if ( ( $status == EditPage::AS_READ_ONLY_PAGE_LOGGED ) || ( $status == EditPage::AS_READ_ONLY_PAGE_ANON ) ) {
					$sMsg = wfMsg( 'createpage_cant_edit' );
				}
				else {
					$sMsg = wfMsg( 'createpage_spam' );
				}
				$this->mFormErrors[] = $sMsg . " ($status)";

				global $wgCreatePageCaptchaTriggered;
				// do not display form - there is already one invoked from Captcha [RT#21902] - Marooned
				if ( empty( $wgCreatePageCaptchaTriggered ) ) {
					$this->renderForm();
				}
				break;
		}
	}

	// handle ConfirmEdit captcha, only for CreatePage, which will be treated a bit differently (edits in special page)
	// this function is based on Bartek's solution for CreateAPage done in t:r6990 [RT#21902] - Marooned
	public function wfCreatePageOnConfirmEdit( &$captcha, &$editPage, $newtext, $section, $merged, &$result ) {
		global $wgTitle, $wgCreatePageCoverRedLinks, $wgOut, $wgRequest;
		$canonspname = SpecialPage::resolveAlias( $wgTitle->getDBkey() );
		if ( $canonspname != 'CreatePage' ) {
			return true;
		}

		if ( $captcha->shouldCheck( $editPage, $newtext, $section, $merged ) ) {
			if ( $captcha->passCaptcha() ) {
				$result = true;
				return false;
			} else {
				global $wgHooks, $wgCreatePageCaptchaTriggered;
				$wgCreatePageCaptchaTriggered = true;
				$wgHooks['EditPage::showEditForm:beforeToolbar'][] = array( $this, 'renderFormHeaderWrapper' );

				$result = false;
				return true;
			}
		} else {
			return true;
		}
	}
}
