<?php
/**
 * @addtogroup Maintenance
 */

define( 'REPORTING_INTERVAL', 10 );

class DumpHTML {
	# Destination directory
	var $dest;

	# Extension base directory
	var $extdir;

	# Skip existing files
	var $noOverwrite = false;

	# Show interlanguage links?
	var $interwiki = true;

	# Depth of HTML directory tree
	var $depth = 3;

	# Directory that commons images are copied into
	var $sharedStaticDirectory;

	# Directory that the images are in, after copying
	var $destUploadDirectory;

	# Base URL for images, after copying
	var $destUploadUrl;

	# Base URL for the destination directory
	var $articleBaseUrl;

	# Relative path to image directory
	var $imageRel = 'upload';

	# Copy commons images instead of symlinking
	var $forceCopy = false;

	# Make a copy of all images encountered
	var $makeSnapshot = false;

	# Don't image description pages in doEverything()
	var $noSharedDesc = false;

	# Make links assuming the script path is in the same directory as
	# the destination
	var $alternateScriptPath = false;

	# Original values of various globals
	var $oldArticlePath = false, $oldCopyrightIcon = false, $oldLogo, $oldRepoGroup, $oldScriptPath;

	# Has setupGlobals been called?
	var $setupDone = false;

	# Has to compress html pages
	var $compress = false;

	# List of raw pages used in the current article
	var $rawPages;

	# Skin to use
	var $skin = 'offline';

	# User group to use
	var $group = false;

	# Checkpoint stuff
	var $checkpointFile = false, $checkpoints = false;

	var $startID = 1, $endID = false;

	var $sliceNumerator = 1, $sliceDenominator = 1;

	# Max page ID, lazy initialised
	var $maxPageID = false;

	# UDP profiling
	var $udpProfile, $udpProfileCounter = 0, $udpProfileInit = false;

	# Debugging options
	var $showTitles = false;

	# Extension version
	const VERSION = '2.0';

	function DumpHTML( $settings = array() ) {
		foreach ( $settings as $var => $value ) {
			$this->$var = $value;
		}
		$this->extdir = dirname( __FILE__ );
	}

	function loadCheckpoints() {
		if ( $this->checkpoints !== false ) {
			return true;
		} elseif ( !$this->checkpointFile ) {
			return false;
		} else {
			$lines = @file( $this->checkpointFile );
			if ( $lines === false ) {
				print "Starting new checkpoint file \"{$this->checkpointFile}\"\n";
				$this->checkpoints = array();
			} else {
				$lines = array_map( 'trim', $lines );
				$this->checkpoints = array();
				foreach ( $lines as $line ) {
					list( $name, $value ) = explode( '=', $line, 2 );
					$this->checkpoints[$name] = $value;
				}
			}
			return true;
		}
	}

	function getCheckpoint( $type, $defValue = false ) {
		if ( !$this->loadCheckpoints() ) {
			return false;
		}
		if ( !isset( $this->checkpoints[$type] ) ) {
			return false;
		} else {
			return $this->checkpoints[$type];
		}
	}

	function setCheckpoint( $type, $value ) {
		if ( !$this->checkpointFile ) {
			return;
		}
		$this->checkpoints[$type] = $value;
		$blob = '';
		foreach ( $this->checkpoints as $type => $value ) {
			$blob .= "$type=$value\n";
		}
		file_put_contents( $this->checkpointFile, $blob );
	}

	function doEverything() {
		if ( $this->getCheckpoint( 'everything' ) == 'done' ) {
			print "Checkpoint says everything is already done\n";
			return;
		}
		$this->doArticles();
		$this->doCategories();
		$this->doRedirects();
		if ( $this->sliceNumerator == 1 ) {
			$this->doSpecials();
		}
		$this->doLocalImageDescriptions();

		if ( !$this->noSharedDesc ) {
			$this->doSharedImageDescriptions();
		}

		$this->setCheckpoint( 'everything', 'done' );
	}

	/**
	 * Write a set of articles specified by start and end page_id
	 * Skip categories and images, they will be done separately
	 */
	function doArticles() {
		if ( $this->endID === false ) {
			$end = $this->getMaxPageID();
		} else {
			$end = $this->endID;
		}
		$start = $this->startID;
		
		# Start from the checkpoint
		$cp = $this->getCheckpoint( 'article' );
		if ( $cp == 'done' ) {
			print "Articles already done\n";
			return;
		} elseif ( $cp !== false ) {
			$start = $cp;
			print "Resuming article dump from checkpoint at page_id $start of $end\n";
		} else {
			print "Starting from page_id $start of $end\n";
		}

		# Move the start point to the correct slice if it isn't there already
		$start = $this->modSliceStart( $start );

		$this->setupGlobals();

		$mainPageObj = Title::newMainPage();
		$mainPage = $mainPageObj->getPrefixedDBkey();

		for ( $id = $start, $i = 0; $id <= $end; $id += $this->sliceDenominator, $i++ ) {
			wfWaitForSlaves( 20 );
			if ( !( $i % REPORTING_INTERVAL) ) {
				print "Processing ID: $id\r";
				$this->setCheckpoint( 'article', $id );
			}
			if ( !($i % (REPORTING_INTERVAL*10) ) ) {
				print "\n";
			}
			$title = Title::newFromID( $id );
			if ( $title ) {
				$ns = $title->getNamespace() ;
				if ( $ns != NS_CATEGORY && $ns != NS_MEDIAWIKI && 
				  $title->getPrefixedDBkey() != $mainPage ) {
					$this->doArticle( $title );
				}
			}
		}
		$this->setCheckpoint( 'article', 'done' );
		print "\n";
	}

	function doSpecials() {
		$this->doMainPage();

		$this->setupGlobals();
		print "Special:Categories...";
		$this->doArticle( SpecialPage::getTitleFor( 'Categories' ) );
		print "\n";
	}

