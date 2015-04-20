<?php
/**
 * Use Exhibit to print query results.
 * @author Fabian Howahl
 * @file
 * @ingroup SMWQuery
 */

/**
 * Result printer using Exhibit to display query results
 *
 * @ingroup SMWQuery
 */
class SRFExhibit extends SMWResultPrinter {
	// /mapping between SMW's and Exhibit's the data types
	protected $m_types = array( "_wpg" => "text", "_num" => "number", "_dat" => "date", "_geo" => "text", "_uri" => "url" );

	protected static $exhibitRunningNumber = 0; // not sufficient since there might be multiple pages rendered within one PHP run; but good enough now

	// /overwrite function to allow execution of result printer even if no results are available (in case remote query yields no results in local wiki)
	public function getResult( $results, $params, $outputmode ) {
		$this->readParameters( $params, $outputmode );
		$result = $this->getResultText( $results, $outputmode );
		return $result;
	}

	// /function aligns the format of SMW's property names to Exhibit's format
	protected function encodePropertyName( $property ) {
		return strtolower( str_replace( " ", "_", trim( $property ) ) );
	}

	// /Tries to determine the namespace in the event it got lost
	protected function determineNamespace( $res ) {
		$row = $res->getNext();
		if ( $row != null ) {
			$tmp = clone $row[0];
			$object = $tmp->getNextDataValue();

			if ( $object instanceof SMWWikiPageValue ) {
				$value = $object->getPrefixedText();
				if ( strpos( $value, ':' ) ) {
					$value = explode( ':', $value, 2 );
					return $value[0] . ':';
				}
			}
		}

		return "";
	}

