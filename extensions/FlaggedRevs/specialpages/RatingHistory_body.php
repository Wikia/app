<?php
if( !defined( 'MEDIAWIKI' ) ) {
	echo "FlaggedRevs extension\n";
	exit( 1 );
}

class RatingHistory extends UnlistedSpecialPage
{
	public function __construct() {
		parent::__construct( 'RatingHistory', 'feedback' );
		wfLoadExtensionMessages( 'RatingHistory' );
		wfLoadExtensionMessages( 'FlaggedRevs' );
	}

	public function execute( $par ) {
		global $wgRequest, $wgUser, $wgOut;
		$this->setHeaders();
		if( $wgUser->isAllowed( 'feedback' ) ) {
			if( $wgUser->isBlocked() ) {
				$wgOut->blockedPage();
				return;
			}
		} else {
			$wgOut->permissionRequired( 'feedback' );
			return;
		}
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		$this->skin = $wgUser->getSkin();
		$this->doPurge = ('purge' === $wgRequest->getVal( 'action' ) && $wgUser->isAllowed('purge'));
		# Our target page
		$this->target = $wgRequest->getText( 'target' );
		$this->page = Title::newFromUrl( $this->target );
		# We need a page...
		if( is_null($this->page) ) {
			$wgOut->showErrorPage( 'notargettitle', 'notargettext' );
			return;
		} else if( !FlaggedRevs::isPageRateable( $this->page ) ) {
			$wgOut->addHTML( wfMsgExt('readerfeedback-main',array('parse')) );
			return;
		}
		# Thank people who voted...
		if( ReaderFeedback::userAlreadyVoted( $this->page ) ) {
			$wgOut->setSubtitle( wfMsgExt('ratinghistory-thanks','parseinline') );
		}
		$period = $wgRequest->getInt( 'period' );
		$validPeriods = array(31,93,365,1095);
		if( !in_array($period,$validPeriods) ) {
			$period = 31; // default
		}
		$this->period = $period;
		$this->dScale = 20;
		
		$this->now = time(); // one time for whole request

		$this->showForm();
		$this->showTable();
		/*
		 * Allow client caching.
		 */
		if( !$this->doPurge && $wgOut->checkLastModified( self::getTouched($this->page) ) ) {
			return; // Client cache fresh and headers sent, nothing more to do
		} else {
			$wgOut->enableClientCache( false ); // don't show stale graphs
			if( $this->doPurge ) $this->purgePage();
		}
		$this->showGraphs();
	}
	
	protected function showTable() {
		global $wgOut;
		# Show latest month of results
		$html = FlaggedRevs::getVoteAggregates( $this->page, $this->period, array(),
			$this->doPurge ? 'skipCache' : 'useCache'
		);
		if( $html ) {
			$wgOut->addHTML( '<h2>'.wfMsgHtml('ratinghistory-table')."</h2>\n".$html );
		}
	}
	
	protected function showForm() {
		global $wgOut, $wgScript;
		$form = Xml::openElement( 'form', array( 'name' => 'reviewedpages', 'action' => $wgScript, 'method' => 'get' ) );
		$form .= "<fieldset>";
		$form .= "<legend>".wfMsgExt( 'ratinghistory-leg',array('parseinline'),
			$this->page->getPrefixedText() )."</legend>\n";
		$form .= Xml::hidden( 'title', $this->getTitle()->getPrefixedDBKey() );
		$form .= Xml::hidden( 'target', $this->page->getPrefixedDBKey() );
		$form .= $this->getPeriodMenu( $this->period );
		$form .= " ".Xml::submitButton( wfMsg( 'go' ) );
		$form .= "</fieldset></form>\n";
		$wgOut->addHTML( $form );
	}
	
   	/**
	* Get a selector of time period options
	* @param int $selected, selected level
	*/
	protected function getPeriodMenu( $selected=null ) {
		$s = "<label for='period'>" . wfMsgHtml('ratinghistory-period') . "</label>&nbsp;";
		$s .= Xml::openElement( 'select', array('name' => 'period', 'id' => 'period') );
		$s .= Xml::option( wfMsg( "ratinghistory-month" ), 31, $selected===31 );
		$s .= Xml::option( wfMsg( "ratinghistory-3months" ), 93, $selected===93 );
		$s .= Xml::option( wfMsg( "ratinghistory-year" ), 365, $selected===365 );
		$s .= Xml::option( wfMsg( "ratinghistory-3years" ), 1095, $selected===1095 );
		$s .= Xml::closeElement('select')."\n";
		return $s;
	}
	
