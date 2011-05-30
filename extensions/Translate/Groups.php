<?php
/**
 * This file holds new style message groups and message group interface.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Interface for message groups.
 *
 * Message groups are the heart of the Translate extension. They encapsulate
 * a set of messages. Aside from basic information like id, label and
 * description, the class defines which mangler, message checker and file
 * system support (FFS), if any, the group uses. Usually this is only thin
 * wrapper over message configuration files.
 */
interface MessageGroup {
	/**
	 * Returns the parsed YAML configuration.
	 * @todo Remove from the interface. Only usage is in FFS. Figure out a better way.
	 * @return array
	 */
	public function getConfiguration();

	/**
	 * Returns the unique identifier for this group.
	 * @return string
	 */
	public function getId();
	/**
	 * Returns the human readable label (as plain text).
	 * @return string
	 */
	public function getLabel();
	/**
	 * Returns a longer description about the group. Description can use wiki text.
	 * @return string
	 */
	public function getDescription();
	/**
	 * Returns the namespace where messages are placed.
	 * @return int
	 */
	public function getNamespace();

	/**
	 * @todo Unclear usage. Perhaps rename to isSecondary with the only purpose
	 *       suppress warnings about message key conflicts.
	 * @return bool
	 */
	public function isMeta();
	/**
	 * If this function returns false, the message group is ignored and treated
	 * like it would not be configured at all. Useful for graceful degradation.
	 * Try to keep the check fast to avoid performance problems.
	 * @return bool
	 */
	public function exists();

	/**
	 * Returns a FFS object that handles reading and writing messages to files.
	 * May also return null if it doesn't make sense.
	 * @return FFS or null
	 */
	public function getFFS();
	/**
	 * Returns a message checker object or null.
	 * @todo Make an interface for message checkers.
	 * @return MessageChecker or null
	 */
	public function getChecker();
	/**
	 * Return a message mangler or null.
	 * @todo Make an interface for message manglers
	 * @return StringMatcher or null
	 */
	public function getMangler();

	/**
	 * Initialises a message collection with the given language code,
	 * message definitions and message tags.
	 * @return MessageCollection
	 */
	public function initCollection( $code );
	/**
	 * Returns a list of messages in a given language code. For some groups
	 * that list may be identical with the translation in the wiki. For other
	 * groups the messages may be loaded from a file (and differ from the
	 * current translations or definitions).
	 * @return array
	 */
	public function load( $code );
	/**
	 * Returns message tags. If type is given, only messages keys with that
	 * tag is returnted. Otherwise an array[tag => keys] is returnted.
	 * @return array
	 */
	public function getTags( $type = null );
	/**
	 * Returns the definition or translation for given message key in given
	 * language code.
	 * @todo Is this needed in the interface?
	 * @return string or null
	 */
	public function getMessage( $key, $code );
}

/**
 * This class implements some basic functions that wrap around the YAML
 * message group configurations.
 *
 * @see http://translatewiki.net/wiki/Translating:Group_configuration
 */
abstract class MessageGroupBase implements MessageGroup {
	protected $conf;
	protected $namespace;

	protected function __construct() { }

	public static function factory( $conf ) {
		$obj = new $conf['BASIC']['class']();
		$obj->conf =  $conf;
		$obj->namespace = $obj->parseNamespace();

		return $obj;
	}

	public function getConfiguration() { return $this->conf; }

	public function getId() { return $this->getFromConf( 'BASIC', 'id' ); }
	public function getLabel() { return $this->getFromConf( 'BASIC', 'label' ); }
	public function getDescription() { return $this->getFromConf( 'BASIC', 'description' ); }
	public function getNamespace() { return $this->namespace; }

	public function isMeta() { return $this->getFromConf( 'BASIC', 'meta' ); }

	protected function getFromConf( $section, $key ) {
		return isset( $this->conf[$section][$key] ) ? $this->conf[$section][$key] : null;
	}

	public function getFFS() {
		$class = $this->getFromConf( 'FILES', 'class' );

		if ( $class === null ) {
			return null;
		}

		if ( !class_exists( $class ) ) {
			throw new MWException( "FFS class $class does not exists" );
		}

		return new $class( $this );
	}

