<?php
$wgHooks['UploadComplete'][] = 'fnCategorizeImage';
$wgHooks['UploadForm:initial'][] = 'fnAddCategoryForm';

function fnAddCategoryForm($uploadFormObj) {
	global $wgRequest, $wgOut;
	
	$uploadFormObj->uploadFormTextAfterSummary .=  "<input type=\"hidden\" name=\"wpCategories\" value=\"" . $wgRequest->getVal("wpCategories") . "\" />";
	
	return $uploadFormObj;
}

function fnCategorizeImage( &$image ){
	global $wgUser, $wgRequest, $wgOut;

	//store current user to restore everything after bot's edit
	$current_user = $wgUser;
	
	//we want these edits to come from the bot, so the user doesn't get double credit for uploading
	$wgUser = User::newFromName( "Mediawiki default" );
	$wgUser->addGroup( 'bot' );
		
	$category_wiki_text = "";
	$categories_array = array();
	
	$categories = $wgRequest->getVal("wpCategories");
	$categories = urldecode($categories);

	//skip if no category is passed
	if( !$categories ){
		//restore user from bot
		$wgUser = $current_user;
		$wgUser->removeGroup("bot");
		wfDebug( __METHOD__.":skipping fnCategorizeImage\n" );
		return false;
	}
	
	//construct Mediawiki objects for the image
	$image_name = $image->mDestName;
	$image_title = Title::makeTitle(NS_IMAGE,$image_name);
	$article = new Article($image_title);
	
	if( !$article->exists() ){
		sleep(3);
	}
	
	//In case there is any previous content in the wiki page, we need to append category tags
	//we also need it to check if the category is already there for some reason
	$article_text_old = $article->getContent();
	
	 
	//Loop through category variable and individually build Category Tab for Wiki text
	$categories_array = explode( "|", $categories );
	foreach($categories_array as $ctg){
		$ctg = trim($ctg);
		$tag = "[[Category:{$ctg}]]";
		if( strpos($article_text_old, $tag) === false ){
			$category_wiki_text .= "\n{$tag}";
		}
	
	}

	//Edit the page with our new content
	$article->doEdit( $article_text_old . "\n" . $category_wiki_text, "Add Categories", EDIT_SUPPRESS_RC & EDIT_UPDATE);
	wfDebug( __METHOD__.": Categorized new image with {$categories} \n" );
	
	//restore user from bot
	$wgUser = $current_user;
	$wgUser->removeGroup("bot");
	
	return true;
	 
}
?>
