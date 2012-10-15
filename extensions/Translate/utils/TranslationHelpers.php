<?php
/**
 * Contains helper class for interface parts that aid translations in doing
 * their thing.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2010-2012 Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Provides the nice boxes that aid the translators to do their job.
 * Boxes contain definition, documentation, other languages, translation memory
 * suggestions, highlighted changes etc.
 */
class TranslationHelpers {
	/**
	 * @var MessageHandle
	 * @since 2012-01-04
	 */
	protected $handle;
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
	 * @param $title Title: Title of a page that holds a translation.
	 * @param $group String: Group id that should be used, otherwise autodetected from title.
	 */
	public function __construct( Title $title, $groupId ) {
		$this->handle = new MessageHandle( $title );
		$this->group = $this->getMessageGroup( $this->handle, $groupId );
	}

	/**
	 * Tries to determine to which group this message belongs. It tries to get
	 * group id from loadgroup GET-paramater, but fallbacks to messageIndex file
	 * if no valid group was provided.
	 *
	 * @return MessageGroup which the key belongs to, or null.
	 */
	protected function getMessageGroup( MessageHandle $handle, $groupId ) {
		$mg = MessageGroups::getGroup( $groupId );

		# If we were not given (a valid) group
		if ( $mg === null ) {
			$groupId = MessageIndex::getPrimaryGroupId( $handle );
			$mg = MessageGroups::getGroup( $groupId );
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

		$this->mustBeKnownMessage();

		if ( method_exists( $this->group, 'getMessageContent' ) ) {
			$this->definition = $this->group->getMessageContent( $this->handle, $this->group->getSourceLanguage() );
		} else {
			$this->definition = $this->group->getMessage( $this->handle->getKey(), $this->group->getSourceLanguage() );
		}

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
		$title = $this->handle->getTitle();
		$page = $this->handle->getKey();
		$code = $this->handle->getCode();
		$group = $this->group;

		// Try database first
		$translation = TranslateUtils::getMessageContent(
			$page, $code, $title->getNamespace()
		);

		if ( $translation !== null ) {
			if ( !TranslateEditAddons::hasFuzzyString( $translation ) && TranslateEditAddons::isFuzzy( $title ) ) {
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
	 * Gets the linguistically correct language code for translation
	 */
	public function getTargetLanguage() {
		global $wgLanguageCode, $wgTranslateDocumentationLanguageCode;

		$code = $this->handle->getCode();
		if ( !$code ) {
			$this->mustBeKnownMessage();
			$code = $this->group->getSourceLanguage();
		}
		if ( $code === $wgTranslateDocumentationLanguageCode ) {
			return $wgLanguageCode;
		}
		return $code;
	}

	/**
	 * Returns block element HTML snippet that contains the translation aids.
	 * Not all boxes are shown all the time depending on whether they have
	 * any information to show and on configuration variables.
	 * @param $suggestions string
	 * @return String. Block level HTML snippet or empty string.
	 */
	public function getBoxes( $suggestions = 'sync' ) {
		// Box filter
		$all = $this->getBoxNames();

		if ( $suggestions === 'async' ) {
			$all['translation-memory'] = array( $this, 'getLazySuggestionBox' );
		} elseif ( $suggestions === 'only' ) {
			return (string) $this->callBox( 'translation-memory', $all['translation-memory'], array( 'lazy' ) );
		} elseif ( $suggestions === 'checks' ) {
			global $wgRequest;
			$this->translation = $wgRequest->getText( 'translation' );
			return (string) $this->callBox( 'check', $all['check'] );
		}

		if ( $this->group instanceof RecentMessageGroup ) {
			$all['last-diff'] = array( $this, 'getLastDiff' );
		}

		$boxes = array();
		foreach ( $all as $type => $cb ) {
			$box = $this->callBox( $type, $cb );
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

	/// @since 2012-01-04
	protected function callBox( $type, $cb, $params = array() ) {
		try {
			return call_user_func_array( $cb, $params );
		} catch ( TranslationHelperExpection $e ) {
			return"<!-- Box $type not available: {$e->getMessage()} -->";
		}
	}

	/**
	 * @return array
	 */
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
	 * @param $serviceName
	 * @param $config
	 * @return string Html snippet which contains the suggestions.
	 */
	protected function getTmBox( $serviceName, $config ) {
		$this->mustHaveDefinition();
		self::checkTranslationServiceFailure( $serviceName );

		// Needed data
		$page = $this->handle->getKey();
		$code = $this->handle->getCode();
		if ( !$code ) {
			$code = $this->group->getSourceLanguage();
		}
		$definition = $this->getDefinition();
		$ns = $this->handle->getTitle()->getNsText();

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

		if ( $suggestions === false ) {
			// Assume timeout
			self::reportTranslationServiceFailure( $serviceName );
		}
		$suggestions = FormatJson::decode( $suggestions, true );

		foreach ( $suggestions as $s ) {
			// No use to suggest them what they are currently viewing
			if ( $s['context'] === "$ns:$page" ) {
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

		$boxes = array_slice( $boxes, 0, 3 );
		$result = implode( "\n", $boxes );

		// Limit to three max
		return $result;
	}

	/**
	 * Returns suggestions from a translation memory.
	 * @param $serviceName
	 * @param $config
	 * @return string Html snippet which contains the suggestions.
	 */
	protected function getTTMServerBox( $serviceName, $config ) {
		$this->mustHaveDefinition();
		$this->mustBeTranslation();

		$source = $this->group->getSourceLanguage();
		$code = $this->handle->getCode();
		$definition = $this->getDefinition();
		$suggestions = TTMServer::primary()->query( $source, $code, $definition );
		if ( count( $suggestions ) === 0 ) {
			return null;
		}

		foreach ( $suggestions as $s ) {
			$accuracy = wfMsgHtml( 'translate-edit-tmmatch' , sprintf( '%.2f', $s['quality'] * 100 ) );
			$legend = array( $accuracy => array() );

			$sourceTitle = Title::newFromText( $s['context'] );
			$handle = new MessageHandle( $sourceTitle );
			$targetTitle = Title::makeTitle( $sourceTitle->getNamespace(), $handle->getKey() . "/$code" );
			if ( $targetTitle ) {
				$legend[$accuracy][] = self::ajaxEditLink( $targetTitle, '•' );
			}

			// Show the source text in a tooltip
			$text = $this->suggestionField( $s['target'] );
			$params = array( 'class' => 'mw-sp-translate-edit-tmsug', 'title' => $s['source'] );

			// Group identical suggestions together
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

		// Limit to three best
		$boxes = array_slice( $boxes, 0, 3 );
		$result = implode( "\n", $boxes );
		return $result;
	}


	/**
	 * @param $async bool
	 * @return null|string
	 * @throws MWException
	 */
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
			} elseif ( $config['type'] === 'ttmserver' ) {
				$boxes[] = $this->getTTMServerBox( $name, $config );
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

		$this->mustHaveDefinition();
		self::checkTranslationServiceFailure( $serviceName );

		$code = $this->handle->getCode();
		$definition = trim( strval( $this->getDefinition() ) );
		$definition = self::wrapUntranslatable( $definition );

		$memckey = wfMemckey( 'translate-tmsug-badcodes-' . $serviceName );
		$unsupported = $wgMemc->get( $memckey );

		if ( isset( $unsupported[$code] ) ) {
			return null;
		}

		/* There is 5000 *character* limit, but encoding needs to be taken into
		 * account. Not sure if this applies also to post method. */
		if ( strlen( rawurlencode( $definition ) ) > 4900 ) {
			return null;
		}

		$source = $this->group->getSourceLanguage();
		$options = self::makeGoogleQueryParams( $definition, "$source|$code", $config );
		$json = Http::post( $config['url'], $options );
		$response = FormatJson::decode( $json );

		if ( $json === false ) {
			// Most likely a timeout or other general error
			self::reportTranslationServiceFailure( $serviceName );
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
			wfWarn(  __METHOD__ . "($serviceName): " . $response->responseDetails );
			error_log( __METHOD__ . "($serviceName): " . $response->responseDetails );
			self::reportTranslationServiceFailure( $serviceName );
		}

		return null;
	}

	protected static function makeGoogleQueryParams( $definition, $pair, $config ) {
		global $wgSitename, $wgVersion, $wgProxyKey, $wgRequest;
		$options = array();
		$options['timeout'] = $config['timeout'];

		$options['postData'] = array(
			'q' => $definition,
			'v' => '1.0',
			'langpair' => $pair,
			// Unique but not identifiable
			'userip' => sha1( $wgProxyKey . ( method_exists( $wgRequest, 'getIP' ) ? $wgRequest->getIP() : wfGetIP() ) ),
			'x-application' => "$wgSitename (MediaWiki $wgVersion; Translate " . TRANSLATE_VERSION . ")",
		);

		if ( $config['key'] ) {
			$options['postData']['key'] = $config['key'];
		}

		return $options;
	}

	protected function getMicrosoftSuggestion( $serviceName, $config ) {
		global $wgMemc;

		$this->mustHaveDefinition();
		self::checkTranslationServiceFailure( $serviceName );

		$code = $this->handle->getCode();
		$definition = trim( strval( $this->getDefinition() ) );
		$definition = self::wrapUntranslatable( $definition );

		$memckey = wfMemckey( 'translate-tmsug-badcodes-' . $serviceName );
		$unsupported = $wgMemc->get( $memckey );

		if ( isset( $unsupported[$code] ) ) {
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

		self::checkTranslationServiceFailure( $serviceName );

		$page = $this->handle->getKey();
		$code = $this->handle->getCode();
		$ns = $this->handle->getTitle()->getNamespace();

		$memckey = wfMemckey( 'translate-tmsug-pairs-' . $serviceName );
		$pairs = $wgMemc->get( $memckey );

		if ( !$pairs ) {

			$pairs = array();
			$json = Http::get( $config['pairs'], 5 );
			$response = FormatJson::decode( $json );

			if ( $json === false ) {
				self::reportTranslationServiceFailure( $serviceName );
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
			return null;
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
		$this->mustHaveDefinition();
		$en = $this->getDefinition();

		$linker = class_exists( 'DummyLinker' ) ? new DummyLinker : new Linker;
		$title = $linker->link(
			SpecialPage::getTitleFor( 'Translate' ),
			htmlspecialchars( $this->group->getLabel() ),
			array(),
			array(
				'group' => $this->group->getId(),
				'language' => $this->handle->getCode()
			)
		);

		$label =
			wfMsg( 'translate-edit-definition' ) .
			wfMsg( 'word-separator' ) .
			wfMsg( 'parentheses', $title );

		// Source language object
		$sl = Language::factory( $this->group->getSourceLanguage() );

		$dialogID = $this->dialogID();
		$id = Sanitizer::escapeId( "def-$dialogID" );
		$msg = $this->adder( $id, $sl ) . "\n" . Html::rawElement( 'div',
			array(
				'class' => 'mw-translate-edit-deftext',
				'dir' => $sl->getDir(),
				'lang' => $sl->getCode(),
			),
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
		$this->mustBeKnownMessage();

		global $wgTranslateDocumentationLanguageCode;

		$placeholder = Html::element( 'div', array( 'class' => 'mw-translate-messagechecks' ) );

		$page = $this->handle->getKey();
		$translation = $this->getTranslation();
		$code = $this->handle->getCode();
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

		$code = $this->handle->getCode();
		$page = $this->handle->getKey();
		$ns = $this->handle->getTitle()->getNamespace();

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
			$display = Html::rawElement( 'div', array(
				'lang' => $fbcode,
				'dir' => Language::factory( $fbcode )->getDir() ),
				$display
			);

			$contents = self::legend( $label ) . "\n" . $this->adder( $id, $fbcode ) .
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

		$page = $this->handle->getKey();
		$ns = $this->handle->getTitle()->getNamespace();

		$title = Title::makeTitle( $ns, $page . '/' . $wgTranslateDocumentationLanguageCode );
		$edit = self::ajaxEditLink( $title, wfMsgHtml( 'translate-edit-contribute' ) );
		$info = TranslateUtils::getMessageContent( $page, $wgTranslateDocumentationLanguageCode, $ns );

		$class = 'mw-sp-translate-edit-info';

		$gettext = $this->formatGettextComments();
		if ( $info !== null && $gettext ) $info .= Html::element( 'hr' );
		$info .= $gettext;

		// The information is most likely in English
		$divAttribs = array( 'dir' => 'ltr', 'lang' => 'en', 'class' => 'mw-content-ltr' );

		if ( strval( $info ) === '' ) {
			global $wgLang;
			$info = wfMsg( 'translate-edit-no-information' );
			$class = 'mw-sp-translate-edit-noinfo';
			// The message saying that there's no info, should be translated
			$divAttribs = array( 'dir' => $wgLang->getDir(), 'lang' => $wgLang->getCode() );
		}
		$class .= ' mw-sp-translate-message-documentation';

		$contents = $wgOut->parse( $info );
		// Remove whatever block element wrapup the parser likes to add
		$contents = preg_replace( '~^<([a-z]+)>(.*)</\1>$~us', '\2', $contents );

		return TranslateUtils::fieldset(
			wfMsgHtml( 'translate-edit-information', $edit, $page ), Html::rawElement( 'div',
			$divAttribs, $contents ), array( 'class' => $class )
		);

	}

	protected function formatGettextComments() {
		$this->mustBeKnownMessage();
		// We need to get the primary group to get the correct file
		// So $group can be different from $this->group
		$group = $this->handle->getGroup();
		if ( !$group instanceof FileBasedMessageGroup ) {
			return '';
		}

		$ffs = $group->getFFS();
		if ( $ffs instanceof GettextFFS ) {
			global $wgContLang;
			$mykey = $wgContLang->lcfirst( $this->handle->getKey() );
			$data = $ffs->read( $this->group->getSourceLanguage() );
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

		return '';
	}

	protected function getPageDiff() {
		$this->mustBeKnownMessage();

		$group = $this->group;
		$title = $this->handle->getTitle();
		$key = $this->handle->getKey();

		if ( $group instanceof WikiPageMessageGroup || !$title->exists() ) {
			return null;
		}

		$definitionTitle = Title::makeTitleSafe( $title->getNamespace(), "$key/en" );
		if ( !$definitionTitle || !$definitionTitle->exists() ) {
			return null;
		}

		$db = wfGetDB( DB_MASTER );
		$conds = array(
			'rt_page' => $title->getArticleId(),
			'rt_type' => RevTag::getType( 'tp:transver' ),
		);
		$options = array(
			'ORDER BY' => 'rt_revision DESC',
		);

		$latestRevision = $definitionTitle->getLatestRevID();

		$translationRevision = $db->selectField( 'revtag', 'rt_value', $conds, __METHOD__, $options );
		if ( $translationRevision === false ) {
			return null;
		}

		// Using newFromId instead of newFromTitle, because the page might have been renamed
		$oldrev = Revision::newFromId( $translationRevision );
		if ( !$oldrev ) {
			// And someone might still have deleted it
			return null;
		}
		$oldtext = $oldrev->getText();
		$newtext = Revision::newFromTitle( $definitionTitle, $latestRevision )->getText();

		if ( $oldtext === $newtext ) {
			return null;
		}

		$diff = new DifferenceEngine;
		if ( method_exists( 'DifferenceEngine', 'setTextLanguage' ) ) {
			$diff->setTextLanguage( $this->group->getSourceLanguage() );
		}
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

		$this->mustBeKnownMessage();
		if ( !$this->group instanceof WikiPageMessageGroup ) {
			return null;
		}

		// Shortcuts
		$code = $this->handle->getCode();
		$key = $this->handle->getKey();

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
		if ( method_exists( 'DifferenceEngine', 'setTextLanguage' ) ) {
			$diff->setTextLanguage( $this->group->getSourceLanguage() );
		}
		$diff->setText( $oldtext, $newtext );
		$diff->setReducedLineNumbers();
		$diff->showDiffStyle();

		return $diff->getDiff( wfMsgHtml( 'tpt-diff-old' ), wfMsgHtml( 'tpt-diff-new' ) );
	}

	protected function getLastDiff() {
		// Shortcuts
		$title = $this->handle->getTitle();
		$latestRevId = $title->getLatestRevID();
		$previousRevId = $title->getPreviousRevisionID( $latestRevId );

		$latestRev = Revision::newFromTitle( $title, $latestRevId );
		$previousRev = Revision::newFromTitle( $title, $previousRevId );

		$diffText = '';

		if ( $latestRev && $previousRev ) {
			$latest = $latestRev->getText();
			$previous = $previousRev->getText();
			if ( $previous !== $latest ) {
				$diff = new DifferenceEngine;
				if ( method_exists( 'DifferenceEngine', 'setTextLanguage' ) ) {
					$diff->setTextLanguage( $this->getTargetLanguage() );
				}
				$diff->setText( $previous, $latest );
				$diff->setReducedLineNumbers();
				$diff->showDiffStyle();
				$diffText = $diff->getDiff( false, false );
			}
		}

		if ( !$latestRev ) {
			return null;
		}

		global $wgUser;
		$user = $latestRev->getUserText( Revision::FOR_THIS_USER, $wgUser );
		$comment = $latestRev->getComment();

		if ( $diffText === '' ) {
			if ( strval( $comment ) !== '' ) {
				$text = wfMessage( 'translate-dynagroup-byc', $user, $comment )->escaped();
			} else {
				$text = wfMessage( 'translate-dynagroup-by', $user )->escaped();
			}
		} else {
			if ( strval( $comment ) !== '' ) {
				$text = wfMessage( 'translate-dynagroup-lastc', $user, $comment )->escaped();
			} else {
				$text = wfMessage( 'translate-dynagroup-last', $user )->escaped();
			}
		}

		return TranslateUtils::fieldset( $text, $diffText, array( 'class' => 'mw-sp-translate-latestchange' ) );
	}

	/**
	 * @param $label string
	 * @return string
	 */
	protected static function legend( $label ) {
		# Float it to the opposite direction
		return Html::rawElement( 'div',	array( 'class' => 'mw-translate-legend' ), $label );
	}

	/**
	 * @return string
	 */
	protected static function clear() {
		return Html::element( 'div', array( 'style' => 'clear:both;' ) );
	}

	/**
	 * @param $code string
	 * @return array
	 */
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

		// BC <1.19
		if ( method_exists( 'Language', 'getFallbacksFor' ) ) {
			$list = Language::getFallbacksFor( $code );
			array_pop( $list ); // Get 'en' away from the end
			$fallbacks = array_merge( $list , $fallbacks );
		} else {
			$realFallback = $code ? Language::getFallbackFor( $code ) : false;
			if ( $realFallback && $realFallback !== 'en' ) {
				$fallbacks = array_merge( array( $realFallback ), $fallbacks );
			}
		}

		return array_unique( $fallbacks );
	}

	/**
	 * @param $msg string
	 * @param $code string
	 * @param $title Title
	 * @param $makelink
	 * @return string
	 */
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

	/**
	 * @return null|string
	 */
	public function getLazySuggestionBox() {
		$this->mustBeKnownMessage();
		if ( !$this->handle->getCode() ) {
			return null;
		}

		$url = SpecialPage::getTitleFor( 'Translate', 'editpage' )->getLocalUrl( array(
			'suggestions' => 'only',
			'page' => $this->handle->getTitle()->getPrefixedDbKey(),
			'loadgroup' => $this->group->getId(),
		) );
		$url = Xml::encodeJsVar( $url );

		$id = Sanitizer::escapeId( 'tm-lazysug-' . $this->dialogID() );
		$target = self::jQueryPathId( $id );

		$script = Html::inlineScript( "jQuery($target).load($url)" );
		$spinner = Html::element( 'div', array( 'class' => 'mw-ajax-loader' ) );
		return Html::rawElement( 'div', array( 'id' => $id ), $script . $spinner );
	}

	/**
	 * @return string
	 */
	public function dialogID() {
		$hash = sha1( $this->handle->getTitle()->getPrefixedDbKey() );
		return substr( $hash, 0, 4 );
	}

	/**
	 * @param $source jQuery selector for element containing the source
	 * @param $lang Language code or object
	 * @return string
	 */
	public function adder( $source, $lang ) {
		if ( !$this->editMode ) {
			return '';
		}
		$target = self::jQueryPathId( $this->getTextareaId() );
		$source = self::jQueryPathId( $source );
		$dir = wfGetLangObj( $lang )->getDir();
		$params = array(
			'onclick' => "jQuery($target).val(jQuery($source).text()).focus(); return false;",
			'href' => '#',
			'title' => wfMsg( 'translate-use-suggestion' ),
			'class' => 'mw-translate-adder mw-translate-adder-' . $dir,
		);

		return Html::element( 'a', $params, '↓' );
	}

	/**
	 * @param $id string|int
	 * @param $text string
	 * @return string
	 */
	public function wrapInsert( $id, $text ) {
		return Html::element( 'pre', array( 'id' => $id, 'style' => 'display: none;' ), $text );
	}

	/**
	 * @param $text string
	 * @return string
	 */
	public function suggestionField( $text ) {
		static $counter = 0;

		$code = $this->getTargetLanguage();

		$counter++;
		$dialogID = $this->dialogID();
		$id = Sanitizer::escapeId( "tmsug-$dialogID-$counter" );
		$contents = Html::rawElement( 'div', array( 'lang' => $code,
			'dir' => Language::factory( $code )->getDir() ),
			TranslateUtils::convertWhiteSpaceToHTML( $text ) );
		$contents .= $this->wrapInsert( $id, $text );

		return $this->adder( $id, $code ) . "\n" . $contents;
	}

	/**
	 * Ajax-enabled message editing link.
	 * @param $target Title: Title of the target message.
	 * @param $text String: Link text for Linker::link()
	 * @return link
	 */
	public static function ajaxEditLink( $target, $text ) {
		$handle = new MessageHandle( $target );
		$groupId = MessageIndex::getPrimaryGroupId( $handle );

		$params = array();
		$params['action'] = 'edit';
		$params['loadgroup'] = $groupId;

		$jsEdit = TranslationEditPage::jsEdit( $target, $groupId );

		$linker = class_exists( 'DummyLinker' ) ? new DummyLinker() : new Linker();
		return $linker->link( $target, $text, $jsEdit, $params );
	}

	/**
	 * @param $id string
	 * @return string
	 */
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
	 * Checks whether the given service has exceeded failure count
	 * @param $service string
	 * @return bool
	 */
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

		if ( $count >= self::$serviceFailureCount ) {
			throw new TranslationHelperExpection( "web service $service is temporarily disabled" );
		}
	}

	/**
	 * Increases the failure count for a given service
	 * @param $service
	 */
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

		throw new TranslationHelperExpection( "web service $service failed to provide valid response" );
	}

	public static function addModules( OutputPage $out ) {
		$out->addModules( 'ext.translate.quickedit' );

		// Might be needed, but ajax doesn't load it
		// Globals :(
		/// @todo: remove when 1.17 is no longer supported.
		// The RL module name is different in 1.17 and >1.17
		$diff = new DifferenceEngine;
		$diff->showDiffStyle();
	}

	/// @since 2012-01-04
	protected function mustBeKnownMessage() {
		if ( !$this->group ) {
			throw new TranslationHelperExpection( 'unknown group' );
		}
	}
	/// @since 2012-01-04
	protected function mustBeTranslation() {
		if ( !$this->handle->getCode() ) {
			throw new TranslationHelperExpection( 'editing source language' );
		}
	}

	/// @since 2012-01-04
	protected function mustHaveDefinition() {
		if ( strval( $this->getDefinition() ) === '' ) {
			throw new TranslationHelperExpection( 'message does not have definition' );
		}
	}

}

/// @since 2012-01-04
class TranslationHelperExpection extends MWException {}
