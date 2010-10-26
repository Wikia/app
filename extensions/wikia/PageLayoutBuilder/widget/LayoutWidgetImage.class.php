<?php

class LayoutWidgetImage extends LayoutWidgetBase {
	public function getName() {
		return 'plb_image';
	}

	public function renderForForm() {
		global $wgExtensionsPath;

		wfLoadExtensionMessages( 'PageLayoutBuilder' );

		$data['error'] = "";

		if($this->error) {
			$style = "border-color: maroon;";
			$data['error'] = $style;
		}

		//TODO move image to other place ?

		$data['caption'] = $this->getCaption();
		$data['align'] =  $this->getAlign("left");
		$data['isform'] = true;
		$data['isempty'] = false;
		$data['username'] = wfMsg('plb-parser-preview-image-username');
		$data['width'] = $this->getAttrVal( 'size', true );
		$data['size'] = $this->getAttrVal( 'size', true );
		$data['id'] = 'plb_'.$this->getAttrVal('id', true);
		$data['img'] = "";
		$data['value'] = $this->getValue();

		$img = null;

		if(!empty($this->value)) {
			$file_title = Title::newFromText( $this->getValue() ,NS_FILE );
			$img = wfFindFile( $file_title  );
		}

		if(empty($img)) {
			$data['divwidth'] =  $data['width'] + 4;
			$data['height'] = round($data['width']/4)*3;
		} else {
			$size = $this->getImageSize($this->getAttrVal( 'size', true ), $img);
			$data['height'] = $size['height'];
			$data['width'] = $size['width'];

			$user = User::newFromName($img->getUser());
			$data['username'] = $user->getName();
			$data['divwidth'] =  $data['width'];
			$data['img'] = wfReplaceImageServer( $img->getThumbUrl( $data['width']."px-" . $img->getName()  ) );
		}
		return $this->renderForPreviewAndForm($data).XML::element('input',array(
								'name' => 'plb_'.$this->getAttrVal('id', true),
								'id' => 'plb_'.$this->getAttrVal('id', true),
								'type' => 'hidden',
								'value' => $this->getValue()
							), "", true );
	}

	public function renderForResult() {
		$caption = $this->getCaption();
		$caption = str_replace( array('|', ']', '[') , array('&#124;', '&#93;', '&#91;'), $caption);

		if($this->getAttrVal('type', true) == 'frameless') {
			return "[[ Image:".$this->getValue()." | frameless | " . $this->getAttrVal("align", true) . " | " . $this->getAttrVal("size", true) . "px | " . $caption . " ]]";
		} else {
			return "[[ Image:".$this->getValue()." | thumb |" . $this->getAttrVal("align", true) . " | " . $this->getAttrVal("size", true) . "px | " . $caption . " ]]";
		}
	}

	public function renderForResultEmpty(Title $title) {
		global $wgExtensionsPath, $wgTitle;

		wfLoadExtensionMessages( 'PageLayoutBuilder' );
		$data['error'] = "";
		$data['id'] = "";
		$data['isform'] = true;
		$data['isempty'] = true;
		$data['editurl'] = $wgTitle->getFullUrl("action=edit");
		$data['img'] = "";
		$data['avatar'] = $wgExtensionsPath.'/wikia/PageLayoutBuilder/widget/images/user.jpg';
		$data['caption'] = $this->getAttrVal( 'caption');
		$data['width'] = $this->getAttrVal( 'size', true );
		$data['divwidth'] =  $data['width'] + 4;
		$data['height'] = round($data['width']/4)*3;
		$data['align'] =  $this->getAlign();
		$data['username'] = wfMsg('plb-parser-preview-image-username');

		return $this->renderForPreviewAndForm($data);
	}

	private function getValue() {
		if(empty($this->value)) {
			return "";
		}

		$pos = strpos($this->value, "|");
		if($pos === false) {
			return trim($this->value);
		}

		$out = explode('|', $this->value, 2);
		return trim($out[0]);
	}

	private function getCaption() {
		if(empty($this->value)) {
			$this->getAttrVal("caption", true);
		}

		$pos = strpos($this->value, "|");
		if($pos === false) {
			return $this->getAttrVal("caption", true);
		}
		$out = explode('|', $this->value, 2);
		return trim($out[1]);
	}

	public function renderForPreview() {
		global $wgExtensionsPath;

		wfLoadExtensionMessages( 'PageLayoutBuilder' );
		$data['error'] = "";
		$data['isform'] = false;
		$data['isempty'] = false;
		$data['img'] = $wgExtensionsPath.'/wikia/PageLayoutBuilder/images/picture-placeholder.png';
		$data['avatar'] = $wgExtensionsPath.'/wikia/PageLayoutBuilder/widget/images/user.jpg';
		$data['caption'] = $this->getAttrVal( 'caption');
		$data['width'] = $this->getAttrVal( 'size', true );
		$data['divwidth'] =  $data['width'] + 4;
		$data['height'] = round($data['width']/4)*3;
		$data['align'] =  $this->getAlign();
		$data['username'] = wfMsg('plb-parser-preview-image-username');

		return $this->renderForPreviewAndForm($data);
	}

