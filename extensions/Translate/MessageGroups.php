<?php

abstract class MessageGroup {
	/**
	 * Human-readable name of this group
	 */
	protected $label  = 'none';
	public function getLabel() { return $this->label; }
	public function setLabel( $value ) { $this->label = $value; }

	/**
	 * Group-wide unique id of this group. Used also for sorting.
	 */
	protected $id     = 'none';
	public function getId() { return $this->id; }
	public function setId( $value ) { $this->id = $value; }

	/**
	 * List of messages that are hidden by default, but can still be translated if
	 * needed.
	 */
	protected $optional = array();
	public function getOptional() { return $this->optional; }
	public function setOptional( $value ) { $this->optional = $value; }

	/**
	 * List of messages that are always hidden and cannot be translated.
	 */
	protected $ignored = array();
	public function getIgnored() { return $this->ignored; }
	public function setIgnored( $value ) { $this->ignored = $value; }

	protected $problematic = null;
	public function getProblematic( $code ) {
		if ( $this->problematic === null ) {
			$this->problematic = array();
			$file = TRANSLATE_CHECKFILE . '-' . $this->id;
			if ( file_exists( $file ) ) {
				$problematic = unserialize( file_get_contents( $file ) );
				if ( isset( $problematic[$code] ) ) {
					$this->problematic = $problematic[$code];
				}
			}
		}
		return $this->problematic;
	}

	public function setProblematic( $value ) { $this->problematic = $value ; }
	/**
	 * Returns a list of optional and ignored messages in 2-d array.
	 */
	public function getBools() {
		return array(
			'optional' => $this->optional,
			'ignored' => $this->ignored,
		);
	}

	/**
	 * Holds descripton of this group. Description is a wiki text snippet that
	 * gives information about this group to translators.
	 */
	protected $description = null;
	public function getDescription() { return $this->description; }
	public function setDescription( $value ) { $this->description = $value; }

	/**
	 * Meta groups consist of multiple groups or parts of other groups. This info
	 * is used on many places, like when creating message index.
	 */
	protected $meta = false;
	public function isMeta() { return $this->meta; }
	public function setMeta( $value ) { $this->meta = $value; }

	/**
	 * To avoid key conflicts between groups or separated changed messages between
	 * brances one can set a message key mangler.
	 */
	protected $mangler = null;
	public function getMangler() { return $this->mangler; }
	public function setMangler( $value ) { $this->mangler = $value; }

	protected $type = 'undefined';
	public function getType() { return $this->type; }
	public function setType( $value ) { $this->type = $value; }


	public $namespaces = array( NS_MEDIAWIKI, NS_MEDIAWIKI_TALK );

	public function getReader( $code ) {
		return null;
	}

	public function getWriter() {
		return new SimpleFormatWriter( $this );
	}

	public function load( $code ) {
		$reader = $this->getReader( $code );
		if ( $reader ) {
			return $reader->parseMessages( $this->mangler );
		}
	}

	/**
	 * This function returns array of type key => definition of all messages
	 * this message group handles.
	 *
	 * @return Array of messages definitions indexed by key.
	 */
	public function getDefinitions() {
		$defs = $this->load( 'en' );
		if ( !is_array( $defs ) ) {
			throw new MWException( "Unable to load definitions for " . $this->getLabel() );
		}
		return $defs;
	}

	/**
	 * This function can be used for meta message groups to list their "own"
	 * messages. For example branched message groups can exclude the messages they
	 * share with each other.
	 */
	public function getUniqueDefinitions() {
		return $this->meta ? array() : $this->getDefinitions();
	}

	/**
	 * Returns of stored translation of message specified by the $key in language
	 * code $code.
	 *
	 * @param $key Key of the message.
	 * @param $code Language code.
	 * @return Stored translation or null.
	 */
	public function getMessage( $key, $code ) {
		if ( !isset( $this->messages[$code] ) ) {
			$this->messages[$code] = self::normaliseKeys( $this->load( $code ) );
		}
		$key = strtolower( str_replace( ' ', '_', $key ) );
		return isset( $this->messages[$code][$key] ) ? $this->messages[$code][$key] : null;
	}

