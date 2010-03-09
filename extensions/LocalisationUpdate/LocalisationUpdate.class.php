<?php
class LocalisationUpdate {
	// DB Search funtion
	// MW <= 1.15
	public static function FindUpdatedMessage( &$message, $lckey, $langcode, $isFullKey ) {
		// Define a cache
		static $cache = array();
		$db = wfGetDB ( DB_SLAVE );

		// If the key also contains the language code remove the language code from the key
		if ( $isFullKey ) {
			$lckey = preg_replace( "/\/" . $langcode . "/", "", $lckey );
		}
		
		// If message is in the cache, don't get an update!
		if ( array_key_exists( $lckey . "/" . $langcode, $cache ) ) {
			$message = $cache[$lckey . "/" . $langcode];
			return true;
		}

		// Get the message from the database
		$conds  = array( 'lo_key' => $lckey, 'lo_language' => $langcode );
		$result = $db->selectField( self::table( 'localisation' ), 'lo_value', $conds, __METHOD__ ); // Check if the database has any updated message
		if ( $result === false ) { // If no results found, exit here
			return true;
		}

		$message = $result;
		$cache[$lckey . "/" . $langcode] = $result; // Update the cache
		return true;
	}
	
	// MW 1.16+
	public static function onRecache( $lc, $langcode, &$cache ) {
		$dbr = wfGetDB ( DB_MASTER );

		// Get the messages from the database
		$res = $dbr->select( self::table( 'localisation' ), 
			array( 'lo_key', 'lo_value' ),
			array( 'lo_language' => $langcode ), 
			__METHOD__ ); 

		foreach ( $res as $row ) {
			$cache['messages'][$row->lo_key] = $row->lo_value;
		}
		$cache['deps'][] = new LUDependency;
		return true;
	}

	// Called from the cronjob to fetch new messages from SVN
	public static function updateMessages( $options ) {
		$verbose = !isset( $options['quiet'] );
		$all = isset( $options['all'] );
		$skipCore = isset( $options['skip-core'] );
		$skipExtensions = isset( $options['skip-extensions'] );
		
		// Update all MW core messages
		if( !$skipCore ) {
			$result = self::updateMediawikiMessages( $verbose );
		}
		
		// Update all Extension messages
		if( !$skipExtensions ) {
			if( $all ) {
				global $IP;
				$extFiles = array();
				
				// Look in extensions/ for all available items...
				$dirs = new RecursiveDirectoryIterator( "$IP/extensions/" );
				
				// I ain't kidding... RecursiveIteratorIterator.
				foreach( new RecursiveIteratorIterator( $dirs ) as $pathname => $item ) {
					$filename = basename( $pathname );
					if( preg_match( '/^(.*)\.i18n\.php$/', $filename, $matches ) ) {
						$group = $matches[1];
						$extFiles[$group] = $pathname;
					}
				}
			} else {
				global $wgExtensionMessagesFiles;
				$extFiles = $wgExtensionMessagesFiles;
			}
			foreach ( $extFiles as $extension => $locFile ) {
				$result += self::updateExtensionMessages( $locFile, $extension, $verbose );
			}
		}

		// And output the result!
		self::myLog( "Updated {$result} messages in total" );
		self::myLog( "Done" );
		return true;
	}

	// Update Extension Messages
	public static function updateExtensionMessages( $file, $extension, $verbose ) {
		global $IP, $wgLocalisationUpdateSVNURL;
		
		$relfile = wfRelativePath( $file, "$IP/extensions" );
		if( substr( $relfile, 0, 2 ) == ".." ) {
			self::myLog( "Skipping $file; not in $IP/extensions\n" );
			return false;
		}
		
		// Create a full path
		$localfile = "$IP/extensions/$relfile";

		// Get the full SVN directory path
		$svnfile = "$wgLocalisationUpdateSVNURL/extensions/$relfile";

		// Compare the 2 files
		$result = self::compareExtensionFiles( $extension, $svnfile, $file, $verbose, false, true );
		return $result;
	}

