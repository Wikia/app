<?php

class TranslationHelpers {
	protected $title;
	protected $page;
	protected $targetLanguage;
	protected $group;
	protected $translation;
	protected $definition;
	protected $textareaId;

	public function __construct( Title $title ) {
		$this->title = $title;
		$this->init();
	}

	protected function init() {
		$title = $this->title;
		list( $page, $code ) = self::figureMessage( $title );
		
		$this->page = $page;
		$this->targetLanguage = $code;
		$this->group = self::getMessageGroup( $title->getNamespace(), $page );
	}

	public static function figureMessage( Title $title ) {
		$text = $title->getDBkey();
		$pos = strrpos( $text, '/' );
		if ( $pos === false ) {
			$code = '';
			$key = $text;
		} else {
			$code = substr( $text, $pos + 1 );
			$key = substr( $text, 0, $pos );
		}
		return array( $key, $code );
	}

	/**
	 * Tries to determine to which group this message belongs. It tries to get
	 * group id from loadgroup GET-paramater, but fallbacks to messageIndex file
	 * if no valid group was provided.
	 * @param $namespace  int  The namespace where the page is.
	 * @param $key  string     The message key we are interested in.
	 * @return MessageGroup which the key belongs to, or null.
	 */
	protected static function getMessageGroup( $namespace, $key ) {
		global $wgRequest;
		$group = $wgRequest->getText( 'loadgroup', '' );
		$mg = MessageGroups::getGroup( $group );

		# If we were not given group
		if ( $mg === null ) {
			$group = TranslateUtils::messageKeyToGroup( $namespace, $key );
			if ( $group ) {
				$mg = MessageGroups::getGroup( $group );
			}
		}

		return $mg;
	}

	public function getTextareaId() {
		return $this->textareaId === null ? 'wpTextbox1' : $this->textareaId;
	}

	public function setTextareaId( $id ) {
		$this->textareaId = $id;
	}

	public function getDefinition() {
		if ( $this->definition !== null ) return $this->definition;
		$this->definition = $this->group->getMessage( $this->page, 'en' );
		return $this->definition;
	}

	public function getTranslation() {
		if ( $this->translation !== null ) return $this->translation;

		// Shoter names
		$page = $this->page;
		$code = $this->targetLanguage;

		// Try database first
		$translation = TranslateUtils::getMessageContent(
			$page, $code, $this->group->getNamespace()
		);

		if ( $translation !== null ) {
			if ( !TranslateEditAddons::hasFuzzyString( $translation ) && TranslateEditAddons::isFuzzy( $this->title ) ) {
				$translation = TRANSLATE_FUZZY . $translation;
			}
		} elseif ( !$this->group instanceof FileBasedMessageGroup ) {
			// Then try to load from files (old groups)
			$translation = $this->group->getMessage( $page, $code );
		} else {
			// Nothing to prefil
			$translation = '';
		}
		$this->translation = $translation;
		return $translation;
	}

	public function setTranslation( $translation ) {
		$this->translation = $translation;
	}

	public function getBoxes( $types = null ) {
		if ( !$this->group ) return '';

		// Box filter
		$all = array(
			'other-languages' => array( $this, 'getOtherLanguagesBox' ),
			'translation-memory' => array( $this, 'getSuggestionBox' ),
			'page-translation' => array( $this, 'getPageDiff' ),
			'separator' => array( $this, 'getSeparatorBox' ),
			'documenation' => array( $this, 'getDocumentationBox' ),
			'definition' => array( $this, 'getDefinitionBox' ),
			'check' => array( $this, 'getCheckBox' ),
		);
		if ( $types !== null ) foreach ( $types as $type ) unset( $all[$type] );

		$boxes = array();
		foreach ( $all as $type => $cb ) {
			$box = call_user_func( $cb );
			if ( $box ) $boxes[$type] = $box;
		}

		if ( count( $boxes ) ) {
			return Html::rawElement( 'div', array( 'class' => 'mw-sp-translate-edit-fields' ), implode( "\n\n", $boxes ) );
		} else {
			return '';
		}
	}

