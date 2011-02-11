<?php

class PageLayoutBuilderParser extends Parser {
	public $mPlbFormElements = array();
	public $formValues = array();
	public $errorsList = array();
	public $isRTE = false;
	public function parse( $text, $title, $tmpParserOptions) {
		$self->mPlbFormElements = array();
		$out = parent::parse($text, $title, $tmpParserOptions);
		$out->mPlbFormElements = $this->mPlbFormElements;
		return $out;
	}

	public function parseForLayoutPreview( $text, $title, $type = "form" ) {
		global $wgUser;
		$parserOptions = ParserOptions::newFromUser($wgUser);
		$parserOptions->setEditSection( false );
		$parserOptions->setIsPreview( true );
		if($type == "article"){
			$parserOptions->isArticlePreview = true;
		} else {
			//TODO: optimalize it and don't use MW parser to render FORM
			$text = $this->preParseForm($text);
		}
		$this->setOutputType(OT_HTML);
		$out = $this->parse($text, $title, $parserOptions);
		return $out;
	}

	public function parseForArticlePreview( $text, $title ) {
		global $wgUser;
		$parserOptions = ParserOptions::newFromUser($wgUser);
		$parserOptions->setEditSection( false );
		$parserOptions->setIsPreview( true );
		$this->setOutputType(OT_HTML);
		$out = $this->parse($text, $title, $parserOptions);
		return $out;
	}

	public function preParserArticle($text, $title) {
		global $wgUser;
		$parserOptions = ParserOptions::newFromUser($wgUser);
		$parserOptions->setEditSection( false );
		$parserOptions->setIsPreview( true );
		$parserOptions->isPreparse = true;
		$this->setOutputType(OT_HTML);
		$out = $this->parse($text, $title, $parserOptions);
		return $out;
	}

	public function preParseForm($text) {
		global $wgPLBwidgets;

		$elements = array_keys($wgPLBwidgets);
		$elementsOut = array();

		$dom = new simple_html_dom;
		$dom->load($text, false);

		$textOut = "";
		foreach($dom->find(implode(",", $elements)) as $element) {
			$textOut .= $element->outertext . "\n";
		}
		return $textOut;
	}

	public static function reverseParser($node, &$out) {
		$out .= LayoutWidgetBase::runReverseParser($node);
		return true;
	}

	//TODO: test it
	public static function isArticleFromLayout($text) {
		$dom = new simple_html_dom;
		$dom->load($text, false);

		foreach($dom->find("plb_layout") as $element) {
			return true;
		}

		return false;
	}

	public static function init(&$parser){
		global $wgPLBwidgets;
		foreach ($wgPLBwidgets as $tag => $className) {
			$parser->setHook($tag, 'PageLayoutBuilderParser::parserTag');
		}

		$parser->setHook('plb_layout', 'PageLayoutBuilderParser::parserLayoutTag');
		return true;
	}

