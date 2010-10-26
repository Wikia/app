<?php

class LayoutWidgetSelectInput extends LayoutWidgetBase {
	public function getName() {
		return 'plb_sinput';
	}

	public function renderForForm() {
		$style = "";
		if($this->error) {
			$style = "border-color: maroon;";
		}

		$out = XML::openElement('select',
							array(
								'name' => 'plb_'.$this->getAttrVal('id', true),
								'type' => 'text',
								'value' => $this->value,
								'style' => $style
							));


		if( empty($this->value) ) {
			$out .= XML::element("option", array("value" => "", "class" => "plb-empty-input"), $this->getAttrVal("instructions", true));
		}

		$options = explode("|", $this->getAttrVal("options"));
		foreach($options as $value) {
			$attr  = array("value" => $value);
			if($this->value == $value) {
				$attr['selected'] = 'selected';
			}
			$out .= XML::element("option", $attr, $value);
		}
		$out .= XML::closeElement('select');
		return $out;
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
					"class" => "plb-rte-widget plb-rte-widget-plb_sinput",
				) + $this->getBaseParamForRTE())
			."<span contenteditable=\"false\" class=\"plb-rte-widget-caption\">"
				.htmlspecialchars(empty($caption) ? wfMsg("plb-editor-enter-caption") : $caption)
				."</span>"
			.XML::closeElement('span');
	}

	public function getRequiredAttrs() {
		return array(
				'id',
				'caption',
				'options'
		);
	}

	public function getAllAttrs() {
		//param name => default value
		return array(
				'id' => '',
				'caption'  => '',
				'instructions' => '',
				'required'  => 0,
				'options' => '',
		);
	}

	protected function overrideAttrCaptions( &$messages ) {
		$messages['options'] = wfMsg('plb-property-editor-choices');
	}
}