	/**
	 * Returns suggestions from a translation memory.
	 * @return Html snippet which contains the suggestions.
	 */
	protected function getTmBox() {
		global $wgTranslateTM;
		if ( $wgTranslateTM === false ) return null;
		if ( !$this->targetLanguage ) return null;
		if ( strval( $this->getDefinition() ) === '' ) return null;

		// Needed data
		$code = $this->targetLanguage;
		$definition = $this->getDefinition();
		$ns = $this->title->getNsText();

		// Fetch suggestions
		$server = $wgTranslateTM['server'];
		$port   = $wgTranslateTM['port'];
		$timeout = $wgTranslateTM['timeout'];
		$def = rawurlencode( $definition );
		$url = "$server:$port/tmserver/en/$code/unit/$def";
		$suggestions = Http::get( $url, $timeout );

		$sugFields = array();
		// Parse suggestions, but limit to three (in case there would be more)
		$boxes = array();

		if ( $suggestions !== false ) {
			$suggestions = json_decode( $suggestions, true );
			foreach ( $suggestions as $s ) {
				// No use to suggest them what they are currently viewing
				if ( $s['context'] === "$ns:{$this->page}" ) continue;

				$accuracy = wfMsgHtml( 'translate-edit-tmmatch' , sprintf( '%.2f', $s['quality'] ) );
				$legend = array( $accuracy => array() );

				$source_page = Title::newFromText( $s['context'] . "/$code" );
				if ( $source_page ) {
					$legend[$accuracy][] = self::editLink( $source_page, '•' );
				}

				$text = $this->suggestionField( $s['target'] );
				$params = array( 'class' => 'mw-sp-translate-edit-tmsug', 'title' => $s['source'] );

				if ( isset( $sugFields[$s['target']] ) ) {
					$sugFields[$s['target']][2] = array_merge_recursive( $sugFields[$s['target']][2], $legend );
				} else {
					$sugFields[$s['target']] = array( $text, $params, $legend );
				}
			}

			foreach ( $sugFields as $field ) {
				list( $text, $params, $label ) = $field;
				$legend = array();
				foreach ( $label as $acc => $links ) { $legend[] = $acc . ' ' . implode( " ", $links ); }
				$legend = implode( ' | ', $legend );
				$boxes[] = Html::rawElement( 'div', $params, self::legend( $legend ) . $text . self::clear() ) . "\n";
			}
		}

		// Limit to three max
		return array_slice( $boxes, 0, 3 );
	}

	protected function getSuggestionBox() {
		$boxes = (array) $this->getTmBox();
		$google = $this->getGoogleSuggestion();
		if ( $google ) $boxes[] = $google;
		$apertium = $this->getApertiumSuggestion();
		if ( $apertium ) $boxes[] = $apertium;

		// Enclose if there is more than one box
		if ( count( $boxes ) ) {
			$sep = Html::element( 'hr', array( 'class' => 'mw-translate-sep' ) );
			return TranslateUtils::fieldset( wfMsgHtml( 'translate-edit-tmsugs' ),
				implode( "$sep\n", $boxes ), array( 'class' => 'mw-translate-edit-tmsugs' ) );
		} else {
			return null;
		}
	}

	protected function getGoogleSuggestion() {
		global $wgProxyKey, $wgGoogleApiKey, $wgMemc;

		$code = $this->targetLanguage;
		$definition = $this->getDefinition();

		$memckey = wfMemckey( 'translate-tmsug-badcodes' );
		$unsupported = $wgMemc->get( $memckey );

		if ( isset( $unsupported[$code] ) ) return null;
		if ( trim( strval( $definition ) ) === '' ) return null;

		$path = 'http://ajax.googleapis.com/ajax/services/language/translate';
		$options = array();
		$options['timeout'] = 3;
		$options['postData'] = array(
			'q' => $definition,
			'v' => '1.0',
			'langpair' => "en|$code",
			// Unique but not identifiable
			'userip' => sha1( $wgProxyKey . wfGetIp() ),
		);
		if ( $wgGoogleApiKey ) $options['postData']['key'] = $wgGoogleApiKey;

		$google_json = Http::post( $path, $options );
		$response = json_decode( $google_json );

		if ( $google_json === false ) {
				wfWarn(  __METHOD__ . ': Http::get failed' );
				return null;
		} elseif ( !is_object( $response ) ) {
				wfWarn(  __METHOD__ . ': Unable to parse reply: ' . strval( $google_json ) );
				error_log(  __METHOD__ . ': Unable to parse reply: ' . strval( $google_json ) );
				return null;
		}
		if ( $response->responseStatus === 200 ) {
			$text = $this->suggestionField( Sanitizer::decodeCharReferences( $response->responseData->translatedText ) );
			return Html::rawElement( 'div', null, self::legend( 'Google' ) . $text . self::clear() );
		} elseif ( $response->responseDetails === 'invalid translation language pair' ) {
			$unsupported[$code] = true;
			$wgMemc->set( $memckey, $unsupported, 60 * 60 * 8 );
		} else {
			wfWarn(  __METHOD__ . ': ' . $response->responseDetails );
			error_log( __METHOD__ . ': ' . $response->responseDetails );
			return null;
		}
	}

