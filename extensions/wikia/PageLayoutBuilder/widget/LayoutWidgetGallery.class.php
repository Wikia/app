<?php

class LayoutWidgetGallery extends LayoutWidgetImage {
	public function getName() {
		return 'plb_gallery';
	}

	public function renderForForm() {
		global $wgExtensionsPath;

		wfLoadExtensionMessages( 'PageLayoutBuilder' );

		$data['error'] = "";

		if($this->error) {
			$style = "border-color: red; border-style: solid;";
			$data['error'] = $style;
		}
		
		$data['caption'] = $this->getCaption();
		$data['align'] =  $this->getAlign("left");
		$data['isform'] = true;
		$data['isempty'] = false;
		$data['username'] = wfMsg('plb-parser-preview-image-username');
		$data['size'] =150;
		$data['width'] = $data['size'];
		$data['id'] = $this->getAttrVal('id', true);
		$data['img'] = "";
		$data['value'] = $this->getValue();
		$data['height'] = round($data['width']/4)*3;
		$img = null;

		$input = XML::element('input',array(
								'name' => 'plb_'.$this->getAttrVal('id', true),
								'id' => 'plb_'.$this->getAttrVal('id', true),
								'type' => 'hidden',
								'value' => $this->getValue()
							), "", true );
							
		if(!empty($this->value)) {
			return $this->parseGallery($this->value).$input;
		}
		
		return $this->renderForPreviewAndForm($data).$input;
	}
	
	public static function renderForFormAjax() {
		global $wgRequest;
		
		$element_id= $wgRequest->getVal('element_id', 0);
		$plb_id = $wgRequest->getVal('plb_id', 0);
		$text = $wgRequest->getVal('gallery');
		
		$out = PageLayoutBuilderModel::getElement($plb_id, $element_id);
		$class = LayoutWidgetBase::getNewWidget('plb_gallery', $out['attributes'], $text);
		return $class->parseGallery($text);
	}
	
	
	public static function getGalleryDataAjax() {
		global $wgRequest;
		
		WikiaPhotoGalleryHelper::initParserHook();
		$text = $wgRequest->getVal('text'); 
		
		$element_id= $wgRequest->getVal('element_id', 0);
		$plb_id = $wgRequest->getVal('plb_id', 0);
		$text = $wgRequest->getVal('text');
		
		$out = PageLayoutBuilderModel::getElement($plb_id, $element_id);
		
		$class = LayoutWidgetBase::getNewWidget('plb_gallery', $out['attributes'], $text);
		$class->parseGallery($text);
		
		return Wikia::json_encode(WikiaPhotoGalleryHelper::$lastGalleryData); 
	}
	
	private function getMwText($value, $parmas = array()) {
		return XML::element('gallery', $parmas, $value, false );
	} 
	
	public function parseGallery( $text ) {
		$params = array(
			'position' => $this->getAttrVal("align", true),
			'spacing'=> $this->getAttrVal("spacing", true),
			'widths' => $this->getAttrVal("size", true),
		 	'captionalign' => 'left' 
		); 
		
		$articleText = $this->getMwText($text, $params);
		$tmpParser = new Parser();
		$tmpParser->setOutputType(OT_HTML);
		$tmpParserOptions = new ParserOptions();
		$fakeTitle = new FakeTitle();
		$html = $tmpParser->parse( $articleText, $fakeTitle, $tmpParserOptions)->getText();		
		$html = str_replace( 'id="gallery-0"', 'id="gallery-plb_'.$this->getAttrVal("id", true).'"',  $html );
		
		return $html;
	}
	
	public function renderForResult() {
		$params = array(
			'position' => $this->getAttrVal("align", true),
			'spacing'=> $this->getAttrVal("spacing", true),
			'widths' => $this->getAttrVal("size", true),
		 	'captionalign' => 'left' 
		); 
		
		return XML::element('gallery', $params, $this->getValue(), false );
	}

	public function renderForResultEmpty($url) {
		global $wgExtensionsPath, $wgTitle;

		wfLoadExtensionMessages( 'PageLayoutBuilder' );
		$data['error'] = "";
		$data['id'] = "";
		$data['isform'] = true;
		$data['isempty'] = true;
		$data['editurl'] = $url;
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
		global $wgExtensionsPath, $wgHooks;
		$wgHooks['GalleryBeforeRenderImage'][] =  'LayoutWidgetGallery::renderImageForPreview';
		return self::parseGallery("1.png\n2.png\n3.png\n4.png\n5.png\n6.png", 0);
	}
	
	public static function renderImageForPreview(&$image) {
		global $wgExtensionsPath;
		$image['link'] = "#";
		$image['thumbnail'] = $wgExtensionsPath.'/wikia/PageLayoutBuilder/images/picture-placeholder.png';
		return true;
	}

	private function renderForPreviewAndForm($data) {
		$data['instructions'] = $this->getAttrVal( 'instructions', true );
		$data['type'] = "gallery";
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates" );
		$oTmpl->set_vars(array(
				"data" => $data
		));
		return $oTmpl->render( "plb-parser-image-frameless" );
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
			."<img contenteditable=\"false\" src=\"$wgExtensionsPath/wikia/PageLayoutBuilder/images/picture-placeholder.png\" style=\"width: 185px\" alt=\"".htmlspecialchars($caption)."\">"
			.$this->getRTEUIMarkup()
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
				return wfMsg( 'plb-parser-gallery-size-not-int' );
			}

			if( $size < 50 ) {
				return wfMsg( 'plb-parser-gallery-size-too-small' );
			}
			
			if( $size > 310 ) {
				return wfMsg( 'plb-parser-gallery-size-too-big' );
			}
		}
/*
Photo size: 185px (variable from 50 to 310)
Position: left (variable to centre & right)
Photo spacing: Medium (variable to small & large)

No. columns FIXED to "fit to page" and not available as an option
Photo orientation: FIXED to "leave in original shape"
*/
		if( !$this->validateAllowedVal( "spacing", array('small','medium','large') )) {
			return  wfMsg( 'plb-parser-gallery-incorrect-spacing' );
		}
				
		if( !$this->validateAllowedVal( "align", array('left','center','right') )) {
			return  wfMsg( 'plb-parser-gallery-incorrect-align' );
		}

		return true;
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
				'size' => '185',
				'align' => 'left',
				'spacing' => 'large',		
				'type' => 'frameless'
		);
	}

	protected function overrideAttrCaptions( &$messages ) {
		$messages['align'] = wfMsg('plb-property-editor-alignment');
		$messages['size'] = wfMsg('plb-property-editor-maximum-width');
		$messages['type'] = wfMsg('plb-property-editor-thumbnail');
	}
}
