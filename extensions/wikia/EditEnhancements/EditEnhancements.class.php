<?php

class EditEnhancements {

	private $buttons;
	private $checkboxes;
	private $summary;
	private $action;
	private $tmpl;

	function __construct($action) {
		global $wgHooks;

		$this->action = $action;
		$wgHooks['EditPageSummaryBox'][] = array(&$this, 'summaryBox');
		$this->tmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
	}
	
	public function summaryBox($summary) {
		global $wgUser, $wgHooks;
		
		$valid_skins = array('SkinMonaco', 'SkinAnswers');
		if(in_array(get_class($wgUser->getSkin()), $valid_skins)) {
			$wgHooks['EditPage::showEditForm:checkboxes'][] = array(&$this, 'showCheckboxes');
                        if($this->action == 'edit') {
                                $wgHooks['GetHTMLAfterBody'][] = array(&$this, 'editPageJS');
                        } else if ($this->action == 'submit') {
                                $wgHooks['GetHTMLAfterBody'][] = array(&$this, 'previewJS');
                        }
			$wgHooks['EditForm::MultiEdit:Form'][] = array(&$this, 'showToolbar');
			$wgHooks['EditPageBeforeEditButtons'][] = array(&$this, 'showButtons');			
			$this->summary = $summary;
			$summary = '<div>';
		}
		return true;
	}

	public function editPageJS() {
	
 		echo $this->tmpl->execute('EditEnhancementsJS'); 

		return true;
	}

	public function previewJS() {
	
		echo $this->tmpl->execute('EditEnhancementsPreviewJS'); 

		return true;
	}

	public function showToolbar($a, $b, $c, $d) {
		global $wgOut;

		$this->tmpl->set_vars(array(
			'buttons'    => $this->buttons,
			'checkboxes' => $this->checkboxes,
			'summary'    => $this->summary
		));
	
		$wgOut->addHTML($this->tmpl->execute('EditEnhancementsToolbar'));
	
		return true;
	}

	function showButtons($EditPage, &$buttons) {
		$this->buttons = $buttons;
	
		// Change it to hide
		$buttons['save'] = $buttons['preview'] = '';
		return true;
	}

	function showCheckboxes($EditPage, &$checkboxes) {
		$this->checkboxes = $checkboxes;

		// Change it to hide
		$checkboxes['minor'] = $checkboxes['watch'] = '';
		return true;
	}
}