	protected function getApertiumSuggestion() {
		global $wgTranslateApertium, $wgMemc;

		if ( !$wgTranslateApertium ) return null;

		$page = $this->page;
		$code = $this->targetLanguage;
		$ns = $this->title->getNamespace();

		$memckey = wfMemckey( 'translate-tmsug-apertium' );
		$pairs = $wgMemc->get( $memckey );

		if ( !$pairs ) {
			$pairs = array();
			$pairlist = Http::get( $wgTranslateApertium, 5 );
			if ( $pairlist === false ) return null;
			$pairlist = trim( Sanitizer::stripAllTags( $pairlist ) );
			$pairlist = explode( " ", $pairlist );
			foreach ( $pairlist as $pair ) {
				$pair = trim( $pair );
				if ( $pair === '' ) continue;
				$languages = explode( '-', $pair );
				if ( count( $languages ) !== 2 ) continue;

				list( $source, $target ) = $languages;
				if ( !isset( $pairs[$target] ) ) $pairs[$target] = array();
				$pairs[$target][$source] = true;
			}

			$wgMemc->set( $memckey, $pairs, 60 * 60 * 24 );
		}

		$codemap = array( 'no' => 'nb' );
		if ( isset( $codemap[$code] ) ) $code = $codemap[$code];
		$code = str_replace( '-', '_', wfBCP47( $code ) );

		if ( !isset( $pairs[$code] ) ) return;

		$suggestions = array();

		$codemap = array_flip( $codemap );
		foreach ( $pairs[$code] as $candidate => $unused ) {
			$mwcode = str_replace( '_', '-', strtolower( $candidate ) );
			if ( isset( $codemap[$mwcode] ) ) $mwcode = $codemap[$mwcode];

			$text = TranslateUtils::getMessageContent( $page, $mwcode, $ns );
			if ( $text === null || TranslateEditAddons::hasFuzzyString( $text ) ) continue;
			$title = Title::makeTitleSafe( $ns, "$page/$mwcode" );
			if ( $title && TranslateEditAddons::isFuzzy( $title ) ) continue;

			$query = array(
				'mark' => 0,
				'mode' => "$candidate-$code",
				'text' => $text
			);

			$response = Http::get( "$wgTranslateApertium?" . wfArrayToCgi( $query ), 3 );
			if ( $response === false ) {
					break; // Too slow, back off
			} else {
				$response = $this->suggestionField( Sanitizer::decodeCharReferences( $response ) );
				$suggestions[] = Html::rawElement( 'div', null, self::legend( "Apertium ($candidate)" ) . $response . self::clear() );
			}
		}
		if ( !count( $suggestions ) ) return null;
		return implode( "\n", $suggestions );
	}

	protected function getDefinitionBox() {
		$en = $this->getDefinition();
		if ( $en === null ) return null;

		global $wgUser;
		$label = " ()";
		$title = $wgUser->getSkin()->link(
			SpecialPage::getTitleFor( 'Translate' ),
			htmlspecialchars( $this->group->getLabel() ),
			array(),
			array(
				'group' => $this->group->getId(),
				'language' => $this->targetLanguage
			)
		);

		$label =
			wfMsg( 'translate-edit-definition' ) .
			wfMsg( 'word-separator' ) .
			wfMsg( 'parentheses', $title );

		$msg = Html::rawElement( 'span',
			array( 'class' => 'mw-translate-edit-deftext' ),
			TranslateUtils::convertWhiteSpaceToHTML( $en )
		);

		$class = array( 'class' => 'mw-sp-translate-edit-definition mw-translate-edit-definition' );
		return TranslateUtils::fieldset( $label, $msg, $class );
	}

	protected function getCheckBox() {
		global $wgTranslateDocumentationLanguageCode;

		$page = $this->page;
		$translation = $this->getTranslation();
		$code = $this->targetLanguage;
		$en = $this->getDefinition();

		if ( strval( $translation ) === '' ) return null;
		if ( $code === $wgTranslateDocumentationLanguageCode ) return null;

		$checker = $this->group->getChecker();
		if ( !$checker ) return null;

		$message = new FatMessage( $page, $en );
		// Take the contents from edit field as a translation
		$message->setTranslation( $translation );

		$checks = $checker->checkMessage( $message, $code );
		if ( !count( $checks ) ) return null;


		$checkMessages = array();
		foreach ( $checks as $checkParams ) {
			array_splice( $checkParams, 1, 0, 'parseinline' );
			$checkMessages[] = call_user_func_array( 'wfMsgExt', $checkParams );
		}

		return TranslateUtils::fieldset(
			wfMsgHtml( 'translate-edit-warnings' ), implode( '<hr />', $checkMessages ),
			array( 'class' => 'mw-sp-translate-edit-warnings' )
		);
	}