	// Update the Mediawiki Core Messages
	public static function updateMediawikiMessages( $verbose ) {
		global $IP, $wgLocalisationUpdateSVNURL;

		// Create an array which will later contain all the files that we want to try to update
		$files = array();

		// The directory which contains the files
		$dirname = "languages/messages";

		// Get the full path to the directory
		$localdir = $IP . "/" . $dirname;

		// Get the full SVN Path
		$svndir = "$wgLocalisationUpdateSVNURL/phase3/$dirname";

		// Open the directory
		$dir = opendir( $localdir );
		while ( false !== ( $file = readdir( $dir ) ) ) {
			$m = array();

			// And save all the filenames of files containing messages
			if ( preg_match( '/Messages([A-Z][a-z_]+)\.php$/', $file, $m ) ) {
				if ( $m[1] != 'En' ) { // Except for the English one
					$files[] = $file;
				}
			}
		}
		closedir( $dir );

		// Find the changed English strings (as these messages won't be updated in ANY language)
		$changedEnglishStrings = self::compareFiles( $localdir . "/MessagesEn.php", $svndir . "/MessagesEn.php", $verbose, true );

		// Count the changes
		$changedCount = 0;

		// For each language
		sort($files);
		foreach ( $files as $file ) {
			$svnfile = $svndir . "/" . $file;
			$localfile = $localdir . "/" . $file;

			// Compare the files
			$result = self::compareFiles( $svnfile, $localfile, $verbose, $changedEnglishStrings, false, true );

			// And update the change counter
			$changedCount += count( $result );
		}

		// Log some nice info
		self::myLog( "{$changedCount} Mediawiki messages are updated" );
		return $changedCount;
	}

	// Remove all unneeded content
	public static function cleanupFile( $contents ) {
		// We don't need any PHP tags
		$contents = preg_replace( "/<\\?php/", "", $contents );
		$contents = preg_replace( "/\?" . ">/", "", $contents );
		$results = array();
		// And we only want the messages array
		preg_match( "/\\\$messages(.*\s)*?\);/", $contents, $results );

		// If there is any!
		if ( !empty( $results[0] ) ) {
			$contents = $results[0];
		} else {
			$contents = "";
		}

		// Windows vs Unix always stinks when comparing files
		$contents = preg_replace( "/\\\r\\\n?/", "\n", $contents );

		// return the cleaned up file
		return $contents;
	}

	public static function getFileContents( $basefile ) {
		global $wgLocalisationUpdateRetryAttempts;
		$attempts = 0;
		$basefilecontents = "";
		// use cURL to get the SVN contents
		if ( preg_match( "/^http/", $basefile ) ) {
			while( !$basefilecontents && $attempts <= $wgLocalisationUpdateRetryAttempts) {
				if($attempts > 0) {
					$delay = 1;
					self::myLog( "Failed to download " . $basefile . "; retrying in ${delay}s..." );
					sleep( $delay );
				}
				$basefilecontents = Http::get( $basefile );
				$attempts++;
			}
			if ( !$basefilecontents ) {
					self::myLog( "Cannot get the contents of " . $basefile . " (curl)" );
					return false;
			}
		} else {// otherwise try file_get_contents
			if ( !( $basefilecontents = file_get_contents( $basefile ) ) ) {
				self::myLog( "Cannot get the contents of " . $basefile );
				return false;
			}
		}
		return $basefilecontents;
	}

