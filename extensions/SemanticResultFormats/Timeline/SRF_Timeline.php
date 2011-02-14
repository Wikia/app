<?php
/**
 * Print query results in interactive timelines.
 * 
 * @file SRF_Timeline.php
 * @ingroup SemanticResultFormats
 * 
 * @author Markus Krötzsch
 */

/**
 * Result printer for timeline data.
 * @ingroup SemanticResultFormats
 */
class SRFTimeline extends SMWResultPrinter {

	protected $m_tlstart = '';  // name of the start-date property if any
	protected $m_tlend = '';  // name of the end-date property if any
	protected $m_tlsize = ''; // CSS-compatible size (such as 400px)
	protected $m_tlbands = ''; // array of band IDs (MONTH, YEAR, ...)
	protected $m_tlpos = ''; // position identifier (start, end, today, middle)

	protected function readParameters( $params, $outputmode ) {
		parent::readParameters( $params, $outputmode );

		if ( array_key_exists( 'timelinestart', $params ) ) {
			$this->m_tlstart = smwfNormalTitleDBKey( $params['timelinestart'] );
		}
		if ( array_key_exists( 'timelineend', $params ) ) {
			$this->m_tlend = smwfNormalTitleDBKey( $params['timelineend'] );
		}
		
		if ( array_key_exists( 'timelinesize', $params ) ) {
			$this->m_tlsize = htmlspecialchars( str_replace( ';', ' ', strtolower( trim( $params['timelinesize'] ) ) ) );
			// str_replace makes sure this is only one value, not mutliple CSS fields (prevent CSS attacks)
			// / FIXME: this is either unsafe or redundant, since Timeline is Wiki-compatible. If the JavaScript makes user inputs to CSS then it is bad even if we block this injection path.
		} else {
			$this->m_tlsize = '300px';
		}
		
		if ( array_key_exists( 'timelinebands', $params ) ) {
		// check for band parameter, should look like "DAY,MONTH,YEAR"
			$this->m_tlbands = preg_split( '/[,][\s]*/u', trim( $params['timelinebands'] ) );
		} else {
			$this->m_tlbands = array( 'MONTH', 'YEAR' ); // / TODO: check what default the JavaScript uses
		}
		
		if ( array_key_exists( 'timelineposition', $params ) ) {
			$this->m_tlpos = strtolower( trim( $params['timelineposition'] ) );
		} else {
			$this->m_tlpos = 'middle';
		}
	}

	public function getName() {
		return wfMsg( 'srf_printername_' . $this->mFormat );
	}

	protected function getResultText( /* SMWQueryResult */ $res, $outputmode ) {
		global $smwgIQRunningNumber;
		
		$this->includeJS();

		$isEventline =  ( 'eventline' == $this->mFormat );

		if ( !$isEventline && ( $this->m_tlstart == '' ) ) { // seek defaults
			foreach ( $res->getPrintRequests() as $pr ) {
				if ( ( $pr->getMode() == SMWPrintRequest::PRINT_PROP ) && ( $pr->getTypeID() == '_dat' ) ) {
					if ( method_exists ( $pr->getData(), 'getValueKey' ) ) {
						$date_value = $pr->getData()->getValueKey();
					} else {
						$date_value = $pr->getData()->getXSDValue();
					}
					
					if ( ( $this->m_tlend == '' ) && ( $this->m_tlstart != '' ) &&
					     ( $this->m_tlstart != $date_value ) ) {
						$this->m_tlend = $date_value;
					} elseif ( ( $this->m_tlstart == '' ) && ( $this->m_tlend != $date_value ) ) {
						$this->m_tlstart = $date_value;
					}
				}
			}
		}

		// print header
		$link = $res->getQueryLink( wfMsgForContent( 'smw_iq_altresults' ) );
		$result = "<div class=\"smwtimeline\" id=\"smwtimeline$smwgIQRunningNumber\" style=\"height: $this->m_tlsize\">";
		$result .= '<span class="smwtlcomment">' . wfMsgForContent( 'smw_iq_nojs' ) . ' ' . $link->getText( $outputmode, $this->mLinker ) . '</span>'; // note for people without JavaScript

		foreach ( $this->m_tlbands as $band ) {
			$result .= '<span class="smwtlband">' . htmlspecialchars( $band ) . '</span>';
			// just print any "band" given, the JavaScript will figure out what to make of it
		}

		// print all result rows		
		if ( ( $this->m_tlstart != '' ) || $isEventline ) {
			$result .= $this->getEventsHTML( $res, $outputmode, $isEventline );
		}
		// no further results displayed ...

		// print footer
		$result .= "</div>";
		$this->isHTML = ( $outputmode == SMW_OUTPUT_HTML ); // yes, our code can be viewed as HTML if requested, no more parsing needed
		return $result;
	}	
	