	/** Write the main page as index.html */
	function doMainPage() {

		print "Making index.html  ";

		// Set up globals with no ../../.. in the link URLs
		$this->setupGlobals( 0 );

		$title = Title::newMainPage();
		$text = $this->getArticleHTML( $title );
		
		# Parse the XHTML to find the images
		#$images = $this->findImages( $text );
		#$this->copyImages( $images );
		
		$file = fopen( "{$this->dest}/index.html", "w" );
		if ( !$file ) {
			print "\nCan't open index.html for writing\n";
			return false;
		}
		fwrite( $file, $text );
		fclose( $file );
		print "\n";
	}

	function doImageDescriptions() {
		$this->doLocalImageDescriptions();
		if ( !$this->noSharedDesc ) {
			$this->doSharedImageDescriptions();
		}
	}

	/**
	 * Dump image description pages that don't have an associated article, but do
	 * have a local image
	 */
	function doLocalImageDescriptions() {
		$chunkSize = 1000;

		$dbr = wfGetDB( DB_SLAVE );
		
		$cp = $this->getCheckpoint( 'local image' );
		if ( $cp == 'done' ) {
			print "Local image descriptions already done\n";
			return;
		} elseif ( $cp !== false ) {
			print "Writing image description pages starting from $cp\n";
			$conds = array(	'img_name >= ' . $dbr->addQuotes( $cp ) );
		} else {
			print "Writing image description pages for local images\n";		
			$conds = false;
		}

		$this->setupGlobals();
		$i = 0;

		do {
			$res = $dbr->select( 'image', array( 'img_name' ), $conds, __METHOD__, 
				array( 'ORDER BY' => 'img_name', 'LIMIT' => $chunkSize ) );
			$numRows = $dbr->numRows( $res );

			while ( $row = $dbr->fetchObject( $res ) ) {
				# Update conds for the next chunk query
				$conds = array( 'img_name > ' . $dbr->addQuotes( $row->img_name ) );
				
				// Slice the result set with a filter
				if ( !$this->sliceFilter( $row->img_name ) ) {
					continue;
				}

				wfWaitForSlaves( 10 );
				if ( !( ++$i % REPORTING_INTERVAL ) ) {
					print "{$row->img_name}\n";
					if ( $row->img_name !== 'done' ) {
						$this->setCheckpoint( 'local image', $row->img_name );
					}
				}
				$title = Title::makeTitle( NS_IMAGE, $row->img_name );
				if ( $title->getArticleID() ) {
					// Already done by dumpHTML
					continue;
				}
				$this->doArticle( $title );
			}
			$dbr->freeResult( $res );
		} while ( $numRows );
		
		$this->setCheckpoint( 'local image', 'done' );
		print "\n";
	}

	/**
	 * Dump images which only have a real description page on commons
	 */
	function doSharedImageDescriptions() {
		list( $start, $end ) = $this->sliceRange( 0, 255 );

		$cp = $this->getCheckpoint( 'shared image' );
		if ( $cp == 'done' ) {
			print "Shared description pages already done\n";
			return;
		} elseif ( $cp !== false ) {
			print "Writing description pages for commons images starting from directory $cp/255\n";
			$start = $cp;
		} else {
			print "Writing description pages for commons images\n";
		}

		$this->setupGlobals();
		$i = 0;
		foreach ( $this->oldRepoGroup->foreignInfo as $repo ) {
			$repoName = $repo['name'];
			for ( $hash = $start; $hash <= $end; $hash++ ) {
				$this->setCheckpoint( 'shared image', $hash );
				$rel = sprintf( "%01x/%02x", intval( $hash / 16 ), $hash );
				$dir = "{$this->destUploadDirectory}/$repoName/$rel";
				$handle = @opendir( $dir );
				while ( $handle && $file = readdir( $handle ) ) {
					if ( $file[0] == '.' ) {
						continue;
					}
					if ( !(++$i % REPORTING_INTERVAL ) ) {
						print "$rel $i\r";
					}

					$title = Title::makeTitleSafe( NS_IMAGE, $file );
					if ( !$title ) {
						wfDebug( __METHOD__.": invalid title: $file\n" );
						continue;
					}
					$this->doArticle( $title );
				}
				if ( $handle ) {
					closedir( $handle );
				}
				print "\n";
			}
		}
		$this->setCheckpoint( 'shared image', 'done' );
		print "\n";
	}

	function doCategories() {
		$chunkSize = 1000;
		
		$this->setupGlobals();
		$dbr = wfGetDB( DB_SLAVE );
		
		$cp = $this->getCheckpoint( 'category' );
		if ( $cp == 'done' ) {
			print "Category pages already done\n";
			return;
		} elseif ( $cp !== false ) {
			print "Resuming category page dump from $cp\n";
			$conds = array( 'cl_to >= ' . $dbr->addQuotes( $cp ) );
		} else {
			print "Starting category pages\n";
			$conds = false;
		}

		$i = 0;
		do {
			$res = $dbr->select( 'categorylinks', 'DISTINCT cl_to', $conds, __METHOD__, 
				array( 'ORDER BY' => 'cl_to', 'LIMIT' => $chunkSize ) );
			$numRows = $dbr->numRows( $res );
			
			while ( $row = $dbr->fetchObject( $res ) ) {
				// Set conditions for next chunk
				$conds = array( 'cl_to > ' . $dbr->addQuotes( $row->cl_to ) );
				
				// Filter pages from other slices
				if ( !$this->sliceFilter( $row->cl_to ) ) {
					continue;
				}

				wfWaitForSlaves( 10 );
				if ( !(++$i % REPORTING_INTERVAL ) ) {
					print "{$row->cl_to}\n";
					if ( $row->cl_to != 'done' ) {
						$this->setCheckpoint( 'category', $row->cl_to );
					}
				}
				$title = Title::makeTitle( NS_CATEGORY, $row->cl_to );
				$this->doArticle( $title );
			}
			$dbr->freeResult( $res );
		} while ( $numRows );
		
		$this->setCheckpoint( 'category', 'done' );
		print "\n";
	}

