<?php

class EditEnhancements {

	private $buttons;
	private $checkboxes;
	private $summary;
	private $action;
	private $undo;
	private $tmpl;

	function __construct($action = '') {
		global $wgHooks, $wgRequest;

		$this->action = $action;
		$this->undo = intval($wgRequest->getVal('undo', 0)) != 0;
		$wgHooks['EditPageSummaryBox'][] = array(&$this, 'summaryBox');
		$this->tmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
	}

	public function summaryBox($summary) {
		global $wgUser, $wgHooks;

		$valid_skins = array('SkinMonaco', 'SkinAnswers', 'SkinOasis');
		if(in_array(get_class($wgUser->getSkin()), $valid_skins)) {
			$wgHooks['EditPage::showEditForm:checkboxes'][] = array(&$this, 'showCheckboxes');
			if($this->action == 'edit' && !$this->undo) {
				$wgHooks['GetHTMLAfterBody'][] = array(&$this, 'editPageJS');
			} else if ($this->action == 'submit' || $this->undo) {
				$wgHooks['GetHTMLAfterBody'][] = array(&$this, 'previewJS');
			}
			$wgHooks['EditForm::MultiEdit:Form'][] = array(&$this, 'showToolbar');
			$wgHooks['EditPageBeforeEditButtons'][] = array(&$this, 'showButtons');
			$this->summary = $summary;
			$summary = '<div>';
		}
		return true;
	}

	public function editPageJS($skin, &$html) {
		// moved into /js/editEnhancements.js
		if ($skin->skinname = 'oasis') {
			global $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgJsMimeType;

			$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/EditEnhancements/js/editEnhancements.js?{$wgStyleVersion}\"></script>\n");

		}
		else {
			$html .= $this->tmpl->render('EditEnhancementsJS');
		}
		return true;
	}

	public function previewJS($skin, &$html) {
		$html .= $this->tmpl->render('EditEnhancementsPreviewJS');
		return true;
	}

	public function showToolbar($a, $b, $c, $d) {
		global $wgOut, $wgUser;

		$this->tmpl->set_vars(array(
			'buttons'    => $this->buttons,
			'checkboxes' => $this->checkboxes,
			'summary'    => $this->summary,
			'action'     => $this->action,
			'undo'       => $this->undo,
			'arrowTitle' => wfMsg('edit-enhancements-scroll-down-arrow'),
			'skinname'   => get_class($wgUser->getSkin()),
		));

		$wgOut->addHTML($this->tmpl->render('EditEnhancementsToolbar'));

		return true;
	}

	function showButtons($EditPage, &$buttons) {
		$this->buttons = $buttons;
		if(isset($this->buttons['diff'])) {
			unset( $this->buttons['diff'] );
			$buttons = array('diff' => $buttons['diff'] );
		} else {
			$buttons = array();
		}
		return true;
	}

	function showCheckboxes($EditPage, &$checkboxes) {
		$this->checkboxes = $checkboxes;

		// Change it to hide
		$checkboxes['minor'] = $checkboxes['watch'] = '';
		return true;
	}
}
