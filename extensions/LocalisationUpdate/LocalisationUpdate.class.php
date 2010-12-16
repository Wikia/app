<?php
class LocalisationUpdate {
	private static $newHashes = null;
	private static $filecache = array();
	
	public static function onRecache( $lc, $langcode, &$cache ) {
		$cache['messages'] = array_merge( $cache['messages'],
			self::readFile( $langcode ) );
		$cache['deps'][] = new FileDependency(
			self::filename( $langcode ) );
		return true;
	}

	// Called from the cronjob to fetch new messages from SVN
	public static function updateMessages( $options ) {
		global $wgLocalisationUpdateDirectory;
		
		$verbose = !isset( $options['quiet'] );
		$all = isset( $options['all'] );
		$skipCore = isset( $options['skip-core'] );
		$skipExtensions = isset( $options['skip-extensions'] );
		if( isset( $options['outdir'] ) ) {
			$wgLocalisationUpdateDirectory = $options['outdir'];
		}
		
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
		
		self::writeHashes();

		// And output the result!
		self::myLog( "Updated {$result} messages in total" );
		self::myLog( "Done" );
		return true;
	}

	// Update Extension Messages
	public static function updateExtensionMessages( $file, $extension, $verbose ) {
		global $IP, $wgLocalisationUpdateSVNURL;
		
		$relfile = wfRelativePath( $file, "$IP/extensions" );
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
		$contents = strtr( $contents,
				array( "<?php" => "",
				"?" . ">" => ""
		) );
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
		$contents = preg_replace( "/\\r\\n?/", "\n", $contents );

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
		$compare_messages = array();
		$base_messages = array();

		// Get the languagecode
		$langcode = Language::getCodeFromFileName( $basefile, 'Messages' );

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
		$compare_messages = array_merge( $compare_messages,
			self::readFile( $langcode ) );

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
		$hashes = self::readFile( 'hashes' );
		return @$hashes[$file] !== $hash;
	}
	
	public static function saveHash( $file, $hash ) {
		if ( is_null( self::$newHashes ) )
			self::$newHashes = self::readFile( 'hashes' );
		self::$newHashes[$file] = $hash;
	}
	
	public static function writeHashes() {
		self::writeFile( 'hashes', self::$newHashes );
	}

	public static function saveChanges( $changedStrings, $forbiddenKeys, $compare_messages, $base_messages, $langcode, $verbose ) {
		// Count the updates
		$updates = 0;
		if(!is_array($changedStrings)) {
			self::myLog("CRITICAL ERROR: \$changedStrings is not an array in file ".(__FILE__)." at line ".(__LINE__));
			return 0;
		}

		$new_messages = self::readFile( $langcode );
		foreach ( $changedStrings as $key => $value ) {
			// If this message wasn't changed in English
			if ( !isset( $forbiddenKeys[$key] ) ) {
				$new_messages[$key] = $base_messages[$key];
				
				// Output extra logmessages when needed
				if ( $verbose ) {
					$oldmsg = isset( $compare_messages[$key] ) ? "'{$compare_messages[$key]}'" : 'not set';
					self::myLog( "Updated message {$key} from $oldmsg to '{$base_messages[$key]}'" );
				}

				// Update the counter
				$updates++;
			}
		}
		self::writeFile( $langcode, $new_messages );
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
			$compare_messages[$language] = array_merge(
				$compare_messages[$language],
				self::readFile( $language ) );

			if ( empty( $compare_messages[$language] ) || !is_array( $compare_messages[$language] ) ) {
				$compare_messages[$language] = array();
			}

			// Get the array of changed strings
			$changedStrings = array_diff_assoc( $messages, $compare_messages[$language] );

			// If we want to save the changes
			if ( $saveResults === true && !empty( $changedStrings ) && is_array( $changedStrings ) ) {
				self::myLog( "--Checking languagecode {$language}--" );
				// The save them
				$updates = self::saveChanges( $changedStrings, $forbiddenKeys, $compare_messages[$language], $messages, $language, $verbose );
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
	
	public static function filename( $lang ) {
		global $wgLocalisationUpdateDirectory, $wgCacheDirectory;
		$dir = $wgLocalisationUpdateDirectory ?
			$wgLocalisationUpdateDirectory :
			$wgCacheDirectory;
		if ( !$dir )
			throw new MWException( 'No cache directory configured' );
		return "$dir/l10nupdate-$lang.cache";
	}
	
	public static function readFile( $lang ) {
		if ( !isset( self::$filecache[$lang] ) ) {
			$file = self::filename( $lang );
			$contents = @file_get_contents( $file );
			if ( $contents === false ) {
				wfDebug( "Failed to read file '$file'\n" );
				$retval = array();
			} else {
				$retval = unserialize( $contents );
				if ( $retval === false ) {
					wfDebug( "Corrupted data in file '$file'\n" );
					$retval = array();
				}
			}
			self::$filecache[$lang] = $retval;
		}
		return self::$filecache[$lang];
	}
	
	public static function writeFile( $lang, $var ) {
		$file = self::filename( $lang );
		if ( !@file_put_contents( $file, serialize( $var ) ) )
			throw new MWException( "Failed to write to file '$file'" );
		self::$filecache[$lang] = $var;
	}
}