	protected function getOtherLanguagesBox() {
		global $wgLang, $wgUser;

		$code = $this->targetLanguage;
		$page = $this->page;
		$ns = $this->title->getNamespace();

		$boxes = array();
		foreach ( self::getFallbacks( $code ) as $fbcode ) {
			$text = TranslateUtils::getMessageContent( $page, $fbcode, $ns );
			if ( $text === null ) continue;

			$label =
				TranslateUtils::getLanguageName( $fbcode, false, $wgLang->getCode() ) .
				wfMsg( 'word-separator' ) .
				wfMsg( 'parentheses', wfBCP47( $fbcode ) );

			$target = Title::makeTitleSafe( $ns, "$page/$fbcode" );
			if ( $target ) {
				$label = self::editLink( $target, htmlspecialchars( $label ) );
			}

			$text = TranslateUtils::convertWhiteSpaceToHTML( $text );
			$params = array( 'class' => 'mw-translate-edit-item' );
			$boxes[] = Html::rawElement( 'div', $params, self::legend( $label ) . $text . self::clear() );
		}

		if ( count( $boxes ) ) {
			$sep = Html::element( 'hr', array( 'class' => 'mw-translate-sep' ) );
			return TranslateUtils::fieldset( wfMsgHtml( 'translate-edit-in-other-languages' , $page ),
				implode( "$sep\n", $boxes ), array( 'class' => 'mw-sp-translate-edit-inother' ) );
		}

		return null;
	}

	public function getSeparatorBox() {
		return Html::element( 'div', array( 'class' => 'mw-translate-edit-extra' ) );
	}

	public function getDocumentationBox() {
		global $wgTranslateDocumentationLanguageCode, $wgUser, $wgOut;

		if ( !$wgTranslateDocumentationLanguageCode ) return null;
		$page = $this->page;
		$ns = $this->title->getNamespace();

		$title = Title::makeTitle( $ns, $page . '/' . $wgTranslateDocumentationLanguageCode );
		$edit = self::editLink( $title, wfMsgHtml( 'translate-edit-contribute' ) );
		$info = TranslateUtils::getMessageContent( $page, $wgTranslateDocumentationLanguageCode, $ns );

		$class = 'mw-sp-translate-edit-info';
		if ( $info === null ) {
			$info = wfMsg( 'translate-edit-no-information' );
			$class = 'mw-sp-translate-edit-noinfo';
		}

		if ( $this->group instanceof GettextMessageGroup ) {
			$reader = $this->group->getReader( 'en' );
			if ( $reader ) {
				global $wgContLang;
				$mykey = $wgContLang->lcfirst( $this->page );
				$data = $reader->parseFile();
				$help = GettextFormatWriter::formatcomments( @$data[$mykey]['comments'], false, @$data[$mykey]['flags'] );
				$info .= "<hr /><pre>$help</pre>";
			}
		}

		$class .= ' mw-sp-translate-message-documentation';

		$contents = $wgOut->parse( $info );
		// Remove whatever block element wrapup the parser likes to add
		$contents = preg_replace( '~^<([a-z]+)>(.*)</\1>$~us', '\2', $contents );
		return TranslateUtils::fieldset(
			wfMsgHtml( 'translate-edit-information', $edit , $page ), $contents, array( 'class' => $class )
		);

	}

	protected function getPageDiff() {
		global $wgEnablePageTranslation;
		if ( !$wgEnablePageTranslation ) return null;
		if ( !$this->group instanceof WikiPageMessageGroup ) return null;

		// Shortcuts
		$code = $this->targetLanguage;
		$key = $this->page;

		// TODO: encapsulate somewhere
		$page = TranslatablePage::newFromTitle( $this->group->title );
		$rev = $page->getTransRev( "$key/$code" );
		$latest = $page->getMarkedTag();
		if ( $rev === $latest ) return null;

		$oldpage = TranslatablePage::newFromRevision( $this->group->title, $rev );
		$oldtext = $newtext = null;
		foreach ( $oldpage->getParse()->getSectionsForSave() as $section ) {
			if ( $this->group->title->getPrefixedDBKey() . '/' . $section->id === $key ) {
				$oldtext = $section->getTextForTrans();
			}
		}

		foreach ( $page->getParse()->getSectionsForSave() as $section ) {
			if ( $this->group->title->getPrefixedDBKey() . '/' . $section->id === $key ) {
				$newtext = $section->getTextForTrans();
			}
		}

		if ( $oldtext === $newtext ) return null;

		$diff = new DifferenceEngine;
		$diff->setText( $oldtext, $newtext );
		$diff->setReducedLineNumbers();
		$diff->showDiffStyle();
		return $diff->getDiff( wfMsgHtml( 'tpt-diff-old' ), wfMsgHtml( 'tpt-diff-new' ) );
	}