	protected function showGraphs() {
		global $wgOut;
		$data = false;
		$html = '';
		// Do each graphs for said time period
		foreach( FlaggedRevs::getFeedbackTags() as $tag => $weight ) {
			// Check if cached version is available.
			// If not, then generate a new one.
			$filePath = $this->getFilePath( $tag );
			$url = $this->getUrlPath( $tag );
			// Get the source output. SVG files are converted to PNG.
			$sExt = self::getSourceFileExtension();
			// Check if the output file is cached
			$exists = !$this->fileExpired($tag,$filePath);
			// ...if not, then regenerate it
			if( $sExt === 'svg' && !$exists ) {
				$exists = $this->makeSvgGraph($tag,$filePath);
			} else if( $sExt === 'png' && !$exists ) {
				$exists = $this->makePngGraph($tag,$filePath);
			}
			if( $exists ) $data = true;
			// Output plot/chart depending on final output file...
			switch( self::getCachedFileExtension() )
			{
			case 'svg':
				if( $exists ) {
					$html .= "<h3>" . wfMsgHtml("readerfeedback-$tag") . "</h3>\n" .
						Xml::openElement( 'div', array('class' => 'fr_reader_feedback_graph') ) .
						Xml::element( 'embed', array('src' => $url, 'type' => 'image/svg+xml',
							'class' => 'fr_reader_feedback_plot', 'width' => '1000', 'height' => '410') ) .
						Xml::closeElement( 'div' ) . "\n";
				}
				break;
			case 'png':
				if( $exists ) {
					// Add link for users with non-shitty browsers to see SVG itself
					$viewLink = "";
					if( $sExt === 'svg' ) {
						$svgUrl = $this->getUrlPath( $tag, 'svg' );
						$viewLink = " <small>[<a href='".htmlspecialchars($svgUrl)."'>".
							wfMsgHtml("readerfeedback-svg")."</a>]</small>";
					}
					$html .= "<h3>" . wfMsgHtml("readerfeedback-$tag") . "$viewLink</h3>\n" .
						Xml::openElement( 'div', array('class' => 'fr_reader_feedback_graph') ) .
						Xml::openElement( 'img', array('src' => $url,'alt' => $tag) ) . 
						Xml::closeElement( 'img' ) .
						Xml::closeElement( 'div' ) . "\n";
				}
				break;
			default:
				if( $exists ) {
					$fp = @fopen( $filePath, 'r' );
					$table = fread( $fp, filesize($filePath) );
					@fclose( $fp );
					$html .= '<h2>' . wfMsgHtml("readerfeedback-$tag") . '</h2>' . $table . "\n";
				} else if( $table = $this->makeHTMLTable( $tag, $filePath ) ) {
					$html .= '<h2>' . wfMsgHtml("readerfeedback-$tag") . '</h2>' . $table . "\n";
				}
				break;
			}
		}
		// Add header
		$purgeUrl = $this->getTitle()->getFullUrl( 'target='.$this->page->getPrefixedUrl().
			"&period={$this->period}&action=purge" );
		$purgeLink = " <small>[<a href='".htmlspecialchars($purgeUrl)."'>".
			wfMsgHtml('ratinghistory-purge')."</a>]</small>";
		// Add header for all the graphs below
		$wgOut->addHTML( '<h2>' . wfMsgHtml('ratinghistory-chart') . "$purgeLink</h2>\n" );
		if( $data ) {
			// Add legend as needed
			$wgOut->addWikiText( wfMsg('ratinghistory-legend',$this->dScale) );
			// Add recent voter list
			$userTable = $this->getUserList();
			if( $userTable ) {
				$html .= '<h2>' . wfMsgHtml('ratinghistory-users') . '</h2>' .
					Xml::openElement( 'div', array('class' => 'fr_reader_feedback_users') ) .
					$userTable . Xml::closeElement( 'div' ) . "\n";
			}
		} else {
			$html .= wfMsg('ratinghistory-none');
		}
		$wgOut->addHTML( $html );
	}
	
