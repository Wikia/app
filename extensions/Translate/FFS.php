<?php
/**
 * File format support classes.
 *
 * These classes handle parsing and generating various different
 * file formats where translation messages are stored.
 *
 * @file
 * @defgroup FFS File format support
 * @author Niklas Laxström
 * @copyright Copyright © 2008-2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Interface for file system support classes.
 * @ingroup FFS
 */
interface FFS {
	public function __construct( FileBasedMessageGroup $group );

	/**
	 * Set the file system location
	 * @param $target \string Filesystem path for exported files.
	 */
	public function setWritePath( $target );

	/**
	 * Get the file system location
	 * @return \string
	 */
	public function getWritePath();

	/**
	 * Will parse messages, authors, and any custom data from the file
	 * and return it in associative array with keys like \c AUTHORS and
	 * \c MESSAGES.
	 * @param $code \string Languge code.
	 * @return \arrayof{String,Mixed} Parsed data.
	 */
	public function read( $code );

	/**
	 * Same as read(), but takes the data as a parameters. The caller
	 * is supposed to know in what language the translations are in.
	 * @param $data \string Formatted messages.
	 * @return \arrayof{String,Mixed} Parsed data.
	 */
	public function readFromVariable( $data );

	/**
	 * Writes to the location provided with setWritePath and group specific
	 * directory structure. Exports translations included in the given
	 * collection with any special handling needed.
	 * @param $collection MessageCollection
	 */
	public function write( MessageCollection $collection );

	/**
	 * Quick shortcut for getting the plain exported data.
	 * Same as write(), but returns the output instead of writing it into
	 * a file.
	 * @param $collection MessageCollection
	 * @return \string
	 */
	public function writeIntoVariable( MessageCollection $collection );
}

/**
 * Very basic FFS module that implements some basic functionality and
 * simple binary based file format.
 * Other FFS classes can extend SimpleFFS and override suitable methods.
 * @ingroup FFS
 */
class SimpleFFS implements FFS {
	protected $group;
	protected $writePath;
	protected $extra;

	public function __construct( FileBasedMessageGroup $group ) {
		$this->setGroup( $group );
		$conf = $group->getConfiguration();
		$this->extra = $conf['FILES'];
	}

	public function setGroup( FileBasedMessageGroup $group ) { $this->group = $group; }
	public function getGroup() { return $this->group; }

	public function setWritePath( $writePath ) { $this->writePath = $writePath; }
	public function getWritePath() { return $this->writePath; }

	public function exists( $code = 'en' ) {
		$filename = $this->group->getSourceFilePath( $code );
		if ( $filename === null ) {
			return false;
		}

		if ( !file_exists( $filename ) ) {
			return false;
		}

		return true;
	}

	public function read( $code ) {
		if ( !$this->exists( $code ) ) {
			return false;
		}

		$filename = $this->group->getSourceFilePath( $code );
		$input = file_get_contents( $filename );
		if ( $input === false ) {
			throw new MWException( "Unable to read file $filename" );
		}

		return $this->readFromVariable( $input );
	}

	public function readFromVariable( $data ) {
		$parts = explode( "\0\0\0\0", $data );

		if ( count( $parts ) !== 2 ) {
			throw new MWException( 'Wrong number of parts' );
		}

		list( $authorsPart, $messagesPart ) = $parts;
		$authors = explode( "\0", $authorsPart );
		$messages = array();

		foreach ( explode( "\0", $messagesPart ) as $line ) {
			if ( $line === '' ) {
				continue;
			}

			$lineParts = explode( '=', $line, 2 );

			if ( count( $lineParts ) !== 2 ) {
				throw new MWException( "Wrong number of parts in line $line" );
			}

			list( $key, $message ) = $lineParts;
			$key = trim( $key );
			$messages[$key] = $message;
		}

		$messages = $this->group->getMangler()->mangle( $messages );

		return array(
			'AUTHORS' => $authors,
			'MESSAGES' => $messages,
		);
	}

