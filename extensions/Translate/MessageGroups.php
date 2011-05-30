<?php
/**
 * This file contains the old style message groups and MessageGroups class
 * for accessing all message groups by id.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2008-2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * This is the interface for old style message groups.
 * @deprecated
 */
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
	 * @param $key \string Key of the message.
	 * @param $code \string Language code.
	 * @return Mixed List of stored translation or \null.
	 */
	public function getMessage( $key, $code ) {
		if ( !isset( $this->messages[$code] ) ) {
			$this->messages[$code] = self::normaliseKeys( $this->load( $code ) );
		}
		$key = strtolower( str_replace( ' ', '_', $key ) );

		return isset( $this->messages[$code][$key] ) ? $this->messages[$code][$key] : null;
	}

	public static function normaliseKeys( $array ) {
		if ( !is_array( $array ) ) {
			return null;
		}

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

		if ( !$path || !$file ) {
			return false;
		}

		return "$path/$file";
	}
	public function getSourceFilePath( $code ) {
		return $this->getMessageFileWithPath( $code );
	}

	/**
	 * Creates a new MessageCollection for this group.
	 *
	 * @param $code \string Language code for this collection.
	 * @param $unique \bool Whether to build collection for messages unique to this
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

	/**
	 * Can be overwritten to retun false if something is wrong.
	 */
	public function exists() {
		return true;
	}

	public function getChecker() {
		return null;
	}

	// Unsupported stuff, just to satisfy the new interface
	public function setConfiguration( $conf ) { }
	public function getConfiguration() { }
	public function getNamespace() { return $this->namespaces[0]; }
	public function getFFS() { return null; }
	public function getTags( $type = null ) {
		$tags = $this->getBools();

		if ( !$type ) {
			return $tags;
		}

		return isset( $tags[$type] ) ? $tags[$type] : array();
	}
}

/**
 * This group supports the %MediaWiki messages itself.
 * @todo Move to the new interface.
 */
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

			// Filter out shared messages.
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
		// Can return null, convert to array.
		$messages = (array) $this->mangler->mangle(
			PHPVariableLoader::loadVariableFromPHPFile( $file, 'messages' )
		);

		if ( $this->parentId ) {
			if ( $code !== 'en' ) {
				// For branches, load newer compatible messages for missing entries, if any.
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
			array( $checker, 'miscMWChecks' ),
			array( $checker, 'prefMessagesCheck' ),
		) );

		return $checker;
	}
}

/**
 * This group supports messages of %MediaWiki extensions using the standard
 * format.
 * @todo Move to the new interface.
 */
class ExtensionMessageGroup extends MessageGroupOld {
	protected $magicFile, $aliasFile;

	/**
	 * Name of the array where all messages are stored, if applicable.
	 */
	protected $arrName = 'messages';

	/**
	 * Name of the array where all special page aliases are stored, if applicable.
	 * Only used in class SpecialPageAliasesCM
	 */
	protected $arrAlias = 'specialPageAliases';

	protected $path = null;

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

	public function getDescription() {
		if ( $this->description === null ) {
			// Load the messages only when needed.
			$this->setDescriptionMsgReal( $this->descriptionKey, $this->descriptionUrl );
		}
		return parent::getDescription();
	}

	/**
	 * Holders for lazy loading.
	 */
	private $descriptionKey, $descriptionUrl;

	/**
	 * Extensions have almost always a localised description message and
	 * address to extension homepage.
	 */
	public function setDescriptionMsg( $key, $url ) {
		$this->descriptionKey = $key;
		$this->descriptionUrl = $url;
	}