	public static function compareFiles( $basefile, $comparefile, $verbose, $forbiddenKeys = array(), $alwaysGetResult = true, $saveResults = false ) {
		// We need to write to the DB later
		$db = wfGetDB ( DB_MASTER );

		$compare_messages = array();
		$base_messages = array();

		// Get the languagecode
		$m = array();
		preg_match( '/Messages([A-Z][a-z_]+)\.php$/', $basefile, $m );
		$langcode = strtolower( $m[1] );

		$basefilecontents = self::getFileContents( $basefile );
		if ( $basefilecontents === false || $basefilecontents === "" ) return array(); // Failed

		// Only get the part we need
		$basefilecontents = self::cleanupFile( $basefilecontents );

		// Change the variable name
		$basefilecontents = preg_replace( "/\\\$messages/", "\$base_messages", $basefilecontents );

		$basehash = md5( $basefilecontents );
		// Check if the file has changed since our last update
		if ( !$alwaysGetResult ) {
			if ( !self::checkHash( $basefile, $basehash ) ) {
				self::myLog( "Skipping {$langcode} since the remote file hasn't changed since our last update" );
				return array();
			}
		}

		// Get the array with messages
		$base_messages = self::parsePHP( $basefilecontents, 'base_messages' );

		$comparefilecontents = self::getFileContents( $comparefile );
		if ( $comparefilecontents === false || $comparefilecontents === "" ) return array(); // Failed

		// only get the stuff we need
		$comparefilecontents = self::cleanupFile( $comparefilecontents );

		// rename the array
		$comparefilecontents = preg_replace( "/\\\$messages/", "\$compare_messages", $comparefilecontents );

		$comparehash = md5( $comparefilecontents );
		// If this is the remote file check if the file has changed since our last update
		if ( preg_match( "/^http/", $comparefile ) && !$alwaysGetResult ) {
			if ( !self::checkHash( $comparefile, $comparehash ) ) {
				self::myLog( "Skipping {$langcode} since the remote file has not changed since our last update" );
				return array();
			}
		}
		// Get the array
		$compare_messages = self::parsePHP( $comparefilecontents, 'compare_messages' );

		// if the localfile and the remote file are the same, skip them!
		if ( $basehash == $comparehash && !$alwaysGetResult ) {
			self::myLog( "Skipping {$langcode} since the remote file is the same as the local file" );
			return array();
		}

		// Add the messages we got with our previous update(s) to the local array (as we already got these as well)
		$fields = array( 'lo_key', 'lo_value' );
		$conds = array( 'lo_language' => $langcode );
		$result = $db->select( self::table( 'localisation' ), $fields, $conds, __METHOD__ );
		foreach ( $result as $r ) {
			$compare_messages[$r->lo_key] = $r->lo_value;
		}

		// Compare the remote and local message arrays
		$changedStrings = array_diff_assoc( $base_messages, $compare_messages );

		// If we want to save the differences
		if ( $saveResults && !empty($changedStrings) && is_array($changedStrings)) {
			self::myLog( "--Checking languagecode {$langcode}--" );
			// The save them
			$updates = self::saveChanges( $changedStrings, $forbiddenKeys, $compare_messages, $base_messages, $langcode, $verbose );
			self::myLog( "{$updates} messages updated for {$langcode}." );
		} elseif ( $saveResults ) {
			self::myLog( "--{$langcode} hasn't changed--" );
		}

		
		self::saveHash( $basefile, $basehash );
		
		self::saveHash( $comparefile, $comparehash );
		
		return $changedStrings;
	}

	/**
	 * Checks whether a messages file has a certain hash
	 * TODO: Swap return values, this is insane
	 * @param $file string Filename
	 * @param $hash string Hash
	 * @return bool True if $file does NOT have hash $hash, false if it does
	 */
	public static function checkHash( $file, $hash ) {
		$db = wfGetDB( DB_MASTER );

		$hashConds = array( 'lfh_file' => $file, 'lfh_hash' => $hash );
		$result = $db->select( self::table( 'localisation_file_hash' ), '*', $hashConds, __METHOD__ );
		if ( $db->numRows( $result ) == 0 ) {
			return true;
		} else {
			return false;
		}
	}
	
	public static function saveHash ($file, $hash) {
		$db = wfGetDB ( DB_MASTER );
		// Double query sucks but we wanna make sure we don't update
		// the timestamp when the hash hasn't changed
		if ( self::checkHash( $file, $hash ) )
			$db->replace( self::table( 'localisation_file_hash' ), array( 'lfh_file' ), array(
					'lfh_file' => $file,
					'lfh_hash' => $hash,
					'lfh_timestamp' => $db->timestamp( wfTimestamp() )
				), __METHOD__
			);
	}

