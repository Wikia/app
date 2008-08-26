<?php
/*
 * scrape_and_insert.inc.php Created on Feb 14, 2008
 *
 * All Metavid Wiki code is Released under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 * 
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.ucsc.edu
 */
 
class MV_BillScraper extends MV_BaseScraper{	
	var $base_url = 'http://www.c-spanarchives.org/congress/';
	var $base_query = '?q=node/69850';
	var $govTrack_bill_url ='http://www.govtrack.us/congress/bill.xpd?bill=';
	var $mapLightBillSearch = 'http://maplight.org/map/us/bill/search/';
	var $mapLightBillInfo = 'http://maplight.org/map/us/bill/$1/default';
	
	var $mapLightInterestG 		= 'http://maplight.org/map/us/interest/$1/view/all';
	var $mapLightInterestGBills = 'http://maplight.org/map/us/interest/$1/bills';
	//flag to control maplight lookup
	var $bill_name_maplight_lookup=true;
	//swich on letter types:
	var $bill_types = array('H.J.RES.'=>'hj', 'H.R.'=>'h', 'H.RES.'=>'hr', 
							'S.CON.RES.'=>'sc', 'S.J.RES'=>'sj', 'S.RES.1'=>'sr', 'S.'=>'s');
	var $bill_titles=array();							
	