	/**
	* Generate an HTML table for this tag
	* @param string $tag
	* @param string $filePath
	* @returns string, html table
	*/
	public function makeHTMLTable( $tag, $filePath ) {
		$dir = dirname($filePath);
		// Make sure directory exists
		if( !is_dir($dir) && !wfMkdirParents( $dir, 0777 ) ) {
			return false;
		}
		// Define the data using the DB rows
		$totalVal = $totalCount = $n = 0;
		list($res,$u,$maxC,$days) = $this->doQuery( $tag );
		// Label spacing
		$int = intval( ceil($days/10) ); // 10 labels at most
		$dates = $drating = $arating = $dcount = "";
		while( $row = $res->fetchObject() ) {
			$totalVal += (int)$row->rfh_total;
			$totalCount += (int)$row->rfh_count;
			$dayAve = sprintf( '%4.2f', (real)$row->rfh_total/(real)$row->rfh_count );
			$cumAve = sprintf( '%4.2f', (real)$totalVal/(real)$totalCount );
			$year = intval( substr( $row->rfh_date, 0, 4 ) );
			$month = intval( substr( $row->rfh_date, 4, 2 ) );
			$day = intval( substr( $row->rfh_date, 6, 2 ) );
			$date = ($this->period > 31) ? "{$month}/{$day}/".substr( $year, 2, 2 ) : "{$month}/{$day}";
			$dates .= "<th>$date</th>";
			$drating .= "<td>$dayAve</td>";
			$arating .= "<td>$cumAve</td>";
			$dcount .= "<td>#{$row->rfh_total}</td>";
			$n++;
		}
		$chart = Xml::openElement( 'div', array('style' => "width:100%; overflow:auto;") );
		$chart .= "<table class='wikitable' style='white-space: nowrap; border=1px; font-size: 8pt;'>\n";
		$chart .= "<tr>$dates</tr>\n";
		$chart .= "<tr align='center' class='fr-rating-dave'>$drating</tr>\n";
		$chart .= "<tr align='center' class='fr-rating-rave'>$arating</tr>\n";
		$chart .= "<tr align='center' class='fr-rating-dcount'>$dcount</tr>\n";
		$chart .= "</table>\n";
		$chart .= Xml::closeElement( 'div' );
		// Write to file for cache
		$fp = @fopen( $filePath, 'w' );
		@fwrite( $fp, $chart );
		@fclose( $fp );
		return $chart;
	}
	
