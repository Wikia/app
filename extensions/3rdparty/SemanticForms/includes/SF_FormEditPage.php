<?php
/**
 * Form Edit Page inheriting from EditPage
 * 
 * @author Daniel Friesen
 */

class FormEditPage extends EditPage {
	
	protected $form, $form_name;
	
	function __construct( $article, $form_name = '' ) {
		global $wgRequest;
		parent::__construct( $article );
		wfLoadExtensionMessages('SemanticForms');
		$this->action = 'formedit';
		$form_name = $wgRequest->getText('form', $form_name);
		$this->form = Title::newFromText($form_name, SF_NS_FORM);
		$this->form_name = $form_name;
	}
	
	function setHeaders() {
		parent::setHeaders();
		global $wgOut, $wgTitle;
		if( !$this->isConflict ) {
			$wgOut->setPageTitle( wfMsg( 'sf_editdata_title',
				$this->form->getText(), $wgTitle->getPrefixedText() ) );
		}
	}
	
	protected function showTextbox1() {
		if( $this->isConflict ) {
			// Fallback to normal mode when showing an editconflict
			parent::showTextbox1();
			return;
		}
		global $sfgIP;
		$target_title = $this->mArticle->getTitle();
		$target_name = SFLinkUtils::titleString($target_title);
		if ($target_title->exists()) {
			require_once($sfgIP . '/specials/SF_EditData.php');
			printEditForm($this->form_name, $target_name);
		} else {
			require_once($sfgIP . '/specials/SF_AddData.php');
			printAddForm($this->form_name, $target_name, array());
		}

	}
}