	public static function normaliseKeys( $array ) {
		if ( !is_array( $array ) ) return null;
		$new = array();
		foreach ( $array as $key => $v ) {
			$key = strtolower( str_replace( ' ', '_', $key ) );
			$new[$key] = $v;
		}
		return $new;
	}

	/**
	 * All the messages for this group, by language code.
	 */
	private $messages = array();

	/**
	 * In this function message group should add translations from the stored file
	 * for language code $code and it's fallback language, if used.
	 *
	 * @param $messages MessageCollection
	 */
	function fill( MessageCollection $messages ) {
		$cache = $this->load( $messages->code );
		foreach ( $messages->keys() as $key ) {
			if ( isset( $cache[$key] ) ) {
				$messages[$key]->infile = $cache[$key];
			}
		}
	}

	/**
	 * Returns path to the file where translation of language code $code are.
	 *
	 * @return Path to the file or false if not applicable.
	 */
	public function getMessageFile( $code ) { return false; }
	public function getPath() { return false; }
	public function getMessageFileWithPath( $code ) {
		$path = $this->getPath();
		$file = $this->getMessageFile( $code );
		if ( !$path || !$file ) return false;
		return "$path/$file";
	}


	/**
	 * Creates a new MessageCollection for this group.
	 *
	 * @param $code The langauge code for this collection.
	 * @param $unique Bool: wether to build collection for messages unique to this
	 *                group only.
	 */
	public function initCollection( $code, $unique = false ) {
		$collection = new MessageCollection( $code );

		if ( !$unique ) {
			$definitions = $this->getDefinitions();
		} else {
			$definitions = $this->getUniqueDefinitions();
		}

		foreach ( $definitions as $key => $definition ) {
			$collection->add( new TMessage( $key, $definition ) );
		}

		$bools = $this->getBools();
		foreach ( $bools['optional'] as $key ) {
			if ( isset( $collection[$key] ) ) {
				$collection[$key]->optional = true;
			}
		}

		foreach ( $bools['ignored'] as $key ) {
			if ( isset( $collection[$key] ) ) {
				unset( $collection[$key] );
			}
		}

		return $collection;
	}

	public function fillCollection( MessageCollection $collection ) {
		TranslateUtils::fillContents( $collection, $this->namespaces );
		$this->fill( $collection );
	}

	public function __construct() {
		$this->mangler = StringMatcher::emptyMatcher();
	}

	public static function factory( $label, $id ) {
		return null;
	}
}

class CoreMessageGroup extends MessageGroup {
	protected $label = 'MediaWiki messages';
	protected $id    = 'core';
	protected $type  = 'mediawiki';

	public function __construct() {
		parent::__construct();
		global $IP;
		$this->prefix = $IP . '/languages/messages';
		$this->metaDataPrefix = $IP . '/maintenance/language';
	}

	protected $prefix = '';
	public function getPrefix() { return $this->prefix; }
	public function setPrefix( $value ) { $this->prefix = $value; }

	protected $metaDataPrefix = '';
	public function getMetaDataPrefix() { return $this->metaDataPrefix; }
	public function setMetaDataPrefix( $value ) { $this->metaDataPrefix = $value; }

	public $parentId = null;

	public static function factory( $label, $id ) {
		$group = new CoreMessageGroup;
		$group->setLabel( $label );
		$group->setId( $id );
		return $group;
	}

	public function getUniqueDefinitions() {
		if ( $this->parentId ) {
			$parent = MessageGroups::getGroup( $this->parentId );
			$parentDefs = $parent->getDefinitions();
			$ourDefs = $this->getDefinitions();

			// Filter out shared messages
			foreach ( array_keys( $parentDefs ) as $key ) {
				unset( $ourDefs[$key] );
			}

			return $ourDefs;
		}
		return $this->getDefinitions();
	}

	public function getMessageFile( $code ) {
		$code = ucfirst( str_replace( '-', '_', $code ) );
		return "Messages$code.php";
	}

	public function getPath() {
		return $this->prefix;
	}

	public function getReader( $code ) {
		return new WikiFormatReader( $this->getMessageFileWithPath( $code ) );
	}

