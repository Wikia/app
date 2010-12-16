<?php

abstract class MessageGroupOld implements MessageGroup {
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
	 * branches one can set a message key mangler.
	 */
	protected $mangler = null;
	public function getMangler() {
		$mangler = $this->mangler;

		if ( !$mangler ) {
			$mangler = StringMatcher::emptyMatcher();
		}

		return $mangler;
	}

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
			$messages = $reader->parseMessages( $this->mangler );
			return $messages ? $messages : array();
		}
		return array();
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
	public function getSourceFilePath( $code ) {
		return $this->getMessageFileWithPath( $code );
	}

	/**
	 * Creates a new MessageCollection for this group.
	 *
	 * @param $code The langauge code for this collection.
	 * @param $unique Bool: wether to build collection for messages unique to this
	 *                group only.
	 */
	public function initCollection( $code, $unique = false ) {

		if ( !$unique ) {
			$definitions = $this->getDefinitions();
		} else {
			$definitions = $this->getUniqueDefinitions();
		}

		$defs = new MessageDefinitions( $this->namespaces[0], $definitions );
		$collection = MessageCollection::newFromDefinitions( $defs, $code );

		$bools = $this->getBools();
		$collection->setTags( 'ignored',  $bools['ignored']  );
		$collection->setTags( 'optional', $bools['optional'] );

		return $collection;
	}

	public function __construct() {
		$this->mangler = StringMatcher::emptyMatcher();
	}

	public static function factory( $label, $id ) {
		return null;
	}

	// Can be overwritten to retun false if something is wrong
	public function exists() {
		return true;
	}

	public function getChecker() {
		return null;
	}

	public function setConfiguration( $conf ) { }
	public function getConfiguration() { }
	public function getNamespace() { return $this->namespaces[0]; }
	public function getFFS() { return null; }
	public function getTags( $type = null ) {
		$tags = $this->getBools();
		if ( !$type ) return $tags;
		return isset( $tags[$type] ) ? $tags[$type] : array();
	}
}

class CoreMessageGroup extends MessageGroupOld {
	protected $label       = 'MediaWiki';
	protected $id          = 'core';
	protected $type        = 'mediawiki';
	protected $description = '{{int:translate-group-desc-mediawikicore}}';

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

	public function getChecker() {
		$checker = new MediaWikiMessageChecker( $this );
		$checker->setChecks( array(
			array( $checker, 'pluralCheck' ),
			array( $checker, 'wikiParameterCheck' ),
			array( $checker, 'wikiLinksCheck' ),
			array( $checker, 'XhtmlCheck' ),
			array( $checker, 'braceBalanceCheck' ),
			array( $checker, 'pagenameMessagesCheck' ),
			array( $checker, 'miscMWChecks' )
		) );
		return $checker;
	}
}

class ExtensionMessageGroup extends MessageGroupOld {
	protected $magicFile, $aliasFile;

	/**
	 * Name of the array where all messages are stored, if applicable.
	 */
	protected $arrName      = 'messages';

	/**
	 * Name of the array where all special page aliases are stored, if applicable.
	 * Only used in class SpecialPageAliasesCM
	 */
	protected $arrAlias      = 'aliases';

	protected $path         = null;

	public function getVariableName() { return $this->arrName; }
	public function setVariableName( $value ) { $this->arrName = $value; }

	public function getVariableNameAlias() { return $this->arrAlias; }
	public function setVariableNameAlias( $value ) { $this->arrAlias = $value; }

	/**
	 * Path to the file where array or function is defined, relative to extensions
	 * root directory defined by $wgTranslateExtensionDirectory.
	 */
	protected $messageFile  = null;
	public function getMessageFile( $code ) { return $this->messageFile; }
	public function setMessageFile( $value ) { $this->messageFile = $value; }

