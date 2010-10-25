<?php

class LayoutWidgetInput extends LayoutWidgetBase {
	public function getName() {
		return 'plb_input';
	}

	public function renderForForm() {
		$style = "";
		if($this->error) {
			$style = "border-color: maroon;";
		}

		return XML::element('input',
							array(
								'name' => 'plb_'.$this->getAttrVal('id', true),
								'type' => 'text',
								'value' => empty($this->value) ? $this->getAttrVal('instructions', true):$this->value,
								'class' => "plb-input ".(empty($this->value) ? "plb-empty-input":""),
								'style' => $style,
							),
							"",
							true );
	}

	public function renderForResult() {
		return $this->value;
	}

	public function renderForResultEmpty(Title $title) {
		return wfMsg("plb-parser-empty-value", array("%1" => $title->getFullURL("action=edit"))) ;
	}

	public function renderForPreview() {
		wfLoadExtensionMessages( 'PageLayoutBuilder' );
		return wfMsg('plb-parser-preview-input');
	}

	public function renderForRTE() {
		wfLoadExtensionMessages("PageLayoutBuilder");
		$caption = $this->getAttrVal('caption'); // is not default value is error message for RTE
		return
			XML::openElement('span',
				array(
					"class" => "plb-rte-widget plb-rte-widget-plb_input",
				) + $this->getBaseParamForRTE())
			."<span contenteditable=\"false\" class=\"plb-rte-widget-caption\">"
				.htmlspecialchars(empty($caption) ? wfMsg("plb-editor-enter-caption") : $caption)
				."</span>"
			.XML::closeElement('span');
	}
}