	public function getWriter() {
		return new WikiFormatWriter( $this );
	}

	public function getBools() {
		require( $this->getMetaDataPrefix() . '/messageTypes.inc' );
		return array(
			'optional' => $this->mangler->mangle( $wgOptionalMessages ),
			'ignored'  => $this->mangler->mangle( $wgIgnoredMessages ),
		);
	}

	public function load( $code ) {
		$file = $this->getMessageFileWithPath( $code );
		// Can return null, convert to array
		$messages = (array) $this->mangler->mangle(
			ResourceLoader::loadVariableFromPHPFile( $file, 'messages' ) );
		if ( $this->parentId ) {
			if ( $code !== 'en' ) {
				// For branches, load newer compatible messages for missing entries, if any
				$trunk = MessageGroups::getGroup( $this->parentId );
				$messages += $trunk->mangler->unmangle( $trunk->load( $code ) );
			}
		}

		return $messages;
	}
}

class ExtensionMessageGroup extends MessageGroup {
	/**
	 * Name of the array where all messages are stored, if applicable.
	 */
	protected $arrName      = 'messages';
	public function getVariableName() { return $this->arrName; }
	public function setVariableName( $value ) { $this->arrName = $value; }

	/**
	 * Path to the file where array or function is defined, relative to extensions
	 * root directory defined by $wgTranslateExtensionDirectory.
	 */
	protected $messageFile  = null;
	public function getMessageFile( $code ) { return $this->messageFile; }
	public function setMessageFile( $value ) { $this->messageFile = $value; }

	public function getMessageFilePath( $code ) {
		return $wgTranslateExtensionDirectory;
	}

	public function setDescriptionMsg( $key ) {
		global $wgLang;

		$desc = $this->getMessage( $key, $wgLang->getCode() );
		if ( $desc === null )
			$desc = $this->getMessage( $key, 'en' );
		if ( $desc !== null )
			$this->description = $desc;
	}

	public static function factory( $label, $id ) {
		$group = new ExtensionMessageGroup;
		$group->setLabel( $label );
		$group->setId( $id );
		return $group;
	}

	/**
	 * This function loads messages for given language for further use.
	 *
	 * @param $code Language code
	 * @throws MWException If loading fails.
	 */
	public function load( $code ) {
		$reader = $this->getReader( $code );
		$cache = $reader->parseMessages( $this->mangler );
		if ( $cache === null ) {
			throw new MWException( "Unable to load messages for $code in {$this->label}" );
		}
		if ( isset( $cache[$code] ) ) {
			return $cache[$code];
		} else {
			return null;
		}
	}

	public function getPath() {
		global $wgTranslateExtensionDirectory;
		return $wgTranslateExtensionDirectory;
	}

	public function getReader( $code ) {
		$reader = new WikiExtensionFormatReader( $this->getMessageFileWithPath( $code ) );
		$reader->variableName = $this->getVariableName();
		return $reader;
	}

	public function getWriter() {
		$writer = new WikiExtensionFormatWriter( $this );
		$writer->variableName = $this->getVariableName();
		return $writer;
	}
}

class AliasMessageGroup extends ExtensionMessageGroup {

	public function fillCollection( MessageCollection $collection ) {
		$this->fill( $collection );
		$this->fillContents( $collection );
	}


	function fill( MessageCollection $messages ) {
		$cache = $this->load( $messages->code );
		foreach ( $messages->keys() as $key ) {
			if ( isset( $cache[$key] ) ) {
				if ( is_array( $cache[$key] ) ) {
					$messages[$key]->infile = implode( ',', $cache[$key] );
				} else {
					$messages[$key]->infile = $cache[$key];
				}
			}
		}
	}

	public function fillContents( MessageCollection $collection ) {
		$data = TranslateUtils::getMessageContent( 'sp-translate-data-SpecialPageAliases', $collection->code );

		if ( !$data ) return;

		$lines = array_map( 'trim', explode( "\n", $data ) );
		$array = array();
		foreach ( $lines as $line ) {
			if ( $line === '' || $line[0] === '#' || $line[0] === '<' ) continue;
			if ( strpos( $line, '='  ) === false ) continue;

			list( $name, $values ) = array_map( 'trim', explode( '=', $line, 2 ) );
			if ( $name === '' || $values === '' ) continue;

			if ( isset( $collection[$name] ) ) {
				$collection[$name]->database = $values;
			}
		}

	}

