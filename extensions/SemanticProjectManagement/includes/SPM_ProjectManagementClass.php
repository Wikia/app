<?php
/*******************************************************************************
 *
 *	Copyright (c) 2010 Frank Dengler, Jonas Bissinger
 *
 *   Semantic Project Management is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General PIFublic License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   Semantic Project Management is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with Semantic Project Management. If not, see <http://www.gnu.org/licenses/>.
 *******************************************************************************/

/**
 *
 * @author Frank Dengler, Jonas Bissinger
 *
 * @ingroup SemanticProjectManagement
 *
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

class ProjectManagementClass{
	
	//general variables
	protected $m_name = ""; 
	private $m_title = "";
	protected $m_tasks = array();
	protected $m_resources = array();
	protected $m_startDate = null; 
	protected $m_id = 1;
	protected $m_errors	= array();
	
	//variables for Gantt-Chart
	//display options
	protected $m_showDiscussion	= false;	
	protected $m_showResponsible = false;
	protected $m_showDuration = false;
	protected $m_showComplete = false;
	protected $m_showStartdate = false;
	protected $m_showEnddate = false;
	//TODO: implement Caption, DateInputFormat, DateDisplayFormat, FormatArr
	
	//settings from SpecialPage
	protected $m_categories = array();
	protected $m_colors = array();  		
	protected $m_properties = array(); 
	protected $m_m0 = "";	//startmonth (M0) for M-notation
	protected $m_allSame = false; //true if all categories are identical
	
	//getters and setters
	public function setTitle($title){
		$this->m_title = $title;
	}

	public function getTitle(){
		return $this->m_title;
	}
	
	public function setName($name){
		$this->m_name = $name;
	}

	public function getName(){
		return $this->m_name;
	}

	public function getShowResponsible(){
		return $this->m_showResponsible;
	}
	
	public function setShowResponsible($show){
		$this->m_showResponsible = $show;
	}
	
	public function getShowDiscussion(){
		return $this->m_showDiscussion;
	}
	
	public function setShowDiscussion($show){
		$this->m_showDiscussion = $show;
	}

	public function getShowDuration(){
		return $this->m_showDuration;
	}
	
	public function setShowDuration($show){
		$this->m_showDuration = $show;
	}
	
	public function getShowComplete(){
		return $this->m_showComplete;
	}
	
	public function setShowComplete($show){
		$this->m_showComplete = $show;
	}

	public function getShowStartdate(){
		return $this->m_showStartdate;
	}
	
	public function setShowStartdate($show){
		$this->m_showStartdate = $show;
	}
	
	public function getShowEnddate(){
		return $this->m_showEnddate;
	}
	
	public function setShowEnddate($show){
		$this->m_showEnddate = $show;
	}
	
	public function getm0(){
		return $this->m_m0;
	}
	
	public function getID(){
		return $this->m_id;
	}
	
	public function getParents(){
		return $this->m_parents;
	}
	
	private function makeID($val){
		return $val;
	}

	/**
	 * This method sets the internal values for Gantt-chart
	 *
	 */
	public function setInternals(){
		//get internal values from SPM_Setup page
		$title = Title::newFromText("SPM_Setup");
		$article  = new Article($title);
		$wikitext = $article->getContent();
		
		$pos1 = strpos($wikitext,"<!--");		
		$pos2 = strpos($wikitext,"-->");
		
		$data = substr($wikitext,$pos1+4,$pos2-$pos1-4);	
		
		$textarr = explode("{**}",$data);
		$levels = (int) $textarr[0];
		$this->m_m0  = $textarr[1];
		$this->m_allSame = $textarr[2];
		
		for ( $i = 0; $i < $levels; $i += 1) {
			
			$vals = array_splice($textarr,3,3);
			$this->m_categories[$i] = $vals[0];
			$this->m_colors[$i] = $vals[1];
			$this->m_properties[$i] = $vals[2];
		}
		
	}
	
	public function getCategories(){
		return $this->m_categories;
	}
	public function getColors(){
		return $this->m_colors;
	}
	public function getProperties(){
		return $this->m_properties;
	}
	/**
	 * This method creates UIds for every task and orders them to correctly display the Gantt-chart
	 */
	private function orderTasks(){
		
			$this->setTimeParameters();
			
			usort($this->m_tasks,array( $this , "cmpLevel"));
			
			$level1number = 10;
			$number = array();
			$tasknames = array();
			$parent = array();
			
			
			//create UId for each task with following logic:
			//UId of first task: 10
			//UId of 10's first child: 1010
			//UId of 10's second child: 1011
			//UId of 1011's first child: 101110 ... 
			foreach ($this->m_tasks as $temp){
				
				$temp->setM0($this->m_m0);
				
					if (!isset($number[$temp->getLevel()])) $number[$temp->getLevel()] = 10;
					
					//check to which parent task belongs
					$parts = $temp->getPartOf();
					
					if (sizeof($parts) == 0){
						//level 1
						$temp->setUid($level1number);
						$tasknames[$temp->getId()] = $temp->getUid();							
						$level1number++;
					}
					else {
						
					foreach ($parts as $part){
																	
						if (isset($tasknames[$part])){	
							if (!isset($number[$tasknames[$part]])) $number[$tasknames[$part]] = 10;	
							$temp->setUid(100*$tasknames[$part]+$number[$tasknames[$part]]);
							$temp->setParent($tasknames[$part]);
							$tasknames[$temp->getId()] = $temp->getUid();
							$number[$tasknames[$part]]++;
							$parent[$tasknames[$part]] = 1;
						}	
						//no part-of relation found -> level 1	
						else {
							$temp->setUid($level1number);
							$tasknames[$temp->getId()] = $temp->getUid();							
							$level1number++;
						}
					}
				}							
			}
			
			//set group property for all parents
			foreach ($this->m_tasks as $temp){
				if ((isset($parent[$temp->getUid()]))&&($parent[$temp->getUid()] == 1)){
					$temp->setGroup(1);
					$temp->setGanttEndDate('');
					$temp->setGanttStartDate('');
				}			
				else $temp->setGroup(0);
			}
			
			//all tasks have a UId -> sort tasks by UId (with string comparison) 
			usort($this->m_tasks,array( $this , "cmpUid"));

	}
	
	/**
	 * Comparison function, orders by: level, starttime (if level was identical), name (if level & starttime identical)
	 *
	 * @param $task1		task, first task to compare
	 * @param $task2		task, second task to compare
	 */  
	static function cmpLevel($task1,$task2){
		$level1 = $task1->getLevel();
		$level2 = $task2->getLevel();

		
		if ($level1 == $level2) {
			
			$sec1 = $task1->getStartSeconds();
			$sec2 = $task2->getStartSeconds();			
			
			if ($sec1 == $sec2) {
				
				
				$name1 = (String) $task1->getLabel();
				$name2 = (String) $task1->getLabel();
								
				return strnatcasecmp($name1,$name2);
			}
			return ($sec1 > $sec2);	
		}
		return ($level1>$level2);
	}	
	
	/**
	 * Comparison function, orders by: string comparison of UId
	 *
	 * @param $task1		task, first task to compare
	 * @param $task2		task, second task to compare
	 */
	static function cmpUid($task1,$task2){
		$id1 = (String) $task1->getUid();
		$id2 = (String) $task2->getUid();		
		return strcmp($id1,$id2);
	}	

	/**
	 * Comparison function, orders by: XMLSchemaDate
	 *
	 * @param $task1		task, first task to compare
	 * @param $task2		task, second task to compare
	 */
	static function cmpDate($task1,$task2){
		$date1 = $task1->getPlannedStartDate();
		if ($date1!=null)
			$res1 = strtotime($date1->getXMLSchemaDate());
		$date2 = $task2->getPlannedStartDate();
		if ($date2!=null)
			$res2 = strtotime($date2->getXMLSchemaDate());
		return ($res1<$res2);

	}
	
	/**
	 * This method should be used for getting new or existing nodes
	 * If a node does not exist yet, it will be created
	 *
	 * @param $id			string, node id
	 * @param $label		string, node label
	 * @return				Object of type ProcessNode
	 */
	public function makeTask($val, $level){

		$this->id = $this->makeID($val);
		$id = $this->makeID($val);
		
		$task;
		
		// check if node exists
		if (isset($this->m_tasks[$id])){
			// take existing node
			$task = $this->m_tasks[$id];

			//switch on for debugging
//			echo "Task: ".$task->getID()." already exists! <br/>";
		} else {
			// create new node
				
			$task = new ProjectManagementTask();
			$task->setOutlineLevel($level);
			$task->setPage($val);
			$task->setProjectManagementClass($this);
			$task->setId($this->id);
			//set default color
			$task->setColor("ff0000");
			
			// add new node to process
			$this->m_tasks[$id] = $task;
			
			//switch on for debugging
//			echo "Task: ".$task->getID()." created! <br/>";
		}
		return $task;

	}
	
	/**
	 * This method should be used for making a new Resource
	 *
	 * @param $val			Value of resource that is to be created
	 * @return				Object of type resource
	 */
	public function makeResource($val){

		$id = $this->makeID($val);
		$resource;

		// check if node exists
		if (isset($this->m_resources[$id])){
			// take existing node
			$resource = $this->m_resources[$id];

		} else {
			// create new node
			$this->m_uid++;
			$uid = $this->m_uid;
			
			
			$resource = new ProjectManagementResource();
			$resource->setPage($val);
			$resource->setUid($uid);
			$resource->setId($uid);
			$resource->setProjectManagementClass($this);

			// add new node to process
			$this->m_resources[$id] = $resource;
		}
			
		return $resource;

	}

	
	/**
	 * Processes a result set and saves all relevant values internally
	 *
	 * @param $res			array, Result set that is to be processed
	 * @param $outputmode	Outputmode
	 * @param $level		int, Level of Result set
	 * @param $parent		Parent of result set
	 * @return				Array of all children
	 */
	public function getTaskResults($res, $outputmode, $level, $parent) {
		global $wgContLang, $spmgScriptPath; // content language object
		$hasChild = array();
		//
		//	Iterate all rows in result set
		//
		$number=1;
		$row = $res->getNext(); // get initial row (i.e. array of SMWResultArray)

		
		while ( $row !== false) {

			$task;
			$subject = $row[0]->getResultSubject(); // get Subject of the Result
			// creates a new node if $val has type wikipage

			$val = $subject->getLongWikiText();
			
			$task  = $this->makeTask($val, $level);

			if ($this->m_allSame == true){
				$task->setLevel($level);
				$task->setColor($this->m_colors[$level-1]);
			}
		//	echo "generating task: ".$val."<br/>";
			
			$hasChild[] = $task;
			$task->setWBS($parent->getWBS());
			$task->addWBS($level,$number);
			$number++;

			if ($parent->getID() != "seed"){
				$task->addPartOf($parent->getID());
//				echo $task->getID()."s parent is: ".$parent->getID()."<br/>";
			}
			
			$title = $subject->getTitle();
			$fullURL = $title->getFullURL();
			$task->setHyperlink($fullURL);
			$discussionTitle = Title::newFromText('Talk:'.$val.'');
			if ($discussionTitle->isKnown()) {
	
				$task->setPictureURL($spmgScriptPath . 'libs/ganttchart/discuss_icon.png');
				$task->setPictureLink($discussionTitle->getFullURL());
			}
			//
			//	Iterate all colums of the row (which describe properties of the proces node)
			//

			foreach ($row as $field) {
					
				// check column title
				$req = $field->getPrintRequest();
				switch ((strtolower($req->getLabel()))) {

					case "hassuccessor":

						// Sequence
						foreach ($field->getContent() as $value) {
							
							$val = $value->getLongWikiText();
							$suc = $this->makeTask($val, $level);
							$task->addSuccessor($suc);
							$suc->addPredecessor($task);
						
							//echo "hasSuccessor: ".$suc->getUid();
							
						
							if ( $value->getTypeID() == '_wpg' ){
								$title = $value->getTitle();
								$fullURL = $title->getFullURL();

								$suc->setHyperlink($fullURL);
 							}
 							
						}
						break;	

						case "category":
	
							// sequence
							foreach ($field->getContent() as $value) {
								
								//only identify level by category if all categories are different
								if ($this->m_allSame == false){
									if (($value !== false)) {
										$val = $value->getShortWikiText();
										
										for ($i=0; $i<sizeof($this->m_categories);$i++){
															
											if ($val == $this->m_categories[$i]) {
												
											//	if (($task->getLevel() == 0)||($task->getLevel() < $task->getCurrentLevel())){
													$task->setColor($this->m_colors[$i]);
													$task->setLevel($i+1);		
												//	$task->setCurrentLevel($i+1);
											//	}					
											}
										}
	
									}
								}
							}
							break;

						case "progress":
							
							$value = current($field->getContent()); // save only the first
							if (($value !== false)) {
								$val = $value->getShortWikiText();
								$task->setProgress($val);
							}
						break;
							
							
						case "startmonth":
							
							$value = current($field->getContent()); // save only the first
							if (($value !== false)) {
								$val = $value->getShortWikiText();
								$task->setStartmonth($val);
							}
							break;
	
							
						case "endmonth":
							
							$value = current($field->getContent()); // save only the first
							if (($value !== false)) {
								$val = $value->getShortWikiText();
								$task->setEndmonth($val);
							}
							break;
	
						case "deliverymonth":
							
							$value = current($field->getContent()); // save only the first
							if (($value !== false)) {
								$val = $value->getShortWikiText();
								$task->setDeliverymonth($val);
							}
							break;
													
						case "haslabel":
							$value = current($field->getContent()); // save only the first
							if (($value !== false)) {
								$val = $value->getShortWikiText();
								$task->setLabel($val);
							}
							break;
	
						case "hasrealstartdate":
							$value = current($field->getContent()); // save only the first
							if (($value !== false) && ($req->getTypeID() == "_dat")) {
	
								$task->setStartDate($value);
							}
							break;
						case "hasrealfinishdate":
							$value = current($field->getContent()); // save only the first
							if (($value !== false) && ($req->getTypeID() == "_dat")) {
	
								$task->setFinishDate($value);
							}
						case "hasplannedstartdate":
							$value = current($field->getContent()); // save only the first
							if (($value !== false) && ($req->getTypeID() == "_dat")) {
	
								$task->setPlannedStartDate($value);
							}
							break;
						case "hasplannedfinishdate":
							$value = current($field->getContent()); // save only the first
							if (($value !== false) && ($req->getTypeID() == "_dat")) {
								
								$task->setPlannedFinishDate($value);
							}
							break;
						case "hasearlystartdate":
							$value = current($field->getContent()); // save only the first
							if (($value !== false) && ($req->getTypeID() == "_dat")) {
	
								$task->setEarlyStartDate($value);
							}
							break;
						case "hasearlyfinishdate":
							$value = current($field->getContent()); // save only the first
							if (($value !== false) && ($req->getTypeID() == "_dat")) {
	
								$task->setEarlyFinishDate($value);
							}
							break;
						case "haslatestartdate":
							$value = current($field->getContent()); // save only the first
							if (($value !== false) && ($req->getTypeID() == "_dat")) {
	
								$task->setLateStartDate($value);
							}
							break;
						case "haslatefinishdate":
							$value = current($field->getContent()); // save only the first
							if (($value !== false) && ($req->getTypeID() == "_dat")) {
	
								$task->setLateFinishDate($value);
							}
							break;
						case "hasactor":
							$value = current($field->getContent()); // save only the first
							if (($value !== false)) {
								$val = $value->getShortWikiText();
								$resource = $this->makeResource($val);
								$task->setActor($val);
							}
							break;
												
						case "resource":
							$value = current($field->getContent()); // save only the first
							if (($value !== false)) {
								$val = $value->getShortWikiText();
								$task->setResource($val);
							}
							break;	
							
						case "caption":
							$value = current($field->getContent()); // save only the first
							if (($value !== false)) {
								$val = $value->getShortWikiText();
								$task->setCaption($val);
							}
							break;
						default:											
					
						
						// TODO - redundant column in result

				}
			}

			// reset row variables
			unset($task);

			$row = $res->getNext();		// switch to next row
		}
		
		return $hasChild;

	}

	/**
	 * This method returns all tasks that neither have a successor nor a successor 
	 *
	 * @param $tasks		array, tasks that are to be checked
	 * @return				array of all single tasks
	 */
	public function returnSingleTasks($tasks){
		$single = array()	;

		foreach ($tasks as $task){
			if ((count($task->getSuccessors())==0)&&(count($task->getPredecessors())==0)){

				$single[] = $task;

			}
		}
		return $single;
	}

	/**
	 * This method returns all tasks that neither have a successor nor a successor 
	 *
	 * @param $tasks		array, tasks that are to be checked
	 * @return				array of all single tasks
	 */
	public function returnStartTasks($tasks){
		$single = array()	;

		foreach ($tasks as $task){
			if ((count($task->getSuccessors())>0)&&(count($task->getPredecessors())==0)){

				$single[] = $task;

			}
		}
		return $single;
	}
	
	
	/**
	 * This method sets the time Parameters to correctly display the Gantt-chart
	 * Priorities from low to high:
	 * plannedStart/FinishDate, Start/EndMonth (M notation), realStart/EndDate
	 * if a task has more than one value, the one with the highest priority is selected
	 * 
	 */
	public function setTimeParameters(){
			
		foreach($this->m_tasks as $task){
		
			$starttime = null;
			$endtime = null;
			$startdate = null;
			$enddate = null;
			
			//if planned start date exists
			if ($task->getPlannedStartDate() != null) {
							
				$startdate = $task->getGanttDate($task->getPlannedStartDate());
	
				//get task starttime as int
				$starttime = $this->getTimeAsInt($task->parsedate($task->getPlannedStartDate()));
	
			}		
			
			//if planned finish date exists
			if ($task->getPlannedFinishDate() != null){
				
				$enddate = $task->getGanttDate($task->getPlannedFinishDate());
				
				$endtime = $this->getTimeAsInt($task->parsedate($task->getPlannedFinishDate()));				
			}
			
			
			//convert M1-36 notation. 
			if ($task->getStartMonth() != null){
				$starttime = $task->monthToTime($task->getStartmonth());								
				$startdate = $task->monthToGanttDate($task->getStartmonth());
			}
			if ($task->getEndMonth() != null){
				
				$tempint = (int) str_replace("M","",$task->getEndmonth());
				$tempint++;
				$endmonth = (string) "M".$tempint;
				$endtime = $task->monthToTime($endmonth);
				$enddate = $task->monthToGanttDate($endmonth);
			}
			
			//convert for M1-36 notation. (for Deliverables)
			//can be removed if all deliverables have start&enddate
			if ($task->getDeliveryMonth() != null){
				
				$endtime = $task->monthToTime($task->getDeliverymonth());
				$starttime = $endtime - (30*24*60*60);			
				
				$enddate = $task->monthToGanttDate($task->getDeliverymonth());
				
				//set startdate = 1 month before enddate
				$date = explode("/",$enddate);
				if ($date[0] != "01") {
					$m = (int) $date[0];
					$s = (string)($m-1);
					if ($m < 11) $s = "0".$s;
					$date[0] = $s;
				}
				else {
					$date[0] = 12;
					$rest = explode(" ",$date[2]);
					$y = (int) $rest[0];
					$s = (string)($y-1);
					$rest[0] = $s;
					$date[2] = implode(" ",$rest);
				}
				$startdate = implode("/",$date);
				
			}
			
			//if real start date exists
			if (($task->getStartDate() != null)){
				$startdate = $task->getGanttDate($task->getStartDate());
				
				//get task starttime as int
				
				$starttime = $this->getTimeAsInt($task->parsedate($task->getStartDate()));
			}

			//if real finish date exists
			if (($task->getFinishDate() != null)){
				$enddate = $task->getGanttDate($task->getFinishDate());
				
				//get task endtime as int
				
				$endtime = $this->getTimeAsInt($task->parsedate($task->getFinishDate()));
			}
			
			//calculate progress
			$progress = 0;
			
			//only calculate progress if real start date exists
			if ($task->getStartDate() != null){
				$time = getdate();
				$todaytime = $time[0]; 
				if ($todaytime >= $endtime) $progress = 100;
		
				if (($todaytime > $starttime)&&($todaytime < $endtime)){
		
					if ($endtime > $starttime)
					$progress = (int)((($todaytime - $starttime)/($endtime-$starttime))*100);
					
				}
			}
			
			//use progress property if existing
			if ($task->getProgress() != null) $progress = $task->getProgress();
					
			//TODO: error handling
			if ((($task->getLevel() == sizeof($this->m_categories)))&&(($startdate == null)||($enddate == null))){
				    
				echo "ERROR: No valid time for ".$task->getLabel()."<br/>";
			    if ($startdate == null) echo "no startdate! <br/>";
			    if ($enddate == null) echo "no enddate! <br/>";
				$task->setStartSeconds(0);
				$task->setGanttStartDate($startdate);
				$task->setGanttEndDate($enddate);
				$task->setProgress(0);
				
			}
			else{
				$task->setStartSeconds($starttime);
				$task->setGanttStartDate($startdate);
				$task->setGanttEndDate($enddate);
				$task->setProgress($progress);
			}
			
		}
	}
	
	private function getTimeAsInt($date){
		//get task starttime as int
				$time1 = explode("T",$date);
				$time2 = explode("-",$time1[0]);
				if (count($time1)>1){
					$time3 = explode(":",$time1[1]);
				} else {
					$time3 = array(0,0,0);
				}
				return date("U",mktime($time3[0],$time3[1],$time3[2],$time2[1],$time2[2],$time2[0]));
	}
	
	/**
	 * This method returns a Calendar
	 * @return string, CalendarXML
	 * 
	 */
	public function getCalendarXML(){
		$res ='';
		$res .="<Calendars>\r\n";
		$res .="<Calendar>\r\n";
		$res .="<UID>3</UID>\r\n";
		$res .="<Name>24 Stunden</Name>\r\n";
		$res .="<IsBaseCalendar>1</IsBaseCalendar>\r\n";
		$res .="<BaseCalendarUID>-1</BaseCalendarUID>\r\n";
		$res .="<WeekDays>\r\n";
		$res .="<WeekDay>\r\n";
		$res .="<DayType>1</DayType>\r\n";
		$res .="<DayWorking>1</DayWorking>\r\n";
		$res .="<WorkingTimes>\r\n";
		$res .="<WorkingTime>\r\n";
		$res .="<FromTime>00:00:00</FromTime>\r\n";
		$res .="<ToTime>00:00:00</ToTime>\r\n";
		$res .="</WorkingTime>\r\n";
		$res .="</WorkingTimes>\r\n";
		$res .="</WeekDay>\r\n";
		$res .="<WeekDay>\r\n";
		$res .="<DayType>2</DayType>\r\n";
		$res .="<DayWorking>1</DayWorking>\r\n";
		$res .="<WorkingTimes>\r\n";
		$res .="<WorkingTime>\r\n";
		$res .="<FromTime>00:00:00</FromTime>\r\n";
		$res .="<ToTime>00:00:00</ToTime>\r\n";
		$res .="</WorkingTime>\r\n";
		$res .="</WorkingTimes>\r\n";
		$res .="</WeekDay>\r\n";
		$res .="<WeekDay>\r\n";
		$res .="<DayType>3</DayType>\r\n";
		$res .="<DayWorking>1</DayWorking>\r\n";
		$res .="<WorkingTimes>\r\n";
		$res .="<WorkingTime>\r\n";
		$res .="<FromTime>00:00:00</FromTime>\r\n";
		$res .="<ToTime>00:00:00</ToTime>\r\n";
		$res .="</WorkingTime>\r\n";
		$res .="</WorkingTimes>\r\n";
		$res .="</WeekDay>\r\n";
		$res .="<WeekDay>\r\n";
		$res .="<DayType>4</DayType>\r\n";
		$res .="<DayWorking>1</DayWorking>\r\n";
		$res .="<WorkingTimes>\r\n";
		$res .="<WorkingTime>\r\n";
		$res .="<FromTime>00:00:00</FromTime>\r\n";
		$res .="<ToTime>00:00:00</ToTime>\r\n";
		$res .="</WorkingTime>\r\n";
		$res .="</WorkingTimes>\r\n";
		$res .="</WeekDay>\r\n";
		$res .="<WeekDay>\r\n";
		$res .="<DayType>5</DayType>\r\n";
		$res .="<DayWorking>1</DayWorking>\r\n";
		$res .="<WorkingTimes>\r\n";
		$res .="<WorkingTime>\r\n";
		$res .="<FromTime>00:00:00</FromTime>\r\n";
		$res .="<ToTime>00:00:00</ToTime>\r\n";
		$res .="</WorkingTime>\r\n";
		$res .="</WorkingTimes>\r\n";
		$res .="</WeekDay>\r\n";
		$res .="<WeekDay>\r\n";
		$res .="<DayType>6</DayType>\r\n";
		$res .="<DayWorking>1</DayWorking>\r\n";
		$res .="<WorkingTimes>\r\n";
		$res .="<WorkingTime>\r\n";
		$res .="<FromTime>00:00:00</FromTime>\r\n";
		$res .="<ToTime>00:00:00</ToTime>\r\n";
		$res .="</WorkingTime>\r\n";
		$res .="</WorkingTimes>\r\n";
		$res .="</WeekDay>\r\n";
		$res .="<WeekDay>\r\n";
		$res .="<DayType>7</DayType>\r\n";
		$res .="<DayWorking>1</DayWorking>\r\n";
		$res .="<WorkingTimes>\r\n";
		$res .="<WorkingTime>\r\n";
		$res .="<FromTime>00:00:00</FromTime>\r\n";
		$res .="<ToTime>00:00:00</ToTime>\r\n";
		$res .="</WorkingTime>\r\n";
		$res .="</WorkingTimes>\r\n";
		$res .="</WeekDay>\r\n";
		$res .="</WeekDays>\r\n";
		$res .="</Calendar>\r\n";
		$res .="</Calendars>\r\n";
		return $res;
	}

	/**
	 * This method returns the html that integrates the JSGantt on the wikipage 
	 * @return string, GanttChart
	 * 
	 */
	public function getGanttChart(){
		global $spmgScriptPath;
		
	//	$levelcheck = $this->getParents();
		
		array_shift($this->m_tasks);
		
		$this->orderTasks();
		
		$res ='';
		$res .='<link rel="stylesheet" type="text/css" href="' .$spmgScriptPath . '/libs/ganttchart/jsgantt.css" />';
		$res .="\r\n";
		$res .='<script language="javascript" src="' .$spmgScriptPath . '/libs/ganttchart/jsgantt.js"></script>';
		$res .="\r\n";
		$res .='<div style="position:relative" class="gantt" id="GanttChartDIV"></div>';
		$res .="\r\n";
		$res .='<script language="javascript">';
		$res .="\r\n";
		$res .='var g = new JSGantt.GanttChart(\'g\',document.getElementById(\'GanttChartDIV\'), \'day\');';
		$res .="\r\n";
		

		if ($this->getShowResponsible()){
			$res .='g.setShowRes(1); // Show Responsible';
		} else {
			$res .='g.setShowRes(0); // Hide Responsible';			
		}
		$res .="\r\n";
		
		if ($this->getShowComplete()){
			$res .='g.setShowComp(1); // Show Completeness';
		} else {
			$res .='g.setShowComp(0); // Hide Completeness';			
		}		
		$res .="\r\n";
		
		if ($this->getShowDuration()){
			$res .='g.setShowDur(1); // Show Duration';
		} else {
			$res .='g.setShowDur(0); // Hide Duration';			
		}	
		$res .="\r\n";

		if ($this->getShowDiscussion()) {
			$res .='g.setShowPicture(1); // Show Picture';
		} else {
			$res .='g.setShowPicture(0); // Hide Picture';
		}
		$res .="\r\n";
				
		if ($this->getShowStartdate()) {
			$res .='g.setShowStartDate(1); // Show Startdate';
		} else {
			$res .='g.setShowStartDate(0); // Hide Startdate';
		}
		$res .="\r\n";

		if ($this->getShowEnddate()) {
			$res .='g.setShowEndDate(1); // Show Enddate';
		} else {
			$res .='g.setShowEndDate(0); // Hide Enddate';
		}
		$res .="\r\n";
		
		$res .='g.setCaptionType(\'Complete\');  // Set to Show Caption';
		$res .="\r\n";
		$res .='g.setFormatArr("hour","day","week","month");';
		$res .="\r\n";				
		
		$id=1;
		foreach($this->m_tasks as $task){
			$tempres = $task->getGanttChart($this->id);
			$res .= $tempres[0];
			$id = $tempres[1];
		}

		$res .='g.Draw();';
		$res .="\r\n";
		$res .='g.DrawDependencies();';
		$res .="\r\n";
		$res .='</script>';
		$res .="\r\n";
		return $res;
	}

	/**
	 * This method returns the XML representation of the project
	 * @return string, XML representation
	 * 
	 */
	public function getXML(){
		array_shift($this->m_tasks);
		$this->orderTasks();

		$res ='';
		//
		// header
		//
		$res .='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'."\r\n";
		$res .='<Project xmlns="http://schemas.microsoft.com/project">'."\r\n";
		$res .="<SaveVersion>1</SaveVersion>\r\n";
		if ($this->m_name!='')
		$res .="<Name>" . $this->m_name . "</Name>\r\n";
		if ($this->m_title!='')
		$res .="<Title>" . $this->m_title . "</Title>\r\n";
		if ($this->m_startDate!=null){
			$res .= "<StartDate>" . $this->m_startDate . "</StartDate>\r\n";
			$res .= "<ScheduleFromStart>1</ScheduleFromStart>\r\n";
		}
		// $res .= $this->getCalendarXML();
		// add tasks
		$res .="<Tasks>\r\n";
		$id=1;
		foreach($this->m_tasks as $task){
			
			$tempres = $task->getXML($id);
			$res .= $tempres[0];
			$id = $tempres[1];
			
		}
		$res .="</Tasks>\r\n";
		$res .="<Resources>\r\n";

		foreach($this->m_resources as $resource){

			$res .= $resource->getXML();

		}

		$res .="</Resources>\r\n";
		if (count($this->m_resources)>0){
			$res .="<Assignments>\r\n";
			$id=1;
			foreach($this->m_tasks as $task){
				$tempres = $task->getAssignmentXML($id);
				$res .= $tempres[0];
				$id = $tempres[1];
			}
			$res .="</Assignments>\r\n";
		}
		//
		// add final stuff
		//
		$res .= "</Project>\r\n";

		return $res;

	}

}