	function doRedirects() {
		print "Doing redirects...\n";

		$chunkSize = 10000;
		$end = $this->getMaxPageID();
		$cp = $this->getCheckpoint( 'redirect' );
		if ( $cp == 'done' )  {
			print "Redirects already done\n";
			return;
		} elseif ( $cp !== false ) {
			print "Resuming redirect generation from page_id $cp\n";
			$start = intval( $cp );
		} else {
			$start = 1;
		}

		$this->setupGlobals();
		$dbr = wfGetDB( DB_SLAVE );
		$i = 0;

		for ( $chunkStart = $start; $chunkStart <= $end; $chunkStart += $chunkSize ) {
			$chunkEnd = min( $end, $chunkStart + $chunkSize - 1 );
			$conds = array( 
				'page_is_redirect' => 1,
				"page_id BETWEEN $chunkStart AND $chunkEnd"
			);
			# Modulo slicing in SQL
			if ( $this->sliceDenominator != 1 ) {
				$n = intval( $this->sliceNumerator );
				$m = intval( $this->sliceDenominator );
				$conds[] = "page_id % $m = $n";
			}
			$res = $dbr->select( 'page', array( 'page_id', 'page_namespace', 'page_title' ),
				$conds, __METHOD__ );
			
			while ( $row = $dbr->fetchObject( $res ) ) {
				$title = Title::makeTitle( $row->page_namespace, $row->page_title );
				if ( !(++$i % (REPORTING_INTERVAL*10) ) ) {
					printf( "Done %d redirects (%2.3f%%)\n", $i, $row->page_id / $end * 100 );
					$this->setCheckpoint( 'redirect', $row->page_id );
				}
				$this->doArticle( $title );
			}
			$dbr->freeResult( $res );
		}
		$this->setCheckpoint( 'redirect', 'done' );
	}

	/** Write an article specified by title */
	function doArticle( $title ) {
		if ( $this->noOverwrite ) {
			$fileName = "{$this->dest}/" . $this->getHashedFilename( $title );
			if ( file_exists( $fileName ) ) {
				return;
			}
		}

		if ( $this->showTitles ) {
			print $title->getPrefixedDBkey() . "\n";
		}

		$this->profile();

		$this->rawPages = array();
		$text = $this->getArticleHTML( $title );

		if ( $text === false ) {
			return;
		}

		# Parse the XHTML to find the images
		#$images = $this->findImages( $text );
		#$this->copyImages( $images );

		# Write to file
		$this->writeArticle( $title, $text );

		# Do raw pages
		$this->mkdir( "{$this->dest}/raw", 0755 );
		foreach( $this->rawPages as $record ) {
			list( $file, $title, $params ) = $record;

			$path = "{$this->dest}/raw/$file";
			if ( !file_exists( $path ) ) {
				$article = new Article( $title );
				$request = new FauxRequest( $params );
				$rp = new RawPage( $article, $request );
				$text = $rp->getRawText();

				print "Writing $file\n";
				$file = fopen( $path, 'w' );
				if ( !$file ) {
					print("Can't open file $path for writing\n");
					continue;
				}
				fwrite( $file, $text );
				fclose( $file );
			}
		}

		wfIncrStats( 'dumphtml_article' );
	}

	/** Write the given text to the file identified by the given title object */
	function writeArticle( $title, $text ) {
		wfProfileIn( __METHOD__ );
		$filename = $this->getHashedFilename( $title );

		# Temporary hack for current dump, this should be moved to 
		# getFriendlyName() at the earliest opportunity.
		#
		# Limit filename length to 255 characters, so it works on ext3.
		# Titles are in fact limited to 255 characters, but dumpHTML 
		# adds a suffix which may put them over the limit.
		$length = strlen( $filename );
		if ( $length > 255 ) {
			print "Warning: Filename too long ($length bytes). Skipping.\n";
			wfProfileOut( __METHOD__ );
			return;
		}
			
		$fullName = "{$this->dest}/$filename";
		$fullDir = dirname( $fullName );

		if ( $this->compress ) {
			$fullName .= ".gz";
			$text = gzencode( $text, 9 );				
		}

		if ( preg_match( '/[\x80-\xFF]/', $fullName ) && wfIsWindows() ) {
			# Work around PHP unicode bug
			$rand = mt_rand( 0, 99999999 );
			$fullDir = str_replace( '/', '\\', $fullDir );
			$fullName = str_replace( '/', '\\', $fullName );
			$tempName = "{$this->dest}\\temp\\TEMP-$rand";

			$success = file_put_contents( $tempName, $text );
			if ( $success ) {
				wfShellExec( "cscript /nologo " . wfEscapeShellArg( 
					dirname( __FILE__ ) . "\\rename-hack.vbs",
					$this->escapeForVBScript( $tempName ),
					$this->escapeForVBScript( $fullName ) ) );
			}
		} else {
			if ( !$this->mkdir( $fullDir ) ) {
				print "Error: unable to create directory '$fullDir'.\n";
			}
			#wfSuppressWarnings();
			$success = file_put_contents( $fullName, $text );
			#wfRestoreWarnings();
		}

		if ( !$success ) {
			die("Can't open file '$fullName' for writing.\nCheck permissions or use another destination (-d).\n");
		}
		wfProfileOut( __METHOD__ );
	}

	/** Escape a UTF-8 string for VBScript's Unescape() */
	function escapeForVBScript( $in ) {
		$utf16 = iconv( 'UTF-8', 'UTF-16BE', $in );
		$out = '';
		for ( $i = 0; $i < strlen( $utf16 ); $i += 2 ) {
			$codepoint = ord( $utf16[$i] ) * 256 + ord( $utf16[$i+1] );
			if ( $codepoint < 128 && $codepoint >= 32 ) {
				$out .= chr( $codepoint );
			} else {
				$out .= sprintf( "%%u%04X", $codepoint );
			}
		}
		return $out;
	}

