<?php

$wgAjaxExportList [] = 'wfGetArticleJSON';
function wfGetArticleJSON($article_title,$callback,$strip_tags=0,$limit=0){
	global $IP, $wgOut, $wgArticlePath, $wgServer, $wgTitle;

	//$wgArticlePath = $wgServer . $wgArticlePath;

	//I'm using an include taken from PEAR SERVICES_JSON
	//Change your instance here
	//require_once( "$IP/extensions/wikia/JSON/JSON.php" );
	
	//construct mediawiki objects based on page title supplied
	$wgTitle = Title::newFromText($article_title);
	$article = new Article($wgTitle);
	
	if (!$article->exists()) {
		$wgTitle = SearchEngine::getNearMatch($article_title);
		if(!$wgTitle && strpos($article_title, "Mini:")===0) $wgTitle = SearchEngine::getNearMatch(substr($article_title,5));
	}
	
	if($wgTitle) {
		$title = $wgTitle;
		$article = new Article($wgTitle);
		
		
		$does_exist = $article->exists();
		$is_redirect = $article->isRedirect();
		
		$redirect_count = 1;
		$redirect_max = 5;
		
		if($does_exist && $is_redirect) {
			while(($redirect_count < $redirect_max) && $is_redirect) {
				$article_content = $article->getContent();
				$link_regex = "/\[\[([^\]]+)\]\]/i";
				preg_match($link_regex, $article_content, $matches);
				
				$new_title = $matches[1];
				$redirect_count++;
				
				$page_title = Title::makeTitleSafe( NS_MAIN, $new_title );
				$article = new Article($page_title);
				$does_exist = $article->exists();
				$is_redirect = $article->isRedirect();
			}
		}
	}
	else $does_exist = false;
	
	
	/*
	if(!$does_exist ){
		$title = SearchEngine::getNearMatch($title);
		
		if($title) {
			$article = new Article($title);
			
			
			$does_exist = $article->exists();
			$is_redirect = $article->isRedirect();
			
			$redirect_count = 1;
			$redirect_max = 5;
			
			if($does_exist && $is_redirect) {
				while(($redirect_count < $redirect_max) && $is_redirect) {
					$article_content = $article->getContent();
					$link_regex = "/\[\[([^\]]+)\]\]/i";
					preg_match($link_regex, $article_content, $matches);
					
					$new_title = $matches[1];
					$redirect_count++;
					
					$page_title = Title::makeTitleSafe( NS_MAIN, $new_title );
					$article = new Article($page_title);
					$does_exist = $article->exists();
					$is_redirect = $article->isRedirect();
				}
			}
		}
	}
	*/
	
	if(!$does_exist ){
		return $callback."({});";
	}
	
	$article_content = $article->getContent();
	$article_html = $wgOut->parse( $article_content, false );
	
	$article_a = array();
	$article_a["url"] = $title->getFullURL();
	$article_a["editurl"] = $wgServer . $title->getEditURL();
	$article_a["title"] = $title->getText();
	$article_a["last_edited"] = $article->getTimestamp();
	
	$article_html = str_replace("href=\"/", "href=\"" . $wgServer . "/", $article_html);
	$article_html = str_replace("href=\"#", "href=\"" . $title->getFullURL() . "#", $article_html);
	
	if ($strip_tags) $article_html = strip_tags($article_html);
	if ($limit) $article_html = substr($article_html, 0, $limit);
	
	if ($strip_tags && $limit) {
		$last_char = substr($article_html, -1);
		while ($last_char != " " && strlen($article_html) > 0) {
			$article_html = substr($article_html, 0, -1);
			$last_char = substr($article_html, -1);
		}
		
		if ($last_char == " ") $article_html = substr($article_html, 0, -1);
		$article_html .= "...";
	}
	
	$article_a["html"] = $article_html;
	
	//Change JSON encode here
	//$json = new Services_JSON();
	return  $callback . "(" . jsonify( $article_a ) . ")";;
}

$wgAjaxExportList [] = 'wfGetEditJSON';
function wfGetEditJSON($article_title){
	global $wgUser, $IP, $wgOut, $wgArticlePath, $wgServer;

	$wgArticlePath = $wgServer . $wgArticlePath;

	//I'm using an include taken from PEAR SERVICES_JSON
	//Change your instance here
	require_once( "$IP/extensions/wikia/JSON/JSON.php" );
	
	//construct mediawiki objects based on page title supplied
	$title = Title::newFromText($article_title);
	$article = new Article($title);
	
	if(! $article->exists() ){
		return "error";
	}
	
	$article_content = $article->getContent();
	if( $wgUser->isAnon() ) {
		$editToken = EDIT_TOKEN_SUFFIX;
	}else{
		$editToken = htmlspecialchars( $wgUser->editToken() );
	}
	$article_a = array();
	$article_a["edittoken"] = $editToken;
	$article_a["last_edited"] = $article->getTimestamp();
	$article_a["wikitext"] = $article_content;
	
	//Change JSON encode here
	$json = new Services_JSON();
	return  $json->encode( $article_a ) ;
}