	/**
	* Generate a graph for this tag
	* @param string $tag
	* @param string $filePath
	* @returns bool, success
	*/
	public function makePngGraph( $tag, $filePath ) {
		if( !function_exists( 'ImageCreate' ) ) {
			// GD is not installed
			return false;
		}
		global $wgPHPlotDir;
		require_once( "$wgPHPlotDir/phplot.php" ); // load classes
		// Define the object
		$plot = new PHPlot( 1000, 400 );
		// Set file path
		$dir = dirname($filePath);
		// Make sure directory exists
		if( !file_exists($dir) && !wfMkdirParents( $dir, 0777 ) ) {
			throw new MWException( 'Could not create file directory!' );
			return false;
		}
		$plot->SetOutputFile( $filePath );
		$plot->SetIsInline( true );
		$data = array();
		$totalVal = $totalCount = $n = 0;
		// Define the data using the DB rows
		list($res,$u,$maxC,$days) = $this->doQuery( $tag );
		if( !$maxC ) return false;
		// Label spacing
		$int = intval( ceil($days/10) ); // 10 labels at most
		while( $row = $res->fetchObject() ) {
			$totalVal += (int)$row->rfh_total;
			$totalCount += (int)$row->rfh_count;
			$dayCount = (real)$row->rfh_count;
			if( !$row->rfh_count ) continue; // bad data
			// Nudge values up by 1
			$dayAve = 1 + (real)$row->rfh_total/(real)$row->rfh_count;
			$cumAve = 1 + (real)$totalVal/(real)$totalCount;
			$year = intval( substr( $row->rfh_date, 0, 4 ) );
			$month = intval( substr( $row->rfh_date, 4, 2 ) );
			$day = intval( substr( $row->rfh_date, 6, 2 ) );
			# Fill in days with no votes to keep spacing even
			if( isset($lastDate) ) {
				$dayGap = wfTimestamp(TS_UNIX,$row->rfh_date) - wfTimestamp(TS_UNIX,$lastDate);
				$x = intval( $dayGap/86400 );
				# Day gaps...
				for( $x; $x > 1; --$x ) {
					$data[] = array("",$lastDAve,$lastRAve,0);
					$n++;
				}
			}
			$n++;
			# Label point?
			if( $n >= $int || !count($data) ) {
				$p = ($days > 31) ? "{$month}-".substr( $year, 2, 2 ) : "{$month}/{$day}";
				$n = 0;
			} else {
				$p = "";
			}
			$data[] = array( $p, $dayAve, $cumAve, $dayCount );
			$lastDate = $row->rfh_date;
			$lastDAve = $dayAve;
			$lastRAve = $cumAve;
		}
		// Minimum sample size
		if( count($data) < 2 ) {
			return false;
		}
		// Fit to [0,4]
		foreach( $data as $x => $dataRow ) {
			$data[$x][3] = $dataRow[3]/$this->dScale;
		}
		$plot->SetDataValues($data);
		$plot->SetPointShapes( array('dot','dot','dot') );
		$plot->setPointSizes( array(1,1,4) );
		$plot->SetDataColors( array('blue','green','red') );
		$plot->SetLineStyles( array('solid','solid','none') );
		$plot->SetBackgroundColor('#F8F8F8');
		// Turn off X axis ticks and labels because they get in the way:
		$plot->SetXTickLabelPos('none');
		$plot->SetXTickPos('none');
		$plot->SetYTickIncrement( .5 );
		// Set plot area
		$plot->SetPlotAreaWorld( 0, 0, null, 5 );
		// Show total number of votes
		$plot->SetLegend( array("#{$totalCount}") );
		// Draw it!
		$plot->DrawGraph();
		return true;
	}
	