	/** Copy a directory recursively, not including .svn */
	function copyDirectory( $source, $dest ) {
		if ( !is_dir( $dest ) ) {
			if ( !mkdir( $dest ) ) {
				echo "Warning: unable to create directory \"$dest\"\n";
				return false;
			}
		}
		$dir = opendir( $source );
		if ( !$dir ) {
			echo "Warning: unable to open directory \"$source\"\n";
			return false;
		}
		while ( false !== ( $fileName = readdir( $dir ) ) ) {
			if ( substr( $fileName, 0, 1 ) == '.' ) {
				continue;
			}
			$currentSource = "$source/$fileName";
			$currentDest = "$dest/$fileName";
			if ( is_dir( $currentSource ) ) {
				$this->copyDirectory( $currentSource, $currentDest );
			} elseif ( is_file( $currentSource ) ) {
				copy( $currentSource, $currentDest );
			}
		}
		return true;
	}

	/** Set up the destination directory */
	function setupDestDir() {
		global $IP;

		if ( is_dir( $this->dest ) ) {
			echo "WARNING: destination directory already exists, skipping initialisation\n";
			return;
		}
		echo "Initialising destination directory...\n";
		if ( !$this->mkdir( "{$this->dest}/skins" ) ) {
			throw new MWException( "Unable to create destination directory." );
		}

		file_put_contents( "{$this->dest}/dumpHTML.version", self::VERSION );
		$this->copyDirectory( "$IP/skins/monobook", "{$this->dest}/skins/monobook" );
		$this->copyDirectory( "$IP/skins/common", "{$this->dest}/skins/common" );
		$this->copyDirectory( "{$this->extdir}/skin", "{$this->dest}/skins/offline" );
	}

	/** Create a file repo group which is a proxy of an old one */
	function newRepoGroup( $old ) {
		return new DumpHTML_ProxyRepoGroup( $this, $old );
	}

	/** Set up globals required for parsing */
	function setupGlobals( $currentDepth = NULL ) {
		global $wgUser, $wgStylePath, $wgArticlePath, $wgMathPath;
		global $wgUploadPath, $wgLogo, $wgMaxCredits, $wgScriptPath;
		global $wgHideInterlanguageLinks, $wgUploadDirectory, $wgThumbnailScriptPath;
		global $wgEnableParserCache, $wgHooks, $wgServer;
		global $wgRightsUrl, $wgRightsText, $wgCopyrightIcon, $wgEnableSidebarCache;
		global $wgGenerateThumbnailOnParse, $wgValidSkinNames, $wgFavicon;
		global $wgDisableCounters;

		if ( !$this->setupDone ) {
			$wgHooks['GetLocalURL'][] =& $this;
			$wgHooks['GetFullURL'][] =& $this;
			$wgHooks['SiteNoticeBefore'][] =& $this;
			$wgHooks['SiteNoticeAfter'][] =& $this;
			$this->oldArticlePath = $wgServer . $wgArticlePath;
			$this->oldLogo = $wgLogo;
			$this->oldRepoGroup = RepoGroup::singleton();
			$this->oldCopyrightIcon = $wgCopyrightIcon;
			$this->oldScriptPath = $wgScriptPath;
			$this->oldFavicon = $wgFavicon;
			$wgValidSkinNames['offline'] = 'Offline';
		}

		if ( is_null( $currentDepth ) ) {
			$currentDepth = $this->depth;
		}

		if ( $this->alternateScriptPath ) {
			if ( $currentDepth == 0 ) {
				$wgScriptPath = '.';
			} else {
				$wgScriptPath = '../..' . str_repeat( '/..', $currentDepth - 1 );
			}
		} else {
			if ( $currentDepth == 0 ) {
				$wgScriptPath = '..' . str_repeat( '/..', $currentDepth );
			} else {
				$wgScriptPath = '../..' . str_repeat( '/..', $currentDepth );
			}
		}

		if ( $currentDepth == 0 ) {
			$wgArticlePath = '$1';
			$this->articleBaseUrl = '.';
		} else {
			$this->articleBaseUrl = '..' . str_repeat( '/..', $currentDepth );
			$wgArticlePath = str_repeat( '../', $currentDepth + 1 ) . '$1';
		}

		$uploadBits = explode( '/', str_replace( '\\', '/', $wgUploadPath ) );
		$this->imageRel = $uploadBits[count($uploadBits) - 1];
		if ( !in_array( $this->imageRel, array( 'images', 'upload' ) ) ) {
			$this->imageRel = 'images';
		}

		$wgStylePath = "{$this->articleBaseUrl}/skins";


		if ( $this->makeSnapshot ) {
			$this->destUploadUrl = "{$this->articleBaseUrl}/{$this->imageRel}";
		} else {
			$this->destUploadUrl = "$wgScriptPath/{$this->imageRel}";
		}
		$wgUploadPath = $this->destUploadUrl; // For BC
		$wgMaxCredits = -1;
		$wgHideInterlanguageLinks = !$this->interwiki;
		$wgThumbnailScriptPath = false;
		$wgEnableParserCache = false;
		$wgMathPath = "$wgScriptPath/math";
		$wgEnableSidebarCache = false;
		$wgGenerateThumbnailOnParse = true;
		$wgDisableCounters = true;

		if ( !empty( $wgRightsText ) ) {
			$wgRightsUrl = "$wgScriptPath/COPYING.html";
		}

		$wgUser = User::newFromName( '__dumpHTML', false );
		$wgUser->setOption( 'skin', $this->skin );
		$wgUser->setOption( 'editsection', 0 );
		if ( $this->group ) {
			$groups = explode( ',', $this->group );
			foreach ( $groups as $group ) {
				$wgUser->addGroup( $group );
			}
			if ( !$wgUser->isAllowed( 'read' ) ) {
				print "The specified user group is not allowed to read\n";
				exit( 1 );
			}
		} elseif ( !$wgUser->isAllowed( 'read' ) ) {
			print "Default users are not allowed to read, please specify a --group option, e.g. --group=sysop\n";
			exit( 1 );
		}

		if ( $this->makeSnapshot ) {
			$this->destUploadDirectory = "{$this->dest}/{$this->imageRel}";
			if ( realpath( $this->destUploadDirectory ) == realpath( $wgUploadDirectory ) ) {
				print "Disabling image snapshot because the destination is the same as the source\n";
				$this->makeSnapshot = false;
				$this->destUploadDirectory = false;
			}
		} else {
			$this->destUploadDirectory = false;
		}

		$newRepoGroup = $this->newRepoGroup( $this->oldRepoGroup );
		RepoGroup::setSingleton( $newRepoGroup );

		# Make a snapshot of the logo image and copyright icon
		$wgLogo = $this->makeUrlSnapshot( $this->oldLogo );
		if ( preg_match( '/<img [^>]*src="([^"]*)"/', $this->oldCopyrightIcon, $m ) ) {
			$urlText = $m[1];
			$url = Sanitizer::decodeCharReferences( $urlText );
			$url = $this->makeUrlSnapshot( $url );
			$wgCopyrightIcon = str_replace( $urlText, htmlspecialchars( $url ), $this->oldCopyrightIcon);
		}

		# Make a snapshot of the favicon
		$wgFavicon = $this->makeUrlSnapshot( $this->oldFavicon );

		$this->setupDone = true;
	}