abstract class ProjectManagementElement{

	private $m_projectmanagementclass;
	// TODO I18N
	private $m_id = 'no_id';
	private $m_uid	= 'no_uid';
	private $m_uri = '';
	private $m_label = 'unlabeled';
	private $m_page='';
	
	
	//setters and getters
	public function getId(){
		return $this->m_id;
	}

	public function setId($id){
		$this->m_id = $id;
	}

	public function getLabel(){
		return $this->m_label;
	}

	public function setLabel($label){
		$this->m_label = $label;
	}

	public function setProjectManagementClass($proc){
		$this->m_projectmanagementclass =  $proc;
	}

	public function getProjectManagementClass(){
		return $this->m_projectmanagementclass;
	}

	public function getUid(){
		return $this->m_uid;
	}
	public function setUid($uid){
		$this->m_uid = $uid;
	}
	public function getUri(){
		return $this->m_uri;
	}
	public function setUri($uri){
		$this->m_uri = $uri;
	}
	public function setPage($page){
		$this->m_page = $page;
	}
	public function replaceLabelChars($label){
		return str_replace("&","and",$label);
	}
}



class ProjectManagementTask extends ProjectManagementElement{

	//task variables
	private $m_WBS= array();
	private $m_outlineLevel;
	// TODO I18N
	private $m_page ='';
	private $m_successors = array();
	private	$m_predecessors = array();
	private $m_earlyStart =null;
	private $m_earlyFinish=null;
	private $m_lateStart=null;
	private $m_lateFinish=null;
	private $m_start=null;
	private $m_finish=null;
	private $m_plannedStart=null;
	private $m_plannedFinish=null;
	private $m_timestamp=null;
	private $m_actor=null;
	private $m_hyperlink='';
	private $m_picturelink='';
	private $m_pictureurl='';
	private $m_color ='';
	private $m_progress = null;
	private $m_resource='';	
	private $m_milestone = false;
	private $m_group = 0;
	private $m_parent = 0;
	private	$m_open = 1;
	private $m_depend = "";
	private $m_caption = "";
	private $m_level = 0;
	private $m_parentname = "";
	private $m_parentBool = false;
	private $m_pid = 0;
	private $m_idd;
	private $m_startmonth;
	private $m_endmonth;
	private $m_deliverymonth;
	private $m_partOf = array();
	private $m_m0 = "";
	private $m_startdate = null;
	private $m_enddate = null;
	private $m_startseconds = null;
	private $m_currentlevel = 0;
	