	public function setDescriptionMsg( $key, $url ) {
		global $wgLang;

		$desc = $this->getMessage( $key, $wgLang->getCode() );
		if ( $desc === null )
			$desc = $this->getMessage( $key, 'en' );
		if ( $desc !== null )
			$this->description = $desc;

		if ( $url )
			$this->description .= wfMsgNoTrans( 'translate-ext-url', $url );
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
			return array();
		}
	}

	public function getPath() {
		if ( $this->path === null ) {
			global $wgTranslateExtensionDirectory;
			return $wgTranslateExtensionDirectory; // BC
		}
		return $this->path;
	}

	public function setPath( $path ) {
		$this->path = $path;
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

	public function exists() {
		return is_readable( $this->getMessageFileWithPath( 'en' ) );
	}

	public function getChecker() {
		$checker = new MediaWikiMessageChecker( $this );
		$checker->setChecks( array(
			array( $checker, 'pluralCheck' ),
			array( $checker, 'wikiParameterCheck' ),
			array( $checker, 'wikiLinksCheck' ),
			array( $checker, 'XhtmlCheck' ),
			array( $checker, 'braceBalanceCheck' ),
			array( $checker, 'pagenameMessagesCheck' ),
			array( $checker, 'miscMWChecks' )
		) );
		return $checker;
	}

	public function getAliasFile() { return $this->aliasFile; }
	public function setAliasFile( $file ) { $this->aliasFile = $file; }

	public function getMagicFile() { return $this->magicFile; }
	public function setMagicFile( $file ) { $this->magicFile = $file; }

}

class AliasMessageGroup extends ExtensionMessageGroup {
	protected $dataSource;

	public function setDataSource( $page ) {
		$this->dataSource = $page;
	}

	public function initCollection( $code, $unique = false ) {
		$collection = parent::initCollection( $code, $unique );

		$defs = $this->load( 'en' );
		foreach ( $defs as $key => $value ) {
			$collection[$key] = new FatMessage( $key, implode( ", ", $value ) );
		}

		$this->fill( $collection );
		$this->fillContents( $collection );

		foreach ( array_keys( $collection->keys() ) as $key ) {
			if ( $collection[$key]->translation() === null ) unset( $collection[$key] );
		}

		return $collection;
	}

	function fill( MessageCollection $messages ) {
		$cache = $this->load( $messages->code );
		foreach ( array_keys( $messages->keys() ) as $key ) {
			if ( isset( $cache[$key] ) ) {
				if ( is_array( $cache[$key] ) ) {
					$messages[$key]->setInfile( implode( ',', $cache[$key] ) );
				} else {
					$messages[$key]->setInfile( $cache[$key] );
				}
			}
		}
	}