	public function write( MessageCollection $collection ) {
		$writePath = $this->writePath;

		if ( $writePath === null ) {
			throw new MWException( "Write path is not set" );
		}

		if ( !file_exists( $writePath ) ) {
			throw new MWException( "Write path '$writePath' does not exists" );
		}

		if ( !is_writable( $writePath ) ) {
			throw new MWException( "Write path '$writePath' is not writable" );
		}

		$targetFile = $writePath . '/' . $this->group->getTargetFilename( $collection->code );

		if ( file_exists( $targetFile ) ) {
			$this->tryReadSource( $targetFile, $collection );
		} else {
			$sourceFile = $this->group->getSourceFilePath( $collection->code );
			$this->tryReadSource( $sourceFile, $collection );
		}

		$output = $this->writeReal( $collection );
		if ( $output ) {
			wfMkdirParents( dirname( $targetFile ), null, __METHOD__ );
			file_put_contents( $targetFile, $output );
		}
	}

	public function writeIntoVariable( MessageCollection $collection ) {
		$sourceFile = $this->group->getSourceFilePath( $collection->code );
		$this->tryReadSource( $sourceFile, $collection );

		return $this->writeReal( $collection );
	}

	protected function writeReal( MessageCollection $collection ) {
		$output = '';

		$authors = $collection->getAuthors();
		$authors = $this->filterAuthors( $authors, $collection->code );
		$output .= implode( "\0", $authors );
		$output .= "\0\0\0\0";

		$mangler = $this->group->getMangler();

		foreach ( $collection as $key => $m ) {
			$key = $mangler->unmangle( $key );
			$trans = $m->translation();
			$output .= "$key=$trans\0";
		}

		return $output;
	}

	protected function tryReadSource( $filename, $collection ) {
		$sourceText = $this->tryReadFile( $filename );

		if ( $sourceText !== false ) {
			$sourceData = $this->readFromVariable( $sourceText );

			if ( isset( $sourceData['AUTHORS'] ) ) {
				$collection->addCollectionAuthors( $sourceData['AUTHORS'] );
			}
		}
	}

	protected function tryReadFile( $filename ) {
		if ( !$filename ) {
			return false;
		}

		if ( !file_exists( $filename ) ) {
			return false;
		}

		if ( !is_readable( $filename ) ) {
			throw new MWException( "File $filename is not readable" );
		}

		$data = file_get_contents( $filename );
		if ( $data == false ) {
			throw new MWException( "Unable to read file $filename" );
		}

		return $data;
	}

	protected function filterAuthors( array $authors, $code ) {
		global $wgTranslateAuthorBlacklist;
		$groupId = $this->group->getId();

		foreach ( $authors as $i => $v ) {
			$hash = "$groupId;$code;$v";

			$blacklisted = false;
			foreach ( $wgTranslateAuthorBlacklist as $rule ) {
				list( $type, $regex ) = $rule;

				if ( preg_match( $regex, $hash ) ) {
					if ( $type === 'white' ) {
						$blacklisted = false;
						break;
					} else {
						$blacklisted = true;
					}
				}
			}

			if ( $blacklisted ) {
				unset( $authors[$i] );
			}
		}

		return $authors;
	}

	public static function fixNewLines( $data ) {
		$data = str_replace( "\r\n", "\n", $data );
		$data = str_replace( "\r", "\n", $data );

		return $data;
	}
}

/**
 * JavaFFS class implements support for Java properties files.
 * This class reads and writes only utf-8 files. Java projects
 * need to run native2ascii on them before using them.
 *
 * This class adds a new item into FILES section of group configuration:
 * \c keySeparator which defaults to '='.
 * @ingroup FFS
 */
class JavaFFS extends SimpleFFS {
	protected $keySeparator = '=';

	public function __construct( FileBasedMessageGroup $group ) {
		parent::__construct( $group );

		if ( isset( $this->extra['keySeparator'] ) ) {
			$this->keySeparator = $this->extra['keySeparator'];
		}
	}