	private function renderForPreviewAndForm($data) {
		$data['instructions'] = $this->getAttrVal( 'instructions', true );

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates" );
		$oTmpl->set_vars(array(
				"data" => $data
		));

		if($this->getAttrVal('type', true) == 'frameless') {
			return $oTmpl->render( "plb-parser-image-frameless" );
		} else {
			return $oTmpl->render( "plb-parser-image-frame" );
		}
	}

	public function renderForRTE() {
		global $wgExtensionsPath;
		wfLoadExtensionMessages("PageLayoutBuilder");
		$caption = $this->getAttrVal('caption',''); // is not default value is error message for RTE

		$tagOptions = array();
		$align = $this->getAttrVal('align');
		if ($align == 'left') {
			$tagOptions['style'] = 'float: left; clear: left;';
		} else {
			$tagOptions['style'] = 'float: right; clear: right;';
		}

		return
			XML::openElement('span',
				$tagOptions
				+ array(
					"class" => "plb-rte-widget plb-rte-widget-plb_image" )
				+ $this->getBaseParamForRTE())
			."<span contenteditable=\"false\" class=\"plb-rte-widget-caption\">"
				.htmlspecialchars(empty($caption) ? wfMsg("plb-editor-enter-caption") : $caption)
				."</span>"
			."<img contenteditable=\"false\" src=\"$wgExtensionsPath/wikia/PageLayoutBuilder/images/picture-placeholder.png\" style=\"width: ".$this->getAttrVal('size',150)."px\" alt=\"".htmlspecialchars($caption)."\">"
			.XML::closeElement('span');
	}

	public function validateAttribute(array &$elements) {
		$out = parent::validateAttribute($elements);
		if( $out !== true ) {
			return $out;
		}

		if($this->hasAttr("size")) {
			$size = (int) $this->getAttrVal( "size" );

			if( $size < 1 ) {
				return wfMsg( 'plb-parser-image-size-not-int' );
			}

			if( $size > 1000 ) {
				return wfMsg( 'plb-parser-image-size-too-big' );
			}
		}

		if( !$this->validateAllowedVal( "align", array('left','center','right') )) {
			return  wfMsg( 'plb-parser-image-incorrect-align' );
		}

		if( !$this->validateAllowedVal( "type", array('thumb','frameless') )) {
			return  wfMsg( 'plb-parser-image-incorrect-frame' );
		}

		//thumb,frameless,border,frame

		return true;
	}

	private function getAlign($inAlign = "") {
		$inAlign = empty($inAlign) ? $this->getAttrVal( 'align', true):$inAlign;
		if( $this->getAttrVal( 'type', true ) == 'frameless' ) {
			$align =  'float' . $inAlign;

			if($align == 'floatcenter') {
				$align = "floatnone";
			}
		} else {
			$align =  't' . $inAlign;

			if($align == 'tcenter') {
				$align = "tnone";
			}
		}

		return $align;
	}

	static private function getImageSize($width, $img) {
		if($width > $img->getWidth()) {
			$width = $img->getWidth();
			$height = $img->getHeight();
		} else {
			$height = round(($width/$img->getWidth())*$img->getHeight() );
		}

		return array("width" => $width, "height" => $height);
	}

	static public function getUrlImageAjax() {
		global $wgRequest;
		$name = $wgRequest->getVal("name", "");
		$size = (int) $wgRequest->getVal("size", "");

		if(!empty($name)) {
			$file_title = Title::newFromText( $name, NS_FILE );
			$img = wfFindFile( $file_title  );
		}

		$response = new AjaxResponse();

		if(empty($img)) {
			$response->addText(json_encode(array("status" => "error")));
			return $response;
		}

		$sizeOut = self::getImageSize($size, $img);
		$response->addText(json_encode(array("status" => "ok",
				"url" => wfReplaceImageServer( $img->getThumbUrl( $sizeOut["width"]."px-" . $img->getName()  ) ),
				"size" => $sizeOut
		)));
		return $response;
	}

	//private function get
	public function getAllAttrs() {
		//param name => default value
		//border and/or frameless, frame, thumb (or thumbnail);
		return array(
				'id' => '',
				'caption'  => '',
				'instructions' => '',
				'required'  => 0,
				'align' => 'left',
				'size' => '150',
				'type' => 'frameless'
		);
	}

	protected function overrideAttrCaptions( &$messages ) {
		$messages['align'] = wfMsg('plb-property-editor-alignment');
		$messages['size'] = wfMsg('plb-property-editor-maximum-width');
		$messages['type'] = wfMsg('plb-property-editor-thumbnail');
	}
}
