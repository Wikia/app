<?php

class EditEnhancements {

	public $action;
	private $undo;
	private $tmpl;

	function __construct($action = '') {
		global $wgHooks, $wgRequest;

		$this->action = $action;
		$this->undo = intval($wgRequest->getVal('undo', 0)) != 0;
		$wgHooks['GetHTMLAfterBody'][] = array($this, 'render');
	}

	public function render($skin, &$html) {
		wfRunHooks('BeforeEditEnhancements', array(&$this) );
		
		if($this->action == 'edit' && !$this->undo ) {
			$this->editPageJS($skin, $html);
		} else if ($this->action == 'submit' || $this->undo) {
			$this->previewJS($skin, $html);
		}
		return true;
	}
	
	public function editPageJS($skin, &$html) {
		global $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgJsMimeType;
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/EditEnhancements/js/EditEnhancements.js?{$wgStyleVersion}\"></script>");

		return true;
	}

	public function previewJS($skin, &$html) {
		global $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgJsMimeType;
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/EditEnhancements/js/EditEnhancementsPreview.js?{$wgStyleVersion}\"></script>");
		
		return true;
	}
}