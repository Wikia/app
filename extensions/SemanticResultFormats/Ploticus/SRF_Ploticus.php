<?php
/**
 * A query printer using Ploticus
 * loosely based on the Ploticus Extension by Flavien Scheurer
 * and CSV result printer
 * 
 * @note AUTOLOADED
 * @author Joel Natividad
 */

/**
 * Result printer using Ploticus to plot and process query results
 * TODO: Create expanded doxygen comments
 *
 * @ingroup SMWQuery
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

class SRFPloticus extends SMWResultPrinter {
	protected $m_ploticusparams = '';
	protected $m_imageformat = 'gif';
	protected $m_titletext = '';
	protected $m_showcsv = false;
	protected $m_ploticusmode = 'prefab';
	protected $m_debug = false;
	protected $m_liveupdating = true;
	protected $m_updatefrequency = 3600;  // by default, generate plot only once per hour
	protected $m_showtimestamp = false;
	protected $m_showrefresh = false;
	protected $m_showimagelink = false;
	protected $m_drawdumpoutput = '';
	protected $m_tblwidth = '';
	protected $m_tblheight = '';
	protected $m_width = '';
	protected $m_height = '';

	protected function readParameters($params, $outputmode) {
		SMWResultPrinter::readParameters($params, $outputmode);
		if (array_key_exists('ploticusparams', $this->m_params)) {
			$this->m_ploticusparams = trim($params['ploticusparams']);
		}
		if (array_key_exists('imageformat', $this->m_params)) {
			$this->m_imageformat = strtolower(trim($params['imageformat']));
		}
		if (array_key_exists('titletext', $this->m_params)) {
			$this->m_titletext = trim($params['titletext']);
		}
		if (array_key_exists('showcsv', $this->m_params)) {
			$tmpcmp = strtolower(trim($params['showcsv']));
			$this->m_showcsv =  $tmpcmp == 'false' || $tmpcmp == 'no' ? false : $tmpcmp;
		}
		if (array_key_exists('ploticusmode', $this->m_params)) {
			$this->m_ploticusmode =  strtolower(trim($params['ploticusmode']));
		}
		if (array_key_exists('debug', $this->m_params)) {
			$tmpcmp = strtolower(trim($params['debug']));
			$this->m_debug =  $tmpcmp == 'false' || $tmpcmp == 'no' ? false : $tmpcmp;
		}
		if (array_key_exists('liveupdating', $this->m_params)) {
			$tmpcmp = strtolower(trim($params['liveupdating']));
			$this->m_liveupdating =  $tmpcmp == 'false' || $tmpcmp == 'no' ? false : $tmpcmp;
		}
		if (array_key_exists('updatefrequency', $this->m_params)) {
			$this->m_updatefrequency = trim($params['updatefrequency']);
		}
		if (array_key_exists('showtimestamp', $this->m_params)) {
			$tmpcmp = strtolower(trim($params['showtimestamp']));
			$this->m_showtimestamp =  $tmpcmp == 'false' || $tmpcmp == 'no' ? false : $tmpcmp;
		}
		if (array_key_exists('showrefresh', $this->m_params)) {
			$tmpcmp = strtolower(trim($params['showrefresh']));
			$this->m_showrefresh =  $tmpcmp == 'false' || $tmpcmp == 'no' ? false : $tmpcmp;
		}
		if (array_key_exists('showimagelink', $this->m_params)) {
			$tmpcmp = strtolower(trim($params['showimagelink']));
			$this->m_showimagelink =  $tmpcmp == 'false' || $tmpcmp == 'no' ? false : $tmpcmp;
		}
		if (array_key_exists('drawdumpoutput', $this->m_params)) {
			$this->m_drawdumpoutput = trim($params['drawdumpoutput']);
		}
		if (array_key_exists('tblwidth', $this->m_params)) {
			$this->m_tblwidth = trim($params['tblwidth']);
		}
		if (array_key_exists('tblheight', $this->m_params)) {
			$this->m_tblheight = trim($params['tblheight']);
		}
		if (array_key_exists('width', $this->m_params)) {
			$this->m_width = trim($params['width']);
		}
		if (array_key_exists('height', $this->m_params)) {
			$this->m_height = trim($params['height']);
		}
	}

	protected function getResultText($res, $outputmode) {
		global $smwgIQRunningNumber, $wgUploadDirectory, $wgUploadPath, $wgArticle, $wgScriptPath, $srfgPloticusPath, $srfgEnvSettings;

		$this->isHTML = true;
		$this->outputmode = SMW_OUTPUT_HTML;

		// check parameters
		$validformats = array('svg', 'svgz','swf', 'png', 'gif', 'jpeg', 'drawdump', 'drawdumpa', 'eps', 'ps');
		if (!in_array($this->m_imageformat, $validformats))
		    return ('<p classid="srfperror">ERROR: '. $this->m_imageformat. ' is not a supported imageformat.<br />Valid imageformats are: ' .
			    implode(', ', $validformats) . '</p>');
		
		if (empty($this->m_ploticusparams))
		    return ('<p classid="srfperror">ERROR: <em>ploticusparams</em> required.</p>');
		
		if (empty($srfgPloticusPath))
		    return ('<p classid="srfperror">ERROR: Set $srfgPloticusPath in LocalSettings.php (e.g. $srfgPloticusPath=/usr/bin/pl).</p>');

		if (!file_exists($srfgPloticusPath)) 
		    return ('<p classid=""srfperror">ERROR: Could not find ploticus in <em>' . $srfgPloticusPath . '</em></p>');
		
		if ($this->m_ploticusmode !== 'script' && $this->m_ploticusmode !== 'prefab')
		    return ('<p classid="srfperror">ERROR: Unknown mode specified (' . $this->m_ploticusmode . 
		      '). Only "prefab" (default) and "script" mode supported.</p>');
		
		// remove potentially dangerous keywords (prefab mode) or ploticus directives (script mode)
		// this is an extended check, JUST IN CASE, even though we're invoking ploticus with the noshell security parameter
		if ($this->m_ploticusmode === 'prefab') {
		     // we also remove line endings for prefab - this is done for readability so the user can specify the prefab
		     // params over several lines rather than one long command line
		    $searches = array('/`/m', '/system/im', '/shell/im', "/\s*?\n/m");
		    $replaces = array('', '', '', ' ');
		} else {
		    $searches = array('/`/m', '/#include/im', '/#shell/im', '/#sql/im', '/#write/im','/#cat/im');
		    $replaces = array('', '// ERROR: INCLUDE not allowed', '// ERROR: SHELL not allowed',
			    '// ERROR: SQL not allowed', '// ERROR: WRITE not allowed', '// ERROR: CAT not allowed');
		}
		$sanitized_ploticusparams = preg_replace($searches, $replaces, $this->m_ploticusparams); 

		// Create the ploticus data directory if it doesn't exist
		// create sharded directory structure for data partitioning/scalability purposes
		$ploticusDir = $wgUploadDirectory . '/ploticus/';
		if (!is_dir($ploticusDir)) {
			mkdir($ploticusDir, 0777);
			for ($idx=0; $idx < 16; $idx++)
				mkdir($ploticusDir . dechex($idx), 0777);
		}

		// create result csv file that we pass on to ploticus
		$tmpFile = tempnam($ploticusDir, 'srf-');
		if (($fhandle = fopen($tmpFile, 'w')) === false )
			return ('<p class="srfperror">ERROR: Cannot create data file - ' . $tmpFile . '.  Check permissions.</p>');
		
		if ($this->mShowHeaders) { 
			// create the header row 
			$header_row = array();
			foreach ($res->getPrintRequests() as $pr) {
				$headertext = $pr->getLabel();
				$header_row[] = strtr($headertext, " ,", "_|"); // ploticus cant handle embedded spaces/commas for legends
			}
			if (empty($header_row[0]))
				$header_row[0] = "Article";
			fputcsv($fhandle, $header_row);
		}
		// write the results
		while ( $row = $res->getNext() ) {
			 $row_items = array();
			 foreach ($row as $field) {
				 $growing = array();
				 while (($object = $field->getNextObject()) !== false) {
					 $text = Sanitizer::decodeCharReferences($object->getXSDValue());
					 // decode: CSV knows nothing of possible HTML entities
					 $growing[] = $text;
				 }
				 $row_items[] = implode(',', $growing);
			 }
			 fputcsv($fhandle, $row_items);
		}
		fclose($fhandle);

		// we create a hash based on params
		// this is a great way to see if the params and/or the query result has changed
		$hashname = hash('md5', $wgArticle->mTitle . $smwgIQRunningNumber . implode(',',$this->m_params));
		if ($this->m_liveupdating) {
		    // only include contents of result csv in hash when liveupdating is on
		    // in this way, doing file_exists check against hash filename will fail when query result has changed
		    $hashname .= hash_file('md5',$tmpFile);
		}
		
		$orighash = $hashname;
		// modify hashname so files created with it will be stored in shard dir based on first char of hash
		$hashname = substr($hashname, 0, 1) . '/' . $hashname; 
		$dataFile = $ploticusDir . $hashname . '.csv';
		@unlink($dataFile);
		@rename($tmpFile, $dataFile);
		$dataURL = $wgUploadPath . '/ploticus/' . $hashname . '.csv';
		$srficonPath = $wgScriptPath . '/extensions/SemanticResultFormats/Ploticus/icons/';
				
		$graphFile = $ploticusDir . $hashname . '.' . $this->m_imageformat;
		$graphURL = $wgUploadPath . '/ploticus/' . $hashname . '.' . $this->m_imageformat;
		$errorFile = $ploticusDir . $hashname . '.err';
		$errorURL = $wgUploadPath . '/ploticus/' . $hashname . '.err';
		$mapFile = $ploticusDir . $hashname . '.map';
		$mapURL = $wgUploadPath . '/ploticus/' . $hashname . '.map';
		$scriptFile = $ploticusDir . $hashname . '.plo';
		$scriptURL = $wgUploadPath . '/ploticus/' . $hashname . '.plo';
		
		if (($this->m_updatefrequency > 0) && file_exists($graphFile)) {
			// get time graph was last generated. Also check to see if the 
			// generated plot has expired per the updatefrequency and needs to be redrawn
		    $graphLastGenerated = filemtime($graphFile);
		    $expireTime = $graphLastGenerated + $this->m_updatefrequency;
		    if ( $expireTime < time()) {
			@unlink($graphFile);
		    }
		}
		
		// check if previous plot generated with the same params and result data is available
		// we know this from the md5 hash.  This should eliminate
		// unneeded, CPU-intensive invocations of ploticus and minimize
		// the need to periodically clean-up graph, csv, script and map files
		$errorData = '';
		if ($this->m_debug || !file_exists($graphFile)) {
 			
			// we set $srfgEnvSettings if specified
			$commandline = empty($srfgEnvSettings) ? ' ' : $srfgEnvSettings . ' ';
			
			if ($this->m_ploticusmode === 'script') {
			    // Script mode.  Search for special keywords in ploticusparam
			    // and replace it with actual values. (case-sensitive)
			    // The special keywords currently are:  %DATAFILE.CSV%, %WORKINGDIR% 
			    $replaces = array('%DATAFILE.CSV%'  => wfEscapeShellArg($dataFile),
					      '%WORKINGDIR%' => $ploticusDir);
			    $literal_ploticusparams = strtr($sanitized_ploticusparams, $replaces);
			    $fhandle = fopen($scriptFile, 'w');
			    fputs($fhandle, $literal_ploticusparams);
			    fclose($fhandle);
			    
			    $commandline .= wfEscapeShellArg($srfgPloticusPath) .
				    ($this->m_debug ? ' -debug':' ') .
				    ' -noshell -' . $this->m_imageformat .
				    ' -o ' . wfEscapeShellArg($graphFile) .
				    ' ' . $scriptFile;
				    
			} else {
			    // prefab mode, build the command line accordingly		       
			    $commandline .= wfEscapeShellArg($srfgPloticusPath) .
				    ($this->m_debug ? ' -debug':' ') .
				    ' -noshell ' . $sanitized_ploticusparams .
				    ($this->mShowHeaders ? ' header=yes':' ') .
				    ' delim=comma data=' . wfEscapeShellArg($dataFile) .
				    ' -' . $this->m_imageformat;
			
			    if ($this->m_imageformat == 'drawdump' || $this->m_imageformat == 'drawdumpa' ) {
				$commandline .= ' ' . wfEscapeShellArg($ploticusDir .  '/' . $this->m_drawdumpoutput);
			    } else {
				$commandline .= ' -o '. wfEscapeShellArg($graphFile);
			    }
			}
			
			// create the imagemap file if clickmap is specified for ploticus       
			if (strpos($sanitized_ploticusparams, 'clickmap')) {
				$commandline .= ' >' . wfEscapeShellArg($mapFile);
			}
			
			// send errors to this file
			$commandline .= ' 2>' . wfEscapeShellArg($errorFile);

			// Execute ploticus.
			wfShellExec($commandline);
			$errorData = file_get_contents($errorFile);
			if (!$this->m_debug)
				@unlink($errorFile);
			
			$graphLastGenerated = time(); // faster than doing filemtime
			
			if($this->m_ploticusmode == 'script' && !$this->m_debug) {
			    @unlink($scriptFile);
			}
		}
		
		//Prepare output.  Put everything inside a table
		// PLOT ROW - colspan 3
		$rtnstr = '<table class="srfptable" id="srfptblid' . $smwgIQRunningNumber . '" cols="3"' .
			(empty($this->m_tblwidth) ? ' ' : ' width="'. $this->m_tblwidth . '" ') .
			(empty($this->m_tblheight) ? ' ' : ' height="'. $this->m_tblheight . '" ') .
			'><tr>';
		if (!empty($errorData) && !$this->m_debug) {
			// there was an error.  We do the not debug check since ploticus by default sends the debug trace to stderr too
			// so when debug is on, having a non-empty errorData does not necessarily indicate an error.
			$rtnstr .= '<td class="srfperror" colspan="3">Error processing ploticus data:</td></tr><tr><td class="srfperror" colspan="3" align="center">' .
				$errorData . '</td></tr>';
		} else {
			$rtnstr .= '<td class="srfpplot" colspan="3" align="center">';
			switch ($this->m_imageformat) {
				case 'svg':
				case 'svgz':
					$rtnstr .= '<object data="' . $graphURL . '"' .
						(empty($this->m_width)? ' ' : ' width="'. $this->m_width . '" ') .
						(empty($this->m_height)? ' ' : ' height="'. $this->m_height . '" ') .
						'type="image/svg+xml"><param name="src" value="' . $graphURL .
						'"> alt : <a href="'. $graphURL . '">Requires SVG capable browser</a></object>';
					break;
				case 'swf':
					$rtnstr .= '<object type="application/x-shockwave-flash" data="' . $graphURL . '"' .
						(empty($this->m_width)? ' ' : ' width="'. $this->m_width . '" ') .
						(empty($this->m_height)? ' ' : ' height="'. $this->m_height . '" ') .
						'><param name="movie" value="' . $graphURL .
						'"><param name="loop" value="false"><param name="SCALE" value="noborder"> alt : <a href="'. $graphURL .
						'">Requires Adobe Flash plugin</a></object>';
					break;
				case 'png':
				case 'gif':
				case 'jpeg':
					if (strpos($sanitized_ploticusparams, 'clickmap')) {
						// we are using clickmaps, create HTML snippet to enable client-side imagemaps
						$mapData = file_get_contents($mapFile);
						$rtnstr .= '<map name="'. $orighash . '">'. $mapData .
							'</map><img src="' . $graphURL . '" border="0" usemap="#' . $orighash . '">';
					} else {
					    $rtnstr .= '<img src="' . $graphURL . '" alt="' . $this->m_titletext .'" title="' .  $this->m_titletext . '">';
					}
					break;
				case 'eps':
				case 'ps':
					$rtnstr .= '<object type="application/postscript" data="' . $graphURL . '"' .
					(empty($this->m_width)? ' ' : ' width="'. $this->m_width . '" ') .
					(empty($this->m_height)? ' ' : ' height="'. $this->m_height . '" ') .
					'> alt : <a href="'. $graphURL . '">Requires PDF-capable browser</a></object>';
			}
			$rtnstr .= '</td></tr>';
		}
		// INFOROW - colspan 3
		$rtnstr .= '<tr><td class="srfpaction" width="33%" colspan="1">';
		
		// INFOROW - ACTIONS - col 1
		// if showcsv or debug is on, add link to data file (CSV)
		if ($this->m_showcsv || $this->m_debug) {
			$rtnstr .= '<a href="' . $dataURL . '" title="CSV file"><img src="'.
				$srficonPath . 'csv_16.png" alt="CSV file"></a>';
		} else {
		    @unlink($dataFile); // otherwise, clean it up
		}
		
		// if showimagelink is on, add link to open image in a new window
		if ($this->m_showimagelink ) {
			$rtnstr .= ' <a href="' . $graphURL . '" target="_blank" title="Open image in new window"><img src="'.
				$srficonPath . 'barchart_16.png" alt="Open image in new window"></a>';
		}
		
		// if showrefresh is on, create link to force refresh
		if ($this->m_showrefresh) {
			global $wgArticlePath;
			$rtnstr .= ' <a href="' . $wgArticlePath . '?action=purge" title="Reload"><img src="'.
				$srficonPath . 'reload_16.png" alt="Reload"></a>';
		}
		
		// INFOROW - col 2
		// show titletext
		$rtnstr .= '</td><td class="srfptitle" width="33%" colspan="1" align="center">' . $this->m_titletext;
		
		// INFOROW - TIMESTAMP - col 3
		// if showtimestamp is on, add plot generation timestamp
		$rtnstr .= '</td><td class="srfptimestamp" width="33%" colspan="1" align="right">';
		if ($this->m_showtimestamp) {
			$rtnstr .= '<small> Generated: ' . date('Y-m-d h:i:s A', $graphLastGenerated) . '</small>';
		}
		
		$rtnstr .= '</td></tr>';
		
		// DEBUGROW - colspan 3, only display when debug is on
		// add link to script or display ploticus cmdline/script
		if ($this->m_debug) {
			$rtnstr .= '<tr><td class="srfpdebug" align="center" colspan="3">DEBUG: ';
		    if ($this->m_ploticusmode == 'script') {
			$rtnstr .= '<a href="' . $scriptURL . '" target="_blank">SCRIPT</a> (<a href="'.
				$errorURL . '" target="_blank">Ploticus Trace</a>)</td></tr>';
		    } else {
			$rtnstr .= 'PREFAB (<a href="' . $errorURL .
				'" target="_blank">Ploticus Trace</a>)</td></tr><tr><td class="srfpdebug" colspan="3">' .
				$commandline . '</td></tr>';
		    }
		}
		
		$rtnstr .= '</table>';
		
		return ($rtnstr);
	}
}
