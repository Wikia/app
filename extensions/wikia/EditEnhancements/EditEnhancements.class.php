<?php

class EditEnhancements {

	private $action;
	private $undo;
	private $tmpl;

	function __construct($action = '') {
		global $wgHooks, $wgRequest;

		$this->action = $action;
		$this->undo = intval($wgRequest->getVal('undo', 0)) != 0;

		if($this->action == 'edit' && !$this->undo) {
			$wgHooks['GetHTMLAfterBody'][] = array(&$this, 'editPageJS');
		} else if ($this->action == 'submit' || $this->undo) {
			$wgHooks['GetHTMLAfterBody'][] = array(&$this, 'previewJS');
		}

		$this->tmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
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