<?php

interface FFS {
	public function __construct( FileBasedMessageGroup $group );

	// The file system location
	public function setWritePath( $target );
	public function getWritePath();

	// Will parse messages, authors, and any custom data from file specified in
	// $group and return it in associative array with keys like AUTHORS and
	// MESSAGES.
	public function read( $code );

	public function readFromVariable( $data );

	// Writes to the location provided in $group, exporting translations included
	// in collection with any special handling needed.
	public function write( MessageCollection $collection );

	// Quick shortcut for getting the plain exported data
	public function writeIntoVariable( MessageCollection $collection );
}

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

	public function read( $code ) {
		$filename = $this->group->getSourceFilePath( $code );
		if ( $filename === null ) return false;

		if ( !file_exists( $filename ) ) return false;

		$input = file_get_contents( $filename );
		if ( $input === false ) throw new MWException( "Unable to read file $filename" );

		return $this->readFromVariable( $input );
	}

	public function readFromVariable( $data ) {
		$parts = explode( "\0\0\0\0", $data );

		if ( count( $parts ) !== 2 ) throw new MWException( 'Wrong number of parts' );

		list( $authorsPart, $messagesPart ) = $parts;
		$authors = explode( "\0", $authorsPart );
		$messages = array();
		foreach ( explode( "\0", $messagesPart ) as $line ) {
			if ( $line === '' ) continue;
			$lineParts = explode( '=', $line, 2 );

			if ( count( $lineParts ) !== 2 ) throw new MWException( "Wrong number of parts in line $line" );

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

		if ( $writePath === null ) throw new MWException( "Write path is not set" );
		if ( !file_exists( $writePath ) ) throw new MWException( "Write path '$writePath' does not exists" );
		if ( !is_writable( $writePath ) ) throw new MWException( "Write path '$writePath' is not writable" );

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
		if ( !$filename ) return false;
		if ( !file_exists( $filename ) ) return false;
		if ( !is_readable( $filename ) ) throw new MWException( "File $filename is not readable" );
		$data = file_get_contents( $filename );
		if ( $data == false ) throw new MWException( "Unable to read file $filename" );
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
			if ( $blacklisted ) unset( $authors[$i] );
		}

		return $authors;
	}

	public static function fixNewLines( $data ) {
		$data = str_replace( "\r\n", "\n", $data );
		$data = str_replace( "\r", "\n", $data );
		return $data;
	}
}

class JavaFFS extends SimpleFFS {
	protected $keySeparator = '=';

	public function __construct( FileBasedMessageGroup $group ) {
		parent::__construct( $group );
		if ( isset( $this->extra['keySeparator'] ) )
			$this->keySeparator = $this->extra['keySeparator'];
	}

	//
	// READ
	//

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
				if ( $line === '' ) continue;
				if ( $line[0] === '#' ) {
					$match = array();
					$ok = preg_match( '/#\s*Author:\s*(.*)/', $line, $match );
					if ( $ok ) $authors[] = $match[1];
					continue;
				}

				if ( strpos( $line, $this->keySeparator ) === false ) {
					throw new MWException( "Line without '{$this->keySeparator}': $line" );
				}

				list( $key, $value ) = explode( $this->keySeparator, $line, 2 );
				$key = trim( $key );
				if ( $key === '' ) throw new MWException( "Empty key in line $line" );

