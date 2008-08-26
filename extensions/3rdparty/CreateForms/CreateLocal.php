<?php

class CreateLocal extends CreateForm {
	
	function displayFormExtra(){
		$output  = "";
		$output .= '<table cellpadding="0" cellspacing="0" border="0" style="margin-bottom:10px;">';
		$output .= '<tr>';
		$output .= '<td>';
		$output .= '<span class="title">select state</span><br>';
		
		#populate drop down
		$output .= '<select id=state name=state onchange=getCities(this.value)><option value=""></option>';
		
		$dbr =& wfGetDB( DB_SLAVE );
		$res = $dbr->query("SELECT distinct(state) as state from cities_us order by state");
		while ($row = $dbr->fetchObject( $res ) ) {
		  $output .= '<option value="' . $row->state . '">' . $row->state . "</option>";
		}
		
		$output .= '</select>';
		
		$output .= '</td>';
		$output .= '</tr>';
		$output .= '<tr>';
		$output .= '<td style="padding-top:5px;">';
		$output .= '<span id="cities-label" class="title" style="display:none">select city</span><br>';
		$output .= '<div id="cities"></div>';
		$output .= '</td>';
		$output .= '</tr>';
		$output .= '<tr>';
		$output .= '<td style="padding-top:5px;">';
		$output .= '<input type="checkbox" value="1" id="national">click this box if your story is of national significance';
		$output .= '</td>';
		$output .= '</tr>';
		$output .= '</table>';
		
		return $output;
	}
	
	function displayForm(){
		global $wgOut;
		$wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/CreateForms/CreateLocal.js?2\"></script>\n");
		$output = $this->displayFormStart();
		
		$output .= $this->displayFormPageTitle();
		if($this->wysiwyg == "ON"){
			$output .= $this->displayFormPageTextWYSIWYG();
			$output .= $this->displayImageUpload();
		}else{
			$output .= $this->displayFormPageText();
		}
		$output .= $this->displayFormPageSource();
		$output .= $this->displayFormExtra();
		$output .= $this->displayFormPageCategories();
		$output .= $this->displayFormCommon();
		$output .= $this->displayFormEnd();
		return $output;
	}
}

class CreateLocalEntity extends CreateForm {
	
	function displayFormExtra(){
		$output  = "";
		$output .= '<table cellpadding="0" cellspacing="0" border="0"><tr><td><span class="title">select state</span><br>';
					$output .= '<select id=state name=state onchange=getCities(this.value)><option value=""></option>';
					$dbr =& wfGetDB( DB_SLAVE );
					$res = $dbr->query("SELECT distinct(state) as state from cities_us order by state");
					while ($row = $dbr->fetchObject( $res ) ) {
						$output .= '<option value="' . $row->state . '">' . $row->state . "</option>";
					}
					$output .= '</select></td><td width="5"></td><td><span id="cities-label" class="title" style="display:none">select city<br></span><div id="cities"></div></td><td width="5"></td></tr></table><br>';
		return $output;
	}
	
	function displayForm(){
		global $wgOut;
		$wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/CreateForms/CreateLocal.js\"></script>\n");
		$output = $this->displayFormStart();
		
		$output .= $this->displayFormPageTitle();
		if($this->wysiwyg == "ON"){
			$output .= $this->displayFormPageTextWYSIWYG();
			$output .= $this->displayImageUpload();
		}else{
			$output .= $this->displayFormPageText();
		}
		$output .= $this->displayFormExtra();
		$output .= $this->displayFormPageCategories();
		$output .= $this->displayFormCommon();
		$output .= $this->displayFormEnd();
		return $output;
	}
}
?>