	/**
	 * Make a copy of a URL in the destination directory, and return the new relative URL
	 */
	function makeUrlSnapshot( $url ) {
		global $wgServer;
		$this->mkdir( "{$this->dest}/misc" );
		$destName = urldecode( basename( $url ) );
		$destPath = "{$this->dest}/misc/$destName";
		if ( !file_exists( $destPath ) ) {
			if ( !preg_match( '/^https?:/', $url ) ) {
				$url = $wgServer . $url;
			}
			$contents = Http::get( $url );
			file_put_contents( $destPath, $contents );
		}
		return "{$this->articleBaseUrl}/misc/" . urlencode( $destName );
	}

	/** Reads the content of a title object, executes the skin and captures the result */
	function getArticleHTML( $title ) {
		global $wgOut, $wgTitle, $wgArticle, $wgUser;

		$linkCache =& LinkCache::singleton();
		$linkCache->clear();
		$wgTitle = $title;
		if ( is_null( $wgTitle ) ) {
			return false;
		}

		$ns = $wgTitle->getNamespace();
		if ( $ns == NS_SPECIAL ) {
			$wgOut = new OutputPage;
			$wgOut->setParserOptions( new ParserOptions );
			SpecialPage::executePath( $wgTitle );
		} else {
			/** @todo merge with Wiki.php code */
			if ( $ns == NS_IMAGE ) {
				$wgArticle = new ImagePage( $wgTitle );
			} elseif ( $ns == NS_CATEGORY ) {
				$wgArticle = new CategoryPage( $wgTitle );
			} else {
				$wgArticle = new Article( $wgTitle );
			}
			$rt = Title::newFromRedirect( $wgArticle->fetchContent() );
			if ( $rt != NULL ) {
				return $this->getRedirect( $rt );
			} else {
				$wgOut = new OutputPage;
				$wgOut->setParserOptions( new ParserOptions );

				$wgArticle->view();
			}
		}

	
		$sk =& $wgUser->getSkin();
		ob_start();
		$sk->outputPage( $wgOut );
		$text = ob_get_contents();
		ob_end_clean();

		return $text;
	}

	function getRedirect( $rt ) {
		$url = $rt->escapeLocalURL();
		$text = $rt->getPrefixedText();
		return <<<ENDTEXT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="Refresh" content="0;url=$url" />
</head>
<body>
  <p>Redirecting to <a href="$url">$text</a></p>
</body>
</html>
ENDTEXT;
	}

	/** Returns image paths used in an XHTML document */
	function findImages( $text ) {
		global $wgOutputEncoding, $wgDumpImages;
		$parser = xml_parser_create( $wgOutputEncoding );
		xml_set_element_handler( $parser, 'wfDumpStartTagHandler', 'wfDumpEndTagHandler' );

		$wgDumpImages = array();
		xml_parse( $parser, $text );
		xml_parser_free( $parser );

		return $wgDumpImages;
	}

	/**
	 * Returns true if the path exists, false otherwise
	 * PHP's file_exists() returns false for broken symlinks, this returns true.
	 */
	function pathExists( $path ) {
		wfSuppressWarnings();
		$exists = (bool)lstat( $path );
		wfRestoreWarnings();
		return $exists;
	}

	/**
	 * Copy a file specified by a URL to a given directory
	 * 
	 * @param string $srcPath The source URL
	 * @param string $srcPathBase The base directory of the source URL
	 * @param string $srcDirBase The base filesystem directory of the source URL
	 * @param string $destDirBase The base filesystem directory of the destination URL
	 */
	function relativeCopy( $srcPath, $srcPathBase, $srcDirBase, $destDirBase ) {
		$rel = substr( $srcPath, strlen( $srcPathBase ) + 1 ); // +1 for slash
		$sourceLoc = "$srcDirBase/$rel";
		$destLoc = "$destDirBase/$rel";
		#print "Copying $sourceLoc to $destLoc\n";
		if ( !$this->pathExists( $destLoc ) ) {
			$this->mkdir( dirname( $destLoc ), 0755 );
			if ( function_exists( 'symlink' ) && !$this->forceCopy ) {
				if ( !symlink( $sourceLoc, $destLoc ) ) {
					print "Warning: unable to create symlink at $destLoc\n";
				}
			} else {
				if ( !copy( $sourceLoc, $destLoc ) ) {
					print "Warning: unable to copy $sourceLoc to $destLoc\n";
				}
			}
		}
	}

