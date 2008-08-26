<?php

$wgExtensionFunctions[] = 'registerCreateForm';

function registerCreateForm(){
    global $wgParser ,$wgOut;
    //$wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/CreateForms/CreatePage.js\"></script>\n");
    $wgParser->setHook('createform', 'renderCreateForm');
}

function renderCreateForm($input){
	global $wgUser, $wgSiteView, $wgOut;
	
	getValue($category,$input,"category");
	getValue($item,$input,"item");
	getValue($fromview,$input,"fromview");
	getValue($title_label,$input,"title label");
	getValue($text_label,$input,"text label");
	getValue($category_label,$input,"categories label");
	getValue($category_help_text,$input,"categories help label");
	getValue($wysiwyg,$input,"wysiwyg");
	$labels = array( "title" => $title_label, "text" => $text_label, "categories" => $category_label, "categories_help" => $category_help_text);
	$options = array( "wysiwyg" => strtoupper($wysiwyg) );
	
	
	$wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/CreateForms/CreatePage.js?5\"></script>\n");
	if(strtoupper($wysiwyg) == "ON"){
		$wgOut->addScript("<link rel=\"stylesheet\" type=\"text/css\" href=\"extensions/Wikiwyg/css/wikiwyg.css\" />\n");
		$wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/Wikiwyg/lib/Wikiwyg.js\"></script>\n");
		$wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/Wikiwyg/lib/Wikiwyg/Toolbar.js\"></script>\n");
		$wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/Wikiwyg/lib/Wikiwyg/Wysiwyg.js\"></script>\n");
		$wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/Wikiwyg/lib/Wikiwyg/Wikitext.js\"></script>\n");
		$wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/CreateForms/Wikiwyg_CreateForm.js?5\"></script>\n");
		$wgOut->setOnloadHandler( "initWikywyg()" );
	}
	
	switch (strtoupper($item)) {
		case "LOCAL":
			require_once ('CreateLocal.php');
			$form = new CreateLocal($category,$fromview,$labels,$options);
			break;
		case "LOCALENTITY":
			require_once ('CreateLocal.php');
			$form = new CreateLocalEntity($category,$fromview,$labels,$options);
			break;
					 
	}
	
	if(!$form){
		switch (strtoupper($category)) {
			case "LAW PROPOSALS":
				require_once ('CreatePolitics.php');
				$form = new CreateLawProposal($category,$fromview,$labels,$options);
				break;
			default:
				$form = new CreateForm($category,$fromview,$labels,$options);
		}
	}
	$output = "";
	$output .= '<br/>' . $form->displayForm();
	return $output;
}

class CreateForm {
	var $form_start, $form_common, $form_body, $form_end;
	var $tab_counter = 1;
	var $title_label = "title";
	var $text_label = "text";
	var $categories_label = "categories";
	var $categories_help_text = 'Categories help organize information on the site. To add multiple categories seperate them by commas.  When identifying what professional leagues, it helps to use the abbreviation of that league (i.e. MLB, NFL, NBA, NHL, College Basketball, College Football. Write the team\'s or college\'s full name: Boston Celtics not Celtics, Duke University not Duke.';
	var $wysiwyg = "";
	function CreateForm($ctg,$fromview, $label,$options){
		$this->category = $ctg;
		$this->from_view = $fromview;
		if($label["title"])$this->title_label = $label["title"];
		if($label["text"])$this->text_label = $label["text"];
		if($label["categories"])$this->categories_label = $label["categories"];
		if($label["categories_help"])$this->categories_help_text = $label["categories_help"];
		if($options["wysiwyg"])$this->wysiwyg = $options["wysiwyg"];
	}
	
	function displayFormStart(){
		return '<form id="editform" name="editform" method="post"  action="index.php?action=submit" enctype="multipart/form-data">';
	}
	function displayFormEnd(){
		return "</form>";
	}
	
	function displayFormPageTitle(){
		$output =   '<span class="title">' . $this->title_label . '</span><br><input class="createbox" type=text tabindex="'.$this->tab_counter.'" name="title2" id="title" style="width:500px;"><br><br>';
		$this->tab_counter++;
		return $output;
	}
	
	function displayFormPageText(){
		$output =   '<span class="title">' . $this->text_label . '</span><br><textarea class="createbox" tabindex="'.$this->tab_counter.'" accesskey="," name="pageBody" id="pageBody" rows="10" cols="80"></textarea><br><br>';
		$this->tab_counter++;
		return $output;		
	}
	
	function displayFormPageTextWYSIWYG(){
		$output =   '<span class="title">' . $this->text_label . '</span><br>
					<input type="hidden" id="pageBody"/><div id="wikiwyg"></div><iframe id="iframe1" tabindex="'.$this->tab_counter.'" height="0" width="0" frameborder="0"></iframe><br>';
		$this->tab_counter++;
		return $output;		
	}
	