	protected function getResultText( SMWQueryResult $res, $outputmode ) {

		global $smwgIQRunningNumber, $wgScriptPath, $wgGoogleMapsKey, $srfgScriptPath;

		if ( defined( 'MW_SUPPORTS_RESOURCE_MODULES' ) ) {
			SMWOutputs::requireHeadItem( 'exhibit-compat', Html::linkedScript( "$wgScriptPath/common/wikibits.js" ) );
		}
		
		// //////////////////////////////
		// ///////REMOTE STUFF///////////
		// //////////////////////////////

		$remote = false;

		// in case the remote parameter is set, a link to the JSON export of the remote wiki is included in the header as data source for Exhibit
		// this section creates the link
		if ( array_key_exists( 'remote', $this->m_params ) && srfgExhibitRemote == true ) {

			$remote = true;

			// fetch interwiki link
			$dbr  = &wfGetDB( DB_SLAVE );
			$cl   = $dbr->tableName( 'interwiki' );
			$dbres  = $dbr->select( $cl, 'iw_url', "iw_prefix='" . $this->m_params['remote'] . "'", __METHOD__, array() );
			$row = $dbr->fetchRow( $dbres );
			$extlinkpattern = $row[iw_url];
			$dbr->freeResult( $dbres );

			$newheader = '<link rel="exhibit/data" type="application/jsonp" href="';
			$link = $res->getQueryLink( 'JSON Link' );
			$link->setParameter( 'json', 'format' );

			if ( array_key_exists( 'callback', $this->m_params ) ) { // check if a special name for the callback function is set, if not stick with 'callback'
				$callbackfunc = $this->m_params['callback'];
			} else {
				$callbackfunc = 'callback';
			}

			if ( array_key_exists( 'limit', $this->m_params ) ) {
				$link->setParameter( $this->m_params['limit'], 'limit' );
			}

			$link->setParameter( $callbackfunc, 'callback' );
			$link = $link->getText( 2, $this->mLinker );

			list( $link, $trash ) = explode( '|', $link );
			$link = str_replace( '[[:', '', $link );

			$newheader .= str_replace( '$1', $link, $extlinkpattern );
			$newheader .= '" ex:jsonp-callback="' . $callbackfunc . '"';
			$newheader .= '/>';

			SMWOutputs::requireHeadItem( 'REMOTE', $newheader );
		}



		// the following variables indicate the use of special views
		// the variable's values define the way Exhibit is called
		$timeline = false;
		$map = false;


		/*The javascript file adopted from Wibbit uses a bunch of javascript variables in the header to store information about the Exhibit markup.
		 The following code sequence creates these variables*/

		// prepare sources (the sources holds information about the table which contains the information)
		$colstack = array();
		foreach ( $res->getPrintRequests() as $pr ) {
			$colstack[] = $this->encodePropertyName( $pr->getLabel() ) . ':' . ( array_key_exists( $pr->getTypeID(), $this->m_types ) ? $this->m_types[$pr->getTypeID()]:'text' ) ;
		}
		array_shift( $colstack );
		array_unshift( $colstack, 'label' );

		if ( SRFExhibit::$exhibitRunningNumber == 0 ) {
			$sourcesrc = "var ex_sources = { source" . ( $smwgIQRunningNumber -1 ) . ": { id:  'querytable" . $smwgIQRunningNumber . "' , columns: '" . implode( ',', $colstack ) . "'.split(','), hideTable: '1', type: 'Item', label: 'Item', pluralLabel: 'Items' } };";
		}
		else {
			$sourcesrc = "sources.source" . $smwgIQRunningNumber . " =  { id:  'querytable" . $smwgIQRunningNumber . "' , columns: '" . implode( ',', $colstack ) . "'.split(','), hideTable: '1', type: 'Item', label: 'Item', pluralLabel: 'Items' };";
		}
		$sourcesrc = "<script type=\"text/javascript\">" . $sourcesrc . "</script>";

		// prepare facets
		$facetcounter = 0;
		if ( array_key_exists( 'facets', $this->m_params ) ) {
			$facets = explode( ',', $this->m_params['facets'] );
			$facetstack = array();
			$params = array( 'height' );
			$facparams = array();
			foreach ( $params as $param ) {
				if ( array_key_exists( $param, $this->m_params ) ) $facparams[] = 'ex:' . $param . '="' . $this->encodePropertyName( $this->m_params[$param] ) . '" ';
			}
			foreach ( $facets as $facet ) {
				$facet = trim( $facet );
				$fieldcounter = 0;
				if ( strtolower( $facet ) == "search" ) { // special facet (text search)
					$facetstack[] = ' facet' . $facetcounter++ . ': { position : "right", innerHTML: \'ex:role="facet" ex:showMissing="false" ex:facetClass="TextSearch" ex:facetLabel="' . $facet . '"\'}';
				} else { // usual facet
					foreach ( $res->getPrintRequests() as $pr ) {
						if ( $this->encodePropertyName( $pr->getLabel() ) == $this->encodePropertyName( $facet ) ) {
							switch( $pr->getTypeID() ) {
								case '_num':
									$facetstack[] = ' facet' . $facetcounter++ . ': { position : "right", innerHTML: \'ex:role="facet" ex:showMissing="false" ex:expression=".' . $this->encodePropertyName( $facet ) . '" ex:facetLabel="' . $facet . '" ex:facetClass="Slider"\'}';
									break;
								default:
									$facetstack[] = ' facet' . $facetcounter++ . ': { position : "right", innerHTML: \'ex:role="facet" ex:showMissing="false" ' . implode( " ", $facparams ) . ' ex:expression=".' . $this->encodePropertyName( $facet ) . '" ex:facetLabel="' . $facet . '"\'}';
							}
						}

					}
				}
				$fieldcounter++;
			}
			$facetstring = implode( ',', $facetstack );
		}
		else $facetstring = '';
		$facetsrc = "var ex_facets = {" . $facetstring . " };";


		// prepare views
		$stylesrc = '';
		$viewcounter = 0;
		if ( array_key_exists( 'views', $this->m_params ) ) $views = explode( ',', $this->m_params['views'] );
		else $views[] = 'tiles';

		foreach ( $views as $view ) {
			switch( trim( $view ) ) {
				case 'tabular':// table view (the columns are automatically defined by the selected properties)
					$thstack = array();
					foreach ( $res->getPrintRequests() as $pr ) {
						$thstack[] = "." . $this->encodePropertyName( $pr->getLabel() );
					}
					array_shift( $thstack );
					array_unshift( $thstack, '.label' );
					$stylesrc = 'var myStyler = function(table, database) {table.className=\'smwtable\';};'; // assign SMWtable CSS to Exhibit tabular view
					$viewstack[] = 'ex:role=\'view\' ex:viewClass=\'Tabular\' ex:showSummary=\'false\' ex:sortAscending=\'true\' ex:tableStyler=\'myStyler\'  ex:label=\'Table\' ex:columns=\'' . implode( ',', $thstack ) . '\' ex:sortAscending=\'false\'' ;
					break;
				case 'timeline':// timeline view
					$timeline = true;
					$exparams = array( 'start', 'end', 'proxy', 'colorkey' ); // parameters expecting an Exhibit graph expression
					$usparams = array( 'timelineheight', 'topbandheight', 'bottombandheight', 'bottombandunit', 'topbandunit' ); // parametes expecting a textual or numeric value
					$tlparams = array();
					foreach ( $exparams as $param ) {
						if ( array_key_exists( $param, $this->m_params ) ) $tlparams[] = 'ex:' . $param . '=\'.' . $this->encodePropertyName( $this->m_params[$param] ) . '\' ';
					}
					foreach ( $usparams as $param ) {
						if ( array_key_exists( $param, $this->m_params ) ) $tlparams[] = 'ex:' . $param . '=\'' . $this->encodePropertyName( $this->m_params[$param] ) . '\' ';
					}
					if ( !array_key_exists( 'start', $this->m_params ) ) {// find out if a start and/or end date is specified
						$dates = array();
						foreach ( $res->getPrintRequests() as $pr ) {
							if ( $pr->getTypeID() == '_dat' ) {
								$dates[] = $pr;
								if ( sizeof( $dates ) > 2 ) break;
							}
						}
						if ( sizeof( $dates ) == 1 ) {
							$tlparams[] = 'ex:start=\'.' . $this->encodePropertyName( $dates[0]->getLabel() ) . '\' ';
						}
						elseif ( sizeof( $dates ) == 2 ) {
							$tlparams[] = 'ex:start=\'.' . $this->encodePropertyName( $dates[0]->getLabel() ) . '\' ';
							$tlparams[] = 'ex:end=\'.' . $this->encodePropertyName( $dates[1]->getLabel() ) . '\' ';
						}
					}
					$viewstack[] = 'ex:role=\'view\' ex:viewClass=\'Timeline\' ex:label=\'Timeline\' ex:showSummary=\'false\' ' . implode( " ", $tlparams );
					break;
				case 'map':// map view
					if ( isset( $wgGoogleMapsKey ) ) {
					   $map = true;
					   $exparams = array( 'latlng', 'colorkey' );
					   $usparams = array( 'type', 'center', 'zoom', 'size', 'scalecontrol', 'overviewcontrol', 'mapheight' );
					   $mapparams = array();
					   foreach ( $exparams as $param ) {
						if ( array_key_exists( $param, $this->m_params ) ) $mapparams[] = 'ex:' . $param . '=\'.' . $this->encodePropertyName( $this->m_params[$param] ) . '\' ';
					   }
					   foreach ( $usparams as $param ) {
						if ( array_key_exists( $param, $this->m_params ) ) $mapparams[] = 'ex:' . $param . '=\'' . $this->encodePropertyName( $this->m_params[$param] ) . '\' ';
					   }
					   if ( !array_key_exists( 'start', $this->m_params ) && !array_key_exists( 'end', $this->m_params ) ) { // find out if a geographic coordinate is available
						foreach ( $res->getPrintRequests() as $pr ) {
							if ( $pr->getTypeID() == '_geo' ) {
								$mapparams[] = 'ex:latlng=\'.' . $this->encodePropertyName( $pr->getLabel() ) . '\' ';
								break;
							}
						}
					   }
					   $viewstack[] .= 'ex:role=\'view\' ex:viewClass=\'Map\' ex:showSummary=\'false\' ex:label=\'Map\' ' . implode( " ", $mapparams );
					}
					break;
				default: case 'tiles':// tile view
					$sortstring = '';
					if ( array_key_exists( 'sort', $this->m_params ) ) {
						$sortfields = explode( ",", $this->m_params['sort'] );
						foreach ( $sortfields as $field ) {
							$sortkeys[] = "." . $this->encodePropertyName( trim( $field ) );
						}
						$sortstring = 'ex:orders=\'' . implode( ",", $sortkeys ) . '\' ';
						if ( array_key_exists( 'order', $this->m_params ) ) $sortstring .= ' ex:directions=\'' . $this->encodePropertyName( $this->m_params['order'] ) . '\'';
						if ( array_key_exists( 'grouped', $this->m_params ) ) $sortstring .= ' ex:grouped=\'' . $this->encodePropertyName( $this->m_params['grouped'] ) . '\'';
					}
					$viewstack[] = 'ex:role=\'view\' ex:showSummary=\'false\' ' . $sortstring;
					break;
			}
		}

		$viewsrc = 'var ex_views = "' . implode( "/", $viewstack ) . '".split(\'/\');;';



		// prepare automatic lenses

		global $wgParser;
		$lenscounter = 0;
		$linkcounter = 0;
		$imagecounter = 0;

		if ( array_key_exists( 'lens', $this->m_params ) ) {// a customized lens is specified via the lens parameter within the query
			$lenstitle    = Title::newFromText( "Template:" . $this->m_params['lens'] );
			$lensarticle  = new Article( $lenstitle );
			$lenswikitext = $lensarticle->getContent();

			if ( preg_match_all( "/[\[][\[][Ii][m][a][g][e][:][{][{][{][1-9A-z\-[:space:]]*[}][}][}][\]][\]]/u", $lenswikitext, $matches ) ) {
                                foreach ( $matches as $match ) {
                                        foreach ( $match as $value ) {
                                                $strippedvalue = trim( substr( $value, 8 ), "[[{}]]" );
                                                $lenswikitext = str_replace( $value, '<div class="inlines" id="imagecontent' . $imagecounter . '">' . $this->encodePropertyName( strtolower( str_replace( "\n", "", $strippedvalue ) ) ) . '</div>', $lenswikitext );
                                                $imagecounter++;
                                        }
                                }
                        }

			if ( preg_match_all( "/[\[][\[][{][{][{][1-9A-z\-[:space:]]*[}][}][}][\]][\]]/u", $lenswikitext, $matches ) ) {
				foreach ( $matches as $match ) {
					foreach ( $match as $value ) {
						$strippedvalue = trim( $value, "[[{}]]" );
						$lenswikitext = str_replace( $value, '<div class="inlines" id="linkcontent' . $linkcounter . '">' . $this->encodePropertyName( strtolower( str_replace( "\n", "", $strippedvalue ) ) ) . '</div>', $lenswikitext );
						$linkcounter++;
					}
				}
			}

			if ( preg_match_all( "/[{][{][{][1-9A-z\:\|\/\=\-[:space:]]*[}][}][}]/u", $lenswikitext, $matches ) ) {
				foreach ( $matches as $match ) {
					foreach ( $match as $value ) {
						$strippedvalue = trim( $value, "{}" );
						$lenswikitext = str_replace( $value, '<div class="inlines" id="lenscontent' . $lenscounter . '">' . $this->encodePropertyName( strtolower( str_replace( "\n", "", $strippedvalue ) ) ) . '</div>', $lenswikitext );
						$lenscounter++;
					}
				}
			}

			$lenshtml = $wgParser->internalParse( $lenswikitext );// $wgParser->parse($lenswikitext, $lenstitle, new ParserOptions(), true, true)->getText();

			$lenssrc = "var ex_lens = '" . str_replace( "\n", "", $lenshtml ) . "';ex_lenscounter =" . $lenscounter . ";ex_linkcounter=" . $linkcounter . ";ex_imagecounter=" . $imagecounter . ";";
		} else {// generic lens (creates links to further content (property-pages, pages about values)
			foreach ( $res->getPrintRequests() as $pr ) {
				if ( $remote ) {
					$wikiurl = str_replace( "$1", "", $extlinkpattern );
				} else {
					$wikiurl = $wgScriptPath . "/index.php?title=";
				}
				if ( $pr->getTypeID() == '_wpg' ) {
					$prefix = '';
					if ( $pr->getLabel() == 'Category' ) $prefix = "Category:";
					$lensstack[] = '<tr ex:if-exists=".' . $this->encodePropertyName( $pr->getLabel() ) . '"><td width="20%">' . $pr->getText( 0, $this->mLinker ) . '</td><td width="80%" ex:content=".' . $this->encodePropertyName( $pr->getLabel() ) . '"><a ex:href-subcontent="' . $wikiurl . $prefix . '{{urlencval(value)}}"><div ex:content="value" class="name"></div></a></td></tr>';
				}
				else {
					$lensstack[] = '<tr ex:if-exists=".' . $this->encodePropertyName( $pr->getLabel() ) . '"><td width="20%">' . $pr->getText( 0, $this->mLinker ) . '</td><td width="80%"><div ex:content=".' . $this->encodePropertyName( $pr->getLabel() ) . '" class="name"></div></td></tr>';
				}
			}
			array_shift( $lensstack );
			$lenssrc = 'var ex_lens = \'<table width=100% cellpadding=3><tr><th class="head" align=left bgcolor="#DDDDDD"><a ex:href-subcontent="' . $wikiurl . $this->determineNamespace( clone $res ) . '{{urlenc(.label)}}" class="linkhead"><div ex:content=".label" class="name"></div></a></th></tr></table><table width="100%" cellpadding=3>' . implode( "", $lensstack ) . '</table>\'; ex_lenscounter = 0; ex_linkcounter=0; ex_imagecounter=0;';
		}

		if ( $remote ) {
                         $varremote = 'true';
                } else {
                        $varremote = 'false';
                }

		// Handling special formats like date
		$formatssrc = 'var formats =\'\'';
		if ( array_key_exists( 'date', $this->m_params ) ) $formatssrc = 'var formats = \'ex:formats="date { mode:' . $this->m_params['date'] . '; show:date }"\';';

		// create a URL pointing to the corresponding JSON feed
        $label = '';
		$JSONlink = $res->getQueryLink( $label );
		if ( $this->getSearchLabel( SMW_OUTPUT_WIKI ) != '' ) { // used as a file name
			$link->setParameter( $this->getSearchLabel( SMW_OUTPUT_WIKI ), 'searchlabel' );
		}
		if ( array_key_exists( 'limit', $this->m_params ) ) {
			$JSONlink->setParameter( htmlspecialchars( $this->m_params['limit'] ), 'limit' );
		}
		$JSONlink->setParameter( 'json', 'format' );
		$stringtoedit = explode( "|", $JSONlink->getText( $outputmode, $this->mLinker ) );
		$stringtoedit = substr( $stringtoedit[0], 3 );
		$JSONlinksrc = "var JSONlink = '" . $stringtoedit . "';";

		// create script header with variables containing the Exhibit markup
		$headervars = "<script type='text/javascript'>\n\t\t\t" . $facetsrc . "\n\t\t\t" . $viewsrc . "\n\t\t\t" . $lenssrc . "\n\t\t\t" . $stylesrc . "\n\t\t\t" . $formatssrc . "\n\t\t\t" . $JSONlinksrc . "\n\t\t\t var remote=" . $varremote . ";</script>";


		// To run Exhibit some links to the scripts of the API need to be included in the header

		$ExhibitScriptSrc1 = '<script type="text/javascript" src="' . $srfgScriptPath . '/Exhibit/exhibit/exhibit-api.js?autoCreate=false&safe=true&bundle=false';
		if ( $timeline ) $ExhibitScriptSrc1 .= '&views=timeline';
		if ( $map ) $ExhibitScriptSrc1 .= '&gmapkey=' . $wgGoogleMapsKey;
		$ExhibitScriptSrc1 .= '"></script>';
		$ExhibitScriptSrc2 = '<script type="text/javascript" src="' . $srfgScriptPath . '/Exhibit/SRF_Exhibit.js"></script>';
		$CSSSrc = '<link rel="stylesheet" type="text/css" href="' . $srfgScriptPath . '/Exhibit/SRF_Exhibit.css"></link>';

		SMWOutputs::requireHeadItem( 'CSS', $CSSSrc ); // include CSS
		SMWOutputs::requireHeadItem( 'EXHIBIT1', $ExhibitScriptSrc1 ); // include Exhibit API
		SMWOutputs::requireHeadItem( 'EXHIBIT2', $ExhibitScriptSrc2 ); // includes javascript overwriting the Exhibit start-up functions
		SMWOutputs::requireHeadItem( 'SOURCES' . $smwgIQRunningNumber, $sourcesrc );// include sources variable
		SMWOutputs::requireHeadItem( 'VIEWSFACETS', $headervars );// include views and facets variable


		if ( !$remote ) {

		// print input table
		// print header
		if ( 'broadtable' == $this->mFormat ) $widthpara = ' width="100%"';
		else $widthpara = '';
		$result = "<table style=\"display:none\" class=\"smwtable\" id=\"querytable" . $smwgIQRunningNumber . "\">\n";
		if ( $this->mShowHeaders ) { // building headers
			$result .= "\t<tr>\n";
			foreach ( $res->getPrintRequests() as $pr ) {
				if ( $pr->getText( $outputmode, $this->getLinker( 0 ) ) == '' ) $headerlabel = "Name";
				else $headerlabel = $pr->getText( $outputmode, $this->getLinker( 0 ) );
				$result .= "\t\t<th>" . $headerlabel . "</th>\n";
			}
			$result .= "\t</tr>\n";
		}

		// print all result rows
		while ( $row = $res->getNext() ) {
			$result .= "\t<tr>\n";
			foreach ( $row as $field ) {
				$result .= "\t\t<td>";
				$textstack = array();
				while ( ( $object = $field->getNextDataValue() ) !== false ) {
					switch( $object->getTypeID() ) {
						case '_wpg':
							$textstack[] = $object->getLongText( $outputmode, $this->getLinker( 0 ) );
							break;
						case '_geo':
							$c = $object->getDBKeys();
							$textstack[] = $c[0] . "," . $c[1];
							break;
						case '_num':
							if ( method_exists( $object, 'getValueKey' ) ) {
								$textstack[] = $object->getValueKey( $outputmode, $this->getLinker( 0 ) );
							}
							else {
								$textstack[] = $object->getNumericValue( $outputmode, $this->getLinker( 0 ) );
							}
							break;
						case '_dat':
							$textstack[] = $object->getYear() . "-" . str_pad( $object->getMonth(), 2, '0', STR_PAD_LEFT ) . "-" . str_pad( $object->getDay(), 2, '0', STR_PAD_LEFT ) . " " . $object->getTimeString();
							break;
						case '_ema':
							$textstack[] =  $object->getShortWikiText( $this->getLinker( 0 ) );
							break;
						case '_tel': case '_anu': case '_uri':
							$textstack[] = $object->getWikiValue();
							break;
						case '__sin':
							$tmp = $object->getShortText( $outputmode, null );
							if ( strpos( $tmp, ":" ) ) {
								$tmp = explode( ":", $tmp, 2 );
								$tmp = $tmp[1];
							}
							$textstack[] = $tmp;
							break;
						case '_txt': case '_cod': case '_str':
							$textstack[] = $object->getWikiValue();
							break;
						default:
							$textstack[] = $object->getLongHTMLText( $this->getLinker( 0 ) );
					}
				}

				if ( $textstack != null ) {
					$result .= implode( ';', $textstack ) . "</td>\n";
				}
				else $result .= "</td>\n";
			}
			$result .= "\t</tr>\n";
		}
		$result .= "</table>\n"; }

		if ( SRFExhibit::$exhibitRunningNumber == 0 ) $result .= "<div id=\"exhibitLocation\"></div>"; // print placeholder (just print it one time)
		$this->isHTML = ( $outputmode == SMW_OUTPUT_HTML ); // yes, our code can be viewed as HTML if requested, no more parsing needed
		SRFExhibit::$exhibitRunningNumber++;
		return $result;
	}

	/**
	 * @see SMWResultPrinter::getParamDefinitions
	 *
	 * @since 1.8
	 *
	 * @param $definitions array of IParamDefinition
	 *
	 * @return array of IParamDefinition|array
	 */
	public function getParamDefinitions( array $definitions ) {
		$params = parent::getParamDefinitions( $definitions );

		$params[] = array( 'name' => 'views', 'message' => 'srf_paramdesc_views', 'islist' => true, 'values' => array( 'tiles', 'tabular', 'timeline', 'maps' ) );
		$params[] = array( 'name' => 'facets', 'message' => 'srf_paramdesc_facets' );
		$params[] = array( 'name' => 'lens', 'message' => 'srf_paramdesc_lens' );

		return $params;
	}

}
