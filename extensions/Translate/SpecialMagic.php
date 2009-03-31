<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * This special page helps with the translations of MediaWiki features that are
 * not in the main messages array.
 */
class SpecialMagic extends SpecialPage {
	/** Message prefix for translations */
	const MSG = 'translate-magic-';

	const MODULE_MAGIC     = 'words';
	const MODULE_SPECIAL   = 'special';
	const MODULE_NAMESPACE = 'namespace';

	/** List of supported modules */
	private $aModules = array(
		self::MODULE_SPECIAL,
		self::MODULE_NAMESPACE,
		self::MODULE_MAGIC
	);

	/** Page options */
	private $options = array();
	private $defaults = array();
	private $nondefaults = array();

	public function __construct() {
		SpecialPage::SpecialPage( 'Magic' );
	}

	/**
	 * @see SpecialPage::getDescription
	 */
	function getDescription() {
		return wfMsg( self::MSG . 'pagename' );
	}

	/**
	 * Returns xhtml output of the form
	 * GLOBALS: $wgLang, $wgTitle
	 */
	protected function getForm() {
		global $wgLang, $wgTitle, $wgScript;

		$form = Xml::tags( 'form',
			array(
				'action' => $wgScript,
				'method' => 'get'
			),

			'<table><tr><td>' .
				wfMsgHtml( 'translate-page-language' ) .
			'</td><td>' .
				TranslateUtils::languageSelector( $wgLang->getCode(), $this->options['language'] ) .
			'</td></tr><tr><td>' .
				wfMsgHtml( 'translate-magic-module' ) .
			'</td><td>' .
				$this->moduleSelector( $this->options['module'] ) .
			'</td></tr><tr><td colspan="2">' .
				Xml::submitButton( wfMsg( self::MSG . 'submit' ) ) . ' ' .
				Xml::submitButton( wfMsg( 'translate-magic-cm-export' ), array( 'name' => 'export' ) ) .
			'</td></tr></table>' .
			Xml::hidden( 'title', $wgTitle->getPrefixedText() )
			
		);
		return $form;
	}

	/**
	 * Helper function get module selector.
	 * Returns the xhtml-compatible select-element.
	 * @param $selectedId which value should be selected by default
	 * @return string
	 */
	protected function moduleSelector( $selectedId ) {
		$selector = new HTMLSelector( 'module', 'module', $selectedId );
		foreach ( $this->aModules as $code ) {
			$selector->addOption( wfMsg( self::MSG . $code ), $code );
		}
		return $selector->getHTML();
	}

	protected function setup( $parameters ) {
		global $wgUser, $wgRequest;

		$defaults = array(
		/* str  */ 'module'   => '',
		/* str  */ 'language' => $wgUser->getOption( 'language' ),
		/* bool */ 'export'   => false,
		/* bool */ 'savetodb' => false,
		);

		// Place where all non default variables will end
		$nondefaults = array();

		// Temporary store possible values parsed from parameters
		$options = $defaults;
		foreach ( $options as $v => $t ) {
			if ( is_bool( $t ) ) {
				$r = $wgRequest->getBool( $v, $options[$v] );
			} elseif ( is_int( $t ) ) {
				$r = $wgRequest->getInt( $v, $options[$v] );
			} elseif ( is_string( $t ) ) {
				$r = $wgRequest->getText( $v, $options[$v] );
			}
			wfAppendToArrayIfNotDefault( $v, $r, $defaults, $nondefaults );
		}

		$this->defaults    = $defaults;
		$this->nondefaults = $nondefaults;
		$this->options     = $nondefaults + $defaults;
	}

