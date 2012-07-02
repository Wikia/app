<?php
/*******************************************************************************
 *
 *	Copyright (c) 2010 Jonas Bissinger
 *
 *   Semantic Project Management is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
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
 * @author Jonas Bissinger
 *
 * @ingroup SemanticProjectManagement
 *
 */

class SemanticProjectManagement extends SpecialPage
{
	

	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct( 'SemanticProjectManagement' );
	}
	//main class
	function execute( $par ){
		
        global $wgRequest,$wgOut,$wgUser;

        $page = 0;
        $this->setHeaders();
		
        //check if user is allowed to access special page
        if ( ! $wgUser->isAllowed('SPMsetup') ) {
			$wgOut->permissionRequired('SPMsetup');
			return;
		}
        
        if ($wgRequest->getCheck('page2')) {
        	$page = 2;

        	$levels = $wgRequest->getVal('level');
        	if ($levels == "") $levels = 1;
        	$text = self::getPage1Text($levels);
        }		
        
        if ($wgRequest->getCheck('page3')) {
        	$page = 3;
        	$levels = $wgRequest->getVal('level');
        	if ($wgRequest->getVal('allSame')=="on") $allSame = 1;
        	else $allSame = 0;
        	$text = self::getPage2Text($levels,$allSame);

        }		
        
	    if ($wgRequest->getCheck('calendar')) {
        	$page = 4;
        	$date = $wgRequest->getVal('startmonth');
        	$text = self::getCalendarText($date);

        }       
        
        
        if (($page == 0)||($wgRequest->getCheck('page1')||($wgRequest->getCheck('page1refresh')) ||($wgRequest->getCheck('calendarRefresh')))) {
        	$page = 1;
			$text = self::getPage0Text();
		}

		 $wgOut->addHTML($text);
        
	}
	
	
	function writeSetupData($level,$m0,$allSame,$cat,$props,$colors){
		
		//structure: levels{**}M0{**}$allSame{**}cat[0]{**}color[0]{**}property[0]{**}cat[1]...
		
		$newtext = "This page is used to store the settings of the Semantic Project Management Extension.<br/><br/>Do not delete or edit this page. To change the settings, please go to: [[Special:SemanticProjectManagement]].<!--";
		$newtext .= $level."{**}".$m0."{**}".$allSame."{**}";
		
		for ($i = 0; $i<$level; $i++){
			 $newtext .= $cat[$i]."{**}".$colors[$i]."{**}".$props[$i]."{**}"; 
		}
			
		$newtext .= "-->";
		
		$title = Title::newFromText("SPM_Setup");
		$article  = new Article($title);
		$article->doEdit($newtext, "settings change", EDIT_UPDATE);		
		
	}
	
	function getSetupData(){
		
		//get values from SPM_setup
		$title  = Title::newFromText("SPM_Setup");
		$article  = new Article($title);
		$wikitext = $article->getContent();
		
		$pos1 = strpos($wikitext,"<!--");		
		$pos2 = strpos($wikitext,"-->");
		$data = substr($wikitext,$pos1+4,$pos2-$pos1-4);
		
		$textarr = explode("{**}",$data);
		$levels = (int) $textarr[0];

		
		//check if data on SPM_setup is valid 
		//todo: better check!
		//echo "SIZE: ".(sizeof($textarr))."<br/>";
		if ((3*$levels) != (sizeof($textarr)-4)) return false; 
		return $textarr;
		 
	}
	
	//checks if all values in an array are different
	function checkAllDifferent($arr){
		
		$check = array();
		for ($i = 0;$i<sizeof($arr);$i++){
			if (isset($check[$arr[$i]])) return false;
			else $check[$arr[$i]] = 1;
		}
		return true;
	}
	
	//checks if all values in an array are identical
	function checkAllSame($arr){
		for ($i = 1;$i<sizeof($arr);$i++){
			if ($arr[0] != $arr[$i]) return false;
		}
		return true;
	}
	
	
	function getPage0Text(){
		
		global $wgRequest;
		
		$startmonth = "";
		$setting = "";
		
		if ($wgRequest->getCheck('calendarRefresh')){
			$startmonth = $wgRequest->getVal('testinput');
		}
		
		//page is reached after changes have been made
		if ($wgRequest->getCheck('page1refresh')){
			
			$arr = self::getSetupData();
			$m0 = $arr[1];
			$allSame = $arr[2];
			
			//echo "loaded m0: ".$m0;
			
			$l = $wgRequest->getVal('level');
			
			$cat = array();
			$col = array();
			$prop = array();
			
			for ($i = 1; $i<=$l; $i++){
			 
			 $cat[$i-1] = $wgRequest->getVal('category'.$i);
			 $col[$i-1] = $wgRequest->getVal('color'.$i);
			 $prop[$i-1] = $wgRequest->getVal('property'.$i);			 
			}
			
			$allSame = $wgRequest->getVal('allSame');
			
			$valid = true;
			$error = "";
			
			if ($allSame == 1) {
				$valid = (self::checkAllSame($cat))&&(self::checkAllSame(array_slice($prop,1)));
				$error = "<br/> <b> <font color=\"#FF0000\"> Invalid setting! </font> </b> All categories/properties have to be identical <br/> <br/>"; 
			}
			if ($allSame == 0){
				$valid = self::checkAllDifferent($cat);
				$error = "<br/> <b> <font color=\"#FF0000\"> Invalid setting! </font> </b> All categories have to be different! <br/> <br/>";
			}
			
			if ($valid) self::writeSetupData($l,$m0,$allSame,$cat,$prop,$col);
			else $setting .= $error;
			
		}
		
		//page is reached after m0 has been changed
		if ($wgRequest->getCheck('calendarRefresh')){
			$startmonth = $wgRequest->getVal('testinput');
			
			$arr = self::getSetupData();
			
			$arr[1] = $startmonth;
			$result = implode("{**}",$arr);
			
			$newtext = "This page is used to store the settings of the Semantic Project Management Extension.<br/><br/>Do not delete or edit this page. To change the settings, please go to: [[Special:SemanticProjectManagement]].<!--";
			$newtext .= $result;
			$newtext .= "-->";
			
			
			//save SPM_Setup with new m0			
			$title = Title::newFromText("SPM_Setup");
			$article  = new Article($title);
			
			$article->doEdit($newtext , "startmonth change");			
		}
		
		
		//check if data is valid
		if (self::getSetupData() == false) {
			
			//fill SPM_Setup with default values			
			$title = Title::newFromText("SPM_Setup");
			$article  = new Article($title);
			$defaultText = "This page is used to store the settings of the Semantic Project Management Extension.<br/><br/>Do not delete or edit this page. To change the settings, please go to: [[Special:SemanticProjectManagement]].<!--3{**}06/01/2009{**}false{**}Work Package{**}FF0000{**}{**}Task{**}FFEE05{**}Part of{**}Deliverable{**}09FF00{**}Part of{**}-->";
			$article->doEdit($defaultText , "default restored");			
			
			//create error message
			$setting .= " <br/> <b> <font color=\"#FF0000\"> Invalid setting! </font> </b> <br/>  Default setting restored! <br/><br/>";
		}
		
		
		//data is valid
		$textarr = self::getSetupData();
		$levels = $textarr[0];
		$m0 = $textarr[1];
		$allSame = $textarr[2];
		$setting .= " <b> Current Setting: </b> <br/> <br/> <table border = \"0\" cellpadding=\"3\" cellspacing=\"5\"><tr bgcolor = \"#A3D5E4\"><th>Level</th><th>Category</th><th>Color</th><th>Property</th><tr>";
		for ($i = 0; $i < $levels; $i++){
			$triple = array_splice($textarr,3,3);
						
			if ($triple[2] == "") $triple[2] = "-";
			$setting .= "<tr> <td align=\"center\">".($i+1)."</td> <td>".$triple[0]."</td> <td width=\"100\" bgcolor=\"#".$triple[1]."\" height=\"21\"></td> <td td align=\"center\">".$triple[2]." </td></tr>";
			
		}
		
		$setting .= "</table>";
		
		
		$text =<<<END
<html>
<head>

</head>
<body>

 $setting
 <br/>
 <br/>
 <b> Project Start Month (M0): $m0 </b>
 <br/>
 <br/>
 <form enctype="multipart/form-data" action="" method="post" name="page0"> 
<input type="hidden" name="level" value="$levels">
<input type="hidden" name="startmonth" value="$m0">
 <p><input type="Submit" name="page2" value="Change Setting"><input type="Submit" name="calendar" value="Change Startmonth"></p>
 
 </form>
</body>
END;
		
		return $text;
	}
	
	
	function getCalendarText($date){
		
		global $spmgScriptPath;
		
		$text =<<<END

<html>
<head>
	<link rel="stylesheet" type="text/css" href="$spmgScriptPath/libs/calendar/calendar.css" />
	<script language="javascript" src="$spmgScriptPath/libs/calendar/calendar_us.js"></script>

</head>
<body>

Please enter Project Startmonth (M0):

<form name="testform" enctype="multipart/form-data" action="" method="post">
	
	<input type="text" name="testinput" value="$date" />
	<script language="javascript">
	var A_CALTPL = {
	'months' : ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
	'weekdays' : ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
	'yearscroll': true, // show year scroller
	'weekstart': 0, // first day of week: 0-Su or 1-Mo
	'centyear'  : 70, // 2 digit years less than 'centyear' are in 20xx, othewise in 19xx.
		'imgpath' : '$spmgScriptPath/libs/calendar/img/'
	}
	new tcal ({
		'formname': 'testform',
		'controlname': 'testinput'},
		
	A_CALTPL);
	</script>


<p><input type="Submit" name="calendarRefresh" value="Save"><input type="Submit" name="page0" value="Cancel"></p>
</form>


</body>
</html>
END;

		return $text;
		
	}
	
	
	function getPage1Text($levels){
		
		$checkbox = "";
 
		//$checkbox = "<p><input type=\"checkbox\" name=\"allSame\"> All Levels have same Category/Property </p>";
		//uncomment last line to enable allSame checkbox		
		
		$s = array("","","","","","","","","","");
		$s[$levels] = "selected";
		
		$text =<<<END
				
<form enctype="multipart/form-data" action="" method="post"> 
<p>Please select number of levels: 
<select name="level">
	<option value="1" $s[1]>1</option>
	<option value="2" $s[2]>2</option>
	<option value="3" $s[3]>3</option>
	<option value="4" $s[4]>4</option>
	<option value="5" $s[5]>5</option>
	<option value="6" $s[6]>6</option>
	<option value="7" $s[7]>7</option>
	<option value="8" $s[8]>8</option>
	<option value="9" $s[9]>9</option>
 </select>
$checkbox
<p><input type="Submit" name="page3" value="Continue"><input type="Submit" name="page0" value="Cancel"></p>
</form>				

END;

		return $text;		
	}
	
	function getPage2Text($levels,$allSame){
		
		global $spmgScriptPath;

		//echo " allSame:".$allSame."<br/>";
		
		if (self::getSetupData() != false) $textarr = self::getSetupData();
		else return "<br/> Internal error: Please reload Special:SemanticProjectManagement <br/>";
		
		
		$l = $textarr[0];
		$text =<<<END

<html>
<head>
<script type="text/javascript" src="$spmgScriptPath/libs/jscolor/jscolor.js"></script>
</head>
<body>
<form enctype="multipart/form-data" action="" method="post" name="page2"> 
<table>
<tr>
END;
		
	  	
		for ( $i = 0; $i < $levels; $i += 1) {
			
			$triple = array_splice($textarr,3,3);
			
			if ($i < $l) $text .= self::generateLevelBox($i+1, $triple[0], $triple[2], $triple[1]);
			else $text .= self::generateLevelBox($i+1, "", "", "", "ffffff", 0);
			
			if (($i+1)%4 == 0) {
					$text.= "</tr> <tr>";
			}
		}
		
		$text .=<<<END
</tr>
</table>
<input type="hidden" name="allSame" value="$allSame">
<input type="hidden" name="level" value="$levels">
<p><input type="Submit" name="page1refresh" value="Save"><input type="Submit" name="page0" value="Cancel"></p>
</form>
</body>
</html>
END;
	
	return $text;
	}
	
	function generateLevelBox($index, $category, $property, $color){
	
		$low = $index-1;
		$propbox = "";
		if ($low != 0) $propbox ="<p> Connecting Property to Level $low: <input style=\"width: 100%;\" type=\"text\" name=\"property$index\" value=\"$property\"/></p>";
		
		$text =<<<END
<td>
<fieldset style="width: 220px;">
<legend>
Level $index
</legend>
<p> Category: <input style="width: 100%;" type="text" name="category$index" value="$category"/> </p>

<p> Color: <input style="width: 100%;" class="color" name="color$index" value="$color"/></p>

$propbox
</fieldset>
<td>

END;

		return $text;

	} 
	
}