	/**
	* Generate a graph for this tag
	* @param string $tag
	* @param string $filePath
	* @returns bool, success
	*/
	public function makeSvgGraph( $tag, $filePath ) {
		global $wgSvgGraphDir, $wgContLang;
		require_once( "$wgSvgGraphDir/svgGraph.php" ); // load classes
		require_once( "$wgSvgGraphDir/svgGraph2.php" ); // load classes
		// Define the object
		$plot = new svgGraph2();
		// Set file path
		$dir = dirname($filePath);
		// Make sure directory exists
		if( !file_exists($dir) && !wfMkdirParents( $dir, 0777 ) ) {
			throw new MWException( 'Could not create file directory!' );
			return false;
		}
		// Set some parameters
		$plot->graphicWidth = 1000;
		$plot->graphicHeight = 410;
		$plot->plotWidth = 930;
		$plot->plotHeight = 350;
		$plot->decimalPlacesY = 1;
		$plot->plotOffsetX = 40;
		$plot->plotOffsetY = 30;
		$plot->numGridlinesY = 10 + 1;
		$plot->innerPaddingX = 15;
		$plot->innerPaddingY = 10;
		$plot->outerPadding = 5;
		$plot->minY = 0;
		$plot->maxY = 5;
		// Define the data using the DB rows
		$dataX = $dave = $rave = $dcount = array();
		$totalVal = $totalCount = $sd = $pts = $n = 0;
		// Define the data using the DB rows
		list($res,$u,$maxC,$days) = $this->doQuery( $tag );
		if( !$maxC ) return false;
		// Label spacing
		$int = intval( ceil($days/10) ); // 10 labels at most
		while( $row = $res->fetchObject() ) {
			$totalVal += (int)$row->rfh_total;
			$totalCount += (int)$row->rfh_count;
			$dayCount = (real)$row->rfh_count;
			if( !$row->rfh_count ) continue; // bad data
			// Nudge values up by 1 to fit [1,5]
			$dayAve = 1 + (real)$row->rfh_total/(real)$row->rfh_count;
			$sd += pow($dayAve - $u,2);
			$cumAve = 1 + (real)$totalVal/(real)$totalCount;
			$year = intval( substr( $row->rfh_date, 0, 4 ) );
			$month = intval( substr( $row->rfh_date, 4, 2 ) );
			$day = intval( substr( $row->rfh_date, 6, 2 ) );
			# Fill in days with no votes to keep spacing even
			if( isset($lastDate) ) {
				$dayGap = wfTimestamp(TS_UNIX,$row->rfh_date) - wfTimestamp(TS_UNIX,$lastDate);
				$x = intval( $dayGap/86400 );
				# Day gaps...
				for( $x; $x > 1; --$x ) {
					$dataX[] = "";
					$dave[] = $lastDAve;
					$rave[] = $lastRAve;
					$dcount[] = 0;
					$n++;
				}
			}
			$n++;
			# Label point?
			if( $n >= $int || !count($dataX) ) {
				$p = ($days > 31) ? "{$month}-".substr( $year, 2, 2 ) : "{$month}/{$day}";
				$n = 0;
			} else {
				$p = "";
			}
			$dataX[] = $p;
			$dave[] = $dayAve;
			$rave[] = $cumAve;
			$dcount[] = $dayCount;
			$lastDate = $row->rfh_date;
			$lastDAve = $dayAve;
			$lastRAve = $cumAve;
			$pts++;
		}
		// Minimum sample size
		if( $pts < 2 ) {
			return false;
		}
		$sd = sqrt($sd/$pts);
		// Round values for display
		$sd = round( $sd, 3 );
		$u = round( $u, 3 );
		// Fit to [0,4]
		foreach( $dcount as $x => $c ) {
			$dcount[$x] = $c/$this->dScale;
		}
		$plot->dataX = $dataX;
		$plot->dataY['dave'] = $dave;
		$plot->dataY['rave'] = $rave;
		$plot->dataY['dcount'] = $dcount;
		$plot->styleTagsX = 'font-family: monospace; font-size: 9pt;';
		$plot->styleTagsY = 'font-family: sans-serif; font-size: 11pt;';
		$plot->format['dave'] = array( 'style' => 'stroke:blue; stroke-width:1;' );
		$plot->format['rave'] = array( 'style' => 'stroke:green; stroke-width:1;' );
		$plot->format['dcount'] = array( 'style' => 'stroke:red; stroke-width:1;' ); 
			#'attributes' => "marker-end='url(#circle)'");
		$pageText = $wgContLang->truncate( $this->page->getPrefixedText(), 65 );
		$plot->title = wfMsgExt('ratinghistory-graph',array('parsemag','content'),
			$totalCount, wfMsgForContent("readerfeedback-$tag"), $pageText );
		$plot->styleTitle = 'font-family: sans-serif; font-weight: bold; font-size: 12pt;';
		$plot->backgroundStyle = 'fill:#F0F0F0;';
		// extra code for markers
		// FIXME: http://studio.imagemagick.org/pipermail/magick-bugs/2003-January/001038.html
		/* $plot->extraSVG = 
			'<defs>
			  <marker id="circle" style="stroke:red; stroke-width:0; fill:red;"
				viewBox="0 0 10 10" refX="5" refY="7" orient="0"
				markerUnits="strokeWidth" markerWidth="5" markerHeight="5">
				<circle cx="5" cy="5" r="3"/>
			  </marker>
			</defs>';
		*/
		# Create the graph
		@$plot->init();
		$plot->drawGraph();
		$plot->polyLine('dave');
		$plot->polyLine('rave');
		#$plot->line('dcount');
		$plot->polyLine('dcount');
		// Render!
		$plot->generateSVG( "xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'" );
		// Write to file for cache
		$svgPath = $this->getFilePath( $tag, 'svg' );
		$svgHandler = new SvgHandler();
		if( !@file_put_contents( $svgPath, $plot->svg ) ) {
			throw new MWException( 'Could not write SVG file!' );
			return false;
		}
		// Rasterize due to IE suckage
		$status = $svgHandler->rasterize( $svgPath, $filePath, 1000, 410 );
		if( $status !== true ) {
			throw new MWException( 'Could not write SVG file!' );
			return false;
		}
		return true;
	}
	