	//getters and setters
	public function setCurrentLevel($l){
		$this->m_currentlevel = $l;
	}
	
	public function getCurrentLevel(){
		return $this->m_currentlevel;
	}
	
	public function setM0($m){
		$this->m_m0 = $m;
	}
	
	public function getM0(){
		return $this->m_m0;
	}
	
	public function setGanttStartDate($p){
		$this->m_startdate = $p;
	}
	
	public function getGanttStartDate(){
		return $this->m_startdate;
	}	

	public function setGanttEndDate($p){
		$this->m_enddate = $p;
	}
	
	public function getGanttEndDate(){
		return $this->m_enddate;
	}	
	
	public function setStartSeconds($p){
		$this->m_startseconds = $p;
	}
	
	public function getStartseconds(){
		return $this->m_startseconds;
	}	
	
	public function addPartOf($p){
		$this->m_partOf[] = $p;
	}
	
	public function getPartOf(){
		return $this->m_partOf;
	}
	
	public function setStartmonth($s){
		$this->m_startmonth = $s;		
	}

	public function getStartmonth(){
		return $this->m_startmonth;
	}
	
	public function setEndmonth($s){
		$this->m_endmonth = $s;		
	}

	public function getEndmonth(){
		return $this->m_endmonth;
	}

	public function setDeliverymonth($s){
		$this->m_deliverymonth = $s;		
	}