	/**
	 * The special page running code
	 * GLOBALS: $wgRequest, $wgOut, $wgUser, $wgLang
	 */
	public function execute( $parameters ) {
		global $wgUser, $wgOut, $wgRequest, $wgLang;
		wfLoadExtensionMessages( 'Translate' );

		$this->setup( $parameters );
		$this->setHeaders();

		$wgOut->addHTML( $this->getForm() );
		$wgOut->addWikitext( wfMsg( self::MSG . 'help' ) );

		if ( !$this->options['module'] ) { return; }
		$o = null;
		switch ( $this->options['module'] ) {
			case 'alias':
			case self::MODULE_SPECIAL:
				$o = new SpecialPageAliasesCM( $this->options['language'] );
				break;
			case self::MODULE_MAGIC:
				$o = new MagicWordsCM( $this->options['language'] );
				break;
			case self::MODULE_NAMESPACE:
				$o = new NamespaceCM( $this->options['language'] );
				break;

			default:
				return;
		}

		if ( $wgRequest->wasPosted() && $this->options['savetodb'] ) {
			if ( !$wgUser->isAllowed( 'translate' ) ) {
				$wgOut->permissionRequired( 'translate' );
				return;
			}

			$o->save( $wgRequest );
		}

		if ( $o instanceof ComplexMessages ) {
			if ( $this->options['export'] ) {
				$result = Xml::element( 'textarea', array( 'rows' => '30' ) , $o->export() );
			} else {
				$result = $o->output();
			}
		}

		$wgOut->addHTML( $result );
	}

}

abstract class ComplexMessages {
	const MSG = 'translate-magic-cm-';

	const LANG_MASTER   = 0;
	const LANG_CHAIN    = 1;
	const LANG_CURRENT  = 2;

	protected $language = null;
	protected $id       = '__BUG__';
	protected $variable = '__BUG__';
	protected $data     = null;
	protected $elementsInArray = true;
	protected $databaseMsg = '__BUG__';
	protected $chainable = false;
	protected $firstMagic = false;
	protected $constants = array();

	protected $tableAttributes = array(
		'class' => 'wikitable',
		'border' => '2',
		'cellpadding' => '4',
		'cellspacing' => '0',
		'style' => 'background-color: #F9F9F9; border: 1px #AAAAAA solid; border-collapse: collapse;',
	);

	public function __construct( $language ) {
		$this->language = $language;
	}

	public function getTitle() {
		return wfMsg( 'translate-magic-' . $this->id );
	}

	#
	# Data retrieval
	#

	protected $init = false;
	public function getGroups() {
		if ( !$this->init ) {
			foreach ( $this->data as &$group ) {
				$this->getData( $group );
			}
			$this->init = true;
		}

		return $this->data;
		
	}

	public function cleanData( $defs, $current ) {
		foreach ( $current as $item => $values ) {
			if ( !$this->elementsInArray ) break;
			if ( !isset( $defs[$item] ) ) {
				unset( $current[$item] );
				continue;
			}
			foreach ( $values as $index => $value )
				if ( in_array( $value, $defs[$item], true ) ) unset( $current[$item][$index] );
		}
		return $current;
	}

	public function mergeMagic( $defs, $current ) {
		foreach ( $current as $item => &$values ) {
			$newchain = $defs[$item];
			array_splice( $newchain, 1, 0, $values );
			$values = $newchain;

		}
		return $current;
	}


	public function getData( &$group ) {
		$defs = $this->readVariable( $group, 'en' );
		$code = $this->language;

		$current = wfArrayMerge( $this->readVariable( $group, $code ), $this->getSavedData() );

		// Clean up duplicates to definitions from saved data
		$current = $this->cleanData( $defs, $current );

		$chain = $current;
		while ( $this->chainable && $code = Language::getFallbackFor( $code ) ) {
			$fbdata = $this->readVariable( $group, $code );
			if ( $this->firstMagic ) $fbdata = $this->cleanData( $defs, $fbdata );
			$chain = array_merge_recursive( $chain, $fbdata );
		}


		if ( $this->firstMagic ) $chain = $this->mergeMagic( $defs, $chain );

		return $group['data'] = array( $defs, $chain, $current );
	}

	/**
	 * Gets saved data from Mediawiki namespace
	 * @return Array
	 */
	protected function getSavedData() {
		$data = TranslateUtils::getMessageContent( $this->databaseMsg, $this->language );

		if ( !$data ) {
			return array();
		}

		$lines = array_map( 'trim', explode( "\n", $data ) );
		$array = array();
		foreach ( $lines as $line ) {
			if ( $line === '' || $line[0] === '#' || $line[0] === '<' ) continue;
			if ( strpos( $line, '='  ) === false ) continue;

			list( $name, $values ) = array_map( 'trim', explode( '=', $line, 2 ) );
			if ( $name === '' || $values === '' ) continue;

			$data = array_map( 'trim', explode( ',', $values ) );
			$array[$name] = $data;

		}


		return $array;
	}