	protected function doQuery( $tag ) {
		// Set cutoff time for period
		$dbr = wfGetDB( DB_SLAVE );
		$cutoff_unixtime = $this->now - ($this->period * 24 * 3600);
		$cutoff_unixtime = $cutoff_unixtime - ($cutoff_unixtime % 86400);
		$cutoff = $dbr->addQuotes( wfTimestamp( TS_MW, $cutoff_unixtime ) );
		$res = $dbr->select( 'reader_feedback_history',
			array( 'rfh_total', 'rfh_count', 'rfh_date' ),
			array( 'rfh_page_id' => $this->page->getArticleId(), 
				'rfh_tag' => $tag,
				"rfh_date >= {$cutoff}"),
			__METHOD__,
			array( 'ORDER BY' => 'rfh_date ASC' )
		);
		# Get max count and average rating
		$total = $count = $ave = $maxC = $days = 0;
		if( $dbr->numRows($res) > 0 ) {
			while( $row = $dbr->fetchObject($res) ) {
				if( !isset($lower) ) {
					$lower = wfTimestamp( TS_UNIX, $row->rfh_date ); // first day
				}
				$total += (int)$row->rfh_total;
				$count += (int)$row->rfh_count;
				if( $row->rfh_count > $maxC ) $maxC = intval($row->rfh_count);
				$upper = $row->rfh_date;
			}
			$upper = wfTimestamp( TS_UNIX, $upper );
			$days = intval( ($upper - $lower)/86400 );
			if( $count )
				$ave = 1 + $total/$count; // Offset to [1,5]
			$res->seek( 0 ); // reset query row
		}
		return array($res,$ave,$maxC,$days);
	}
	
	/**
	* Get the path to where the corresponding graph file should be
	* @param string $tag
	* @param string $ext
	* @returns string
	*/
	public function getFilePath( $tag, $ext='' ) {
		global $wgUploadDirectory;
		$rel = self::getRelPath( $tag, $ext );
		return "{$wgUploadDirectory}/graphs/{$rel}";
	}
	
	/**
	* Get the url to where the corresponding graph file should be
	* @param string $tag
	* @param string $ext
	* @returns string
	*/
	public function getUrlPath( $tag, $ext='' ) {
		global $wgUploadPath;
		$rel = self::getRelPath( $tag, $ext );
		return "{$wgUploadPath}/graphs/{$rel}";
	}
	
	public function getRelPath( $tag, $ext = '' ) {
		$ext = $ext ? $ext : self::getCachedFileExtension();
		$pageId = $this->page->getArticleId();
		# Paranoid check. Should not be necessary, but here to be safe...
		if( !preg_match('/^[a-zA-Z]{1,20}$/',$tag) ) {
			throw new MWException( 'Invalid tag name!' );
		}
		return "{$pageId}/{$tag}/l{$this->period}d.{$ext}";
	}
	
	public static function getCachedFileExtension() {
		global $wgSvgGraphDir, $wgPHPlotDir;
		if( $wgSvgGraphDir || $wgPHPlotDir ) {
			$ext = 'png';
		} else {
			$ext = 'html';
		}
		return $ext;
	}
	
	public static function getSourceFileExtension() {
		global $wgSvgGraphDir, $wgPHPlotDir;
		if( $wgSvgGraphDir ) {
			$ext = 'svg';
		} else if( $wgPHPlotDir ) {
			$ext = 'png';
		} else {
			$ext = 'html';
		}
		return $ext;
	}
	