	public function getWriter() {
		$writer = new WikiExtensionFormatWriter( $this );
		$writer->variableName = $this->getVariableName();
		$writer->commaToArray = true;
		return $writer;
	}

}

class CoreMostUsedMessageGroup extends CoreMessageGroup {
	protected $label = 'MediaWiki messages (most used)';
	protected $id    = 'core-mostused';
	protected $meta  = true;

	protected $description = 'This is a list of about 500 most often displayed messages. The list has been build from data gathered from a profiling run on all Wikimedia wikis.';

	public function export( MessageCollection $messages ) { return 'Not supported'; }
	public function exportToFile( MessageCollection $messages, $authors ) { return 'Not supported'; }

	function getDefinitions() {
		$data = file_get_contents( dirname( __FILE__ ) . '/wikimedia-mostused-2009.txt' );
		$messages = explode( "\n", $data );
		$contents = Language::getMessagesFor( 'en' );
		$definitions = array();
		foreach ( $messages as $key ) {
			if ( isset( $contents[$key] ) ) {
				$definitions[$key] = $contents[$key];
			}
		}
		return $definitions;
	}
}

class GettextMessageGroup extends MessageGroup {
	protected $type = 'gettext';
	/**
	 * Name of the array where all messages are stored, if applicable.
	 */
	protected $potFile      = 'messages';
	public function getPotFile() { return $this->potFile; }
	public function setPotFile( $value ) { $this->potFile = $value; }

	protected $codeMap = array();

	protected $path = '';
	public function getPath() { return $this->path; }
	public function setPath( $value ) { $this->path = $value; }

	protected $prefix = '';
	public function getPrefix() { return $this->prefix; }
	public function setPrefix( $value ) { $this->prefix = $value; }

	public $filePattern = '%CODE%.po';

	public function getMessageFile( $code ) {
		if ( $code == 'en' ) {
			return $this->getPotFile();
		} else {
			if ( isset( $this->codeMap[$code] ) ) {
				$code = $this->codeMap[$code];
			}
			return $this->replaceVariables( $this->filePattern, $code );
		}
	}

	public function replaceVariables( $string, $code ) {
		return str_replace( '%CODE%', $code, $string );
	}

	public static function factory( $label, $id ) {
		$group = new GettextMessageGroup;
		$group->setLabel( $label );
		$group->setId( $id );
		return $group;
	}


	public function getReader( $code ) {
		$reader = new GettextFormatReader( $this->getMessageFileWithPath( $code ) );
		$reader->setPrefix( $this->prefix );
		if ( $code === 'en' )
			$reader->setPotMode( true );
		return $reader;
	}

	public function getWriter() {
		return new GettextFormatWriter( $this );
	}
}

class WikiMessageGroup extends MessageGroup {
	protected $source = null;

	/**
	 * Constructor.
	 *
	 * @param $id Unique id for this group.
	 * @param $source Mediawiki message that contains list of message keys.
	 */
	public function __construct( $id, $source ) {
		parent::__construct();
		$this->id = $id;
		$this->source = $source;
	}

	public function fill( MessageCollection $messages ) {
		return; // no-op
	}

	/* Fetch definitions from database */
	public function getDefinitions() {
		$definitions = array();
		/* In theory could have templates that are substitued */
		$contents = wfMsg( $this->source );
		$messages = preg_split( '/\s+/', $contents );
		foreach ( $messages as $message ) {
			if ( !$message ) continue;
			$definitions[$message] = wfMsgForContentNoTrans( $message );
		}
		return $definitions;
	}