	public function getDeliverymonth(){
		return $this->m_deliverymonth;
	}
	
	public function setIsParent($b){
		$this->m_parentBool = $b;
	}
	
	public function isParent(){
		return $this->m_parentBool;
	}
	
	public function setLevel($l){
		$this->m_level=$l;
	}
	
	public function getLevel(){
		return $this->m_level;
	}
	
	public function setColor($c){
		$this->m_color=strtolower($c);
	}
	
	public function getColor(){
		return $this->m_color;
	}
	
	public function setParent($p){
		$this->m_parent = $p;
	}
	
	public function getParent(){
		return $this->m_parent;
	}
	
	public function setParentName($p){
		$this->m_parentname = $p;
	}
	
	public function getParentName(){
		return $this->m_parentname;
	}
	
    public function getPid(){
    	return $this->m_pid;
    }
    
    public function setPid($pid){
    	$this->m_pid = $pid;
    }
	
	public function setDepend($depend){
		$this->m_depend = $depend;
	}
	public function getDepend(){
		return $this->m_depend;
	}
	
	public function setCaption($caption){
		$this->m_caption = $caption;
	}
	public function getCaption(){
		return $this->m_caption;
	}
	
	public function setMilestone($mile){
		$this->m_milestone = $mile;
	}

	public function setGroup($group){
		$this->m_group = $group;
	}
	