	function procArguments(){
		global $options, $args;				
		if( !isset($options['stream_name']) && !isset($options['s'])){				
			die("error missing stream name\n");
		}else{			
			$stream_inx = (isset($options['stream_name']))?$options['stream_name']:$options['s'];
			if($args[$stream_inx]=='all'){
				$dbr =& wfGetDB(DB_SLAVE);
				//put all in wiki into stream list
				print "do all streams\n";
				$result = $dbr->query('SELECT * FROM `mv_streams`');
				while($row = $dbr->fetchObject($result)){
					$this->streams[$row->name]= new MV_Stream($row);					
				}	
			}else{
				$stream_name = $args[$stream_inx];
				$this->streams[$stream_name]= new MV_Stream(array('name'=>$stream_name));		
				if(!$this->streams[$stream_name]->doesStreamExist()){
					die('error: stream '.$stream_name . ' does not exist');
				}
				print "Proccessing Stream: $stream_name \n";
			}
		}				
	}	
	function doScrapeInsert(){
		foreach($this->streams as & $stream){
			if(!isset($stream->date_start_time))$stream->date_start_time=0;
			if($stream->date_start_time==0){
				print 'error stream '. $stream->name . ' missing time info'."\n";
				continue;
			}
			$hors =  (strpos($stream->name, 'house')!==false)?'h':'s';
			$date_req = date('Y-m-d', $stream->date_start_time);
			if(strpos($stream->name,  date('m-d-y', $stream->date_start_time))===false){
				$dTitle = Title::newFromText('Archive:Stream_DateMissMatch');
				append_to_wiki_page($dTitle, 'DateMissMatch:[[Stream:'.$stream->stream_name.']]:'.date('m-d-y', $stream->date_start_time)."\n");
				//use date from stream name: 
				//house_da_01-01-07_
				
				preg_match('/[0-9]+\-[0-9]+\-[0-9][0-9]/U',$stream->name,$matches);
				if(isset($matches[0])){					
					list($month,$day,$year)=explode('-',$matches[0]);
					$date_req = '20'.$year.'-'.$month.'-'.$day;
				}else{
					die('could not find date in stream name');
				}
							
			}
			$cspan_url = $this->base_url .$this->base_query .  '&date='.$date_req.'&hors='.$hors;
			echo $cspan_url . "\n";			
			$rawpage = $this->doRequest($cspan_url);		
			//get the title and href if present:
			$patern = '/overlib\(\'(.*)\((Length: ([^\)]*)).*CAPTION,\'<font size=2>(.*)<((.*href="([^"]*))|.*)>/'; 
			preg_match_all($patern, $rawpage, $matches);
			$cspan_person_ary = array();
			//format matches: 
			foreach($matches[0] as $k=>$v){
				$href='';
				$href_match=array();
				preg_match('/href="(.*)"/',$matches[5][$k], $href_match);
				if(count($href_match)!=0)$href=$href_match[1];
				
				$porg = str_replace('<br>',' ',$matches[4][$k]);
				$porg = preg_replace('/[D|R|I]+\-\[.*\]/', '', $porg);
				$pparts = explode(',',$porg);
				if(isset($pparts[1]) && isset($pparts[0])){
					$pname = trim($pparts[1]) . '_' . trim($pparts[0]);					
					if(mv_is_valid_person($pname)){		
						$cspan_person_ary[]= array(
							'start_time'=>strip_tags($matches[1][$k]),
							'length'=>$matches[3][$k],
							'person_title'=>str_replace('<br>',' ',$matches[4][$k]),
							'Spoken_by'=>$pname,
							'href'=>$href
						);
					}
				}
			}							
		    //group people in page matches
		    //$g_cspan_matches=array();
		    //$prev_person=null;		    
		    //foreach($person_time_ary as $ptag){
		    //	$g_cspan_matches[strtolower($ptag['Spoken_by'])][]=$ptag;		    			    			    
		    //}
		   
		    //retrive db rows to find match: 
		   	$dbr =& wfGetDB(DB_SLAVE);
		   	
		    //$mvd_res = MV_Index::getMVDInRange($stream->id, null, null, $mvd_type='ht_en',false,$smw_properties=array('Spoken_by'), '');		    
		    /*while ($row = $dbr->fetchObject($mvd_res)) {	   	   
		    $db_person_ary=$g_row_matches=array();
		    //group peole in db matches:
		    $cur_person = '';
		    $curKey=0;
		   	while ($row = $dbr->fetchObject($mvd_res)) {			   		   		   				   		
		   		if(!isset($row->Spoken_by))continue;  	   				   
   				if($cur_person!=$row->Spoken_by){
   					$g_row_matches[]=get_object_vars($row);
   					$curKey=count($g_row_matches)-1;
   					$cur_person=$row->Spoken_by;
   				}else{
   					$g_row_matches[$curKey]['end_wiki_title']=$row->wiki_title;
   					$g_row_matches[$curKey]['end_time']+=($row->end_time-$row->start_time);
   				}	   	
   				//print_r($g_row_matches);
   				//if($curKey>2){
   				//	die;
   				//}   				
		   	} */ 
		    
		    //get people from metavid table (and conform to mvd_res)
		    $sql = 'SELECT  (`people_time`.`time`-`streams`.`adj_start_time`) as `time`, 	
		    	   `person_lookup`.`name_clean`	 as `Spoken_by`,
				   `person_lookup`.`first` as `first`,
				   `person_lookup`.`last` as `last`
		    	   FROM  `metavid`.`people_attr_stream_time` as `people_time`
		    	   RIGHT JOIN `metavid`.`streams` as `streams` ON `streams`.`id`=`people_time`.`stream_fk`
		    	   LEFT JOIN `metavid`.`people` as `person_lookup` ON  `person_lookup`.`id` = `people_time`.`people_fk` 
		    	   WHERE `streams`.`name`=\''.$stream->name.'\' 		    	   		
		    	   ORDER BY `people_time`.`time` ';		    
			$people_res = $dbr->query($sql);	
			$cur_person = '';
			$curKey=0;
			while ($row = $dbr->fetchObject($people_res)) {
				if(!isset( $row->Spoken_by))continue;   			
				$cur_row_person = $row->first . '_' . $row->last;
				if($cur_person!=$cur_row_person){
					$db_person_ary[]=get_object_vars($row);					
					$curKey=count($db_person_ary)-1;
					$db_person_ary[$curKey]['Spoken_by']= $row->first . '_' . $row->last;
					$db_person_ary[$curKey]['start_time']=$row->time;
					//not on screen a long time if only one hit:
					$db_person_ary[$curKey]['end_time']=$row->time+10;
					$cur_person=$cur_row_person;
				}else{
					//update the end time: 
					$db_person_ary[$curKey]['end_time']=$row->time;
				}
			}			
		  	//list on screen times for everyone: 
		   	foreach($db_person_ary as $row){
		   		print $row['Spoken_by'] . ' on screen for '. ($row['end_time']-$row['start_time']) . "\n";
		   		//$db_person_ary[]=$row;
		   	}
		   	
			//print_r($db_person_ary);
			//die;
	
		   	//count($cspan_person_ary)	
		   	$cur_db_inx=0;	   	
		   	$cur_person=null;	
		   	$fistValid=true;	   			   	
		   	for($i=0;$i<count($cspan_person_ary);$i++){
		   		//print "looking at: ". $cspan_person_ary[$i]['Spoken_by'] . "\n";
		   		print "\tCSPAN: ". $cspan_person_ary[$i]['Spoken_by'] . ' on screen for '. $cspan_person_ary[$i]['length'].' or:'.ntp2seconds($cspan_person_ary[$i]['length']). "\n";
		   		//set up cur, the next and prev pointers: 
		   		$cur_person = $cspan_person_ary[$i]['Spoken_by'];
		   		
	   			//make sure next is not the same as current: 
	   			//note: we don't group above since the same person can give two subsequent different speeches 
	   			$next_person=$cur_person;
	   			$k_person_inx=1;
	   			$person_insert_set = array();
	   			while($next_person==$cur_person){
	   				if(isset($cspan_person_ary[$i+$k_person_inx])){
		   				$potential_next_person = (mv_is_valid_person($cspan_person_ary[$i+$k_person_inx]['Spoken_by']))?
		   					$cspan_person_ary[$i+$k_person_inx]['Spoken_by']:null;
						if($potential_next_person==null && $k_person_inx==1){
							$next_person=null;
							break;
						}else if($potential_next_person!=null){
							$next_person=$potential_next_person;
						}				   				
		   				$k_person_inx++;		   				
	   				}else{
	   					$next_person=null;
	   				}
	   			}		   			
	   			//should be no need to make sure prev is not the same as current (as we do greedy look ahead below) 
	   			//$prev_person = $cur_person;
	   			//$k=1;
	   			//while($prev_person==$cur_person){
	   				if(isset($cspan_person_ary[$i-1])){		   		
			   			$prev_person = (mv_is_valid_person($cspan_person_ary[$i-1]['Spoken_by']))?
			   				$cspan_person_ary[$i-1]['Spoken_by']:null;	
			   		}else{
	   					$prev_person=null;
	   				}		
	   			//}		   			   			 		   	

		   		if(mv_is_valid_person($cspan_person_ary[$i]['Spoken_by'])){		   					   		
		   			//print "\tis valid person looking for db sync\n";
		   			//print "\t prev: $prev_person cur: $cur_person next: $next_person\n";
		   			if($prev_person==null && $next_person==null){
		   				print "error both prev and next are null skiping person\n";		   			
		   				continue;
		   			}
		   			
		   			//check how long they where on screen (also check subquent)
		   			$cspan_on_screen_time=ntp2seconds($cspan_person_ary[$i]['length']);
		   					   		
		   			//print "NOW STARTING AT: $cur_db_inx of " . count($db_person_ary) . "\n";
		   			for($j=$cur_db_inx;$j<count($db_person_ary);$j++){				   				
						//print "searchig db on: " . $db_person_ary[$j]['Spoken_by'] . "!=" . $cspan_person_ary[$i]['Spoken_by'] . " \n";
	   					$prevMatch=$curMatch=$nextMatch=false;
	   					if($cur_db_inx==0 || $prev_person==null){
	   						//no need to check prev in db_inx
	   						$prevMatch=true;
	   					//	print "(no back check)";
	   					}else{
		   					if($db_person_ary[$j-1]['Spoken_by'] ==$prev_person){
							//	print "found prev match: $prev_person\n;";	
								$prevMatch=true;								
		   					}
	   					}
	   					if(isset($db_person_ary[$j])){
	   						if(isset($cspan_person_ary[$i])){
			   					if($db_person_ary[$j]['Spoken_by']==$cspan_person_ary[$i]['Spoken_by']){
								//	print "found cur match:". $cspan_person_ary[$i]['Spoken_by']."\n";
									$curMatch=true;
			   					}
	   						}	   	
	   					}
	   					if($next_person==null){
	   						//no need to check next in db_inx
	   						$nextMatch=true;
	   					//	print "(no next check)";
	   					}else{				
	   						if(isset($db_person_ary[$j+1])){
								if($db_person_ary[$j+1]['Spoken_by']==$next_person){
									//print "found next match:".$next_person."\n";
									$nextMatch=true;
								}								
	   						}
	   					}
	   					//if we have a match set do insert proc:
	   					if($prevMatch && $curMatch && $nextMatch){
	   						//print "FOUND Match on $j\n";
	   						//print "\t prev: $prev_person cur: $cur_person next: $next_person\n";
	   						$cur_db_inx=$j;
	   						//add all additional info we can from c-span: 
	   						//also push forward for all of current (we should always hit the first series of the same person first )
	   						$k=0;	   						
	   						//build insert set:
	   						$cur_start_time = $db_person_ary[$j]['start_time'];
	   						while($cur_person==$cspan_person_ary[$i+$k]['Spoken_by']){	   							   							  						
	   							//use the last cspan_person for start case	   							
	   							$cspan_person_ary[$i+$k]['wiki_start_time']=$cur_start_time;
		   						if(ntp2seconds($cspan_person_ary[$i+$k]['length']) > 
	   									$db_person_ary[$j]['end_time']-$cur_start_time){
		   								$cspan_person_ary[$i+$k]['wiki_end_time'] =$db_person_ary[$j]['end_time'];
		   								//already used up our db_person_ary continue: 
		   								print "a cspan insert sync " . 
											' '. $cspan_person_ary[$i+$k]['wiki_start_time']. " to " .
											$cspan_person_ary[$i+$k]['wiki_end_time']. " of " . 
											$db_person_ary[$j]['end_time'] . " for: " .
											$cspan_person_ary[$i]['Spoken_by'] . "\n";	
		   								break;
	   							}else{
	   									$cspan_person_ary[$i+$k]['wiki_end_time'] =$cur_start_time+
	   												ntp2seconds($cspan_person_ary[$i+$k]['length']);
	   									//print "add " . ntp2seconds($cspan_person_ary[$i+$k]['length']) . "\n";
	   									$cur_start_time+=ntp2seconds($cspan_person_ary[$i+$k]['length']);
	   							} 	 
	   							print "p cspan insert sync " . 
										' '. $cspan_person_ary[$i+$k]['wiki_start_time']. " to " .
										$cspan_person_ary[$i+$k]['wiki_end_time']. " of " . 
										$db_person_ary[$j]['end_time'] . " for: " .
											$cspan_person_ary[$i]['Spoken_by'] . "\n";	  			
	   							//print_r($db_person_ary[$j]);
	   							//print_r($cspan_person_ary[$i+$k]);									
	   							$k++;
	   							if(!isset($cspan_person_ary[$i+$k]))break;
	   						}	   	
	   						$k--;
	   						//extend the last property if within 100 seconds
	   						if(abs($cspan_person_ary[$i+$k]['wiki_end_time']-$db_person_ary[$j]['end_time'])<100){
	   							$cspan_person_ary[$i+$k]['wiki_end_time']=$db_person_ary[$j]['end_time'];	   			
	   							print "updated cspan insert for: ". $cspan_person_ary[$i]['Spoken_by'] . 
										' '. $cspan_person_ary[$i+$k]['wiki_start_time']. " to " .
										$cspan_person_ary[$i+$k]['wiki_end_time']. " of " . 
										$db_person_ary[$j]['end_time'] . "\n";
	   						}	 
	   						$k++;
//	   						/die;
	   						//move the index to the current: 
	   						$i=$i+$k;
	   						continue;
	   					}				   						   				
		   			}		    
		   		}else{
		   			//print $cspan_person_ary[$i]['Spoken_by'] . " is not valid person\n";
		   		}		   		
		   	}	
		   	print "Get Additonal C-SPAN Data For \"synced\" Data:\n";
		   	foreach($cspan_person_ary as $pData){
		   		if(isset($pData['wiki_start_time'])){
		   			//init:  			
		   			$bill_categories=array();
		   			$annotate_body ='';	
		   			$body='';
		   			$bill_key=null;
		   			
		   			$rawpage = $this->doRequest($this->base_url . $pData['href']);
		   			//$rawpage = $this->doRequest('http://www.c-spanarchives.org/congress/?q=node/77531&id=8330447');
		   			
		   			preg_match('/<\/td><th><center>([^<]*)<\/center><\/th><td>/U', $rawpage, $title_matches);
		   			preg_match('/<table width="400">\n<tr><td>\n(.*)<\/tr><\/td>/',$rawpage, $page_matches);
		   			
		   			if(isset($title_matches[1]) && isset($page_matches[1])){
		   				$title = trim($title_matches[1]);
		   				$body = $page_matches[1];
		   				//print_r($page_matches);
		   			}else{
		   				print "error can't find title or body\n";
		   				print "skip...";
		   				continue;
		   			}			   	
		   			//do debate tag search:		   			
		   			preg_match('/<td colspan="2">Debate:\s*<[^>]*>([^<]*)/U', $rawpage, $debate_matches);		   			
		   			if(isset($debate_matches[1])){
		   				$bill_key = trim($debate_matches[1]);
		   				print "found debate: tag " .$bill_key."\n";		   				
		   				//build gov-track-congress-session friendly debate url:
						if($this->get_and_proccess_billid($bill_key,$stream->date_start_time)!=null){
							$bill_categories[$bill_key]=$bill_key;	
						}													   				  	   		
		   			}		   			
		   				   			
		   			
		   			//title fix hack for C-span error motion to procceed 
		   			//@@todo add in the rest of the motions:		   			
		   			if(strpos($title,'MOTION TO PROCEED')!==false){
		   				$title = str_replace('MOTION TO PROCEED','', $title);
		   				//$annotate_body.="[[Bill Motion:=MOTION TO PROCEED]]\n";
		   			}
		   			//fix title case
		   			$title = ucwords( strtolower($title));
		   			//don't Cap a Few of the Words: '
		   			$title = str_replace(array(' And',' Or',' Of', ' A'), array(' and',' or',' of', ' a'), $title);
		   			
		   			//replace '' with ``
		   			$body = str_replace('\'\'', '``', $body);
		   			//replace bill names with [[Catgory:: bill name #]]		   		
		   			//$bill_pattern = '/(H\.R\.\s[0-9]+)/';
		   			$bill_pattern='/';
		   			$bill_pattern_ary=array();
		   			$or='';
		   			foreach($this->bill_types as $cspanT=>$govtrakT){
		   				$cspanT = str_replace('RES', '[\s]?RES', $cspanT);//sometimes spaces before res in text
		   				$cspanT = str_replace('CON', '[\s]?CON', $cspanT);//sometimes spaces before res in text
		   				//replace . with \.[\s]?
		   				$bill_pattern.=$or.'('.str_replace('.','\\.[\s]?', $cspanT).'\s?[0-9]+)';
		   				$bill_pattern_ary[]='('.str_replace('.','\\.[\s]?', $cspanT).'\s?[0-9]+)';
		   				$or='|';
		   			}
		   			$bill_pattern.='/i';//case insensative
		   			//$body='bla bla H.R. 3453 test S. 3494 some more text';
		   			//print "pattern:".$bill_pattern . "\n";
		   			preg_match_all($bill_pattern, $body, $bill_matches);	
		   			//print_r($bill_matches);
		   			//die;	   				   		
		   			if(isset($bill_matches[1])){
		   				foreach($bill_matches as $k=> $bill_type_ary){
		   					if($k!=0){
		   						if(isset($bill_type_ary[0])){				   						
		   							$bill_name =$bill_type_ary[0];
		   						}else if(isset($bill_type_ary[1])){		
		   							$bill_name=$bill_type_ary[1];
		   						}else{
		   							continue;
		   						}	
		   						//if the first letter is lower case not likely a bill 
		   						if(trim($bill_name)=='')continue;
		   						if(islower(substr($bill_name,0,1)))continue;
		   						//conform white space and case:
		   						$bill_name=str_replace(array('S. ','Con. ', 'Res. '),array('S.', 'CON.', 'RES. '),$bill_name);
		   						//make sure its not a false possitave and load bill data from govTrack: 
		   						if($this->get_and_proccess_billid($bill_name,$stream->date_start_time)){
		   							$bill_categories[$bill_name]=$bill_name;
		   						}
		   					}
		   				}
		   			}	
		   			// add speech by attribute to annotation body:  						
		   			$annotate_body.='Speech By: [[Speech by:='.str_replace('_',' ',$pData['Spoken_by']).']] ';
		   			//add speech by attribute to body as well?  
		   			$body.="\n\n".'Speech By: [[Speech by:='.str_replace('_',' ',$pData['Spoken_by']).']] ';
					//add any mentions of bills with linkback to full bill title:
		   			$body = preg_replace_callback($bill_pattern_ary,array('self','bill_pattern_cp'), $body);			   		
		   			
		   			//source the doument:
		   			$body.="\n\n".'Source: [[Data Source Name:=C-SPAN Congressional Chronicle]] [[Data Source URL:='.$this->base_url . $pData['href'].']]'; 
		   				   					   			
		   			$body.="\n";
		   			//add the title to the top of the page: 
		   			$body="===$title===\n". $body;	
		   			$cspan_title_str = 	$this->get_aligned_time_title($pData,'Thomas_en', $stream);
		   			if(!$cspan_title_str){	   			
		   				$cspan_title_str = 'Thomas_en:'.$stream->name.'/'.
			   				seconds2ntp($pData['wiki_start_time']).'/'.
			   				seconds2ntp($pData['wiki_end_time']);
		   			}		   				
		   			$cspanTitle=Title::makeTitle(MV_NS_MVD, ucfirst($cspan_title_str));
		   			//print "do edit ".$cspanTitle->getText()."\n";
		   			do_update_wiki_page($cspanTitle, $body);				   			
		   			//protect editing of the offical record (but allow moving for sync)	
		   			$cspanTitle->loadRestrictions();
					global $wgRestrictionTypes;
					foreach( $wgRestrictionTypes as $action ) {
						// Fixme: this form currently requires individual selections,
						// but the db allows multiples separated by commas.
						$mRestrictions[$action] = implode( '', $cspanTitle->getRestrictions( $action ) );
					}
					
					$article = new Article($cspanTitle);
					$mRestrictions['edit']['sysop']=true;
					$expiry = Block::infinity();
					$dbw = wfGetDb(DB_MASTER);
					$dbw->begin();
					$ok = $article->updateRestrictions( $mRestrictions,wfMsg('mv_source_material'), false, $expiry );					
					if($ok){
						print "updated permisions for ". $cspanTitle->getText()."\n";
		   				$dbw->commit();
					}else{
						print "failed to update restrictions :(\n";
					}
		   			
		   			//proccess each bill to the annotation body;
		   			$bcat=''; 
		   			$bill_lead_in ="\n\nBill ";
		   			//print_r($bill_categories);		   			
		   			foreach($bill_categories as $bill){
		   				if(trim($bill)!=''){	
		   					//use short title for category and long title for semantic link... (highly arbitrary)					
			   				$annotate_body.=$bill_lead_in.'[[Bill:='.$this->cur_bill_short_title.']] ';
			   				$bill_lead_in=' , ';		   				   		
			   				$annotate_body.="[[Category:$bill]] ";
		   				}
		   			}
		   			if(trim($title)!=''){
		   				$annotate_body.="[[Category:$title]]\n";
		   			}
		   			
		   			
		   			//see if we can align with an existing speech page: 		   			
		   			$anno_title_str = $this->get_aligned_time_title($pData,'Anno_en', $stream);		   			
					if(!$anno_title_str){		
						$anno_title_str =  'Anno_en:'.$stream->name.'/'.
			   				seconds2ntp($pData['wiki_start_time']).'/'.
			   				seconds2ntp($pData['wiki_end_time']);		
					}	 						   						   			
		   			$annoTitle =Title::makeTitle(MV_NS_MVD, ucfirst($anno_title_str));
		   			do_update_wiki_page($annoTitle, $annotate_body);		  			
		   			//[Page: S14580] replaced with:  [[Category:BillName]]
		   			//would be good to link into the official record for "pages"
		   			
		   			//[[Speech by:=name]]
		   			//[[category:=title]]
		   			
		   			//for documentation: 
		   			//semantic qualities would be Aruging For:billX or Arguging Agaist billY
		   			
		   			//these pages are non-editable 
		   			//maybe put the category info into annotations layer? (since it applies to both?)
		   			
		   			
		   			//do new page mvd:or_
		   		}
		   	}	   		   		   
		   	//$inx_cspan_person_ary = array_keys($g_row_matches);
		   	//$inx_row_person_ary = array_keys($g_person_time_ary);
		   	//for($i=0;$i<5;$i++){
		   		
		   	//}		   	
            //find match person1->person2
            
            
            //average switch time to get offset of stream
            //use offset to insert all $person_time_array data 
		}
	}	
	function get_aligned_time_title(&$pData, $preFix='Anno_en', $stream){
		$dbr =& wfGetDB(DB_SLAVE);
		$mvd_anno_res = MV_Index::getMVDInRange($stream->getStreamId(), 
			$pData['wiki_start_time']-120,$pData['wiki_end_time']+120,
		$mvd_type='Anno_en',$getText=false,$smw_properties='Speech_by');
		   					
		$doSpeechInsert=true;									
		while($row = $dbr->fetchObject($mvd_anno_res)){
			if($row->Speech_by){
				if($row->Speech_by == $pData['Spoken_by']){
					print "match update existing: $row->Speech_by  == ". $pData['Spoken_by']. "\n";
					$anno_title_str =  $preFix.':'.$stream->name.'/'.
		   				seconds2ntp($row->start_time).'/'.
		   				seconds2ntp($row->end_time);			   						   					   					   			
		   			return $anno_title_str;
				}else{
					print "\nno existing speech match:$row->Speech_by != " .$pData['Spoken_by']. "\n\n"; 
				}														
			}
		}
		return false;
	}
	function bill_pattern_cp($matches){	
		if(isset($this->bill_titles[$matches[0]])){
		 	return "[[Mentions Bill:=". $this->bill_titles[$matches[0]] ."|{$matches[0]}]]";	
		 }else{
		 	return "[[Mentions Bill:={$matches[0]}]]";
		 }
	}
	/* converts c-span bill_id to gov_track bill id */
	function get_and_proccess_billid($bill_key, $stream_date='',$session=''){
		global $MvBillTypes;
		//add a space to bill key after $bill_type key
		foreach($this->bill_types as $bk=>$na){
			if(strpos($bill_key, $bk)!==false){
				if(strpos($bill_key, $bk.' ')===false){
					$bill_key = str_replace($bk, $bk.' ',$bill_key);
				}
			}			
		}
		//first get the year to detrim the house session:				
		if($session==''){	
			$year =date('y', $stream_date);
			if($year=='01'||$year=='02'){$session='107';
			}else if($year=='03'||$year=='04'){$session='108';
			}else if($year=='06'||$year=='05'){$session='109';
			}else if($year=='07'||$year=='08'){$session='110';
			}else if($year=='09'||$year=='10'){$session='111';
			}else if($year=='11'||$year=='12'){$session='112';}
			$this->cur_session=$session;
		}	
		foreach($this->bill_types as $cspanT=>$govtrakT){
			$bill_key = trim($bill_key);
			if(substr($bill_key, 0,strlen($cspanT))==$cspanT){
				$govTrackBillId= $govtrakT.$session.'-'.trim(substr($bill_key,strlen($cspanT)));
				$openCongBillId=$session.'-'.strtolower($govtrakT).trim(substr($bill_key,strlen($cspanT)));
				break;
			}
		}
		if(trim($bill_key)=='')return false;
		//attempt to asertain maplight bill id:
		$mapLightBillId= $this->getMAPLightBillId($bill_key, $session);
		
		print "GOT bill id: $govTrackBillId from $bill_key\n";
		print "GOT openCon id: $openCongBillId from $bill_key\n";
		print "GOT mapLight id: $mapLightBillId from $bill_key\n"; 
		if($govTrackBillId){
			$this->proccessBill($govTrackBillId, $bill_key, $openCongBillId, $mapLightBillId);	
			$this->govTrackBillId= $govTrackBillId;		
			return 	$this->govTrackBillId;					
		}else{
			print 'error in getting govTrack bill id on: '. $bill_key . " (skiped)\n";
			die;
			return null;
		}	
	}
	function getMAPLightBillId($bill_key, $session){		
		if(trim($bill_key)=='')return false;
		$raw_map_light = $this->doRequest($this->mapLightBillSearch. str_replace(' ','+',$bill_key));
		//check if we got redirected: 
		$patern = '/<a href=\"\/map\/us\/bill\/([^\/]*)\/default" class="active">Supporter/';
		preg_match($patern, $raw_map_light,$matches );
		if(isset($matches[1])){
			print "got redirected from search: " . $matches[1]. "\n";
			return $matches[1];
		}
			
		$patern = '/<a href=\"\/map\/us\/bill\/([^"]*)">'.str_replace(' ', '\s?',$bill_key).'\s\('.$session.'/i';
		preg_match($patern, $raw_map_light,$matches );
		//print $patern; 
		//print_r($matches);
		if(isset($matches[1])){
			return $matches[1];			
		}else{			
			print "could not find bill id: $bill_key $session \n";
			print "at : " . $this->mapLightBillSearch. str_replace(' ','+',$bill_key)."\n";					
			return false;
		}
	}
	function proccessBill($govTrackBillId, $bill_key, $openCongBillId=false, $mapLightBillId=false, $forceUpdate=false){
		//get the bill title & its sponser / cosponsers: 
		$rawGovTrackPage = $this->doRequest($this->govTrack_bill_url . $govTrackBillId);		

		/*****************************
		 * Proccess Bill GovTrack info
		 *****************************/								
		print "gov_track id: ". $govTrackBillId . " from: " . $this->govTrack_bill_url . $govTrackBillId. "\n";
		
		//get title: 
		$patern = '/property="dc:title" datatype="xsd:string" style="margin-bottom: 1em">([^<]*)<\/div>(<p style="margin-top: 1.75em; margin-bottom: 1.75em">([^<]*))?/';		
		preg_match($patern,$rawGovTrackPage, $title_match);		
		if(isset($title_match[1])){
			if(trim($title_match[1])==''){
				print "empty title\n";
				return false;
			}
			$title_short  = str_replace(array('_','...',' [110th]',' [109th]',' [108th]',' [107th]'),array(' ','','','','',''),$title_match[1]);
			$this->cur_bill_short_title=$title_short;
			//set the desc if present:
			$title_desc = (isset($title_match[3]))?$title_match[3]:'';
			$this->bill_titles[$bill_key]=$title_short;
		}else{
			print $this->govTrack_bill_url . $govTrackBillId . "\n" .$patern ."\n". $rawGovTrackPage;
			die('could not get title for bill: ' . $govTrackBillId);
		}
		
		//print "raw govtrack:\n $rawGovTrackPage";
		//get the $thomas_match 
		preg_match('/thomas\.loc\.gov\/cgi-bin\/bdquery\/z\?(.*):/', $rawGovTrackPage, $thomas_match);								
		//get introduced: //strange .* does not seem to work :( 
		preg_match('/Introduced<\/nobr><\/td><td style="padding-left: 1em; font-size: 75%; color: #333333"><nobr>([^<]*)/m', $rawGovTrackPage, $date_intro_match);	
		//print_r($date_intro_match);						
		//get sponsor govtrack_id: 
		preg_match('/usbill:sponsor[^<]*<a href="person.xpd\?id=([^"]*)/i', $rawGovTrackPage, $sponsor_match);			
		//lookup govtrack_id 
		//print_r($sponsor_match);
		if(isset($sponsor_match[1])){
			$sponsor_name = str_replace('_',' ',$this->get_wiki_name_from_govid($sponsor_match[1]));
		}
		//get cosponsor chunk:
		$scospon=strpos($rawGovTrackPage, 'Cosponsors [as of');
		$cochunk = substr($rawGovTrackPage, 
			$scospon,								 
			strpos($rawGovTrackPage, '<a href="/faq.xpd#cosponsors">')-$scospon);							
		preg_match_all('/person.xpd\?id=([^"]*)/',$cochunk,  $cosponsor_match);				
									
		$bp = "{{Bill|\n".
			'GovTrackID='.$govTrackBillId."|\n";
		if(isset($thomas_match[1]))$bp.='ThomasID='.$thomas_match[1]."|\n";
		if($openCongBillId)$bp.='OpenCongressBillID='.$openCongBillId."|\n";
		if($mapLightBillId)$bp.='MapLightBillID='.$mapLightBillId."|\n";
		if(isset($this->cur_session))$bp.='Session='.$this->cur_session."th session|\n";
		$bp.='Bill Key='.$bill_key."|\n";							
		if(isset($date_intro_match[1]))$bp.='Date Introduced='.$date_intro_match[1]."|\n";
		if($title_desc){
			$bp.='Title Description='.$title_desc."|\n";
		}													
		if($sponsor_name)$bp.='Sponsor='.$sponsor_name."|\n";
		
		if(isset($cosponsor_match[1])){
			foreach($cosponsor_match[1] as $k=>$govid){
				$cosponsor_name = $this->get_wiki_name_from_govid($govid);
				if($cosponsor_name){
					$bp.='Cosponsor '.($k+1).'='.$cosponsor_name."|\n";	
				}
			}	
		}
		/*****************************
		 * Proccess MapLight Info 
		 *****************************/
		if($mapLightBillId){
			$bill_interest = $this->proccMapLightBillIntrests($mapLightBillId);
			$i=1;
			foreach($bill_interest['support'] as $interest){
				$this->procMapLightInterest($interest);			
				$bp.='Supporting Interest '.$i.'='.$interest['name']."|\n";
				$i++;
			}
			$i=1;
			foreach($bill_interest['oppose'] as $interest){
				$bp.='Opposing Interest '.$i.'='.$interest['name']."|\n";
				$i++;
			}
		}										
		$bp.="}}\n";	
		//print 'page : '.$title_short.' ' . $bp . "\n";	
		//incorporated into the template: 
		//$body.="\n\n".'Source: [[Data Source Name:=GovTrack]] [[Data Source URL:='.$this->govTrack_bill_url . $govTrackBillId.']]';
		//set up the base bill page:		
		$wgBillTitle = Title::newFromText($title_short);
		do_update_wiki_page($wgBillTitle, $bp);		
		
		//set up a redirect for the bill key, and a link for the category page:
		print "\ndo redirect for: $title_short \n";
		global $mvForceUpdate;
		$wgBillKeyTitle =Title::newFromText($bill_key);		
		do_update_wiki_page($wgBillKeyTitle, '#REDIRECT [['.$title_short.']]',null, $mvForceUpdate);							
		//set up link on the category page:
		$wgCatPageTitle =Title::newFromText($bill_key, NS_CATEGORY);		
		do_update_wiki_page($wgCatPageTitle, 'See Bill Page For More Info: [[:'.$wgBillTitle->getText().']]', null, $mvForceUpdate);		
	}
	function procMapLightInterest($interest){
		 global $mvMaxContribPerInterest, $mvMaxForAgainstBills;
		 if($this->bill_name_maplight_lookup){
		 	include_once('metavid2mvWiki.inc.php');
		 	do_proc_interest($interest['key'], $interest['name']);
		 }	
	}
	//returns an array of interest in ['support'] & ['opposition'] .. also procces interest links
	function proccMapLightBillIntrests($mapLightBillId){
		//print "map info: $this->mapLightBillInfo \n";
		print str_replace('$1', $mapLightBillId, $this->mapLightBillInfo). "\n\n";
		$ret_ary = array('support'=>array(),'oppose'=>array() );	
		$bill_page = $this->doRequest(str_replace('$1', $mapLightBillId, $this->mapLightBillInfo));
		//$bill_page = $this->doRequest('http://maplight.org/map/us/bill/10831/default');
		//print $bill_page;
		//([^<]*)<\/a>)*		
		//a href="\/map\/us\/interest\/([^"]*) class="interest"
		
		$pat_interest = '/<li><a\shref="\/map\/us\/interest\/([^"]*)".*>([^<]*)<\/a>&nbsp;.*<\/li>/U';
		//class="organizations"\sid="for
		//preg_match_all('/class="organizations"\sid="for.*<ul class="industries list-clear">()*/',$bill_page, $matches);
		preg_match_all($pat_interest, $bill_page, $matches, PREG_OFFSET_CAPTURE);	
		//print_r($matches);
		$aginst_pos = strpos($bill_page,'class="organizations" id="against"');
		//return empty arrays if we don't have info to give back:'
		if($aginst_pos===false)return $ret_ary;
		if(!isset($matches[1]))return $ret_ary;
		
		foreach($matches[1] as $inx=>$intrest){
			if($intrest[1]<$aginst_pos){
				$ret_ary['support'][]=array('key'=>$intrest[0], 'name'=>$matches[2][$inx][0]);
			}else{
				$ret_ary['oppose'][]=array('key'=>$intrest[0], 'name'=>$matches[2][$inx][0]);
			}
		}
		return $ret_ary;
	}
	function get_bill_name_from_mapLight_id($mapBillId, $doLookup=true){
		global $mvForceUpdate;
		if(!$mvForceUpdate){
			if(!isset($this->mapLight_bill_cache)){
				$sql = 'SELECT * FROM `smw_attributes` WHERE `attribute_title` = \'MAPLight_Bill_ID\'';
				$dbr = wfGetDB( DB_SLAVE );	
				$res = $dbr->query($sql);
				while ($row = $dbr->fetchObject($res)) {
					$this->mapLight_bill_cache[$row->value_xsd]=$row->subject_title;
				}
			}
		}
		if(!isset($this->mapLight_bill_cache[$mapBillId])){
			if($doLookup){
				print "missing bill by mapId: $mapBillId retrive it: \n";
				$raw_bill_page = $this->doRequest('http://www.maplight.org/map/us/bill/'.$mapBillId.'/default');
				preg_match('/title">([^-]*)-/', $raw_bill_page, $matches);				
				if(isset($matches[1]))$bill_key = trim($matches[1]);			
				preg_match('/map-bill-title">([^t]*)t/',$raw_bill_page, $matches);
				if(isset($matches[1]))$session_num = trim($matches[1]);			
				print " found bill key:$session_num $bill_key \n";
				//set a flag as to not get caught in infintate loop: 
				$this->bill_name_maplight_lookup=false;
				$this->get_and_proccess_billid($bill_key, '', $session_num);
				print " found bill title: ". $this->cur_bill_short_title . "\n";
				//should now have the bill name update the cache and return
				$this->mapLight_bill_cache[$mapBillId]= $this->cur_bill_short_title;				
			}else{
				print "unable to find bill 	mapId: $mapBillId \n";
				return false;
			}
		}
		return $this->mapLight_bill_cache[$mapBillId];
	}
	function get_wiki_name_from_govid($govID){
		if(!isset($this->govTrack_cache)){
			$sql = 'SELECT * FROM `smw_attributes` WHERE `attribute_title` = \'GovTrack_Person_ID\'';				
			$dbr = wfGetDB( DB_SLAVE );	
			$res = $dbr->query($sql);
			while ($row = $dbr->fetchObject($res)) {
				$this->govTrack_cache[$row->value_xsd]=$row->subject_title;
			}
		}
		if(!isset($this->govTrack_cache[$govID])){
			$wgTitle = Title::newFromText('Archive:Missing_People');
			print $govID. ' not found ' . "\n";
			append_to_wiki_page($wgTitle, "Missing GovTrack person: [[Missing GovTrackId:=$govID]][http://www.govtrack.us/congress/person.xpd?id=$govID] ");
			return false;	
		}
		return str_replace('_',' ',$this->govTrack_cache[$govID]);
	}
	function get_wiki_name_from_maplightid($mapID){		
		if(!isset($this->mapLight_cache)){
			$sql = 'SELECT * FROM `smw_attributes` WHERE `attribute_title` = \'MAPLight_Person_ID\'';
			$dbr = wfGetDB( DB_SLAVE );	
			$res = $dbr->query($sql);
			while ($row = $dbr->fetchObject($res)) {
				$this->mapLight_cache[$row->value_xsd]=$row->subject_title;
			}
		}
		if(!isset($this->mapLight_cache[$mapID])){
			$wgTitle = Title::newFromText('CongressVid:Missing_People');
			print "Missing MAPLight key for $mapID (have you insertd maplight ID for everyone yet?)\n";			
			//append_to_wiki_page($wgTitle, "Missing MapLight person: [http://maplight.org/map/us/legislator/$mapID $mapID]");
			return false;	
		}
		return str_replace('_',' ',$this->mapLight_cache[$mapID]);
	}
				
}

