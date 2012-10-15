<?php
/**
 * See mediawiki.org/wiki/Extension:GraphViz for more information
 *
 * Extension to allow Graphviz to work inside MediaWiki.
 * This Version is based on CoffMan's nice Graphviz Extension.
 *
 * Licence: http://www.gnu.org/copyleft/fdl.html
 *
 * Configuration
 *
 *  These settings can be overwritten in LocalSettings.php.
 *  Configuration must be done AFTER including this extension using
 *  require("extensions/Graphviz.php");
 *
 * $wgGraphVizSettings->execPath
 *	Describes where your actual (dot) executable remains.
 *
 *	Windows Default: C:/Programme/ATT/Graphviz/bin/
 *	Other Platform : /usr/local/bin/dot
 *
 * $wgGraphVizSettings->mscgenPath
 *			Describes where your actual mscgen-executable remains
 *
 * $wgGraphVizSettings->named
 *	Describes the way graph-files are named.
 *
 *	named: name of your graph and its type determine its filename
 *	md5  : name of your graph is based on a md5 hash of its source.
 *	sha1 : name of your graph is based on a SHA1 hash of its source.
 *
 *	Default : named
 *
 * $wgGraphVizSettings->install
 *	Gets you an errormessage if something fails, but maybe ruins your
 *	wiki's look. This message is in English, always.
 *
 *	Default : false (not really implemented yet)
 *
 * Features
 * - normally selects defaults for Windows or Unix-like automatically.
 * - should run out of the box
 * - Creates png (or maybe other image) + MAP File
 * - additional storage modes (see discussion below)
 *   - Meaningful filename
 *   - Hash based filename
 *   - Configurable (name/md5/sha1)
 *
 * Storage Modes:
 * MD5:
 * + don't worry about graphnames
 * + pretty fast hash
 * - permanent cleanup necesary (manually or scripted)
 * - md5 is buggy - possibility that 2 graphs have the same hash but
 *   are not the same
 * SHA1:
 * + don't worry about graphnames
 * + no hash-bug as md5
 * - permanent cleanup necessary (manually or scripted)
 * - not so fast as md5
 * Named:
 * + Graphs have a name, now it's used
 * + no permanent cleanup necessary.
 * - Naming Conflicts
 *   a) if you have multiple graphs of the same name in the same
 *	  article, you will only get 1 picture - independently if they're
 *			the same or not.
 *   b) possible naming conflicts in obscure cases (that should not happen)
 *	  Read code for possibilities / exploits
 *
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

define( 'GraphViz_VERSION', '0.9.1 alpha' );

/**
 * The GraphViz-Class with the essential settings
 */
class GraphVizSettings {
	public $execPath, $mscgenPath, $named; // Execution Parameters
	// public $uploadPath, $uploadDirectory; // where are the images/maps saved
	public $outputType, $imageFormatting; // produced image
	public $install, $info; // Information aboutfunctionality
	public $pruneEnabled, $pruneStrategy, $pruneValue, $pruneAmount; // Pruning Parameters
};


$wgGraphVizSettings = new GraphVizSettings(); // create new instance of GraphVizSettings

/**
 * Configuration of the graphviz instance
 * if parameters are overwritten in the LocalSettings.php nothing will be changed
 */

// Set execution path
if ( stristr( PHP_OS, 'WIN' ) && !stristr( PHP_OS, 'Darwin' ) ) {
	$wgGraphVizSettings->execPath = 'C:/Program Files/Graphviz/bin/'; // '/' will be converted to '\\' later on, so feel free how to write your path C:/ or C:\\
} else {
	$wgGraphVizSettings->execPath = '/usr/bin/'; //  common: '/usr/bin/'  '/usr/local/bin/' or (if set) '$DOT_PATH/'
}