	/**
	 * Includes the JavaScript required for the timeline and eventline formats.
	 * 
	 * @since 1.5.3
	 */
	protected function includeJS() {
		SMWOutputs::requireHeadItem( SMW_HEADER_STYLE );
		
		// MediaWiki 1.17 introduces the Resource Loader.
		if ( method_exists( 'OutputPage', 'addModules' ) && method_exists( 'SMWOutputs', 'requireResource' ) ) {
			SMWOutputs::requireResource( 'ext.srf.timeline' );
		}
		else {
			global $srfgScriptPath;
			SMWOutputs::requireHeadItem(
				'smw_tlhelper',
				'<script type="text/javascript" src="' . $srfgScriptPath . 
					'/Timeline/SRF_timeline.js"></script>'
			);
			SMWOutputs::requireHeadItem(
				'smw_tl',
				'<script type="text/javascript" src="' . $srfgScriptPath . 
					'/Timeline/SimileTimeline/timeline-api.js"></script>'
			);			
		}		
	}
	
	/**
	 * Returns the HTML for the events.
	 * 
	 * @since 1.5.3
	 * 
	 * @param SMWQueryResult $res
	 * @param $outputmode
	 * @param boolean $isEventline
	 * 
	 * @return string
	 */
	protected function getEventsHTML( SMWQueryResult $res, $outputmode, $isEventline ) {
		$positions = array(); // possible positions, collected to select one for centering
		$curcolor = 0; // color cycling is used for eventline		
		
		$result = '';
		
		$output = false; // true if output for the popup was given on current line
		if ( $isEventline ) $events = array(); // array of events that are to be printed
		
		while ( $row = $res->getNext() ) { // Loop over the objcts (pages)
			$hastime = false; // true as soon as some startdate value was found
			$hastitle = false; // true as soon as some label for the event was found
			$curdata = ''; // current *inner* print data (within some event span)
			$curmeta = ''; // current event meta data
			$curarticle = ''; // label of current article, if it was found; needed only for eventline labeling
			$first_col = true;
			
			foreach ( $row as $field ) { // Loop over the returned properties
				$first_value = true;
				$pr = $field->getPrintRequest();
				
				if ( $pr->getData() == '' ) {
					$date_value = null;
				} elseif ( method_exists ( $pr->getData(), 'getValueKey' ) ) {
					$date_value = $pr->getData()->getValueKey();
				} else {
					$date_value = $pr->getData()->getXSDValue();
				}
				
				while ( ( $object = $field->getNextObject() ) !== false ) { // Loop over property values
					$event = $this->handlePropertyValue( 
						$object, $outputmode, $pr, $first_col, $hastitle, $hastime,
						$first_value, $isEventline, $curmeta, $curdata, $date_value, $output
					);
					if ( $event !== false ) {
						$events[] = $event;
					}
					$first_value = false;
				}
				
				if ( $output ) $curdata .= '<br />';
				$output = false;
				$first_col = false;
			}

			if ( $hastime ) {
				$result .= Html::rawElement(
					'span',
					array( 'class' => 'smwtlevent' ),
					$curmeta . Html::element(
						'span',
						array( 'class' => 'smwtlcoloricon' ),
						$curcolor
					) . $curdata
				);
			}
			
			if ( $isEventline ) {
				foreach ( $events as $event ) {
					$result .= '<span class="smwtlevent"><span class="smwtlstart">' . $event[0] . '</span><span class="smwtlurl">' . $event[1] . '</span><span class="smwtlcoloricon">' . $curcolor . '</span>';
					if ( $curarticle != '' ) $result .= '<span class="smwtlprefix">' . $curarticle . ' </span>';
					$result .=  $curdata . '</span>';
					$positions[$event[2]] = $event[0];
				}
				$events = array();
				$curcolor = ( $curcolor + 1 ) % 10;
			}
		}
		
		if ( count( $positions ) > 0 ) {
			ksort( $positions );
			$positions = array_values( $positions );
			
			switch ( $this->m_tlpos ) {
				case 'start':
					$result .= '<span class="smwtlposition">' . $positions[0] . '</span>';
					break;
				case 'end':
					$result .= '<span class="smwtlposition">' . $positions[count( $positions ) - 1] . '</span>';
					break;
				case 'today': break; // default
				case 'middle': default:
					$result .= '<span class="smwtlposition">' . $positions[ceil( count( $positions ) / 2 ) - 1] . '</span>';
					break;
			}
		}

		return $result;
	}
	