	function displayImageUpload(){
		global $wgUser;
		if($wgUser->isLoggedIn()){
			$output = "<span class=\"title\">upload images</span><br><iframe id=\"uploading\" frameborder=\"0\" src=\"index.php?title=Special:IFrameUpload\">This feature requires iframe support.</iframe>";		
		}else{
			$output = '<a href="javascript:Login()">Log in to have image upload capability</a><br/><br/>';
		}
		return $output;
	}
	
	function displayFormPageCategories(){
		global $IP;
		require_once("$IP/extensions/TagCloud/TagCloudClass.php");
		$cloud = new TagCloud(20);
		
		$tagcloud = " <div id=\"create-tagcloud\" style=\"line-height: 25pt;width:600px;padding-bottom:15px;\">";
		$tagnumber = 0;
		foreach ($cloud->tags as $tag => $att) {
			$tag = str_replace("Opinions","",$tag);
			$tag = str_replace("News","",$tag);
			$tag = str_replace("Gossip","",$tag);
			$tag = str_replace("Articles","",$tag);
			$tag = str_replace("Stories","",$tag);
			$tag = trim($tag);
			$tagcloud .= " <span id=\"tag-{$tagnumber}\" style=\"font-size:{$cloud->tags[$tag]["size"]}{$cloud->tags_size_type}\"><a style='cursor:hand;cursor:pointer;text-decoration:underline' onclick=\"javascript:insertTag('" . str_replace("'","\'",$tag) . "',{$tagnumber});\" >{$tag}</a></span>";
			$tagnumber++;
		}
		$tagcloud .= "</div>";
		
		$output = '<div class="title">' . $this->categories_label . '</div>';
		$output .= '<div class="categorytext">' . $this->categories_help_text . '</div>';
		$output .= $tagcloud;		
		$output .= '<textarea class="createbox" tabindex="'.$this->tab_counter.'" accesskey="," name="pageCtg" id="pageCtg" rows="2" cols="80"></textarea><br><br>';
		$this->tab_counter++;
		return $output;
	}
	
	function displayFormCommon(){
		global $wgUser, $wgSiteView;
		$output =  '<input id="wpSave" tabindex="'.$tabCounter1.'" type=button onclick=createPage2() value="Create!" name="wpSave" class="createsubmit" accesskey="s" title="Save your changes [alt-s]"/ >
				<input type="hidden" value="" name="wpSection" />
				<input type="hidden" value="" name="wpEdittime" />
				<input type="hidden" value="" name="wpTextbox1" id="wpTextbox1" />
				<input type="hidden" value="'. $this->category . '" name="pageType" id="pageType" />
				<input type="hidden" value="'. $this->item . '" name="item" id="item" />
				<input type="hidden" value="' . htmlspecialchars( $wgUser->editToken() ) . '" name="wpEditToken" />
				<input type="hidden" value="' .  date("D m/d/y, g:i a T") . '" name="curdate" />
				<input type="hidden" value="' .  date("m/d/y") . '" name="curdate2" />
				<input type="hidden" value="' .  $wgUser->mName . '" name="usr" />';
		if(strtoupper($this->from_view) == "YES"){
			$output .= '<input type="hidden" value="' .  $wgSiteView->getDomainName() . '" name="viewname" />';
			$output .= '<input type="hidden" value="' .  $wgSiteView->getCategories() . '" name="viewctg" />';
		}
		return $output;
	}
	
	function displayFormPageSource(){
		$output = "";
		if(strtoupper($this->category) == "NEWS"){
				$output .= '<span style="font-size:12pt;color:#78BF5F;font-weight:bold;">source</span> <a href="javascript:toggle(\'sourceinfo\',\'toggle1\')" style="font-size:8pt; text-decoration:none;"><span id="toggle1">(help?)</span></a><br>';
				$output .= '<div id=sourceinfo style="display:none;">';
				$output .= '<table width=500 cellpadding=0 cellspacing=0 border=0>';
				$output .= '<tr>';
				$output .= '<td style="padding-bottom:10px; padding-top:10px; font-size:8pt;">';
				$output .= 'Every news story needs a source to ensure its accuracy.  To help make sure the community reports accurate stories, please provide a source below. If you want to add multiple sources, seperate each link with a comma.';
				$output .= '</td>';
				$output .= '</tr>';
				$output .= '</table>';												
				$output .= '</div>';
				$output .= '<input class="createbox" tabindex="'.$this->tab_counter.'" accesskey="," name="pageSources" rows="2" cols="80" value="http://" style="width:500px;"><br><br>';
				$this->tab_counter++;
		}
		return $output;
	}
	
	function displayForm(){
		$output = $this->displayFormStart();
		$output .= $this->displayFormPageTitle();
		if($this->wysiwyg == "ON"){
			$output .= $this->displayFormPageTextWYSIWYG();
			$output .= $this->displayImageUpload();
		}else{
			$output .= $this->displayFormPageText();
		}
		
		$output .= $this->displayFormPageSource();
		$output .= $this->displayFormPageCategories();
		$output .= $this->displayFormExtra();
		$output .= $this->displayFormCommon();
		$output .= $this->displayFormEnd();
		return $output;
	}
	
	function displayFormExtra(){ return ""; }
}
?>