	protected function setDescriptionMsgReal( $key, $url ) {
		$this->description = '';

		global $wgLang;

		$desc = null;

		if ( !wfEmptyMsg( $key ) ) {
			$desc = wfMsgNoTrans( $key );
		}

		if ( $desc === null ) {
			$desc = $this->getMessage( $key, 'en' );
		}

		if ( $desc !== null ) {
			$this->description = $desc;
		}

		if ( $url ) {
			$this->description .= wfMsgNoTrans( 'translate-ext-url', $url );
		}

		if ( $this->description === '' ) {
			$this->description = wfMsgNoTrans( 'translate-group-desc-nodesc' );
		}
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
	 * @param $code \string Language code
	 * @throws MWException If loading fails.
	 * @return \array List of messages.
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

/**
 * This supports translation of special page aliases via
 * the Special:AdvancedTranslate page.
 * @todo Move to the new interface or no interface at all.
 */
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
			if ( $collection[$key]->translation() === null ) {
				unset( $collection[$key] );
			}
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

		if ( !$data ) {
			return;
		}

		$lines = array_map( 'trim', explode( "\n", $data ) );
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

/**
 * This class implements the "Most used messages" group for %MediaWiki.
 * @todo Move to the new interface.
 */
class CoreMostUsedMessageGroup extends CoreMessageGroup {
	protected $label = 'MediaWiki (most used)';
	protected $id    = 'core-0-mostused';
	protected $meta  = true;

	protected $description = '{{int:translate-group-desc-mediawikimostused}}';

	public function export( MessageCollection $messages ) { return 'Not supported'; }
	public function exportToFile( MessageCollection $messages, $authors ) { return 'Not supported'; }

	function getDefinitions() {
		$data = file_get_contents( dirname( __FILE__ ) . '/wikimedia-mostused-2011.txt' );
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

/**
 * This class implements the "Most used messages" group for %MediaWiki for the old group.
 * Should be removed in June 2011.
 * @todo Move to the new interface.
 */
class OldCoreMostUsedMessageGroup extends CoreMessageGroup {
	protected $label = 'MediaWiki (most used - 2009)';
	protected $id    = 'core-0-mostused-old';
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

/**
 * Group for messages that can be controlled via a page in %MediaWiki namespace.
 *
 * In the page comments start with # and continue till the end of the line.
 * The page should contain list of page names in %MediaWiki namespace, without
 * the namespace prefix. Use underscores for spaces in page names, since
 * whitespace separates the page names from each other.
 * @ingroup MessageGroups
 */
class WikiMessageGroup extends MessageGroupOld {
	protected $source = null;

	/**
	 * Constructor.
	 *
	 * @param $id \string Unique id for this group.
	 * @param $source \string Mediawiki message that contains list of message keys.
	 */
	public function __construct( $id, $source ) {
		parent::__construct();
		$this->id = $id;
		$this->source = $source;
	}

	/**
	 * Fetch definitions from database.
	 * @return \array Array of messages keys with definitions.
	 */
	public function getDefinitions() {
		$definitions = array();

		// In theory the page could have templates that are substitued
		$contents = wfMsg( $this->source );
		$contents = preg_replace( '~^\s*#.*$~m', '', $contents );
		$messages = preg_split( '/\s+/', $contents );

		foreach ( $messages as $message ) {
			if ( !$message ) {
				continue;
			}

			$definitions[$message] = wfMsgForContentNoTrans( $message );
		}

		return $definitions;
	}

	/**
	 * Returns of stored translation of message specified by the $key in language
	 * code $code.
	 *
	 * @param $key \string Key of the message.
	 * @param $code \string Language code.
	 * @return \types{\string,\null} The translation or null if it doesn't exists.
	 */
	public function getMessage( $key, $code ) {
		global $wgContLang;

		if ( $code && $wgContLang->getCode() !== $code ) {
			return TranslateUtils::getMessageContent( $key, $code );
		} else {
			return TranslateUtils::getMessageContent( $key, false );
		}
	}
}

/**
 * Wraps the translatable page sections into a message group.
 * @ingroup PageTranslation
 */
class WikiPageMessageGroup extends WikiMessageGroup {
	protected $title;

	public function __construct( $id, $source ) {
		$this->id = $id;
		$this->title = $source;
		$this->namespaces = array( NS_TRANSLATIONS, NS_TRANSLATIONS_TALK );
	}

	public function getTitle() {
		if ( is_string( $this->title ) ) {
			$this->title = Title::newFromText( $this->title );
		}
		return $this->title;
	}

	public function getDefinitions() {
		$dbr = wfGetDB( DB_SLAVE );
		$tables = 'translate_sections';
		$vars = array( 'trs_key', 'trs_text' );
		$conds = array( 'trs_page' => $this->getTitle()->getArticleId() );
		$options = array( 'ORDER BY' => 'trs_order' );
		$res = $dbr->select( $tables, $vars, $conds, __METHOD__, $options );

		$defs = array();
		$prefix = $this->getTitle()->getPrefixedDBKey() . '/';
		$re = '~<tvar\|([^>]+)>(.*?)</>~u';

		foreach ( $res as $r ) {
			/// @todo: use getTextForTrans?
			$text = $r->trs_text;
			$text = preg_replace( $re, '$\1', $text );
			$defs[$r->trs_key] = $text;
		}

		$new_defs = array();
		foreach ( $defs as $k => $v ) {
			$k = str_replace( ' ', '_', $k );
			$new_defs[$prefix . $k] = $v;
		}

		return $new_defs;
	}

	public function load( $code ) {
		if ( $code === 'en' ) {
			return $this->getDefinitions();
		}

		return array();
	}

	/**
	 * Returns of stored translation of message specified by the $key in language
	 * code $code.
	 *
	 * @param $key \string Key of the message.
	 * @param $code \string Language code.
	 * @return \mixed Stored translation or null.
	 */
	public function getMessage( $key, $code ) {
		if ( $code === 'en' ) {
			$stuff = $this->load( 'en' );
			return isset( $stuff[$key] ) ? $stuff[$key] : null;
		}

		$title = Title::makeTitleSafe( $this->namespaces[0], "$key/$code" );
		$rev = Revision::newFromTitle( $title );

		if ( !$rev ) {
			return null;
		}

		return $rev->getText();
	}

	public function getChecker() {
		$checker = new MediaWikiMessageChecker( $this );
		$checker->setChecks( array(
			array( $checker, 'pluralCheck' ),
			array( $checker, 'wikiParameterCheck' ),
			array( $checker, 'XhtmlCheck' ),
			array( $checker, 'braceBalanceCheck' ),
			array( $checker, 'pagenameMessagesCheck' ),
			array( $checker, 'miscMWChecks' )
		) );

		return $checker;
	}

	public function getDescription() {
		$title = $this->title;
		$target = SpecialPage::getTitleFor( 'MyLanguage', $title )->getPrefixedText();
		return wfMsgNoTrans( 'translate-tag-page-desc', $title, $target );
	}
}

/**
 * Factory class for accessing message groups individually by id or
 * all of them as an list.
 * @todo Clean up the mixed static/member method interface.
 */
class MessageGroups {

	/// Initialises the list of groups (but not the groups itself if possible).
	public static function init() {
		static $loaded = false;
		if ( $loaded ) {
			return;
		}
		$loaded = true;

		global $wgTranslateCC, $wgTranslateEC, $wgTranslateAC;
		global $wgAutoloadClasses;

		$key = wfMemcKey( 'translate-groups' );
		$value = DependencyWrapper::getValueFromCache( self::getCache(), $key );

		if ( $value === null ) {
			wfDebug( __METHOD__ . "-nocache\n" );
			self::loadGroupDefinitions();
		} else {
			wfDebug( __METHOD__ . "-withcache\n" );
			$wgTranslateCC = $value['cc'];
			$wgTranslateAC = $value['ac'];
			$wgTranslateEC = $value['ec'];

			foreach ( $value['autoload'] as $class => $file ) {
				$wgAutoloadClasses[$class] = $file;
			}
		}
	}

	/**
	 * Manually reset group cache.
	 *
	 * Use when automatic dependency tracking fails.
	 */
	public static function clearCache() {
		$key = wfMemckey( 'translate-groups' );
		self::getCache()->delete( $key );
	}

	/**
	 * Returns a cacher object.
	 */
	protected static function getCache() {
		$cacher = wfGetCache( CACHE_MEMCACHED );
		if ( $cacher instanceof FakeMemCachedClient ) {
			$cacher = wfGetCache( CACHE_DB );
		}
		return $cacher;
	}

	/**
	 * This constructs the list of all groups from multiple different
	 * sources. When possible, a cache dependency is created to automatically
	 * recreate the cache when configuration changes.
	 * @todo Reduce the ways of which messages can be added. Target is just
	 * to have three ways: Yaml files, translatable pages and with the hook.
	 * @todo In conjuction with the above, reduce the number of global
	 * variables like wgTranslate#C and have the message groups specify
	 * their own cache dependencies.
	 */
	protected static function loadGroupDefinitions() {
		global $wgTranslateAddMWExtensionGroups;
		global $wgEnablePageTranslation, $wgTranslateGroupFiles;
		global $wgTranslateAC, $wgTranslateEC, $wgTranslateCC;
		global $wgAutoloadClasses;

		$deps = array();
		$deps[] = new GlobalDependency( 'wgTranslateAddMWExtensionGroups' );
		$deps[] = new GlobalDependency( 'wgEnablePageTranslation' );
		$deps[] = new GlobalDependency( 'wgTranslateGroupFiles' );
		$deps[] = new GlobalDependency( 'wgTranslateAC' );
		$deps[] = new GlobalDependency( 'wgTranslateEC' );
		$deps[] = new GlobalDependency( 'wgTranslateCC' );
		$deps[] = new GlobalDependency( 'wgTranslateExtensionDirectory' );
		$deps[] = New FileDependency( dirname( __FILE__ ) . '/groups/mediawiki-defines.txt' );
		$deps[] = New FileDependency( dirname( __FILE__ ) . '/groups/Wikia/extensions.txt' );
		$deps[] = New FileDependency( dirname( __FILE__ ) . '/groups/Toolserver/toolserver-textdomains.txt' );

		if ( $wgTranslateAddMWExtensionGroups ) {
			$a = new PremadeMediawikiExtensionGroups;
			$a->addAll();
		}

		if ( $wgEnablePageTranslation ) {
			$dbr = wfGetDB( DB_SLAVE );

			$tables = array( 'page', 'revtag', 'revtag_type' );
			$vars   = array( 'page_id', 'page_namespace', 'page_title', );
			$conds  = array( 'page_id=rt_page', 'rtt_id=rt_type', 'rtt_name' => 'tp:mark' );
			$options = array( 'GROUP BY' => 'page_id' );
			$res = $dbr->select( $tables, $vars, $conds, __METHOD__, $options );

			foreach ( $res as $r ) {
				$title = Title::makeTitle( $r->page_namespace, $r->page_title );
				$id = TranslatablePage::getMessageGroupIdFromTitle( $title );
				$wgTranslateCC[$id] = new WikiPageMessageGroup( $id, $title );
				$wgTranslateCC[$id]->setLabel( $title->getPrefixedText() );
			}
		}

		$autoload = array();
		wfRunHooks( 'TranslatePostInitGroups', array( &$wgTranslateCC, &$deps, &$autoload ) );

		foreach ( $wgTranslateGroupFiles as $configFile ) {
			wfDebug( $configFile . "\n" );
			$deps[] = new FileDependency( realpath( $configFile ) );
			$fgroups = TranslateYaml::parseGroupFile( $configFile );

			foreach ( $fgroups as $id => $conf ) {
				if ( !empty( $conf['AUTOLOAD'] ) && is_array( $conf['AUTOLOAD'] ) ) {
					$dir = dirname( $configFile );
					foreach ( $conf['AUTOLOAD'] as $class => $file ) {
						// For this request and for caching.
						$wgAutoloadClasses[$class] = "$dir/$file";
						$autoload[$class] = "$dir/$file";
					}
				}
				$group = MessageGroupBase::factory( $conf );
				$wgTranslateCC[$id] = $group;
			}
		}

		$key = wfMemckey( 'translate-groups' );
		$value = array(
			'ac' => $wgTranslateAC,
			'ec' => $wgTranslateEC,
			'cc' => $wgTranslateCC,
			'autoload' => $autoload,
		);

		$wrapper = new DependencyWrapper( $value, $deps );
		$wrapper->storeToCache( self::getCache(), $key, 60 * 60 * 2 );

		wfDebug( __METHOD__ . "-end\n" );
	}

	/**
	 * Fetch a message group by id.
	 * @param $id \string Message group id.
	 * @return MessageGroup or null if it doesn't exist.
	 */
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
		} elseif ( isset( $wgTranslateCC[$id] ) ) {
			if ( is_callable( $wgTranslateCC[$id] ) ) {
				return call_user_func( $wgTranslateCC[$id], $id );
			} else {
				return $wgTranslateCC[$id];
			}
		}
	}

	public static function exists( $id ) {
		return (bool) self::getGroup( $id );
	}

	/**
	 * Get all enabled message groups.
	 * @return \arrayof{String,MessageGroup}
	 */
	public static function getAllGroups() {
		return self::singleton()->getGroups();
	}

	/// @todo Make protected.
	public $classes;
	private function __construct() {
		self::init();
	}

	/// Constructor function.
	public static function singleton() {
		static $instance;
		if ( !$instance instanceof self ) {
			$instance = new self();
		}
		return $instance;
	}

	/**
	 * Get all enabled message groups.
	 * @return \array
	 */
	public function getGroups() {
		if ( $this->classes === null ) {
			$this->classes = array();
			global $wgTranslateEC, $wgTranslateCC;

			$all = array_merge( $wgTranslateEC, array_keys( $wgTranslateCC ) );
			sort( $all );

			foreach ( $all as $id ) {
				$g = self::getGroup( $id );
				$this->classes[$g->getId()] = $g;
			}
		}
		return $this->classes;
	}

	/**
	 * Returns group strucuted into sub groups. First group in each subgroup is
	 * considered as the main group.
	 */
	public static function getGroupStructure() {
		global $wgTranslateGroupStructure;

		$groups = self::getAllGroups();

		$structure = array();
		foreach ( $groups as $id => $o ) {
			if ( !MessageGroups::getGroup( $id )->exists() ) {
				continue;
			}

			foreach ( $wgTranslateGroupStructure as $pattern => $hypergroup ) {
				if ( preg_match( $pattern, $id ) ) {
					// Emulate deepArraySet, because AFAIK php does not have one
					self::deepArraySet( $structure, $hypergroup, $id, $o );
					// We need to continue the outer loop, because we have finished this item.
					continue 2;
				}
			}

			// Does not belong to any subgroup, just shove it into main level.
			$structure[$id] = $o;
		}

		// Sort top-level groups according to labels, not ids
		foreach ( $structure as $id => $data ) {
			// Either it is a group itself, or the first group of the array
			$nid = is_array( $data ) ? key( $data ) : $id;
			$labels[$id] = $groups[$nid]->getLabel();
		}
		natcasesort( $labels );

		foreach ( array_keys( $labels ) as $id ) {
			$sorted[$id] = $structure[$id];
		}

		return $sorted;
	}

	/**
	 * Function do do $array[level1][level2]...[levelN][$key] = $value, if we have
	 * the indexes in an array.
	 */
	public static function deepArraySet( &$array, array $indexes, $key, $value ) {
		foreach ( $indexes as $index ) {
			if ( !isset( $array[$index] ) ) $array[$index] = array();
			$array = &$array[$index];
		}

		$array[$key] = $value;
	}

}

class SingleFileBasedMessageGroup extends FileBasedMessageGroup {}