	// READ

	public function readFromVariable( $data ) {
		$data = self::fixNewLines( $data );
		$lines = array_map( 'ltrim', explode( "\n", $data ) );
		$authors = $messages = array();
		$linecontinuation = false;

		foreach ( $lines as $line ) {
			if ( $linecontinuation ) {
				$linecontinuation = false;
				$valuecont = $line;
				$valuecont = str_replace( '\n', "\n", $valuecont );
				$value .= $valuecont;
			} else {
				if ( $line === '' ) {
					continue;
				}

				if ( $line[0] === '#' ) {
					$match = array();
					$ok = preg_match( '/#\s*Author:\s*(.*)/', $line, $match );

					if ( $ok ) {
						$authors[] = $match[1];
					}

					continue;
				}

				if ( strpos( $line, $this->keySeparator ) === false ) {
					throw new MWException( "Line without '{$this->keySeparator}': $line" );
				}

				list( $key, $value ) = explode( $this->keySeparator, $line, 2 );
				$key = trim( $key );

				if ( $key === '' ) {
					throw new MWException( "Empty key in line $line" );
				}

				$value = str_replace( '\n', "\n", $value );
			}

			if ( strlen( $value ) && $value[strlen( $value ) - 1] === "\\" ) {
				$value = substr( $value, 0, strlen( $value ) - 1 );
				$linecontinuation = true;
			} else {
				$messages[$key] = ltrim( $value );
			}
		}

		$messages = $this->group->getMangler()->mangle( $messages );

		return array(
			'AUTHORS' => $authors,
			'MESSAGES' => $messages,
		);
	}

	// Write

	protected function writeReal( MessageCollection $collection ) {
		$header  = $this->doHeader( $collection );
		$header .= $this->doAuthors( $collection );
		$header .= "\n";

		$output = '';
		$mangler = $this->group->getMangler();

		foreach ( $collection as $key => $m ) {
			$key = $mangler->unmangle( $key );
			$value = $m->translation();
			$value = str_replace( TRANSLATE_FUZZY, '', $value );

			if ( $value === '' ) {
				continue;
			}

			// Make sure we do not slip newlines trough... it would be fatal.
			$value = str_replace( "\n", '\\n', $value );

			// Just to give an overview of translation quality.
			if ( $m->hasTag( 'fuzzy' ) ) {
				$output .= "# Fuzzy\n";
			}

			$output .= "$key{$this->keySeparator}$value\n";
		}

		if ( $output ) {
			return $header . $output;
		}
	}

	protected function doHeader( MessageCollection $collection ) {
		if ( isset( $this->extra['header'] ) ) {
			$output = $this->extra['header'];
		} else {
			global $wgSitename;

			$code = $collection->code;
			$name = TranslateUtils::getLanguageName( $code );
			$native = TranslateUtils::getLanguageName( $code, true );
			$output  = "# Messages for $name ($native)\n";
			$output .= "# Exported from $wgSitename\n";
		}

		return $output;
	}

	protected function doAuthors( MessageCollection $collection ) {
		$output = '';
		$authors = $collection->getAuthors();
		$authors = $this->filterAuthors( $authors, $collection->code );

		foreach ( $authors as $author ) {
			$output .= "# Author: $author\n";
		}

		return $output;
	}
}

/**
 * Generic file format support for JavaScript formatted files.
 * @ingroup FFS
 */
abstract class JavaScriptFFS extends SimpleFFS {
	/**
	 * Message keys format.
	 */
	abstract protected function transformKey( $key );

	/**
	 * Header of message file.
	 */
	abstract protected function header( $code, $authors );

	/**
	 * Footer of message file.
	 */
	abstract protected function footer();

