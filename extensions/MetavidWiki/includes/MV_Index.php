<?php
/*
 * MV_Index.php Created on May 16, 2007
 *
 * All Metavid Wiki code is Released under the GPL2
 * for more info visit http://metavid.org/wiki/Code
 *
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.org
 *
 */
 /*
  * maintains the index table state on various updates
  * (need for indexed time ranged queries)
  * (currently stored in a mysql table)
  * in the future we should shift this to a search engine of some sort
  * (ie lucene or sphinx) or just do everything with semantic relations
  * if we can get the speed to an acceptable level...
  *
  * keep an additional copy of the text table is not ideal but...
  * we keep a copy of every version of the page so its not so bad ;P
  */
if ( !defined( 'MEDIAWIKI' ) )  die( 1 );

 class MV_Index {
	var $mvTitle = null;
	function __construct( & $mvTitle = null ) {
		if ( $mvTitle != null )
			$this->mvTitle = $mvTitle;
	}
	
	function countMVDInRange( $stream_id, $start_time = null, $end_time = null, $mvd_type = 'all' ) {
		global $mvDefaultClipLength;
		$dbr =& wfGetDB( DB_SLAVE );

		$cond = array( 'stream_id' => $stream_id );
		if ( $end_time )
			$cond[] = 'AND start_time <= ' . $dbr->addQuotes( $end_time );
		if ( $start_time )
			$cond[] = 'AND end_time >= ' . $dbr->addQuotes( $start_time );
		return $dbr->selectField( 'mv_mvd_index', 'COUNT(1)', $cond,  __METHOD__ );
	}
	/*
	 * getMVDInRange returns the mvd titles that are in the given range
	 * param list got kind of crazy long... @@todo re-factor int a request object or something cleaner
	 */
	function getMVDInRange( $stream_id, $start_time = null, $end_time = null, $mvd_type = 'all', $getText = false, $smw_properties = '', $options = array() ) {
		global $mvDefaultClipLength;
		$dbr =& wfGetDB( DB_SLAVE );
		// set up select vars:
		$conds = $vars = array();
		$from_tables = '';
		$do_cat_lookup = $do_smw_lookup = false;
		//
		// set mvd_type if empty:
		if ( $mvd_type == null )$mvd_type = 'all';
		if ( $start_time < 0 )$start_time = 0;
		// add base select vars:
		$vars = array( 'mv_page_id as id', 'mvd_type', 'wiki_title', 'stream_id', 'start_time', 'end_time' );
		// add in base from:
		$from_tables .= $dbr->tableName( 'mv_mvd_index' );
		$conds = array( 'stream_id' => $stream_id );
		// print_r($smw_properties);		
		if ( $smw_properties != '' ) {
			if ( !is_array( $smw_properties ) )
				$smw_properties = explode( ',', $smw_properties );
			foreach ( $smw_properties as $prop_name ) {
				if ( $prop_name == 'category' ) {
					$do_cat_lookup = true;
				} else {
					if ( SMW_VERSION >= 1.2 ) {						
						// the following is too slow to use but gennerally works:
						// has to be rewritten with sub-queries or something more elaborate
						// for now just do lookup after the fact
						$do_smw_lookup = true;
						/*$esc_p = mysql_real_escape_string($prop_name);
						$vars[] = $esc_p.'.`smw_title` AS `'.
									$esc_p.'` ';
						$from_tables.=' ,'.
							' ' . $dbr->tableName('smw_rels2') . ' as `'.$esc_p.'_rels2`'. 
							' JOIN `smw_ids` AS `'.$esc_p.'_pname` '. 
								' ON ( '. 
								' `'.$esc_p.'_rels2`.`p_id` = `'.$esc_p.'_pname`.`smw_id`
									AND `'.$esc_p.'_pname`.`smw_title` LIKE CONVERT( _utf8 '.
											$dbr->addQuotes($esc_p).
										' USING latin1 ) COLLATE latin1_general_ci '.										
							' ) ' . 
							' LEFT JOIN `smw_ids` AS `'.$esc_p.'stext` ' . 
								' ON ( '.
								' `'.$esc_p.'_rels2`.`s_id` = `'.$esc_p.'stext`.`smw_id` '.
								' ) ' . 							
							'LEFT JOIN `smw_ids` AS `'.mysql_real_escape_string($prop_name).'` '. 
								' ON ( '.
								' `'.$esc_p.'_rels2`.`o_id` = `'.mysql_real_escape_string($prop_name).'`.`smw_id`'.  
								' ) ';
						$conds[]=' `'.$esc_p.'stext`.`smw_title` = `mv_mvd_index`.`wiki_title` ';
						break; 		
						*/
					} else {
						$vars[] = mysql_real_escape_string( $prop_name ) . '.object_title as ' . mysql_real_escape_string( $prop_name );
						$from_tables .= ' ' .
							' LEFT JOIN ' . $dbr->tableName( 'smw_relations' ) .
							' as ' . mysql_real_escape_string( $prop_name ) .
							' ON (' . $dbr->tableName( 'mv_mvd_index' ) . '.mv_page_id' .
							' = ' . mysql_real_escape_string( $prop_name ) . '.subject_id' .
							' AND ' . mysql_real_escape_string( $prop_name ) . '.relation_title' .
							' = ' . $dbr->addQuotes( $prop_name ) . ')';
					}
				}
			}
		}
		if ( $mvd_type != 'all' ) {
			$mvd_type = ( is_object( $mvd_type ) ) ? get_object_vars( $mvd_type ):$mvd_type;
			if ( is_array( $mvd_type ) ) {
				$mvd_type_cond = $or = '';
				foreach ( $mvd_type as $mtype ) {
					// @@todo confirm its a valid mvd_type:
					$mvd_type_cond .= $or . "mvd_type=" . $dbr->addQuotes( $mtype );
					$or = ' OR ';
				}
				$conds[] = $mvd_type_cond;
			} else if ( is_string( $mvd_type ) ) {
				$conds['mvd_type'] = $mvd_type;
			}

		}
		// print "Start time: $start_time END TIME: $end_time\n";
		if ( $end_time != null )
			$conds[] = 'start_time <= ' . $dbr->addQuotes( $end_time );
			
		if ( $start_time != null )
			$conds[] = 'end_time >= ' . $dbr->addQuotes( $start_time );
			
		// add in ordering
		if ( !isset( $options['ORDER BY'] ) )
			$options['ORDER BY'] = 'start_time ASC';
			
		// add in limit
		if ( !isset( $options['LIMIT'] ) )
			$options['LIMIT'] = 200;
						
		// run query:
		$result = $dbr->select( $from_tables,
			$vars,
			$conds,
			__METHOD__,
			$options );
		// print $dbr->lastQuery();
		// die;
		if ( $dbr->numRows( $result ) == 0 )return array();
		$ret_ary = array();
		$from_tables = $vars = $options = array();
		$conds = '';
		$or = '';
		while ( $row = $dbr->fetchObject( $result ) ) {
			$ret_ary[$row->id] = $row;
			// init array:			
			if ( $do_cat_lookup ) {
				if ( !isset( $ret_ary[$row->id]->category ) )
					$ret_ary[$row->id]->category = array();
				if ( $do_cat_lookup ) {
					$conds .= $or . ' cl_from =' . $dbr->addQuotes( $row->id );
					$or = ' OR ';
				}
			}
		}
		if ( $do_cat_lookup ) {
			$from_tables = $dbr->tableName( 'categorylinks' );
			$from_tables .= ' LEFT JOIN ' . $dbr->tableName( 'mv_mvd_index' ) .
						  	' ON ( ' .
								 $dbr->tableName( 'categorylinks' ) . '.cl_from = ' .
								 $dbr->tableName( 'mv_mvd_index' ) . '.mv_page_id' .
							' ) ';
						
			$vars = array( 'cl_from', 'cl_to' );
			
			$options['LIMIT'] = 2000; // max avarage 5 categories per page

			$result_cat = $dbr->select( $from_tables,
				$vars,
				$conds,
				__METHOD__,
				$options );
			while ( $cat_row = $dbr->fetchObject( $result_cat ) ) {
				$ret_ary[$cat_row->cl_from]->category[] = $cat_row->cl_to;
			}
		}
		// slow epecialy for lots of query results but join Query is crazy complicated for SMW >= 1.2 
		// (and I have not been able to construct it without hitting exessive number of rows in the EXPLIN) 
		// @@todo these queries should be merged with semantic wiki Ask with some ~special~ keywords for fulltext search
		if ( $do_smw_lookup ) {
			$smwStore =& smwfGetStore();
			foreach ( $ret_ary as & $row ) {
                $rowTitle = Title::newFromText( $row->wiki_title, MV_NS_MVD );
                foreach ( $smw_properties as $propKey ) {
                	if ( $propKey != 'category' ) {
	                	// init property: 
	                	$row->$propKey = '';
	                	$propTitle = Title::newFromText( $propKey, SMW_NS_PROPERTY );
		                $smwProps = $smwStore->getPropertyValues( $rowTitle, $propTitle );
						// just a temp hack .. we need to think about this abstraction a bit...
						if ( count( $smwProps ) != 0 ) {
							$v = current( $smwProps );
							$row->$propKey = $v->getXSDValue();
						}
                	}
                }
			}
		}
		// print_r($ret_ary);
		// die;

		
		// print $dbr->lastQuery();
		// die;
		// echo $sql;
		// $result =& $dbr->query( $sql, 'MV_Index:time_index_query');
		return $ret_ary;
	}
	/*@@todo figure another way to get at this data...this is not a very fast query: */
	function getMVDTypeInRange( $stream_id, $start_time = null, $end_time = null ) {
		$dbr =& wfGetDB( DB_SLAVE );
		// init vars
		$from_tables = $vars =	$conds = $options = array();

		$from_tables = $dbr->tableName( 'mv_mvd_index' );
		$vars = 'COUNT(*) as count, mvd_type';
		$conds = array( 'stream_id' => $stream_id );
		if ( $end_time )
			$cond[] = ' AND start_time <= ' . $dbr->addQuotes( $end_time );
		if ( $start_time )
			$cond[] = ' AND end_time >= ' . $dbr->addQuotes( $start_time );
		$options['GROUP BY'] =	'mvd_type';
		return $dbr->select( $from_tables,
			$vars,
			$conds,
			__METHOD__,
			$options );	;
	}
	function remove_by_stream_id( $stream_id ) {
		$dbw =& wfGetDB( DB_WRITE );
		$dbw->delete( 'mv_mvd_index', array( 'stream_id' => $stream_id ) );
	}
	/*
	 * removes a single entry by wiki_title name
	 */
	function remove_by_wiki_title( $wiki_title ) {
		$dbw =& wfGetDB( DB_WRITE );
		$dbw->delete( 'mv_mvd_index', array( 'wiki_title' => $wiki_title ) );
		// print "ran sql:" . $dbw->lastQuery() . "\n";
		return true;
	}
	function doUnifiedFiltersQuery( &$filters, $metaDataIncludes = null ) {
		global $mvDefaultClipLength,
		 $wgRequest, $mvDo_SQL_CALC_FOUND_ROWS, $mvMediaSearchResultsLimit;

		global $mvSpokenByInSearchResult, $mvCategoryInSearchResult, $mvBillInSearchResult;
		
		
		// init vars
		$from_tables = '';
		$vars =	$conds = $options = array();
		// init top range generation query
		$from_tables_top = '';
		$vars_top =	$conds_top = $options_top = array();

		$do_top_range_query = false;
	

		$dbr =& wfGetDB( DB_SLAVE );
		// organize the queries (group full-text searches and category/attributes)
		// if the attribute is not a numerical just add it to the fulltext query
		$ftq_match_asql = $last_person_aon = $ftq_match = $ftq = $snq = $toplq = $toplq_cat = $date_range_join = $date_range_where = $asql = ''; // top query and full text query =''
		if ( $filters == '' )return array();
		$ftq_match_asql = $date_cond = '';
		
		$date_range_join = true;

		// $selOpt = ($mvDo_SQL_CALC_FOUND_ROWS)?'SQL_CALC_FOUND_ROWS':'';
		if ( $mvDo_SQL_CALC_FOUND_ROWS )
			$options[] = 'SQL_CALC_FOUND_ROWS';

		// set limit offset:
		list( $this->limit, $this->offset ) = $wgRequest->getLimitOffset( 20, 'searchlimit' );
		if ( $this->limit > $mvMediaSearchResultsLimit )$this->limit = $mvMediaSearchResultsLimit;

		$this->order = strtolower( $wgRequest->getVal( 'order' ) );
		// force order type:
		if ( !( $this->order == 'relevant' || $this->order == 'recent' || $this->order == 'viewed' ) )$this->order = 'recent';


		$group_spoken = true;
		// $categoryTable =  ;
		$valid_filter_count = 0;
		foreach ( $filters as $f ) {
			// proocc and or for fulltext:
			if ( !isset( $f['a'] ) )$f['a'] = 'and';
			switch( $f['a'] ) {
				case 'and':$aon = '+'; $asql = 'AND'; break;
				case 'or':$aon = ''; $asql = 'OR'; break;
				case 'not':$aon = '-'; $asql = 'NOT'; break;
			}
			// add to the fulltext query:
			switch( $f['t'] ) {
				case 'speech_by':		
				case 'spoken_by':
					$skey = str_replace('_', ' ', $f['t']);					
					// skip if empty value:
					if ( trim( $f['v'] ) == '' )continue;
					// if we have an OR set prev to OR
					if ( $last_person_aon == '+' && $aon == '' ) {
						$ftq = str_replace( '+"'.$skey, '"'.$skey, $ftq );
						$group_spoken = false;
					}
					// full text based semantic query:
					$ftq .= ' ' . $aon . '"'.$skey.' ' . mysql_real_escape_string( $f['v'] ) . '" ';
					// table based query:
					$last_person_aon = $aon;
					$valid_filter_count++;
					// $conds[]=
				break;
				case 'bill':
					// skip if empty value:
					if ( trim( $f['v'] ) == '' )continue;
					$f['v'] = str_replace( array( '.', '_', ':' ), ' ', $f['v'] );
					// full text based semantic query:
					$ftq .= ' ' . $aon . '"bill ' . mysql_real_escape_string( $f['v'] ) . '" ';
					// table based query:
					$last_person_aon = $aon;
					$valid_filter_count++;
					// $conds[]=
				break;
				case 'match':
					// skip if empty value:
					if ( trim( $f['v'] ) == '' )continue;
					$mwords = explode(' ', $f['v']);
					$space='';
					foreach($mwords as $word){
						$ftq_match .=$space. $aon . mysql_real_escape_string( $word );
						$space=' ';
					}
					// only need to split out ftq match if spoken by is more than one
					if ( $ftq_match_asql != '' )
						$ftq_match_asql = $asql;
					$valid_filter_count++;
				break;
				// top level queries  (sets up time ranges )
				case 'category':
					// skip if empty value:
					if ( trim( $f['v'] ) == '' )continue;
					$do_top_range_query = true;
					// full text based category query:
					$toplq .= ' ' . $aon . '"category ' . mysql_real_escape_string( $f['v'] ) . '" ';
					// $ftq.=' '.$aon.'category:'.mysql_escape_string($f['v']);

					// table based query:
					switch( $f['a'] ) {
						case 'and':$toplq_cat = 'AND'; break;
						case 'or':$toplq_cat = 'OR'; break;
						case 'not':$toplq_cat = 'NOT'; break;
					}
					$toplq_cat .= $dbr->tableName( 'categorylinks' ) . '.cl_to=' . $dbr->addQuotes( $f['v'] );
					$valid_filter_count++;
				break;
				case 'date_range':
					list( $month, $day, $year ) = explode( '/', $f['vs'] );
					$sts = mktime( 0, 0, 0, $month, $day, $year );
					list( $month, $day, $year ) = explode( '/', $f['ve'] );
					$ets = mktime( 0, 0, 0, $month, $day + 1, $year ); // (the start of the next day)
					// add date condtion:
					// note dissable and or for date range for now: $asql
					$conds[] = ' ( `mv_streams`.`date_start_time` > '
														. $dbr->addQuotes( $sts ) .
												 ' AND `mv_streams`.`date_start_time` < ' . $dbr->addQuotes( $ets ) .
										') ';
					// print	$date_cond;
					$valid_filter_count++;
				break;
				case 'stream_name':
					// skip if empty value:
					if ( trim( $f['v'] ) == '' )continue;
					$stream =& mvGetMVStream( $f['v'] );
					// add stream cond
					$conds[] = $asql . " stream_id = " . $dbr->addQuotes( $stream->getStreamId() );
					$valid_filter_count++;
				break;
				case 'smw_property':
					//@@todo merge doUnifiedFiltersQuery function with SMW Ask more complicated query work needed
				break;
			}
		}
		if ( $valid_filter_count == 0 ) {
			return array();
		}
		// add the top query to the base query:
		$ftq .= $toplq;
		$vars = "mv_page_id as id," . $dbr->tableName( 'mv_mvd_index' ) . '.stream_id,
			(' . $dbr->tableName( 'mv_streams' ) . '.date_start_time+' . $dbr->tableName( 'mv_mvd_index' ) .
			'.start_time) AS mvd_date_start_time, ' .
			'start_time, end_time, view_count, wiki_title,' .
			$dbr->tableName( 'searchindex' ) . '.si_text AS `text` ';

		/*if ( $mvSpokenByInSearchResult )
			$vars .= ', smw_relations.object_title as spoken_by ';*/

		$from_tables .= $dbr->tableName( 'mv_mvd_index' ) . ' ';
		$from_tables .= 'JOIN ' . $dbr->tableName( 'searchindex' ) .
				' ON (' .
					 $dbr->tableName( 'mv_mvd_index' ) . '.mv_page_id = ' .
					 $dbr->tableName( 'searchindex' ) . '.si_page ) ';

		if ( $date_range_join )
			$from_tables .= 'LEFT JOIN ' . $dbr->tableName( 'mv_streams' ) .
				' ON (' .
					$dbr->tableName( 'mv_mvd_index' ) . '.stream_id = ' .
					$dbr->tableName( 'mv_streams' ) . '.id ) ';

		// print "FROM TABLES:". $from_tables;

		// restrict to streams with valid $mvDefaultVideoQualityKey files:
		global $mvDefaultVideoQualityKey;
		$from_tables .= 'JOIN ' . $dbr->tableName( 'mv_stream_files' ) .
				' ON ' .
				'( ' . $dbr->tableName( 'mv_mvd_index' ) . '.stream_id = ' .
					$dbr->tableName( 'mv_stream_files' ) . '.stream_id ' .
					' AND ' . $dbr->tableName( 'mv_stream_files' ) . '.file_desc_msg = ' .
					$dbr->addQuotes( $mvDefaultVideoQualityKey ) .
				') ';

		// date range join:

		// include spoken by relation in results (LEFT JOIN should not be *that* costly )
		/*if ( $mvSpokenByInSearchResult ) {
			//$sql.="LEFT JOIN `smw_relations` ON (`mv_mvd_index`.`mv_page_id`=`smw_relations`.`subject_id` " .
			//	"AND `smw_relations`.`relation_title`='Spoken_By') ";
			$from_tables .= 'LEFT JOIN ' . $dbr->tableName( 'smw_relations' ) .
				' ON ' .
				'( ' . $dbr->tableName( 'mv_mvd_index' ) . '.mv_page_id = ' .
					$dbr->tableName( 'smw_relations' ) . '.subject_id ' .
					' AND ' . $dbr->tableName( 'smw_relations' ) . '.relation_title = \'Spoken_By\'' .
				 ') ';
		}*/
		
		// add conditions to last condition element (cuz we have to manually mannage and or):

		$conds[count( $conds )] = ' ' . $dbr->tableName( 'mv_mvd_index' ) . '.mvd_type = \'ht_en\' ' .
					' OR ' . $dbr->tableName( 'mv_mvd_index' ) . '.mvd_type=\'anno_en\'  ';

		// limit to ht_en & anno_en (for now) (future allow selection
		// $conds_inx = (count($conds)==0)?0:count($conds)-1;
		$two_part_anor = '';
		if ( $group_spoken ) {
			$ftq .= $ftq_match;
		} else {
			if ( $ftq_match != '' ) {
				$conds[] .= $ftq_match_asql . ' MATCH ( ' . $dbr->tableName( 'searchindex' ) . '.si_text )' .
					  ' AGAINST(\'' . $ftq_match . '\' IN BOOLEAN MODE) ';
				// if($ftq!='')$sql.=' AND ';
			}
		}
		if ( $ftq != '' ) {
			$conds[] .= "	MATCH ( " . $dbr->tableName( 'searchindex' ) . '.si_text ) ' .
				' AGAINST(\'' . $ftq . '\' IN BOOLEAN MODE) ';
		}
		// print_r($conds);
		// die;
		// date range stuff is SLOW when its the only filter (pulls up matches for everything)
		/*if($snq!='' || $ftq!='' && isset($date_range_andor))
			$sql.=$date_range_andor;
		$sql.=" $date_range_where ";*/

		switch( $this->order ) {
			case 'relevant':
				// @@todo need to add in some relevence metrics
			break;
			case 'recent':
				$options['ORDER BY'] = 'mvd_date_start_time DESC ';
			break;
			case 'viewed':
				$options['ORDER BY'] = 'view_count DESC ';
			break;
		}
		// echo $this->order;
		// $sql.="LIMIT {$this->offset}, {$this->limit} ";
		$options['LIMIT'] = $this->limit;
		$options['OFFSET'] = $this->offset;

		$result = $dbr->select( $from_tables,
			$vars,
			$conds,
			__METHOD__,
			$options );

		 //echo "SQL:".$dbr->lastQuery($result)." \n";
		 //die;
		// $result = $dbr->query($sql,  'MV_Index:doFiltersQuery_base');

		$this->numResults = $dbr->numRows( $result );
		if ( $dbr->numRows( $result ) == 0 ) return array();

		if ( $mvDo_SQL_CALC_FOUND_ROWS ) {
			$resFound = $dbr->query( 'SELECT FOUND_ROWS() as `count`;' );
			$found = $dbr->fetchObject( $resFound );
			$this->numResultsFound = $found->count;
		} else {
			$this->numResultsFound = null;
		}

		// @@TODO hide empty categories (if limit > rows found )
		// while($row = $dbr->fetchObject( $result )){
		//	$ret_ary[]=$row;
		// }
		// return $ret_ary;
		// group by stream_name & time range:

		// init ret_ary & stream_group
		$ret_ary = $stream_groups = array();
		while ( $row = $dbr->fetchObject( $result ) ) {
		 	$ret_ary[$row->id] = $row;
			if ( !isset( $stream_groups[$row->stream_id] ) ) {
				$stream_groups[$row->stream_id] = array();
			}
			if ( count( $stream_groups[$row->stream_id] ) == 0 ) {
				$new_srange = array( 's' => $row->start_time,
									'e' => $row->end_time,
									'rows' => array( $row ) );
				$stream_groups[$row->stream_id][] = $new_srange;
			} else {
				MV_Index::insert_merge_range( $stream_groups[$row->stream_id], $stream_groups, $row );
			}
		}
		
		if( $mvCategoryInSearchResult){
			$or='';
			$conds='';
			$options=array();
			//build the category query conditions: 
			foreach($ret_ary as $row){
				if ( !isset( $ret_ary[$row->id]->category ) )
					$ret_ary[$row->id]->categories = array();
				
				$conds .= $or . ' cl_from =' . $dbr->addQuotes( $row->id );
				$or = ' OR ';				
			}
			//do the lookup:
			$from_tables = $dbr->tableName( 'categorylinks' );
			$from_tables .= ' LEFT JOIN ' . $dbr->tableName( 'mv_mvd_index' ) .
						  	' ON ( ' .
								 $dbr->tableName( 'categorylinks' ) . '.cl_from = ' .
								 $dbr->tableName( 'mv_mvd_index' ) . '.mv_page_id' .
							' ) ';
						
			$vars = array( 'cl_from', 'cl_to' );				
			$options['LIMIT'] = 2000; // max avarage 5 categories per page

			$result_cat = $dbr->select( $from_tables,
				$vars,
				$conds,
				__METHOD__,
				$options );
			while ( $cat_row = $dbr->fetchObject( $result_cat ) ) {
				$ret_ary[$cat_row->cl_from]->categories[$cat_row->cl_to] = true;
			}
		}
		
		if( $mvSpokenByInSearchResult || $mvBillInSearchResult ){		
		// slow especially for lots of query results but join Query is crazy complicated for SMW >= 1.2 
		// (and I have not been able to construct it without hitting exessive number of rows in the EXPLIN) 
		// @@todo these queries should be merged with semantic wiki Ask with some ~special~ keywords for fulltext search					
			$smwStore =& smwfGetStore();
			foreach ( $ret_ary as & $row ) {
				//@@todo this is all very hackish but this is because SMW changed the db schema causing a few hacks:
				// obviously this should be rewritten to use some SMW based query system. 
				$smw_properties=array();
				if($mvSpokenByInSearchResult && strtolower(substr($row->wiki_title,0,2))=='ht')
					$smw_properties[]='Spoken_By';
					
				if($mvSpokenByInSearchResult && strtolower(substr($row->wiki_title,0,4))=='anno')
					$smw_properties[]='Speech_by';
				
				if($mvBillInSearchResult)
					$smw_properties[]='Bill';				
				
				
                $rowTitle = Title::newFromText( $row->wiki_title, MV_NS_MVD );               
                foreach ( $smw_properties as $propKey ) {
                	if ( $propKey != 'category' ) {	         
                		//print "on key: $propKey";     
	                	$propTitle = Title::newFromText( $propKey, SMW_NS_PROPERTY );
		                $smwProps = $smwStore->getPropertyValues( $rowTitle, $propTitle );
						// just a temp hack .. we need to think about this abstraction a bit..
						//print_r($smwProps);
						if(count($smwProps)!=0){
							if($propKey=='Spoken_By' || $propKey=='Speech_by'){
								$v = current( $smwProps );
								$row->spoken_by = $v->getXSDValue();
							}else if($propKey=='Bill'){
								$row->bills=array();
								foreach($smwProps as $v){				
									$row->bills[$v->getXSDValue()] = true;
								}							
							}
						}
                	}
                }                			                 
			}
		}
		
		//print_r($ret_ary);
		//die;
		
		
		
		
		// print "<pre>";
		// print_r($ret_ary);
		// die;
		// throw out empty top level ranges
		/*foreach($ret_ary as &$stream_set){
			foreach($stream_set as $k=> &$srange){
				if(count($srange['rows'])==0){
					//print "throw out: ". $srange['s'] . $srange['e'];
					unset($stream_set[$k]);
				}
			}
		}*/
		// do category & bill lookup for search result ranges
		/*if ( $mvCategoryInSearchResult || $mvBillInSearchResult ) {
			$from_tables = $conds = '';
			$vars = $options = array();

			// set up selected vars:
			$vars[] = $dbr->tableName( 'categorylinks' ) . '.cl_to';
			$vars[] = $dbr->tableName( 'mv_mvd_index' ) . '.stream_id';
			$vars[] = $dbr->tableName( 'mv_mvd_index' ) . '.start_time';
			$vars[] = $dbr->tableName( 'mv_mvd_index' ) . '.end_time';
			$vars[] = $dbr->tableName( 'smw_relations' ) . '.object_title as bill_to ';

			// set up from_tables
			$from_tables .= $dbr->tableName( 'mv_mvd_index' ) .
				' LEFT JOIN ' . $dbr->tableName( 'categorylinks' ) .
					' ON ( ' .
						$dbr->tableName( 'mv_mvd_index' ) . '.mv_page_id = ' .
						$dbr->tableName( 'categorylinks' ) . '.cl_from ' .
					' ) ' .
				' LEFT JOIN ' . $dbr->tableName( 'smw_relations' ) .
					' ON ( ' .
							$dbr->tableName( 'mv_mvd_index' ) . '.mv_page_id = ' .
							$dbr->tableName( 'smw_relations' ) . '.subject_id ' .
						' AND ' .
							$dbr->tableName( 'smw_relations' ) . '.relation_title=\'bill\' ' .
					' ) ';
			// generate stream_id, range sets
			$conds .= $dbr->tableName( 'mv_mvd_index' ) . '.mvd_type=\'Anno_en\' ' .
				' AND (';
				$or = '';
				foreach ( $stream_groups as $stream_id => $rangeSet ) {
					foreach ( $rangeSet as $range ) {
						$conds .= $or . ' ( ' . $dbr->tableName( 'mv_mvd_index' ) . '.stream_id =' .
											$dbr->addQuotes( $stream_id );
						$conds .= " AND `start_time` <= " . $dbr->addQuotes( $range['s'] ) . "";
						$conds .= " AND `end_time` >= " . $dbr->addQuotes( $range['e'] ) . ' ) ';
						$or = ' OR ';

					}
				}
			$conds .= ' ) ';
			$options['LIMIT'] = 200;

			$result = $dbr->select( $from_tables,
				$vars,
				$conds,
				__METHOD__,
				$options );
			// print "BEFORE merge: ";
			// print_r($ret_ary);
			// print_r($stream_groups);

			// merge category info back into base results:
			// $result = $dbr->query($sql,  'MV_Index:doCategorySearchResult');
			while ( $cl_row = $dbr->fetchObject( $result ) ) {
				// print_r($cl_row);
				foreach ( $stream_groups[$cl_row->stream_id] as &$range ) {
					foreach ( $range['rows'] as &$result_row ) {
						if ( $result_row->start_time <= $cl_row->end_time &&
						  $result_row->end_time >= $cl_row->start_time ) {
						 	// print "result row:"; print_r($result_row);
						 	if ( isset( $cl_row->cl_to ) && isset( $ret_ary[$result_row->id] ) )
								$ret_ary[$result_row->id]->categories[$cl_row->cl_to] = true;
							if ( isset( $cl_row->bill_to ) && isset( $ret_ary[$result_row->id] ) )
								$ret_ary[$result_row->id]->bills[$cl_row->bill_to] = true;
					 	}
					}
				}
			}
			// print "AFTER MERGE: ";
			// print_r($ret_ary);
		}*/
		// print "<pre>";
		// print_r($ret_ary);
		// die;
		return $ret_ary;
	}
	function numResultsFound() {
		if ( isset( $this->numResultsFound ) ) {
			return $this->numResultsFound;
		} else {
			return null;
		}
	}
	function numResults() {
		if ( isset( $this->numResults ) )
			return $this->numResults;
		return 0;
	}
	/*inserts search result into proper range and stream */
	function insert_merge_range( & $sranges, &$ret_ary, $row, $doRowInsert = true ) {
		foreach ( $sranges as & $srange ) {
				// skip if srange row 0 has same mvd (topq already inserted)
				// if($srange['rows'][0]->id==$row->id )continue ;
				// check if current $srow encapsulate and insert
				if ( $row->start_time <= $srange['s']  && $row->end_time >= $srange['e'] ) {
					$srange['s'] = $row->start_time;
					$srange['e'] = $row->end_time;
					if ( $doRowInsert )
						$srange['rows'][] = $row;
					// grab rows from any other stream segment that fits in new srange:
					foreach ( $ret_ary as &$sbrange ) {
						if ( isset( $sbrange['s'] ) ) {
							if ( $row->start_time <= $sbrange['s']  && $row->end_time >= $sbrange['e'] ) {
								foreach ( $sbrange['rows'] as $sbrow ) {
									$srange['rows'][] = $sbrow;
								}
								unset( $sbrange );
							}
						}
					}
					return ;
				}// else if current fits into srange insert
				else if ( $row->start_time >= $srange['s']  &&  $row->end_time <= $srange['e'] ) {
					if ( $doRowInsert )
						$srange['rows'][] = $row;
					return ;
				}
				// make sure the current row does not already exist:
				foreach ( $srange['rows'] as $sbrow ) {
					if ( $sbrow->wiki_title == $row->wiki_title ) {
						return ;
					}
				}
		}
		// just add as new srange
		$new_srange = array( 's' => $row->start_time,
							'e' => $row->end_time );
		if ( $doRowInsert ) {
			$new_srange['rows'] = array( $row );
		} else {
			$new_srange['rows'] = array();
		}
		$ret_ary[$row->stream_id][] = $new_srange;
	}
	function getMVDbyId( $id, $fields = '*' ) {
		$dbr =& wfGetDB( DB_SLAVE );
		$result = $dbr->select( 'mv_mvd_index', $fields,
			array( 'mv_page_id' => $id ) );
		if ( $dbr->numRows( $result ) == 0 ) {
			return array();
		} else {
			// (mvd->id got renamed to more accurate mv_page_id)
			$row = $dbr->fetchObject( $result );
			$row->id = $row->mv_page_id;
			return $row;
		}
	}
	function getMVDbyTitle( $title_key, $fields = '*' ) {
		$dbr =& wfGetDB( DB_SLAVE );
		$result = $dbr->select( 'mv_mvd_index', $fields,
			array( 'wiki_title' => $title_key ) );
		if ( $dbr->numRows( $result ) == 0 ) {
			return null;
		} else {
			$row =  $dbr->fetchObject( $result );
			$row->id = $row->mv_page_id;
			return $row;
		}
	}
	function update_index_title( $old_title, $new_title ) {
		// make sure the new title is valid:
		$mvTitle = new MV_Title( $new_title );
		if ( $mvTitle->validRequestTitle() ) {
			// build the update row
			$update_ary = array(
				'wiki_title' => $mvTitle->getWikiTitle(),
				'mvd_type' => $mvTitle->getTypeMarker(),
				'stream_id' => $mvTitle->getStreamId(),
				'start_time' => $mvTitle->getStartTimeSeconds(),
				'end_time' => $mvTitle->getEndTimeSeconds() );
			// get old page_id
			$mvd_row = MV_Index::getMVDbyTitle( $old_title );
			$dbw =& wfGetDB( DB_WRITE );
			$dbw->update( 'mv_mvd_index', $update_ary,
				array( 'mv_page_id' => $mvd_row->mv_page_id ) );
			$lq = $dbw->lastQuery();
			// print "js_log(\"sql:$lq \");";
		} else {
			// print "NOT VALID MOVE";
			// @@todo better error handling (tyring to move a MVD data into bad request form)
			throw new MWException( "Invalid Page name for MVD namespace \n" );
		}
	}
	/*
	 * update_index_page updates the `mv_mvd_index` table (on MVD namespace saves)
	 */
	function update_index_page( &$article, &$text ) {
		global $mvgIP;
		// check static or $this usage context
		// use mv title to split up the values:
		$mvTitle = new MV_Title( $article->mTitle->getDBkey() );
		// print "Wiki title: " . $mvTitle->getWikiTitle();
		// fist check if an mvd entry for this stream already exists:
		$mvd_row = MV_Index::getMVDbyTitle( $mvTitle->getWikiTitle() );
		// set up the insert values:
		$insAry = array(
			'mv_page_id' => $article->mTitle->getArticleID(),
			'wiki_title' => $mvTitle->getWikiTitle(),
			'mvd_type' => $mvTitle->getTypeMarker(),
			'stream_id' => $mvTitle->getStreamId(),
			'start_time' => $mvTitle->getStartTimeSeconds(),
			'end_time' => $mvTitle->getEndTimeSeconds(),
		);

		$dbw =& wfGetDB( DB_WRITE );
		if ( count( $mvd_row ) == 0 ) {
			return $dbw->insert( 'mv_mvd_index' , $insAry );
		} else {
			$dbw->update( 'mv_mvd_index', $insAry,
				array( 'mv_page_id' => $mvd_row->mv_page_id ) );
		}
	}
}
