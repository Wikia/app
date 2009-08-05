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

	public function __construct( $name = '', $restriction = '', $listed = true, $function = false, $file = 'default', $includable = false ) {
		global $wgRequest;

		$wgRequest->setVal('action', 'edit');

		parent::__construct( $name, $restriction, $listed, $function, $file, $includable );

		// force EditEnhancements initialisation if available
		if(function_exists('wfEditEnhancementsInit') && !class_exists('EditEnhancements')) {
			$this->mEditEnhancementsEnabled = true;
			wfEditEnhancementsInit(true);
		}
	}

	public function execute() {
		global $wgRequest, $wgDisableAnonymousEditig, $wgUser;
		// force CategorySelect initialisation if available
		if(function_exists('CategorySelectInit') && function_exists('CategorySelectInitializeHooks') && ($wgUser->getOption('disablecategoryselect', false) == false)) {
			$this->mCategorySelectEnabled = true;
			$tmp = $wgDisableAnonymousEditig;
			$wgDisableAnonymousEditig = false; // set to false for forcing init
			CategorySelectInit();
			CategorySelectInitializeHooks($this->mTitle, null);
			$wgDisableAnonymousEditig = $tmp;
		}
	}

	protected function createEditPage($sPostBody) {
		$oArticle = new Article( Title::makeTitle( NS_MAIN, 'New or Updated Page' ) );
		$this->mEditPage = new EditPage($oArticle);
		$this->mEditPage->textbox1 = $sPostBody;
	}

	protected function renderForm() {
		// CategorySelect compatibility (restore categories from article body)
		if($this->mCategorySelectEnabled) {
			CategorySelectReplaceContent( $this->mEditPage, $this->mEditPage->textbox1 );
		}

		$this->mEditPage->showEditForm( array($this, 'renderFormHeader') );
		return true;
	}

	protected function parseFormData() {
		global $wgRequest;

		//create EditPage object
		$this->createEditPage( $this->mFormData['postBody'] );


		if(!count($this->mFormErrors) && $wgRequest->getVal('wpPreview')) {
			// preview mode
			$this->mEditPage->formtype = 'preview';
			$this->mPreviewTitle = Title::newFromText( $this->mFormData['postTitle'] );

			//simple hack to show correct title in preview mode
			global $wgCustomTitle;
			$wgCustomTitle = $this->mPreviewTitle;

			// CategorySelect compatibility (add categories to article body)
			if($this->mCategorySelectEnabled) {
				CategorySelectImportFormData( $this->mEditPage, $wgRequest );
			}
		}

	}

	abstract public function renderFormHeader($wgOut);
	abstract protected function save();
}