	protected function getUserList() {
		global $wgMemc;
		if( $this->period > 93 ) {
			return ''; // too big
		}
		$key = wfMemcKey( 'flaggedrevs', 'ratingusers', $this->page->getArticleId(), $this->period );
		// Check cache
		if( !$this->doPurge ) {
			$set = $wgMemc->get($key);
			// Cutoff is at the 24 hour mark due to the way the aggregate 
			// schema groups ratings by date for graphs.
			$cache_cutoff = $this->now - ($this->now % 86400);
			if( is_array($set) && count($set) == 2 ) {
				list($html,$time) = $set;
				$touched = wfTimestamp( TS_UNIX, self::getTouched($this->page) );
				if( $time > $cache_cutoff && $time > $touched ) {
					return $html;
				}
			}
		}
		// Set cutoff time for period
		$dbr = wfGetDB( DB_SLAVE );
		$cutoff_unixtime = $this->now - ($this->period * 24 * 3600);
		// Use integral number of days to be consistent with graphs
		$cutoff_unixtime = $cutoff_unixtime - ($cutoff_unixtime % 86400);
		$cutoff = $dbr->addQuotes( wfTimestamp( TS_MW, $cutoff_unixtime ) );
		// Get the first revision possibly voted on in the range
		$firstRevTS = $dbr->selectField( 'revision',
			'rev_timestamp',
			array( 'rev_page' => $this->page->getArticleId(), "rev_timestamp <= $cutoff" ),
			__METHOD__,
			array( 'ORDER BY' => 'rev_timestamp DESC' )
		);
		// Fetch the list of users and how many votes they reviews
		$res = $dbr->select( array( 'revision', 'reader_feedback', 'user' ),
			# COALESCE() gets the user_name for users, and the IP for anons
			array( 'rfb_user', 'COALESCE(user_name,rfb_ip) AS name', 'COUNT(rfb_rev_id) AS n' ),
			array( 'rev_page' => $this->page->getArticleId(),
				"rev_id = rfb_rev_id",
				"rfb_timestamp >= $cutoff",
				// Trigger INDEX usage
				"rev_timestamp >= ".$dbr->addQuotes($firstRevTS) ),
			__METHOD__,
			array( 'GROUP BY' => 'name', 'USE INDEX' => array('revision' => 'page_timestamp') ),
			array( 'user' => array( 'LEFT JOIN', 'rfb_user > 0 AND user_id = rfb_user') )
		);
		// Output multi-column list
		$total = $res->numRows();
		$columns = 4;
		$count = 0;
		$html = "<table class='fr_reader_feedback_users'><tr>";
		while( $row = $res->fetchObject() ) {
			$title = Title::makeTitleSafe( NS_USER, $row->name );
			if( is_null($title) ) continue; // bad IP?
			$html .= '<td>'.$this->skin->makeLinkObj( $title, $title->getText() )." [{$row->n}]</td>";
			$count++;
			if( $total > $count && ($count % $columns) == 0 ) {
				$html .= "</tr><tr>";
			}
		}
		$html .= "</tr></table>\n";
		$wgMemc->set( $key, array( $html, $this->now ), 24*3600 );
		return $html;
	}
	
	public function purgePage() {
		global $wgUploadDirectory;
		foreach( FlaggedRevs::getFeedbackTags() as $tag => $weight ) {
			$dir = "{$wgUploadDirectory}/graphs/".$this->page->getArticleId()."/{$tag}/";
			if( is_dir( $dir ) ) {
				$handle = opendir( $dir );
				if( $handle ) {
					while( false !== ( $file = readdir($handle) ) ) {
						@unlink("$dir/$file");
					}
					closedir( $handle );
				}
			}
			@rmdir( $dir );
		}
		return true;
	}
	
	/**
	* Check if a graph file is expired.
	* @param string $tag
	* @param string $path, filepath to existing file
	* @returns string
	*/
	protected function fileExpired( $tag, $path ) {
		if( $this->doPurge || !file_exists($path) ) {
			return true;
		}
		$dbr = wfGetDB( DB_SLAVE );
		$tagTimestamp = $dbr->selectField( 'reader_feedback_pages', 'rfp_touched',
			array( 'rfp_page_id' => $this->page->getArticleId(), 'rfp_tag' => $tag ),
			__METHOD__ );
		$tagTimestamp = wfTimestamp( TS_UNIX, $tagTimestamp );
		$file_unixtime = filemtime($path);
		# Check max cache time
		$cutoff_unixtime = $this->now - (7 * 24 * 3600);
		if( $file_unixtime < $cutoff_unixtime ) {
			$this->purgePage();
			return true;
		}
		# If there are new votes, graph is stale
		return ( $file_unixtime < $tagTimestamp );
	}
	
	/**
	* Get highest touch timestamp of the tags. This uses a tiny filesort.
	* @param $page Title
	* @returns string
	*/
	public static function getTouched( $page ) {
		$dbr = wfGetDB( DB_SLAVE );
		$tagTimestamp = $dbr->selectField( 'reader_feedback_pages', 
			'MAX(rfp_touched)',
			array( 'rfp_page_id' => $page->getArticleId() ),
			__METHOD__ );
		return wfTimestamp( TS_MW, $tagTimestamp );
	}
}
