<?php
/**
 * A special page to create a new article, using wysiwig editor
 *
 */

class SpecialCreatePage extends SpecialEditPage {

	public function __construct() {
		// confirm edit captcha [RT#21902] - Marooned
		global $wgHooks, $wgWikiaEnableConfirmEditExt;
		if ( $wgWikiaEnableConfirmEditExt ) {
			$wgHooks['ConfirmEdit::onConfirmEdit'][] = array( $this, 'wfCreatePageOnConfirmEdit' );
		}

		parent::__construct( 'CreatePage'  /*class*/, '' /*restriction*/, true );
	}

	public function execute( $par ) {
		global $wgUser, $wgOut, $wgRequest, $wgJsMimeType, $wgExtensionsPath;

		if ( !empty( $par ) ) {
			if ( !wfRunHooks('SpecialCreatePage::Subpage', array( $par )) ) {
				return;
			}
		}

		$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/CreatePage/js/focus.js\" ></script>\n" );

		if ( $wgUser->isBlocked() ) {
			throw new UserBlockedError( $this->getUser()->mBlock );
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
		wfRunHooks( 'BlogsAlternateEdit', array( false ) );

		$request = $this->getRequest();

		$this->mFormData['postBody'] = $request->getVal( 'wpTextbox1' );
		$this->mFormData['postTitle'] = $request->getVal( 'postTitle' );
		$this->mFormData['postEditSummary'] = $request->getVal( 'wpSummary' );
		$this->mFormData['postCategories'] = $request->getVal( 'wpCategoryTextarea1' );

		if ( !$this->getUser()->matchEditToken( $request->getVal( 'wpEditToken' ) ) ) {
			$this->mFormErrors[] = $this->msg( 'sessionfailure' )->escaped();
		}

		$postBody = trim( $this->mFormData['postBody'] );
		if ( empty( $postBody ) ) {
			$this->mFormErrors[] = $this->msg( 'createpage_empty_article_body_error' )->escaped();
		}

		if ( empty( $this->mFormData['postTitle'] ) ) {
			$this->mFormErrors[] = $this->msg( 'createpage_empty_title_error' )->escaped();
		}
		else {
			$oPostTitle = Title::newFromText( $this->mFormData['postTitle'], NS_MAIN );

			if ( !( $oPostTitle instanceof Title ) ) {
				$this->mFormErrors[] = $this->msg( 'createpage_invalid_title_error' )->escaped();
			}
			else {
				$sFragment = $oPostTitle->getFragment();
				if ( strlen( $sFragment ) > 0 ) {
					$this->mFormErrors[] = $this->msg( 'createpage_invalid_title_error' )->escaped();
				} else {
					$this->mPostArticle = new Article( $oPostTitle, 0 );
					if ( $this->mPostArticle->exists() ) {
						$this->mFormErrors[] = $this->msg( 'createpage_article_already_exists' )->escaped();
					}
				}
			}
		}

		parent::parseFormData();
	}

	// invoked from hook 'EditPage::showEditForm:beforeToolbar' when Captcha fires up [RT#21902] - Marooned
	public function renderFormHeaderWrapper( $editPage, $out ) {
		$this->renderFormHeader( $out );
		return true;
	}

	/**
	 * Print extra field for 'title'
	 *
	 * @param OutputPage $wgOut
	 */
	public function renderFormHeader( $wgOut ) {
		global $wgRequest;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

		$oTmpl->set_vars( array(
			"formErrors" => $this->mFormErrors,
			"formData" => $this->mFormData,
			/*field with value 1 add by login form befor reload */
			"isReload" => ( $wgRequest->getVal( 'wpIsReload', 0 ) == 1 ),
			"editIntro" => $wgOut->parse( $this->mEditIntro )
		) );

		$wgOut->setPageTitle( wfMsg( "createpage" ) );
		$wgOut->addScriptFile('edit.js');
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
			CategorySelectHooksHelper::onEditPageImportFormData( $this->mEditPage, $wgRequest );
		}

		$sPostBody = $this->mEditPage->textbox1;

		$editPage = new EditPage( $this->mPostArticle );
		$editPage->initialiseForm();
		$editPage->textbox1 = $sPostBody;
		$editPage->summary = isset( $this->mFormData['postEditSummary'] ) ? $this->mFormData['postEditSummary'] : '';
		$editPage->recreate = true;

		$result = false;
		$status = $editPage->internalAttemptSave( $result );
		switch( $status->value ) {
			case EditPage::AS_SUCCESS_UPDATE:
			case EditPage::AS_SUCCESS_NEW_ARTICLE:
			case EditPage::AS_ARTICLE_WAS_DELETED:
				$wgOut->redirect( $this->mPostArticle->getTitle()->getFullUrl() );
				break;
			default:
				/**
				 * PLATFORM-1160: Log the entire $status to ELK
				 *
				 * Recommendation: use $status->value for comparisons and messages rather than $status in the following block.
				 */
				Wikia\Logger\WikiaLogger::instance()->warning( 'PLATFORM-1160', [ 'method' => __METHOD__, 'status_object' => $status ] );
				if ( ( $status->value == EditPage::AS_READ_ONLY_PAGE_LOGGED ) || ( $status->value == EditPage::AS_READ_ONLY_PAGE_ANON ) ) {
					$sMsg = wfMsg( 'createpage_cant_edit' );
				}
				else {
					$sMsg = wfMsg( 'createpage_spam' );
				}
				$this->mFormErrors[] = $sMsg . " ($status->value)";

				global $wgCreatePageCaptchaTriggered;
				// do not display form - there is already one invoked from Captcha [RT#21902] - Marooned
				if ( empty( $wgCreatePageCaptchaTriggered ) ) {
					$this->renderForm();
				}
				break;
		}
	}

	/**
	 * handle ConfirmEdit captcha, only for CreatePage, which will be treated a bit differently (edits in special page)
	 * this function is based on Bartek's solution for CreateAPage done in t:r6990 [RT#21902] - Marooned
	 * @param SimpleCaptcha $captcha
	 * @param $editPage
	 * @param $newtext
	 * @param $section
	 * @param $merged
	 * @param $result
	 * @return bool
	 */
	public function wfCreatePageOnConfirmEdit( &$captcha, &$editPage, $newtext, $section, $merged, &$result ) {
		global $wgTitle;
		$canonspname = array_shift(SpecialPageFactory::resolveAlias( $wgTitle->getDBkey() ));
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
