<?php
/**
 * Contains helper class for interface parts that aid translations in doing
 * their thing.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2010 Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Provides the nice boxes that aid the translators to do their job.
 * Boxes contain definition, documentation, other languages, translation memory
 * suggestions, highlighted changes etc.
 */
class TranslationHelpers {
	/**
	 * Title of the message
	 */
	protected $title;
	/**
	 * Name of the message without namespace or language code.
	 */
	protected $page;
	/**
	 * The language we are translating into.
	 */
	protected $targetLanguage;
	/**
	 * The group object of the message (or null if there isn't any)
	 * @var MessageGroup
	 */
	protected $group;
	/**
	 * The current translation as a string.
	 */
	protected $translation;
	/**
	 * The message definition as a string.
	 */
	protected $definition;
	/**
	 * HTML id to the text area that contains the translation. Used to insert
	 * suggestion directly into the text area, for example.
	 */
	protected $textareaId = 'wpTextbox1';
	/**
	 * Whether to include extra tools to aid translating.
	 */
	protected $editMode = 'true';

	/**
	 * @param $title Title Title of a page that holds a translation.
	 */
	public function __construct( Title $title ) {
		$this->title = $title;
		$this->init();
	}

	/**
	 * Initializes member variables.
	 */
	protected function init() {
		$title = $this->title;
		list( $page, $code ) = TranslateEditAddons::figureMessage( $title );

		$this->page = $page;
		$this->targetLanguage = $code;
		$this->group = self::getMessageGroup( $title->getNamespace(), $page );
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

	/**
	 * Gets the HTML id of the text area that contains the translation.
	 * @return String
	 */
	public function getTextareaId() {
		return $this->textareaId;
	}

	/**
	 * Sets the HTML id of the text area that contains the translation.
	 * @param $id String
	 */
	public function setTextareaId( $id ) {
		$this->textareaId = $id;
	}

	/**
	 * Enable or disable extra help for editing.
	 * @param $mode Boolean
	 */
	public function setEditMode( $mode = true ) {
		$this->editMode = $mode;
	}

	/**
	 * Gets the message definition.
	 * @return String
	 */
	public function getDefinition() {
		if ( $this->definition !== null ) {
			return $this->definition;
		}

		if ( $this->group === null ) {
			return;
		}

		$this->definition = $this->group->getMessage( $this->page, 'en' );

		return $this->definition;
	}

	/**
	 * Gets the current message translation. Fuzzy messages will be marked as
	 * such unless translation is provided manually.
	 * @return String
	 */
	public function getTranslation() {
		if ( $this->translation !== null ) {
			return $this->translation;
		}

		// Shorter names
		$page = $this->page;
		$code = $this->targetLanguage;
		$group = $this->group;

		// Try database first
		$translation = TranslateUtils::getMessageContent(
			$page, $code, $this->title->getNamespace()
		);

		if ( $translation !== null ) {
			if ( !TranslateEditAddons::hasFuzzyString( $translation ) && TranslateEditAddons::isFuzzy( $this->title ) ) {
				$translation = TRANSLATE_FUZZY . $translation;
			}
		} elseif ( $group && !$group instanceof FileBasedMessageGroup ) {
			// Then try to load from files (old groups)
			$translation = $group->getMessage( $page, $code );
		} else {
			// Nothing to prefil
			$translation = '';
		}

		$this->translation = $translation;

		return $translation;
	}

	/**
	 * Manual override for the translation. If not given or it is null, the code
	 * will try to fetch it automatically.
	 * @param $translation String or null
	 */
	public function setTranslation( $translation ) {
		$this->translation = $translation;
	}

	/**
	 * Get target language code
	 */
	public function getTargetLanguage() {
		return $this->targetLanguage;
	}

	/**
	 * Returns block element HTML snippet that contains the translation aids.
	 * Not all boxes are shown all the time depending on whether they have
	 * any information to show and on configuration variables.
	 * @return String. Block level HTML snippet or empty string.
	 */
	public function getBoxes( $suggestions = 'sync' ) {
		// Box filter
		$all = $this->getBoxNames();

		if ( $suggestions === 'async' ) {
			$all['translation-memory'] = array( $this, 'getLazySuggestionBox' );
		} elseif ( $suggestions === 'only' ) {
			return (string) call_user_func( $all['translation-memory'], 'lazy' );
		} elseif ( $suggestions === 'checks' ) {
			global $wgRequest;
			$this->translation = $wgRequest->getText( 'translation' );
			return (string) call_user_func( $all['check'] );
		}

		$boxes = array();
		foreach ( $all as $type => $cb ) {
			$box = call_user_func( $cb );

			if ( $box ) {
				$boxes[$type] = $box;
			}
		}

		if ( count( $boxes ) ) {
			return Html::rawElement( 'div', array( 'class' => 'mw-sp-translate-edit-fields' ), implode( "\n\n", $boxes ) );
		} else {
			return '';
		}
	}

	public function getBoxNames() {
		return array(
			'other-languages' => array( $this, 'getOtherLanguagesBox' ),
			'translation-memory' => array( $this, 'getSuggestionBox' ),
			'translation-diff' => array( $this, 'getPageDiff' ),
			'page-translation' => array( $this, 'getTranslationPageDiff' ),
			'separator' => array( $this, 'getSeparatorBox' ),
			'documentation' => array( $this, 'getDocumentationBox' ),
			'definition' => array( $this, 'getDefinitionBox' ),
			'check' => array( $this, 'getCheckBox' ),
		);
	}

	/**
	 * Returns suggestions from a translation memory.
	 * @return Html snippet which contains the suggestions.
	 */
	protected function getTmBox( $serviceName, $config ) {
		if ( !$this->targetLanguage ) {
			return null;
		}

		if ( strval( $this->getDefinition() ) === '' ) {
			return null;
		}

		if ( self::checkTranslationServiceFailure( $serviceName ) ) {
			return null;
		}

		// Needed data
		$code = $this->targetLanguage;
		$definition = $this->getDefinition();
		$ns = $this->title->getNsText();

		// Fetch suggestions
		$server = $config['server'];
		$port   = $config['port'];
		$timeout = $config['timeout'];
		$def = rawurlencode( $definition );
		$url = "$server:$port/tmserver/en/$code/unit/$def";
		$suggestions = Http::get( $url, $timeout );

		$sugFields = array();
		// Parse suggestions, but limit to three (in case there would be more)
		$boxes = array();

		if ( $suggestions !== false ) {
			$suggestions = FormatJson::decode( $suggestions, true );

			foreach ( $suggestions as $s ) {
				// No use to suggest them what they are currently viewing
				if ( $s['context'] === "$ns:{$this->page}" ) {
					continue;
				}

				$accuracy = wfMsgHtml( 'translate-edit-tmmatch' , sprintf( '%.2f', $s['quality'] ) );
				$legend = array( $accuracy => array() );

				$source_page = Title::newFromText( $s['context'] . "/$code" );
				if ( $source_page ) {
					$legend[$accuracy][] = self::ajaxEditLink( $source_page, '•' );
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

				foreach ( $label as $acc => $links ) {
					$legend[] = $acc . ' ' . implode( " ", $links );
				}

				$legend = implode( ' | ', $legend );
				$boxes[] = Html::rawElement( 'div', $params, self::legend( $legend ) . $text . self::clear() ) . "\n";
			}
		} else {
			// Assume timeout
			self::reportTranslationServiceFailure( $serviceName );
		}

		$boxes = array_slice( $boxes, 0, 3 );
		$result = implode( "\n", $boxes );

		// Limit to three max
		return $result;
	}

	public function getSuggestionBox( $async = false ) {
		global $wgTranslateTranslationServices;

		$boxes = array();
		foreach ( $wgTranslateTranslationServices as $name => $config ) {
			if ( $async === 'async' ) {
				$config['timeout'] = $config['timeout-async'];
			} else {
				$config['timeout'] = $config['timeout-sync'];
			}

			if ( $config['type'] === 'tmserver' ) {
				$boxes[] = $this->getTmBox( $name, $config );
			} elseif ( $config['type'] === 'google' ) {
				$boxes[] = $this->getGoogleSuggestion( $name, $config );
			} elseif ( $config['type'] === 'microsoft' ) {
				$boxes[] = $this->getMicrosoftSuggestion( $name, $config );
			} elseif ( $config['type'] === 'apertium' ) {
				$boxes[] = $this->getApertiumSuggestion( $name, $config );
			} else {
				throw new MWException( __METHOD__ . ": Unsupported type {$config['type']}" );
			}
		}

		// Remove nulls and falses
		$boxes = array_filter( $boxes );

		// Enclose if there is more than one box
		if ( count( $boxes ) ) {
			$sep = Html::element( 'hr', array( 'class' => 'mw-translate-sep' ) );
			return TranslateUtils::fieldset( wfMsgHtml( 'translate-edit-tmsugs' ),
				implode( "$sep\n", $boxes ), array( 'class' => 'mw-translate-edit-tmsugs' ) );
		} else {
			return null;
		}
	}

	protected function getGoogleSuggestion( $serviceName, $config ) {
		global $wgMemc;

		if ( self::checkTranslationServiceFailure( $serviceName ) ) {
			return null;
		}

		$code = $this->targetLanguage;
		$definition = trim( strval( $this->getDefinition() ) );
		$definition = self::wrapUntranslatable( $definition );

		$memckey = wfMemckey( 'translate-tmsug-badcodes-' . $serviceName );
		$unsupported = $wgMemc->get( $memckey );

		if ( $definition === '' || isset( $unsupported[$code] ) ) {
			return null;
		}

		/* There is 5000 *character* limit, but encoding needs to be taken into
		 * account. Not sure if this applies also to post method. */
		if ( strlen( rawurlencode( $definition ) ) > 4900 ) {
			return null;
		}

		$options = self::makeGoogleQueryParams( $definition, "en|$code", $config );
		$json = Http::post( $config['url'], $options );
		$response = FormatJson::decode( $json );

		if ( $json === false ) {
				// Most likely a timeout or other general error
				self::reportTranslationServiceFailure( $serviceName );

				return null;
		} elseif ( !is_object( $response ) ) {
				error_log(  __METHOD__ . ': Unable to parse reply: ' . strval( $json ) );
				return null;
		}

		if ( $response->responseStatus === 200 ) {
			$text = Sanitizer::decodeCharReferences( $response->responseData->translatedText );
			$text = self::unwrapUntranslatable( $text );
			$text = $this->suggestionField( $text );
			return Html::rawElement( 'div', null, self::legend( $serviceName ) . $text . self::clear() );
		} elseif ( $response->responseDetails === 'invalid translation language pair' ) {
			$unsupported[$code] = true;
			$wgMemc->set( $memckey, $unsupported, 60 * 60 * 8 );
		} else {
			// Unknown error, assume the worst
			self::reportTranslationServiceFailure( $serviceName );
			wfWarn(  __METHOD__ . "($serviceName): " . $response->responseDetails );
			error_log( __METHOD__ . "($serviceName): " . $response->responseDetails );
			return null;
		}
	}

	protected static function makeGoogleQueryParams( $definition, $pair, $config ) {
		global $wgSitename, $wgVersion, $wgProxyKey;
		$options = array();
		$options['timeout'] = $config['timeout'];

		$options['postData'] = array(
			'q' => $definition,
			'v' => '1.0',
			'langpair' => $pair,
			// Unique but not identifiable
			'userip' => sha1( $wgProxyKey . wfGetIp() ),
			'x-application' => "$wgSitename (MediaWiki $wgVersion; Translate " . TRANSLATE_VERSION . ")",
		);

		if ( $config['key'] ) {
			$options['postData']['key'] = $config['key'];
		}

		return $options;
	}

	protected function getMicrosoftSuggestion( $serviceName, $config ) {
		global $wgMemc;

		if ( self::checkTranslationServiceFailure( $serviceName ) ) {
			return null;
		}

		$code = $this->targetLanguage;
		$definition = trim( strval( $this->getDefinition() ) );
		$definition = self::wrapUntranslatable( $definition );

		$memckey = wfMemckey( 'translate-tmsug-badcodes-' . $serviceName );
		$unsupported = $wgMemc->get( $memckey );

		if ( $definition === '' || isset( $unsupported[$code] ) ) {
			return null;
		}

		$options = array();
		$options['timeout'] = $config['timeout'];

		$params = array(
			'text' => $definition,
			'to' => $code,
		);

		if ( isset( $config['key'] ) ) {
			$params['appId'] = $config['key'];
		} else {
			return null;
		}

		$url = $config['url'] . '?' . wfArrayToCgi( $params );
		$url = wfExpandUrl( $url );

		$options['method'] = 'GET';

		if ( class_exists( 'MWHttpRequest' ) ) {
			$req = MWHttpRequest::factory( $url, $options );
		} else {
			$req = HttpRequest::factory( $url, $options );
		}

		$status = $req->execute();

		if ( !$status->isOK() ) {
			$error = $req->getContent();
			if ( strpos( $error, 'must be a valid language' ) !== false ) {
				$unsupported[$code] = true;
				$wgMemc->set( $memckey, $unsupported, 60 * 60 * 8 );
				return null;
			}

			if ( $error ) {
				error_log(  __METHOD__ . ': Http::get failed:' . $error );
			} else {
				error_log( __METHOD__ . ': Unknown error, grr' );
			}
			// Most likely a timeout or other general error
			self::reportTranslationServiceFailure( $serviceName );
			return null;
		}

		$ret = $req->getContent();
		$text = preg_replace( '~<string.*>(.*)</string>~', '\\1', $ret  );
		$text = Sanitizer::decodeCharReferences( $text );
		$text = self::unwrapUntranslatable( $text );
		$text = $this->suggestionField( $text );
		return Html::rawElement( 'div', null, self::legend( $serviceName ) . $text . self::clear() );
	}

	protected static function wrapUntranslatable( $text ) {
		$text = str_replace( "\n", "!N!", $text );
		$wrap = '<span class="notranslate">\0</span>';
		$text = preg_replace( '~%[^% ]+%|\$\d|{VAR:[^}]+}|{?{(PLURAL|GRAMMAR|GENDER):[^|]+\||%(\d\$)?[sd]~', $wrap, $text );
		return $text;
	}

	protected static function unwrapUntranslatable( $text ) {
		$text = str_replace( '!N!', "\n", $text );
		$text = preg_replace( '~<span class="notranslate">(.*?)</span>~', '\1', $text );
		return $text;
	}

	protected function getApertiumSuggestion( $serviceName, $config ) {
		global $wgMemc;

		if ( self::checkTranslationServiceFailure( $serviceName ) ) {
			return null;
		}

		$page = $this->page;
		$code = $this->targetLanguage;
		$ns = $this->title->getNamespace();

		$memckey = wfMemckey( 'translate-tmsug-pairs-' . $serviceName );
		$pairs = $wgMemc->get( $memckey );

		if ( !$pairs ) {

			$pairs = array();
			$json = Http::get( $config['pairs'], 5 );
			$response = FormatJson::decode( $json );

			if ( $json === false ) {
				self::reportTranslationServiceFailure( $serviceName );
				return null;
			} elseif ( !is_object( $response ) ) {
				error_log(  __METHOD__ . ': Unable to parse reply: ' . strval( $json ) );
				return null;
			}

			foreach ( $response->responseData as $pair ) {
				$source = $pair->sourceLanguage;
				$target = $pair->targetLanguage;
				if ( !isset( $pairs[$target] ) ) {
					$pairs[$target] = array();
				}
				$pairs[$target][$source] = true;
			}

			$wgMemc->set( $memckey, $pairs, 60 * 60 * 24 );
		}

		if ( isset( $config['codemap'][$code] ) ) {
			$code = $config['codemap'][$code];
		}

		$code = str_replace( '-', '_', wfBCP47( $code ) );

		if ( !isset( $pairs[$code] ) ) {
			return;
		}

		$suggestions = array();

		$codemap = array_flip( $config['codemap'] );
		foreach ( $pairs[$code] as $candidate => $unused ) {
			$mwcode = str_replace( '_', '-', strtolower( $candidate ) );

			if ( isset( $codemap[$mwcode] ) ) {
				$mwcode = $codemap[$mwcode];
			}

			$text = TranslateUtils::getMessageContent( $page, $mwcode, $ns );
			if ( $text === null || TranslateEditAddons::hasFuzzyString( $text ) ) {
				continue;
			}

			$title = Title::makeTitleSafe( $ns, "$page/$mwcode" );
			if ( $title && TranslateEditAddons::isFuzzy( $title ) ) {
				continue;
			}

			$options = self::makeGoogleQueryParams( $text, "$candidate|$code", $config );
			$options['postData']['format'] = 'html';
			$json = Http::post( $config['url'], $options );
			$response = FormatJson::decode( $json );
			if ( $json === false || !is_object( $response ) ) {
				self::reportTranslationServiceFailure( $serviceName );
				break; // Too slow, back off
			} elseif ( $response->responseStatus !== 200 ) {
				error_log( __METHOD__ . " (HTTP {$response->responseStatus}) with ($serviceName ($candidate|$code)): " . $response->responseDetails );
			} else {
				$sug = Sanitizer::decodeCharReferences( $response->responseData->translatedText );
				$sug = trim( $sug );
				$sug = $this->suggestionField( $sug );
				$suggestions[] = Html::rawElement( 'div',
					array( 'title' => $text ),
					self::legend( "$serviceName ($candidate)" ) . $sug . self::clear()
				);
			}
		}

		if ( !count( $suggestions ) ) {
			return null;
		}

		$divider = Html::element( 'div', array( 'style' => 'margin-bottom: 0.5ex' ) );
		return implode( "$divider\n", $suggestions );
	}

	public function getDefinitionBox() {
		$en = $this->getDefinition();
		if ( $en === null ) {
			return null;
		}

		global $wgUser;

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

		$dialogID = $this->dialogID();
		$id = Sanitizer::escapeId( "def-$dialogID" );
		$msg = $this->adder( $id ) . "\n" . Html::rawElement( 'span',
			array( 'class' => 'mw-translate-edit-deftext' ),
			TranslateUtils::convertWhiteSpaceToHTML( $en )
		);

		$msg .= $this->wrapInsert( $id, $en );

		$class = array( 'class' => 'mw-sp-translate-edit-definition mw-translate-edit-definition' );

		return TranslateUtils::fieldset( $label, $msg, $class );
	}

	public function getTranslationDisplayBox() {
		$en = $this->getTranslation();
		if ( $en === null ) {
			return null;
		}
		$label = wfMsg( 'translate-edit-translation' );
		$class = array( 'class' => 'mw-translate-edit-translation' );
		$msg = Html::rawElement( 'span',
			array( 'class' => 'mw-translate-edit-translationtext' ),
			TranslateUtils::convertWhiteSpaceToHTML( $en )
		);

		return TranslateUtils::fieldset( $label, $msg, $class );
	}

	public function getCheckBox() {
		global $wgTranslateDocumentationLanguageCode;

		$placeholder = Html::element( 'div', array( 'class' => 'mw-translate-messagechecks' ) );

		if ( $this->group === null ) {
			return;
		}

		$page = $this->page;
		$translation = $this->getTranslation();
		$code = $this->targetLanguage;
		$en = $this->getDefinition();

		if ( strval( $translation ) === '' ) {
			return $placeholder;
		}

		if ( $code === $wgTranslateDocumentationLanguageCode ) {
			return null;
		}

		$checker = $this->group->getChecker();
		if ( !$checker ) {
			return null;
		}

		$message = new FatMessage( $page, $en );
		// Take the contents from edit field as a translation
		$message->setTranslation( $translation );

		$checks = $checker->checkMessage( $message, $code );
		if ( !count( $checks ) ) {
			return $placeholder;
		}

		$checkMessages = array();
		foreach ( $checks as $checkParams ) {
			array_splice( $checkParams, 1, 0, 'parseinline' );
			$checkMessages[] = call_user_func_array( 'wfMsgExt', $checkParams );
		}

		return Html::rawElement( 'div', array( 'class' => 'mw-translate-messagechecks' ),
			TranslateUtils::fieldset(
			wfMsgHtml( 'translate-edit-warnings' ), implode( '<hr />', $checkMessages ),
			array( 'class' => 'mw-sp-translate-edit-warnings' )
		) );
	}

	public function getOtherLanguagesBox() {
		global $wgLang;

		$code = $this->targetLanguage;
		$page = $this->page;
		$ns = $this->title->getNamespace();

		$boxes = array();
		foreach ( self::getFallbacks( $code ) as $fbcode ) {
			$text = TranslateUtils::getMessageContent( $page, $fbcode, $ns );
			if ( $text === null ) {
				continue;
			}

			$label =
				TranslateUtils::getLanguageName( $fbcode, false, $wgLang->getCode() ) .
				wfMsg( 'word-separator' ) .
				wfMsg( 'parentheses', wfBCP47( $fbcode ) );

			$target = Title::makeTitleSafe( $ns, "$page/$fbcode" );
			if ( $target ) {
				$label = self::ajaxEditLink( $target, htmlspecialchars( $label ) );
			}

			$dialogID = $this->dialogID();
			$id = Sanitizer::escapeId( "other-$fbcode-$dialogID" );

			$params = array( 'class' => 'mw-translate-edit-item' );

			$display = TranslateUtils::convertWhiteSpaceToHTML( $text );
			$display = Html::rawElement( 'span', array(
				'lang' => $fbcode,
				'dir' => Language::factory( $fbcode )->getDir() ),
				$display
			);

			$contents = self::legend( $label ) . "\n" . $this->adder( $id ) .
				$display . self::clear();

			$boxes[] = Html::rawElement( 'div', $params, $contents ) .
				$this->wrapInsert( $id, $text );
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
		global $wgTranslateDocumentationLanguageCode, $wgOut;

		if ( !$wgTranslateDocumentationLanguageCode ) {
			return null;
		}

		$page = $this->page;
		$ns = $this->title->getNamespace();

		$title = Title::makeTitle( $ns, $page . '/' . $wgTranslateDocumentationLanguageCode );
		$edit = self::ajaxEditLink( $title, wfMsgHtml( 'translate-edit-contribute' ) );
		$info = TranslateUtils::getMessageContent( $page, $wgTranslateDocumentationLanguageCode, $ns );

		$class = 'mw-sp-translate-edit-info';

		$gettext = $this->formatGettextComments();
		if ( $info !== null && $gettext ) $info .= Html::element( 'hr' );
		$info .= $gettext;

		if ( strval( $info ) === '' ) {
			$info = wfMsg( 'translate-edit-no-information' );
			$class = 'mw-sp-translate-edit-noinfo';
		}
		$class .= ' mw-sp-translate-message-documentation';

		$contents = $wgOut->parse( $info );
		// Remove whatever block element wrapup the parser likes to add
		$contents = preg_replace( '~^<([a-z]+)>(.*)</\1>$~us', '\2', $contents );

		return TranslateUtils::fieldset(
			wfMsgHtml( 'translate-edit-information', $edit, $page ), $contents, array( 'class' => $class )
		);

	}

	protected function formatGettextComments() {
		if ( $this->group instanceof FileBasedMessageGroup ) {
			$ffs = $this->group->getFFS();
			if ( $ffs instanceof GettextFFS ) {
				global $wgContLang;
				$mykey = $wgContLang->lcfirst( $this->page );
				$data = $ffs->read( 'en' );
				$help = $data['TEMPLATE'][$mykey]['comments'];
				// Do not display an empty comment. That's no help and takes up unnecessary space.
				$conf = $this->group->getConfiguration();
				if ( isset( $conf['BASIC']['codeBrowser'] ) ) {
					$out = '';
					$pattern = $conf['BASIC']['codeBrowser'];
					$pattern = str_replace( '%FILE%', '\1', $pattern );
					$pattern = str_replace( '%LINE%', '\2', $pattern );
					$pattern = "[$pattern \\1:\\2]";
					foreach ( $help as $type => $lines ) {
						if ( $type === ':' ) {
							$files = '';
							foreach ( $lines as $line ) {
								$files .= ' ' . preg_replace( '/([^ :]+):(\d+)/', $pattern, $line );
							}
							$out .= "<nowiki>#:</nowiki> $files<br />";
						} else {
							foreach ( $lines as $line ) {
								$out .= "<nowiki>#$type</nowiki> $line<br />";
							}
						}
					}
					return "$out";
				}
			}
		}

		return '';
	}

	protected function getPageDiff() {
		if ( $this->group instanceof WikiPageMessageGroup ) {
			return null;
		}

		// Shortcuts
		$key = $this->page;

		$definitionTitle = Title::makeTitleSafe( $this->title->getNamespace(), "$key/en" );
		if ( !$definitionTitle || !$definitionTitle->exists() ) {
			return null;
		}

		$db = wfGetDB( DB_MASTER );
		$id = $db->selectField( 'revtag_type', 'rtt_id',
			array( 'rtt_name' => 'tp:transver' ), __METHOD__ );

		$conds = array(
			'rt_page' => $this->title->getArticleId(),
			'rt_type' => $id,
			'rt_revision' => $this->title->getLatestRevID(),
		);

		$latestRevision = $definitionTitle->getLatestRevID();

		$translationRevision =  $db->selectField( 'revtag', 'rt_value', $conds, __METHOD__ );
		if ( $translationRevision === false ) {
			return null;
		}

		$oldtext = Revision::newFromTitle( $definitionTitle, $translationRevision )->getText();
		$newtext = Revision::newFromTitle( $definitionTitle, $latestRevision )->getText();

		if ( $oldtext === $newtext ) {
			return null;
		}

		$diff = new DifferenceEngine;
		$diff->setText( $oldtext, $newtext );
		$diff->setReducedLineNumbers();
		$diff->showDiffStyle();

		return $diff->getDiff( wfMsgHtml( 'tpt-diff-old' ), wfMsgHtml( 'tpt-diff-new' ) );
	}

	protected function getTranslationPageDiff() {
		global $wgEnablePageTranslation;

		if ( !$wgEnablePageTranslation ) {
			return null;
		}

		if ( !$this->group instanceof WikiPageMessageGroup ) {
			return null;
		}

		// Shortcuts
		$code = $this->targetLanguage;
		$key = $this->page;

		// TODO: encapsulate somewhere
		$page = TranslatablePage::newFromTitle( $this->group->getTitle() );
		$rev = $page->getTransRev( "$key/$code" );
		$latest = $page->getMarkedTag();
		if ( $rev === $latest ) {
			return null;
		}

		$oldpage = TranslatablePage::newFromRevision( $this->group->getTitle(), $rev );
		$oldtext = $newtext = null;
		foreach ( $oldpage->getParse()->getSectionsForSave() as $section ) {
			if ( $this->group->getTitle()->getPrefixedDBKey() . '/' . $section->id === $key ) {
				$oldtext = $section->getTextForTrans();
			}
		}

		foreach ( $page->getParse()->getSectionsForSave() as $section ) {
			if ( $this->group->getTitle()->getPrefixedDBKey() . '/' . $section->id === $key ) {
				$newtext = $section->getTextForTrans();
			}
		}

		if ( $oldtext === $newtext ) {
			return null;
		}

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
			foreach ( $fallbacks as $k => $v ) {
				if ( $v === $code ) {
					unset( $fallbacks[$k] );
				}
			}

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

		if ( !$title ) {
			$title = "$name ($code)";
		}

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

	public function getLazySuggestionBox() {
		if ( $this->group === null || !$this->targetLanguage ) {
			return null;
		}

		$url = SpecialPage::getTitleFor( 'Translate', 'editpage' )->getLocalUrl( array(
			'suggestions' => 'only',
			'page' => $this->title->getPrefixedDbKey(),
			'loadgroup' => $this->group->getId(),
		) );
		$url = Xml::encodeJsVar( $url );

		$id = Sanitizer::escapeId( 'tm-lazysug-' . $this->dialogID() );
		$target = self::jQueryPathId( $id );

		$script = Html::inlineScript( "jQuery($target).load($url)" );
		$spinner = Html::element( 'div', array( 'class' => 'mw-ajax-loader' ) );
		return Html::rawElement( 'div', array( 'id' => $id ), $script . $spinner );
	}

	public function dialogID() {
		$hash = sha1( $this->title->getPrefixedDbKey() );
		return substr( $hash, 0, 4 );
	}

	public function adder( $source ) {
		if ( !$this->editMode ) {
			return '';
		}
		$target = self::jQueryPathId( $this->getTextareaId() );
		$source = self::jQueryPathId( $source );
		$params = array(
			'onclick' => "jQuery($target).val(jQuery($source).text()).focus(); return false;",
			'href' => '#',
			'title' => wfMsg( 'translate-use-suggestion' ),
			'class' => 'mw-translate-adder',
		);

		return Html::element( 'a', $params, '↓' );
	}

	public function wrapInsert( $id, $text ) {
		return Html::element( 'pre', array( 'id' => $id, 'style' => 'display: none;' ), $text );
	}

	public function suggestionField( $text ) {
		static $counter = 0;

		$counter++;
		$dialogID = $this->dialogID();
		$id = Sanitizer::escapeId( "tmsug-$dialogID-$counter" );
		$contents = TranslateUtils::convertWhiteSpaceToHTML( $text );
		$contents .= $this->wrapInsert( $id, $text );

		return $this->adder( $id ) . "\n" . $contents;
	}

	/**
	 * Ajax-enabled message editing link.
	 * @param $target Title: Title of the target message.
	 * @param $text String: Link text for Linker::link()
	 * @return link
	 */
	public static function ajaxEditLink( $target, $text ) {
		global $wgUser;

		list( $page, ) = TranslateEditAddons::figureMessage( $target );
		$group = TranslateUtils::messageKeyToGroup( $target->getNamespace(), $page );

		$params = array();
		$params['action'] = 'edit';
		$params['loadgroup'] = $group;

		$jsEdit = TranslationEditPage::jsEdit( $target, $group );

		return $wgUser->getSkin()->link( $target, $text, $jsEdit, $params );
	}

	public static function jQueryPathId( $id ) {
		return Xml::encodeJsVar( "#$id" );
	}

	/**
	 * How many failures during failure period need to happen to consider
	 * the service being temporarily off-line. */
	protected static $serviceFailureCount = 5;
	/**
	 * How long after the last detected failure we clear the status and
	 * try again.
	 */
	protected static $serviceFailurePeriod = 900;

	/**
	 * Checks whether the given service has exceeded failure count */
	public static function checkTranslationServiceFailure( $service ) {
		global $wgMemc;

		$key = wfMemckey( "translate-service-$service" );
		$value = $wgMemc->get( $key );
		if ( !is_string( $value ) ) {
			return false;
		}
		list( $count, $failed ) = explode( '|', $value, 2 );

		if ( $failed + ( 2 * self::$serviceFailurePeriod ) < wfTimestamp() ) {
			if ( $count >= self::$serviceFailureCount ) {
				error_log( "Translation service $service (was) restored" );
			}
			$wgMemc->delete( $key );
			return false;
		} elseif ( $failed + self::$serviceFailurePeriod < wfTimestamp() ) {
			/* We are in suspicious mode and one failure is enough to update
			 * failed timestamp. If the service works however, let's use it.
			 * Previous failures are forgotten after another failure period
			 * has passed */
			return false;
		}

		return $count >= self::$serviceFailureCount;
	}

	/**
	 * Increases the failure count for a given service */
	public static function reportTranslationServiceFailure( $service ) {
		global $wgMemc;

		$key = wfMemckey( "translate-service-$service" );
		$value = $wgMemc->get( $key );
		if ( !is_string( $value ) ) {
			$count = 0;
		} else {
			list( $count, ) = explode( '|', $value, 2 );
		}

		$count += 1;
		$failed = wfTimestamp();
		$wgMemc->set( $key, "$count|$failed", self::$serviceFailurePeriod * 5 );

		if ( $count == self::$serviceFailureCount ) {
			error_log( "Translation service $service suspended" );
		} elseif ( $count > self::$serviceFailureCount ) {
			error_log( "Translation service $service still suspended" );
		}
	}

	public static function addModules( OutputPage $out ) {
		if ( method_exists( $out, 'addModules' ) ) {
			$out->addModules( array(
				'jquery.form',
				'jquery.ui.dialog',
				'jquery.autoresize',
				'ext.translate.quickedit',
			) );
		} else {
			// Our class
			$out->addScriptFile( TranslateUtils::assetPath( 'js/quickedit.js' ) );

			// Core jQuery
			$out->includeJQuery();
			$out->addScriptFile( TranslateUtils::assetPath( 'js/jquery-ui-1.7.2.custom.min.js' ) );

			// Additional jQuery stuff
			$out->addScriptFile( TranslateUtils::assetPath( 'js/jquery.form.js' ) );
			$out->addExtensionStyle( TranslateUtils::assetPath( 'js/base/custom-theme/jquery-ui-1.7.2.custom.css' ) );
		}

		$vars = array(
			'trlMsgNoNext' => wfMsg( 'translate-js-nonext' ),
			'trlMsgSaveFailed' => wfMsg( 'translate-js-save-failed' ),
		);

		$out->addScript( Skin::makeVariablesScript( $vars ) );

		// Might be needed, but ajax doesn't load it
		// Globals :(
		$diff = new DifferenceEngine;
		$diff->showDiffStyle();
	}
}
