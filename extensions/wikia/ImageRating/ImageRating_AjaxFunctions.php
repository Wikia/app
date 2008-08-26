<?php

$wgAjaxExportList [] = 'wfAddImageCategory';
function wfAddImageCategory($page_id, $categories){ 
	$categories = urldecode($categories);
	
	$dbr =& wfGetDB( DB_MASTER );
	
	//construct page title object
	$image_page = Title::newFromID($page_id);
	$article = new Article($image_page);
	
	//check if its been edited in last 2 seconds: want to delay the edit
	$time_since_edited =  wfTimestamp( TS_MW, 0 ) - $article->getTimestamp();
	if($time_since_edited <= 2){
		return "busy";
	}
	
	//get current page text
	$page_text = $article->getContent();
		
	//append new categories
	$categories_array = explode(",",$categories);
	$category_text = "";
	foreach($categories_array as $category){
		$category = trim($category);
		$tag = "[[Category:{$category} Images]]";
		if( strpos($page_text, $tag) === false ){
			$category_text .= "\n{$tag}";
		}
	}
	$new_text = $page_text . $category_text;
	
	//make page edit
	
	$article->doEdit( $new_text, "add category" );
	
	return "ok";
				
}

?>