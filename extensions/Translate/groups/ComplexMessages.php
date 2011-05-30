<?php
/**
 * Classes for complex messages (%MediaWiki special page aliases, namespace names, magic words).
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2008-2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Base class which implements handling and translation interface of
 * non-message %MediaWiki items.
 * @todo Needs documentation.
 */
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
			$saved = $this->getSavedData();
			foreach ( $this->data as &$group ) {
				$this->getData( $group, $saved );
			}
			$this->init = true;
		}

		return $this->data;

	}

	public function cleanData( $defs, $current ) {
		foreach ( $current as $item => $values ) {
			if ( !$this->elementsInArray ) {
				break;
			}

			if ( !isset( $defs[$item] ) ) {
				unset( $current[$item] );
				continue;
			}

			foreach ( $values as $index => $value )
				if ( in_array( $value, $defs[$item], true ) ) {
					unset( $current[$item][$index] );
				}
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

	public function getData( &$group, $savedData ) {
		$defs = $this->readVariable( $group, 'en' );
		$code = $this->language;

		$current = wfArrayMerge( $this->readVariable( $group, $code ), $savedData );

		// Clean up duplicates to definitions from saved data
		$current = $this->cleanData( $defs, $current );

		$chain = $current;
		while ( $this->chainable && $code = Language::getFallbackFor( $code ) ) {
			$fbdata = $this->readVariable( $group, $code );
			if ( $this->firstMagic ) {
				$fbdata = $this->cleanData( $defs, $fbdata );
			}

			$chain = array_merge_recursive( $chain, $fbdata );
		}

		if ( $this->firstMagic ) {
			$chain = $this->mergeMagic( $defs, $chain );
		}

		$data = $group['data'] = array( $defs, $chain, $current );

		return $data;
	}

	/**
	 * Gets data from request. Needs to be run before the form is displayed and
	 * validation. Not needed for export, which uses request directly.
	 */
	public function loadFromRequest( WebRequest $request ) {
		$saved = $this->parse( $this->formatForSave( $request ) );
		foreach ( $this->data as &$group ) {
			$this->getData( $group, $saved );
		}
	}

	/**
	 * Gets saved data from Mediawiki namespace
	 * @return Array
	 */
	protected function getSavedData() {
		$data = TranslateUtils::getMessageContent( $this->databaseMsg, $this->language );

		if ( !$data ) {
			return array();
		} else {
			return $this->parse( $data );
		}
	}

	protected function parse( $data ) {
		$lines = array_map( 'trim', explode( "\n", $data ) );
		$array = array();
		foreach ( $lines as $line ) {
			if ( $line === '' || $line[0] === '#' || $line[0] === '<' ) {
				continue;
			}

			if ( strpos( $line, '='  ) === false ) {
				continue;
			}

			list( $name, $values ) = array_map( 'trim', explode( '=', $line, 2 ) );
			if ( $name === '' || $values === '' ) {
				continue;
			}

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
			if ( !$subarray || !count( $subarray ) ) {
				return array();
			}
		} else {
			if ( !$subarray ) {
				return array();
			}
		}

		if ( !is_array( $subarray ) ) {
			$subarray = array( $subarray );
		}

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
		if ( file_exists( $file ) ) {
			require( $file ); # Include
		}

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

	public function output() {
		global $wgRequest;

		$colspan = array( 'colspan' => 3 );

		$s = Xml::openElement( 'table', $this->tableAttributes );

		foreach ( array_keys( $this->data ) as $group ) {
			$s .= $this->header( $this->data[$group]['label'] );

			foreach ( $this->getIterator( $group ) as $key ) {
				$rowContents = '';

				$value = $this->val( $group, self::LANG_MASTER, $key );
				if ( $this->firstMagic ) {
					array_shift( $value );
				}

				$value = array_map( 'htmlspecialchars', $value );
				$rowContents .= '<td>' . $this->formatElement( $value ) . '</td>';

				$value = $this->val( $group, self::LANG_CHAIN, $key );
				if ( $this->firstMagic ) {
					array_shift( $value );
				}

				$value = array_map( 'htmlspecialchars', $value );
				$value = $this->highlight( $key, $value );
				$rowContents .= '<td>' . $this->formatElement( $value ) . '</td>';

				$value = $this->val( $group, self::LANG_CURRENT, $key );
				$rowContents .= '<td>' . $this->editElement( $key, $this->formatElement( $value ) ) . '</td>';

				$s .= Xml::tags( 'tr', array( 'id' => "mw-sp-magic-$key" ), $rowContents );
			}
		}

		global $wgUser;
		if ( $wgUser->isAllowed( 'translate' ) ) {
			$s .= '<tr>' . Xml::tags( 'td', $colspan, $this->getButtons() ) . '<tr>';
		}

		$s .= Xml::closeElement( 'table' );

		return Xml::tags(
			'form',
			array( 'method' => 'post', 'action' => $wgRequest->getRequestURL() ),
			$s
		);
	}

	public function getButtons() {
		return
			Xml::inputLabel( wfMsg( self::MSG . 'comment' ), 'comment', 'sp-translate-magic-comment' ) .
			Xml::submitButton( wfMsg( self::MSG . 'save' ), array( 'name' => 'savetodb' ) );
	}

	public function formatElement( $element ) {
		if ( !count( $element ) ) {
			return '';
		}

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
				// Make a nice array out of the submit with trimmed values.
				$data = array_map( 'trim', explode( ',', $data ) );
				// Normalise: Replace spaces with underscores.
				$data = str_replace( ' ', '_', $data );
				// Create final format.
				$data = implode( ', ', $data );
				if ( $data !== '' ) {
					$text .= "$key = $data\n" ;
				}
			}
		}
		return $text;
	}

	public function save( $request ) {
		$title = Title::newFromText( 'MediaWiki:' . $this->getKeyForSave() );
		$article = new Article( $title );

		$data = "# DO NOT EDIT THIS PAGE DIRECTLY! Use [[Special:AdvancedTranslate]].\n<pre>\n" . $this->formatForSave( $request ) . "\n</pre>";

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
	public function validate( &$errors = array(), $filter = false ) {
		$used = array();
		foreach ( array_keys( $this->data ) as $group ) {
			if (  $filter !== false && !in_array( $group, (array) $filter, true ) ) {
				continue;
			}

			$this->validateEach( $errors, $group, $used );
		}
	}

	protected function validateEach( &$errors = array(), $group, &$used ) {
		foreach ( $this->getIterator( $group ) as $key ) {
			$values = $this->val( $group, self::LANG_CURRENT, $key );
			$link = Xml::element( 'a', array( 'href' => "#mw-sp-magic-$key" ), $key );

			if ( count( $values ) !== count( array_filter( $values ) ) ) {
				$errors[] = "There is empty value in $link.";
			}

			foreach ( $values as $v ) {
				if ( isset( $used[$v] ) ) {
					$otherkey = $used[$v];
					$first = Xml::element( 'a', array( 'href' => "#mw-sp-magic-$otherkey" ), $otherkey );
					$errors[] = "Translation <b>$v</b> is used more than once for $first and $link.";
				} else {
					$used[$v] = $key;
				}
			}
		}
	}

	public function export( $filter = false ) {
		$text = '';
		$errors = array();
		$this->validate( $errors, $filter );
		foreach ( $errors as $_ ) $text .= "#!!# $_\n";

		foreach ( $this->getGroups() as $group => $data ) {
			if (  $filter !== false && !in_array( $group, (array) $filter, true ) ) {
				continue;
			}

			$text .= $this->exportEach( $group, $data );
		}

		return $text;
	}

	protected function exportEach( $group, $data ) {
		$var = $data['var'];
		$items = $data['data'];

		$extra = $data['code'] ? "['{$this->language}']" : '';

		$out = '';

		$indexKeys = array();
		foreach ( array_keys( $items[self::LANG_MASTER] ) as $key ) {
			$indexKeys[$key] = isset( $this->constants[$key] ) ? $this->constants[$key] : "'$key'";
		}

		$padTo = max( array_map( 'strlen', $indexKeys ) ) + 3;

		foreach ( $this->getIterator( $group ) as $key ) {
			$temp = "\t{$indexKeys[$key]}";

			while ( strlen( $temp ) <= $padTo ) {
				$temp .= ' ';
			}

			$from = self::LANG_CURRENT;
			// Abuse of the firstMagic property, should use something proper
			if ( $this->firstMagic ) {
				$from = self::LANG_CHAIN;
			}

			// Check for translations
			$val = $this->val( $group, self::LANG_CURRENT, $key );
			if ( !$val || !count( $val ) ) {
				continue;
			}

			// Then get the data we really want
			$val = $this->val( $group, $from, $key );

			// Remove duplicated entries, causes problems with magic words
			// Just to be sure, it should not be possible to save invalid data anymore
			$val = array_unique( $val /* @todo SORT_REGULAR */ );

			// So do empty elements...
			foreach ( $val as $k => $v ) {
				if ( $v === '' ) {
					unset( $val[$k] );
				}
			}

			// Another check
			if ( !count( $val ) ) {
				continue;
			}

			$normalized = array_map( array( $this, 'normalize' ), $val );
			if ( $this->elementsInArray ) {
				$temp .= "=> array( " . implode( ', ', $normalized ) . " ),";
			} else {
				$temp .= "=> " . implode( ', ', $normalized ) . ",";
			}
			$out .= $temp . "\n";
		}

		if ( $out !== '' ) {
			$text = "# {$data['label']} \n";
			$text .= "\$$var$extra = array(\n" . $out . ");\n\n";
			return $text;
		} else {
			return '';
		}
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

/**
 * Adds support for translating special page aliases via Special:AdvancedTranslate.
 * @todo Needs documentation.
 */
class SpecialPageAliasesCM extends ComplexMessages {
	protected $id = SpecialMagic::MODULE_SPECIAL;
	protected $databaseMsg = 'sp-translate-data-SpecialPageAliases';
	protected $chainable = true;


	public function __construct( $code ) {
		parent::__construct( $code );
		$this->data['core'] = array(
			'label' => 'MediaWiki Core',
			'var' => 'specialPageAliases',
			'file' => Language::getMessagesFileName( '%CODE%' ),
			'code' => false,
		);

		global $wgTranslateExtensionDirectory;
		$groups = MessageGroups::singleton()->getGroups();
		foreach ( $groups as $g ) {
			if ( !$g instanceof ExtensionMessageGroup ) {
				continue;
			}

			$file = $g->getAliasFile();
			if ( $file === null ) {
				continue;
			}

			$file = "$wgTranslateExtensionDirectory/$file";
			if ( file_exists( $file ) ) {
				$this->data[$g->getId()] = array(
					'label' => $g->getLabel(),
					'var'  => $g->getVariableNameAlias(),
					'file' => $file,
					'code' => $code,
				);
			}
		}
	}

	public function highlight( $key, $values ) {
		if ( count( $values ) ) {
			if ( !isset( $values[0] ) ) {
				throw new MWException( "Something missing from values: " .  print_r( $values, true ) );
			}

			$values[0] = "<b>$values[0]</b>";
		}
		return $values;
	}

	protected function validateEach( &$errors = array(), $group, &$used ) {
		parent::validateEach( $errors, $group, $used );
		foreach ( $this->getIterator( $group ) as $key ) {
			$values = $this->val( $group, self::LANG_CURRENT, $key );

			foreach ( $values as $_ ) {
				wfSuppressWarnings();
				$title = SpecialPage::getTitleFor( $_ );
				wfRestoreWarnings();
				$link = Xml::element( 'a', array( 'href' => "#mw-sp-magic-$key" ), $key );
				if ( $title === null ) {
					if ( $_ !== '' ) {
						// Empty values checked elsewhere
						$errors[] = "Translation <b>$_</b> is invalid title in $link.";
					}
				} else {
					$text = $title->getText();
					$dbkey = $title->getDBkey();
					if ( $text !== $_ && $dbkey !== $_ ) {
						$errors[] = "Translation <b>$_</b> for $link is not in normalised form, which is <b>$text</b>";
					}
				}
			}
		}
	}
}

/**
 * Adds support for translating magic words via Special:AdvancedTranslate.
 * @todo Needs documentation.
 */
class MagicWordsCM extends ComplexMessages {
	protected $id = SpecialMagic::MODULE_MAGIC;
	protected $firstMagic = true;
	protected $chainable = true;
	protected $databaseMsg = 'sp-translate-data-MagicWords';

	public function __construct( $code ) {
		parent::__construct( $code );
		$this->data['core'] = array(
			'label' => 'MediaWiki Core',
			'var' => 'magicWords',
			'file' => Language::getMessagesFileName( '%CODE%' ),
			'code' => false,
		);

		global $wgTranslateExtensionDirectory;
		$groups = MessageGroups::singleton()->getGroups();
		foreach ( $groups as $g ) {
			if ( !$g instanceof ExtensionMessageGroup ) {
				continue;
			}

			$file = $g->getMagicFile();
			if ( $file === null ) {
				continue;
			}

			$file = "$wgTranslateExtensionDirectory/$file";
			if ( file_exists( $file ) ) {
				$this->data[$g->getId()] = array(
					'label' => $g->getLabel(),
					'var'  => 'magicWords',
					'file' => $file,
					'code' => $code,
				);
			}
		}
	}

	public function highlight( $key, $values ) {
		if ( count( $values ) && $key === 'redirect' ) {
			$values[0] = "<b>$values[0]</b>";
		}

		return $values;
	}
}

/**
 * Adds support for translating namespace names via Special:AdvancedTranslate.
 * @todo Needs documentation.
 */
class NamespaceCM extends ComplexMessages {
	protected $id = SpecialMagic::MODULE_NAMESPACE;
	protected $elementsInArray = false;
	protected $databaseMsg = 'sp-translate-data-Namespaces';

	public function __construct( $code ) {
		parent::__construct( $code );
		$this->data['core'] = array(
			'label' => 'MediaWiki Core',
			'var'  => 'namespaceNames',
			'file' => Language::getMessagesFileName( '%CODE%' ),
			'code' => false,
		);
	}

	protected $constants = array(
		-2 => 'NS_MEDIA',
		-1 => 'NS_SPECIAL',
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

	protected function validateEach( &$errors = array(), $group, &$used ) {
		parent::validateEach( $errors, $group, $used );
		foreach ( $this->getIterator( $group ) as $key ) {
			$values = $this->val( $group, self::LANG_CURRENT, $key );

			if ( count( $values ) > 1 ) {
				$link = Xml::element( 'a', array( 'href' => "#mw-sp-magic-$key" ), $key );
				$errors[] = "Namespace $link can have only one translation. Replace the translation with a new one, and notify staff about the change.";
			}
		}
	}
}
