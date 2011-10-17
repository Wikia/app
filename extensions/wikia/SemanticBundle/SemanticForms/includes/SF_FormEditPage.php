<?php
/**
 * Contains Form Edit Page inheriting from EditPage
 * 
 * @author Daniel Friesen
 * @author Yaron Koren
 * @file
 * @ingroup SF
 */

/**
 * Form Edit Page inheriting from EditPage
 * @ingroup SF
 */
class SFFormEditPage extends EditPage {

	protected $form, $form_name;

	function __construct( $article, $form_name = '' ) {
		global $wgRequest;
		parent::__construct( $article );
		SFUtils::loadMessages();
		$this->action = 'formedit';
		$form_name = $wgRequest->getText( 'form', $form_name );
		$this->form = Title::makeTitleSafe( SF_NS_FORM, $form_name );
		$this->form_name = $form_name;
	}
	
	protected function isSectionEditSupported() {
		return false; // sections and forms don't mix
	}

	function setHeaders() {
		parent::setHeaders();
		global $wgOut, $wgTitle;
		if ( !$this->isConflict ) {
			$wgOut->setPageTitle( wfMsg( 'sf_formedit_title',
				$this->form->getText(), $wgTitle->getPrefixedText() ) );
		}
	}

	protected function displayPreviewArea( $previewOutput, $isOnTop = false ) {
		if ( $this->textbox1 != null )
			parent::displayPreviewArea( $previewOutput );
	}
	
	protected function importContentFormData( &$request ) {
		// @todo This is where $request to save&preview page text should go
	}
	
	protected function showContentForm() {
		$target_title = $this->mArticle->getTitle();
		$target_name = SFUtils::titleString( $target_title );
		if ( $target_title->exists() ) {
			SFEditData::printEditForm( $this->form_name, $target_name, $this->textbox1 );
		} else {
			SFAddData::printAddForm( $this->form_name, $target_name, array(), $this->textbox1 );
		}
		// @todo This needs a proper form builder
	}

	function showFooter() {
	}
}