class MV_ArchiveOrgScrape extends MV_BaseScraper{
	function getFileList($stream_name){
		$raw_page = $this->doRequest('http://www.archive.org/details/mv_'.$stream_name);
		preg_match_all('/href="(http:\/\/www.archive.org\/download\/mv_[^"]*)">([^<]*)<\/a>([^<]*)/', $raw_page, $matches);
		$files = array();		
		if(isset($matches[1])){
			foreach($matches as $inx=>$set){
				foreach($set as $k=>$v){
					$files[$k][$inx]=trim($v);
				}
			}
			//add the flv:
			$files[]=array('',
					 'http://www.archive.org/download/mv_'.$stream_name.'/'.$stream_name.'.flv',
					 'flash flv', '');
		}else{
			return false;
		}		
		return $files;
	}
}

class MV_BaseScraper{
	/*
	 * simple url cach using the mv_url_cache table
	 * 
	 * @@todo handle post vars
	 */
	function doRequest($url, $post_vars=array()){
		global $mvUrlCacheTable;
		$dbr = wfGetDB( DB_SLAVE );	
		$dbw = wfGetDB( DB_MASTER );
		//check the cache 
		//$sql = "SELECT * FROM `metavid`.`cache_time_url_text` WHERE `url` LIKE '$url'";	
		//select( $table, $vars, $conds='', $fname = 'Database::select', $options = array() )	
		$res = $dbr->select($mvUrlCacheTable, '*', array('url'=>$url), 'MV_BaseScraper::doRequest');
		//@@todo check date for experation
		if($res->numRows()==0){
			echo "do web request: " . $url . "\n";
			//get the content: 
			$page = file_get_contents($url);
			if($page===false){
				echo("error retriving $url retrying...\n");
				sleep(5);				
				return $this->doRequest($url);
			}
			if($page!=''){
				//insert back into the db: 
				//function insert( $table, $a, $fname = 'Database::insert', $options = array() )
				$dbw->insert($mvUrlCacheTable, array('url'=>$url, 'result'=>$page, 'req_time'=>time()));			
				return $page;
			}
		}else{			
			$row = $dbr->fetchObject( $res );
			return $row->result;			
		}
	}
}
?>