// Set further default values for parameters
$wgGraphVizSettings->mscgenPath = '';  // installation path for mscgen-renderer
$wgGraphVizSettings->named = 'named'; // naming scheme for the maps/images
$wgGraphVizSettings->outputType = 'png'; // can be changed to gif, svg, ...
$wgGraphVizSettings->imageFormatting = 'false'; // Do we want to use border/position/... in comparison to the normal wiki images?
$wgGraphVizSettings->install = false; // Do not use on Linux ... it somewhere destroys the script // Do you want error messages displayed? This can ruin your layout
$wgGraphVizSettings->info = false; // Do you want additional info to your renders displayed?
$wgGraphVizSettings->pruneEnabled = false; // Do you want to prune?
$wgGraphVizSettings->pruneStrategy = 'filenumber';	// pruning strategy to use
//  filesize - limit total size of files to amount of bytes
//  filenumber - limit total number of files

$wgGraphVizSettings->pruneValue = '10000';   // value to apply to 'pruneStrategy'
//  total file size (in bytes)
//  total number of files allowed

$wgGraphVizSettings->pruneAmount = '0.5';  // amount by which we prune
// Removes this fraction of the oldest files come prune time



/**
 * Media Wiki Plugin Stuff
 */

$wgHooks['ParserFirstCallInit'][] = 'wfGraphVizSetHook';