	protected static function legend( $label ) {
		return Html::rawElement( 'div', array( 'class' => 'mw-translate-legend' ), $label );
	}

	protected static function clear() {
		return Html::element( 'div', array( 'style' => 'clear:both;' ) );
	}

	protected static function getFallbacks( $code ) {
		global $wgUser, $wgTranslateLanguageFallbacks;

		// User preference has the final say
		$preference = $wgUser->getOption( 'translate-editlangs' );
		if ( $preference !== 'default' ) {
			$fallbacks = array_map( 'trim', explode( ',', $preference ) );
			foreach ( $fallbacks as $k => $v ) if ( $v === $code ) unset( $fallbacks[$k] );
			return $fallbacks;
		}

		// Global configuration settings
		$fallbacks = array();
		if ( isset( $wgTranslateLanguageFallbacks[$code] ) ) {
			$fallbacks = (array) $wgTranslateLanguageFallbacks[$code];
		}

		// And the real fallback
		// TODO: why only one?
		$realFallback = $code ? Language::getFallbackFor( $code ) : false;
		if ( $realFallback && $realFallback !== 'en' ) {
			$fallbacks = array_merge( array( $realFallback ), $fallbacks );
		}

		return $fallbacks;
	}

	protected function doBox( $msg, $code, $title = false, $makelink = false ) {
		global $wgUser, $wgLang;

		$name = TranslateUtils::getLanguageName( $code, false, $wgLang->getCode() );
		$code = wfBCP47( $code );

		$skin = $wgUser->getSkin();

		$attributes = array();
		if ( !$title ) {
			$attributes['class'] = 'mw-sp-translate-in-other-big';
		} elseif ( $code === 'en' ) {
			$attributes['class'] = 'mw-sp-translate-edit-definition';
		} else {
			$attributes['class'] = 'mw-sp-translate-edit-committed';
		}
		if ( mb_strlen( $msg ) < 100 && !$title ) {
			$attributes['class'] = 'mw-sp-translate-in-other-small';
		}

		$msg = TranslateUtils::convertWhiteSpaceToHTML( $msg );

		if ( !$title ) $title = "$name ($code)";

		if ( $makelink ) {
			$linkTitle = Title::newFromText( $makelink );
			$title = $skin->link(
				$linkTitle,
				htmlspecialchars( $title ),
				array(),
				array( 'action' => 'edit' )
			);
		}

		return TranslateUtils::fieldset( $title, Html::element( 'span', null, $msg ), $attributes );
	}

	public function adder( $source ) {
			$target = Xml::escapeJsString( $this->getTextareaId() );
			$source = Xml::escapeJsString( $source );
			$params = array(
				'onclick' => "jQuery('#$target').val(jQuery('#$source').text()).focus(); return false;",
				'href' => '#'
			);
			return Html::element( 'a', $params, '↓' );
	}

	public function suggestionField( $contents ) {
		static $counter = 0;
		$counter++;
		$id = "tmsug-" . wfTimestamp() . "-$counter";
		$contents = TranslateUtils::convertWhiteSpaceToHTML( $contents );
		return $this->adder( $id ) . "\n" . Html::rawElement( 'span', array( 'id' => $id ), $contents );
	}

	public static function editLink( $target, $text, $params = array() ) {
		global $wgUser;

		list( $page, ) = self::figureMessage( $target );
		$group = TranslateUtils::messageKeyToGroup( $target->getNamespace(), $page );
		if ( $group ) $group = MessageGroups::getGroup( $group );
		$params += array( 'action' => 'edit' );
		if ( $group ) $params += array( 'loadgroup' => $group->getId() );

		$jsEdit = TranslationEditPage::jsEdit( $target );

		return $wgUser->getSkin()->link( $target, $text, $jsEdit, $params );
	}
}