	/**
	 * Copy an image, and if it is a thumbnail, copy its parent image too
	 */
	function copyImage( $srcPath, $srcPathBase, $srcDirBase, $destDirBase ) {
		$this->relativeCopy( $srcPath, $srcPathBase, $srcDirBase, $destDirBase );
		if ( substr( $srcPath, strlen( $srcPathBase ) + 1, 6 ) == 'thumb/' ) {
			# The image was a thumbnail
			# Copy the source image as well
			$rel = substr( $srcPath, strlen( $srcPathBase ) + 1 );
			$parts = explode( '/', $rel );
			$rel = "{$parts[1]}/{$parts[2]}/{$parts[3]}";
			$newSrc = "$srcPathBase/$rel";
			$this->relativeCopy( $newSrc, $srcPathBase, $srcDirBase, $destDirBase );
		}
	}
	
	/**
	 * Copy images (or create symlinks) from commons to a static directory.
	 * This is necessary even if you intend to distribute all of commons, because
	 * the directory contents is used to work out which image description pages
	 * are needed.
	 *
	 * Also copies math images, and full-sized images if the makeSnapshot option 
	 * is specified.
	 *
	 */
	function copyImages( $images ) {
		global $wgUploadPath, $wgUploadDirectory, $wgMathPath, $wgMathDirectory;
		# Find shared uploads and copy them into the static directory
		$mathPathLength = strlen( $wgMathPath );
		$uploadPathLength = strlen( $wgUploadPath );
		foreach ( $images as $escapedImage => $dummy ) {
			$image = urldecode( $escapedImage );

			if ( substr( $image, 0, $mathPathLength ) == $wgMathPath ) {
				$this->relativeCopy( $image, $wgMathPath, $wgMathDirectory, "{$this->dest}/math" );
			} elseif ( $this->makeSnapshot && substr( $image, 0, $uploadPathLength ) == $wgUploadPath ) {
				$this->copyImage( $image, $wgUploadPath, $wgUploadDirectory, $this->destUploadDirectory );
			}
		}
	}

	function onGetFullURL( &$title, &$url, $query ) {
		global $wgContLang, $wgArticlePath;

		$iw = $title->getInterwiki();
		if ( $title->isExternal() && $wgContLang->getLanguageName( $iw ) ) {
			if ( $title->getDBkey() == '' ) {
				$url = str_replace( '$1', "../$iw/index.html", $wgArticlePath );
			} else {
				$url = str_replace( '$1', "../$iw/" . wfUrlencode( $this->getHashedFilename( $title ) ),
					$wgArticlePath );
			}
			$url .= $this->compress ? ".gz" : "";
			return false;
		} else {
			return true;
		}
	}

	function onGetLocalURL( &$title, &$url, $query ) {
		global $wgArticlePath;

		if ( $title->isExternal() ) {
			# Default is fine for interwiki
			return true;
		}

		$url = false;
		if ( $query != '' ) {
			$params = array();
			parse_str( $query, $params );
			if ( isset($params['action']) && $params['action'] == 'raw' ) {
				if ( $params['gen'] == 'css' || $params['gen'] == 'js' ) {
					$file = 'gen.' . $params['gen'];
				} else {
					$file = $this->getFriendlyName( $title->getPrefixedDBkey() );
					// Clean up Monobook.css etc.
					$matches = array();
					if ( preg_match( '/^(.*)\.(css|js)_[0-9a-f]{4}$/', $file, $matches ) ) {
						$file = $matches[1] . '.' . $matches[2];
					}
				}
				$this->rawPages[$file] = array( $file, $title, $params );
				$url = str_replace( '$1', "raw/" . wfUrlencode( $file ), $wgArticlePath );
			}
		}
		if ( $url === false ) {
			$url = str_replace( '$1', wfUrlencode( $this->getHashedFilename( $title ) ), $wgArticlePath );
		}
		$url .= $this->compress ? ".gz" : "";
		return false;
	}

	function getHashedFilename( &$title ) {
		if ( !$title ) {
			throw new MWException( 'Invalid $title parameter to '.__METHOD__ );
		}
		if ( '' != $title->mInterwiki ) {
			$dbkey = $title->getDBkey();
		} else {
			$dbkey = $title->getPrefixedDBkey();
		}

		$mainPage = Title::newMainPage();
		if ( $mainPage->getPrefixedDBkey() == $dbkey ) {
			return 'index.html';
		}

		return 'articles/' . $this->getHashedDirectory( $title ) . '/' .
			$this->getFriendlyName( $dbkey ) . '.html';
	}

	function getFriendlyName( $name ) {
		global $wgLang;
		# Replace illegal characters for Windows paths with underscores
		$friendlyName = strtr( $name, '/\\*?"<>|~', '_________' );

		# Work out lower case form. We assume we're on a system with case-insensitive
		# filenames, so unless the case is of a special form, we have to disambiguate
		if ( function_exists( 'mb_strtolower' ) ) {
			$lowerCase = $wgLang->ucfirst( mb_strtolower( $name ) );
		} else {
			$lowerCase = ucfirst( strtolower( $name ) );
		}

		# Make it mostly unique
		if ( $lowerCase != $friendlyName  ) {
			$friendlyName .= '_' . substr(md5( $name ), 0, 4);
		}
		# Handle colon specially by replacing it with tilde
		# Thus we reduce the number of paths with hashes appended
		$friendlyName = str_replace( ':', '~', $friendlyName );

		return $friendlyName;
	}