// Information about the people did this Parserhook
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Graphviz',
	'path' => __FILE__,
	'version' => GraphViz_VERSION,
	'author' => array(
		'[http://wickle.com CoffMan]',
		'[mailto://arno.venner@gmail.com MasterOfDesaster]',
		'[http://hummel-universe.net Thomas Hummel]'
		),
	'url' => 'https://www.mediawiki.org/wiki/Extension:GraphViz',
	'descriptionmsg' => 'graphviz-desc'
	);

	$wgExtensionMessagesFiles['GraphViz'] = dirname( __FILE__ ) . '/GraphViz.i18n.php';

	/**
	 * Information about the hooks used
	 */
	function wfGraphVizSetHook( $parser ) {
		$parser->setHook( 'graphviz', 'renderGraphviz' );
		$parser->setHook( 'mscgen', 'renderMscGen' );
		return true;
	}

	/**
	 * The renderingfunction for the mscgen-hook implementation
	 * @author Matthewpearson
	 */
	function renderMscGen( $timelinesrc, $args = null, $parser = null )
	{
		$args["renderer"] = "mscgen"; // set renderer to mscgen - not that nice, could be done better
		return renderEngine( $timelinesrc, $args, $parser ); // go to the "normal" rendering stuff
	}
	/**
	 * The renderingfunction for the graphviz-implementation
	 * @author Thomas Hummel
	 */
	function renderGraphviz( $timelinesrc, $args = null, $parser = null )	  // Raw Script data
	{

		if ( isset( $args["renderer"] ) ) {
			switch( $args["renderer"] ) {
				case 'circo':
				case 'dot':
				case 'fdp':
				case 'sfdp':
				case 'neato':
				case 'twopi':
					break;
				default:
					$args["renderer"] = 'dot';
			}
		} else {
			$args["renderer"] = "dot";
		}

		return renderEngine( $timelinesrc, $args, $parser ); // go to the "normal" rendering stuff

	}
	/**
	 * The actual renderingfunction for handling all the stuff
	 */
	function renderEngine( $timelinesrc, $args = null, $parser = null )	  // Raw Script data
	{

		global
		$wgTitle,
		$wgUploadDirectory,	  // Storage of the final image (e.g. png) & map
		$wgUploadPath,		   // HTML Reference
		$wgGraphVizSettings,	 // Plugin Config
		$info;										// some html-output for retracing what we did


		$info = "<h1>Graphviz Information</h1>";
		$info .= "<h2>Called render</h2>";

		/* Prepare Directories
		 */
		$dest = $wgUploadDirectory . "/graphviz/";
		if ( stristr( PHP_OS, 'WIN' ) && !stristr( PHP_OS, 'Darwin' ) ) {
			$dest = str_replace( "/", '\\', $dest ); // switch the slashes for windows
			$isWindows = true;
		} else {
			$isWindows = false;
		}
		if ( ! is_dir( $dest ) ) { mkdir( $dest, 0777 );} // create directory if it isn't there


		/* Start pruning  (if enabled) - use directory generated before
		 * prune before creating a new image so that it won't be pruned right after creation
		 */
		if ( $wgGraphVizSettings->pruneEnabled ) {
			prune( $dest,$wgGraphVizSettings->pruneStrategy,$wgGraphVizSettings->pruneValue,$wgGraphVizSettings->pruneAmount ); // prune the collection first
		}

		/* Check renderer - renderer should be set at least in renderMscgen or renderGraphviz but for security we check agaion and set some additional params
		 */
		if ( isset( $args['renderer'] ) ) {
			$renderer = $args['renderer'];
		} else {
			$renderer = 'dot';
		}

		switch( $renderer ) {
			case 'circo':
			case 'dot':
			case 'fdp':
			case 'sfdp':
			case 'neato':
			case 'twopi':
				$mapDashTOption = ' -Tcmapx ';
				$inputOption = '';
				break;
			case 'mscgen':
				if ( $wgGraphVizSettings->mscgenPath != null ) { // check if path to mscgen is set - if not use agaion graphviz with dot
					$inputOption = '-i ';
					$mapDashTOption = ' -T ismap ';
					$wgGraphVizSettings->execPath =$wgGraphVizSettings->mscgenPath; // not that nice but functional: overwrite execPath with the path to mscgen
				} else {
					$renderer = 'dot';
					$mapDashTOption = ' -Tcmapx ';
					$inputOption = '';
				}
				break;

			default:
				$renderer = 'dot';
				$mapDashTOption = ' -Tcmapx ';
				$inputOption = '';
		}

		/* create the command for graphviz or mscgen
		 */
		$cmd = $renderer;
		$cmd =$wgGraphVizSettings->execPath . $cmd; // example: /user/bin/dot
		if ( $isWindows ) {
			$cmd = $cmd . '.exe'; // executables in windows
		}

		$info .= "<pre>Dir=$dest</pre>";
		$info .= "<pre>execPath=" .$wgGraphVizSettings->execPath . "</pre>";
		$info .= "<pre>named=" .$wgGraphVizSettings->named . "</pre>";

		/* create actual storagename
		 */
		$wgGraphVizSettings->named = strtolower($wgGraphVizSettings->named );   // avoid problems with upper/lowercase

		/* get title name from parser. If parser not set, use $wgTitle instead
		 */
		if ($parser!=null){
			$title = $parser->getTitle()->getFulltext();
		} else{
			$title = $wgTitle->getFulltext();
		}

		$storagename = str_replace( "%", '_perc_', urlencode( $title ) ) . '---'; // clean up pagename (special chars etc)

		if ( $wgGraphVizSettings->named == 'md5' ) {
			$storagename = md5( $storagename . $timelinesrc );  // produce md5-hash out of the storagename !can be duplicate!
		} elseif ( $wgGraphVizSettings->named == 'sha1' ) {
			$storagename = sha1( $storagename . $timelinesrc );  // produce sha1-hash
		} else { // named == 'named'
			$storagename .=  str_replace( "%", '_perc_',
				urlencode( trim( str_replace( array( "\n", "\\" ), array( '', '/' ),
					substr( $timelinesrc, 0, strpos( $timelinesrc, '{' ) )  // extract the name of the graph out of the graph
				) ) )
			);
		}
		$info .= "<pre>storagename=" . $storagename . "</pre>";


		/* check if some outputtype is specified in the wikipage - else use the default value
		 */
		if ( isset( $args['format'] ) ) {
			$outputType = $args['format'];
		} else {
			$outputType =$wgGraphVizSettings->outputType;
		}



		/* inputcheck of supported image types
		 */
		if ( $renderer != 'mscgen' ) {
			// see supported types by graphviz itself (here only those that seem to be kind of useful) - http://www.graphviz.org/doc/info/output.html
			switch( $outputType ) {
				case 'bmp':
				case 'gif':
				case 'jpg':
				case 'jpeg':
				case 'png':
				case 'svg': // for svg you need extra MediaWiki configuration
				case 'svgz': // same as for svg
					// case 'tif':
					// case 'tiff':
					break;
				default:
					$outputType = 'png';
			}
		} else {
			// mscgen does only support png, svg and eps
			switch( $outputType ) {
				case 'png':
				case 'svg':
					break;
				default:
					$outputType = 'png';
			}
		}
		$info .= "<pre>outputType=" . $outputType . "</pre>";


		/* prepare the actual files
		 */
		$src = $dest . $storagename;	  // the raw input code - needed for the renderers - e.g. /graphviz/imagename (will be deleted later on)
		$imgn = $src . '.' . $outputType;  // the whole image name -  e.g. /graphviz/imagename.png
		$mapn = $src . '.map';			// the whole map name   - e.g. /graphviz/imagename.map


		$info .= '<pre>Src=' . $src . '</pre>';
		$info .= '<pre>imgn=' . $imgn . '</pre>';
		$info .= '<pre>mapn=' . $mapn . '</pre>';


		/* The actual commands for the rendering
		 * check first if we have to overwrite the file (if we don't use hashes) or if it already exists
		 */
		if ( $wgGraphVizSettings->named == 'named' || !( file_exists( $imgn ) || file_exists( $src . ".err" ) ) )
		{
			$timelinesrc = rewriteWikiUrls( $timelinesrc ); // if we use wiki-links we transform them to real urls

			// write the given dot-commands into a textfile
			$handle = fopen( $src, "w" );
			if ( ! $handle ) return 'Error writing graphviz file to disk.';
			$ret2 = fwrite( $handle, $timelinesrc );
			$ret3 = fclose( $handle );

			$info .= '<pre>Opened and closed $src, handle=' . $handle . ', timeelinesrc=' . $timelinesrc . ', ret2=' . $ret2 . ', ret3=' . $ret3 . '</pre>';

			// prepare the whole commands for image and map
			$cmdline	= wfEscapeShellArg( $cmd ) . ' -T ' . $outputType . '   -o ' . wfEscapeShellArg( $imgn ) . ' ' . $inputOption . wfEscapeShellArg( $src );
			$cmdlinemap = wfEscapeShellArg( $cmd ) . $mapDashTOption . '-o ' . wfEscapeShellArg( $mapn ) . ' ' . $inputOption . wfEscapeShellArg( $src );


			// run the commands
			if ( $isWindows ) {
				$WshShell = new COM( "WScript.Shell" );
				$ret = $WshShell->Exec( $cmdline );
				$retmap = $WshShell->Exec( $cmdlinemap );
			} else {
				$ret = shell_exec( $cmdline );
				$retmap = shell_exec( $cmdlinemap );
			}

			$info .= '<pre>Ran cmd line (image). ret=$ret cmdline=' . $cmdline . '</pre>';
			$info .= '<pre>Ran cmd line (map). ret=$ret cmdlinemap=' . $cmdlinemap . '</pre>';

			// Error messages for image-creation
			if ( $wgGraphVizSettings->install && $ret == "" ) {
				echo '<div id="toc"><tt>Timeline error: Executable not found.' .	  "\n" . 'Command line was: ' . $cmdline . '</tt></div>';
				$info .= '<div id="toc"><tt>Timeline error: Executable not found.' .	  "\n" . 'Command line was: ' . $cmdline . '</tt></div>';
				exit;
			}

			// Error messages for map-creation
			if ( $wgGraphVizSettings->install && $retmap == "" ) {
				echo '<div id="toc"><tt>Timeline error: Executable not found.' .   "\n" . 'Command line was: ' . $cmdlinemap . '</tt></div>';
				$info .= '<div id="toc"><tt>Timeline error: Executable not found.' .	  "\n" . 'Command line was: ' . $cmdlinemap . '</tt></div>';
				exit;
			}

			// let some other programs do their stuff
			if ( $isWindows ) {
				while ( $ret->Status == 0 || $retmap->Status == 0 ) {
					usleep( 100 );
				}
			}

			unlink( $src ); // delete the src right away
		}


		/* put the produced into the website
		 */
		@$err = file_get_contents( $src . ".err" );// not really used

		if ( $err != "" ) {
			$info .= '<div id="toc"><tt>' . $err . '</tt></div>'; // print error message
		} else {
			if ( false == ( $map = file_get_contents( $mapn ) ) ) {
				if ( $wgGraphVizSettings->install ) {
					echo '<div id="toc"><tt>File: ' . $mapn . ' is missing or empty.</tt></div>';
					$info .= '<div id="toc"><tt>File: ' . $mapn . ' is missing or empty.</tt></div>';
				}
			}

			// clean up map-name
			$map  = preg_replace( '#<ma(.*)>#', ' ', $map );
			$map  = str_replace( '</map>', '', $map );
			if ( $renderer == 'mscgen' ) {
				$mapbefore = $map;
				$map = preg_replace( '/(\w+)\s([_:%#/\w]+)\s(\d+,\d+)\s(\d+,\d+)/',
			   '<area shape="$1" href="$2" title="$2" alt="$2" coords="$3,$4" />',
				$map );
			}

			/* Procduce html
			 */
			if ( $wgGraphVizSettings->imageFormatting )
			{
				$txt = imageAtrributes( $args, $storagename, $map, $outputType, $wgUploadPath ); // if we want borders/position/...
			} else {
				$txt  = '<map name="' . $storagename . '">' . $map . '</map>' .
					 '<img src="' . $wgUploadPath . '/graphviz/' . $storagename . '.' . $outputType . '"' .
							   ' usemap="#' . $storagename . '" />';
			}



		}

		/* give it back to your wiki
		 */
		if ( $wgGraphVizSettings->info ) { $txt .= $info;} // do we want the information snipptes?
		return $txt;
	}


	function rewriteWikiUrls( &$source )
	{

		$line = preg_replace(
		'|\[\[([^]]+)\]\]|e',
		'Title::newFromText("$1")->getFullURL()',
		$source
		);
		return $line;
	}

	/**
	 * Prunes the repository of generated files
	 * @author Gregory Szorc <gregory.szorc@gmail.com>
	 * @author Thomas Hummel (modified only)
	 */
	function prune( $dest, $pruneStrategy, $pruneValue, $pruneAmount )
	{
		$pruneList = array(); // array of files that are prune candidates
		$pruneListSize = 0; // size (in bytes) of prunable files

		$directory = new DirectoryIterator( $dest );

		foreach ( $directory as $file ) {
			// only look for actual files
			if ( $file->isFile() ) {
				// only mark files with defined prefix as prune candidates
				$pruneList[$file->getPathname()] = $file->getMTime();
				$pruneListSize += $file->getSize();

			}
		}

		// so now we have our list of files

		$doPrune = false;

		// let's see if we actually need to prune
		if ( $pruneStrategy == 'filesize' ) {
			if ( $pruneListSize > $pruneValue ) {
				$doPrune = true;
			}
		} elseif ( $pruneStrategy == 'filenumber' ) {
			if ( count( $pruneList ) > $pruneValue ) {
				$doPrune = true;
			}
		} else {
			throw new MWException( 'Invalid prune strategy.  Please read the instructions: ' . $pruneStrategy );
		}

		if ( $doPrune ) {
			// sort the files in order of modification time
			asort( $pruneList, SORT_NUMERIC );

			$filesToDelete = array_slice( $pruneList, 0, (int)round( count( $pruneList ) * $pruneAmount ) );

			foreach ( array_keys( $filesToDelete ) as $file ) {
				unlink( $file );

			}
		}
	}

	/*//every time we create a new file, we run the pruning algorithm
	 //we prune first so that in case settings aren't sane, we don't prune what we create
	 self::prune(); //prune the collection first
	 */

	/**
	 * Image Attributes (orientated on MediaWiki-Syntax like here: http://en.wikipedia.org/wiki/Wikipedia:Extended_image_syntax)
	 * syntax is <graphviz attribute='value'>
	 * @author Thomas Hummel
	 */
	function imageAtrributes( $args = null, $storagename, $map, $outputType, $wgUploadPath )  {
		// Initialize Variables
		$varnames = array( "outerDivClass", "middleDivClass", "innerDivClass", "imageClass" );
		$varnames[] = "imageStyle";
		foreach ( $varnames as $varname )
		$$varname = '';

		// Caption that is put below the image (can be overwritten by Type)
		if ( isset( $args['caption'] ) ) { $caption = $args['caption'];}

		// Alt-Text for missing pictures, screenreaders, ... if not set use caption and at least default-String
		if ( isset( $args['alt'] ) ) { $alt = $args['alt'];
		} elseif ( isset( $args['caption'] ) ) { $alt = $args['caption'];
		} else { $alt = "This is a graph with borders and nodes. Maybe there is an Imagemap used so the nodes may be linking to some Pages.";
		}

		// For a border write <graphviz border='border'>
		if ( isset( $args['border'] ) ) {
			switch( $args['border'] ) {
				case 'frame':
				case 'border': $imageClass .= 'thumbborder'; break;
			}
		}

		// Location defining horizontal alignment
		if ( isset( $args['location'] ) ) {
			switch( $args['location'] ) {
				case 'left': $outerDivClass = 'floatleft'; break;
				case 'middle':
				case 'center': $outerDivClass = 'center'; $innerDivClass = 'floatnone'; break;
				case 'right': $outerDivClass = 'floatright'; break;
				case 'none': $outerDivClass = 'floatnone'; break;
			}
		}

		// Alignment for the vertical alignment
		if ( isset( $args['alignment'] ) ) {
			switch( $args['alignment'] ) {
				case 'baseline':
				case 'middle':
				case 'sub':
				case 'super':
				case 'text-top':
				case 'text-bottom':
				case 'top':
				case 'bottom':
					$imageStyle = 'vertical-align: ' . $args['alignment']; break;
			}
		}



		// Type:
		if ( isset( $args['type'] ) ) {
			switch( $args['type'] ) {
				case 'frame':
				case 'framed':  // little bug (optical): if you center a framed Graph there will be a border over the whole width of the wiki-page
					$middleDivClass = 'thumb';
					if ( $outerDivClass != null ) { $middleDivClass .= ' tnone';} else { $middleDivClass = 'tright';}
					$innerDivClass = 'thumbinner';
					$imageClass = 'thumbimage';
					$captionDivClass = 'thumbcaption';
					break;
				case 'thumb':
				case 'thumbnail':
					// Differences to the MediaWiki-Behaviour: No extra Thumbs are generated - the browser has to resize the image itself!
					// !!Please take into consideration that the mindmap will not fit to your smaller image!!
					$middleDivClass = 'thumb';
					if ( $outerDivClass != null ) { $middleDivClass .= ' tnone';} else { $middleDivClass = 'tright';}
					$innerDivClass = 'thumbinner" style="width:222px;';
					$imageClass = 'thumbimage" width="220px';
					$captionDivClass = 'thumbcaption';
					$caption .= ' <a href="' . $wgUploadPath . '/graphviz/' . $storagename . '.' . $outputType . '">(+)</a>';
					break;
				case 'frameless':
					$imageClass = '" width="220px';
				default: // nothing specified
					$caption = ''; // no caption as it is defined on the wiki page
			}
		} else {
			$caption = ''; // no caption as it is defined on the wiki page
		}

		// Produce the basic html
		$txt  = '<map name="' . $storagename . '">' . $map . '</map>' .
					 '<img class="' . $imageClass . '" style="' . $imageStyle . '"' .
					  'alt="' . $alt . '" src="' . $wgUploadPath . '/graphviz/' . $storagename . '.' . $outputType . '"' .
							   ' usemap="#' . $storagename . '" />';

		// Add necessary containers
		if ( $caption != null ) {
			$txt .= '<div class="' . $captionDivClass . '">' . $caption . '</div>';
		}
		if ( $innerDivClass != null ) {
			$txt = '<div class="' . $innerDivClass . '">' . $txt . '</div>';
		}
		if ( $middleDivClass != null ) {
			$txt = '<div class="' . $middleDivClass . '">' . $txt . '</div>';
		}
		if ( $outerDivClass != null ) {
			$txt = '<div class="' . $outerDivClass . '">' . $txt . '</div>';
		}

		return $txt;
	}