	public static function parserTag( $content, $attributes, Parser $self ) {
		global $wgEnableRTEExt, $wgRTEParserEnabled;
		
		
		if(!( !empty($wgRTEParserEnabled) || !empty($self->isInsideLayoutTag) || $self->getTitle()->getNamespace() == NS_PLB_LAYOUT )) {
			return '<span class="error">' . wfMsgForContent( 'plb-parser-error-not-on-plb-article'  ) . '</span>';
		}
		// TODO: move to RTEParser
		foreach ($attributes as $k => $v) {
			$v = !empty($wgEnableRTEExt) ? RTEParser::unmarkEntities($v) : $v;
			$attributes[$k] = htmlspecialchars_decode($v,ENT_QUOTES);
		}

		$value = (isset($attributes['id']) && isset($self->formValues[$attributes['id']])) ? $self->formValues[$attributes['id']]:"";
		$error = (isset($attributes['id']) && isset($self->errorsList[$attributes['id']]));

		$oWidget = LayoutWidgetBase::getNewWidget($self->mCurrentTagName, $attributes, $value, $error, $self);

		if(empty($self->mPlbFormElements)) {
			$self->mPlbFormElements = array();
		}

		if(empty($self->plbMarkers)) {
			$self->plbMarkers = array();
		}

		$marker = $self->uniqPrefix() . "-WIDGET_PLB-{".count($self->plbMarkers)."}-\x7f";

		if(empty($oWidget)) {
			return self::parserReturnMarker($self, $marker, wfMsg('plb-special-form-unknow-error'));
		}

		if(empty($wgRTEParserEnabled)) {
			$validateElementStatus = $oWidget->validateAttribute($self->mPlbFormElements);
			if ($validateElementStatus !== true) {
				return self::parserReturnMarker($self, $marker, $validateElementStatus);
			}

			$self->getOptions();

			if(!empty($self->getOptions()->isArticlePreview) && ($self->getOptions()->isArticlePreview)) {
				return self::parserReturnMarker($self, $marker, $oWidget->renderForPreview());
			} else {
				$clear = XML::element( 'div', array( "class" => "plb-article-form-space form"), '', false ) . "\n";
				return self::parserReturnMarker($self, $marker, $oWidget->renderForFormCaption(). $oWidget->renderForForm() . $clear );
			}
		} else {
			if($oWidget->isParagraph()) {
				//add pre to marker to prevent p dressing 
				return self::parserReturnMarker($self, "<pre>".$marker."</pre>", $oWidget->RTEElementDecoratorAndRender());	
			} else {
				return self::parserReturnMarker($self, $marker, $oWidget->RTEElementDecoratorAndRender());
			}
			
		}
	}

	public static function parserReturnMarker($self, $marker, $text) {
		$self->plbMarkers[$marker] = $text;
		return $marker;
	}

	public static function replaceTags($self, $text) {
		if(!empty($self->plbMarkers)) {
			$text = strtr($text, $self->plbMarkers);
		}
		return true;
	}

	public static function parserLayoutTag( $content, $attributes, Parser $self ) {
		global $wgUser, $wgPLBwidgets;
		//$title = $self->Title();
		wfLoadExtensionMessages( 'PageLayoutBuilder' );

		if(empty($attributes['layout_id'])) {
			return wfMsg('plb-parser-no-attribute', array('$1' => 'layout_id' ) );
		}

		if(empty($self->plbMarkers)) {
			$self->plbMarkers = array();
		}
		
		$layoutTitle = Title::newFromID($attributes['layout_id']);
		//* can't use Article->getContent becasue of problem with oldid in url *//
		$rev = Revision::newFromTitle( $layoutTitle );
		$layoutText = $rev ? $rev->getRawText() : "";

		$dom = new simple_html_dom;
		$dom->load($layoutText, false);

		$plbParser = new PageLayoutBuilderParser();
		$formValues = $plbParser->extractFormValues($attributes);
		$elements = array_keys($wgPLBwidgets);
		$elementsOut = array();
		$parserOptions = $self->getOptions();
		foreach($dom->find(implode(",", $elements)) as $element) {
			$marker = $self->uniqPrefix() . "-LAYOUT_PLB-{".count($self->plbMarkers)."}-\x7f";
			$name = trim($element->tag);
			$elementAttributes =  $element->getAllAttributes();
			$id = empty($element->id) ? "":$element->id;
			$value = isset( $formValues[$id] ) ? $formValues[$id]:"";

			$oWidget = LayoutWidgetBase::getNewWidget($name, $elementAttributes, $value );

			
			$positionMarker =  '<span style="display:none" class="position-marker" id="input_' . $id . '" ></span>';
			 
			$validateElementStatus = $oWidget->validateAttribute($elementsOut);
			if($validateElementStatus === true) {
				if($oWidget->isEmpty()) {
					if(!empty($parserOptions->isPreparse)) {
						$element->outertext = "";
					} else {
						$url = $parserOptions->getIsPreview() ? "#":$self->getTitle()->getFullURL("action=edit");
						$element->outertext = self::parserReturnMarker($self, $marker, $oWidget->renderForResultEmpty($url) . $positionMarker );
					}
				} else {
					$element->outertext = $oWidget->renderForResult() . $positionMarker;
				}
			} else {
				$element->outertext = self::parserReturnMarker($self, $marker, $validateElementStatus);
			}
		}

		$self->getOptions();
		if(!empty($self->getOptions()->isPreparse) && ($self->getOptions()->isPreparse)) {
			$marker = $self->uniqPrefix() . "-LAYOUT_PLB-{".time()."}-\x7f";
			return self::parserReturnMarker($self, $marker, $dom->__toString());
		}
		
		$cat = "";
		if(!empty($attributes['cswikitext'])) {
			$cat = $attributes['cswikitext'];	
		}
		$self->isInsideLayoutTag = true; 
		$out = $self->recursiveTagParse( self::removeGalleryAndIP($dom->__toString()).$cat );
		$self->isInsideLayoutTag = false;
		return $out;
	}
	/*
	 * load values for form form existing article
	 */