	public function getGroup(){
		return $this->m_group;
	}
		
	public function setOpen($open){
		$this->m_open = $open;
	}
	
	public function getOpen(){
		return $this->m_open;
	}	
	
	public function setPage($page){
		$this->m_page = $page;
	}
	
	public function getPage(){
		return $this->m_page;
	}
	
	public function setHyperlink($link){
		$this->m_hyperlink = $link;
	}
	
	public function getHyperlink(){
		return $this->m_hyperlink;
	}
	
	public function setPictureLink($link){
		$this->m_picturelink = $link;
	}
	
	public function getPictureLink(){
		return $this->m_picturelink;
	}
	
	public function setPictureURL($url){
		$this->m_pictureurl = $url;
	}
	
	public function getPictureURL(){
		return $this->m_pictureurl;
	}
	
	public function setStartDate($date){
		$this->m_start = $date;
	}
	
	public function getStartDate(){
		return $this->m_start;
	}
	
	public function setFinishDate($date){
		$this->m_finish = $date;
	}
	
	public function getFinishDate(){
		return $this->m_finish;
	}
	
	public function setPlannedStartDate($date){
		$this->m_plannedStart = $date;
	}
	
	public function getPlannedStartDate(){
		return $this->m_plannedStart;
	}
	
	public function setPlannedFinishDate($date){
		$this->m_plannedFinish = $date;
	}
	