	public function readFromVariable( $data ) {
		/* Parse authors list */
		$authors = preg_replace( "#/\* Translators\:\n(.*?)\n \*/(.*)#s", '$1', $data );
		if ( $authors === $data ) {
			$authors = array();
		} else {
			$authors = explode( "\n", $authors );
			for ( $i = 0; $i < count( $authors ); $i++ ) {
				$authors[$i] = substr( $authors[$i], 6 );
			}
		}

		/* Pre-processing of messages */

		/**
		 * Find the start and end of the data section (enclosed in curly braces).
		 */
		$dataStart = strpos( $data, '{' );
		$dataEnd   = strrpos( $data, '}' );

		/**
		 * Strip everything outside of the data section.
		 */
		$data = substr( $data, $dataStart + 1, $dataEnd - $dataStart - 1 );

		/**
		 * Strip comments.
		 */
		$data = preg_replace( '#^(\s*?)//(.*?)$#m', '', $data );

		/**
		 * Replace message endings with double quotes.
		 */
		$data = preg_replace( "#\'\,\n#", "\",\n", $data );

		/**
		 * Strip excess whitespace.
		 */
		$data = trim( $data );

		/**
		 * Per-key message processing.
		 */

		/**
		 * Break in to segments.
		 */
		$data = explode( "\",\n", $data );

		$messages = array();
		foreach ( $data as $segment ) {
			/**
			 * Add back trailing quote, removed by explosion.
			 */
			$segment .= '"';

			/**
			 * Concatenate separated strings.
			 */
			$segment = str_replace( '"+', '" +', $segment );
			$segment = explode( '" +', $segment );
			for ( $i = 0; $i < count( $segment ); $i++ ) {
				$segment[$i] = ltrim( ltrim( $segment[$i] ), '"' );
			}
			$segment = implode( $segment );

			/**
			 * Remove line breaks between message keys and messages.
			 */
			$segment = preg_replace( "#\:(\s+)[\\\"\']#", ': "', $segment );

			/**
			 * Break in to key and message.
			 */
			$segments = explode( ': "', $segment );

			/**
			 * Strip excess whitespace from key and value, then quotation marks.
			 */
			$key = trim( trim( $segments[0] ), "'\"" );
			$value = trim( trim( $segments[1] ), "'\"" );

			/**
			 * Unescape any JavaScript string syntax and append to message array.
			 */
			$messages[$key] = self::unescapeJsString( $value );
		}

		$messages = $this->group->getMangler()->mangle( $messages );

		return array(
			'AUTHORS' => $authors,
			'MESSAGES' => $messages
		);
	}

	public function writeReal( MessageCollection $collection ) {
		$header = $this->header( $collection->code, $collection->getAuthors() );

		$mangler = $this->group->getMangler();

		/**
		 * Get and write messages.
		 */
		$body = '';
		foreach ( $collection as $message ) {
			if ( strlen( $message->translation() ) === 0 ) {
				continue;
			}

			$key = $mangler->unmangle( $message->key() );
			$key = $this->transformKey( Xml::escapeJsString( $key ) );

			$translation = Xml::escapeJsString( $message->translation() );

			$body .= "\t{$key}: \"{$translation}\",\n";
		}

		if ( strlen( $body ) === 0 ) {
			return false;
		}

		/**
		 * Strip last comma, re-add trailing newlines.
		 */
		$body = substr( $body, 0, -2 );
		$body .= "\n";

		return $header . $body . $this->footer();
	}

	protected function authorsList( $authors ) {
		if ( count( $authors ) === 0 ) {
			return '';
		}

		$authorsList = '';
		foreach ( $authors as $author ) {
			$authorsList .= " *  - $author\n";
		}

		/**
		 * Remove trailing newline, and return.
		 */
		return substr( " * Translators:\n$authorsList", 0, -1 );
	}