	/**
	 * Get a relative directory for putting a title into
	 */
	function getHashedDirectory( &$title ) {
		if ( '' != $title->getInterwiki() ) {
			$pdbk = $title->getDBkey();
		} else {
			$pdbk = $title->getPrefixedDBkey();
		}

		# Find the first colon if there is one, use characters after it
		$p = strpos( $pdbk, ':' );
		if ( $p !== false ) {
			$dbk = substr( $pdbk, $p + 1 );
			$dbk = substr( $dbk, strspn( $dbk, '_' ) );
		} else {
			$dbk = $pdbk;
		}

		# Split into characters
		$m = array();
		preg_match_all( '/./us', $dbk, $m );

		$chars = $m[0];
		$length = count( $chars );
		$dir = '';

		for ( $i = 0; $i < $this->depth; $i++ ) {
			if ( $i ) {
				$dir .= '/';
			}
			if ( $i >= $length ) {
				$dir .= '_';
			} else {
				$c = $chars[$i];
				if ( ord( $c ) >= 128 || preg_match( '/[a-zA-Z0-9!#$%&()+,[\]^_`{}-]/', $c ) ) {
					if ( function_exists( 'mb_strtolower' ) ) {
						$dir .= mb_strtolower( $c );
					} else {
						$dir .= strtolower( $c );
					}
				} else {
					$dir .= sprintf( "%02X", ord( $c ) );
				}
			}
		}
		return $dir;
	}

	/**
	 * Calculate the start end end of a job based on the current slice
	 * @param integer $start
	 * @param integer $end
	 * @return array of integers
	 */
	function sliceRange( $start, $end ) {
		$count = $end - $start + 1;
		$each = $count / $this->sliceDenominator;
		$sliceStart = $start + intval( $each * ( $this->sliceNumerator - 1 ) );
		if ( $this->sliceNumerator == $this->sliceDenominator ) {
			$sliceEnd = $end;
		} else {
			$sliceEnd = $start + intval( $each * $this->sliceNumerator ) - 1;
		}
		return array( $sliceStart, $sliceEnd );
	}

	/**
	 * Adjust a start point so that it belongs to the current slice, where slices are defined by integer modulo
	 * @param integer $start
	 * @param integer $base The true start of the range; the minimum start
	 */
	function modSliceStart( $start, $base = 1 ) {
		return ( $start - $base ) - ( ( $start - $base ) % $this->sliceDenominator ) + $this->sliceNumerator - 1 + $base;
	}

	/**
	 * Determine whether a string belongs to the current slice, based on hash
	 */
	function sliceFilter( $s ) {
		return crc32( $s ) % $this->sliceDenominator == $this->sliceNumerator - 1;
	}

	/**
	 * No site notice
	 */
	function onSiteNoticeBefore( &$text ) {
		$text = '';
		return false;
	}
	function onSiteNoticeAfter( &$text ) {
		$text = '';
		return false;
	}

	function getMaxPageID() {
		if ( $this->maxPageID === false ) {
			$dbr = wfGetDB( DB_SLAVE );
			$this->maxPageID = $dbr->selectField( 'page', 'max(page_id)', false, __METHOD__ );
		}
		return $this->maxPageID;
	}

	function profile() {
		global $wgProfiler, $wgRequestTime, $wgRUstart;

		if ( !$this->udpProfile ) {
			return;
		}
		if ( !$this->udpProfileInit ) {
			$this->udpProfileInit = true;
			$this->udpProfileCounter = 0;
		} elseif ( $this->udpProfileCounter == 1 % $this->udpProfile ) {
			wfProfileOut( '-total' );
			$wgProfiler->getFunctionReport();
			$wgProfiler = new DumpHTML_ProfilerStub;
		}
		if ( $this->udpProfileCounter == 0 ) {
			$wgProfiler = new ProfilerSimpleUDP;
			$wgProfiler->setProfileID( 'dumpHTML' );
			$wgRequestTime = microtime( true );
			$wgRUstart = getrusage();
			wfProfileIn( '-total' );
		}
		$this->udpProfileCounter = ( $this->udpProfileCounter + 1 ) % $this->udpProfile;
	}

	function debug( $text ) {
		print "$text\n";
	}
	
	function mkdir( $dir ) {
		//if ( wfIsWindows() ) {
			return wfMkdirParents( $dir, 0755 );
		/*} else {
			$dir = escapeshellarg( $dir );
			`mkdir -p -- $dir`;
			return true;
		}*/
	}
}

class DumpHTML_ProfilerStub {
	function profileIn() {}
	function profileOut() {}
	function getOutput() {}
	function close() {}
	function getFunctionReport() {}
	function getCurrentSection() { return '';}
}

class DumpHTML_ProxyRepoGroup extends RepoGroup {
	var $dump, $backendRG;

	function __construct( $dump, $backendRG ) {
		$this->dump = $dump;
		$this->backendRG = $backendRG;
		$backendRG->initialiseRepos();

		if ( count( $backendRG->foreignRepos ) ) {
			$localDest = "{$this->dump->destUploadDirectory}/local";
			$localUrl = "{$this->dump->destUploadUrl}/local";
		} else {
			$localDest = $this->dump->destUploadDirectory;
			$localUrl = $this->dump->destUploadUrl;
		}
		if ( !$dump->makeSnapshot ) {
			$localDest = false;
		}
		$this->reposInitialised = true;
		$this->localRepo = new DumpHTML_ProxyRepo( $backendRG->getLocalRepo(), $dump, $localDest, $localUrl );
		$this->foreignRepos = array();
		foreach ( $backendRG->foreignRepos as $index => $repo ) {
			$friendlyName = strtr( $repo->getName(), array( '/. ', '___' ) );
			if ( !$dump->makeSnapshot ) {
				$foreignDest = false;
			} else {
				$foreignDest = "{$dump->destUploadDirectory}/$friendlyName";
			}
			$this->foreignRepos[] = new DumpHTML_ProxyRepo( $repo, $dump, $foreignDest, 
				$dump->destUploadUrl . '/' . urlencode( $friendlyName ) );
		}
	}
}

class DumpHTML_ProxyRepo {
	function __construct( $backend, $dump, $directory, $url ) {
		$this->backend = $backend;
		$this->dump = $dump;
		$this->directory = $directory;
		$this->url = $url;
		$this->name = $backend->getName();
		$this->backend->thumbScriptUrl = false;
		$this->backend->transformVia404 = false;
		$this->backendUrl = $backend->getZoneUrl( 'public' );
	}

