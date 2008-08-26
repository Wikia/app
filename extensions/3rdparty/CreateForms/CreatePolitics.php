<?php

class CreateLawProposal extends CreateForm {
	
	function displayFormExtra(){
		$output  = "";
		$output .= '<span class="title">justification</span><br><textarea tabindex="'.$this->tab_counter.'" accesskey="," name="justification" id="justification" class="createbox" rows="10" cols="80"></textarea><br><br>';
		$this->tab_counter++;
		return $output;
	}
	
	function displayForm(){
		global $wgOut;
		$wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/CreateForms/CreatePolitics.js\"></script>\n");
		$output = $this->displayFormStart();
		
		$output .= $this->displayFormPageTitle();
		$output .= $this->displayFormPageText();
		$output .= $this->displayFormExtra();
		$output .= $this->displayFormPageCategories();
		$output .= $this->displayFormCommon();
		$output .= $this->displayFormEnd();
		return $output;
	}
}

?>