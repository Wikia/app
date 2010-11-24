<?php

class LayoutWidgetInput extends LayoutWidgetBase {
	public function getName() {
		return 'plb_input';
	}

	public function renderForForm() {
		$style = "";
		if($this->error) {
			$style = "border-color: red; border-style: solid;";
		}

		return XML::element('input',
							array(
								'name' => 'plb_'.$this->getAttrVal('id', true),
								'type' => 'text',
								'value' => empty($this->value) ? $this->getAttrVal('instructions', true):$this->value,
								'class' => "plb-input-instructions plb-input ".(empty($this->value) ? "plb-empty-input":""),
								'style' => $style,
							),
							"",
							true );
	}

	public function renderForResult() {
		return $this->value;
	}

	public function renderForResultEmpty($url) {
		return wfMsg("plb-parser-empty-value", array("%1" =>$url)) ;
	}

	public function renderForPreview() {
		wfLoadExtensionMessages( 'PageLayoutBuilder' );
		return wfMsg('plb-parser-preview-input');
	}

	public function renderForRTE() {
		wfLoadExtensionMessages("PageLayoutBuilder");
		$caption = $this->getAttrVal('caption'); // is not default value is error message for RTE
		$sampleText = wfMsg('plb-parser-preview-input');
		return
			XML::openElement('span',
				array(
					"class" => "plb-rte-widget plb-rte-widget-plb_input",
				) + $this->getBaseParamForRTE())
			."<span class=\"plb-rte-widget-caption\">"
				.htmlspecialchars(empty($caption) ? wfMsg("plb-editor-enter-caption") : $caption)
				."</span>"
			."<span class=\"plb-rte-widget-sample-text\">" . htmlspecialchars($sampleText) . "</span>"
			.$this->getRTEUIMarkup()
			.XML::closeElement('span');
	}
}