	function __call( $name, $args ) {
		return call_user_func_array( array( $this->backend, $name ), $args );
	}

	function newFile( $title, $time = false) {
		$file = $this->backend->newFile( $title, $time );
		if ( $file ) {
			$file = new DumpHTML_ProxyFile( $file, $this );
			$file->copyToDump();
		}
		return $file;
	}

	function findFile( $title, $time = false ) {
		$file = $this->backend->findFile( $title, $time );
		if ( $file ) {
			$file = new DumpHTML_ProxyFile( $file, $this );
			$file->copyToDump();
		}
		return $file;
	}

	function copyToDump( $rel ) {
		if ( !$this->dump->makeSnapshot ) {
			return;
		}

		if ( is_callable( array( $this->backend, 'getZonePath' ) ) ) {
			$sourceBase = $this->backend->getZonePath( 'public' );
		} elseif ( is_callable( array( $this->backend, 'getZoneUrl' ) ) ) {
			$sourceBase = false;
			$sourceBaseUrl = $this->backend->getZoneUrl( 'public' );
		} else {
			$sourceBase = false;
			$sourceBaseUrl = false;
		}

		$dest = "{$this->directory}/$rel";

		if ( $this->dump->pathExists( $dest ) ) {
			return;
		}

		if ( $sourceBase !== false ) {
			$source = "$sourceBase/$rel";
			if ( !file_exists( $source ) ) {
				// Hopefully we'll get another go at it later
				return;
			}
			if ( !is_dir( dirname( $dest ) ) ) {
				$this->dump->mkdir( dirname( $dest ) );
			}

			#$this->dump->debug( "Copying $source to $dest" );
			if ( function_exists( 'symlink' ) && !$this->dump->forceCopy ) {
				if ( !symlink( $source, $dest ) ) {
					$this->dump->debug( "Warning: unable to create symlink at $dest" );
				}
			} else {
				if ( !copy( $source, $dest ) ) {
					$this->dump->debug( "Warning: unable to copy $source to $dest" );
				}
			}
		} elseif ( $sourceBaseUrl !== false ) {
			$urlRel = implode( '/', array_map( 'rawurlencode', explode( '/', $rel ) ) );
			$sourceUrl = $sourceBaseUrl . '/' . $urlRel;
			$contents = Http::get( $sourceUrl );
			if ( $contents === false ) {
				$this->dump->debug( "Unable to get contents of file from $sourceUrl" );
			} else {
				if ( !file_put_contents( $dest, $contents ) ) {
					$this->debug( "Unable to write to $dest" );
				}
			}
		} // else give up
	}
}

class DumpHTML_ProxyFile {
	function __construct( $backend, $repo ) {
		$this->backend = $backend;
		$this->repo = $repo;
		$this->dump = $repo->dump;
	}

	function __call( $name, $args ) {
		$callback = array( $this->backend, $name );
		if ( !is_callable( $callback ) ) {
			throw new MWException( "Attempt to call invalid function LocalFile::$name\n" );
		}
		$result = call_user_func_array( array( $this->backend, $name ), $args );
		if ( is_string( $result ) ) {
			$result = $this->fixURL( $result );
		} elseif ( $result instanceof MediaTransformOutput ) { 
			$result = $this->fixMTO( $result );
		}
		return $result;
	}

	function getUrl() {
		return $this->repo->url . '/' . $this->backend->getUrlRel();
	}

	public function getFullURL() {
		return $this->getUrl();
	}

	function fixURL( $url ) {
		if ( is_string( $url ) && substr( $url, 0, strlen( $this->repo->backendUrl ) ) == $this->repo->backendUrl ) {
			$rel = substr( $url, strlen( $this->repo->backendUrl ) + 1 );
			$rel = implode('/', array_map( 'rawurldecode', explode( '/', $rel ) ) );
			$this->repo->copyToDump( $rel );
			$newUrl = $this->repo->url . '/' . $rel;
			$url = $newUrl;
		}
		return $url;
	}

	function fixMTO( $thumb ) {
		// FIXME: accessing private members, needs MTO::setUrl()
		if ( isset( $thumb->url ) ) {
			$thumb->url = $this->fixURL( $thumb->url );
		}
		return $thumb;
	}

	function copyToDump() {
		if ( !$this->dump->makeSnapshot ) {
			return;
		}

		$source = $this->backend->getPath();
		$dest = $this->repo->directory . '/' . $this->backend->getRel();

		if ( $this->dump->pathExists( $dest ) ) {
			return;
		}

		#$this->dump->debug ( "Copying $source to $dest\n" );
		if ( $source === false ) {
			$sourceUrl = $this->backend->getUrl();
			$contents = Http::get( $sourceUrl );
			if ( $contents === false ) {
				$this->dump->debug( "Unable to get contents of file from $sourceUrl" );
			} else {
				if ( !file_put_contents( $dest, $contents ) ) {
					$this->debug( "Unable to write to $dest" );
				}
			}
		} else {
			if ( !is_dir( dirname( $dest ) ) ) {
				$this->dump->mkdir( dirname( $dest ) );
			}

			if ( function_exists( 'symlink' ) && !$this->dump->forceCopy ) {
				if ( !symlink( $source, $dest ) ) {
					$this->dump->debug( "Warning: unable to create symlink at $dest" );
				}
			} else {
				if ( !copy( $source, $dest ) ) {
					$this->dump->debug( "Warning: unable to copy $source to $dest" );
				}
			}
		}
	}
}


/** XML parser callback */
function wfDumpStartTagHandler( $parser, $name, $attribs ) {
	global $wgDumpImages;

	if ( $name == 'IMG' && isset( $attribs['SRC'] ) ) {
		$wgDumpImages[$attribs['SRC']] = true;
	}
}

/** XML parser callback */
function wfDumpEndTagHandler( $parser, $name ) {}

# vim: syn=php
?>
