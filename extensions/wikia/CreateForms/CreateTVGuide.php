<?php

class CreateTVGuide extends CreateForm {
	
	
	
	function displayForm(){
		global $wgOut, $wgStyleVersion;
		$wgOut->addScript("<script type=\"text/javascript\" src=\"/extensions/CreateForms/CreateTVGuide.js?{$wgStyleVersion}\"></script>\n");
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

?>