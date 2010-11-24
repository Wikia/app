<?php

class LayoutWidgetSelectInput extends LayoutWidgetBase {
	public function getName() {
		return 'plb_sinput';
	}

	public function renderForForm() {
		$style = "";
		if($this->error) {
			$style .= "border-color: red; border-style: solid;";
		}

		$out = XML::openElement('select',
							array(
								'name' => 'plb_'.$this->getAttrVal('id', true),
								'type' => 'text',
								'value' => $this->value,
								'style' => $style,
								'class' => empty($this->value) ? "plb-empty-select":""
							));


		if( empty($this->value) ) {
			$out .= XML::element("option", array("value" => "", "class" => "plb-empty-input"), $this->getAttrVal("instructions", true));
		}

		$options = explode("|", $this->getAttrVal("options"));
		foreach($options as $value) {
			$attr  = array("value" => $value);
			if($this->value == $value) {
				$attr['selected'] = 'selected';
				$attr['option'] = 'normal';
			}
			$out .= XML::element("option", $attr, $value);
		}
		$out .= XML::closeElement('select');
		return $out;
	}

	public function renderForResult() {
		return $this->value;
	}

	public function renderForResultEmpty($url) {
		return wfMsg("plb-parser-empty-value", array("%1" => $url )) ;
	}

	public function renderForPreview() {
		wfLoadExtensionMessages( 'PageLayoutBuilder' );
		return wfMsg('plb-parser-preview-input');
	}

	public function renderForRTE() {
		wfLoadExtensionMessages("PageLayoutBuilder");
		$caption = $this->getAttrVal('caption'); // is not default value is error message for RTE
		$sampleText = wfMsg('plb-parser-preview-sinput');
		return
			XML::openElement('span',
				array(
					"class" => "plb-rte-widget plb-rte-widget-plb_sinput",
				) + $this->getBaseParamForRTE())
			."<span class=\"plb-rte-widget-caption\">"
				.htmlspecialchars(empty($caption) ? wfMsg("plb-editor-enter-caption") : $caption)
				."</span>"
			."<span class=\"plb-rte-widget-sample-text\">" . htmlspecialchars($sampleText) . "</span>"
			.$this->getRTEUIMarkup()
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