	public function getChecker() {
		$class = $this->getFromConf( 'CHECKER', 'class' );

		if ( $class === null ) {
			return null;
		}

		if ( !class_exists( $class ) ) {
			throw new MWException( "Checker class $class does not exists" );
		}

		$checker = new $class( $this );
		$checks = $this->getFromConf( 'CHECKER', 'checks' );

		if ( !is_array( $checks ) ) {
			throw new MWException( "Checker class $class not supplied with proper checks" );
		}

		foreach ( $checks as $check ) {
			$checker->addCheck( array( $checker, $check ) );
		}

		return $checker;
	}

	public function getMangler() {
		if ( !isset( $this->mangler ) ) {
			$class = $this->getFromConf( 'MANGLER', 'class' );

			if ( $class === null ) {
				$this->mangler = StringMatcher::emptyMatcher();
				return $this->mangler;
			}

			if ( !class_exists( $class ) ) {
				throw new MWException( "Mangler class $class does not exists" );
			}

			/**
			 * @todo Branch handling, merge with upper branch keys
			 */
			$class = $this->getFromConf( 'MANGLER', 'class' );
			$this->mangler = new $class();
			$this->mangler->setConf( $this->conf['MANGLER'] );
		}

		return $this->mangler;
	}

	public function initCollection( $code ) {
		$namespace = $this->getNamespace();
		$messages = array();

		$cache = new MessageGroupCache( $this );
		if ( !$cache->exists() ) {
			wfWarn( "By-passing message group cache" );
			$messages = $this->load( 'en' );
		} else {
			foreach ( $cache->getKeys() as $key ) {
				$messages[$key] = $cache->get( $key );
			}
		}

		$definitions = new MessageDefinitions( $namespace, $messages );
		$collection = MessageCollection::newFromDefinitions( $definitions, $code );
		$this->setTags( $collection );

		return $collection;
	}

	public function getMessage( $key, $code ) {
		$cache = new MessageGroupCache( $this, $code );
		if ( $cache->exists() ) {
			$msg = $cache->get( $key );

			if ( $msg !== false ) {
				return $msg;
			}

			// Try harder
			$nkey = str_replace( ' ', '_', strtolower( $key ) );
			$keys = $cache->getKeys();

			foreach ( $keys as $k ) {
				if ( $nkey === str_replace( ' ', '_', strtolower( $k ) ) ) {
					return $cache->get( $k );
				}
			}
			return null;
		} else {
			return null;
		}
	}

	public function getTags( $type = null ) {
		if ( $type === null ) {
			$taglist = array();
			foreach ( $this->getRawTags() as $type => $patterns ) {
				$taglist[$type] = $this->parseTags( $patterns );
			}
			return $taglist;
		} else {
			return $this->parseTags( $this->getRawTags( $type ) );
		}
	}

	protected function parseTags( $patterns ) {
		$cache = new MessageGroupCache( $this->getId() );

		if ( !$cache->exists() ) {
			wfWarn( "By-passing message group cache" );
			$messageKeys = array_keys( $this->load( 'en' ) );
		} else {
			$messageKeys = $cache->getKeys();
		}

		$matches = array();

		/**
		 * Collect exact keys, no point running them trough string matcher
		 */
		foreach ( $patterns as $index => $pattern ) {
			if ( strpos( $pattern, '*' ) === false ) {
				$matches[] = $pattern;
				unset( $patterns[$index] );
			}
		}

		if ( count( $patterns ) ) {
			/**
			 * Rest of the keys contain wildcards.
			 */
			$mangler = new StringMatcher( '', $patterns );

			/**
			 * Use mangler to find messages that match.
			 */
			foreach ( $messageKeys as $key ) {
				if ( $mangler->match( $key ) ) {
					$matches[] = $key;
				}
			}
		}

		return $matches;
	}

	protected function getRawTags( $type = null ) {
		if ( !isset( $this->conf['TAGS'] ) ) {
			return array();
		}

		$tags = $this->conf['TAGS'];
		if ( !$type ) {
			return $tags;
		}

		if ( isset( $tags[$type] ) ) {
			return $tags[$type];
		}

		return array();
	}

	protected function setTags( MessageCollection $collection ) {
		foreach ( $this->getTags() as $type => $tags ) {
			$collection->setTags( $type, $tags );
		}
	}

