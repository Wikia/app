<?php

class LayoutWidgetMultiLineInput extends LayoutWidgetInput {
	public function getName() {
		return 'plb_mlinput';
	}

	public function renderForForm() {
		$style = "";
		if($this->error) {
			$style = "border-color: red; border-style: solid;";
		}

		$instructions = strtr( $this->getAttrVal('instructions', true), array(
			'&#10;' => "\n",
			'&#13;' => "\r",
			'&#9;' => "\t",
		));
		
		return XML::element('textarea',
							array(
								'name' => 'plb_'.$this->getAttrVal("id"),
								'type' => 'text',
								'data-instructions' => $instructions,
								'style' => $style,
								'class' => 'plb-mlinput-textarea plb-input-instructions '.(empty($this->value) ? "plb-empty-input":""),
							),
							empty($this->value) ? $instructions : $this->value,
							false );
	}

	public function renderForPreview() {
		wfLoadExtensionMessages( 'PageLayoutBuilder' );
		return "<p>".wfMsg('plb-parser-preview-mlinput')."</p>";
	}

	public function renderForResult() {
		// BugzId: 4892. There might be a better way to do this.
		$this->value = str_replace("\r", "", $this->value);
		$this->value = str_replace("\n\n", "</p><p>", $this->value);

		return "<p>\n".$this->value."\n</p>";
	}

	public function renderForResultEmpty($url) {
		return "<p>".wfMsg("plb-parser-empty-value", array("%1" => $url ))."</p>";
	}

	public function renderForRTE() {
		wfLoadExtensionMessages("PageLayoutBuilder");
		$caption = $this->getAttrVal('caption'); // is not default value is error message for RTE
		$sampleText = wfMsg('plb-parser-preview-mlinput');
		return
			XML::openElement('p',
				array(
					"class" => "plb-rte-widget plb-rte-widget-plb_mlinput",
				) + $this->getBaseParamForRTE())
			."<span class=\"plb-rte-widget-caption\">"
				.htmlspecialchars(empty($caption) ? wfMsg("plb-editor-enter-caption") : $caption)
				."</span>"
			."<span class=\"plb-rte-widget-sample-text\">" . htmlspecialchars($sampleText) . "</span>"
			.$this->getRTEUIMarkup()
			.XML::closeElement('p');
	}

	function isParagraph() {
		return true;
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