	public function getPlannedFinishDate(){
		return $this->m_plannedFinish;
	}
	
	public function setEarlyStartDate($date){
		$this->m_earlyStart = $date;
	}
	
	public function setEarlyFinishDate($date){
		$this->m_earlyFinish = $date;
	}
	
	public function setLateStartDate($date){
		$this->m_lateStart = $date;
	}
	
	public function setLateFinishDate($date){
		$this->m_lateFinish = $date;
	}
	
	public function setActor($resource){
		$this->m_actor = $resource;
	}
	
	public function getActor(){
		return $this->m_actor;
	}
	
	public function addWBS($id, $value){
		$this->m_WBS[$id] = $value;
	}
	
	public function setWBS($wbs){
		$this->m_WBS = $wbs;
	}
	
	public function getWBS(){
		return $this->m_WBS;
	}
	
	public function setTimestamp($time){
		$this->m_timestamp = $time;
	}
	
	public function setOutlineLevel($level){
		$this->m_outlineLevel = $level;
	}
	
	public function getOutlineLevel(){
		return $this->m_outlineLevel;
	}
	
	public function addSuccessor($suc){
		$this->m_successors[] = $suc;
	}
	
	public function getSuccessors(){
		return $this->m_successors;
	}
	
	public function addPredecessor($pred){
		$this->m_predecessors[] = $pred;
	}
	
	public function getPredecessors(){
		return $this->m_predecessors;
	}
	
	public function isMilestone(){
		return $this->m_milestone;
	}
	
	public function getResource(){
		return $this->m_resource;
	}	
	