	/**
	 * Return an array of keys that can be used to iterate over all keys
	 * @return Array of keys for data
	 */
	protected function getIterator( $group ) {
		$groups = $this->getGroups();
		return array_keys( $groups[$group]['data'][self::LANG_MASTER] );
	}

	protected function val( $group, $type, $key ) {
		$array = $this->getGroups();
		$subarray = @$array[$group]['data'][$type][$key];
		if ( $this->elementsInArray ) {
			if ( !$subarray || !count( $subarray ) ) return array();
		} else {
			if ( !$subarray ) return array();
		}

		if ( !is_array( $subarray ) ) $subarray = array( $subarray );
		return $subarray;
	}

	/**
	 */
	protected function readVariable( $group, $code ) {
		$file = $group['file'];
		if ( !$group['code'] ) {
			$file = str_replace( '%CODE%', str_replace( '-', '_', ucfirst( $code ) ), $file );
		}

		$ { $group['var'] } = array(); # Initialize
		if ( file_exists( $file ) ) require( $file ); # Include

		if ( $group['code'] ) {
			$data = (array) @$ { $group['var'] } [$code];
		} else {
			$data = $ { $group['var'] } ;
		}

		return self::arrayMapRecursive( 'strval', $data );
	}

	public static function arrayMapRecursive( $callback, $data ) {
		foreach ( $data as $index => $values ) {
			if ( is_array( $values ) ) {
				$data[$index] = self::arrayMapRecursive( $callback, $values );
			} else {
				$data[$index] = call_user_func( $callback, $values );
			}
		}
		return $data;
	}

	#
	# /Data retrieval
	#

	#
	# Output
	#

	public function header( $title ) {
		$colspan = array( 'colspan' => 3 );
		$header = Xml::element( 'th', $colspan, $this->getTitle() . ' - ' . $title );
		$subheading[] = '<th>' . wfMsgHtml( 'translate-magic-cm-original' ) . '</th>';
		$subheading[] = '<th>' . wfMsgHtml( 'translate-magic-cm-current' ) . '</th>';
		$subheading[] = '<th>' . wfMsgHtml( 'translate-magic-cm-to-be' ) . '</th>';
		return '<tr>' . $header . '</tr>' .
			'<tr>' . implode( "\n", $subheading )  . '</tr>';
	}

	/**
	 * GLOBALS: $wgRequest
	 */
	public function output() {
		global $wgRequest;

		$colspan = array( 'colspan' => 3 );

		$s = Xml::openElement( 'table', $this->tableAttributes );

		foreach ( array_keys( $this->data ) as $group ) {
			$s .= $this->header( $group );
			
			foreach ( $this->getIterator( $group ) as $key ) {
				$rowContents = '';

				$value = $this->val( $group, self::LANG_MASTER, $key );
				if ( $this->firstMagic ) array_shift( $value );
				$value = array_map( 'htmlspecialchars', $value );
				$rowContents .= '<td>' . $this->formatElement( $value ) . '</td>';

				$value = $this->val( $group, self::LANG_CHAIN, $key );
				if ( $this->firstMagic ) array_shift( $value );
				$value = array_map( 'htmlspecialchars', $value );
				$value = $this->highlight( $key, $value );
				$rowContents .= '<td>' . $this->formatElement( $value ) . '</td>';

				$value = $this->val( $group, self::LANG_CURRENT, $key );
				$rowContents .= '<td>' . $this->editElement( $key, $this->formatElement( $value ) ) . '</td>';

				$s .= '<tr>' . $rowContents . '</tr>';
			}

		}

		global $wgUser;
		if ( $wgUser->isAllowed( 'translate' ) ) {
			$s .= '<tr>' . Xml::tags( 'td', $colspan, $this->getButtons() ) . '<tr>';
		}

		$s .= Xml::closeElement( 'table' );

		return Xml::tags( 'form',
			array( 'method' => 'post', 'action' => $wgRequest->getRequestURL() ),
			$s );
	}