				$value = str_replace( '\n', "\n", $value );
			}

			if ( $value[strlen( $value ) - 1] === "\\" ) {
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

	//
	// WRITE
	//
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

			if ( $value === '' ) continue;

			# Make sure we don't slip newlines trough... it would be fatal
			$value = str_replace( "\n", '\\n', $value );
			# Just to give an overview of translation quality
			if ( $m->hasTag( 'fuzzy' ) ) $output .= "# Fuzzy\n";
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

class JavaScriptFFS extends SimpleFFS {
	private function leftTrim( $string ) {
		$string = ltrim( $string );
		$string = ltrim( $string, '"' );
		return $string;
	}

	public function readFromVariable( $data ) {
		// Just get relevant data.
		$dataStart = strpos( $data, '{' );
		$dataEnd   = strrpos( $data, '}' );
		$data = substr( $data, $dataStart + 1, $dataEnd - $dataStart - 1 );
		// Strip comments.
		$data = preg_replace( '#^(\s*?)//(.*?)$#m', '', $data );
		// Break in to message segements for further parsing.
		$data = explode( '",', $data );

		$messages = array();
		// Process each segment.
		foreach ( $data as $segment ) {
			// Remove excess quote mark at beginning.
			$segment = substr( $segment, 1 );
			// Add back trailing quote.
			$segment .= '"';
			// Concatenate seperate strings.
			$segment = explode( '" +', $segment );
			$segment = array_map( array( $this, 'leftTrim' ), $segment );
			$segment = implode( $segment );
			# $segment = preg_replace( '#\" \+(.*?)\"#m', '', $segment );
			// Break in to key and message.
			$segments = explode( '\':', $segment );
			$key = $segments[ 0 ];
			unset( $segments[ 0 ] );
			$value = implode( $segments );
			// Strip excess whitespace from both.
			$key = trim( $key );
			$value = trim( $value );
			// Remove quotation marks and syntax.
			$key = substr( $key, 1 );
			$value = substr( $value, 1, - 1 );
			$messages[ $key ] = $value;

			// Hack.
			if ( $key === 'filterEvaluateNotImplemented' ) {
				$messages[ $key ] = substr( $value, 0, - 2 );
			}
		}

		// Remove extraneous key that is sometimes present.
		unset( $messages[ 0 ] );

		return array( 'MESSAGES' => $messages );
	}

	// Quick shortcut for getting the plain exported data
	public function writeIntoVariable( MessageCollection $collection ) {
		$code = $collection->code;
		$names = Language::getLanguageNames();
		$name = $names[ $code ];

		// Generate list of authors for comment.
		$authors = $collection->getAuthors();
		$authorList = '';
		foreach ( $authors as $author ) {
			$authorList .= " *  - $author\n";
		}

		// Generate header and write.
		$r = <<<EOT
/* Copyright (c) 2006-2008 MetaCarta, Inc., published under the Clear BSD
 * license.  See http://svn.openlayers.org/trunk/openlayers/license.txt for the
 * full text of the license. */

/* Translators (2009 onwards):
$authorList */

/**
 * @requires OpenLayers/Lang.js
 */

/**
 * Namespace: OpenLayers.Lang["$code"]
 * Dictionary for $name.  Keys for entries are used in calls to
 *     <OpenLayers.Lang.translate>.  Entry bodies are normal strings or
 *     strings formatted for use with <OpenLayers.String.format> calls.
 */
OpenLayers.Lang["$code"] = OpenLayers.Util.applyDefaults({


EOT;

		// Get and write messages.
		foreach ( $collection as $message ) {
			$key = Xml::escapeJsString( $message->key() );
			$value = Xml::escapeJsString( $message->translation() );

			$line = "    '{$message->key()}': \"{$value}\",\n\n";
			$r .= $line;
		}

		// Strip last comma.
		$r = substr( $r, 0, - 3 );
		$r .= "\n\n";

		// File terminator.
		return $r . '});';
	}
}

class YamlFFS extends SimpleFFS {
	//
	// READ
	//
	public function readFromVariable( $data ) {
		$authors = $messages = array();

		# Authors first
		$matches = array();
		preg_match_all( '/^#\s*Author:\s*(.*)$/m', $data, $matches );
		$authors = $matches[1];

		# Then messages
		$messages = TranslateYaml::loadString( $data );

		# Some groups have messages under language code
		if ( isset( $this->extra['codeAsRoot'] ) ) {
			$messages = array_shift( $messages );
		}

		$messages = $this->flatten( $messages );
		$messages = $this->group->getMangler()->mangle( $messages );

		return array(
			'AUTHORS' => $authors,
			'MESSAGES' => $messages,
		);
	}

	//
	// WRITE
	//
	protected function writeReal( MessageCollection $collection ) {
		$output  = $this->doHeader( $collection );
		$output .= $this->doAuthors( $collection );

		$mangler = $this->group->getMangler();

		$messages = array();
		foreach ( $collection as $key => $m ) {
			$key = $mangler->unmangle( $key );
			$value = $m->translation();
			$value = str_replace( TRANSLATE_FUZZY, '', $value );
			if ( $value === '' ) continue;

			$messages[$key] = $value;
		}

		if ( !count( $messages ) ) return false;

		$messages = $this->unflatten( $messages );

		# Some groups have messages under language code
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
			if ( !is_array( $v ) ) continue;
			$flat = false; break;
		}
		if ( $flat ) return $messages;

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
			// Can as well keep only one copy around
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
			if ( $plurals === false ) continue;

			foreach ( $plurals as $key => $value ) {

				$path = explode( '.', $key );
				if ( count( $path ) == 1 ) {
					$array[$key] = $value;
					continue;
				}

				$pointer = &$array;
				do {
					# Extract the level and make sure it exists
					$level = array_shift( $path );
					if ( !isset( $pointer[$level] ) ) {
						$pointer[$level] = array();
					}

					# Update the pointer to the new reference
					$tmpPointer = &$pointer[$level];
					unset( $pointer );
					$pointer = &$tmpPointer;
					unset( $tmpPointer );

					# If next level is the last, add it into the array
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

		if ( !$plurals ) return false;

		$pls = '{{PLURAL';
		foreach ( $messages as $key => $value ) {
			if ( $key === 'other' ) continue;
			$pls .= "|$key=$value";
		}

		// Put the "other" alternative last, without other= prefix
		$other = isset( $messages['other'] ) ? '|' . $messages['other'] : '';
		$pls .= "$other}}";
		return $pls;
	}

	/**
	 * Converts the special plural syntax to array or ruby style plurals
	 */
	protected function unflattenPlural( $key, $message ) {
		// Quick escape
		if ( strpos( $message, '{{PLURAL' ) === false ) return array( $key => $message );

		// Replace all variables with placeholders. Possible source of bugs
		// if other characters that given below are used.
		$regex = '~\{\{[a-zA-Z_-]+}}~';
		$placeholders = array();
		$match = null;
		while ( preg_match( $regex, $message, $match ) ) {
			$uniqkey = self::placeholder();
			$placeholders[$uniqkey] = $match[0];
			$message = preg_replace( $regex, $uniqkey, $message );
		}

		// Then replace (possible multiple) plural instances into placeholders
		$regex = '~\{\{PLURAL\|(.*?)}}~s';
		$matches = array();
		$match = null;
		while ( preg_match( $regex, $message, $match ) ) {
			$uniqkey = self::placeholder();
			$matches[$uniqkey] = $match;
			$message = preg_replace( $regex, $uniqkey, $message );
		}

		// No plurals, should not happen
		if ( !count( $matches ) ) return false;

		// The final array of alternative plurals forms
		$alts = array();

		// Then loop trough each plural block and replacing the placeholders
		// to construct the alternatives. Produces invalid output if there is
		// multiple plural bocks which don't have the same set of keys.
		$pluralChoice = implode( '|', array_keys( self::$pluralWords ) );
		$regex = "~($pluralChoice)\s*=\s*(.+)~s";
		foreach ( $matches as $ph => $plu ) {
			$forms = explode( '|', $plu[1] );
			foreach ( $forms as $form ) {
				if ( $form === '' ) continue;
				$match = array();
				if ( preg_match( $regex, $form, $match ) ) {
					$formWord = "$key.{$match[1]}";
					$value = $match[2];
				} else {
					$formWord = "$key.other";
					$value = $form;
				}

				if ( !isset( $alts[$formWord] ) ) $alts[$formWord] = $message;
				$string = $alts[$formWord];
				$alts[$formWord] = str_replace( $ph, $value, $string );
			}
		}

		// Replace other variables
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