	public function setResource($resource){
		$this->m_resource = $resource;
	}
	public function getProgress(){
		return $this->m_progress;
	}	
	
	public function setProgress($progress){
		$this->m_progress = $progress;
	}
	
	/**
	 * This method returns the assignment XML
	 * @param id 
	 * @return string, AssignmentXML
	 * 
	 */
	public function getAssignmentXML($id){
		$res = '';
		$res = '';
		if (($this->m_plannedFinish!=null) && ($this->m_plannedStart!=null)){
			$res .="<Assignment>\r\n";
			$res .="<UID>" .$id. "</UID>\r\n";
			$res .="<TaskUID>".$this->m_uid ."</TaskUID>\r\n";
			$res .="<ResourceUID>". $this->m_actor->getUid() ."</ResourceUID>\r\n";
			if ($this->m_plannedStart!=null) {
				$res .= "<Start>" . $this->parsedate($this->m_plannedStart) . "</Start>\r\n";

			}
			if ($this->m_plannedFinish!=null)
			$res .= "<Finish>" . $this->parsedate($this->m_plannedFinish) . "</Finish>\r\n";
			$res .="</Assignment>\r\n";
			$id++;
		}
		return array($res,$id);
	}
	
	
	/**
	 * This method extracts a date string formatted for task from a SMWTimeValue object. 
	 *
	 * @param $dv		SMWTimeValue, date that is to be converted
	 * @return			string in form YYYY-MM-DDTHH:MM:SS
	 */
	public function parsedate(SMWTimeValue $dv, $isend=false) {
		$year = $dv->getYear();
		if ( ($year > 9999) || ($year<-9998) ) return ''; // ISO range is limited to four digits
		$year = number_format($year, 0, '.', '');
		$time = $dv->getTimeString(false);
		if ( ($time == false) && ($isend) ) { // increment by one day, compute date to cover leap years etc.
			$dv = SMWDataValueFactory::newTypeIDValue('_dat',$dv->getWikiValue() . 'T00:00:00+24:00');
		}
		$month = $dv->getMonth();
		if (strlen($month) == 1) $month = '0' . $month;
		$day = $dv->getDay();
		if (strlen($day) == 1) $day = '0' . $day;
		$result = $year .'-'. $month .'-'. $day;
		if ($time != false) $result .= "T$time";
		return $result;
	}
	
	/**
	 * This method extract a date string formatted for ganttchart from a SMWTimeValue object.
	 *
	 * @param $dv		SMWTimeValue, date that is to be converted
	 * @return			string in form MM/DD/YYYY HH:MM:SS
	 */
	public function getGanttDate(SMWTimeValue $dv, $isend=false) {
		$year = $dv->getYear();
		if ( ($year > 9999) || ($year<-9998) ) return ''; // ISO range is limited to four digits
		$year = number_format($year, 0, '.', '');
		$time = $dv->getTimeString(false);
		if ( ($time == false) && ($isend) ) { // increment by one day, compute date to cover leap years etc.
			$dv = SMWDataValueFactory::newTypeIDValue('_dat',$dv->getWikiValue() . 'T00:00:00+24:00');
		}
		$month = $dv->getMonth();
		if (strlen($month) == 1) $month = '0' . $month;
		$day = $dv->getDay();
		if (strlen($day) == 1) $day = '0' . $day;
		$result = $month .'/'. $day.'/'.$year;
		if ($time != false) $result .= " $time";
		return $result;
	}
	
	/**
	 * This method converts M01-M36 to time
	 *
	 * @param $mo		string, month (in m notation) that is to be converted
	 * @return			int (seconds since unix aera)
	 */
	public function monthToTime($mo){
		
		$p = $this->getProjectManagementClass();
	    $m0 = $p->getm0();
		
		$arr = explode("/",$m0);

		$m = (int) $arr[0];
		$d = (int) $arr[1];
		$y = (int) $arr[2];		
		
		$addYears = $y;
		$addMonths = (int) substr($mo,1);;
		$plusMonths  = (int) substr($mo,1);
				
		if ($plusMonths > 12){
			$addMonths = ((($plusMonths-1) % 12)+1);
			$addYears += floor((($plusMonths-1)/12));	
		}
		
		$addMonths += $m;
		$plusMonths = $addMonths;
		
		if ($plusMonths > 12){
			$addMonths = ((($plusMonths-1) % 12)+1);
			$addYears += floor((($plusMonths-1)/12));	
		}
		
		
		$result = date("U",mktime(0,0,0,$addMonths,$d,$addYears));		
		return $result;
		
	}
	
	/**
	 * This method converts M01-M36 to date
	 *
	 * @param $mo		string, month (in m notation) that is to be converted
	 * @return			string in form MM/DD/YYYY HH:MM:SS
	 */
	public function monthToGanttDate($mo){
		
		$p = $this->getProjectManagementClass();
		
	    $m0 = $p->getm0();
		
		$arr = explode("/",$m0);

		$m = (int) $arr[0];
		$d = (int) $arr[1];
		$y = (int) $arr[2];		
		
		$addYears = $y;
		$addMonths = (int) substr($mo,1);;
		$plusMonths  = (int) substr($mo,1);
				
		if ($plusMonths > 12){
			$addMonths = ((($plusMonths-1) % 12)+1);
			$addYears += floor((($plusMonths-1)/12));	
		}
		
		$addMonths += $m;
		$plusMonths = $addMonths;
		
		if ($plusMonths > 12){
			$addMonths = ((($plusMonths-1) % 12)+1);
			$addYears += floor((($plusMonths-1)/12));	
		}
		
		$result = date("m/d/Y H:i:s",mktime(0,0,0,$addMonths,$d,$addYears));
		
		return $result;
		
	}                                                                                
	
