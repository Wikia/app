<?php

abstract class LayoutWidgetBase {

	private $attributes = array();
	protected $value = null;
	protected $error = 0;

	abstract public function getName();
	abstract public function renderForForm();
	abstract public function renderForPreview();

	abstract public function renderForResult();
	abstract public function renderForResultEmpty($url);

	abstract public function renderForRTE();


	public function  __construct($attributes = array(), $value = null, $error = 0) {
		$this->attributes = $attributes;
		$this->value = $value;
		$this->error = $error;
	}

	/*
	 * @return layoutWidgetBase
	 */
	public static final function getNewWidget($tag, $attributes = array(), $value = null, $error = 0, $parser = null) {
		global $wgPLBwidgets;
		
		if(empty($wgPLBwidgets[$tag])) {
			return null;
		}

		$class = new $wgPLBwidgets[$tag]($attributes, $value, $error);
		if($class->getName() == $tag) {
			$class->parser = $parser;
			return $class;
		}

		return null;
	}
//TODO: use staitc or move to parser class ?
	public static function runReverseParser(DOMElement $element) {
		global $wgPLBwidgets;

		$data = RTEReverseParser::getRTEData($element);

		if(!is_array($data)) {
			return "";
		}

		if(isset($data["__plb_type"]) && in_array($data["__plb_type"], array_keys($wgPLBwidgets))) {
			$class = self::getNewWidget($data["__plb_type"]);
			$params = array();
			foreach($class->getAllAttrs() as $key => $value ) {
				if(isset( $data["__plb_param_".$key] )) {
					$params[$key] = $data["__plb_param_".$key];
				}

			}

			if($class->isParagraph()) {
				//TODO: solution to the problem of dressed in p more sophisticated way
				return RTEParser::markEntities(Xml::element($data["__plb_type"], $params))."\n";
			} else {
				return RTEParser::markEntities(Xml::element($data["__plb_type"], $params));
			}
		}
		return "";
	}



	public function validateAttribute(array &$elements) {
		$list = $this->getRequiredAttrs();
		$list[] = 'id';

		foreach($list as $value) {
			if(!isset($this->attributes[$value])) {
				return wfMsg('plb-parser-no-attribute', array('$1' => $value) );
			}
		}

		$id = (int) $this->attributes['id'];

		if( $id < 1 ) {
			return wfMsg("plb-parser-id-not-int");
		}

		if( strlen($id) > 9 ) {
			return wfMsg("plb-parser-id-too-long");
		}

		$ids = array_keys($elements);
		if( in_array($id, $ids) ) {
			return wfMsg("plb-parser-id-not-unique");
		}

		$elements[$id] = array(
			"type" => $this->getName() ,
			"attributes" => $this->attributes
		);

		return true;
	}

	public function renderForFormCaption() {
		return XML::element('p', array('class' => 'plb-form-caption-p'), $this->getAttrVal( "caption", true ));
	}

	protected function validateAllowedVal($name, $vals = array() ) {
		if( !$this->hasAttr( $name )) {
			return true;
		}
		if( in_array($this->getAttrVal( $name ), $vals) ) {
			return true;
		}
		return false;
	}

	public function validateForm() {
		if((!empty($this->attributes['required'])) && ($this->attributes['required'] == 1) && empty($this->value)) {
			return array(wfMsg('plb-special-form-none-value', array('$1' => $this->value)));
		}
		return true;
	}

	public function isEmpty() {
		if( empty( $this->value )) {
			return true;
		}
		return false;
	}

	public function getAttrVal($name, $default = false) {
		/* set daefult values */
		$params = $this->getAllAttrs();
		if($default) {
			if(!empty($this->attributes[$name])){
				return $this->attributes[$name];
			}
			if(!empty($params[$name])){
				return $params[$name];
			} else {
				return "";
			}
		} else {
			return isset($this->attributes[$name]) ? $this->attributes[$name]:"";
		}
	}

	public function hasAttr($name) {
		return !empty($this->attributes[$name]);
	}


	public function getBaseParamForRTE() {
		$base = array(
			'contenteditable' => 'false',
			'formateditable' => 'true',
			'__plb_type' => $this->getName(),
		);
		return $base;
	}

	public function RTEElementDecoratorAndRender( $directly = false ) {
		$data = array(
			'placeholder' => true,
			'custom-placeholder' => true,
			'__plb_type' => $this->getName(),
		);
		foreach(array_keys($this->getAllAttrs()) as $name ) {
			if(isset($this->attributes[$name])) {
				$data["__plb_param_".$name] = $this->attributes[$name];
			}
		}
		if ($directly) {
			return RTEData::addDataToTag($data, $this->renderForRTE());
		} else {
			$dataIdx = RTEData::put('data', $data);
			return RTEData::addIdxToTag($dataIdx, $this->renderForRTE());
		}
	}

	public function renderEditorMenuItem() {
		global $wgExtensionsPath;
		return
			"<li __plb_type=\"{$this->getName()}\"><img src=\"$wgExtensionsPath/wikia/PageLayoutBuilder/widget/images/widget-icon-{$this->getName()}.png\" alt=\"\">".wfMsg('plb-widget-name-'.$this->getName())."</li>";
	}

	public function renderEditorListItem() {
		global $wgExtensionsPath;
		$name = wfMsg('plb-widget-name-'.$this->getName());
		return
			"<li class='plb-widget-list-entry plb-widget-list-entry-{$this->getName()}' __plb_id=\"[\$ID]\">"
			."<img src=\"$wgExtensionsPath/wikia/PageLayoutBuilder/widget/images/widget-icon-{$this->getName()}.png\" alt=\"\">"
			."<span class=\"details\">"
			."<span class=\"type\">$name</span>"
			."[\$CAPTION]</span></span>"
			."[\$BUTTONS]</li>";
	}

	public function getRequiredAttrs() {
		return array(
				'id',
				'caption'
		);
	}

	public function getAllAttrs() {
		//param name => default value
		wfLoadExtensionMessages( 'PageLayoutBuilder' );
		return array(
				'id' => '',
				'caption'  => '',//wfMsg('plb-parser-default-caption'),
				'instructions' => '',//wfMsg('plb-parser-default-instructions'),
				'required' => 0,
		);
	}

	public function getAttrCaptions() {
		$messages = array();
		$this->overrideAttrCaptions($messages);
		$attrs = $this->getAllAttrs();
		foreach ($attrs as $name => $value) {
			if (empty($messages[$name])) {
				$messages[$name] = wfMsg("plb-property-editor-$name");
			}
		}
		return $messages;
	}

	public function isParagraph() {
		return false;
	}

	// to be overriden (optional)
	protected function overrideAttrCaptions( &$messages ) {
		return;
	}

	protected function getRTEUIMarkup() {
		$content = "&nbsp;";
//		$content = "";
		//" contenteditable=\"false\"";
		return
			 "<span class=\"plb-rte-widget-box-icon\">$content</span>"
			."<span class=\"plb-rte-widget-horiz-line plb-rte-widget-top-line\">$content</span>"
			."<span class=\"plb-rte-widget-horiz-line plb-rte-widget-bottom-line\">$content</span>"
			."<span class=\"plb-rte-widget-edit-button-placer\">"
				."<button class=\"plb-rte-widget-edit-button wikia-button secondary\">".htmlspecialchars(wfMsg('plb-editor-edit'))."</button></span>";
	}

}