	protected static function unescapeJsString( $string ) {
		// See ECMA 262 section 7.8.4 for string literal format
		$pairs = array(
			"\\" => "\\\\",
			"\"" => "\\\"",
			"'" => "\\'",
			"\n" => "\\n",
			"\r" => "\\r",

			// To avoid closing the element or CDATA section.
			"<" => "\\x3c",
			">" => "\\x3e",

			// To avoid any complaints about bad entity refs.
			"&" => "\\x26",

			/*
			 * Work around https://bugzilla.mozilla.org/show_bug.cgi?id=274152
			 * Encode certain Unicode formatting chars so affected
			 * versions of Gecko do not misinterpret our strings;
			 * this is a common problem with Farsi text.
			 */
			"\xe2\x80\x8c" => "\\u200c", // ZERO WIDTH NON-JOINER
			"\xe2\x80\x8d" => "\\u200d", // ZERO WIDTH JOINER
		);
		$pairs = array_flip( $pairs );

		return strtr( $string, $pairs );
	}
}

/**
 * New style file format support for specific kind of JavaScript
 * formatted files used by OpenLayers.
 * @ingroup FFS
 */
class OpenLayersFFS extends JavaScriptFFS {
	protected function transformKey( $key ) {
		return "'$key'";
	}

	protected function header( $code, $authors ) {
		$names = Language::getLanguageNames();
		$name = $names[ $code ];

		$authorsList = $this->authorsList( $authors );

		/** @cond doxygen_bug */
		return <<<EOT
/* Copyright (c) 2006-2008 MetaCarta, Inc., published under the Clear BSD
 * license.  See http://svn.openlayers.org/trunk/openlayers/license.txt for the
 * full text of the license. */

/**
 * @requires OpenLayers/Lang.js
 */

/**
$authorsList
 *
 * Namespace: OpenLayers.Lang["$code"]
 * Dictionary for $name.  Keys for entries are used in calls to
 *     <OpenLayers.Lang.translate>.  Entry bodies are normal strings or
 *     strings formatted for use with <OpenLayers.String.format> calls.
 */
OpenLayers.Lang["$code"] = OpenLayers.Util.applyDefaults({

EOT;
		/** @endcond */
	}

	protected function footer() {
		return "});\n";
	}
}

/**
 * File format support for Shapado, which uses JavaScript based format.
 * @ingroup FFS
 */
class ShapadoJsFFS extends JavaScriptFFS {
	protected function transformKey( $key ) {
		return $key;
	}

	protected function header( $code, $authors ) {
		global $wgSitename;

		$name = TranslateUtils::getLanguageName( $code );
		$native = TranslateUtils::getLanguageName( $code, true );
		$authorsList = $this->authorsList( $authors );

		/** @cond doxygen_bug */
		return <<<EOT
/** Messages for $name ($native)
 *  Exported from $wgSitename
 *
{$authorsList}
 */

var I18n = {

EOT;
		/** @endcond */
	}

	protected function footer() {
		return "};\n\n";
	}
}

/**
 * Implements support for message storage in YAML format.
 *
 * This class adds new key into FILES section: \c codeAsRoot.
 * If it is set to true, all messages will under language code.
 * @ingroup FFS
 */
class YamlFFS extends SimpleFFS {

	public function readFromVariable( $data ) {
		// Authors first.
		$matches = array();
		preg_match_all( '/^#\s*Author:\s*(.*)$/m', $data, $matches );
		$authors = $matches[1];

		// Then messages.
		$messages = TranslateYaml::loadString( $data );

		// Some groups have messages under language code
		if ( isset( $this->extra['codeAsRoot'] ) ) {
			$messages = array_shift( $messages );
		}

		$messages = $this->flatten( $messages );
		$messages = $this->group->getMangler()->mangle( $messages );
		foreach ( $messages as $key => &$value ) {
			$value = rtrim( $value, "\n" );
		}

		return array(
			'AUTHORS' => $authors,
			'MESSAGES' => $messages,
		);
	}

	protected function writeReal( MessageCollection $collection ) {
		$output  = $this->doHeader( $collection );
		$output .= $this->doAuthors( $collection );

		$mangler = $this->group->getMangler();

		$messages = array();
		foreach ( $collection as $key => $m ) {
			$key = $mangler->unmangle( $key );
			$value = $m->translation();
			$value = str_replace( TRANSLATE_FUZZY, '', $value );

			if ( $value === '' ) {
				continue;
			}

			$messages[$key] = $value;
		}

		if ( !count( $messages ) ) {
			return false;
		}

		$messages = $this->unflatten( $messages );

		// Some groups have messages under language code.
		if ( isset( $this->extra['codeAsRoot'] ) ) {
			$code = $this->group->mapCode( $collection->code );
			$messages = array( $code => $messages );
		}

		$output .= TranslateYaml::dump( $messages );
		return $output;
	}

	protected function doHeader( MessageCollection $collection ) {
		global $wgSitename;
		global $wgTranslateYamlLibrary;

		$code = $collection->code;
		$name = TranslateUtils::getLanguageName( $code );
		$native = TranslateUtils::getLanguageName( $code, true );
		$output  = "# Messages for $name ($native)\n";
		$output .= "# Exported from $wgSitename\n";

		if ( isset( $wgTranslateYamlLibrary ) ) {
			$output .= "# Export driver: $wgTranslateYamlLibrary\n";
		}

		return $output;
	}

	protected function doAuthors( MessageCollection $collection ) {
		$output = '';
		$authors = $collection->getAuthors();
		$authors = $this->filterAuthors( $authors, $collection->code );

		foreach ( $authors as $author ) {
			$output .= "# Author: $author\n";
		}

		return $output;
	}

	/**
	 * Flattens multidimensional array by using the path to the value as key
	 * with each individual key separated by a dot.
	 */
	protected function flatten( $messages ) {
		$flat = true;

		foreach ( $messages as $v ) {
			if ( !is_array( $v ) ) {
				continue;
			}

			$flat = false; break;
		}

		if ( $flat ) {
			return $messages;
		}

		$array = array();
		foreach ( $messages as $key => $value ) {
			if ( !is_array( $value ) ) {
				$array[$key] = $value;
			} else {
				$plural = $this->flattenPlural( $value );
				if ( $plural ) {
					$array[$key] = $plural;
				} else {
					$newArray = array();
					foreach ( $value as $newKey => $newValue ) {
						$newArray["$key.$newKey"] = $newValue;
					}
					$array += $this->flatten( $newArray );
				}
			}

			/**
			 * Can as well keep only one copy around.
			 */
			unset( $messages[$key] );
		}

		return $array;
	}

	/**
	 * Performs the reverse operation of flatten. Each dot in the key starts a
	 * new subarray in the final array.
	 */
	protected function unflatten( $messages ) {
		$array = array();
		foreach ( $messages as $key => $value ) {
			$plurals = $this->unflattenPlural( $key, $value );

			if ( $plurals === false ) {
				continue;
			}

			foreach ( $plurals as $key => $value ) {

				$path = explode( '.', $key );
				if ( count( $path ) == 1 ) {
					$array[$key] = $value;
					continue;
				}

				$pointer = &$array;
				do {
					/**
					 * Extract the level and make sure it exists.
					 */
					$level = array_shift( $path );
					if ( !isset( $pointer[$level] ) ) {
						$pointer[$level] = array();
					}

					/**
					 * Update the pointer to the new reference.
					 */
					$tmpPointer = &$pointer[$level];
					unset( $pointer );
					$pointer = &$tmpPointer;
					unset( $tmpPointer );

					/**
					 * If next level is the last, add it into the array.
					 */
					if ( count( $path ) === 1 ) {
						$lastKey = array_shift( $path );
						$pointer[$lastKey] = $value;
					}
				} while ( count( $path ) );
			}
		}

		return $array;
	}

	protected function flattenPlural( $value ) {
		return false;
	}

	/**
	 * Override this. Return false to skip processing this value. Otherwise
	 * return array with keys and values.
	 */
	protected function unflattenPlural( $key, $value ) {
		return array( $key => $value );
	}
}

/**
 * Extends YamlFFS with Ruby (on Rails) style plural support. Supports subkeys
 * zero, one, many, few, other and two for each message using plural with
 * {{count}} variable.
 * @ingroup FFS
 */
class RubyYamlFFS extends YamlFFS {
	static $pluralWords = array(
		'zero' => 1,
		'one' => 1,
		'many' => 1,
		'few' => 1,
		'other' => 1,
		'two' => 1
	);

	/**
	 * Flattens ruby plural arrays into special plural syntax.
	 */
	protected function flattenPlural( $messages ) {

		$plurals = false;
		foreach ( array_keys( $messages ) as $key ) {
			if ( isset( self::$pluralWords[$key] ) ) {
				$plurals = true;
			} elseif ( $plurals ) {
				throw new MWException( "Reserved plural keywords mixed with other keys: $key" );
			}
		}

		if ( !$plurals ) {
			return false;
		}

		$pls = '{{PLURAL';
		foreach ( $messages as $key => $value ) {
			if ( $key === 'other' ) {
				continue;
			}

			$pls .= "|$key=$value";
		}

		// Put the "other" alternative last, without other= prefix.
		$other = isset( $messages['other'] ) ? '|' . $messages['other'] : '';
		$pls .= "$other}}";
		return $pls;
	}

	/**
	 * Converts the special plural syntax to array or ruby style plurals
	 */
	protected function unflattenPlural( $key, $message ) {
		// Quick escape.
		if ( strpos( $message, '{{PLURAL' ) === false ) {
			return array( $key => $message );
		}

		/*
		 * Replace all variables with placeholders. Possible source of bugs
		 * if other characters that given below are used.
		 */
		$regex = '~\{\{[a-zA-Z_-]+}}~';
		$placeholders = array();
		$match = null;

		while ( preg_match( $regex, $message, $match ) ) {
			$uniqkey = $this->placeholder();
			$placeholders[$uniqkey] = $match[0];
			$search = preg_quote( $match[0], '~' );
			$message = preg_replace( "~$search~", $uniqkey, $message );
		}

		// Then replace (possible multiple) plural instances into placeholders.
		$regex = '~\{\{PLURAL\|(.*?)}}~s';
		$matches = array();
		$match = null;

		while ( preg_match( $regex, $message, $match ) ) {
			$uniqkey = $this->placeholder();
			$matches[$uniqkey] = $match;
			$message = preg_replace( $regex, $uniqkey, $message );
		}

		// No plurals, should not happen.
		if ( !count( $matches ) ) {
			return false;
		}

		// The final array of alternative plurals forms.
		$alts = array();

		/*
		 * Then loop trough each plural block and replacing the placeholders
		 * to construct the alternatives. Produces invalid output if there is
		 * multiple plural bocks which don't have the same set of keys.
		 */
		$pluralChoice = implode( '|', array_keys( self::$pluralWords ) );
		$regex = "~($pluralChoice)\s*=\s*(.+)~s";
		foreach ( $matches as $ph => $plu ) {
			$forms = explode( '|', $plu[1] );

			foreach ( $forms as $form ) {
				if ( $form === '' ) {
					continue;
				}

				$match = array();
				if ( preg_match( $regex, $form, $match ) ) {
					$formWord = "$key.{$match[1]}";
					$value = $match[2];
				} else {
					$formWord = "$key.other";
					$value = $form;
				}

				if ( !isset( $alts[$formWord] ) ) {
					$alts[$formWord] = $message;
				}

				$string = $alts[$formWord];
				$alts[$formWord] = str_replace( $ph, $value, $string );
			}
		}

		// Replace other variables.
		foreach ( $alts as &$value ) {
			$value = str_replace( array_keys( $placeholders ), array_values( $placeholders ), $value );
		}

		if ( !isset( $alts["$key.other"] ) ) {
			wfWarn( "Other not set for key $key" );
			return false;
		}

		return $alts;
	}

	protected function placeholder() {
		static $i = 0;

		return "\x7fUNIQ" . dechex( mt_rand( 0, 0x7fffffff ) ) . dechex( mt_rand( 0, 0x7fffffff ) ) . $i++;
	}
}

/**
 * Generic file format support for Phython single dictionary formatted files.
 * @ingroup FFS
 */
class PythonSingleFFS extends SimpleFFS {
	private $fw = null;
	static $data = null;

	public function read( $code ) {
		// TODO: Improve this code to not use static variables.
		if ( !isset( self::$data[$this->group->getId()] ) ) {
			$filename = $this->group->getSourceFilePath( $code );
			$json = shell_exec( "python -c'import simplejson as json; execfile(\"$filename\"); print json.dumps(msg)'" );
			self::$data[$this->group->getId()] = json_decode( $json, true );
		}
		if ( !isset( self::$data[$this->group->getId()][$code] ) ) self::$data[$this->group->getId()][$code] = array();
		return array( 'MESSAGES' => self::$data[$this->group->getId()][$code] );
	}


	public function write( MessageCollection $collection ) {
		if ( $this->fw === null ) {
			$outputFile = $this->writePath . '/' . $this->group->getTargetFilename( 'en' );
			wfMkdirParents( dirname( $outputFile ), null, __METHOD__ );
			$this->fw = fopen( $outputFile, 'w' );
			$this->fw = fopen( $this->writePath . '/' . $this->group->getTargetFilename( 'en' ), 'w' );
			fwrite( $this->fw, "# -*- coding: utf-8 -*-\nmsg = {\n" );
		}

		// Not sure why this is needed, only continue if there are translations.
		$collection->loadTranslations();
		$ok = false;
		foreach ( $collection as $messages ) {
			if ( $messages->translation() != '' ) $ok = true;
		}
		if ( !$ok ) return;

		$authors = $this->doAuthors( $collection );
		if ( $authors != '' ) fwrite( $this->fw, "$authors" );
		fwrite( $this->fw, "\t'{$collection->code}': {\n" );
		fwrite( $this->fw, $this->writeBlock( $collection ) );
		fwrite( $this->fw, "\t},\n" );
	}

	public function writeIntoVariable( MessageCollection $collection ) {
		return <<<PHP
# -*- coding: utf-8 -*-
msg = {
{$this->doAuthors($collection)}\t'{$collection->code}': {
{$this->writeBlock( $collection )}\t}
}
PHP;
	}

	protected function writeBlock( MessageCollection $collection ) {
		$block = '';
		$messages = array();
		foreach ( $collection as $message ) {
			if ( $message->translation() == '' ) continue;
			$translation = str_replace( '\\', '\\\\', $message->translation() );
			$translation = str_replace( '\'', '\\\'', $translation );
			$translation = str_replace( "\n", '\n', $translation );
			$messages[$message->key()] = $translation;
		}
		ksort( $messages );
		foreach ( $messages as $key => $translation ) {
			$block .= "\t\t'{$key}': u'{$translation}',\n";
		}
		return $block;
	}

	protected function doAuthors( MessageCollection $collection ) {
		$output = '';

		// Read authors.
		$fr = fopen( $this->group->getSourceFilePath( $collection->code ), 'r' );
		$authors = array();
		while ( !feof( $fr ) ) {
			$line = fgets( $fr );
			if ( strpos( $line, "\t# Author:" ) === 0 ) {
				$authors[] = trim( substr( $line, strlen( "\t# Author: " ) ) );
			} elseif ( $line === "\t'{$collection->code}': {\n" ) {
				break;
			} else {
				$authors = array();
			}
		}
		$authors2 = $collection->getAuthors();
		$authors2 = $this->filterAuthors( $authors2, $collection->code );
		$authors = array_unique( array_merge( $authors, $authors2 ) );

		foreach ( $authors as $author ) {
			$output .= "\t# Author: $author\n";
		}

		return $output;
	}

	public function __destruct() {
		if ( $this->fw !== null ) {
			fwrite( $this->fw, "}" );
			 fclose( $this->fw );
		}
	}
}
