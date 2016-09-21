<?php
class WikiaStyleGuideTooltipIconController extends WikiaService {
	/**
	 * @desc Renders simple markup for a circle with a sign within it
	 * 
	 * @responseParam string tooltipIconTitle (required) The text which will fill tooltip's content (or just value of title attribute)
	 * @responseParam string text (optional) Text before the icon if not given will set empty string
	 * @responseParam string classes (optional) Additional classes separated with a comma which will be added to the icon <span /> 
	 * @responseParam string tooltipIconSign (optional) The sign which should be within the icon, by default question mark
	 */
	public function index() {
		$this->tooltipIconTitle = $this->request->getVal('tooltipIconTitle');
		
		$this->text = $this->request->getVal('text', '');
		$this->classes = $this->request->getVal('classes', '');
		$this->tooltipIconSign = $this->request->getVal('tooltipIconSign', wfMsg('wikiastyleguide-tooltip-icon-question-mark'));
	}
}