	/**
	 * This method returns a tasks Gantt representation
	 *
	 * @param $id		string, id of task that has to be converted
	 * @return			string, for JSGAntt
	 */	
	public function getGanttChart($id){
		
		$res = '';
		$this->setId($id);
		$predStr = '';

		$levelCheck = array();
			
		$label = $this->getLabel();
			
		
		if ($label != 'unlabeled'){
			
			//cut label if > 35 digits
			if (strlen($label) > 35) {
			 $label=substr($label,0,35);
			 $label .="...";
			}
			
			if ($this->getColor() == '') $color = 'ff00ff';
			else $color = $this->getColor();
			
			if ($this->getHyperlink() == '') $help = '';
			else $help = $this->getHyperlink();
			
			if ($this->getPictureLink() == '') $pictureLink = '';
			else $pictureLink = $this->getPictureLink();

			if ($this->getPictureURL() == '') $pictureURL = '';
			else $pictureURL = $this->getPictureURL();

	
			if ($this->isMilestone() == true) $milestone = 1;
			else $milestone = 0;
			
			if ($this->getResource() == null) $resource = '';
			else $resource = $this->getResource();
			
			if ($this->getGroup() == null) $group = 0;
			else $group = $this->getGroup();
			
			if ($this->getParent() == null) $parent = 0;
			else $parent = $this->getParent();
			
			if ($this->getOpen() == null) $open = 1;
			else $open = $this->getOpen();
	
			if ($this->getCaption() == null) $caption = "";
			else $caption = $this->getCaption();

			if ($this->getProgress() == null) $progress = "0";
			else $progress = $this->getProgress();
		    
			$startdate = $this->getGanttStartDate();
			$enddate = $this->getGanttEndDate();
			
		   //set dependence (red arrow from predecessor)
		   $depend = "";
		   $allt = $this->getPredecessors();
		  foreach ($allt as $t) {
		    $depend .= $t->getUid() . ",";
		   }
			if (strlen($depend)>0){
				$depend = substr($depend, 0, -1);
			}
			//set id
			$id = $this->getUid();
			
			$res .='g.AddTaskItem(new JSGantt.TaskItem('.$id. ',\'' .$label.'\', \''.$startdate. '\',\'' .$enddate.'\',\''.$color.'\', \''.$help.'\', '.$milestone.', \''.$resource.'\','.$progress.', '.$group.', '.$parent.', '.$open.', "'.$depend.'","","'.$pictureURL.'","'.$pictureLink.'"));';
			$res .="\r\n";
			
		}
		
		return array($res,$id);
	}
	
	/**
	 * This method returns a tasks XML representation
	 *
	 * @param $id		string, id of task that has to be converted
	 * @return			string, XML representation
	 */	
	public function getXML($id){

		$res = '';
		//if (($this->m_plannedFinish!=null) && ($this->m_plannedStart!=null)){
			$this->m_id = $id;
			$id++;
			$res .= "<Task>\r\n";
			$res .= "<UID>" . $this->getUid() . "</UID>\r\n";
			$res .= "<ID>" . $this->m_id . "</ID>\r\n";
			if ($this->getLabel()=='unlabeled'){
				$res .= "<Name>" . $this->m_page . "</Name>\r\n";
			}else{
				$res .= "<Name>" . $this->replaceLabelChars($this->getLabel()) . "</Name>\r\n";
			}
			$res .= "<Type>2</Type>\r\n";
			$res .= "<IsNull>0</IsNull>\r\n";
			if($this->m_timestamp!=null)
				$res .= "<CreateDate>" . date("Y-m-d", $this->m_timestamp) . "T" . date("H:i:s", $this->m_timestamp) . "</CreateDate>\r\n";
			$res .= "<WBS>" . $this->WBStoSTring($this->m_WBS) . "</WBS>\r\n";
			$res .= "<OutlineNumber>" . $this->WBStoSTring($this->m_WBS)  . "</OutlineNumber>\r\n";
			$res .= "<OutlineLevel>" . $this->m_outlineLevel . "</OutlineLevel>\r\n";
			$res .= "<CalendarUID>3</CalendarUID>\r\n";
			if ($this->m_plannedStart!=null) {
				$res .= "<Start>" . $this->parsedate($this->m_plannedStart) . "</Start>\r\n";
				$res .= "<ConstraintType>2</ConstraintType>\r\n";
				$res .= "<ConstraintDate>" . $this->parsedate($this->m_plannedStart) . "</ConstraintDate>\r\n";
			}
			if ($this->m_plannedFinish!=null)
				$res .= "<Finish>" . $this->parsedate($this->m_plannedFinish) . "</Finish>\r\n";
			if ($this->m_earlyStart!=null)
				$res .= "<EarlyStart>" . $this->parsedate($this->m_earlyStart) . "</EarlyStart>\r\n";
			if ($this->m_earlyFinish!=null)
				$res .= "<EarlyFinish>" . $this->parsedate($this->m_earlyFinish) . "</EarlyFinish>\r\n";
			if ($this->m_lateStart!=null)
				$res .= "<LateStart>" . $this->parsedate($this->m_lateStart) . "</LateStart>\r\n";
			if ($this->m_lateFinish!=null)
				$res .= "<LateFinish>" . $this->parsedate($this->m_lateFinish) . "</LateFinish>\r\n";
			$res .= "<Hyperlink>".$this->replaceLabelChars($this->getLabel())."</Hyperlink>\r\n";
			$res .= "<HyperlinkAddress>". $this->m_hyperlink ."</HyperlinkAddress>\r\n";
			foreach ($this->m_predecessors as $pred){
				$res .= "<PredecessorLink>\r\n";
				$res .= "<PredecessorUID>". $pred->getUid() ."</PredecessorUID>\r\n";
				$res .= "<Type>1</Type>\r\n";
				$res .= "<CrossProject>0</CrossProject>\r\n";
				$res .= "<LinkLag>0</LinkLag>\r\n";
				$res .= "<LagFormat>7</LagFormat>\r\n";
				$res .= "</PredecessorLink>\r\n";
			}
			$res .= "<FixedCostAccrual>3</FixedCostAccrual>\r\n";
			$res .= "</Task>\r\n";
		//}
		return array($res,$id);
	}
	
	/**
	 * This method returns a string represenation of the work breakdown structure
	 *
	 * @param $wbs		array, work breakdown structure
	 * @return			string, string representation of wbs
	 */	
	public function WBStoString($wbs){
		$res = '';
		for ($i=1; $i<count($wbs);$i++){

			$res .= $wbs[$i] .'.';
		}
		$res = substr($res, 0, -1);
		return $res;
	}
}

class ProjectManagementResource extends ProjectManagementElement{

	/**
	 * This method returns an XML represenation of the Element
	 *
	 * @return			string, XML representation of Element
	 */	
	public function getXML(){

		$res = '';
		$res .= "<Resource>\r\n";
		$res .= "<UID>" . $this->getUid() . "</UID>\r\n";
		$res .= "<ID>" . $this->getId() . "</ID>\r\n";
		if ($this->m_label=='unlabeled'){
			$res .= "<Name>" . $this->m_page . "</Name>\r\n";
		}else{
			$res .= "<Name>" . $this->replaceLabelChars($this->m_label) . "</Name>\r\n";
		}
		$res .= "<Type>1</Type>\r\n";
		$res .= "<IsNull>0</IsNull>\r\n";
		$res .= "</Resource>\r\n";
		return $res;
	}

}