	public static function saveChanges( $changedStrings, $forbiddenKeys, $compare_messages, $base_messages, $langcode, $verbose ) {
		// Gonna write to the DB again
		$db = wfGetDB ( DB_MASTER );

		// Count the updates
		$updates = 0;
		if(!is_array($changedStrings)) {
			self::myLog("CRITICAL ERROR: \$changedStrings is not an array in file ".(__FILE__)." at line ".(__LINE__));
			return 0;
		}

		foreach ( $changedStrings as $key => $value ) {
			// If this message wasn't changed in English, and is in fact set
			if ( !array_key_exists( $key , $forbiddenKeys ) && isset( $compare_messages[$key] ) ) {
				// See if we can update the database
				
				$values = array(
					'lo_value' => $base_messages[$key],
					'lo_language' => $langcode,
					'lo_key' => $key
				);
				$db->replace( self::table( 'localisation' ),
					array( array( 'lo_language', 'lo_key' ) ),
					$values, __METHOD__ );
				
				// Output extra logmessages when needed
				if ( $verbose ) {
					self::myLog( "Updated message {$key} from '{$compare_messages[$key]}' to '{$base_messages[$key]}'" );
				}

				// Update the counter
				$updates++;
			}
		}
		return $updates;
	}

	public static function cleanupExtensionFile( $contents ) {
		// We don't want PHP tags
		$contents = preg_replace( "/<\?php/", "", $contents );
		$contents = preg_replace( "/\?" . ">/", "", $contents );
		$results = array();
		// And we only want message arrays
		preg_match_all( "/\\\$messages(.*\s)*?\);/", $contents, $results );
		// But we want them all in one string
		if(!empty($results[0]) && is_array($results[0])) {
			$contents = implode( "\n\n", $results[0] );
		} else {
			$contents = "";
		}

		// And we hate the windows vs linux linebreaks
		$contents = preg_replace( "/\\\r\\\n?/", "\n", $contents );
		return $contents;
	}

	public static function compareExtensionFiles( $extension, $basefile, $comparefile, $verbose, $alwaysGetResult = true, $saveResults = false ) {
		// FIXME: Factor out duplicated code?
		
		// Let's mess with the database again
		$db = wfGetDB ( DB_MASTER );
		$compare_messages = array();
		$base_messages = array();

		$basefilecontents = self::getFileContents( $basefile );
		if ( $basefilecontents === false || $basefilecontents === "" ) return 0; // Failed

		// Cleanup the file where needed
		$basefilecontents = self::cleanupExtensionFile( $basefilecontents );

		// Rename the arrays
		$basefilecontents = preg_replace( "/\\\$messages/", "\$base_messages", $basefilecontents );

		$basehash = md5( $basefilecontents );
		// If this is the remote file
		if ( preg_match( "/^http/", $basefile ) && !$alwaysGetResult ) {
			// Check if the hash has changed
			if ( !self::checkHash( $basefile, $basehash ) ) {
				self::myLog( "Skipping {$extension} since the remote file has not changed since our last update" );
				return 0;
			}
		}

		// And get the real contents
		$base_messages = self::parsePHP( $basefilecontents, 'base_messages' );
		
		$comparefilecontents = self::getFileContents( $comparefile );
		if ( $comparefilecontents === false || $comparefilecontents === "" ) return 0; // Failed

		// Only get what we need
		$comparefilecontents = self::cleanupExtensionFile( $comparefilecontents );

		// Rename the array
		$comparefilecontents = preg_replace( "/\\\$messages/", "\$compare_messages", $comparefilecontents );
		$comparehash = md5( $comparefilecontents );
		if ( preg_match( "/^http/", $comparefile ) && !$alwaysGetResult ) {
			// Check if the remote file has changed
			if ( !self::checkHash( $comparefile, $comparehash ) ) {
				self::myLog( "Skipping {$extension} since the remote file has not changed since our last update" );
				return 0;
			}
		}
		// Get the real array
		$compare_messages = self::parsePHP( $comparefilecontents, 'compare_messages' );

		// If both files are the same, they can be skipped
		if ( $basehash == $comparehash && !$alwaysGetResult ) {
			self::myLog( "Skipping {$extension} since the remote file is the same as the local file" );
			return 0;
		}

		// Update counter
		$updates = 0;

		if ( !is_array( $base_messages ) ) {
			$base_messages = array();
		}

		if ( empty( $base_messages['en'] ) ) {
			$base_messages['en'] = array();
		}

		if ( !is_array( $compare_messages ) ) {
			$compare_messages = array();
		}

		if ( empty( $compare_messages['en'] ) ) {
			$compare_messages['en'] = array();
		}

		// Find the changed english strings
		$forbiddenKeys = array_diff_assoc( $base_messages['en'], $compare_messages['en'] );

		// Do an update for each language
		foreach ( $base_messages as $language => $messages ) {
			if ( $language == "en" ) { // Skip english
				continue;
			}

			// Add the already known messages to the array so we will only find new changes
			$fields = array( 'lo_key', 'lo_value' );
			$conds = array( 'lo_language' => $language );
			$result = $db->select( self::table( 'localisation' ), $fields, $conds, __METHOD__ );
			foreach ( $result as $r ) {
				$compare_messages[$r->lo_key] = $r->lo_value;
			}


			if ( empty( $compare_messages[$language] ) || !is_array($compare_messages[$language]) ) {
				$compare_messages[$language] = array();
			}

			// Get the array of changed strings
			$changedStrings = array_diff_assoc( $messages, $compare_messages[$language] );

			// If we want to save the changes
			if ( $saveResults === true && !empty($changedStrings) && is_array($changedStrings)) {
				self::myLog( "--Checking languagecode {$language}--" );
				// The save them
				$updates = self::saveChanges( $changedStrings, $forbiddenKeys, $compare_messages, $messages, $language, $verbose );
				self::myLog( "{$updates} messages updated for {$language}." );
			} elseif($saveResults === true) {
				self::myLog( "--{$language} hasn't changed--" );
			}
		} 

		// And log some stuff
		self::myLog( "Updated " . $updates . " messages for the '{$extension}' extension" );

		self::saveHash( $basefile, $basehash );
		
		self::saveHash( $comparefile, $comparehash );
		
		return $updates;
	}