	/**
	 * Hanldes a single property value. Returns an array with data for a single event or false.
	 * 
	 * @since 1.5.3
	 * 
	 * @param SMWDataValue $object
	 * @param $outputmode
	 * @param SMWPrintRequest $pr
	 * @param boolean $first_col
	 * @param boolean &$hastitle
	 * @param boolean &$hastime
	 * @param boolean $first_value
	 * @param boolean $isEventline
	 * @param string &$curmeta
	 * @param string &$curdata
	 * @param &$date_value
	 * @param boolean &$output
	 * 
	 * @return false or array
	 */
	protected function handlePropertyValue( SMWDataValue $object, $outputmode, SMWPrintRequest $pr, $first_col, 
		&$hastitle, &$hastime, $first_value, $isEventline, &$curmeta, &$curdata, $date_value, &$output ) {
		
		$event = false;
		
		$l = $this->getLinker( $first_col );
		
		if ( !$hastitle && $object->getTypeID() != '_wpg' ) { // "linking" non-pages in title positions confuses timeline scripts, don't try this
			$l = null;
		}
		
		if ( $object->getTypeID() == '_wpg' ) { // use shorter "LongText" for wikipage
			$objectlabel = $object->getLongText( $outputmode, $l );
		} else {
			$objectlabel = $object->getShortText( $outputmode, $l );
		}
		
		$urlobject =  ( $l !== null );
		$header = '';
		
		if ( $first_value ) {
			// find header for current value:
			if ( $this->mShowHeaders && ( '' != $pr->getLabel() ) ) {
				$header = $pr->getText( $outputmode, $this->mLinker ) . ': ';
			}
			
			// is this a start date?
			if ( ( $pr->getMode() == SMWPrintRequest::PRINT_PROP ) &&
			     ( $date_value == $this->m_tlstart ) ) {
				// FIXME: Timeline scripts should support XSD format explicitly. They
				// currently seem to implement iso8601 which deviates from XSD in cases.
				// NOTE: We can assume $object to be an SMWDataValue in this case.
				$curmeta .= Html::element(
					'span',
					array( 'class' => 'smwtlstart' ),
					$object->getXMLSchemaDate()
				);
				$positions[$object->getHash()] = $object->getXMLSchemaDate();
				$hastime = true;
			}
			
			// is this the end date?
			if ( ( $pr->getMode() == SMWPrintRequest::PRINT_PROP ) &&
			     ( $date_value == $this->m_tlend ) ) {
				// NOTE: We can assume $object to be an SMWDataValue in this case.
				$curmeta .= Html::element(
					'span',
					array( 'class' => 'smwtlend' ),
					$object->getXMLSchemaDate( false )
				);
			}
			
			// find title for displaying event
			if ( !$hastitle ) {
				$curmeta .= Html::element(
					'span',
					array(
						'class' => $urlobject ? 'smwtlurl' : 'smwtltitle'
					),
					$objectlabel
				);

				if ( ( $pr->getMode() == SMWPrintRequest::PRINT_THIS ) ) {
					// NOTE: type Title of $object implied
					$curarticle = $object->getLongWikiText();
				}
				$hastitle = true;
			}
		} elseif ( $output ) {
			// it *can* happen that output is false here, if the subject was not printed (fixed subject query) and mutliple items appear in the first row
			$curdata .= ', '; 
		}
		
		if ( !$first_col || !$first_value || $isEventline ) {
			$curdata .= $header . $objectlabel;
			$output = true;
		}
		
		if ( $isEventline && ( $pr->getMode() == SMWPrintRequest::PRINT_PROP ) && ( $pr->getTypeID() == '_dat' ) && ( '' != $pr->getLabel() ) && ( $date_value != $this->m_tlstart ) && ( $date_value != $this->m_tlend ) ) {
			if ( method_exists( $object, 'getValueKey' ) ) {
				$event = array(
					$object->getXMLSchemaDate(),
					$pr->getLabel(),
					$object->getValueKey()
				);
			}
			else {
				$event = array(
					$object->getXMLSchemaDate(),
					$pr->getLabel(),
					$object->getNumericValue()
				);
			}
		}

		return $event;
	}

	/**
	 * @see SMWResultPrinter::getParameters
	 * 
	 * @since 1.5.0
	 * 
	 * @return array
	 */	
	public function getParameters() {
		$params = parent::getParameters();
		
		$params[] = array( 'name' => 'timelinebands', 'type' => 'enum-list', 'description' => wfMsg( 'srf_paramdesc_timelinebands' ), 'values' => array( 'DECADE', 'YEAR', 'MONTH', 'WEEK', 'DAY', 'HOUR', 'MINUTE' ) );
		$params[] = array( 'name' => 'timelineposition', 'type' => 'enumeration', 'description' => wfMsg( 'srf_paramdesc_timelineposition' ), 'values' => array( 'start', 'middle', 'end' ) );
		$params[] = array( 'name' => 'timelinestart', 'type' => 'string', 'description' => wfMsg( 'srf_paramdesc_timelinestart' ) );
		$params[] = array( 'name' => 'timelineend', 'type' => 'string', 'description' => wfMsg( 'srf_paramdesc_timelineend' ) );
		$params[] = array( 'name' => 'timelinesize', 'type' => 'string', 'description' => wfMsg( 'srf_paramdesc_timelinesize' ) );
		
		 return $params;
	}
	
	/**
	 * Register the resource modules used by this result printer.
	 * 
	 * @since 1.5.2
	 */
	public static function registerResourceModules() {
		global $wgResourceModules, $srfgScriptPath;
		
		$moduleTemplate = array(
			'localBasePath' => dirname( __FILE__ ),
			'remoteBasePath' => $srfgScriptPath . '/Timeline',
			'group' => 'ext.srf'
		);
		
		$wgResourceModules['ext.srf.timeline'] = $moduleTemplate + array(
			'scripts' => array( 'SRF_timeline.js', 'SimileTimeline/timeline-api.js' ),
			'dependencies' => array( 'mediawiki.legacy.wikibits' )
		);
	}
	
}
