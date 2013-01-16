<?php
class WikiaStyleGuideTooltipIconController extends WikiaController {
	const DEFAULT_ICON_SIGN = '?';
	
	public function index() {
		$this->text = $this->request->getVal('text', '');
		$this->tooltipIconTitle = $this->request->getVal('tooltipIconTitle', '');
		$this->tooltipIconSign = $this->request->getVal('tooltipIconSign', self::DEFAULT_ICON_SIGN);
	}
}