	public static function schemaUpdates() {
		global $wgExtNewTables, $wgExtNewFields;
		$dir = dirname( __FILE__ );
		$wgExtNewTables[] = array( 'localisation', "$dir/schema.sql" );
		$wgExtNewFields[] = array( 'localisation_file_hash', 'lfh_timestamp', "$dir/patch-lfh_timestamp.sql" );
		return true;
	}
	
	public static function parserTestTables( &$tables ) {
		$tables[] = 'localisation';
		$tables[] = 'localisation_file_hash';
		return true;
	}

	public static function myLog( $log ) {
		if ( isset( $_SERVER ) && array_key_exists( 'REQUEST_METHOD', $_SERVER ) ) {
			wfDebug( $log . "\n" );
		} else {
			print( $log . "\n" );
		}
	}
	
	public static function parsePHP( $php, $varname ) {
		try {
			$reader = new QuickArrayReader("<?php $php");
			return $reader->getVar( $varname );
		} catch( Exception $e ) {
			self::myLog( "Failed to read file: " . $e );
			return false;
		}
	}
	
	public static function table( $table ) {
		global $wgLocalisationUpdateDatabase;
		if( $wgLocalisationUpdateDatabase ) {
			return "$wgLocalisationUpdateDatabase.$table";
		} else {
			return $table;
		}
	}
}

class LUDependency extends CacheDependency {
	var $timestamp;

	function isExpired() {
		$timestamp = $this->getTimestamp();
		return $timestamp !== $this->timestamp;
	}

	function loadDependencyValues() {
		$this->timestamp = $this->getTimestamp();
	}

	function getTimestamp() {
		$dbr = wfGetDB( DB_MASTER );
		return $dbr->selectField( 
			LocalisationUpdate::table( 'localisation_file_hash' ),
			'MAX(lfh_timestamp)',
			'',
			__METHOD__ );
	}

	function __sleep() {
		$this->loadDependencyValues();
		return array( 'timestamp' );
	}
}