	protected function parseNamespace() {
		$ns = $this->getFromConf( 'BASIC', 'namespace' );

		if ( is_int( $ns ) ) {
			return $ns;
		}

		if ( defined( $ns ) ) {
			return constant( $ns );
		}

		global $wgContLang;

		$index = $wgContLang->getNsIndex( $ns );

		if ( !$index ) {
			throw new MWException( "No valid namespace defined, got $ns" );
		}

		return $index;
	}
}

/**
 * This class implements default behaviour for file based message groups.
 *
 * File based message groups are primary type of groups at translatewiki.net,
 * while other projects may use mainly page translation message groups, or
 * custom type of message groups.
 */
class FileBasedMessageGroup extends MessageGroupBase {

	/**
	 * Constructs a FileBasedMessageGroup from any normal message group.
	 * Useful for doing special Gettext exports from any group.
	 * @param $group MessageGroup
	 * @return FileBasedMessageGroup
	 */
	public static function newFromMessageGroup( $group ) {
		$conf = array(
			'BASIC' => array(
				'class' => 'FileBasedMessageGroup',
				'id' => $group->getId(),
				'label' => $group->getLabel(),
				'namespace' => $group->getNamespace(),
			),
			'FILES' => array(
				'sourcePattern' => '',
				'targetPattern' => '',
			),
		);
		return MessageGroupBase::factory( $conf );
	}

	public function exists() {
		return $this->getFFS()->exists();
	}

	public function load( $code ) {
		$ffs = $this->getFFS();
		$data = $ffs->read( $code );
		return $data ? $data['MESSAGES'] : array();
	}

	public function getSourceFilePath( $code ) {
		if ( $code === 'en' ) {
			$pattern = $this->getFromConf( 'FILES', 'definitionFile' );
			if ( $pattern !== null ) {
				return $this->replaceVariables( $pattern, $code );
			}
		}

		$pattern = $this->getFromConf( 'FILES', 'sourcePattern' );
		if ( $pattern === null ) {
			throw new MWException( 'No source file pattern defined' );
		}

		return $this->replaceVariables( $pattern, $code );
	}

	public function getTargetFilename( $code ) {
		$pattern = $this->getFromConf( 'FILES', 'targetPattern' );

		if ( $pattern === null ) {
			throw new MWException( 'No target file pattern defined' );
		}

		return $this->replaceVariables( $pattern, $code );
	}

	protected function replaceVariables( $pattern, $code ) {
		global $IP, $wgTranslateGroupRoot;

		$variables = array(
			'%CODE%' => $this->mapCode( $code ),
			'%MWROOT%' => $IP,
			'%GROUPROOT%' => $wgTranslateGroupRoot,
		);

		return str_replace( array_keys( $variables ), array_values( $variables ), $pattern );
	}

	public function mapCode( $code ) {
		if ( !isset( $this->conf['FILES']['codeMap'] ) ) {
			return $code;
		}

		if ( isset( $this->conf['FILES']['codeMap'][$code] ) ) {
			return $this->conf['FILES']['codeMap'][$code];
		} else {
			if ( !isset( $this->reverseCodeMap ) ) {
				$this->reverseCodeMap = array_flip( $this->conf['FILES']['codeMap'] );
			}

			if ( isset( $this->reverseCodeMap[$code] ) ) {
				return 'x-invalidLanguageCode';
			}

			return $code;
		}
	}

	/**
	 * Checks whether a language code can be used in this group.
	 * @param $code \string
	 * @return \bool
	 */
	public function isValidLanguage( $code ) {
		return $this->mapCode( $code ) !== 'x-invalidLanguageCode';
	}

}

/**
 * New style message group for %MediaWiki.
 * @todo Currently unused?
 */
class MediaWikiMessageGroup extends FileBasedMessageGroup {
	public function mapCode( $code ) {
		return ucfirst( str_replace( '-', '_', parent::mapCode( $code ) ) );
	}

