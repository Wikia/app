<?php
/*
 * MV_MagicWords.php Created on May 16, 2007
 *
 * All Metavid Wiki code is Released under the GPL2
 * for more info visit http://metavid.org/wiki/Code
 * 
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.org
 *
 * magic words has all parser rewrite keys functions
 * format is {{#mvData:magicTypeKey|format=format|num_results=#}} etc   
 */
if ( !defined( 'MEDIAWIKI' ) )  die( 1 );
class MV_MagicWords {
	var $args = array();
	
	// list of valid arguments and their default value:
	var $params = array ( 'format' => 'ul_list', 'num_results' => 5,
						 'time_range' => 'last_week', 'class' => '',
						 'person' => '', 'bill' => '' );
	
	function __construct( $arg_list ) {
		// print_r($arg_list);
		$this->proccessArgs( $arg_list );
	}
	function proccessArgs( $arg_list ) {
		$this->magicTypeKey = $arg_list[0];
		foreach ( array_slice( $arg_list, 1 ) as $inx => $arg ) {
			if ( strpos( $arg, '=' ) === false ) {
				// get param via index order (not as reliable as param=value mode)
				switch( $inx ) {
					case '0':
						$this->params['format'] = $arg;
					break;
					case '1':
						$this->params['num_results'] = $arg;
					break;
				}
			} else {
				list( $arg_type, $arg_value ) = split( '=', $arg );
				// make sure the arg_type is a valid argument
				if ( isset( $this->params[$arg_type] ) ) {
					$this->params[$arg_type] = $arg_value;
				}
			}
		}
	}
	function renderMagic() {
		switch( $this->magicTypeKey ) {
			case 'TOPSEARCHES':
				return $this->getTopSearches();
			break;
			case 'POPULARCLIPS':
				return $this->getTopClips();
			break;
			case 'PERSONSPEECHES':
				return $this->getPersonOut();
			break;
			case 'VIDEOBILL':
				return $this->getBillOut();
			break;
			default:
				return "error: unknown mvData function: <b>{$this->magicTypeKey}</b> <br>";
			break;
		}
	}
	function getBillOut() {
		// return 'bill results';
		if ( $this->params['bill'] != '' ) {
			$bill_name = $this->params['bill'];
		} else {
			return "error: no person provided";
		}
		$ms = new MV_SpecialMediaSearch();
		$_REQUEST['limit'] = $this->params['num_results'];
		$ms->filters[] = array ( 'a' => 'and', 't' => 'bill', 'v' => $bill_name );
		$ms->doSearch( $log_search = false );
		return $ms->getUnifiedResultsHTML( $show_sidebar = false );
	}
	function getPersonOut() {
		if ( $this->params['person'] != '' ) {
			$person_name = $this->params['person'];
		} else {
			return "error: no person provided";
		}
		$ms = new MV_SpecialMediaSearch();
		$_REQUEST['limit'] = $this->params['num_results'];
		
		// set limit by global: 
		global $mvMediaSearchResultsLimit;
		$pgsl = $mvMediaSearchResultsLimit;
		$mvMediaSearchResultsLimit	= $this->params['num_results'];
		
		$ms->filters[] = array ( 'a' => 'and', 't' => 'spoken_by', 'v' => $person_name );
		$ms->doSearch( $log_search = false );
		
		$mvMediaSearchResultsLimit = $pgsl;
		return $ms->getUnifiedResultsHTML( $show_sidebar = false );
	}
	function getStartTime() {
	$start_time = 0;
		// be sure to define 'mv_date_last_week' in messeges  
		switch( $this->params['time_range'] ) {
			case 'last_week':$start_time = time() - ( 7 * 24 * 60 * 60 ); break;
		}
		// round to nearest previus hour: 
		$round_sec = 60 * 60;
		if ( $start_time != 0 ) {
			$start_time = floor( $start_time / $round_sec ) * $round_sec;
		}
		return $start_time;
	}
	// gets the top few clip ranges
	function getTopClips() {
		$dbr = & wfGetDB( DB_READ );
		$o = '';
		$vars = array( 'query_key', 'stream_id', 'start_time', 'end_time', 'COUNT(1) as hit_count' );
		$conds = array( 'view_date >=' . $dbr->addQuotes( $this->getStartTime() ) );
		$options = 	array( 'GROUP BY' => 'query_key', 'ORDER BY' => '`hit_count`  DESC ',
				 		'LIMIT' => ( $this->params['num_results'] ) );
		$result = $dbr->select( 'mv_clipview_digest',
					$vars,
					$conds,
					__METHOD__,
			 		$options
				);
		if ( $dbr->numRows( $result ) == 0 ) {
 			return '';
 		} else {
 			if ( $this->params['format'] == 'ul_list' ) {
 				$class_attr = ( $this->params['class'] != '' ) ? ' class="' . $this->params['class'] . '"':'';
 				$o .= '<ul' . $class_attr . '>';
 			}
 			global $wgUser;
 			$sk = $wgUser->getSkin();
 			while ( $row = $dbr->fetchObject( $result ) ) {
 				$o .= '<li>';
 				$person_ht = $bill_ht = $category_ht = '';
 				// first make link and stream title:
 				$mvStream = MV_Stream::newStreamByID( $row->stream_id );
 				$nt = $mvStream->getStreamName() . '/' . seconds2ntp( $row->start_time )
 							. '/' . seconds2ntp( $row->end_time );
 				$mvTitle = new MV_Title( $nt, MV_NS_STREAM );
 				
 				$mvStreamTitle = Title :: MakeTitle( MV_NS_STREAM, $mvTitle->getNearStreamName( $extra_range = '0' ) );
 				
 				
 				// output the image: 
 				$o .= $sk->makeKnownLinkObj( $mvStreamTitle,
	 					'<img alt="image for ' . $mvTitle->getStreamNameText() . ' ' .
	 						 $mvTitle->getTimeDesc() . '" src="' . $mvTitle->getStreamImageURL( 'small' ) .
	 					'"/>',
 					'tl=1' );
 				$title_span = '';
 				if ( isset( $mvStream->date_start_time ) ) {
 					$parts = split( '_', $mvStream->getStreamName() );
 					if ( count( $parts ) >= 3 ) {
 						$title_span = ucfirst( $parts[0] . ' ' );
 					} else {
 						$title_span = $mvStream->getStreamName();
 					}
 					$title_span .= date( 'F jS, Y', $mvStream->date_start_time );
 				} else {
 					$title_span = $mvTitle->getStreamNameText() . $mvTitle->getTimeDesc();
 				}
 				$o .= '<span class="title">' .
 						$sk->makeKnownLinkObj( $mvStreamTitle,
 							  $title_span,
 							  'tl=1' ) .
 					'</span>';
 				// try to get metadata from anno_en first.
 				// @@todo maybe the following metadata grabbing could be abstracted to a single function in mv_index  			
 				$mvd_rows = MV_Index::getMVDInRange(
 								$row->stream_id,
 								$row->start_time,
 								$row->end_time,
 								$mvd_type = 'anno_en',
 								$getText = true,
 								$smw_properties = array( 'Speech_by', 'Bill', 'category' ),
 								$options = array( 'limit' => 1 )
 							);
 				if ( count( $mvd_rows ) != 0 ) {
 					reset( $mvd_rows );
 					$mvd_row = current( $mvd_rows );
 					// print_r($mvd_rows);
 					// print "type of: " . gettype($mvd_row);
 					if ( isset( $mvd_row->Speech_by ) ) {
 						if ( trim( $mvd_row->Speech_by ) != '' ) {
	 						$ptitle = Title::MakeTitle( NS_MAIN, $mvd_row->Speech_by );
	 						$o .= '<span class="keywords">' .
	 								$sk->makeKnownLinkObj( $ptitle, $ptitle->getText() ) .
	 							'</span>';
 						}
 					}
 					if ( isset( $mvd_row->Bill ) ) {
 						if ( trim( $mvd_row->Bill ) != '' ) {
	 						$btitle = Title::MakeTitle( NS_MAIN, $mvd_row->Bill );
	 						$o .= '<span class="keywords">Bill:' .
	 								$sk->makeKnownLinkObj( $btitle ) . '
	 							</span>';
 						}
 					}
 					global $wgContLang;
 					/*$mvdNStxt = $wgContLang->getNsText(MV_NS_MVD);
 					//grab categories:  		
 					 $cl_res = $dbr->select('categorylinks', 'cl_to', 
 					 				array('cl_sortkey'=>$mvdNStxt.':'.str_replace('_',' ',$mvd_row->wiki_title)),
 					 				'getTopClips::Categories',
 					 				'LIMIT 0, 5'); 				
 					 if($dbr->numRows($cl_res)!=0){
 					 	$o.='<span class="keywords">Categories: ';
 					 	$coma='';
 					 	while($cl_row= $dbr->fetchObject($cl_res) ){
 					 		$cTitle =  Title::MakeTitle(NS_CATEGORY, $cl_row->cl_to);
 					 		$o.=$coma.$sk->makeKnownLinkObj($cTitle, $cTitle->getText());
 					 		$coma=', ';
 					 	}
 					 	$o.='</span>';
 					 } */
 				}
 				$o .= '</li>';
 			}
 			$o .= '</ul><div style="clear:both"></div>';
 		}
 		return $o;
	}
	// get the top few search results this is a ~slow~ query ... 
	// @@todo we should only run it every 2 hours or something..  
	function getTopSearches() {
		$dbr =& wfGetDB( DB_READ );
		$o = '';
		$options = array();
		/*$result = $dbr->select('mv_search_digest', '`query_key`, COUNT(1) as `hit_count`', "`time` >= '$start_time' ",
				 __METHOD__,
				 array('GROUP BY' => 'query_key', 'ORDER BY `hit_count` ASC', 
				 		'LIMIT 0,'.$this->params['num_results']) );*/
		/*$sql="SELECT `mv_search_digest`.`query_key`, COUNT(1) as `hit_count`, `mv_query_key_lookup`.`filters`
			  FROM `mv_search_digest`
			  LEFT JOIN `mv_query_key_lookup` ON (`mv_search_digest`.`query_key` = `mv_query_key_lookup`.`query_key`)
			  WHERE `time` >= '{$this->getStartTime()}' GROUP BY `mv_search_digest`.`query_key` 
			  LIMIT 0, {$this->params[num_results]}";*/
		// $from_tables 
		$vars = array( $dbr->tableName( 'mv_search_digest' ) . '.query_key',
					  'COUNT(1) as `hit_count`',
					  $dbr->tableName( 'mv_query_key_lookup' ) . '.filters' );
		$from_tables = $dbr->tableName( 'mv_search_digest' ) .
						' LEFT JOIN' . $dbr->tableName( 'mv_query_key_lookup' ) .
							' ON ( ' .
								$dbr->tableName( 'mv_search_digest' ) . '.query_key = ' .
								$dbr->tableName( 'mv_query_key_lookup' ) . '.query_key ' .
							' ) ';
		$conds = '`time` >= ' . $dbr->addQuotes( $this->getStartTime() );
							
		$options['GROUP BY'] = $dbr->tableName( 'mv_search_digest' ) . '.query_key';
		$options['ORDER BY'] = '`hit_count`  DESC';
		$options['LIMIT'] = $this->params['num_results'];
		
		$result = $dbr->select( $from_tables,
			$vars,
			$conds,
			__METHOD__,
			$options );
		if ( $dbr->numRows( $result ) == 0 ) {
 			return '';
 		} else {
 			// @@todo probably should try to abstract out formating.. 
 			// but will need to wait until we have a few more test cases to do a productive abstraction
 			if ( $this->params['format'] == 'ul_list' ) {
 				$class_attr = ( $this->params['class'] != '' ) ? ' class="' . htmlspecialchars( $this->params['class'] ) . '"':'';
 				$o .= '<ul' . $class_attr . '>';
 			}
 			$mvms = new MV_SpecialMediaSearch();
 			$sTitle = Title::MakeTitle( NS_SPECIAL, 'MediaSearch' );
 			while ( $row = $dbr->fetchObject( $result ) ) {
 				$title_desc = htmlspecialchars( $row->hit_count ) . ' ' . wfMsg( 'mv_date_' . $this->params['time_range'] );
 				$mvms->loadFiltersFromSerialized( $row->filters );
 				$o .= '<li><a title="' . $title_desc . '" href="' . $sTitle->escapeLocalURL( $mvms->get_httpd_filters_query() . '&tl=1'  ) . '">' .
						$mvms->getFilterDesc( $query_key = true ) .
					'</li>';
 			}
 			if ( $this->params['format'] == 'ul_list' ) {
 				$o .= '</ul>';
 			}
 		}
 		return $o;
	}
}

?>