	public function fillContents( MessageCollection $collection ) {
		$data = TranslateUtils::getMessageContent( $this->dataSource, $collection->code );

		if ( !$data ) return;

		$lines = array_map( 'trim', explode( "\n", $data ) );
		$array = array();
		foreach ( $lines as $line ) {
			if ( $line === '' || $line[0] === '#' || $line[0] === '<' ) continue;
			if ( strpos( $line, '='  ) === false ) continue;

			list( $name, $values ) = array_map( 'trim', explode( '=', $line, 2 ) );
			if ( $name === '' || $values === '' ) continue;

			if ( isset( $collection[$name] ) ) {
				$collection[$name]->setTranslation( $values );
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
	protected $label = 'MediaWiki (most used)';
	protected $id    = 'core-0-mostused';
	protected $meta  = true;

	protected $description = '{{int:translate-group-desc-mediawikimostused}}';

	public function export( MessageCollection $messages ) { return 'Not supported'; }
	public function exportToFile( MessageCollection $messages, $authors ) { return 'Not supported'; }

	function getDefinitions() {
		$data = file_get_contents( dirname( __FILE__ ) . '/wikimedia-mostused-2009.txt' );
		$data = str_replace( "\r", '', $data );
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

class GettextMessageGroup extends MessageGroupOld {
	protected $type = 'gettext';
	/**
	 * Name of the array where all messages are stored, if applicable.
	 */
	protected $potFile      = 'messages';
	public function getPotFile() { return $this->potFile; }
	public function setPotFile( $value ) { $this->potFile = $value; }

	protected $codeMap = array();
	public function setCodeMap( $map ) {
		$this->codeMap = $map;
	}

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

class WikiMessageGroup extends MessageGroupOld {
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
	protected $type = 'mediawiki';

	public $title;

	public function __construct( $id, $source ) {
		$this->id = $id;
		$title = Title::newFromText( $source );
		if ( !$title ) {
			throw new MWException( 'Invalid title' );
		}
		$this->title = $title;
		$this->namespaces = array( NS_TRANSLATIONS, NS_TRANSLATIONS_TALK );

	}

	public function getDefinitions() {
		$dbr = wfGetDB( DB_SLAVE );
		$tables = 'translate_sections';
		$vars = array( 'trs_key', 'trs_text' );
		$conds = array( 'trs_page' => $this->title->getArticleId() );
		$res = $dbr->select( $tables, $vars, $conds, __METHOD__ );

		$defs = array();
		$prefix = $this->title->getPrefixedDBKey() . '/';
		$re = '~<tvar\|([^>]+)>(.*?)</>~u';
		foreach ( $res as $r ) {
			// TODO: use getTextForTrans?
			$text = $r->trs_text;
			$text = preg_replace( $re, '$\1', $text );
			$defs[$r->trs_key] = $text;
		}
		// Some hacks to get nice order for the messages
		ksort( $defs );
		$new_defs = array();
		foreach ( $defs as $k => $v ) $new_defs[$prefix . $k] = $v;
		return $new_defs;
	}

	public function load( $code ) {
		if ( $code === 'en' ) return $this->getDefinitions();
		else return array();
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
			// FIXME: throws PHP Notice:  Undefined index:  <key>
			// when keys are added, but createMessageIndex.php is
			// not run (like when a translatable page from page
			// translation was added)
			return $stuff[$key];
		}
		$title = Title::makeTitleSafe( $this->namespaces[0], "$key/$code" );
		$rev = Revision::newFromTitle( $title );
		if ( !$rev ) return null;
		return $rev->getText();
	}

	public function getChecker() {
		$checker = new MediaWikiMessageChecker( $this );
		$checker->setChecks( array(
			array( $checker, 'pluralCheck' ),
			array( $checker, 'wikiParameterCheck' ),
			array( $checker, 'wikiLinksCheck' ),
			array( $checker, 'XhtmlCheck' ),
			array( $checker, 'braceBalanceCheck' ),
			array( $checker, 'pagenameMessagesCheck' ),
			array( $checker, 'miscMWChecks' )
		) );
		return $checker;
	}
}

class MessageGroups {
	public static function init() {
		static $loaded = false;
		if ( $loaded ) return;
		wfDebug( __METHOD__ . "\n" );

		global $wgTranslateAddMWExtensionGroups;
		if ( $wgTranslateAddMWExtensionGroups ) {
			$a = new PremadeMediawikiExtensionGroups;
			$a->addAll();
		}

		global $wgTranslateCC;

		global $wgEnablePageTranslation;
		if ( $wgEnablePageTranslation ) {
			$dbr = wfGetDB( DB_SLAVE );

			$tables = array( 'page', 'revtag', 'revtag_type' );
			$vars   = array( 'page_id', 'page_namespace', 'page_title', );
			$conds  = array( 'page_id=rt_page', 'rtt_id=rt_type', 'rtt_name' => 'tp:mark' );
			$options = array( 'GROUP BY' => 'page_id' );
			$res = $dbr->select( $tables, $vars, $conds, __METHOD__, $options );
			foreach ( $res as $r ) {
				$title = Title::makeTitle( $r->page_namespace, $r->page_title )->getPrefixedText();
				$id = "page|$title";
				$wgTranslateCC[$id] = new WikiPageMessageGroup( $id, $title );
				$wgTranslateCC[$id]->setLabel( $title );
				$wgTranslateCC[$id]->setDescription( wfMsgNoTrans( 'translate-tag-page-desc', $title ) );
			}
		}


		wfRunHooks( 'TranslatePostInitGroups', array( &$wgTranslateCC ) );

		global $wgTranslateGroupFiles, $wgAutoloadClasses;
		foreach ( $wgTranslateGroupFiles as $file ) {
			wfDebug( $file . "\n" );
			$conf = TranslateSpyc::load( $file );
			if ( !empty( $conf['AUTOLOAD'] ) && is_array( $conf['AUTOLOAD'] ) ) {
				$dir = dirname( $file );
				foreach ( $conf['AUTOLOAD'] as $class => $file ) {
					$wgAutoloadClasses[$class] = "$dir/$file";
				}
			}

			$group = MessageGroupBase::factory( $conf );
			$wgTranslateCC[$group->getId()] = $group;
		}

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