	public function getTags( $type = null ) {
		$path = $this->getFromConf( 'BASIC', 'metadataPath' );

		if ( $path === null ) {
			throw new MWException( "metadataPath is not configured" );
		}

		$filename = "$path/messageTypes.inc";

		if ( !is_readable( $filename ) ) {
			throw new MWException( "$filename is not readable" );
		}

		$data = file_get_contents( $filename );

		if ( $data === false ) {
			throw new MWException( "Failed to read $filename" );
		}

		$reader = new ConfEditor( $data );
		$vars = $reader->getVars();

		$tags = array();
		$tags['optional'] = $vars['wgOptionalMessages'];
		$tags['ignored'] = $vars['wgIgnoredMessages'];

		if ( !$type ) {
			return $tags;
		}

		if ( isset( $tags[$type] ) ) {
			return $tags[$type];
		}

		return array();
	}
}

/**
 * Groups multiple message groups together as one big group.
 *
 * Limitations:
 *  - Only groups of same type and in the same namespace.
 */
class AggregateMessageGroup extends MessageGroupBase {

	public function exists() {
		// Group exists if there are any subgroups.
		$exists = (bool) $this->conf['GROUPS'];

		if ( !$exists ) {
			trigger_error( __METHOD__ . "[{$this->getId()}]: Group is empty" );
		}

		return $exists;
	}

	public function load( $code ) {
		$messages = array();

		foreach ( $this->getGroups() as $group ) {
			$messages += $group->load( $code );
		}

		return $messages;
	}

	public function getMangler() {
		if ( !isset( $this->mangler ) ) {
			$this->mangler = StringMatcher::emptyMatcher();
		}
		return $this->mangler;
	}

	public function getGroups() {
		if ( !isset( $this->groups ) ) {
			$groups = array();
			$ids = (array) $this->conf['GROUPS'];
			$ids = $this->expandWildcards( $ids );

			foreach ( $ids as $id ) {
				// Do not try to include self and go to infinite loop.
				if ( $id === $this->getId() ) {
					continue;
				}

				$group = MessageGroups::getGroup( $id );
				if ( $group === null ) {
					error_log( "Invalid group id in {$this->getId()}: $id" );
					continue;
				}

				/** @todo Figure out a better way to skip groups which are in
				* aggregate and as individual in the list. */
				if ( $group instanceof AggregateMessageGroup ) {
					continue;
				}

				$groups[$id] = $group;
			}
			$this->groups = $groups;
		}
		return $this->groups;
	}

	/**
	 * If the list of group ids contains wildcards, this function will match
	 * them against the list of all supported groups and return matched group
	 * names.
	 * @param $ids \list{String}
	 * @return \list{String}
	 */
	protected function expandWildcards( $ids ) {
		$hasWild = false;
		foreach ( $ids as $id ) {
			if ( strpos( $id, '*' ) !== false ) {
				$hasWild = true;
				break;
			}
		}

		if ( !$hasWild ) return $ids;

		$matcher = new StringMatcher( '', $ids );
		$all = array();
		foreach ( MessageGroups::singleton()->getGroups() as $id => $_ ) {
			if ( $matcher->match( $id ) ) {
				$all[] = $id;
			}
		}
		return $all;
	}

	public function initCollection( $code ) {
		$messages = array();
		foreach ( $this->getGroups() as $group ) {
			$cache = new MessageGroupCache( $group );
			if ( $cache->exists() ) {
				foreach ( $cache->getKeys() as $key ) {
					$messages[$key] = $cache->get( $key );
				}
			} else {
				// BC for MessageGroupOld
				$messages += $group->load( 'en' );
			}
		}

		$namespace = $this->getNamespace();
		$definitions = new MessageDefinitions( $namespace, $messages );
		$collection = MessageCollection::newFromDefinitions( $definitions, $code );
		$this->setTags( $collection );

		return $collection;
	}

	public function getMessage( $key, $code ) {
		$id = TranslateUtils::messageKeyToGroup( $this->getNamespace(), $key );
		$groups = $this->getGroups();
		if ( isset( $groups[$id] ) ) {
			return $groups[$id]->getMessage( $key, $code );
		} else {
			return null;
		}
	}

	public function getTags( $type = null ) {
		$tags = array();
		foreach ( $this->getGroups() as $group ) {
			$tags = array_merge_recursive( $tags, $group->getTags( $type ) );
		}
		return $tags;
	}
}