	public function getButtons() {
		return
			Xml::inputLabel( wfMsg( self::MSG . 'comment' ), 'comment', 'sp-translate-magic-comment' ) .
			Xml::submitButton( wfMsg( self::MSG . 'save' ), array( 'name' => 'savetodb' ) );
	}

	public function formatElement( $element ) {
		if ( !count( $element ) ) return '';
		if ( is_array( $element ) ) {
			$element = array_map( 'trim', $element );
			$element = implode( ', ', $element );
		}
		return trim( $element );
	}

	function getKeyForEdit( $key ) {
		return Sanitizer::escapeId( 'sp-translate-magic-cm-' . $this->id . $key );
	}

	public function editElement( $key, $contents ) {
		return Xml::input( $this->getKeyForEdit( $key ), 40, $contents );
	}

	#
	# /Output
	#

	#
	# Save to database
	#

	function getKeyForSave() {
		return $this->databaseMsg . '/' . $this->language;
	}

	function formatForSave( $request ) {
		$text = '';
		foreach ( array_keys( $this->data ) as $group ) {
			foreach ( $this->getIterator( $group ) as $key ) {
				$data = $request->getText( $this->getKeyForEdit( $key ) );
				$data = implode( ', ', array_map( 'trim', explode( ',', $data ) ) );
				if ( $data !== '' )
					$text .= "$key = $data\n" ;
			}
		}
		return $text;
	}

	public function save( $request ) {
		$title = Title::newFromText( 'MediaWiki:' . $this->getKeyForSave() );
		$article = new Article( $title );

		$data = "# DO NOT EDIT THIS PAGE DIRECTLY! Use [[Special:Magic]].\n<pre>\n" . $this->formatForSave( $request ) . "\n</pre>";

		$comment = $request->getText( 'comment', wfMsgForContent( self::MSG . 'updatedusing' ) );
		$status = $article->doEdit( $data, $comment, 0 );

		if ( $status === false || ( is_object( $status ) && !$status->isOK() ) ) {
			throw new MWException( wfMsgHtml( self::MSG . 'savefailed' ) );
		}

		/* Reset outdated array */
		$this->init = false;

	}

	#
	# !Save to database
	#

	#
	# Export
	#

	public function export() {
		$groups = $this->getGroups();
		$text = '';

		foreach ( $groups as $group => $data ) {


			$var = $data['var'];
			$items = $data['data'];

			$extra = '';
			if ( $data['code'] ) {
				$extra = "['{$this->language}']";
			}

			$out = '';

			$indexKeys = array();
			foreach ( array_keys( $items[self::LANG_MASTER] ) as $key ) {
				$indexKeys[$key] = isset( $this->constants[$key] ) ? $this->constants[$key] : "'$key'";
			}

			$padTo = max( array_map( 'strlen', $indexKeys ) ) + 3;

			foreach ( $this->getIterator( $group ) as $key ) {
				$temp = "\t{$indexKeys[$key]}";

				while ( strlen( $temp ) <= $padTo ) { $temp .= ' '; }

				$from = self::LANG_CURRENT;
				if ( $this->firstMagic && !$data['code'] ) $from = self::LANG_CHAIN;

				// Check for translations
				$val = $this->val( $group, self::LANG_CURRENT, $key );
				if ( !$val || !count( $val ) ) continue;

				// Then get the data we really want
				$val = $this->val( $group, $from, $key );

				$normalized = array_map( array( $this, 'normalize' ), $val );
				if ( $this->elementsInArray ) {
					$temp .= "=> array( " . implode( ', ', $normalized ) . " ),";
				} else {
					$temp .= "=> " . implode( ', ', $normalized ) . ",";
				}
				$out .= $temp . "\n";
			}

			if ( $out !== '' ) {
				$text .= "# $group \n";
				$text .= "\$$var$extra = array(\n" . $out . ");\n\n";
			}

		}

		return $text;
	}

