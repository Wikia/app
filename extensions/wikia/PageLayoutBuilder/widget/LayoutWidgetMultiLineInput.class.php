<?php

class LayoutWidgetMultiLineInput extends LayoutWidgetInput {
	public function getName() {
		return 'plb_mlinput';
	}

	public function renderForForm() {
		$style = "";
		if($this->error) {
			$style = "border-color: maroon;";
		}

		return XML::element('textarea',
							array(
								'name' => 'plb_'.$this->getAttrVal("id"),
								'type' => 'text',
								'style' => $style,
								'class' => 'plb-mlinput-textarea '.(empty($this->value) ? "plb-empty-input":""),
							),
							empty($this->value) ? $this->getAttrVal('instructions', true) : $this->value,
							false );
	}

	public function renderForPreview() {
		wfLoadExtensionMessages( 'PageLayoutBuilder' );
		return wfMsg('plb-parser-preview-mlinput');
	}

	public function renderForRTE() {
		wfLoadExtensionMessages("PageLayoutBuilder");
		$caption = $this->getAttrVal('caption'); // is not default value is error message for RTE
		$sampleText = wfMsg('plb-parser-preview-mlinput');
		return
			XML::openElement('span',
				array(
					"class" => "plb-rte-widget plb-rte-widget-plb_mlinput",
				) + $this->getBaseParamForRTE())
			."<span contenteditable=\"false\" class=\"plb-rte-widget-caption\">"
				.htmlspecialchars(empty($caption) ? wfMsg("plb-editor-enter-caption") : $caption)
				."</span>"
			."<span contenteditable=\"false\" class=\"plb-rte-widget-sample-text\">" . htmlspecialchars($sampleText) . "</span>"
			.XML::closeElement('span');
	}

	public function getAllAttrs() {
		//param name => default value
		return array(
				'id' => '',
				'caption'  => '',
				'instructions' => '',
				'required'  => 0,
		);
	}
}

