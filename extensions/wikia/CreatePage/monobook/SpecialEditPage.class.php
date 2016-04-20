<?php

abstract class SpecialEditPage extends SpecialPage {

	protected $mEditPage;
	protected $mCategorySelectEnabled = false;
	protected $mEditEnhancementsEnabled = false;
	protected $mTitle;
	protected $mPreviewTitle;
	protected $mFormData;
	protected $mFormErrors;
	protected $mPostArticle;
	protected $mEditIntro;

	public function __construct( $name = '', $restriction = '', $listed = true, $function = false, $file = 'default', $includable = false ) {
		parent::__construct( $name, $restriction, $listed, $function, $file, $includable );

		// force EditEnhancements initialisation if available
		if ( function_exists( 'wfEditEnhancementsInit' ) && !class_exists( 'EditEnhancements' ) ) {
			$this->mEditEnhancementsEnabled = true;
			wfEditEnhancementsInit( true );
		}
	}

	public function execute( $par ) {
		global $wgRequest, $wgUser;

		$wgRequest->setVal( 'action', 'edit' );

		// force CategorySelect initialisation if available
		if ( class_exists( 'CategorySelectHooksHelper' ) && ( $wgUser->getGlobalPreference( 'disablecategoryselect', false ) == false ) ) {
			$this->mCategorySelectEnabled = true;
			CategorySelectHooksHelper::onMediaWikiPerformAction( null, null, $this->mTitle, null, null, null );
		}
	}

	protected function getPreloadedText( $preload ) {
		if ( $preload === '' ) {
			return '';
		} else {
			$preloadTitle = Title::newFromText( $preload );
			if ( isset( $preloadTitle ) && $preloadTitle->userCan( 'read' ) ) {
				$rev = Revision::newFromTitle( $preloadTitle );
				if ( is_object( $rev ) ) {
					$text = $rev->getText();
					$text = preg_replace( '~</?includeonly>~', '', $text );
					$text = preg_replace( '/<noinclude>.*<\/noinclude>/', '', $text );

					return $text;
				} else
					return '';
			}
		}
	}

	protected function createEditPage( $sPostBody ) {
		$oArticle = new Article( Title::makeTitle( NS_MAIN, '' ) );

		$this->mEditPage = new EditPage( $oArticle );
		$this->mEditPage->textbox1 = $sPostBody;

		// fix for RT #33844 - run hook fired by "classical" EditPage
		// Allow extensions to modify edit form
		global $wgEnableRTEExt, $wgRequest;
		if ( !empty( $wgEnableRTEExt ) ) {
			wfRunHooks( 'AlternateEdit', array( $this->mEditPage ) );
			$this->mEditPage->textbox1 = $wgRequest->getVal( 'wpTextbox1' );

			RTE::log( __METHOD__ . '::wikitext', $this->mEditPage->textbox1 );
		}

		// fix for RT #38845 - allow for preloading text content
		if ( !$wgRequest->wasPosted() ) {
			wfRunHooks( 'EditFormPreloadText', array( &$this->mEditPage->textbox1, &$this->mEditPage->mTitle ) );
		}
	}

	protected function renderForm() {
		global $wgRequest;

		$preload = $wgRequest->getVal( 'preload', '' );
		if ( !empty( $preload ) ) {
			$this->mEditPage->textbox1 = $this->getPreloadedText( $preload );
		}

		$editintro = $wgRequest->getVal( 'editintro', '' );
		if ( !empty( $editintro ) ) {
			$this->mEditIntro = $this->getPreloadedText( $editintro );
		}

		// CategorySelect compatibility (restore categories from article body)
		if ( $this->mCategorySelectEnabled ) {
			CategorySelectHooksHelper::onEditPageGetContentEnd( $this->mEditPage, $this->mEditPage->textbox1 );
		}

		$this->mEditPage->showEditForm( array( $this, 'renderFormHeader' ) );
		return true;
	}

	protected function parseFormData() {
		global $wgRequest;

		// create EditPage object
		$this->createEditPage( $this->mFormData['postBody'] );

		if ( !count( $this->mFormErrors ) && $wgRequest->getVal( 'wpPreview' ) ) {
			// preview mode
			$this->mEditPage->formtype = 'preview';
			$this->mPreviewTitle = Title::newFromText( $this->mFormData['postTitle'] );

			// simple hack to show correct title in preview mode
			global $wgCustomTitle;
			$wgCustomTitle = $this->mPreviewTitle;

			// CategorySelect compatibility (add categories to article body)
			if ( $this->mCategorySelectEnabled ) {
				CategorySelectHooksHelper::onEditPageImportFormData( $this->mEditPage, $wgRequest );
			}
		}

	}

	abstract public function renderFormHeader( $wgOut );
	abstract protected function save();
}