	public function loadForm(Title $pageTitle, $layoutId) {
		wfProfileIn(__METHOD__);
		
		$rev = Revision::newFromTitle( $pageTitle );
		$cArticle = $rev ? $rev->getRawText() : "";
		
		return $this->loadFormFromText( $cArticle, $pageTitle->getArticleID() , $layoutId );
		
		wfProfileOut(__METHOD__);
	}
	
	
	public function loadFormFromText( $cArticle, $pageId, $layoutId ) {
		
		if(!(PageLayoutBuilderModel::articleIsFromPLB( $pageId ) == $layoutId )) {
			return false;
		}
		
		$dom = new simple_html_dom;
		$dom->load($cArticle, false);
		$element = $dom->find("plb_layout[layout_id=$layoutId]");

		$this->formValues = array();
		if(!empty($element[0])) {
			$out = $this->extractFormValues($element[0]->getAllAttributes());;
			wfProfileOut(__METHOD__);
			return $out;
		}
	}

	public function forceFormValue($values) {
		$this->formValues = $values;
	}

	public function forceFormErrors($values) {
		$this->errorsList = $values;
	}

	public function extractFormValues($attributes) {
		wfProfileIn(__METHOD__);
		
		/* save for use in form */		
		$this->formValues = array();
		foreach ( $attributes as $key => $value) {
			if(( strpos($key, "val_") === 0 ) || ($key == 'cswikitext')){
				$key = $key == 'cswikitext' ? 'cswikitext':((int) str_replace("val_", "" , $key));
				$this->formValues[$key] = htmlspecialchars_decode($value, ENT_QUOTES);
				$this->formValues[$key] = strtr( $this->formValues[$key], array(
					'&#10;' => "\n",
					'&#13;' => "\r",
					'&#9;' => "\t",
				));
			}
		}
				
		wfProfileOut(__METHOD__);
		return $this->formValues;
	}

	public static function removeGalleryAndIP($text) {
		$text = str_replace('<gallery ', "<gallery source=\"template\x7f\" ", $text);
		$text = preg_replace('/image\s*:\s*'.wfMsg( 'imgplc-placeholder' ).'/i' , "File:Template_Placeholder", $text);
		return $text;
	}

	public static function removeGalleryAndIPHook(Parser &$self, &$text) {
		global $wgRTEParserEnabled;
		if($wgRTEParserEnabled) {
			return true;
		}

		if($self->getTitle()->getNamespace() ==  NS_PLB_LAYOUT) {
			$text = self::removeGalleryAndIP($text);
		}
		return true;
	}

	/*
	 * @author Tomasz Odrobny
	 * @params Title
	 * @return Parser
	 */

	public static function rteIsCustom($name, $params, $frame, $wikitextIdx) {
		global $wgPLBwidgets;
		if (isset($wgPLBwidgets[$name])) {
			return false;
		}
		return true;
	}
	
	
	
	public static function fetchTemplateAndTitleHook(&$text, &$title) {
		global $wgPLBwidgets;
		if(strpos($text, "plb_") > 0 ) {
			$dom = new simple_html_dom;
			$dom->load($text, false);
			$elements = array_keys($wgPLBwidgets);
			foreach($dom->find(implode(",", $elements)) as $element) {
				$element->outertext = '<span class="error">' . wfMsgForContent( 'plb-parser-error-use-on-template'  ) . '</span>';
			}
			$text = $dom->__toString();
		} 
		
		return true;
	}
}