	/**
	 * Returns of stored translation of message specified by the $key in language
	 * code $code.
	 *
	 * @param $key Key of the message.
	 * @param $code Language code.
	 * @return Stored translation or null.
	 */
	public function getMessage( $key, $code ) {
		global $wgContLang;
		$params = array();
		if ( $code && $wgContLang->getCode() !== $code ) {
			$key = "$key/$code";
		} else {
			$params[] = 'content';
		}
		$message = wfMsgExt( $key, $params );
		return wfEmptyMsg( $key, $message ) ? null : $message;
	}
}


class WikiPageMessageGroup extends WikiMessageGroup {
	public $title;

	public function __construct( $id, $source ) {
		$this->id = $id;
		$title = Title::newFromText( $source );
		if ( !$title ) {
			throw new MWException( 'Invalid title' );
		}
		$this->title = $title;
		$this->namespaces = array( $title->getNamespace(), $title->getNamespace() + 1 );
		
	}

	public function getDefinitions() {
		return TranslateTag::parseSectionDefinitions( $this->title, $this->namespaces );
	}

	public function load( $code ) {
		if ( $code === 'en' ) return $this->getDefinitions();
	}

	/**
	 * Returns of stored translation of message specified by the $key in language
	 * code $code.
	 *
	 * @param $key Key of the message.
	 * @param $code Language code.
	 * @return Stored translation or null.
	 */
	public function getMessage( $key, $code ) {
		if ( $code === 'en' ) {
			$stuff = $this->load( 'en' );
			return $stuff[$key];
		}
		$title = Title::makeTitleSafe( $this->namespaces[0], "$key/$code" );
		$rev = Revision::newFromTitle( $title );
		if ( !$rev ) return null;
		return $rev->getText();
	}

}


class MessageGroups {
	public static function init() {
		static $loaded = false;
		if ( $loaded ) return;

		global $wgTranslateAddMWExtensionGroups;
		if ( $wgTranslateAddMWExtensionGroups ) {
			$a = new PremadeMediawikiExtensionGroups;
			$a->addAll();
		}

		global $wgTranslateCategory, $wgTranslateCC;
/*		wfLoadExtensionMessages( 'Translate' );
		$cat = Category::newFromName( wfMsgForContent( 'translate-tag-category' ) );
		$titles = $cat->getMembers();
		foreach ( $titles as $t ) {
			$title = $t->getPrefixedText();
			$id = "page|$title";
			$wgTranslateCC[$id] = new WikiPageMessageGroup( $id, $title );
			$wgTranslateCC[$id]->setLabel( $title );
			$wgTranslateCC[$id]->setDescription( wfMsgNoTrans( 'translate-tag-page-desc', $title ) );

		}*/

		global $wgTranslateCC;
		wfRunHooks( 'TranslatePostInitGroups', array( &$wgTranslateCC ) );
		$loaded = true;
	}

	public static function getGroup( $id ) {
		self::init();

		global $wgTranslateEC, $wgTranslateAC, $wgTranslateCC;
		if ( in_array( $id, $wgTranslateEC ) ) {
			$creater = $wgTranslateAC[$id];
			if ( is_array( $creater ) ) {
				return call_user_func( $creater, $id );
			} else {
				return new $creater;
			}
		} else {
			if ( array_key_exists( $id, $wgTranslateCC ) ) {
				if ( is_callable( $wgTranslateCC[$id] ) ) {
					return call_user_func( $wgTranslateCC[$id], $id );
				} else {
					return $wgTranslateCC[$id];
				}
			} elseif ( strpos( $id, 'page|' ) === 0 ) {
				list( , $title ) = explode( '|', $id, 2 );
				return new WikiPageMessageGroup( $id, $title );
			} else {
				return null;
			}
		}
	}

	public $classes = array();
	private function __construct() {
		self::init();
		global $wgTranslateEC, $wgTranslateCC;

		$all = array_merge( $wgTranslateEC, array_keys( $wgTranslateCC ) );
		sort( $all );
		foreach ( $all as $id ) {
			$g = self::getGroup( $id );
			$this->classes[$g->getId()] = $g;
		}
	}

	public static function singleton() {
		static $instance;
		if ( !$instance instanceof self ) {
			$instance = new self();
		}
		return $instance;
	}

	public function getGroups() {
		return $this->classes;
	}
}