	/**
	 * Returns string with quotes that should be valid php
	 */
	protected function normalize( $data ) {
		# Escape quotes
		if ( !is_string( $data ) ) {
			throw new MWException();
		}
		$data = preg_replace( "/(?<!\\\\)'/", "\'", trim( $data ) );
		return "'$data'";
	}

	#
	# /Export
	#

	public function highlight( $key, $values ) {
		return $values;
	}

}

class SpecialPageAliasesCM extends ComplexMessages {
	protected $id = SpecialMagic::MODULE_SPECIAL;
	protected $databaseMsg = 'sp-translate-data-SpecialPageAliases';
	protected $chainable = true;

	public function __construct( $code ) {
		parent::__construct( $code );
		$this->data['Mediawiki Core'] = array(
			'var' => 'specialPageAliases',
			'file' => Language::getMessagesFileName( '%CODE%' ),
			'code' => false,
		);

		global $wgTranslateExtensionDirectory;

		if ( !file_exists( TRANSLATE_ALIASFILE ) || !is_readable( TRANSLATE_ALIASFILE ) )
			return;

		$defines = file_get_contents( TRANSLATE_ALIASFILE );
		$sections = preg_split( "/\n\n/", $defines, - 1, PREG_SPLIT_NO_EMPTY );

		foreach ( $sections as $section ) {
			$lines = array_map( 'trim', preg_split( "/\n/", $section ) );
			$name = '';
			foreach ( $lines as $line ) {
				if ( $line === '' ) continue;
				if ( strpos( $line, '=' ) === false ) {
					if ( $name === '' ) {
						$name = $line;
					} else {
						throw new MWException( "Trying to define name twice: " . $line );
					}
				} else {
					list( $key, $value ) = array_map( 'trim', explode( '=', $line, 2 ) );
					if ( $key === 'file' ) $file = $value;
				}
			}

			if ( $name !== '' ) {
				$this->data[$name] = array(
					'var' => 'aliases',
					'file' => $wgTranslateExtensionDirectory . '/' . $file,
					'code' => true,
				);
			}
		}
	}

	public function highlight( $key, $values ) {
		if ( count( $values ) ) $values[0] = "<b>$values[0]</b>";
		return $values;
	}

}

class MagicWordsCM extends ComplexMessages {
	protected $id = SpecialMagic::MODULE_MAGIC;
	protected $firstMagic = true;
	protected $chainable = true;
	protected $databaseMsg = 'sp-translate-data-MagicWords';

	public function __construct( $code ) {
		parent::__construct( $code );
		$this->data['Mediawiki Core'] = array(
			'var' => 'magicWords',
			'file' => Language::getMessagesFileName( '%CODE%' ),
			'code' => false,
		);
	}

	public function highlight( $key, $values ) {
		if ( count( $values ) && $key === 'redirect' ) $values[0] = "<b>$values[0]</b>";
		return $values;
	}

}

class NamespaceCM extends ComplexMessages {
	protected $id = SpecialMagic::MODULE_NAMESPACE;
	protected $elementsInArray = false;
	protected $databaseMsg = 'sp-translate-data-Namespaces';

	public function __construct( $code ) {
		parent::__construct( $code );
		$this->data['Mediawiki Core'] = array(
			'var' => 'namespaceNames',
			'file' => Language::getMessagesFileName( '%CODE%' ),
			'code' => false,
		);
	}

	protected $constants = array(
		- 2 => 'NS_MEDIA',
		- 1 => 'NS_SPECIAL',
		 0 => 'NS_MAIN',
		 1 => 'NS_TALK',
		 2 => 'NS_USER',
		 3 => 'NS_USER_TALK',
		 4 => 'NS_PROJECT',
		 5 => 'NS_PROJECT_TALK',
		 6 => 'NS_FILE',
		 7 => 'NS_FILE_TALK',
		 8 => 'NS_MEDIAWIKI',
		 9 => 'NS_MEDIAWIKI_TALK',
		10 => 'NS_TEMPLATE',
		11 => 'NS_TEMPLATE_TALK',
		12 => 'NS_HELP',
		13 => 'NS_HELP_TALK',
		14 => 'NS_CATEGORY',
		15 => 'NS_CATEGORY_TALK',
	);

}
